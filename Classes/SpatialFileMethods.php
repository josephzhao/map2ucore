<?php

namespace Map2u\CoreBundle\Classes;

use Map2u\CoreBundle\Model\SpatialFileInterface;
use PHPExcel_IOFactory;

class SpatialFileMethods {

    private $databaseName = '';
    private $sourceFileName = '';
    private $driveType = ['shapefile' => '', 'mapinfo' => ''];
    private $dir = '';

    public static function getSpatialFileType($files) {

        $filetype = 'shapefile';
        $sheetnames = '';
        $bMapinfofile = false;
        $bKmlfile = false;
        $bTextfile = false;
        $bExcelfile = false;
        list($bShapefile, $spatialfileName) = SpatialFileMethods::isShapefile($files);

        if ($bShapefile === true) {
            return [$filetype, $spatialfileName, $sheetnames];
        }
        $filetype = 'mapinfo';
        list($bMapinfofile, $spatialfileName) = SpatialFileMethods::isMapinfofile($files);

        if ($bMapinfofile === true) {

            return [$filetype, $spatialfileName, $sheetnames];
        }

        $filetype = 'kml';
        list($bKmlfile, $spatialfileName) = SpatialFileMethods::isKmlfile($files);
        if ($bKmlfile === true) {
            return [$filetype, $spatialfileName, $sheetnames];
        }
        $filetype = 'text';
        list($bTextfile, $spatialfileName) = SpatialFileMethods::isTextfile($files);
        if ($bTextfile === true) {
            return [$filetype, $spatialfileName, $sheetnames];
        }
        $filetype = 'excel';
        list($bExcelfile, $spatialfileName, $sheetnames) = SpatialFileMethods::isExcelfile($files);

        return [$filetype, $spatialfileName, $sheetnames];
    }

    public static function saveSpatialFile($dir, $files, $bexcel = false) {
        $filenames = array();
        if ($files === null) {
            return $filenames;
        }
        if (is_array($files)) {
            foreach ($files as $file) {
                if ($bexcel === true) {
                    copy($file->getPathname(), $dir . '/' . str_replace(' ', '-', trim($file->getClientOriginalName())));
                } else {
                    $file->move($dir, str_replace(' ', '-', trim($file->getClientOriginalName())));
                }
                array_push($filenames, str_replace(' ', '-', trim($file->getClientOriginalName())));
            }
        } else {
            if ($bexcel === true) {
                copy($files->getPathname(), $dir . '/' . str_replace(' ', '-', trim($files->getClientOriginalName())));
            } else {
                $files->move($dir, str_replace(' ', '-', trim($files->getClientOriginalName())));
            }
            array_push($filenames, str_replace(' ', '-', trim($files->getClientOriginalName())));
        }
        return $filenames;
    }

    public static function ogr2ogrToDatabase($dir, SpatialFileInterface $spatialfile, $dbparams) {

        if (file_exists($dir) === false) {
            shell_exec('mkdir -p ' . $dir);
        }
        $ogrstr = 'ogr2ogr -overwrite -skipfailures -unsetFieldWidth -f "PostgreSQL" PG:"host=127.0.0.1 user=' . $dbparams['database_user'] . ' dbname=' . $dbparams['database_name'] . ' password=' . $dbparams['database_password'] . '" -nlt GEOMETRY -t_srs EPSG:4326  -lco GEOMETRY_NAME=the_geom -lco PRECISION=NO  -lco "OVERWRITE=YES" -nln spatial_' . str_replace('-', '_', $spatialfile->getId()) . ' ' . $dir . '/' . $spatialfile->getFileName() . ' 2>&1';

        $output = shell_exec($ogrstr);

        return $output;
    }

    public static function textToDatabase($conn, $dir, SpatialFileInterface $spatialfile) {
        $textData = SpatialFileMethods::getTextData($dir, $spatialfile);
        $field_names = SpatialFileMethods::checkTextDataFields($textData);
        $result = SpatialFileMethods::createSpatialfileTable($dir, $spatialfile, $field_names, $conn, 'spatial_' . str_replace('-', '_', $spatialfile->getId()));
        if ($result) {
            $spatialfile->setFieldList(serialize($field_names));
            $rowCount = SpatialFileMethods::insertTextDataToTable($textData, $field_names, $conn, 'spatial_' . str_replace('-', '_', $spatialfile->getId()));
            if ($rowCount === 0) {
                return null;
            }
        }
        return $field_names;
    }

    public static function excelToDatabase($conn, $dir, SpatialFileInterface $spatialfile, $sheetname) {
        $excelData = SpatialFileMethods::getExcelData($dir, $spatialfile, $sheetname);
        $field_names = SpatialFileMethods::checkExcelDataFields($excelData);
        $result = SpatialFileMethods::createSpatialfileTable($dir, $spatialfile, $field_names, $conn, 'spatial_' . str_replace('-', '_', $spatialfile->getId()));
        if ($result === true) {
            $spatialfile->setFieldList(serialize($field_names));
            $rowCount = SpatialFileMethods::insertExcelDataToTable($excelData, $field_names, $conn, 'spatial_' . str_replace('-', '_', $spatialfile->getId()));
            if ($rowCount === 0) {
                return null;
            }
        }
        return $field_names;
    }

    private static function getExcelData($dir, SpatialFileInterface $spatialfile, $sheetname) {
        $excelfilename = $dir . '/' . $spatialfile->getFileName();
        $inputFileType = PHPExcel_IOFactory::identify($excelfilename);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($excelfilename);

        $sheet = $objPHPExcel->getSheetByName($sheetname);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        $data = array();

        //  Loop through each row of the worksheet in turn
        for ($row = 1; $row <= $highestRow; $row++) {
            //  Read a row of data into an array
            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
            $bOK = false;
            foreach ($rowData as $each_data) {
                if (is_array($each_data)) {
                    foreach ($each_data as $eachone) {
                        if (strlen(trim($eachone)) > 0) {
                            $bOK = true;
                        }
                    }
                } else if (strlen(trim($each_data)) > 0) {
                    $bOK = true;
                }
            }
            if ($bOK === true) {
                $data[] = $rowData;
            }
        }
        return $data;
    }

    public static function checkExcelDataFields($excelData) {
        $i = 0;
        $field_names = array();
        foreach ($excelData as $data) {

            if ($i == 0) {
                $field_names = SpatialFileMethods::checkExcelDataFieldNames($data[0]);
            } else {
                $field_names = SpatialFileMethods::checkExcelDataEachRowType($data[0], $field_names);
            }
            $i = $i + 1;
        }
        return $field_names;
    }

    public static function checkExcelDataFieldNames($rowdata) {
        $i = 0;
        $field_names = array();
        foreach ($rowdata as $field) {
            $field_names[$i] = array();
            $field1 = str_replace("%", "per", strtolower(trim($field)));
            $field2 = str_replace("#", "num", strtolower(trim($field1)));
            $field3 = str_replace(".", "_", strtolower(trim($field2)));
            $field_names[$i]['column_name'] = str_replace(" ", "_", strtolower(trim($field3)));
            $field_names[$i]['data_type'] = "numeric";
            $i +=1;
        }
        return $field_names;
    }

    public static function checkExcelDataEachRowType($rowdata, $field_names) {
        $i = 0;
        foreach ($rowdata as $field) {
            if ($field !== null && strlen(trim($field)) > 0 && !is_numeric(trim($field))) {
                $field_names[$i]['data_type'] = "VARCHAR";
            }
            $i +=1;
        }
        return $field_names;
    }

    private static function createSpatialfileTable($dir, SpatialFileInterface $spatialfile, $field_names, $conn, $shpTablename) {
        $conn->query("DROP TABLE IF EXISTS $shpTablename");
        if (count($field_names) === 0) {
            if (file_exists($dir)) {
                shell_exec("rm -rf " . $dir);
            }
            $deletesql = "delete from map2u_core__spatial_file where id='" . $spatialfile->getId() . "'";
            $result = $conn->query($deletesql);
            return false;
        }
        if (is_array($field_names) && isset($field_names[0]['column_name'])) {
            $str = implode(",", array_map(function($data) {
                        return $data['column_name'] . ' ' . $data['data_type'];
                    }, $field_names));
        } else {
            $str = $field_names['column_name'] . ' ' . $field_names['data_type'];
        }
        $sql = "CREATE TABLE $shpTablename (id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),ogc_fid integer, $str );";
        $conn->query($sql);
        $sql = "SELECT AddGeometryColumn('" . $shpTablename . "','the_geom',4326, 'GEOMETRY', 2)";
        $conn->query($sql);
        return true;
    }

    private static function insertTextDataToTable($textData, $field_names, $conn, $shpTablename) {
        $str = implode(",", array_map(function($data) {
                    return $data['column_name'];
                }, $field_names));
        $i = 0;
        $count = 0;
        foreach ($textData as $row_data) {
            if ($i > 0) {
                try {
                    $sql = "insert into " . $shpTablename . " (" . $str . ") values(";
                    $sql = $sql . SpatialFileMethods::getTextRowdataValues($field_names, $row_data);
                    $sql = $sql . ")";
                    $conn->query($sql);
                    $count +=1;
                } catch (Doctrine\DBAL\DBALException $e) {
                    
                }
            }
            $i +=1;
        }
        return $count;
    }

    private static function getTextRowdataValues($field_names, $row_data) {

        return implode(",", array_map(function($data, $field_name) {
                    if ($field_name['data_type'] === 'numeric') {
                        return $data;
                    } else {
                        $data_raw = trim(preg_replace('/\xc2\xa0/', '', $data));
                        return "'" . $data_raw . "'";
                    }
                }, $row_data, $field_names));
    }

    private static function insertExcelDataToTable($excelData, $field_names, $conn, $shpTablename) {
        $str = implode(",", array_map(function($data) {
                    return $data['column_name'];
                }, $field_names));
        $i = 0;
        $count = 0;
        foreach ($excelData as $row_data) {
            if ($i > 0) {
                try {
                    $sql = "insert into " . $shpTablename . " (" . $str . ") values(";
                    $sql = $sql . SpatialFileMethods::getExcelRowdataValues($field_names, $row_data[0]);
                    $sql = $sql . ")";
                    $conn->query($sql);
                    $count +=1;
                } catch (Doctrine\DBAL\DBALException $e) {
                    
                }
            }
            $i +=1;
        }
        return $count;
    }

    private static function getExcelRowdataValues($field_names, $row_data) {

        return implode(",", array_map(function($data, $field_name) {

                    if ($field_name['data_type'] === 'numeric') {
                        if (strlen(trim($data)) === 0) {
                            return 'NULL';
                        } else
                            return trim($data);
                    } else {
                        $data_raw = trim(preg_replace('/\xc2\xa0/', '', $data));
                        return "'" . $data_raw . "'";
                    }
                }, $row_data, $field_names));
    }

    public static function getTextData($dir, SpatialFileInterface $spatialfile) {
        $textfilename = $dir . '/' . $spatialfile->getFileName();

        $data = array();
        $handle = fopen($textfilename, "r");
        $i = 0;

        if (!$handle) {
            return $data;
        }

        while (($line = fgets($handle)) !== false) {
            // process the line read.
            $line_data = str_replace('\r\n', '', $line);

            if ($i === 0) {
                $delimiter = SpatialFileMethods::getDelimiter($line_data);
            }
            if ($delimiter === '') {
                return $data;
            }
            $i = $i + 1;
            $rowData = explode($delimiter, $line_data);

            $bOK = false;
            foreach ($rowData as $each_data) {
                if (strlen(trim($each_data)) > 0) {
                    $bOK = true;
                }
            }
            if ($bOK === true) {
                $data[] = $rowData;
            }
        }
        fclose($handle);
        return $data;
    }

    public static function getDelimiter($line_data) {
        $delimiter = '';
        if (strpos($line_data, ',')) {

            $delimiter = ',';
        } elseif (strpos($line_data, '\t')) {

            $delimiter = '\t';
        } elseif (strpos($line_data, ';')) {

            $delimiter = ';';
        }
        return $delimiter;
    }

    public static function checkTextDataFields($textData) {
        $i = 0;
        $field_names = array();
        foreach ($textData as $data) {

            if ($i == 0) {
                $field_names = SpatialFileMethods::checkTextDataFieldNames($data);
            } else {
                $field_names = SpatialFileMethods::checkTextDataEachRowType($data, $field_names);
            }
            $i = $i + 1;
        }
        return $field_names;
    }

    public static function checkTextDataFieldNames($rowdata) {
        $i = 0;
        $field_names = $field_types = array();
        foreach ($rowdata as $field) {
            $field_names[$i] = array();
            $field1 = str_replace("%", "per", strtolower(trim($field)));
            $field2 = str_replace("#", "num", strtolower(trim($field1)));
            $field3 = str_replace(".", "_", strtolower(trim($field2)));
            $field_names[$i]['column_name'] = str_replace(" ", "_", strtolower(trim($field3)));
            $field_names[$i]['data_type'] = "numeric";
            $i +=1;
        }
        return $field_names;
    }

    public static function checkTextDataEachRowType($rowdata, $field_names) {
        $i = 0;
        foreach ($rowdata as $field) {
            if (!is_numeric(trim($field))) {
                $field_names[$i]['data_type'] = "VARCHAR";
            }
            $i +=1;
        }
        return $field_names;
    }

    public static function ogr2ogrDatabaseToGeoJSON($dir, SpatialFileInterface $spatialfile, $dbparams, $geo_type) {
        $columns = unserialize($spatialfile->getFieldList());
        $column_name_array = array();
        array_push($column_name_array, 'id');
        foreach ($columns as $column) {
            array_push($column_name_array, $column['column_name']);
        }
        $filename = 'spatial_' . str_replace('-', '_', $spatialfile->getId());

        $column_names = implode(',', $column_name_array);
        $geom_column = "the_geom";
        // delete existing geojson file, ogr2ogr not update or auto overwrite geojson file
        if (file_exists($dir . '/' . $filename . '.geojson')) {
            shell_exec("rm -rf " . $dir . '/' . $filename . '.geojson');
        }


        $sql2shapefile = 'ogr2ogr -overwrite -unsetFieldWidth -f "GeoJSON" ' . $dir . '/' . $filename . '.geojson PG:"host=127.0.0.1 user=' . $dbparams['database_user'] . ' dbname=' . $dbparams['database_name'] . ' password=' . $dbparams['database_password'] . '" -nlt ' . $geo_type . ' -sql "SELECT ' . $column_names . ',' . $geom_column . ' as the_geom FROM ' . $filename . '" 2>&1';


        $ogr2ogr_output = shell_exec($sql2shapefile);

        if ($ogr2ogr_output !== null) {
            return $ogr2ogr_output;
        }
        $topojsonfile = 'topojson -p -o ' . $dir . '/' . $filename . '.topojson  ' . $dir . '/' . $filename . '.geojson  2>&1';


        $output = shell_exec($topojsonfile);

        $zipfile = "zip -r " . $dir . '/' . $filename . '.zip  ' . $dir . '/' . $filename . '.topojson   2>&1';

        $output = shell_exec($zipfile);

        return $output;
    }

    public static function ogr2ogrJsonToTopojson($conn, $dir, SpatialFileInterface $spatialfile) {
        
    }

    private static function isShapefile($files) {
        $shp_file = 0;
        $spatialfileName = '';
        if (!is_array($files)) {
            return [false, ''];
        }
        foreach ($files as $file) {
            $filename = $file->getClientOriginalName();
            if (strtolower(substr($filename, strlen($filename) - 4)) === '.shp') {
                $shp_file += 1;
                $spatialfileName = str_replace(' ', '-', trim($filename));
            }
            if (strtolower(substr($filename, strlen($filename) - 4)) === '.dbf') {
                $shp_file += 1;
            }
            if (strtolower(substr($filename, strlen($filename) - 4)) === '.shx') {
                $shp_file += 1;
            }
            if (strtolower(substr($filename, strlen($filename) - 4)) === '.prj') {
                $shp_file += 1;
            }
        }
        return [$shp_file === 4, $spatialfileName];
    }

    private static function isMapinfofile($files) {
        $tab_file = 0;
        $mid_file = 0;
        $tabfile = null;
        $midfile = null;
        // if not array, not a mapinfo files
        if (!is_array($files)) {
            return [false, ''];
        }
        foreach ($files as $file) {
            $filename = $file->getClientOriginalName();

            if (strtolower(substr($filename, strlen($filename) - 4)) === '.mif') {
                $mid_file += 1;
            }
            if (strtolower(substr($filename, strlen($filename) - 3)) === '.id') {
                $tab_file += 1;
            }
            if (strtolower(substr($filename, strlen($filename) - 4)) === '.dat') {
                $tab_file += 1;
            }
            if (strtolower(substr($filename, strlen($filename) - 4)) === '.mid') {
                $mid_file += 1;
                $midfile = $file;
            }
            if (strtolower(substr($filename, strlen($filename) - 4)) === '.tab') {
                $tab_file += 1;
                $tabfile = $file;
            }
            if (strtolower(substr($filename, strlen($filename) - 4)) === '.map') {
                $tab_file += 1;
            }
        }
        if ($tab_file === 4 && $tabfile !== null) {
            return [true, str_replace(' ', '-', trim($tabfile->getClientOriginalName()))];
        } else {
            if ($mid_file === 2 && $midfile !== null) {
                return [true, str_replace(' ', '-', trim($midfile->getClientOriginalName()))];
            }
        }
        return [false, ''];
    }

    private static function isKmlfile($files) {
        $kmlfile = null;
        if (!is_array($files)) {
            $filename = $files->getClientOriginalName();
            if (strtolower(substr($filename, strlen($filename) - 4)) === '.kml') {
                $kmlfile = $files;
            }
            if (strtolower(substr($filename, strlen($filename) - 4)) === '.kmz') {
                $kmlfile = $files;
            }
            if ($kmlfile !== null) {
                return [true, str_replace(' ', '-', trim($kmlfile->getClientOriginalName()))];
            }
            return [false, ''];
        }
        foreach ($files as $file) {
            $filename = $file->getClientOriginalName();
            if (strtolower(substr($filename, strlen($filename) - 4)) === '.kml') {
                $kmlfile = $file;
            }
            if (strtolower(substr($filename, strlen($filename) - 4)) === '.kmz') {
                $kmlfile = $file;
            }
        }

        if ($kmlfile !== null) {
            return [true, str_replace(' ', '-', trim($kmlfile->getClientOriginalName()))];
        }
        return [false, ''];
    }

    private static function isTextfile($files) {
        $textfile = null;
        if (!is_array($files)) {
            $filename = $files->getClientOriginalName();
            if (strtolower(substr($filename, strlen($filename) - 4)) === '.txt') {
                $textfile = $files;
            }
            if (strtolower(substr($filename, strlen($filename) - 4)) === '.csv') {
                $textfile = $files;
            }
            if ($textfile !== null) {
                return [true, str_replace(' ', '-', trim($textfile->getClientOriginalName()))];
            }
            return [false, ''];
        }
        foreach ($files as $file) {
            $filename = $file->getClientOriginalName();
            if (strtolower(substr($filename, strlen($filename) - 4)) === '.txt') {
                $textfile = $file;
            }
            if (strtolower(substr($filename, strlen($filename) - 4)) === '.csv') {
                $textfile = $file;
            }
        }
        if ($textfile !== null) {
            return [true, str_replace(' ', '-', trim($textfile->getClientOriginalName()))];
        }
        return [false, ''];
    }

    private static function isExcelfile($files) {

        $excelfile = null;
        if (!is_array($files)) {
            $filename = $files->getClientOriginalName();
            if (strtolower(substr($filename, strlen($filename) - 4)) === '.xls') {
                $excelfile = $files;
            }
            if (strtolower(substr($filename, strlen($filename) - 5)) === '.xlsx') {
                $excelfile = $files;
            }
            if ($excelfile !== null) {
                $fullfilename = $excelfile->getPathname();
                $inputFileType = PHPExcel_IOFactory::identify($fullfilename);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($fullfilename);
                $sheetnames = $objPHPExcel->getSheetNames();
                return [true, str_replace(' ', '-', trim($excelfile->getClientOriginalName())), $sheetnames];
            }
            return [false, ''];
        }
        foreach ($files as $file) {
            $filename = $file->getClientOriginalName();
            if (strtolower(substr($filename, strlen($filename) - 4)) === '.xls') {
                $excelfile = $file;
            }
            if (strtolower(substr($filename, strlen($filename) - 5)) === '.xlsx') {
                $excelfile = $file;
            }
        }
        if ($excelfile !== null) {
            $fullfilename = $excelfile->getPathname();
            $inputFileType = PHPExcel_IOFactory::identify($fullfilename);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($fullfilename);
            $sheetnames = $objPHPExcel->getSheetNames();
            return [true, str_replace(' ', '-', trim($excelfile->getClientOriginalName())), $sheetnames];
        }
        return [false, ''];
    }

    public static function getDatabaseParams($container) {
        $database_driver = $container->getParameter("database_driver");
        $database_host = $container->getParameter("database_host");
        $database_name = $container->getParameter("database_name");
        $database_user = $container->getParameter("database_user");
        $database_password = $container->getParameter("database_password");
        return ['database_driver' => $database_driver, 'database_host' => $database_host, 'database_name' => $database_name, 'database_user' => $database_user, 'database_password' => $database_password];
    }

    public static function updateTableGeommetry($params, $conn, $shpTablename) {
        $sql = null;
        if (intval($params['spatial_typeid']) === 5) {

            switch ($params['spatial_geographic_level']) {
                case '0':
                    $sql = "update " . $shpTablename . " a set  the_geom=b.pt_geom from tab_geo_ca b where replace(trim(upper(a." . $params['spatial_geographic_id'] . ")),' ','')=b.postcode";

                    break;
                case '1':
                    $sql = "update " . $shpTablename . " a set  the_geom=b.pt_geom from tab_geo_ca b where replace(trim(upper(a." . $params['spatial_geographic_id'] . ")),' ','')=b.postcode";

                    break;
                case '2':
                    $sql = "update " . $shpTablename . " a set  the_geom=b.pt_geom from tab_geo_ca b where replace(trim(upper(a." . $params['spatial_geographic_id'] . ")),' ','')=b.postcode";

                    break;
                case '3':
                    $sql = "update " . $shpTablename . " a set  the_geom=b.pt_geom from tab_geo_ca b where replace(trim(upper(a." . $params['spatial_geographic_id'] . ")),' ','')=b.postcode";

                    break;
                case '4':
                    $sql = "update " . $shpTablename . " a set  the_geom=b.the_geom from fsa_geoms b where replace(trim(upper(a." . $params['spatial_geographic_id'] . ")),' ','')=b.fsa";

                    break;
                case '5':
                    $sql = "update " . $shpTablename . " a set  the_geom=b.pt_geom from tab_geo_ca b where replace(trim(upper(a." . $params['spatial_geographic_id'] . ")),' ','')=b.postcode";

                    break;
                case '6':
                    $sql = "update " . $shpTablename . " a set  the_geom=b.pt_geom from tab_geo_ca b where replace(trim(upper(a." . $params['spatial_geographic_id'] . ")),' ','')=b.postcode";

                    break;
                case '7':
                    $sql = "update " . $shpTablename . " a set  the_geom=b.pt_geom from tab_geo_ca b where replace(trim(upper(a." . $params['spatial_geographic_id'] . ")),' ','')=b.postcode";

                    break;
                default:
                    $sql = "update " . $shpTablename . " a set  the_geom=b.the_geom from tab_geo_ca b where replace(trim(upper(a." . $params['spatial_geographic_id'] . ")),' ','')=b.postcode";
                    break;
            }
            $noupdatesql = "select " . strtolower($params['spatial_geographic_id']) . " from " . $shpTablename . " where the_geom is null";
        } else {
            if (intval($params['spatial_loc_pc']) !== -1) {
                $sql = "update " . $shpTablename . " a set  the_geom=b.pt_geom from tab_geo_ca b where replace(trim(upper(a." . $params['spatial_loc_pc'] . ")),' ','')=b.postcode";

                $noupdatesql = "select " . $params['spatial_loc_pc'] . " from " . $shpTablename . " where the_geom is null";
            } else {
                if (intval($params['spatial_loc_lon']) !== -1 && intval($params['spatial_loc_lat']) !== -1) {
                    $sql = "update " . $shpTablename . " set  the_geom=ST_GeomFromText('POINT('+convert(varchar(20)," . $params['spatial_loc_lon'] . ")+ ' '+ " . "+convert(varchar(20)," . $params['spatial_loc_lat'] . "))', 4326)";
                    $noupdatesql = "select " . $params['spatial_loc_lon'] . "," . $params['spatial_loc_lat'] . " from " . $shpTablename . " where the_geom is null";
                }
            }
        }
        if ($sql === null) {
            return [0, 'No spatial info updated!'];
        }
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt_result = $stmt->fetchAll();
        $rowCount = count($stmt_result);

        $noupdatestmt = $conn->prepare($noupdatesql);
        $noupdatestmt->execute();
        $noupdatestmt_result = $noupdatestmt->fetchAll();

        return [$rowCount, $noupdatestmt_result];
    }

}
