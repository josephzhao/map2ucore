/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



$(function () {
//    alert($('div#create_heatmap div.create_heatmap_from_spatialfile .slider').length);
//    $('div#create_heatmap div.create_heatmap_from_spatialfile .slider').slider();

    $('div#create_heatmap div.create_heatmap_from_spatialfile .loadheatmap_on_map').unbind("click");
    $('div#create_heatmap div.create_heatmap_from_spatialfile .loadheatmap_on_map').click(function () {
        loadSavedHeatmap();
    });

    $('div#create_heatmap div.create_heatmap_from_spatialfile #spatialfile_select_list').change(function () {
        var spatialfile_id = $('div#create_heatmap div.create_heatmap_from_spatialfile #spatialfile_select_list').val();
        $('div#create_heatmap').spin();
        $.post(Routing.generate('spatialfile_columns', {spatialfile_id: spatialfile_id, _locale: window.locale}), function (response) {
            if (document.getElementById('spatialfile_keyfield_list') !== undefined && document.getElementById('spatialfile_keyfield_list') !== null) {
                $('div#create_heatmap div.create_heatmap_from_spatialfile #spatialfile_keyfield_list').empty();
                $('div#create_heatmap div.create_heatmap_from_spatialfile #geometries_select').empty();
                $('div#create_heatmap div.create_heatmap_from_spatialfile #geometries_selected').empty();
                var leaflet_feature_data = response.properties;
                window.heatmap_file_properties = leaflet_feature_data;
                if (response.columns !== null && response.columns !== '' && response.columns !== undefined)
                {
                    for (var i = 0; i < response.columns.length; i++) {
                        if (response.columns[i]['column_name'] !== 'ogc_fid' && response.columns[i]['column_name'] !== 'the_geom' && response.columns[i]['column_name'] !== 'the_geom4326' && response.columns[i]['column_name'] !== 'geom') {
                            var selectBoxOption = document.createElement("option"); //create new option 
                            selectBoxOption.value = response.columns[i]['column_name']; //set option value 
                            selectBoxOption.text = response.columns[i]['column_name']; //set option display text 
                            document.getElementById('spatialfile_keyfield_list').add(selectBoxOption, null); //add created option to select box.
                        }
                    }
                }
                var uploadfile_id = $("div.create_heatmap_from_spatialfile div#initial_data").data("uploadfile-id");
                if (spatialfile_id === uploadfile_id) {

                    var keyfield = $("div.create_heatmap_from_spatialfile div#initial_data").data("keyfield");
                    if (keyfield !== undefined && keyfield !== null && keyfield.trim() !== '') {
                        $('div#create_heatmap div.create_heatmap_from_spatialfile #spatialfile_keyfield_list').val(keyfield);
                    }
                }

                var keyfield = $('div#create_heatmap div.create_heatmap_from_spatialfile #spatialfile_keyfield_list').val();
//                if (leaflet_feature_data !== null && leaflet_feature_data !== undefined)
//                {
//                    for (var i = 0; i < response.data.length; i++) {
//                        var selectBoxOption = document.createElement("option"); //create new option 
//                        selectBoxOption.value = leaflet_feature_data[i].ogc_fid; //set option value 
//                        selectBoxOption.text = leaflet_feature_data[i][labelfield]; //set option display text 
//                        document.getElementById('geometries_select').add(selectBoxOption, null); //add created option to select box.
//                    }
//                }

//                if (parseInt(itemvalue) === parseInt(uploadfile_id)) {
//                    var values = $("div#create_heatmap div.create_heatmap_from_spatialfile div#initial_data").data("values");
//                    if (values !== undefined && values !== null) {
//                        values = values.toString().trim();
//                        var values_array = values.split(",");
//                        $.map(values_array, function (data) {
//                            var select_text = $("div#create_heatmap div.create_heatmap_from_spatialfile select#geometries_select option[value='" + data + "']").text();
//                            $("div#create_heatmap div.create_heatmap_from_spatialfile select#geometries_selected").append("<option value='" + data + "'>" + select_text + "</option.");
//                        });
//                    }
//
//                }

//            if ($("div#create_heatmap div.create_heatmap_from_spatialfile #tradearea_name_id").val() === '')
//            {
//                $("div#create_heatmap div.create_heatmap_from_spatialfile #tradearea_name_id").val($('#spatialfile_keyfield_list option:selected').text());
//            }
            }
            $("div#create_heatmap").spin(false);
        });
    });
    $("div#create_heatmap div.create_heatmap_from_spatialfile button.addgeometrytoselected").click(function (e) {
        e.preventDefault();
        e.stopPropagation();
        $("div#create_heatmap div.create_heatmap_from_spatialfile #geometries_select option:selected").each(function () {
            var bExist = false;
            var item_value = this.value;
            var item_text = this.text;
            $("#create_heatmap .create_heatmap_from_spatialfile #geometries_selected > option").each(function () {

                if (this.value === item_value) {
                    bExist = true;
                }
            });
            if (bExist === false)
            {
                if (document.getElementById('geometries_selected') !== undefined && document.getElementById('geometries_selected') !== null) {
                    var selectBoxOption = document.createElement("option"); //create new option 
                    selectBoxOption.value = item_value; //set option value 
                    selectBoxOption.text = item_text; //set option display text 
                    document.getElementById('geometries_selected').add(selectBoxOption, null);
                }
            }
        });
    });
    $("div#create_heatmap div.create_heatmap_from_spatialfile button.addallgeometrytoselected").click(function (e) {
        e.preventDefault();
        e.stopPropagation();
        $("#create_heatmap .create_heatmap_from_spatialfile #geometries_selected").empty();
        $("div#create_heatmap div.create_heatmap_from_spatialfile #geometries_select option").each(function () {

            if (document.getElementById('geometries_selected') !== undefined && document.getElementById('geometries_selected') !== null) {
                var selectBoxOption = document.createElement("option"); //create new option 
                selectBoxOption.value = this.value; //set option value 
                selectBoxOption.text = this.text; //set option display text 
                document.getElementById('geometries_selected').add(selectBoxOption, null);
            }

        });
    });
    $("div#create_heatmap div.create_heatmap_from_spatialfile button.removegeometryfromselected").click(function (e) {
        e.preventDefault();
        e.stopPropagation();
        $("div#create_heatmap div.create_heatmap_from_spatialfile #geometries_selected option:selected").each(function () {
            $(this).remove();
        });
    });
    $("div#create_heatmap div.create_heatmap_from_spatialfile button.removeallgeometryfromselected").click(function (e) {
        e.preventDefault();
        e.stopPropagation();
        $("div#create_heatmap div.create_heatmap_from_spatialfile #geometries_selected option").each(function () {
            $(this).remove();
        });
    });
    $("div#create_heatmap div.create_heatmap_from_spatialfile button.zoom_to_selected_features").click(function (e) {
        e.preventDefault();
        e.stopPropagation();
        zoomToSelectSearchFeature();
    });
    $("div#create_heatmap div.create_heatmap_from_spatialfile input#geometries_select_filter").keyup(function () {

        var filtervalue = $(this).val();
        if (window.heatmap_file_properties !== undefined && window.heatmap_file_properties !== null && document.getElementById('geometries_select') !== undefined && document.getElementById('geometries_select') !== null) {
            $('div#create_heatmap div.create_heatmap_from_spatialfile #geometries_select').empty();
            var labelfield = $('div#create_heatmap div.create_heatmap_from_spatialfile #spatialfile_keyfield_list').val();
            for (var i = 0; i < window.heatmap_file_properties.length; i++) {
                var selectBoxOption = document.createElement("option"); //create new option 
                if (window.heatmap_file_properties[i].ogc_fid !== null && window.heatmap_file_properties[i].ogc_fid !== undefined) {
                    $('#geometries_select').data('fieldname', 'ogc_fid');
                    selectBoxOption.value = window.heatmap_file_properties[i].ogc_fid; //set option value 
                }
                else {
                    if (window.heatmap_file_properties[i].id !== null && window.heatmap_file_properties[i].id !== undefined) {
                        selectBoxOption.value = window.heatmap_file_properties[i].id;
                        $('#geometries_select').data('fieldname', 'id');
                    }
                    else {
                        selectBoxOption.value = window.heatmap_file_properties[i][labelfield]; //set option value 
                        $('#geometries_select').data('fieldname', labelfield);
                    }
                }

                selectBoxOption.text = window.heatmap_file_properties[i][labelfield]; //set option display text 

                document.getElementById('geometries_select').add(selectBoxOption, null); //add created option to select box.
            }
            $("#geometries_selected option").each(function () {
                $(this).text($("#geometries_select option[value='" + this.value + "']").text());
            });
            if (filtervalue !== undefined && filtervalue.trim() !== '')
            {
                $("#geometries_select option").each(function () {
                    if (this.text.toString().toLowerCase().indexOf(filtervalue.toLowerCase()) === -1)
                    {
                        $(this).remove();
                    }
                });
            }
        }
    });
    $("div#create_heatmap div.create_heatmap_from_spatialfile #geometries_select").dblclick(function (e) {
        e.preventDefault();
        e.stopPropagation();
        var selected_items = $("div#create_heatmap div.create_heatmap_from_spatialfile #geometries_select option:selected").map(function () {
            return $(this).val();
        });
        if (selected_items.length === 0)
            return;
        zoomToSelectSearchFeature(selected_items[0]);
    });
    $("div#create_heatmap div.create_heatmap_from_spatialfile #geometries_selected").dblclick(function (e) {
        e.preventDefault();
        e.stopPropagation();
        var selected_items = $("div#create_heatmap div.create_heatmap_from_spatialfile #geometries_selected option:selected").map(function () {
            return $(this).val();
        });
        if (selected_items.length === 0)
            return;
        zoomToSelectSearchFeature(selected_items[0]);
    });
    function zoomToSelectSearchFeature(item) {

        if (parseInt($('div#create_heatmap div.create_heatmap_from_spatialfile #spatialfile_select_list').val()) === -1) {
            if (window.map.drawnItems.getLayers().length === 0)
            {
                alert("No User draw features loaded!");
                return;
            }

            if (item === undefined) {
                var options = $("div#create_heatmap div.create_heatmap_from_spatialfile #geometries_select option:selected");
                var selected_items = $.map(options, function (option) {
                    return parseInt(option.value);
                });
                var bounds = undefined;
                for (var j = 0; j < window.map.drawnItems.getLayers().length; j++)
                {
                    for (var k = 0; k < selected_items.length; k++)
                    {
                        if (window.map.drawnItems.getLayers()[j].id === parseInt(selected_items[k])) {
                            if (bounds === undefined)
                            {
                                bounds = window.map.drawnItems.getLayers()[j].getBounds();
                            }
                            else {
                                bounds.extend(window.map.drawnItems.getLayers()[j].getBounds());
//                           if(bounds.min.x>map.drawnItems.getLayers()[j].getBounds().min.x) 
//                               bounds.min.x=map.drawnItems.getLayers()[j].getBounds().min.x;
//                           if(bounds.min.y>map.drawnItems.getLayers()[j].getBounds().min.y) 
//                               bounds.min.y=map.drawnItems.getLayers()[j].getBounds().min.y;
//                           if(bounds.max.x<map.drawnItems.getLayers()[j].getBounds().max.x) 
//                               bounds.max.x=map.drawnItems.getLayers()[j].getBounds().max.x;
//                           if(bounds.max.y<map.drawnItems.getLayers()[j].getBounds().max.y) 
//                               bounds.max.y=map.drawnItems.getLayers()[j].getBounds().max.y;

                            }

                        }
                    }
                }
                if (bounds !== undefined)
                {
                    window.map.fitBounds(bounds);
                }
                ;
            }
            else
            {
                for (var j = 0; j < window.map.drawnItems.getLayers().length; j++)
                {
                    if (window.map.drawnItems.getLayers()[j].id === parseInt(item.value)) {
                        var bounds = window.map.drawnItems.getLayers()[j].getBounds();
                        window.map.fitBounds(bounds);
                    }
                }
                ;
            }
            return;
        }
        // end of user draw layer

        var current_layer = null;
        var selected_items = [];
        var selected_feature_items = [];
        d3.selectAll("#svg-leaflet-d3").each(function () {
            var elt = d3.select(this);
            if (elt.attr("filename").toString().toLowerCase() === $.trim($('div#create_heatmap div.create_heatmap_from_spatialfile #spatialfile_select_list option:selected').text().toLowerCase()) && elt.attr("layerType").toString().toLowerCase() === 'uploadfile')
                current_layer = elt;
        });
        if (current_layer === null)
        {
            alert($.trim($('div#create_heatmap div.create_heatmap_from_spatialfile #spatialfile_select_list option:selected').text()) + " map not loaded!");
            return;
        }

        if (item === undefined)
        {

            var options = $("div#create_heatmap div.create_heatmap_from_spatialfile #geometries_select  option:selected");
            var selected_items = $.map(options, function (option) {
                return parseInt(option.value);
            });

            alert(selected_items);
            var bounds;
            current_layer.selectAll("path").each(function (d, i) {

                //       alert(d.properties['ogc_id']+ ";  " + selected_items + ";    " + jQuery.inArray(d.properties['ogc_id'], selected_items));
                if (parseInt(jQuery.inArray(d.properties['ogc_id'], selected_items)) > -1)
                {

                    var bound = d3.geo.bounds(d);
                    if (bounds === undefined)
                        bounds = bound;
                    else {
                        if (bounds[0][0] > bound[0][0])
                            bounds[0][0] = bound[0][0];
                        if (bounds[0][1] > bound[0][1])
                            bounds[0][1] = bound[0][1];
                        if (bounds[1][0] < bound[1][0])
                            bounds[1][0] = bound[1][0];
                        if (bounds[1][1] < bound[1][1])
                            bounds[1][1] = bound[1][1];
                    }

                    selected_feature_items[selected_feature_items.length] = this;
                }
                else {

                }
                //  console.log(this, d, i);
            });
            if (bounds !== undefined)
            {
                window.map.fitBounds([[bounds[0][1], bounds[0][0]], [bounds[1][1], bounds[1][0]]]);
                setTimeout(function () {
                    for (var index = 0; index < selected_feature_items.length; index++) {
                        $(selected_feature_items[index]).css("fill", "#FF0");
                        $(selected_feature_items[index]).css("fill-opacity", "0.90");
                    }
                }, 350);
                return false;
            }
        }
        else
        {
            current_layer.selectAll("path").each(function (d, i) {

                if ($(this).data("fill") !== undefined)
                {
                    $(this).css("fill", $(this).data("fill"));
                }
                if ($(this).data("fill-opacity") !== undefined)
                {
                    $(this).css("fill-opacity", $(this).data("fill-opacity"));
                }
                if (parseInt(d.properties['ogc_id']) === parseInt(item.value))
                {
                    var bound = d3.geo.bounds(d);
                    window.map.fitBounds([[bound[0][1], bound[0][0]], [bound[1][1], bound[1][0]]]);
                    selected_feature_items[selected_feature_items.length] = this;
//                    $.map(selected_feature_items, function (d, index) {
//                        $(selected_feature_items[index]).data("fill", $(selected_feature_items[index]).css("fill"));
//                        $(selected_feature_items[index]).data("fill-opacity", $(selected_feature_items[index]).css("fill-opacity"));
//                        $(selected_feature_items[index]).css("fill", "#FF0");
//                        $(selected_feature_items[index]).css("fill-opacity", "0.5");
//                    });
                    setTimeout(function () {
                        for (var index = 0; index < selected_feature_items.length; index++) {
                            $(selected_feature_items[index]).css("fill", "#FF0");
                            $(selected_feature_items[index]).css("fill-opacity", "0.90");
                        }
                    }, 350);
                    return false;
                }
            });
        }



    }


    $("div#create_heatmap div.create_heatmap_from_spatialfile select#spatialfile_keyfield_list").change(function (e) {
        e.preventDefault();
        e.stopPropagation();
        var itemvalue = this.value;
        $("div#create_heatmap div.create_heatmap_from_spatialfile input#geometries_select_filter").val('');
        if (window.heatmap_file_properties !== undefined && window.heatmap_file_properties !== null && document.getElementById('geometries_select') !== undefined && document.getElementById('geometries_select') !== null) {
            $('div#create_heatmap div.create_heatmap_from_spatialfile #geometries_select').empty();
            var labelfield = $('div#create_heatmap div.create_heatmap_from_spatialfile #spatialfile_keyfield_list').val();
            for (var i = 0; i < window.heatmap_file_properties.length; i++) {
                var selectBoxOption = document.createElement("option"); //create new option 
                if (window.heatmap_file_properties[i].ogc_fid !== null && window.heatmap_file_properties[i].ogc_fid !== undefined) {
                    $('#geometries_select').data('fieldname', 'ogc_fid');
                    selectBoxOption.value = window.heatmap_file_properties[i].ogc_fid; //set option value 
                }
                else {
                    if (window.heatmap_file_properties[i].id !== null && window.heatmap_file_properties[i].id !== undefined) {
                        selectBoxOption.value = window.heatmap_file_properties[i].id;
                        $('#geometries_select').data('fieldname', 'id');
                    }
                    else {
                        selectBoxOption.value = window.heatmap_file_properties[i][labelfield]; //set option value 
                        $('#geometries_select').data('fieldname', labelfield);
                    }
                }

                selectBoxOption.text = window.heatmap_file_properties[i][itemvalue]; //set option display text 
                document.getElementById('geometries_select').add(selectBoxOption, null); //add created option to select box.
            }
            $("#geometries_selected option").each(function () {
                $(this).text($("#geometries_select option[value='" + this.value + "']").text());
            });
        }
    });
    function loadSavedHeatmap() {
        var heatmap_id = $('div#create_heatmap div.create_heatmap_from_spatialfile select#heatmap_select_list').val();
        if (heatmap_id === null) {
            return;
        }
        $.ajax({
            url: Routing.generate('mapping_loadheatmap', {id: heatmap_id, _locale: window.locale}),
            type: 'GET',
            complete: function () {
            },
            success: function (data) {
                if (data.success === true) {
                  
                    window.heatmap_data = data.data;
                    var spatialfile_id = $("div#create_heatmap select#spatialfile_select_list").val();
                    var keyfield = $("div#create_heatmap select#spatialfile_keyfield_list").val();

                    if (window.heatmap_data) {
                        if (window.heatmap_layer)
                            window.heatmap_layer.setData(data.data);
                        else
                            createHeatMapLayer({"data": window.heatmap_data, 'spatialfile_id': spatialfile_id, 'keyfield': keyfield, 'type': 'preview','layerId':data.data['id']});
                    }




                }
                else {
                    alert(data.message);
                }
            },
            cache: false,
            contentType: false,
            processData: true
        });
    }
    $('div#create_heatmap div.create_heatmap_from_spatialfile #spatialfile_select_list').trigger('change');
});


