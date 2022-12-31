$( document ).ready(function() {
    jQuery(document).on("click", "#print_button", function() {
        window.print();
        setInterval(function() {
            window.close();
        }, 500);
    });

    setTimeout(function() {
        window.print();
    }, 3000);
    window.onafterprint = function(){
        setTimeout(function() {
            window.close();
        }, 10000);
    }

    function auto_grow(element) {
        element.style.height = "5px";
        element.style.height = (element.scrollHeight)+"px";
    }
    auto_grow(document.getElementById("comment"));
});


jQuery("#reset_sign").on("click", function (e) {
    $("#signature").jSignature('reset');
});
jQuery("#submit_sign").on("click", function (e) {
    var datapair = $('#signature').jSignature("getData", 'base30');
    datapair = 'data='+(datapair[1])+'&id=' + $(this).attr('data-num');
    jQuery.ajax({
        type: "POST",
        url: base_url + "panel/misc/save_invoice_signature",
        data: datapair,
        cache: false,
        success: function (data) {
            location.reload();
        }
    });
});

$(document).ready(function() {
    if(document.getElementById('signature')) {
        $("#signature").jSignature();
    }
});