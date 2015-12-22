
$(function () {


    var fields;
    var sheetNames;
    var field_types;
    var MaxFileSize = 21 * 2014 * 2014;
    var MaxFileSizeMessage = "Max upload file size is limited to 20M";

    var rABS = typeof FileReader !== "undefined" && typeof FileReader.prototype !== "undefined" && typeof FileReader.prototype.readAsBinaryString !== "undefined";

    var X = XLSX;



    $("div.uploadspatialfile_block form#uploadspatialfile_form input#form_spatial_file").change(function (e) {


        var fupload = document.getElementById('form_spatial_file');
        if (fupload)
        {
            var fileNames = fupload.files;
            error_message = '';
            var fileTypes = checkUploadSpatialFilesType(fileNames);
            if (fileTypes.count > 1) {
                alert("There are more than one spatial dataset!\nEvery time only one spatial dataset allowed");
                return;
            }
            if (fileTypes.count === 0) {
                alert("There are no spatial dataset!\nPlease select a valid spatial dataset");
                return;
            }


            var filelist = document.getElementById('form_upload_file_list');
            $('#form_upload_file_list').empty();
            if (filelist && fileNames.length > 0)
            {
                for (var i = 0; i < fileNames.length; i++)
                {
                    if (fileNames[i].size > MaxFileSize)
                    {
                        error_message = error_message + MaxFileSizeMessage + ",\n the file " + fileNames[i].name + " size is " + fileNames[i].size + ",\n";
                    }



                    var ext = fileNames[i].name.substring(fileNames[i].name.lastIndexOf('.') + 1);
                    if (ext !== '' && ext !== undefined)
                    {

                        var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.xls|.xlsx|.csv|.txt|.shp|.shx|.xls|.id|.dat|.prj|.dbf|.map|.ind|.tab|.kml|.mid|.mif|.kmz)$/;

                        if (regex.test(fileNames[i].name.toLowerCase())) {

                            if (typeof (FileReader) !== "undefined") {
                                if (ext.toLowerCase() === 'xls' || ext.toLowerCase() === 'xlsx') {
                                    readExcelFileHeader(fileNames[i]);
                                }
                                if (ext.toLowerCase() === 'txt' || ext.toLowerCase() === 'csv') {
                                    readTextFileHeader(fileNames[i]);
                                }
                            } else {
                                alert("This browser does not support HTML5.");
                            }
                        }
                        else {
                            alert("Please upload a valid spatial data file.");
                        }
                        var selectBoxOption = document.createElement("option"); //create new option 
                        selectBoxOption.value = fileNames[i].name; //set option value 
                        selectBoxOption.text = fileNames[i].name; //set option display text 
                        filelist.add(selectBoxOption, null); //add created option to select box.

                    }
                }
            }
            if (error_message !== '')
            {
                alert(error_message);


            }
        }

        SpatialFileUploadFormValidation();
    });
    $("div.uploadspatialfile_block form#uploadspatialfile_form tbody tr input[type='radio']").unbind('click');
    $("div.uploadspatialfile_block form#uploadspatialfile_form tbody tr input[type='radio']").bind('click', function () {
        $("div.uploadspatialfile_block form#uploadspatialfile_form tbody tr.optional").map(function () {
            $(this).hide();
        });
        $("div.uploadspatialfile_block form#uploadspatialfile_form tbody tr." + $(this).data('type')).map(function () {
            $(this).show();
        });
        SpatialFileUploadFormValidation();
    });
    function checkUploadSpatialFilesType(fileNames) {

        var count = 0;
        var b_xls = false;
        var b_xlsx = false;
        var b_csv = false;
        var b_txt = false;
        var b_shp = false;
        var b_shx = false;

        var b_id = false;
        var b_dat = false;
        var b_prj = false;
        var b_dbf = false;
        var b_map = false;
        var b_ind = false;
        var b_tab = false;
        var b_kml = false;
        var b_mid = false;
        var b_mif = false;
        var b_kmz = false;

        var b_text = false;
        var b_shapefile = false;
        var b_mapinfo = false;
        var b_excel = false;
        var b_kmlfile = false;

        if (fileNames === null || fileNames === undefined || fileNames.length === 0) {
            return null;
        }
        for (var i = 0; i < fileNames.length; i++)
        {
            var ext = fileNames[i].name.substring(fileNames[i].name.lastIndexOf('.') + 1);
            if (ext !== null && ext !== undefined && ext !== '')
            {
                ext = ext.toLowerCase();
                if (ext === 'xls') {
                    b_xls = true;
                }
                if (ext === 'xlsx') {
                    b_xlsx = true;
                }
                if (ext === 'csv') {
                    b_csv = true;
                }
                if (ext === 'txt') {
                    b_txt = true;
                }
                if (ext === 'shp') {
                    b_shp = true;
                }
                if (ext === 'shx') {
                    b_shx = true;
                }
                if (ext === 'id') {
                    b_id = true;
                }
                if (ext === 'dat') {
                    b_dat = true;
                }
                if (ext === 'tab') {
                    b_tab = true;
                }
                if (ext === 'prj') {
                    b_prj = true;
                }
                if (ext === 'dbf') {
                    b_dbf = true;
                }
                if (ext === 'map') {
                    b_map = true;
                }
                if (ext === 'ind') {
                    b_ind = true;
                }
                if (ext === 'kml') {
                    b_kml = true;
                }
                if (ext === 'mid') {
                    b_mid = true;
                }
                if (ext === 'mif') {
                    b_mif = true;
                }
                if (ext === 'kmz') {
                    b_kmz = true;
                }
            }
        }
        if (b_xls === true || b_xlsx === true) {
            b_excel = true;
            count += 1;
        }
        if (b_csv === true || b_txt === true) {
            b_text = true;
            count += 1;
        }
        if ((b_mif === true && b_mid === true) || (b_map === true && b_ind === true && b_dat === true && b_id === true && b_tab === true)) {
            b_mapinfo = true;
            count += 1;
        }
        if (b_kml === true || b_kmz === true) {
            b_kmlfile = true;
            count += 1;
        }
        if ((b_shp === true && b_shx === true && b_prj === true && b_dbf === true)) {
            b_shapefile = true;
            count += 1;
        }
        return {count: count, excel: b_excel, text: b_text, mapinfo: b_mapinfo, kmlfile: b_kmlfile, shapefile: b_shapefile};
    }

    $("div.uploadspatialfile_block form#uploadspatialfile_form a#show-sample-dataformat").unbind();
    $("div.uploadspatialfile_block form#uploadspatialfile_form a#show-sample-dataformat").bind('click', showSampleDataFormat);

    function showSampleDataFormat(e) {
        window.open(Routing.generate('spatialfile_sample_format', {_locale: window.locale}), "Sample data format", "status=0,toolbar=0,location=0,menubar=0,resizable=0,width=650,height=550").focus();
    }
    function readExcelFileHeader(filename) {

        var reader = new FileReader();

        reader.onload = function (e) {

            var data = e.target.result;

            var wb;
            if (rABS) {
                wb = X.read(data, {type: 'binary'});
            } else {
                var arr = fixdata(data);
                wb = X.read(btoa(arr), {type: 'base64'});
            }

            var header = processExcel_wb(wb);
            if (header === null) {
                return;
            }
            sheetNames = header[0];
            fields = header[1];
            field_types = header[2];
            $("div.uploadspatialfile_block form#uploadspatialfile_form tbody tr select[name='spatial_sheetname']").html("");

            $.map(sheetNames, function (data, index) {
                $('div.uploadspatialfile_block form#uploadspatialfile_form tbody tr select[name="spatial_sheetname"]').append($('<option>', {
                    value: index,
                    text: data
                }));
            });
            $('div.uploadspatialfile_block form#uploadspatialfile_form tbody tr select[name="spatial_sheetname"]').change(sheetNamesChanged);
            $('div.uploadspatialfile_block form#uploadspatialfile_form tbody tr select[name="spatial_sheetname"]').trigger('change');

        };
        if (rABS)
            reader.readAsBinaryString(filename);
        else
            reader.readAsArrayBuffer(filename);
    }

    function readTextFileHeader(filename) {
        var reader = new FileReader();
        reader.onload = function (progressEvent) {

            var header = processText_wb(this.result);
            if (header === null) {
                return;
            }
            fields = header[0];
            field_types = header[1];

            $("div.uploadspatialfile_block form#uploadspatialfile_form tbody tr select[name='spatial_loc_name']").html("");
            $('div.uploadspatialfile_block form#uploadspatialfile_form tbody tr select[name="spatial_loc_name"]').append($('<option>', {
                value: -1,
                text: 'Select a Field Name'
            }));
            $("div.uploadspatialfile_block form#uploadspatialfile_form tbody tr select[name='spatial_loc_radius']").html("");
            $('div.uploadspatialfile_block form#uploadspatialfile_form tbody tr select[name="spatial_loc_radius"]').append($('<option>', {
                value: -1,
                text: 'Select a Field Name'
            }));
            $("div.uploadspatialfile_block form#uploadspatialfile_form tbody tr select[name='spatial_loc_pc']").html("");
            $('div.uploadspatialfile_block form#uploadspatialfile_form tbody tr select[name="spatial_loc_pc"]').append($('<option>', {
                value: -1,
                text: 'Select a Field Name'
            }));
            $("div.uploadspatialfile_block form#uploadspatialfile_form tbody tr select[name='spatial_loc_lat']").html("");
            $('div.uploadspatialfile_block form#uploadspatialfile_form tbody tr select[name="spatial_loc_lat"]').append($('<option>', {
                value: -1,
                text: 'Select a Field Name'
            }));
            $("div.uploadspatialfile_block form#uploadspatialfile_form tbody tr select[name='spatial_loc_lon']").html("");
            $('div.uploadspatialfile_block form#uploadspatialfile_form tbody tr select[name="spatial_loc_lon"]').append($('<option>', {
                value: -1,
                text: 'Select a Field Name'
            }));
            $("div.uploadspatialfile_block form#uploadspatialfile_form tbody tr select[name='spatial_loc_value']").html("");
            $('div.uploadspatialfile_block form#uploadspatialfile_form tbody tr select[name="spatial_loc_value"]').append($('<option>', {
                value: -1,
                text: 'Select a Field Name'
            }));
            $("div.uploadspatialfile_block form#uploadspatialfile_form tbody tr select[name='spatial_geographic_id']").html("");
            $('div.uploadspatialfile_block form#uploadspatialfile_form tbody tr select[name="spatial_geographic_id"]').append($('<option>', {
                value: -1,
                text: 'Select a Field Name'
            }));
            if (fields.length > 0) {
                $.map(fields, function (data, index) {
                    $('div.uploadspatialfile_block form#uploadspatialfile_form tbody tr select[name="spatial_loc_name"]').append($('<option>', {
                        value: data,
                        text: data
                    }));
                    $('div.uploadspatialfile_block form#uploadspatialfile_form tbody tr select[name="spatial_geographic_id"]').append($('<option>', {
                        value: data,
                        text: data
                    }));
                    if (field_types[index] !== 'numeric') {
                        $('div.uploadspatialfile_block form#uploadspatialfile_form tbody tr select[name="spatial_loc_pc"]').append($('<option>', {
                            value: data,
                            text: data
                        }));
                    }
                    if (field_types[index] === 'numeric') {

                        $('div.uploadspatialfile_block form#uploadspatialfile_form tbody tr select[name="spatial_loc_radius"]').append($('<option>', {
                            value: data,
                            text: data
                        }));
                        $('div.uploadspatialfile_block form#uploadspatialfile_form tbody tr select[name="spatial_loc_lat"]').append($('<option>', {
                            value: data,
                            text: data
                        }));
                        $('div.uploadspatialfile_block form#uploadspatialfile_form tbody tr select[name="spatial_loc_lon"]').append($('<option>', {
                            value: data,
                            text: data
                        }));
                        $('div.uploadspatialfile_block form#uploadspatialfile_form tbody tr select[name="spatial_loc_value"]').append($('<option>', {
                            value: data,
                            text: data
                        }));
                    }
                });
                SpatialFileUploadFormValidation();
            }
        };
        reader.readAsText(filename);
    }
    function sheetNamesChanged() {
        setSelectOptFields($(this).val());
    }
    function setSelectOptFields(sheetName_index) {

        $("div.uploadspatialfile_block form#uploadspatialfile_form tbody tr select[name='spatial_loc_name']").html("");
        $('div.uploadspatialfile_block form#uploadspatialfile_form tbody tr select[name="spatial_loc_name"]').append($('<option>', {
            value: -1,
            text: 'Select a Field Name'
        }));
        $("div.uploadspatialfile_block form#uploadspatialfile_form tbody tr select[name='spatial_loc_radius']").html("");
        $('div.uploadspatialfile_block form#uploadspatialfile_form tbody tr select[name="spatial_loc_radius"]').append($('<option>', {
            value: -1,
            text: 'Select a Field Name'
        }));
        $("div.uploadspatialfile_block form#uploadspatialfile_form tbody tr select[name='spatial_loc_pc']").html("");
        $('div.uploadspatialfile_block form#uploadspatialfile_form tbody tr select[name="spatial_loc_pc"]').append($('<option>', {
            value: -1,
            text: 'Select a Field Name'
        }));
        $("div.uploadspatialfile_block form#uploadspatialfile_form tbody tr select[name='spatial_loc_lat']").html("");
        $('div.uploadspatialfile_block form#uploadspatialfile_form tbody tr select[name="spatial_loc_lat"]').append($('<option>', {
            value: -1,
            text: 'Select a Field Name'
        }));
        $("div.uploadspatialfile_block form#uploadspatialfile_form tbody tr select[name='spatial_loc_lon']").html("");
        $('div.uploadspatialfile_block form#uploadspatialfile_form tbody tr select[name="spatial_loc_lon"]').append($('<option>', {
            value: -1,
            text: 'Select a Field Name'
        }));
        $("div.uploadspatialfile_block form#uploadspatialfile_form tbody tr select[name='spatial_loc_value']").html("");
        $('div.uploadspatialfile_block form#uploadspatialfile_form tbody tr select[name="spatial_loc_value"]').append($('<option>', {
            value: -1,
            text: 'Select a Field Name'
        }));
        $("div.uploadspatialfile_block form#uploadspatialfile_form tbody tr select[name='spatial_geographic_id']").html("");
        $('div.uploadspatialfile_block form#uploadspatialfile_form tbody tr select[name="spatial_geographic_id"]').append($('<option>', {
            value: -1,
            text: 'Select a Field Name'
        }));


        $.map(fields[sheetName_index], function (data, index) {

            $('div.uploadspatialfile_block form#uploadspatialfile_form tbody tr select[name="spatial_loc_name"]').append($('<option>', {
                value: data,
                text: data
            }));
            $('div.uploadspatialfile_block form#uploadspatialfile_form tbody tr select[name="spatial_loc_pc"]').append($('<option>', {
                value: data,
                text: data
            }));
            $('div.uploadspatialfile_block form#uploadspatialfile_form tbody tr select[name="spatial_geographic_id"]').append($('<option>', {
                value: data,
                text: data
            }));
            if (field_types[sheetName_index][index] === 'numeric') {
                $('div.uploadspatialfile_block form#uploadspatialfile_form tbody tr select[name="spatial_loc_radius"]').append($('<option>', {
                    value: data,
                    text: data
                }));
                $('div.uploadspatialfile_block form#uploadspatialfile_form tbody tr select[name="spatial_loc_lat"]').append($('<option>', {
                    value: data,
                    text: data
                }));
                $('div.uploadspatialfile_block form#uploadspatialfile_form tbody tr select[name="spatial_loc_lon"]').append($('<option>', {
                    value: data,
                    text: data
                }));
                $('div.uploadspatialfile_block form#uploadspatialfile_form tbody tr select[name="spatial_loc_value"]').append($('<option>', {
                    value: data,
                    text: data
                }));
            }
        });
        SpatialFileUploadFormValidation();

    }

    function SpatialFileUploadFormValidation(be_alert) {

        var formvalidated = true;
        var fupload = document.getElementById('form_spatial_file');
        if (fupload && fupload.files.length > 0) {
            var type = $("div.uploadspatialfile_block form#uploadspatialfile_form tbody tr input[type='radio']:checked").data('type');
            var tab_name = $('div.uploadspatialfile_block form#uploadspatialfile_form tbody tr select[name="spatial_sheetname"]').val();
            var loc_name = $('div.uploadspatialfile_block form#uploadspatialfile_form tbody tr select[name="spatial_loc_name"]').val();
            var loc_geographic_id = $('div.uploadspatialfile_block form#uploadspatialfile_form tbody tr select[name="spatial_geographic_id"]').val();
            var loc_geographic_level = $('div.uploadspatialfile_block form#uploadspatialfile_form tbody tr select[name="spatial_geographic_level"]').val();
            var loc_radius = $('div.uploadspatialfile_block form#uploadspatialfile_form tbody tr select[name="spatial_loc_radius"]').val();
            var loc_pc = $('div.uploadspatialfile_block form#uploadspatialfile_form tbody tr select[name="spatial_loc_pc"]').val();
            var loc_lat = $('div.uploadspatialfile_block form#uploadspatialfile_form tbody tr select[name="spatial_loc_lat"]').val();
            var loc_lon = $('div.uploadspatialfile_block form#uploadspatialfile_form tbody tr select[name="spatial_loc_lon"]').val();
            var loc_value = $('div.uploadspatialfile_block form#uploadspatialfile_form tbody tr select[name="spatial_loc_value"]').val();
            if (tab_name === '') {
                return false;
            }
            switch (type) {
                case 'tradearea':
                    if (loc_name === '-1' || loc_radius === '-1' || (loc_pc === '-1' && (loc_lat === '-1' || loc_lon === '-1')))
                    {

                        formvalidated = false;
                    }


                    break;
                case 'customer':
                    if (loc_value === '-1' || (loc_pc === '-1' && (loc_lat === '-1' || loc_lon === '-1')))
                    {

                        formvalidated = false;
                    }
                    break;
                case 'poi':
                    if (loc_name === '-1' || (loc_pc === '-1' && (loc_lat === '-1' || loc_lon === '-1')))
                    {

                        formvalidated = false;
                    }

                    break;
                case 'maps':
                    if (loc_value === '-1' || loc_geographic_id === '-1' || loc_geographic_level === -1)
                    {

                        formvalidated = false;
                    }

                    break;
                default:
                    return false;
            }
        }
        else {
            formvalidated = false;
            if (be_alert === true) {
                alert("No upload file selected!\nPlease select upload file");
            }
        }
        return formvalidated;

    }

    $('div.uploadspatialfile_block form#uploadspatialfile_form button#form_submit_button_id').unbind("click");
    $('div.uploadspatialfile_block form#uploadspatialfile_form button#form_submit_button_id').click(function () {
        // if (SpatialFileUploadFormValidation(true)) {
        if ($('div.uploadspatialfile_block form#uploadspatialfile_form').length)
        {
            //   $('div#main_modal_dialogpanel').spin();
            var formData = new FormData($('div.uploadspatialfile_block form#uploadspatialfile_form')[0]);
            formData.append('spatial_sheetnames', JSON.stringify(sheetNames));
            $.ajax({
                url: Routing.generate('spatialfile_upload', {_locale: window.locale}),
                type: 'POST',
                complete: function () {
                    //  $('div#main_modal_dialogpanel').spin(false);

                },
                success: function (data) {
                    var result;
                    if (typeof data === 'string') {
                        result = JSON.parse(data);
                    }
                    else {
                        result = data;
                    }
                    alert(result.message);
                    if (result.success === true)
                    {
                    }
                },
                data: formData,
                cache: false,
                contentType: false,
                processData: false
            });
        }
        //}
    });
    $("div.uploadspatialfile_block form#uploadspatialfile_form tbody tr select").change(function () {
        SpatialFileUploadFormValidation();
    });

    $("div.uploadspatialfile_block form#uploadspatialfile_form tbody tr input[type='radio']:checked").trigger('click');


    function setProgress(e)
    {

        if (e.lengthComputable) {
            var progress = e.loaded / e.total;
            var progressBarWidth = progress * $(".sonata-bc").width();
            $(".progressbar").width(progressBarWidth).html(Math.round(progress * 100) + "% ");
        }
    }


    function fixdata(data) {
        var o = "", l = 0, w = 10240;
        for (; l < data.byteLength / w; ++l)
            o += String.fromCharCode.apply(null, new Uint8Array(data.slice(l * w, l * w + w)));
        o += String.fromCharCode.apply(null, new Uint8Array(data.slice(l * w)));
        return o;
    }




    function excelToCsv(workbook) {
        var header = [];
        var data = [];
        var sheetNames = [];
        workbook.SheetNames.forEach(function (sheetName) {
            sheetNames.push(sheetName);
            var jsons = X.utils.sheet_to_json(workbook.Sheets[sheetName]);

            if (jsons.length > 0) {
                data.push(jsons);
                header.push(Object.keys(jsons[0]));
            }
            else {
                data.push([]);
                header.push([]);
            }

        });
        return [sheetNames, header, data];
    }
    function processExcel_wb(wb) {
        var output = excelToCsv(wb);
        var sheetNames = output[0];
        var fields = output[1];
        var data = output[2];

        var field_types = [];

        for (var k = 0; k < sheetNames.length; k++) {
            field_types[k] = [];

            for (var i = 0; i < fields[k].length; i++) {
                field_types[k][i] = "numeric";
            }

            for (var i = 0; i < data[k].length; i++) {
                var datum = data[k][i];
                for (var j = 0; j < fields[k].length; j++) {
                    if (datum[fields[k][j]] !== undefined && datum[fields[k][j]].trim() !== '' && datum[fields[k][j]].trim() !== null) {
                        if ($.isNumeric(datum[fields[k][j]].replace(/[$,\,]/g, '').trim()) === false) {
                            if (fields[j] === 'index_tr') {
                                alert(datum[fields[k][j]]);
                            }
                            field_types[k][j] = 'varchar';
                        }
                    }
                }
            }
        }
        return [sheetNames, fields, field_types];
    }


    function processText_wb(wb) {

        var fields = [];
        var field_types = [];
        var declimer = '';
        // By lines
        var lines = wb.split('\n');
        for (var i = 0; i < lines.length; i++) {
            if (i === 0) {
                if (lines[0].indexOf(",") !== -1) {
                    fields = lines[0].split(",");
                    declimer = ',';
                } else if (lines[0].indexOf("\t") !== -1) {
                    fields = lines[0].split("\t");
                    declimer = '\t';
                }
                else if (lines[0].indexOf(";") !== -1) {
                    fields = lines[0].split(";");
                    declimer = ';';
                }
                if (fields.length === 0) {
                    return null;
                }
                for (var j = 0; j < fields.length; j++) {
                    field_types[j] = 'numeric';
                }
            }
            else {
                var values = lines[i].split(declimer);
                for (var j = 0; j < values.length; j++) {
                    if (values[j].trim() !== '' && $.isNumeric(values[j].trim()) === false) {
                        field_types[j] = 'varchar';
                    }
                }
            }

        }
        return [fields, field_types];
    }
});