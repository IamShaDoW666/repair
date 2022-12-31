(function($){ 
    "use strict"; 
    $(document).ready(function () {
        var oTable = $('#dynamic-table').dataTable({
            "aaSorting": [[0, "asc"]],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "iDisplayLength": parseInt(site.settings.rows_per_page),
            'bProcessing': true, 'bServerSide': true,
            'sAjaxSource': site.base_url + 'panel/inventory/getAllManufacturers',
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
            ],
        });
    });


    jQuery(document).on("click", "#delete", function () {
        var num = jQuery(this).data("num");
        jQuery.ajax({
            type: "POST",
            url: base_url + "panel/inventory/delete_manufacturer",
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
                if (data.success) {
                    toastr['success'](lang.manufacturer_deleted);
                }else{
                    toastr['error'](lang.manufacturer_deleted_error);
                }
                $('#dynamic-table').DataTable().ajax.reload();
            }
        });


    });


    jQuery(document).on("click", ".add_manufacturer", function () {
        bootbox.prompt({
            title:lang.input_manufacturer_name,
            callback: function(result) {
            if (result) {
                submit_manufacturer(result, null)
            }
            }
        });
    });

        jQuery(document).on("click", "#modify_manufacturer", function () {
        let num = $(this).data('num');
        jQuery.ajax({
            type: "POST",
            url: base_url + "panel/inventory/getManufacturerByID",
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
                if (data) {
                    bootbox.prompt({
                        title: lang.input_manufacturer_name,
                        value: data.name,
                        callback: function(result) {
                        if (result) {
                            submit_manufacturer(result, data.id)
                        }
                        }
                    });
                }
            }
        });
    });

    function submit_manufacturer(name, id = false) {
        let url = "";
        if (id) {
            url = base_url + "panel/inventory/edit_manufacturer";
        }else{
            url = base_url + "panel/inventory/add_manufacturer";
        }

        jQuery.ajax({
            type: "POST",
            url: url,
            data: "id=" + encodeURI(id) + "&name=" + encodeURI(name),
            cache: false,
            dataType: "json",
            success: function (data) {
                if (id) {
                    if (data.success) {
                        toastr.success(lang.manufaturer_edited);
                    }else{
                        toastr.success(lang.manufaturer_edited_error);
                    }
                }else{
                    if (data.success) {
                        toastr.success(lang.manufaturer_added);
                    }else{
                        toastr.success(lang.manufaturer_added_error);
                    }
                }
                $('#dynamic-table').DataTable().ajax.reload();
            }
        });
    }
})(jQuery); 

