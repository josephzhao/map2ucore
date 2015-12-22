/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function saveMapBookmark() {
    if (window.map === undefined)
        return;
    var map_center = window.map.getCenter();
    var map_zoomlevel = window.map.getZoom();

    var name = prompt("Please enter bookmark name", "Bookmark ");
    if (name === null || name === '' || name === undefined)
        return;


    var formData = new FormData($('#map_bookmark_manage_id')[0]);
    formData.append('center', map_center.lat.toFixed(6) + "," + map_center.lng.toFixed(6));
    formData.append('zoom', map_zoomlevel);
    formData.append('name', name);

    $.ajax({
        url: Routing.generate('create_bookmark'),
        type: 'POST',
        //Ajax events
        success: completeHandler = function(response) {
            var map_bookmarks_list = document.getElementById('map_bookmarks_list');
            $('select#map_bookmarks_list').empty();
            var bookmarks;
            if (typeof response !== 'object')
                response = JSON.parse(response);


            if (typeof response.bookmarks !== 'object')
                bookmarks = JSON.parse(response.bookmarks);
            else
                bookmarks = response.bookmarks;

            for (var i = 0; i < bookmarks.length; i++)
            {
                var selectBoxOption = document.createElement("option"); //create new option 
                selectBoxOption.value = bookmarks[i].id + "," + bookmarks[i].lat + "," + bookmarks[i].lng + "," + bookmarks[i].zoomlevel; //set option value 
                selectBoxOption.text = bookmarks[i].name;
                map_bookmarks_list.add(selectBoxOption, null);
            }
        },
        error: errorHandler = function(response) {
            alert(JSON.stringify(response));
        },
        cache: false,
        contentType: false,
        processData: false,
        data: formData
    });

}
function updateMapBookmark() {
    var selected_options = $("select#map_bookmarks_list option:selected").map(function() {
        return  this.text;
    });
    if (selected_options.length === 0)
    {
        alert("Bookmark must be selected first!");
        return;
    }
    var name = prompt("Please enter new bookmark name", selected_options[0]);
    if (name === null || name === '' || name === undefined)
        return;
    var selected_options_value = $("select#map_bookmarks_list option:selected").map(function() {
        return  this.value;
    });
    if (window.map === undefined)
        return;

    var data = selected_options_value[0].split(",");

    var formData = new FormData($('#map_bookmark_manage_id')[0]);
    formData.append('id', data[0]);

    formData.append('name', name);

    $.ajax({
        url: Routing.generate('update_bookmark'),
        type: 'POST',
        //Ajax events
        success: completeHandler = function(response) {
            var map_bookmarks_list = document.getElementById('map_bookmarks_list');
            $('select#map_bookmarks_list').empty();
            var bookmarks;
            if (typeof response !== 'object')
                response = JSON.parse(response);

            if (typeof response.bookmarks !== 'object')
                bookmarks = JSON.parse(response.bookmarks);
            else
                bookmarks = response.bookmarks;
            for (var i = 0; i < bookmarks.length; i++)
            {
                var selectBoxOption = document.createElement("option"); //create new option 
                selectBoxOption.value = bookmarks[i].id + "," + bookmarks[i].lat + "," + bookmarks[i].lng + "," + bookmarks[i].zoomlevel; //set option value 
                selectBoxOption.text = bookmarks[i].name;
                map_bookmarks_list.add(selectBoxOption, null);
            }
        },
        error: errorHandler = function(response) {
            alert(JSON.stringify(response));
        },
        cache: false,
        contentType: false,
        processData: false,
        data: formData
    });

}
function deleteMapBookmark() {
    var selected_options = $("select#map_bookmarks_list option:selected").map(function() {
        return  this.value;
    });
    if (selected_options.length === 0)
    {
        alert("Bookmark must be selected first!");
        return;
    }
    var selected_options_text = $("select#map_bookmarks_list option:selected").map(function() {
        return  this.text;
    });
    var r = confirm(selected_options_text[0] + "\n" + "Area you sure you want to delete this bookmark?");
    if (r !== true) {
        return;
    }
    var data = selected_options[0].split(",");
    var formData = new FormData($('#map_bookmark_manage_id')[0]);
    formData.append('id', data[0]);

    $.ajax({
        url: Routing.generate('delete_bookmark'),
        type: 'POST',
        //Ajax events
        success: completeHandler = function(response) {

            var bookmarks;
            var map_bookmarks_list = document.getElementById('map_bookmarks_list');
            if (typeof response !== 'object')
                response = JSON.parse(response);
            $('select#map_bookmarks_list').empty();
            if (typeof response.bookmarks !== 'object')
                bookmarks = JSON.parse(response.bookmarks);
            else
                bookmarks = response.bookmarks;
            for (var i = 0; i < bookmarks.length; i++)
            {

                var selectBoxOption = document.createElement("option"); //create new option 
                selectBoxOption.value = bookmarks[i].id + "," + bookmarks[i].lat + "," + bookmarks[i].lng + "," + bookmarks[i].zoomlevel; //set option value 
                selectBoxOption.text = bookmarks[i].name;
                map_bookmarks_list.add(selectBoxOption, null);
            }
        },
        error: errorHandler = function(response) {

            alert(JSON.stringify(response));
        },
        cache: false,
        contentType: false,
        processData: false,
        data: formData
    });

}
function showMapBookmark() {
    var selected_options = $("select#map_bookmarks_list option:selected").map(function() {
        return  this.value;
    });
    if (selected_options.length === 0)
    {
        alert("Bookmark must be selected first!");
        return;
    }
    if (window.map === undefined)
        return;


    var data = selected_options[0].split(",");


    window.map.setView([data[1], data[2]], data[3]);
}

function setDefaultMapBookmark() {
    var selected_options = $("select#map_bookmarks_list option:selected").map(function() {
        return  this.value;
    });
    if (selected_options.length === 0)
    {
        alert("Bookmark must be selected first!");
        return;
    }
    var data = selected_options[0].split(",");
    var formData = new FormData($('#map_bookmark_manage_id')[0]);
    formData.append('id', data[0]);


    $.ajax({
        url: Routing.generate('default_bookmark'),
        type: 'POST',
        //Ajax events
        success: completeHandler = function(response) {
            if (typeof response !== 'object')
                response = JSON.parse(response);

            alert(response.message);
        },
        error: errorHandler = function(response) {
            alert(JSON.stringify(response));
        },
        cache: false,
        contentType: false,
        processData: false,
        data: formData
    });

}

function maptoolbar_init(w) {
    $(".navbar-maptoolbar li").click(function() {
        if (typeof $(this).attr('function') === "function") {
            alert("function");
        }
        if ($(this).attr('function') !== undefined && $(this).attr('function') !== null) {
            var toolbar_function = $(this).attr('function');
            eval(toolbar_function);
        }

    });

    function mapHomeExtent() {
        w.map.setView([43.73737, -79.95987], 10);
    }
    function mapPrevExtent() {

        //      var backDisabled = (this._state.history.items.length === 0);
        //         var forwardDisabled = (this._state.future.items.length === 0);
        //   alert("future=" + w.historyControl._state.future.items.length);
        //   alert("history=" + w.historyControl._state.history.items.length);

        w.historyControl.goBack();
    }
    function mapNextExtent() {
        w.historyControl.goForward();
    }
    function toogleLeftSidebarPane() {
        setTimeout(function() {
            w.leftSidebar.toggle();
        }, 500);
    }
    function toogleChartBarPane() {

    }
    function mapZoom_in() {
        w.map.zoomIn();
    }
    function mapZoom_out() {
        w.map.zoomOut();
    }

    function leaflet_drawpolyline() {

    }
    function heatmap_pane() {
        w.map.spin(true);
        $.ajax({
            url: Routing.generate("default_heatmapform"),
            method: 'GET',
            complete:function() {
                w.map.spin(false);
            },
            success: function(html) {
                $("#sidebar-left #sidebar_content").html(html);
             //   heatmap_gradient_minicolors();
             //   heatmap_gradient_submit();
            }
        });
    }
    function leaflet_drawpolygone() {
    }

    function leaflet_drawrectangle() {
    }

    function leaflet_drawcircle() {
    }

    function leaflet_drawmarker() {
    }

    function leaflet_drawedit_edit() {
    }

    function leaflet_drawedit_remove() {
    }
    function leaflet_draw() {
        $(".leaflet-draw.leaflet-control").toggle();
    }
    function leaflet_map_print() {

        // alert( $("#leafmap").html());
//        var divContents = $("#leafmap").html();
//        var width=$("#leafmap").width();
//        var height=$("#leafmap").height();
//            var printWindow = window.open('', '', 'height='+height+','+'width='+width);
//            printWindow.document.write('<html><head><title>DIV Contents</title>');
//            printWindow.document.write('</head><body >');
//            printWindow.document.write(divContents);
//            printWindow.document.write('</body></html>');
//            printWindow.document.close();
//            printWindow.print();
//        html2canvas($("#leafmap"), {
//            onrendered: function(canvas) {
//                var printWindow = window.open('', '', 'height=1400,width=1400');
//                 $styles = $("style, link, meta");
//                
//            printWindow.document.write('<html><head><title>DIV Contents</title>');
//            printWindow.document.write($styles.clone().html());
//            printWindow.document.write('</head><body >');
//            printWindow.document.body.appendChild(canvas);
//            printWindow.document.write('</body></html>');
//            printWindow.document.close();
//            printWindow.print();
//          //  printWindow.close();
//    //            document.body.appendChild(canvas);
//            }
//        });

//  html2canvas(document.body, {
//            onrendered: function(canvas) {
//                document.body.appendChild(canvas);
//            }
//        });



        $("#leafmap").print({
            globalStyles: true // Use Global styles
            , noPrintSelector: ".noprint"

        });
    }
    function map_locate() {
        if (w.lc._active)
            w.lc.stopLocate();
        else
            w.lc.locate();
    }
    w.map.on('historyback', function() {
        if (w.historyControl._state.backDisabled) {
            $(".map_history_goback").addClass('disabled');
        }
        else {
            $(".map_history_goback").removeClass('disabled');
        }

    });
    w.map.on('historyforward', function() {
        if (w.historyControl._state.forwardDisabled) {
            $(".map_history_forward").addClass('disabled');
        }
        else {
            $(".map_history_forward").removeClass('disabled');
        }
    });
    w.map.on('movestart', function(e) {
        if (w.historyControl._state.backDisabled) {
            $(".map_history_goback").addClass('disabled');
        }
        else {
            $(".map_history_goback").removeClass('disabled');
        }
        if (w.historyControl._state.forwardDisabled) {
            $(".map_history_forward").addClass('disabled');
        }
        else {
            $(".map_history_forward").removeClass('disabled');
        }
    });
}
