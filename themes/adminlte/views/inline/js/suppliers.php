(function($){ 
    "use strict"; 
    $(document).ready(function () {
    var oTable = $('#dynamic-table').dataTable({
        "aaSorting": [[3, "asc"]],
        "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        "iDisplayLength": parseInt(site.settings.rows_per_page),
        'bProcessing': true, 'bServerSide': true,
        'sAjaxSource': site.base_url + 'panel/inventory/getAllSuppliers',
        'fnServerData': function (sSource, aoData, fnCallback) {
            aoData.push({
                "name": get_csrf_token_name,
                "name": get_csrf_hash
            });
            $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
        }, 
        "aoColumns": [
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        ],
        
    });
            
});


jQuery(document).on("click", "#delete", function () {
    var num = jQuery(this).data("num");
    jQuery.ajax({
        type: "POST",
        url: base_url + "panel/inventory/delete_supplier",
        data: "id=" + encodeURI(num),
        cache: false,
        dataType: "json",
        success: function (data) {
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "progressBar": true,
                "positionClass": "toast-bottom-right",
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }

            toastr['success'](lang.deleted, lang.supplier_deleted);
            $('#dynamic-table').DataTable().ajax.reload();
        }
    });
});

jQuery(document).on("click", ".view_supplier", function () {
    var num = jQuery(this).data("num");
    find_supplier(num);

});

if (getUrlVars()["id"]) {
    find_supplier(getUrlVars()["id"]);
    $('#view_supplier').modal('show');
}


jQuery(".add_supplier").on("click", function (e) {
    $('#suppliermodal').modal('show');

    $('#suppliers_form').trigger("reset");
    $('#suppliers_form').parsley().reset();

    jQuery('#titsupplieri').html(`${lang.add} ${lang.supplier_title}`);

    jQuery('#footersupplier1').html(`<button data-dismiss="modal" class="pull-left btn btn-default" type="button"><i class="fa fa-reply"></i> ${lang.go_back}</button><button id="submit_supplier" role="button" form="suppliers_form" class="btn btn-success" data-mode="add"><i class="fa fa-user"></i> ${lang.add} ${lang.supplier_title}</button>`);
});

jQuery(document).on("click", "#modify_supplier", function () {
    jQuery('#titsupplieri').html(`${lang.edit} ${lang.supplier_title}`);
    var num = jQuery(this).data("num");
    jQuery.ajax({
            type: "POST",
            url: base_url + "panel/inventory/getSupplierByID",
            data: "id=" + encodeURI(num) + "&token=" + token,
            cache: false,
            dataType: "json",
            success: function (data) {
                $('#suppliers_form').trigger("reset");
                $('#suppliers_form').parsley().reset();
                jQuery('#suppliers_name').val(data.name);
                jQuery('#suppliers_company').val(data.company);
                jQuery('#suppliers_address').val(data.address);
                jQuery('#suppliers_city').val(data.city)
                jQuery('#suppliers_country').val(data.country);
                jQuery('#suppliers_state').val(data.state)
                jQuery('#suppliers_postal_code').val(data.postal_code);
                jQuery('#suppliers_phone').val(data.phone);
                jQuery('#suppliers_email').val(data.email);
                jQuery('#suppliers_vat_no').val(data.vat_no);


                jQuery('#footersupplier1').html(`<button data-dismiss="modal" class="pull-left btn btn-default" type="button"><i class="fa fa-reply"></i> ${lang.go_back}</button><button id="submit_supplier" role="button" form="suppliers_form" class="btn btn-success" data-mode="modify" data-num="${encodeURI(num)}"><i class="fa fa-user"></i> ${lang.save} ${lang.supplier_title}</button>`);
            }
        });
    });

$('#suppliers_form').parsley({
    errorsContainer: function(pEle) {
        var $err = pEle.$element.closest('.form-group');
        return $err;
    }
    }).on('form:submit', function(event) {
    var mode = jQuery('#submit_supplier').data("mode");
    var id = jQuery('#submit_supplier').data("num");
    var name = jQuery('#suppliers_name').val();
    var company = jQuery('#suppliers_company').val();
    var url = "";
    var dataString = "";

    if (mode == "add") {
        url = base_url + "panel/inventory/add_supplier";
        dataString = $('#suppliers_form').serialize();
        jQuery.ajax({
            type: "POST",
            url: url,
            data: dataString,
            cache: false,
            success: function (data) {
                toastr['success'](lang.edit, lang.supplier_title + " " + name + " " + company + " " + lang.added);
                setTimeout(function () {
                    $('#suppliermodal').modal('hide');
                    find_supplier(data);
                    $('#dynamic-table').DataTable().ajax.reload();
                    $('#view_supplier').modal('show');
                }, 500);
            }
        });
    } else {
        url = base_url + "panel/inventory/edit_supplier";
        dataString = $('#suppliers_form').serialize() + "&id=" + encodeURI(id);
        jQuery.ajax({
            type: "POST",
            url: url,
            data: dataString,
            cache: false,
            success: function (data) {
                
                toastr['success'](lang.edit, lang.supplier_title + ": " + name + " " + company + lang.updated);
                setTimeout(function () {
                    $('#suppliermodal').modal('hide');
                    find_supplier(id);
                    $('#dynamic-table').DataTable().ajax.reload();
                    $('#view_supplier').modal('show');

                }, 500);
            }
        });
    }
    return false;
});

function getUrlVars() {
var vars = {};
var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function (m, key, value) {
    vars[key] = value;
});
return vars;
}
function find_supplier(num) {
    jQuery.ajax({
        type: "POST",
        url: base_url + "panel/inventory/getSupplierByID",
        data: "id=" + encodeURI(num) + "&token=" + token,
        cache: false,
        dataType: "json",
        success: function (data) {
            if (typeof data.name === 'undefined') {
                $('#view_supplier').modal('hide');
                toastr['error'](lang.no + " " + lang.supplier_title, '');
            } else {
                jQuery('#titlesupplier').html(lang.supplier_title + ': ' + data.name);
                jQuery( ".flatb.add" ).data( "name", data.name+' '+data.company);
                jQuery( ".flatb.add" ).data( "id_name", data.id);
                jQuery( ".flatb.lista" ).data( "name", data.name+' '+data.company);
                jQuery('#vs_name').html(data.name);
                jQuery('#vs_company').html(data.company);
                jQuery('#vs_address').html(data.address);
                jQuery('#vs_city').html(data.city)
                jQuery('#vs_country').html(data.country);
                jQuery('#vs_state').html(data.state)
                jQuery('#vs_postal_code').html(data.postal_code);
                jQuery('#vs_phone').html(data.phone);
                jQuery('#vs_email').html(data.email);
                jQuery('#vs_vat_no').html(data.vat_no);

                var string = "<button data-dismiss=\"modal\" class=\"btn btn-default\" type=\"button\"><i class=\"fa fa-reply\"></i> "+lang.go_back+"</button>";

                <?php if($this->Admin || $GP['inventory-delete_supplier']): ?>
                    string += "<button id=\"delete\" data-dismiss=\"modal\" data-num=\"" + encodeURI(num) + "\" class=\"btn btn-danger\" type=\"button\"><i class=\"fa fa-trash-o \"></i> "+lang.delete+"</button>";
                <?php endif; ?>
                <?php if($this->Admin || $GP['inventory-edit_supplier']): ?>
                    string += "<button data-dismiss=\"modal\" id=\"modify_supplier\" href=\"#suppliermodal\" data-toggle=\"modal\" data-num=\"" + encodeURI(num) + "\" class=\"btn btn-success\"><i class=\"fa fa-pencil\"></i>"+lang.modify+"</button>";
                <?php endif; ?>


                jQuery('#footersupplier').html(string);
            }
        }
    });
}


})(jQuery); 