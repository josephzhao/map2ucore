/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


(function (window, document) {

    saveHeatMapSettings = function () {
        var datasource = $("#heatmap select#heatmap_datasource").val();
        var fieldname = $("#heatmap select#heatmap_datafieldname").val();
        var gradient = $("#heatmap div#heatmap_gradient input[type=radio]:checked").attr('data');
        var radius_size = $("#heatmap input#heatmap_radius_size").val();
        var opacity = $("#heatmap input#heatmap_opacity").val();
    
        var setting_name = prompt("Please enter settings name?\nsame name will be overwritten! ", "");

        if (setting_name === null || $.trim(setting_name) === '') {
            return;
        }
        var formData = new FormData();
        formData.append('data', JSON.stringify({radius: radius_size, opacity: opacity,  datasource: datasource, fieldname: fieldname, gradient: gradient }));
        formData.append('setting_name', setting_name);
        $.ajax({
            url: Routing.generate('heatmap_save'),
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

                $("#heatmap select#my_heatmap_list").empty();
                if (result.heatmaps !== undefined && result.heatmaps !== null)
                {
                    for (var i = 0; i < result.heatmaps.length; i++)
                        $("#heatmap select#my_heatmap_list").append($("<option></option>").attr("value", result.heatmaps[i].id).text(result.heatmaps[i].layer_name));
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
    createHeatMapLayer = function (opt) {

        var testData;
        if (opt && opt.data)
            testData = opt.data;
        else
            testData = {
                min: 0,
                max: 11,
                data: [{lat: 24.6408, lng: 46.7728, count: 3}, {lat: 50.75, lng: -1.55, count: 1}, {lat: 52.6333, lng: 1.75, count: 1}, {lat: 48.15, lng: 9.4667, count: 1}, {lat: 52.35, lng: 4.9167, count: 2}, {lat: 60.8, lng: 11.1, count: 1}, {lat: 43.561, lng: -116.214, count: 1}, {lat: 47.5036, lng: -94.685, count: 1}, {lat: 42.1818, lng: -71.1962, count: 1}, {lat: 42.0477, lng: -74.1227, count: 1}, {lat: 40.0326, lng: -75.719, count: 1}, {lat: 40.7128, lng: -73.2962, count: 2}, {lat: 27.9003, lng: -82.3024, count: 1}, {lat: 38.2085, lng: -85.6918, count: 1}, {lat: 46.8159, lng: -100.706, count: 1}, {lat: 30.5449, lng: -90.8083, count: 1}, {lat: 44.735, lng: -89.61, count: 1}, {lat: 41.4201, lng: -75.6485, count: 2}, {lat: 39.4209, lng: -74.4977, count: 11}, {lat: 39.7437, lng: -104.979, count: 1}, {lat: 39.5593, lng: -105.006, count: 1}, {lat: 45.2673, lng: -93.0196, count: 1}, {lat: 41.1215, lng: -89.4635, count: 1}, {lat: 43.4314, lng: -83.9784, count: 1}, {lat: 43.7279, lng: -86.284, count: 1}, {lat: 40.7168, lng: -73.9861, count: 1}, {lat: 47.7294, lng: -116.757, count: 1}, {lat: 47.7294, lng: -116.757, count: 2}, {lat: 35.5498, lng: -118.917, count: 1}, {lat: 34.1568, lng: -118.523, count: 1}, {lat: 39.501, lng: -87.3919, count: 3}, {lat: 33.5586, lng: -112.095, count: 1}, {lat: 38.757, lng: -77.1487, count: 1}, {lat: 33.223, lng: -117.107, count: 1}, {lat: 30.2316, lng: -85.502, count: 1}, {lat: 39.1703, lng: -75.5456, count: 8}, {lat: 30.0041, lng: -95.2984, count: 2}, {lat: 29.7755, lng: -95.4152, count: 1}, {lat: 41.8014, lng: -87.6005, count: 1}, {lat: 37.8754, lng: -121.687, count: 7}, {lat: 38.4493, lng: -122.709, count: 1}, {lat: 40.5494, lng: -89.6252, count: 1}, {lat: 42.6105, lng: -71.2306, count: 1}, {lat: 40.0973, lng: -85.671, count: 1}, {lat: 40.3987, lng: -86.8642, count: 1}, {lat: 40.4224, lng: -86.8031, count: 4}, {lat: 47.2166, lng: -122.451, count: 1}, {lat: 32.2369, lng: -110.956, count: 1}, {lat: 41.3969, lng: -87.3274, count: 2}, {lat: 41.7364, lng: -89.7043, count: 2}, {lat: 42.3425, lng: -71.0677, count: 1}, {lat: 33.8042, lng: -83.8893, count: 1}, {lat: 36.6859, lng: -121.629, count: 2}, {lat: 41.0957, lng: -80.5052, count: 1}, {lat: 46.8841, lng: -123.995, count: 1}, {lat: 40.2851, lng: -75.9523, count: 2}, {lat: 42.4235, lng: -85.3992, count: 1}, {lat: 39.7437, lng: -104.979, count: 2}, {lat: 25.6586, lng: -80.3568, count: 7}, {lat: 33.0975, lng: -80.1753, count: 1}, {lat: 25.7615, lng: -80.2939, count: 1}, {lat: 26.3739, lng: -80.1468, count: 1}, {lat: 37.6454, lng: -84.8171, count: 1}, {lat: 34.2321, lng: -77.8835, count: 1}, {lat: 34.6774, lng: -82.928, count: 1}, {lat: 39.9744, lng: -86.0779, count: 1}, {lat: 35.6784, lng: -97.4944, count: 2}, {lat: 33.5547, lng: -84.1872, count: 1}, {lat: 27.2498, lng: -80.3797, count: 1}, {lat: 41.4789, lng: -81.6473, count: 1}, {lat: 41.813, lng: -87.7134, count: 1}, {lat: 41.8917, lng: -87.9359, count: 1}, {lat: 35.0911, lng: -89.651, count: 1}, {lat: 32.6102, lng: -117.03, count: 1}, {lat: 41.758, lng: -72.7444, count: 1}, {lat: 39.8062, lng: -86.1407, count: 1}, {lat: 41.872, lng: -88.1662, count: 1}, {lat: 34.1404, lng: -81.3369, count: 1}, {lat: 46.15, lng: -60.1667, count: 1}, {lat: 36.0679, lng: -86.7194, count: 1}, {lat: 43.45, lng: -80.5, count: 1}, {lat: 44.3833, lng: -79.7, count: 1}, {lat: 45.4167, lng: -75.7, count: 2}, {lat: 43.75, lng: -79.2, count: 2}, {lat: 45.2667, lng: -66.0667, count: 3}, {lat: 42.9833, lng: -81.25, count: 2}, {lat: 44.25, lng: -79.4667, count: 3}, {lat: 45.2667, lng: -66.0667, count: 2}, {lat: 34.3667, lng: -118.478, count: 3}, {lat: 42.734, lng: -87.8211, count: 1}, {lat: 39.9738, lng: -86.1765, count: 1}, {lat: 33.7438, lng: -117.866, count: 1}, {lat: 37.5741, lng: -122.321, count: 1}, {lat: 42.2843, lng: -85.2293, count: 1}, {lat: 34.6574, lng: -92.5295, count: 1}, {lat: 41.4881, lng: -87.4424, count: 1}, {lat: 25.72, lng: -80.2707, count: 1}, {lat: 34.5873, lng: -118.245, count: 1}, {lat: 35.8278, lng: -78.6421, count: 1}]
            };

        var legend;
        if (opt && opt.legend && opt.legend.element)
            legend = $(opt.legend.element);
        else
            legend = $("#sidebar-left #sidebar_content #heatmap_legend1");

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
        
        var heatmap_legends = $("#sidebar-left #sidebar_content #heatmap_legends");

        var gradient = null;

        gradient = $('#heatmap_gradient input:radio[name=legend_gradient]:checked').attr("data");

        heatmap_legends.empty();

        var legendCanvas = {};
        var legend_select = $("<div id='heatmap_gradient'></div>").appendTo(heatmap_legends);

        var gradientCfg = {};

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
            
            var opt = $("<div style='margin:2px;'><input type='radio' index='" + i + "' data='" + escape(JSON.stringify(g)) + "' name='legend_gradient' style='display:inline-block'><div class='gradient' index='" + i + "' style='margin-left:5px;display:inline-block;width:240px;'> &nbsp;</div></div>");
            if ((i === 0 && !gradient) || (gradient === escape(JSON.stringify(g)))) {

                opt.find("input").attr('checked', 'checked');
            }
            var opt_gradient = opt.find(".gradient");
            opt_gradient.css('background-image', 'url(' + legendCanvas[i].toDataURL() + ')');
            opt_gradient.css('backgroundRepeat', 'no-repeat');
            opt_gradient.css('background-size', 'cover');

            legend_select.append(opt);


        });


        window.legendCanvas = legendCanvas;

        if (typeof gradient === 'string')
            gradient = JSON.parse(unescape(gradient));

        var cfg = {
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
            window.map.removeLayer(window.heatmap_layer);

        $(".leaflet-overlay-pane .leaflet-zoom-hide.heatmap").map(function () {
            $(this).remove();
        });


        var heatmapLayer = new HeatmapOverlay(cfg);
        heatmapLayer.onAdd(window.map);
        //     heatmapLayer.setData(testData);
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
            var value = $("#heatmap input#heatmap_radius_size").data('slider').getValue();
            $("#heatmap input#heatmap_radius_size").data('slider').max = 100 + Math.pow(2, Math.max(1, (11 - zoom))) * 80;
            $("#heatmap input#heatmap_radius_size").slider('setValue', value);
        });

        heatmap_datasource_changed();

        $('#heatmap_gradient input:radio[name=legend_gradient]').change(function () {
            heatmap_gradientchagne(this);
        });

        setTimeout(function () {
            var zoom = window.map.getZoom();
            var value = $("#heatmap input#heatmap_radius_size").data('slider').getValue();
            $("#heatmap input#heatmap_radius_size").data('slider').max = 100 + Math.pow(2, Math.max(1, (11 - zoom))) * 80;
            $("#heatmap input#heatmap_radius_size").slider('setValue', value);
        }, 200);


    };
    $('#heatmap .heatmap_legend input[type=radio]').click(function () {

        var cfg = {"gradient": $(this).attr('data')};

        window.heatmap_layer.cfg['gradient'] = cfg['gradient'];


        var radius = $('#heatmap input.radius-size-slider').data('slider').getValue();

    });
    $('#heatmap .opacity-slider').slider().on('slideStop', function (ev) {
        var newVal = $('#heatmap input.opacity-slider').data('slider').getValue();

        window.heatmap_layer._heatmap.configure({'maxOpacity': parseFloat(newVal) / 100.0});

    });
    $('#heatmap input.radius-size-slider').slider().on('slideStop', function (ev) {

        var radius = $('#heatmap input.radius-size-slider').data('slider').getValue();
        window.heatmap_layer.updateRadius(parseFloat(radius) / 5000.0);

    });
    heatmap_gradientchagne = function () {

        var index = parseInt($('#heatmap_gradient input:radio[name=legend_gradient]:checked').attr("index"));//$("#thematicmap select#thematicmap_gradient option:selected").index();

        var legendCtx = window.legendCanvas[index].getContext('2d');



    };
    heatmap_radiuschagne = function () {
        var radius = $("#heatmap input#heatmap_radius_size").val();
        alert(radius);
        window.heatmap_layer._heatmap.set('radius', radius);
    };
    heatmap_opacitychange = function () {
        var opacity = $("#heatmap input.opacity-slider").val();

        window.heatmap_layer._heatmap.set('opacity', parseFloat(opacity) / 100);
    };
    heatmap_datasource_changed = function () {
        var datasource = $("#heatmap select#heatmap_datasource").val();
        $.ajax({
            url: Routing.generate('default_uploadfilefields'),
            type: 'GET',
            beforeSend: function () {
                window.map.spin(true);
            },
            complete: function () {
                window.map.spin(false);
            },
            error: function () {
                window.map.spin(false);
            },
            //Ajax events
            success: completeHandler = function (response) {
                var result = response;
                if (typeof result !== 'object')
                    result = JSON.parse(result);
                if (result.success !== true) {
                    // if load data not suceess
                    alert(result.message);
                    return;
                }

                $("#heatmap select#heatmap_datafieldname").empty();
                if (result.fields !== undefined && result.fields !== null)
                {
                    for (var i = 0; i < result.fields.length; i++)
                        $("#heatmap select#heatmap_datafieldname").append($("<option></option>").attr("value", result.fields[i]).text(result.fields[i]));
                }

                setTimeout(function () {
                    heatmap_datafieldnamechagne();
                }, 200);
            },
            // Form data
            data: {id: datasource},
            //Options to tell JQuery not to process data or worry about content-type
            cache: false,
            contentType: false
        });
    };
    heatmap_datafieldnamechagne = function () {
        var datasource = $("#heatmap select#heatmap_datasource").val();
        var fieldname = $("#heatmap select#heatmap_datafieldname").val();
        $.ajax({
            url: Routing.generate('default_heatmapdata'),
            type: 'GET',
            beforeSend: function () {
                window.map.spin(true);
            },
            complete: function () {
                window.map.spin(false);
            },
            error: function () {
                window.map.spin(false);
            },
            //Ajax events
            success: completeHandler = function (response) {
                var result = response;
                if (typeof result !== 'object')
                    result = JSON.parse(result);
                if (result.success !== true) {
                    // if load data not suceess
                    alert(result.message);
                    return;
                }


                window.heatmap_layer.setData({min: result.min,
                    max: result.max,
                    data: result.data});
                var radius = $("#heatmap input#heatmap_radius_size").val();
                window.heatmap_layer.updateRadius(parseFloat(radius) / 5000.0);
                if (typeof result.extent === 'string')
                    result.extent = JSON.parse(result.extent);
                var coordinates = result.extent.coordinates[0];
                var southWest = new L.LatLng(coordinates[0][1], coordinates[0][0]);
                var northEast = new L.LatLng(coordinates[2][1], coordinates[2][0]);
                var bounds = new L.LatLngBounds(southWest, northEast);
                window.map_bounds = bounds;
                // alert(JSON.stringify(bounds));

                //   window.map.setView(bounds.getCenter());
                // alert("ok");
            },
            // Form data
            data: {datasource: datasource, datafield: fieldname},
            //Options to tell JQuery not to process data or worry about content-type
            cache: false,
            contentType: false
        });
    };
    HeatmapOverlay.prototype.updateRadius = function (newradius) {


        this.cfg.radius = newradius;
        //  window.heatmap_layer._heatmap._store._cfgRadius = parseFloat(radius) / 5000000000.0;
        //    window.heatmap_layer._heatmap.configure();


        var data = this._data;
        var min = data.min;
        var max = data.max;
        var clonedArray = $.map(data, function (obj) {

            return  {lat: obj.latlng.lat, lng: obj.latlng.lng, count: obj['count'], radius: newradius};
        });
        //      alert(min + "," + max + "," +newdata.length);
        //   $.extend([],window.heatmap_layer._heatmap._store._getInternalData());
        //   window.heatmap_layer._heatmap.updateRadius(parseFloat(radius) / 50.0);
        //    window.heatmap_layer._heatmap._renderer._clear();

        this.setData({min: min, max: max, data: clonedArray});
    };
    createHeatMapLayer({});

}(this, document));