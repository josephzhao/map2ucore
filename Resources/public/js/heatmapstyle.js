/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(function () {
    createHeatmapGradient = function () {
        var heatmap_legends = $("div#create_heatmap #custom_heatmap #heatmap_legends");
        var gradients = [{"0": "#FFFF80", "1": "#6B0000"}
            , {"0": "#20CC10", "1": "#0720E3"}
            , {"0": "#ffff00", "1": "#ff0000"}
            , {"0": "#ffffff", "1": "#000000"}
            , {"0": "#38a800", "0.5": "#ffff00", "1": "#ff0000"}
            , {"0": "#38a800", "0.33": "#ffff00", "0.66": "#ff0000", "1": "#ff00ff"}
            , {"0": "#20CC10", "0.33": "#2EE6A5", "0.66": "#30A9F0", "1": "#0720E3"}
            , {"0": "#ff0000", "0.33": "#ffff00", "0.66": "#00ffff", "1": "#0000ff"}
            , {"0": "#ff9999", "0.33": "#ffff99", "0.66": "#99ffff", "1": "#9999ff"}
        ];
        heatmap_legends.empty();
        var legendCanvas = {};
        var legend_select = $("<div id='heatmap_gradient'></div>").appendTo(heatmap_legends);
        var gradientCfg = {};
        var gradient = null;
        gradient = $('#heatmap_gradient input:radio[name=legend_gradient]:checked').attr("data");
        if (typeof gradient === 'string')
            gradient = JSON.parse(unescape(gradient));
        gradients.map(function (g, i) {
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
            var opt = $("<div style='margin:2px;'><input type='radio' index='" + i + "' data='" + escape(JSON.stringify(g)) + "' name='legend_gradient' style='display:inline-block'><div class='gradient' index='" + i + "' style='margin-left:5px;display:inline-block;width:180px;'> &nbsp;</div></div>");
            if ((i === 0 && !gradient) || (gradient === escape(JSON.stringify(g)))) {

                opt.find("input").attr('checked', 'checked');
            }
            var opt_gradient = opt.find(".gradient");
            opt_gradient.css('background-image', 'url(' + legendCanvas[i].toDataURL() + ')');
            opt_gradient.css('backgroundRepeat', 'no-repeat');
            opt_gradient.css('background-size', 'cover');
            legend_select.append(opt);
        });
        $("div#create_heatmap #custom_heatmap #heatmap_legends #heatmap_gradient input[type='radio'][name='legend_gradient']").unbind("change");
        $("div#create_heatmap #custom_heatmap #heatmap_legends #heatmap_gradient input[type='radio'][name='legend_gradient']").change(function () {
            if (window.heatmap_data) {
                createHeatMapLayer({data: window.heatmap_data, 'uploadfile_id': '', 'type': 'preview'});
            }
        });
        window.legendCanvas = legendCanvas;
    };
    function addHeatmapGradient() {
        //    alert("h1");
        var gradient_name;
        if ($("#heatmap_gradient_form #gradient_name").val() === undefined || $("#heatmap_gradient_form #gradient_name").val() === '')
        {
            alert("Gradient name must not be empty!");
            $("#heatmap_gradient_form #gradient_name").focus();
            return;
        }
        gradient_name = $("#heatmap_gradient_form #gradient_name").val();
        var gradient_number = getHeatmapGradient();
        if (gradient_number.length < 2)
        {
            alert("No enough validate gradient number");
            return;
        }

        //  alert("gradient_number=" + gradient_number.length + "  " + JSON.stringify(gradient_number));

        var sorted_gradient_number = sortHeatmapGradient(gradient_number);
        setHeatmapGradient(sorted_gradient_number);
        var bexist = false;
        $("#heatmap_gradient_form #heatmapgradient option").map(function () {
            var opt_value = $(this).val();
            if (typeof opt_value === 'string')
                opt_value = JSON.parse(opt_value);
            if (opt_value['name'] === gradient_name) {
                bexist = true;
            }
        });
        if (bexist === false) {
            var gradient_str;
            var gradient = {name: gradient_name, gradient: sorted_gradient_number};
            gradient_str = JSON.stringify(gradient);
            $('#heatmap_gradient_form #heatmapgradient').append($("<option></option>").attr("value", gradient_str).text(gradient_name));
        }
        // alert("sorted_gradient_number=" + JSON.stringify(sorted_gradient_number));
    }
    function setHeatmapGradient(sorted_gradient_number) {
        //    alert("h2");
        $("#heatmap_gradient_form input.gradient_number").map(function (i) {

            if (i < sorted_gradient_number.length) {
                $("#heatmap_gradient_form input#gradient_number_" + i).val(sorted_gradient_number[i].number);
                $("#heatmap_gradient_form input#gradient_color_" + i).val("#" + sorted_gradient_number[i].color);
                $("#heatmap_gradient_form #gradient_color_preview_" + i).css("background-color", "#" + sorted_gradient_number[i].color);
                $("#heatmap_gradient_form div#gradient_color_preview_" + i).css("margin", "3px;");
                $("#heatmap_gradient_form div#gradient_color_preview_" + i).width(20);
                $("#heatmap_gradient_form div#gradient_color_preview_" + i).height(20);
            }
            else
            {
                $("#heatmap_gradient_form input#gradient_number_" + i).val('');
                $("#heatmap_gradient_form input#gradient_color_" + i).val('');
                $("#heatmap_gradient_form div#gradient_color_preview_" + i).css("background-color", 'white');
            }
        });
    }
    function getHeatmapGradient() {
        //   alert("h3");
        var gradient_number = $("#heatmap_gradient_form input.gradient_number").map(function () {

            if ($(this).val() !== null && $(this).val() !== '')
            {
                if (isNaN(parseFloat($(this).val()))) {
                    alert("The number " + $(this).val() + " is invalidate value!");
                }
                else
                {
                    if (parseFloat($(this).val()) > 1.0 || parseFloat($(this).val()) < 0.0) {
                        alert("The number must be between 0 and 1.0");
                    }
                    else
                    {
                        var color_id = $(this).attr("id").toString();
                        color_id = color_id.replace("number", "color");
                        var sNum = $("#heatmap_gradient_form #" + color_id).val();
                        sNum = sNum.replace("#", "");
                        if (sNum !== undefined && (typeof sNum === "string") && sNum.length === 6 && !isNaN(parseInt(sNum, 16)))
                        {


                            return {number: $(this).val(), color: sNum};
                        }
                        else {
                            alert("Gradient number:" + $(this).val() + " does not have validate color value:" + sNum + ".");
                        }
                    }
                }
            }
        });
        return gradient_number;
    }
    function changeHeatmapGradient() {
        //   alert("h4");
        $("#heatmap_gradient_form #heatmapgradient option:selected").map(function () {
            var opt_value = $(this).val();
            if (typeof opt_value === 'string')
                opt_value = JSON.parse(opt_value);
            var sorted_gradient_number = opt_value['gradient'];
            $("#heatmap_gradient_form #gradient_name").val(opt_value['name']);
            setHeatmapGradient(sorted_gradient_number);
        });
    }
    function sortHeatmapGradient(gradient_number) {
        //   alert("h5");
        var sorted_gradient_number = [], keys = [],
                k, i, len;
        for (k in gradient_number)
        {

            if (gradient_number[k].number)
            {
                keys.push(gradient_number[k].number);
            }
        }

        keys.sort();
        len = keys.length;
        for (i = 0; i < len; i++)
        {
            k = keys[i];
            for (var j in gradient_number) {
                if (gradient_number[j].number === k)
                    sorted_gradient_number.push(gradient_number[j]);
            }
        }
        return sorted_gradient_number;
    }
    function delHeatmapGradient() {
        alert("h6");
        $("#heatmap_gradient_form #heatmapgradient option:selected").map(function () {
            var opt_text = $(this).text();
            var result = confirm("Are you sure you want to delete " + opt_text + "?");
            if (result) {
                $(this).remove();
            }
        });
    }
    function updateHeatmapGradient() {
        alert("h7");
        var gradient_name;
        if ($("#heatmap_gradient_form #gradient_name").val() === undefined || $("#heatmap_gradient_form #gradient_name").val() === '')
        {
            alert("Gradient name must not be empty!");
            $("#heatmap_gradient_form #gradient_name").focus();
            return;
        }
        gradient_name = $("#heatmap_gradient_form #gradient_name").val();
        var gradient_number = getHeatmapGradient();
        if (gradient_number.length < 2)
        {
            alert("No enough validate gradient number");
            return;
        }

//  alert("gradient_number=" + gradient_number.length + "  " + JSON.stringify(gradient_number));

        var sorted_gradient_number = sortHeatmapGradient(gradient_number);
        setHeatmapGradient(sorted_gradient_number);
        var bexist = false;
        $("#heatmap_gradient_form #heatmapgradient option").map(function () {
            var opt_value = $(this).val();
            if (typeof opt_value === 'string')
                opt_value = JSON.parse(opt_value);
            if (opt_value['name'] === gradient_name) {
                bexist = true;
            }
        });
        if (bexist === false) {
            var gradient_str;
            var gradient = {name: gradient_name, gradient: sorted_gradient_number};
            gradient_str = JSON.stringify(gradient);
            $('#heatmap_gradient_form #heatmapgradient').append($("<option></option>").attr("value", gradient_str).text(gradient_name));
        }
        var gradient_name;
        if ($("#heatmap_gradient_form #gradient_name").val() === undefined || $("#heatmap_gradient_form #gradient_name").val() === '')
        {
            alert("Gradient name must not be empty!");
            $("#heatmap_gradient_form #gradient_name").focus();
            return;
        }
        gradient_name = $("#heatmap_gradient_form #gradient_name").val();
        var gradient_number = getHeatmapGradient();
        if (gradient_number.length < 2)
        {
            alert("No enough validate gradient number");
            return;
        }

//  alert("gradient_number=" + gradient_number.length + "  " + JSON.stringify(gradient_number));

        var sorted_gradient_number = sortHeatmapGradient(gradient_number);
        setHeatmapGradient(sorted_gradient_number);
        var bexist = false;
        $("#heatmap_gradient_form #heatmapgradient option").map(function () {
            var opt_value = $(this).val();
            if (typeof opt_value === 'string')
                opt_value = JSON.parse(opt_value);
            if (opt_value['name'] === gradient_name) {
                bexist = true;
                var gradient_str;
                var gradient = {name: gradient_name, gradient: sorted_gradient_number};
                gradient_str = JSON.stringify(gradient);
                $(this).val(gradient_str);
                var result = confirm("This gradient values has been updated only for list box, \nnot saved to server yet, do you want to save it to server?");
                if (result)
                    saveHeatmapGradient();
            }
        });
        if (bexist === false) {
            var result = confirm("This gradient name not exist,do you want to add it?");
            if (result) {

                var gradient_str;
                var gradient = {name: gradient_name, gradient: sorted_gradient_number};
                gradient_str = JSON.stringify(gradient);
                $('#heatmap_gradient_form #heatmapgradient').append($("<option></option>").attr("value", gradient_str).text(gradient_name));
            }
        }

    }
    function saveHeatmapGradient() {
        alert("h8");
        $("#heatmap_gradient_form").submit();
    }
    function heatmap_gradient_minicolors() {
        alert("h9");
        $("#heatmap_gradient_form #gradient_color").minicolors({
            control: $(this).attr('data-control') || 'hue',
            defaultValue: $(this).attr('data-defaultValue') || '',
            inline: $(this).attr('data-inline') === 'true',
            letterCase: $(this).attr('data-letterCase') || 'lowercase',
            opacity: $(this).attr('data-opacity'),
            position: $(this).attr('data-position') || 'bottom left',
            change: function (hex, opacity) {
                var log;
                alert("ddd");
                try {
                    log = hex ? hex : 'transparent';
                    if (opacity)
                        log += ', ' + opacity;
                    console.log(log);
                } catch (e) {
                }
            },
            theme: 'default'
        });
    }
    function heatmap_gradient_submit() {
        alert("h10");
        $("#heatmap_gradient_form").unbind('submit').submit(function (e)
        {
            e.preventDefault();
            var formData = new FormData($('#heatmap_gradient_form')[0]);
            e.preventDefault();
            var formData = new FormData($('#heatmap_gradient_form')[0]);
            var data = $("#heatmap_gradient_form #heatmapgradient option").map(function () {

                return $(this).val().toString();
            });
            var formdata = [];
            ;
            for (var i = 0; i < data.length; i++)
                formdata[i] = data[i];
            alert(JSON.stringify(formdata));
            formData.append("data", JSON.stringify(formdata));
            $.ajax({
                url: $(this).attr("action"),
                type: 'POST',
                xhr: function () {
                    var map2uXhr = $.ajaxSettings.xhr();
                    if (map2uXhr.upload) {
                        //   map2uXhr.upload.addEventListener('progress', setProgress, false);
                    }
                    return map2uXhr;
                },
                complete: function () {
//                $('body').css('cursor', 'default');
//                $(".progressbar").hide();
                },
                success: function (data) {
                    alert(data);
//                var result;
//                if (typeof data !== 'object')
//                    result = JSON.parse(data);
//                if (result.success === true)
//                {
//
//
//
//                }
//                alert(result.message);
                },
                data: formData,
                cache: false,
                contentType: false,
                processData: false
            });
            return false;
        });
    }

    createHeatMapLayer = function (opt) {
        var testData;
        var layerId = opt.data['id'];
        if (opt && opt.data) {
            testData = opt.data;
        }
        else {
            testData = {
                min: 0,
                max: 11,
                data: [{lat: 24.6408, lng: 46.7728, count: 3}, {lat: 50.75, lng: -1.55, count: 1}, {lat: 52.6333, lng: 1.75, count: 1}, {lat: 48.15, lng: 9.4667, count: 1}, {lat: 52.35, lng: 4.9167, count: 2}, {lat: 60.8, lng: 11.1, count: 1}, {lat: 43.561, lng: -116.214, count: 1}, {lat: 47.5036, lng: -94.685, count: 1}, {lat: 42.1818, lng: -71.1962, count: 1}, {lat: 42.0477, lng: -74.1227, count: 1}, {lat: 40.0326, lng: -75.719, count: 1}, {lat: 40.7128, lng: -73.2962, count: 2}, {lat: 27.9003, lng: -82.3024, count: 1}, {lat: 38.2085, lng: -85.6918, count: 1}, {lat: 46.8159, lng: -100.706, count: 1}, {lat: 30.5449, lng: -90.8083, count: 1}, {lat: 44.735, lng: -89.61, count: 1}, {lat: 41.4201, lng: -75.6485, count: 2}, {lat: 39.4209, lng: -74.4977, count: 11}, {lat: 39.7437, lng: -104.979, count: 1}, {lat: 39.5593, lng: -105.006, count: 1}, {lat: 45.2673, lng: -93.0196, count: 1}, {lat: 41.1215, lng: -89.4635, count: 1}, {lat: 43.4314, lng: -83.9784, count: 1}, {lat: 43.7279, lng: -86.284, count: 1}, {lat: 40.7168, lng: -73.9861, count: 1}, {lat: 47.7294, lng: -116.757, count: 1}, {lat: 47.7294, lng: -116.757, count: 2}, {lat: 35.5498, lng: -118.917, count: 1}, {lat: 34.1568, lng: -118.523, count: 1}, {lat: 39.501, lng: -87.3919, count: 3}, {lat: 33.5586, lng: -112.095, count: 1}, {lat: 38.757, lng: -77.1487, count: 1}, {lat: 33.223, lng: -117.107, count: 1}, {lat: 30.2316, lng: -85.502, count: 1}, {lat: 39.1703, lng: -75.5456, count: 8}, {lat: 30.0041, lng: -95.2984, count: 2}, {lat: 29.7755, lng: -95.4152, count: 1}, {lat: 41.8014, lng: -87.6005, count: 1}, {lat: 37.8754, lng: -121.687, count: 7}, {lat: 38.4493, lng: -122.709, count: 1}, {lat: 40.5494, lng: -89.6252, count: 1}, {lat: 42.6105, lng: -71.2306, count: 1}, {lat: 40.0973, lng: -85.671, count: 1}, {lat: 40.3987, lng: -86.8642, count: 1}, {lat: 40.4224, lng: -86.8031, count: 4}, {lat: 47.2166, lng: -122.451, count: 1}, {lat: 32.2369, lng: -110.956, count: 1}, {lat: 41.3969, lng: -87.3274, count: 2}, {lat: 41.7364, lng: -89.7043, count: 2}, {lat: 42.3425, lng: -71.0677, count: 1}, {lat: 33.8042, lng: -83.8893, count: 1}, {lat: 36.6859, lng: -121.629, count: 2}, {lat: 41.0957, lng: -80.5052, count: 1}, {lat: 46.8841, lng: -123.995, count: 1}, {lat: 40.2851, lng: -75.9523, count: 2}, {lat: 42.4235, lng: -85.3992, count: 1}, {lat: 39.7437, lng: -104.979, count: 2}, {lat: 25.6586, lng: -80.3568, count: 7}, {lat: 33.0975, lng: -80.1753, count: 1}, {lat: 25.7615, lng: -80.2939, count: 1}, {lat: 26.3739, lng: -80.1468, count: 1}, {lat: 37.6454, lng: -84.8171, count: 1}, {lat: 34.2321, lng: -77.8835, count: 1}, {lat: 34.6774, lng: -82.928, count: 1}, {lat: 39.9744, lng: -86.0779, count: 1}, {lat: 35.6784, lng: -97.4944, count: 2}, {lat: 33.5547, lng: -84.1872, count: 1}, {lat: 27.2498, lng: -80.3797, count: 1}, {lat: 41.4789, lng: -81.6473, count: 1}, {lat: 41.813, lng: -87.7134, count: 1}, {lat: 41.8917, lng: -87.9359, count: 1}, {lat: 35.0911, lng: -89.651, count: 1}, {lat: 32.6102, lng: -117.03, count: 1}, {lat: 41.758, lng: -72.7444, count: 1}, {lat: 39.8062, lng: -86.1407, count: 1}, {lat: 41.872, lng: -88.1662, count: 1}, {lat: 34.1404, lng: -81.3369, count: 1}, {lat: 46.15, lng: -60.1667, count: 1}, {lat: 36.0679, lng: -86.7194, count: 1}, {lat: 43.45, lng: -80.5, count: 1}, {lat: 44.3833, lng: -79.7, count: 1}, {lat: 45.4167, lng: -75.7, count: 2}, {lat: 43.75, lng: -79.2, count: 2}, {lat: 45.2667, lng: -66.0667, count: 3}, {lat: 42.9833, lng: -81.25, count: 2}, {lat: 44.25, lng: -79.4667, count: 3}, {lat: 45.2667, lng: -66.0667, count: 2}, {lat: 34.3667, lng: -118.478, count: 3}, {lat: 42.734, lng: -87.8211, count: 1}, {lat: 39.9738, lng: -86.1765, count: 1}, {lat: 33.7438, lng: -117.866, count: 1}, {lat: 37.5741, lng: -122.321, count: 1}, {lat: 42.2843, lng: -85.2293, count: 1}, {lat: 34.6574, lng: -92.5295, count: 1}, {lat: 41.4881, lng: -87.4424, count: 1}, {lat: 25.72, lng: -80.2707, count: 1}, {lat: 34.5873, lng: -118.245, count: 1}, {lat: 35.8278, lng: -78.6421, count: 1}]
            };
        }
        var legend;

        if (opt && opt.legend && opt.legend.element)
            legend = $(opt.legend.element);
        else
            legend = $("#sidebar-left #sidebar_content #heatmap_legend1");

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
        else {

            if ($("div#create_heatmap #custom_heatmap input#radius_size").length === 0 || $("div#create_heatmap #custom_heatmap input#radius_size").data('slider') === undefined) {
                radius = 100.0;
            } else {
                radius = parseFloat($("div#create_heatmap #custom_heatmap input#radius_size").data('slider').getValue()) / 5000.0;
            }


        }
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

        var heatmap_legends = $("#sidebar-left #sidebar_content #heatmap_legends");
        var gradient = null;
        var gradientCfg = {};
        gradient = $('div#create_heatmap #heatmap_gradient input:radio[name=legend_gradient]:checked').attr("data");

        if (typeof gradient === 'string') {
            gradient = JSON.parse(unescape(gradient));
        }

        var cfg = {
            "id": layerId,
            // radius should be small ONLY if scaleRadius is true (or small radius is intended)
            "radius": radius,
            "maxOpacity": opacity,
            // scales the radius based on map zoom
            "scaleRadius": scaleRadius,
            "gradient": gradient,
            // if set to false the heatmap uses the global maximum for colorization
            // if activated: uses the data maximum within the current map boundaries 
            //   (there will always be a red spot with useLocalExtremas true)
            "useLocalExtrema": useLocalExtrema,
            // update the legend whenever there's an extrema change
            onExtremaChange: function (data) {
                // control.updateLegend(data);

                // the onExtremaChange callback gives us min, max, and the gradientConfig
                // so we can update the legend



                if (data.gradient !== gradientCfg)
                {


                }
            },
            // which field name in your data represents the latitude - default "lat"
            latField: 'lat',
            // which field name in your data represents the longitude - default "lng"
            lngField: 'lng',
            // which field name in your data represents the data value - default "value"
            valueField: 'count'
        };

        if (typeof window.heatmap_layer === 'object')
        {
            window.map.removeLayer(window.heatmap_layer);
        }
        $(".leaflet-overlay-pane .leaflet-zoom-hide.heatmap").map(function () {
            if ($(this).data("type") === opt.type) {
                $(this).remove();
            }
        });

        var heatmapLayer = new HeatmapOverlay(cfg);



        if (opt.spatialfile_id) {
            $(heatmapLayer.cfg.container).data("spatialfile_id", opt.spatialfile_id);
        }
        if (opt.keyfield) {
            $(heatmapLayer.cfg.container).data("keyfield", opt.keyfield);
        }
        if (opt.type) {
            $(heatmapLayer.cfg.container).data("type", opt.type);
        }
        if (opt.layerId) {
            $(heatmapLayer.cfg.container).data("layerId", opt.layerId);
        }

        heatmapLayer.onAdd(window.map);
   
        heatmapLayer.setData(testData);

        window.heatmap_layer = heatmapLayer;

        window.heatmap_cfg = cfg;

        var _this = this;
        window.map.on("resize", function () {
            var size = window.map.getSize();
            heatmapLayer._width = size.x;
            heatmapLayer._height = size.y;
            heatmapLayer._el.style.width = size.x + 'px';
            heatmapLayer._el.style.height = size.y + 'px';
            heatmapLayer._heatmap._width = size.x;
            heatmapLayer._heatmap._height = size.y;
            heatmapLayer._heatmap._renderer.setDimensions(size.x, size.y);
            heatmapLayer._heatmap._renderer.renderAll(heatmapLayer._heatmap._store._getInternalData());
            heatmapLayer._draw();
        });
        window.map.on("zoomend", function () {
            var zoom = this.getZoom();
            if ($("div#create_heatmap #custom_heatmap input#radius_size").length === 0)
            {
                return;
            }
            var value = $("div#create_heatmap #custom_heatmap input#radius_size").data('slider').getValue();

            $("div#create_heatmap #custom_heatmap input#radius_size").data('slider').max = 100 + Math.pow(2, Math.max(1, (11 - zoom))) * 80;
            $("div#create_heatmap #custom_heatmap input#radius_size").slider('setValue', value);
            //    $("div#create_heatmap #custom_heatmap input#radius_size").trigger("change");
        });
    };

    heatmap_radiuschagne = function () {
        var radius = $("div#create_heatmap #custom_heatmap input#radius_size").val();

        if (window.heatmap_layer) {
            //  alert(radius);
            window.heatmap_layer._heatmap.set('radius', radius / 5000.0);
        }
    };
    heatmap_opacitychange = function () {
        var opacity = $("div#create_heatmap #custom_heatmap input.opacity-slider").val();
        if (window.heatmap_layer) {
            window.heatmap_layer._heatmap.set('opacity', parseFloat(opacity) / 100);
        }
    };
//    $("div#create_heatmap div#maptype input[type='radio'][name='custom_maptype']").click(function (e) {
//        if ($(this).val() === 'pc_map') {
//            $("div#create_heatmap  div#custom_heatmap").hide();
//        }
//        else
//            $("div#create_heatmap  div#custom_heatmap").show();
//    });

    $("div#create_heatmap div.bottom-buttons button[value='create-map']").unbind("click");
    $("div#create_heatmap div.bottom-buttons button[value='create-map']").click(function () {
        var spatialfile_id = $("div#create_heatmap select#spatialfile_select_list").val();
        var keyfield = $("div#create_heatmap select#spatialfile_keyfield_list").val();

        if (window.heatmap_data) {
            createHeatMapLayer({data: window.heatmap_data, 'spatialfile_id': spatialfile_id, 'keyfield': keyfield, 'type': 'preview'});
        }
        else
        {
            $("select#spatialfile_keyfield_list").trigger("change");
        }
    });
    // if the index field changed
    $("select#shapefile_labelfield_list").change(function (e) {

        $("div#create_heatmap").data("keyfield", $(this).val());
        var project_id = $("div.current_project_item").data("project-id");

        var uploadfile_id = $("div#create_heatmap select#shapefile_select_list").val();


        var keyfield = $("div#create_heatmap").data("keyfield");
        var values = $("div#create_heatmap").data("values");
        e.preventDefault();
        var formData = new FormData();
        formData.append('project_id', project_id);
        formData.append('uploadfile_id', uploadfile_id);
        formData.append('keyfield', keyfield);
        formData.append('values', values);

        $.ajax({
            url: Routing.generate('mapping_showheatmap', {'_locale': window.locale}),
            type: 'POST',
            data: formData,
            complete: function () {

            },
            success: function (data) {

                var result;
                if (typeof data !== 'object')
                    result = JSON.parse(data);
                else
                    result = data;

                if (result.success === true)
                {
                    window.heatmap_data = result.data;
                    if (window.heatmap_layer) {

                        if (parseInt($(window.heatmap_layer.cfg.container).data("uploadfile_id")) !== parseInt(uploadfile_id)) {
                            $("div.leaflet-overlay-pane div.leaflet-zoom-hide.heatmap").map(function () {
                                if ($(this).data("type") === 'preview') {
                                    $(this).remove();
                                }
                            });
                        }
                        //   window.heatmap_layer.setData(result.data);
                    }
                    if (window.heatmap_data) {
                        createHeatMapLayer({data: window.heatmap_data, 'uploadfile_id': uploadfile_id, 'keyfield': keyfield, 'type': 'preview'});
                    }
                }

            },
            cache: false,
            contentType: false,
            processData: false
        });
        return false;

    });

    $('div#create_heatmap #custom_heatmap input.opacity-slider').slider().on('slideStop', function (ev) {
        var newVal = $('div#create_heatmap #custom_heatmap input.opacity-slider').data('slider').getValue();

        if (window.heatmap_layer) {

            window.heatmap_layer._heatmap.configure({'maxOpacity': parseFloat(newVal) / 100.0});
        }

    });
    $('div#create_heatmap #custom_heatmap input.radius-size-slider').slider().on('slideStop', function (ev) {

        var radius = $('div#create_heatmap #custom_heatmap input.radius-size-slider').data('slider').getValue();

        if (window.heatmap_layer) {

            window.heatmap_layer.updateRadius(parseFloat(radius) / 5000.0);
        }

    });

    createHeatmapGradient();
    $("select#spatialfile_keyfield_list").trigger("change");
});