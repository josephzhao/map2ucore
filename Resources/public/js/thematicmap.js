/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


(function(window, document) {

    saveToThematicMapList = function() {
        var datasource = $("#thematicmap select#thematicmap_datasource").val();
        var fieldname = $("#thematicmap select#thematicmap_datafieldname").val();
        var gradient = $("#thematicmap div#thematicmap_gradient input[type=radio]:checked").attr('data');
        var min = $("#thematicmap input#category_min").val();
        var max = $("#thematicmap input#category_max").val();
        var number = $("#thematicmap input#category_number").val();
        var opacity = $("#thematicmap input#category_opacity").val();
        var width = $("#thematicmap input.category-boundary-width").val();
        var categories = $("#thematicmap div#thematicmap_categories div.item");
        var data_categories = [];
        for (var i = 0; i < categories.length; i++) {
            var color_fill = $(categories[i]).find("div.category-color-fill").css("background-color");
            var color_boundary = $(categories[i]).find("div.category-color-boundary").css("background-color");
            var category_from = $(categories[i]).find("div.category-from").html();
            var category_to = $(categories[i]).find("div.category-to").html();
            data_categories.push({'fill': color_fill, 'boundary': color_boundary, 'from': category_from, 'to': category_to});
        }

        var setting_name = prompt("Please enter settings name?\nsame name will be overwritten! ", "");

        if (setting_name === null || $.trim(setting_name) === '') {
            return;
        }
        var formData = new FormData();
        formData.append('data', JSON.stringify({width: width, opacity: opacity, number: number, datasource: datasource, fieldname: fieldname, gradient: gradient, min: min, max: max, categories: data_categories}));
        formData.append('setting_name', setting_name);
        $.ajax({
            url: Routing.generate('thematicmap_save'),
            type: 'POST',
            beforeSend: function() {
                window.map.spin(true);
            },
            complete: function() {
                window.map.spin(false);
            },
            error: function() {
                window.map.spin(false);
            },
            //Ajax events
            success: completeHandler = function(response) {
                var result = response;
                if (typeof result !== 'object')
                    result = JSON.parse(result);
                if (result.success !== true && result.message !== null && result.message !== undefined) {
                    alert(result.message);
                    return;
                }

                $("#thematicmap select#my_thematicmap_list").empty();
                if (result.thematicmaps !== undefined && result.thematicmaps !== null)
                {
                    for (var i = 0; i < result.thematicmaps.length; i++)
                        $("#thematicmap select#my_thematicmap_list").append($("<option></option>").attr("value", result.thematicmaps[i].id).text(result.thematicmaps[i].name));
                }

            },
            // Form data
            data: formData,
            //Options to tell JQuery not to process data or worry about content-type
            cache: false,
            contentType: false,
            processData: false

        });
    };
    $("#thematicmap img#load_thematicmap").click(function() {
        if (window.layersControl !== undefined)
            window.layersControl.addUploadfile(Routing.generate('default_uploadfile_info'), $("#thematicmap  select#thematicmap_datasource").val());
    });
    applyThematicmap = function() {
        var datasource = $("#thematicmap select#thematicmap_datasource").val();
        var filename = $("#thematicmap select#thematicmap_datasource option:selected").text();
        var fieldname = $("#thematicmap select#thematicmap_datafieldname").val();
        var opacity = $("#thematicmap input#category_opacity").val();
        var min = $("#thematicmap input#category_min").val();
        var width = $("#thematicmap input.category-boundary-width").val();
        var categories = $("#thematicmap div#thematicmap_categories div.item");
        var data_categories = [];
        for (var i = 0; i < categories.length; i++) {
            var color_fill = $(categories[i]).find("div.category-color-fill").css("background-color");
            var color_boundary = $(categories[i]).find("div.category-color-boundary").css("background-color");
            var category_from = $(categories[i]).find("div.category-from").html();
            var category_to = $(categories[i]).find("div.category-to").html();
            data_categories.push({'fill': color_fill, 'boundary': color_boundary, 'from': category_from, 'to': category_to});
        }
        window.layersControl.renderThematicmap(
                {
                    datasource: parseInt(datasource)
                    , filename: filename
                    , fieldname: fieldname
                    , min: parseFloat(min)
                    , opacity: opacity
                    , width: width
                    , thematicmap: true
                    , categories: data_categories
                }
        );
    };

    createThematicmapLayer = function(opt) {

        var testData;
        if (opt && opt.data)
            testData = opt.data;
        else
            testData = {
                min: 0,
                max: 11,
                data: [{lat: 24.6408, lng: 46.7728, count: 3}, {lat: 50.75, lng: -1.55, count: 1}, {lat: 52.6333, lng: 1.75, count: 1}, {lat: 48.15, lng: 9.4667, count: 1}, {lat: 52.35, lng: 4.9167, count: 2}, {lat: 60.8, lng: 11.1, count: 1}, {lat: 43.561, lng: -116.214, count: 1}, {lat: 47.5036, lng: -94.685, count: 1}, {lat: 42.1818, lng: -71.1962, count: 1}, {lat: 42.0477, lng: -74.1227, count: 1}, {lat: 40.0326, lng: -75.719, count: 1}, {lat: 40.7128, lng: -73.2962, count: 2}, {lat: 27.9003, lng: -82.3024, count: 1}, {lat: 38.2085, lng: -85.6918, count: 1}, {lat: 46.8159, lng: -100.706, count: 1}, {lat: 30.5449, lng: -90.8083, count: 1}, {lat: 44.735, lng: -89.61, count: 1}, {lat: 41.4201, lng: -75.6485, count: 2}, {lat: 39.4209, lng: -74.4977, count: 11}, {lat: 39.7437, lng: -104.979, count: 1}, {lat: 39.5593, lng: -105.006, count: 1}, {lat: 45.2673, lng: -93.0196, count: 1}, {lat: 41.1215, lng: -89.4635, count: 1}, {lat: 43.4314, lng: -83.9784, count: 1}, {lat: 43.7279, lng: -86.284, count: 1}, {lat: 40.7168, lng: -73.9861, count: 1}, {lat: 47.7294, lng: -116.757, count: 1}, {lat: 47.7294, lng: -116.757, count: 2}, {lat: 35.5498, lng: -118.917, count: 1}, {lat: 34.1568, lng: -118.523, count: 1}, {lat: 39.501, lng: -87.3919, count: 3}, {lat: 33.5586, lng: -112.095, count: 1}, {lat: 38.757, lng: -77.1487, count: 1}, {lat: 33.223, lng: -117.107, count: 1}, {lat: 30.2316, lng: -85.502, count: 1}, {lat: 39.1703, lng: -75.5456, count: 8}, {lat: 30.0041, lng: -95.2984, count: 2}, {lat: 29.7755, lng: -95.4152, count: 1}, {lat: 41.8014, lng: -87.6005, count: 1}, {lat: 37.8754, lng: -121.687, count: 7}, {lat: 38.4493, lng: -122.709, count: 1}, {lat: 40.5494, lng: -89.6252, count: 1}, {lat: 42.6105, lng: -71.2306, count: 1}, {lat: 40.0973, lng: -85.671, count: 1}, {lat: 40.3987, lng: -86.8642, count: 1}, {lat: 40.4224, lng: -86.8031, count: 4}, {lat: 47.2166, lng: -122.451, count: 1}, {lat: 32.2369, lng: -110.956, count: 1}, {lat: 41.3969, lng: -87.3274, count: 2}, {lat: 41.7364, lng: -89.7043, count: 2}, {lat: 42.3425, lng: -71.0677, count: 1}, {lat: 33.8042, lng: -83.8893, count: 1}, {lat: 36.6859, lng: -121.629, count: 2}, {lat: 41.0957, lng: -80.5052, count: 1}, {lat: 46.8841, lng: -123.995, count: 1}, {lat: 40.2851, lng: -75.9523, count: 2}, {lat: 42.4235, lng: -85.3992, count: 1}, {lat: 39.7437, lng: -104.979, count: 2}, {lat: 25.6586, lng: -80.3568, count: 7}, {lat: 33.0975, lng: -80.1753, count: 1}, {lat: 25.7615, lng: -80.2939, count: 1}, {lat: 26.3739, lng: -80.1468, count: 1}, {lat: 37.6454, lng: -84.8171, count: 1}, {lat: 34.2321, lng: -77.8835, count: 1}, {lat: 34.6774, lng: -82.928, count: 1}, {lat: 39.9744, lng: -86.0779, count: 1}, {lat: 35.6784, lng: -97.4944, count: 2}, {lat: 33.5547, lng: -84.1872, count: 1}, {lat: 27.2498, lng: -80.3797, count: 1}, {lat: 41.4789, lng: -81.6473, count: 1}, {lat: 41.813, lng: -87.7134, count: 1}, {lat: 41.8917, lng: -87.9359, count: 1}, {lat: 35.0911, lng: -89.651, count: 1}, {lat: 32.6102, lng: -117.03, count: 1}, {lat: 41.758, lng: -72.7444, count: 1}, {lat: 39.8062, lng: -86.1407, count: 1}, {lat: 41.872, lng: -88.1662, count: 1}, {lat: 34.1404, lng: -81.3369, count: 1}, {lat: 46.15, lng: -60.1667, count: 1}, {lat: 36.0679, lng: -86.7194, count: 1}, {lat: 43.45, lng: -80.5, count: 1}, {lat: 44.3833, lng: -79.7, count: 1}, {lat: 45.4167, lng: -75.7, count: 2}, {lat: 43.75, lng: -79.2, count: 2}, {lat: 45.2667, lng: -66.0667, count: 3}, {lat: 42.9833, lng: -81.25, count: 2}, {lat: 44.25, lng: -79.4667, count: 3}, {lat: 45.2667, lng: -66.0667, count: 2}, {lat: 34.3667, lng: -118.478, count: 3}, {lat: 42.734, lng: -87.8211, count: 1}, {lat: 39.9738, lng: -86.1765, count: 1}, {lat: 33.7438, lng: -117.866, count: 1}, {lat: 37.5741, lng: -122.321, count: 1}, {lat: 42.2843, lng: -85.2293, count: 1}, {lat: 34.6574, lng: -92.5295, count: 1}, {lat: 41.4881, lng: -87.4424, count: 1}, {lat: 25.72, lng: -80.2707, count: 1}, {lat: 34.5873, lng: -118.245, count: 1}, {lat: 35.8278, lng: -78.6421, count: 1}]
            };
        var legendCanvas = document.createElement('canvas');


        if (opt && opt.legend && opt.legend.legendCanvas && opt.legend.legendCanvas.width)
            legendCanvas.width = opt.legendCanvas.width;
        else
            legendCanvas.width = 100;

        legendCanvas.height = 10;
        var gradients = [{"0": "#FFFF80", "1": "#6B0000"}, {"0": "#20CC10", "1": "#0720E3"}, {"0": "#ffff00", "1": "#ff0000"}, {"0": "#ffffff", "1": "#000000"}, {"0": "#38a800", "0.5": "#ffff00", "1": "#ff0000"}, {"0": "#38a800", "0.33": "#ffff00", "0.66": "#ff0000", "1": "#ff00ff"}, {"0": "#20CC10", "0.33": "#2EE6A5", "0.66": "#30A9F0", "1": "#0720E3"}, {"0": "#ff0000", "0.33": "#ffff00", "0.66": "#00ffff", "1": "#0000ff"}, {"0": "#ff9999", "0.33": "#ffff99", "0.66": "#99ffff", "1": "#9999ff"}];


        var legend_title;
        if (opt && opt.legend && opt.legend.title)
            legend_title = opt.legend.title;
        else
            legend_title = "Descriptive Legend Title";
        var opacity;
        if (opt && opt.maxOpacity)
            opacity = opt.maxOpacity;
        else
            opacity = 0.8;
        var radius;
        if (opt && opt.radius)
            radius = opt.radius;
        else
            radius = 2;
        var scaleRadius;
        if (opt && opt.scaleRadius)
            scaleRadius = opt.scaleRadius;
        else
            scaleRadius = true;
        var useLocalExtrema;
        if (opt && opt.useLocalExtrema)
            useLocalExtrema = opt.useLocalExtrema;
        else
            useLocalExtrema = false;



        var thematicmap_legends = $("#sidebar-left #sidebar_content #thematicmap_legends");

        var gradient = null;
        gradient = $("#thematicmap #thematicmap_legends option:selected").val();



        thematicmap_legends.empty();

        var legendCanvas = {};
        window.legendCanvas = legendCanvas;
        var legend_select = $("<div id='thematicmap_gradient'></div>").appendTo(thematicmap_legends);

        var gradientCfg = {};
        //startColorstr='#ffff00', endColorstr='#ff0000'


        gradients.map(function(g, i) {

            legendCanvas[i] = document.createElement('canvas');
            legendCanvas[i].width = 100;
            legendCanvas[i].height = 10;
            var legendCtx = legendCanvas[i].getContext('2d');
            gradientCfg = gradients[i];
            var gradient_render = legendCtx.createLinearGradient(0, 0, legendCanvas[i].width, 1);
            for (var key in gradientCfg)
            {

                gradient_render.addColorStop(key, gradientCfg[key]);
            }

            legendCtx.fillStyle = gradient_render;
            legendCtx.fillRect(0, 0, 100, 10);

            //     var opt = $("<option value='" + escape(JSON.stringify(g)) + "'>&nbsp;</option>");
            var opt = $("<div style='margin:2px;'><input type='radio' index='" + i + "' data='" + escape(JSON.stringify(g)) + "' name='legend_gradient' style='display:inline-block'><div class='gradient' index='" + i + "' style='margin-left:5px;display:inline-block;width:255px;'> &nbsp;</div></div>");
            if (i === 0) {
                opt.find("input").attr('checked', 'checked');
            }
            var opt_gradient = opt.find(".gradient");
            opt_gradient.css('background-image', 'url(' + legendCanvas[i].toDataURL() + ')');
            opt_gradient.css('backgroundRepeat', 'no-repeat');
            opt_gradient.css('background-size', 'cover');



            legend_select.append(opt);

            if ((i === 0 && (gradient === undefined || gradient === null || gradient === '')) || (escape(JSON.stringify(g)) === gradient))
            {
                gradient = escape(JSON.stringify(g));
                $("#thematicmap #thematicmap_legends select").val(gradient);
                $("#thematicmap #thematicmap_legends select").css('background-image', 'url(' + legendCanvas[i].toDataURL() + ')');
                $("#thematicmap #thematicmap_legends select").css("backgroundRepeat", 'no-repeat');
                $("#thematicmap #thematicmap_legends select").css("background-size", 'cover');

            }
        });

        $('#thematicmap_gradient input:radio[name=legend_gradient]').change(function() {
            thematicmap_gradientchagne(this);
        });
        thematicmap_datasource_changed();
        return;
    };
    categories_changed = function(item) {
        $("#thematicmap div#thematicmap_categories div.item").removeClass('selected');
        $(item).addClass('selected');
        var color_fill = $(item).find("div.category-color-fill").css("background-color");
        var color_boundary = $(item).find("div.category-color-boundary").css("background-color");
        var category_from = $(item).find("div.category-from").html();
        var category_to = $(item).find("div.category-to").html();

        $("#thematicmap #thematicmap_category_property").empty();
        $("#thematicmap #thematicmap_category_property").append('<div  class="thematicmap_label category-from" style="width:150px;display: inline-block">From: ' + category_from + '</div>');
        $("#thematicmap #thematicmap_category_property").append('<div class="thematicmap_label" style="width:150px;display: inline-block">To:<input class="category-to" type="text" style="line-height: 15px;padding:0px 0px;width:100px;" value="' + category_to + '" onchange="category_textToChanged();"></input></div>');
        $("#thematicmap #thematicmap_category_property").append('<div class="thematicmap_label" style="width:150px;display: inline-block">Fill:<input class="category-color-fill" type="text" style="line-height: 15px;padding:0px 0px;width:105px;" value="' + color_fill + '" onchange="category_fillColorChanged();"></input><div class="background-color_fill  color-box" style="display: inline-block;width:18px;background-color:' + color_fill + '">&nbsp;</div></div>');
        $("#thematicmap #thematicmap_category_property").append('<div class="thematicmap_label" style="width:150px;display: inline-block">Boundary:<input class="category-color-boundary" type="text" style="line-height: 15px;padding:0px 0px;width:67px;" value="' + color_boundary + '" onchange="category_boundaryColorChanged();"></input><div class="background-color_boundary  color-box" style="display: inline-block;width:18px;background-color:' + color_boundary + '">&nbsp;</div></div>');
        $('.background-color_boundary.color-box').colpick({
            layout: 'rgbhex',
            color: rgb2hex(color_boundary),
            onChange: function(hsb, hex, rgb, el, bySetColor) {
                $('.background-color_boundary.color-box').css('background-color', '#' + hex);
                $('#thematicmap #thematicmap_category_property input.category-color-boundary').val("rgb(" + rgb.r + "," + rgb.g + "," + rgb.b + ")");
            },
            onSubmit: function(hsb, hex, rgb, el) {
                $(el).css('background-color', '#' + hex);
                $(el).colpickHide();
                $('#thematicmap #thematicmap_category_property input.category-color-boundary').val("rgb(" + rgb.r + "," + rgb.g + "," + rgb.b + ")");
                $("#thematicmap div#thematicmap_categories div.item.selected").find("div.category-color-boundary").css("background-color", "rgb(" + rgb.r + "," + rgb.g + "," + rgb.b + ")");
            }
        });

        $('.background-color_fill.color-box').colpick({
            layout: 'rgbhex',
            color: rgb2hex(color_fill),
            onChange: function(hsb, hex, rgb, el, bySetColor) {
                $('.background-color_fill.color-box').css('background-color', '#' + hex);
                $('#thematicmap #thematicmap_category_property input.category-color-fill').val("rgb(" + rgb.r + "," + rgb.g + "," + rgb.b + ")");
            },
            onSubmit: function(hsb, hex, rgb, el) {
                $(el).css('background-color', '#' + hex);
                $(el).colpickHide();
                $('#thematicmap #thematicmap_category_property input.category-color-fill').val("rgb(" + rgb.r + "," + rgb.g + "," + rgb.b + ")");
                $("#thematicmap div#thematicmap_categories div.item.selected").find("div.category-color-fill").css("background-color", "rgb(" + rgb.r + "," + rgb.g + "," + rgb.b + ")");
            }
        });

        $('.colpick').css("z-index", "1200");
        $('.colpick').css("margin-top", "-205px");
        $('.colpick').css("height", "180px");
        $('.colpick').css("margin-left", "-265px");

        $("#thematicmap").focus(function() {
            $('#thematicmap .colpick').hide();
        });
    };
    //Function to convert hex format to a rgb color
    rgb2hex = function(rgb) {
        var hexDigits = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "a", "b", "c", "d", "e", "f"];
        rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
        function hex(x) {
            return isNaN(x) ? "01" : hexDigits[(x - x % 16) / 16] + hexDigits[x % 16];
        }
        return "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);
    };
    category_textToChanged = function() {

        var to_text = $("#thematicmap #thematicmap_category_property input.category-to").val();
        var from_text = $("#thematicmap div#thematicmap_categories div.item.selected").find("div.category-from").html();
        if (parseFloat(to_text) <= parseFloat(from_text)) {
            alert("You can not set the value less than from value!");
            $("#thematicmap #thematicmap_category_property input.category-to").focus();
            return;
        }
        $("#thematicmap div#thematicmap_categories div.item.selected").find("div.category-to").html(to_text);

        var category_from = $("#thematicmap div#thematicmap_categories").find("div.category-from");
        var category_to = $("#thematicmap div#thematicmap_categories").find("div.category-to");
        var category_to_last, category_from_last;
        for (var i = 0; i < category_to.length; i++) {
            if (i === 0) {
                category_to_last = category_to[i];
                category_from_last = category_from[i];
            }
            else {

                if (parseFloat($(category_from[i]).html()) !== parseFloat($(category_to_last).html()))
                {
                    $(category_from[i]).html($(category_to_last).html());
                }
                if (parseFloat($(category_to[i]).html()) < parseFloat($(category_to_last).html()))
                {
                    $(category_to[i]).html($(category_to_last).html());
                }
                category_to_last = category_to[i];
            }
        }

    };
    category_fillColorChanged = function() {
        var fillColor = $("#thematicmap #thematicmap_category_property input.category-color-fill").val();
        $("#thematicmap div#thematicmap_categories div.item.selected").find("div.category-color-fill").css("background-color", fillColor);

    };
    category_boundaryColorChanged = function() {
        var boundaryColor = $("#thematicmap #thematicmap_category_property input.category-color-boundary").val();
        $("#thematicmap div#thematicmap_categories div.item.selected").find("div.category-color-boundary").css("background-color", boundaryColor);
    };
    /**
     * @param searchString
     * @return string
     */
    getHexValue = function(searchString) {
        var noHash = searchString.replace("#", "");
        if ((noHash.length !== 6 && noHash.length !== 3) || noHash.match(/[0-9A-Fa-f]/g).length < noHash.length) {
            return false;
        }
        return noHash;
    };

    /**
     * @param searchString
     * @return array
     */
    getRGBValue = function(searchString) {
        var ingredients = searchString.match(/\d{,3}/g);
        for (var i in ingredients) {
            if (parseInt(ingredients[i]) > 255) {
                return false;
            }
        }

        return ingredients;
    };
    re_category = function() {

        var result_min = $("#category_min").val();
        var result_max = $("#category_max").val();
        if (parseFloat(result_min) > parseFloat(result_max)) {
            $("#category_min").val(result_max);
            $("#category_max").val(result_min);
            result_min = $("#category_min").val();
            result_max = $("#category_max").val();
        }


        var category_colors_length = parseInt($("#category_number").val());
        if (category_colors_length === 0) {
            alert("The categories number must be greater than 0!");
            return;
        }
        if (category_colors_length < 0)
        {
            category_colors_length = Math.abs(category_colors_length);
            $("#category_number").val(category_colors_length);
        }
        $("#thematicmap div#thematicmap_categories").empty();
        var index = parseInt($('#thematicmap_gradient input:radio[name=legend_gradient]:checked').attr("index"));// $("#thematicmap select#thematicmap_gradient option:selected").index();
        var legendCtx = window.legendCanvas[index].getContext('2d');

        for (var i = 0; i < category_colors_length; i++) {
            var c = legendCtx.getImageData((window.legendCanvas[index].width / parseFloat(category_colors_length)) * (i + 0.5), 2, 1, 1).data;
            var category_text = "<div class='item' index='" + i + "' style='width:280px; border-bottom:1px grey dotted;'><div class='category-from' style='width:90px;display: inline-block'>" + (parseFloat(result_min) + (parseFloat(result_max) - parseFloat(result_min)) / category_colors_length * i).toFixed(4) + "</div><div  class='category-to'  style='width:90px;display: inline-block'>" + (parseFloat(result_min) + (parseFloat(result_max) - parseFloat(result_min)) / category_colors_length * (i + 1)).toFixed(4) + "</div><div class='category-color-fill' style='margin:2px; width:38px; display: inline-block;background-color: rgb(" + c[0] + ',' + c[1] + ',' + c[2] + ")'>&nbsp;</div><div class='category-color-boundary' style='margin:2px 2px 2px 10px; width:38px; display: inline-block;background-color: #000000'>&nbsp;</div><div>";
            $("#thematicmap div#thematicmap_categories").append(category_text);
        }
        $("#thematicmap div#thematicmap_categories div.item").click(function() {
            categories_changed(this);
        });
    };
    thematicmap_gradientchagne = function(item) {

        var index = parseInt($('#thematicmap_gradient input:radio[name=legend_gradient]:checked').attr("index"));//$("#thematicmap select#thematicmap_gradient option:selected").index();

        var legendCtx = window.legendCanvas[index].getContext('2d');
        var category_colors_fill = $("#thematicmap div#thematicmap_categories div.category-color-fill");
        var category_colors_boundary = $("#thematicmap div#thematicmap_categories div.category-color-boundary");
        for (var i = 0; i < category_colors_fill.length; i++) {
            var c = legendCtx.getImageData((window.legendCanvas[index].width / category_colors_fill.length) * (i + 0.5), 2, 1, 1).data;
            $(category_colors_fill[i]).css("background-color", "rgb(" + c[0] + ',' + c[1] + ',' + c[2] + ")");
            $(category_colors_boundary[i]).css("background-color", "#000000");
        }
        $("#thematicmap #thematicmap_category_property").empty();
    };

    heatmap_radiuschagne = function() {
        var radius = $("#heatmap input#radius_size").val();
        //   alert(radius);
        //  window.heatmap_layer._heatmap.set('radius', radius);
    };
    heatmap_opacitychange = function() {
        var opacity = $("#heatmap input.opacity-slider").val();

        //  window.heatmap_layer._heatmap.set('opacity', parseFloat(opacity) / 100);
    };
    thematicmap_list_del = function() {

        var id = $("#thematicmap select#my_thematicmap_list").val();
        var res = confirm("Are you sure you want to delete the thematic map setting?");
        if (res === false)
            return;
        var formData = new FormData();
        formData.append('id', id);
        $.ajax({
            url: Routing.generate('thematicmap_delete'),
            type: 'POST',
            beforeSend: function() {
                window.map.spin(true);
            },
            complete: function() {
                window.map.spin(false);
            },
            error: function() {
                window.map.spin(false);
            },
            //Ajax events
            success: completeHandler = function(response) {
                var result = response;
                if (typeof result !== 'object')
                    result = JSON.parse(result);
                if (result.success !== true && result.message !== null && result.message !== undefined) {
                    // if load data not suceess
                    alert(result.message);
                    return;
                }
                if (result.success === true) {
                    $("#thematicmap select#my_thematicmap_list option[value='" + id + "']").remove();
                }
            },
            // Form data
            data: formData,
            //Options to tell JQuery not to process data or worry about content-type
            cache: false,
            contentType: false,
            processData: false

        });
    };
    thematicmap_list_changed = function() {
        var id = $("#thematicmap select#my_thematicmap_list").val();
        $.ajax({
            url: Routing.generate('thematicmap_setting'),
            type: 'GET',
            beforeSend: function() {
                window.map.spin(true);
            },
            complete: function() {
                window.map.spin(false);
            },
            error: function() {
                window.map.spin(false);
            },
            //Ajax events
            success: completeHandler = function(response) {
                var result = response;
                if (typeof result !== 'object')
                    result = JSON.parse(result);
                if (result.success !== true && result.message !== null && result.message !== undefined) {
                    // if load data not suceess
                    alert(result.message);
                    return;
                }
                if (result.success === true) {
                    if (typeof result.thematicmap === 'string')
                        result.thematicmap = JSON.parse(result.thematicmap);
                    if (typeof result.thematicmap.category === 'string')
                        result.thematicmap.category = JSON.parse(result.thematicmap.category);
                    if (typeof result.thematicmap.categories === 'string')
                        result.thematicmap.categories = JSON.parse(result.thematicmap.categories);


                    if ($('#thematicmap select#thematicmap_datasource').val() !== result.thematicmap.datasource_id) {
                        $('#thematicmap select#thematicmap_datasource').val(result.thematicmap.datasource_id);

                        thematicmap_datasource_changed(false);
                    }
                    if ($('#thematicmap select#thematicmap_datafieldname').val() !== result.thematicmap.fieldname) {
                        $('#thematicmap select#thematicmap_datafieldname').data("change", false);
                        $('#thematicmap select#thematicmap_datafieldname').val(result.thematicmap.fieldname);
//                        setTimeout(function() {
//                            thematicmap_datafieldnamechagne(false);
//                        }, 200);

                    }


                    if ($("#thematicmap div#thematicmap_gradient input[type=radio]:checked").attr('data') !== result.thematicmap.gradient) {
                        $('#thematicmap div#thematicmap_gradient input[type=radio]').map(function() {
                            if ($(this).attr('data') === result.thematicmap.gradient) {
                                $(this).prop('checked', true);
                            }
                        });
                    }

                    if (result.thematicmap.category) {
                        $("#thematicmap input#category_min").val(result.thematicmap.category.min);
                        $("#thematicmap input#category_max").val(result.thematicmap.category.max);
                        $("#thematicmap input#category_number").val(result.thematicmap.category.number);
                        $("#thematicmap input#category_opacity").val(result.thematicmap.category.opacity);
                        $("#thematicmap input.category-boundary-width").val(result.thematicmap.category.width);
                    }


                    $("#thematicmap div#thematicmap_categories").empty();
                    setTimeout(function() {
                        if (result.thematicmap.categories) {
                            for (var i = 0; i < result.thematicmap.categories.length; i++) {
                                var category_text = "<div class='item' style='width:280px; border-bottom:1px grey dotted;'><div  class='category-from' style='width:90px;display: inline-block'>" + result.thematicmap.categories[i].from + "</div><div  class='category-to'  style='width:90px;display: inline-block'>" + result.thematicmap.categories[i].to + "</div><div class='category-color-fill' style='margin:2px; width:38px; display: inline-block;background-color: " + result.thematicmap.categories[i].fill + "'>&nbsp;</div><div class='category-color-boundary' style='margin:2px 2px 2px 10px; width:38px; display: inline-block;background-color: " + result.thematicmap.categories[i].boundary + " '>&nbsp;</div><div>";
                                $("#thematicmap div#thematicmap_categories").append(category_text);
                            }
                            $("#thematicmap div#thematicmap_categories div.item").click(function() {
                                categories_changed(this);
                            });
                        }
                    }, 500);
                    $('#thematicmap select#thematicmap_datafieldname').data("change", null);
                }
            },
            // Form data
            data: {id: id},
            //Options to tell JQuery not to process data or worry about content-type
            cache: false,
            contentType: false
        });
    };
    thematicmap_list = function() {

        $.ajax({
            url: Routing.generate('thematicmap_list'),
            type: 'GET',
            beforeSend: function() {
                window.map.spin(true);
            },
            complete: function() {
                window.map.spin(false);
            },
            error: function() {
                window.map.spin(false);
            },
            //Ajax events
            success: completeHandler = function(response) {
                var result = response;
                if (typeof result !== 'object')
                    result = JSON.parse(result);
                if (result.success !== true && result.message !== null && result.message !== undefined) {
                    // if load data not suceess
                    alert(result.message);
                    return;
                }
                $("#thematicmap select#my_thematicmap_list").empty();
                if (result.thematicmaps !== undefined && result.thematicmaps !== null)
                {
                    for (var i = 0; i < result.thematicmaps.length; i++)
                        $("#thematicmap select#my_thematicmap_list").append($("<option></option>").attr("value", result.thematicmaps[i].id).text(result.thematicmaps[i].name));
                }

            },
            // Form data
            data: {id: datasource, numeric: false},
            //Options to tell JQuery not to process data or worry about content-type
            cache: false,
            contentType: false
        });
    };

    thematicmap_datasource_changed = function(event_fieldname_change) {
        var datasource = $("#thematicmap select#thematicmap_datasource").val();
        $.ajax({
            url: Routing.generate('default_uploadfilefields'),
            type: 'GET',
            beforeSend: function() {
                window.map.spin(true);
            },
            complete: function() {
                window.map.spin(false);
            },
            error: function() {
                window.map.spin(false);
            },
            //Ajax events
            success: completeHandler = function(response) {
                var result = response;
                if (typeof result !== 'object')
                    result = JSON.parse(result);
                if (result.success !== true && result.message !== null && result.message !== undefined) {
                    // if load data not suceess
                    alert(result.message);
                    return;
                }

                $("#thematicmap select#thematicmap_datafieldname").empty();
                if (result.fields !== undefined && result.fields !== null)
                {
                    for (var i = 0; i < result.fields.length; i++)
                        $("#thematicmap select#thematicmap_datafieldname").append($("<option></option>").attr("value", result.fields[i]).text(result.fields[i]));
                }

                if (event_fieldname_change !== false) {
                    setTimeout(function() {
                        thematicmap_datafieldnamechagne();
                    }, 200);
                }
            },
            // Form data
            data: {id: datasource, numeric: false},
            //Options to tell JQuery not to process data or worry about content-type
            cache: false,
            contentType: false
        });
    };
    thematicmap_datafieldnamechagne = function(event_category_change) {
        var datasource = $("#thematicmap select#thematicmap_datasource").val();
        var fieldname = $("#thematicmap select#thematicmap_datafieldname").val();
        if (fieldname === undefined || fieldname === null || fieldname === '')
            return;
        if ($("#thematicmap select#thematicmap_datafieldname").data("change") === false)
            return;
        $.ajax({
            url: Routing.generate('thematicmap_data'),
            type: 'GET',
            beforeSend: function() {
                window.map.spin(true);
            },
            complete: function() {
                window.map.spin(false);
            },
            error: function() {
                window.map.spin(false);
            },
            //Ajax events
            success: completeHandler = function(response) {
                var result = response;
                if (typeof result !== 'object')
                    result = JSON.parse(result);
                if (result.success !== true && result.message !== null && result.message !== undefined) {
                    // if load data not suceess
                    alert(result.message);
                    return;
                }
                $("#thematicmap div#thematicmap_categories").empty();
                var index = parseInt($('#thematicmap_gradient input:radio[name=legend_gradient]:checked').attr("index"));// $("#thematicmap select#thematicmap_gradient option:selected").index();
                var legendCtx = window.legendCanvas[index].getContext('2d');
                if (result.min && result.max && event_category_change !== false) {
                    for (var i = 0; i < 5; i++) {
                        var c = legendCtx.getImageData((window.legendCanvas[index].width / 5.0) * (i + 0.5), 2, 1, 1).data;
                        var category_text = "<div class='item' index='" + i + "' style='width:280px; border-bottom:1px grey dotted;'><div  class='category-from' style='width:90px;display: inline-block'>" + (parseFloat(result.min) + (parseFloat(result.max) - parseFloat(result.min)) / 5 * i).toFixed(4) + "</div><div  class='category-to'  style='width:90px;display: inline-block'>" + (parseFloat(result.min) + (parseFloat(result.max) - parseFloat(result.min)) / 5 * (i + 1)).toFixed(4) + "</div><div class='category-color-fill' style='margin:2px; width:38px; display: inline-block;background-color: rgb(" + c[0] + ',' + c[1] + ',' + c[2] + ")'>&nbsp;</div><div class='category-color-boundary' style='margin:2px 2px 2px 10px; width:38px; display: inline-block;background-color: #000000 '>&nbsp;</div></div>";
                        $("#thematicmap div#thematicmap_categories").append(category_text);
                    }
                    $("#thematicmap div#thematicmap_categories div.item").click(function() {
                        categories_changed(this);
                    });
                    $("#category_min").val(result.min);
                    $("#category_max").val(result.max);
                    $("#category_number").val(5);
                }
                else {

                }
                $("#thematicmap #thematicmap_category_property").empty();
            },
            // Form data
            data: {datasource: datasource, datafield: fieldname},
            //Options to tell JQuery not to process data or worry about content-type
            cache: false,
            contentType: false
        });
    };

    createThematicmapLayer({});

}(this, document));