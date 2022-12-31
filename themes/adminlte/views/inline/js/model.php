(function($){ 
    "use strict"; 
    $(document).ready(function () {
        var oTable = $('#dynamic-table').dataTable({
            "aaSorting": [[0, "asc"]],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "iDisplayLength": parseInt(site.settings.rows_per_page),
            'bProcessing': true, 'bServerSide': true,
            'sAjaxSource': site.base_url + 'panel/inventory/getAllModels',
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
            ],
        });
    });


    jQuery(document).on("click", "#delete", function () {
    var num = jQuery(this).data("num");
    jQuery.ajax({
        type: "POST",
        url: base_url + "panel/inventory/delete_model",
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
            toastr['success'](lang.deleted + ": ", lang.model_deleted);
            $('#dynamic-table').DataTable().ajax.reload();
        }
    });
    });

    jQuery(document).on("click", "#modify_model", function () {
    let num = $(this).data('num');
    jQuery.ajax({
        type: "POST",
        url: base_url + "panel/inventory/getModelByID",
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
                    title: lang.input_model_name,
                    value: data.name,
                    backdrop: true,
                    callback: function(result) {
                        if (result){
                            jQuery.ajax({
                                type: "POST",
                                url: base_url + "panel/inventory/edit_model",
                                data: "id=" + encodeURI(num) + "&name=" + encodeURI(result),
                                cache: false,
                                dataType: "json",
                                success: function (data) {
                                    if (data.success) {
                                        toastr.success(lang.model_edited);
                                    }
                                    $('#dynamic-table').DataTable().ajax.reload();
                                }
                            });
                        }
                    }
                });
            }
        }
    });
    });
})(jQuery); 
