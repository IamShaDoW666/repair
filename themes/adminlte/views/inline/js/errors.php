(function($){ 
    "use strict"; 
    $(document).ready(function () {

    var oTable = $('#dynamic-table').dataTable({
        "aaSorting": [[3, "asc"]],
        "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        "iDisplayLength": parseInt(site.settings.rows_per_page),
        'bProcessing': true, 'bServerSide': true,
        'sAjaxSource': site.base_url + 'panel/errors/getAllErrors',
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
        ],
    });
    });



    jQuery(document).on("click", "#delete_error", function () {
    var num = jQuery(this).data("num");
    bootbox.confirm({
        message: "Are you sure!",
        buttons: {
            cancel: {
                label: '<i class="fa fa-times"></i> Cancel'
            },
            confirm: {
                label: '<i class="fa fa-check"></i> Confirm'
            }
        },
        callback: function (result) {
            if (result) {
                jQuery.ajax({
                    type: "POST",
                    url: base_url + "panel/errors/delete",
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
                        toastr['success'](lang.deleted + ": ", lang.error_deleted);
                        $('#dynamic-table').DataTable().ajax.reload();
                    }
                });

            }
        }
    });

    });

        jQuery(document).on("click", ".add_error", function (e) {
            $('#errormodal').modal('show');
            $('#error_form').trigger("reset");
            $('#error_form').parsley().reset();

            jQuery('#title_error').html(lang.add + " " + lang.reparation_error);
            jQuery('#footerError').html('<button data-dismiss="modal" class="pull-left btn btn-default" type="button"><i class="fa fa-reply"></i> '+lang.go_back+'</button><button role="button" form="error_form" id="error_submit" class="btn btn-success" data-mode="add"><i class="fa fa-user"></i> '+ lang.add  + " " + lang.reparation_error +'</button>');
        });

        jQuery(document).on("click", "#modify_error", function () {
                jQuery('#title_error').html(lang.edit + " " + lang.reparation_error);
                var num = jQuery(this).data("num");
                $('#error_form').trigger("reset");
                $('#error_form').parsley().reset();

                jQuery.ajax({
                    type: "POST",
                    url: base_url + "panel/errors/getErrorByID",
                    data: "id=" + encodeURI(num) + "&token=" + token,
                    cache: false,
                    dataType: "json",
                    success: function (data) {
                        jQuery('#error_code').val(data.code);
                        jQuery('#error_defect').val(data.defect);
                        jQuery('#error_reason').val(data.reason);
                        jQuery('#error_description').val(data.description)

                        jQuery('#footerError').html('<button data-dismiss="modal" class="pull-left btn btn-default" type="button"><i class="fa fa-reply"></i> '+lang.go_back+'</button><button id="error_submit" role="button" form="error_form" class="btn btn-success" data-mode="modify" data-num="' + encodeURI(num) + '"><i class="fa fa-save"></i> ' + lang.save + ' ' + lang.reparation_error +'</button>')
                    }
                });
            });

    $(function () {
        $('#error_form').parsley({
            errorsContainer: function(pEle) {
                var $err = pEle.$element.closest('.form-group');
                return $err;
            }
        }).on('form:submit', function(event) {
            var mode = jQuery('#error_submit').data("mode");
            var id = jQuery('#error_submit').data("num");

            var error_defect = jQuery('#error_defect').val();

            var url = "";
            var formData = new FormData($('form#error_form')[0]);
            if (mode == "add") {
                url = base_url + "panel/errors/add";
                jQuery.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    async: false,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        toastr['success'](lang.add,lang.reparation_error + " "  + name  + lang.added);
                        if (data.error) {
                            toastr['error'](data.error);
                        }
                        setTimeout(function () {
                            $('#errormodal').modal('hide');
                            $('#dynamic-table').DataTable().ajax.reload();
                        }, 500);
                    }
                });
            } else {
                formData.append('id', id);
                url = base_url + "panel/errors/edit";
                jQuery.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    async: false,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        toastr['success'](lang.edit, lang.reparation_error + ": " + name  +lang.updated);
                        if (data.error) {
                            toastr['error'](data.error);
                        }
                        setTimeout(function () {
                            $('#errormodal').modal('hide');
                            $('#dynamic-table').DataTable().ajax.reload();
                        }, 500);
                    }
                });
            }
            return false;
        });
    });
})(jQuery); 
