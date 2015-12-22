/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {
    $(window).resize(function () { /* do something */

        $('div#mapoverlayselectionlist').height($(window).height() - 278);
        $('div.dataTables_scrollBody').height($(window).height() - 345);
    });
    var table = $('#table_mapoverlayselectionlist').DataTable({
//        "columnDefs": [{
//                "targets": [1],
//                "visible": false
//            }],
        "scrollY": "300px",
        "sScrollX": '100%',
        //   "scrollX": true,
        "paging": false
    });
    $('#table_mapoverlayselectionlist tbody').on('click', 'tr', function () {
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
        }
        else {
            table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    });
    $('a.toggle-vis').on('click', function (e) {
        e.preventDefault();
        // Get the column API object
        var column = table.column($(this).attr('data-column'));
        // Toggle the visibility
        column.visible(!column.visible());
    });
    //<li><a href="#" class="delete">Delete</a></li>
    var tag = $('<div class="tag"><ul><li><a href="#" class="addto_map">Add To Map</a></li></ul></div>');
    tag.insertBefore($("div.dataTables_filter#table_mapoverlayselectionlist_filter"));

    $("#mapoverlayselection .tag .addto_map").click(function () {
         var bExist=false;
        var tr_text = $('#table_mapoverlayselectionlist tbody tr.selected').map(function () {
            return {id: $(this).attr("data-id"), type: $(this).attr("data-type")};
        });
        if (tr_text.length === 0)
        {
            alert("you have to select a layer source first!");
            return;
        }

        window.map.dataLayers.forEach(function (layer,i) {
            var tt = tr_text;
            if (parseInt(layer.layerId) === parseInt(tt[0].id) && tt[0].type === layer.layerType) {
                $('div.sidebar_content div.section.overlay-layers ul > li').map(function () {
                    if ($(this).data("index") === i) {
                        $(this).trigger('click');
                    }
                });
                bExist=true;
                alert("The layer you selected is alreday in overlay list!");
                return;
            }
        });
        if(bExist===false)
            window.layersControl.loadLayerInfoFromSource(tr_text[0].id,tr_text[0].type);
        
        
        
    });
    $("#mapoverlayselection .tag .delete").click(function () {

    });
    $(window).resize();
});
