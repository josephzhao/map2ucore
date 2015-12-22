<?php

namespace Map2u\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultMethods extends Controller {

    public static function gen_uuid() {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                // 32 bits for "time_low"
                mt_rand(0, 0xffff), mt_rand(0, 0xffff),
                // 16 bits for "time_mid"
                mt_rand(0, 0xffff),
                // 16 bits for "time_hi_and_version",
                // four most significant bits holds version number 4
                mt_rand(0, 0x0fff) | 0x4000,
                // 16 bits, 8 bits for "clk_seq_hi_res",
                // 8 bits for "clk_seq_low",
                // two most significant bits holds zero and one for variant DCE1.1
                mt_rand(0, 0x3fff) | 0x8000,
                // 48 bits for "node"
                mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

    public static function getDatabaseParams($controller) {
        $database_driver = $controller->getParameter("database_driver");
        $database_host = $controller->getParameter("database_host");
        $database_name = $controller->getParameter("database_name");
        $database_user = $controller->getParameter("database_user");
        $database_password = $controller->getParameter("database_password");
        return ['database_driver' => $database_driver, 'database_host' => $database_host, 'database_name' => $database_name, 'database_user' => $database_user, 'database_password' => $database_password];
    }

    public static function setDatabaseTableUUID($controller, $tableName) {
        $conn = $controller->get('database_connection');
        $sql = "SELECT column_name,data_type FROM information_schema.columns WHERE table_name='" . str_replace('-', '_', $tableName) . "' and column_name='id'";

        $stmt = $conn->fetchAll($sql);
        if (count($stmt) === 0) {
            $sql = "ALTER TABLE " . str_replace('-', '_', $tableName) . " ADD id UUID NOT NULL DEFAULT uuid_generate_v4();";

            $result = $conn->query($sql);
        }
    }

    public static function getTableColumns($controller, $tableName) {
        $conn = $controller->get('database_connection');
        $sql = "SELECT column_name,data_type FROM information_schema.columns WHERE table_name='" . str_replace('-', '_', $tableName) . "'";
        $stmt = $conn->fetchAll($sql);
        $rowCount = count($stmt);
        $column_name_array = array();
        $column_name_type_array = array();
        for ($i = $rowCount - 1; $i >= 0; $i--) {
            if ($stmt[$i]['column_name'] === 'the_geom' || $stmt[$i]['column_name'] === 'id' || $stmt[$i]['column_name'] === 'ogc_fid' || $stmt[$i]['column_name'] === 'geom' || $stmt[$i]['column_name'] === 'the_geom4326') {
                unset($stmt[$i]);
            } else {
                array_push($column_name_array, $stmt[$i]['column_name']);
                $temp_array = array();
                $temp_array['column_name'] = $stmt[$i]['column_name'];
                $temp_array['data_type'] = $stmt[$i]['data_type'];

                array_push($column_name_type_array, $temp_array);
            }
        }
        return $column_name_type_array;
    }

    //put your code here
    public static function generateRandomString($length = 20) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function getGeometryType($conn, $tablename, $fieldname) {

        $geo_type = '';
        $sql = "select distinct(ST_GeometryType(" . $fieldname . ")) as type from " . $tablename . " where " . $fieldname . " is not null";
        $stmt = $conn->fetchAll($sql);
        if ($stmt) {
            foreach ($stmt as $type) {
                $geo_type = DefaultMethods::getGeoType($geo_type, $type);
            }
        }
        return $geo_type;
    }

    private static function getGeoType($geo_type, $type) {
        if ($type['type'] !== null && $type['type'] !== 'NULL') {
            if ($geo_type === '') {
                $geo_type = strtoupper(str_replace("ST_", '', $type['type']));
            } else if ("MULTI" . $geo_type === strtoupper(str_replace("ST_", '', $type['type']))) {
                $geo_type = strtoupper(str_replace("ST_", '', $type['type']));
            }
        }
        return $geo_type;
    }

}
