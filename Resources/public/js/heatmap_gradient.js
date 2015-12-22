/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function addHeatmapGradient() {
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
    $("#heatmap_gradient_form #heatmapgradient option").map(function() {
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
    $("#heatmap_gradient_form input.gradient_number").map(function(i) {

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
    var gradient_number = $("#heatmap_gradient_form input.gradient_number").map(function() {

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
    $("#heatmap_gradient_form #heatmapgradient option:selected").map(function() {
        var opt_value = $(this).val();
        if (typeof opt_value === 'string')
            opt_value = JSON.parse(opt_value);
        var sorted_gradient_number = opt_value['gradient'];
        $("#heatmap_gradient_form #gradient_name").val(opt_value['name']);
        setHeatmapGradient(sorted_gradient_number);
    });
}
function sortHeatmapGradient(gradient_number) {
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
    $("#heatmap_gradient_form #heatmapgradient option:selected").map(function() {
        var opt_text = $(this).text();
        var result = confirm("Are you sure you want to delete " + opt_text + "?");
        if (result) {
            $(this).remove();
        }
    });
}
function updateHeatmapGradient() {
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
    $("#heatmap_gradient_form #heatmapgradient option").map(function() {
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
    $("#heatmap_gradient_form #heatmapgradient option").map(function() {
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
    $("#heatmap_gradient_form").submit();
}
function heatmap_gradient_minicolors() {

    $("#heatmap_gradient_form #gradient_color").minicolors({
        control: $(this).attr('data-control') || 'hue',
        defaultValue: $(this).attr('data-defaultValue') || '',
        inline: $(this).attr('data-inline') === 'true',
        letterCase: $(this).attr('data-letterCase') || 'lowercase',
        opacity: $(this).attr('data-opacity'),
        position: $(this).attr('data-position') || 'bottom left',
        change: function(hex, opacity) {
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
    $("#heatmap_gradient_form").unbind('submit').submit(function(e)
    {
        e.preventDefault();
        var formData = new FormData($('#heatmap_gradient_form')[0]);
        e.preventDefault();
        var formData = new FormData($('#heatmap_gradient_form')[0]);
        var data = $("#heatmap_gradient_form #heatmapgradient option").map(function() {

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
            xhr: function() {
                var map2uXhr = $.ajaxSettings.xhr();
                if (map2uXhr.upload) {
                    //   map2uXhr.upload.addEventListener('progress', setProgress, false);
                }
                return map2uXhr;
            },
            complete: function() {
//                $('body').css('cursor', 'default');
//                $(".progressbar").hide();
            },
            success: function(data) {
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