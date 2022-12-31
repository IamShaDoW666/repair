(function($){ 
    "use strict"; 
    function type(x) {
        if (x == 1) {
            return lang.percentage;
        }
        if (x == 2) {
            return lang.fixed;
        }
    }
    $(document).ready(function () {
        var oTable = $('#dynamic-table').dataTable({
            "aaSorting": [[0, "asc"]],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "iDisplayLength": parseInt(site.settings.rows_per_page),
            'bProcessing': true, 'bServerSide': false,
            'sAjaxSource': site.base_url + 'panel/settings/tax_rates/getAll',
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
                {"mRender": type },
                null,
            ],
        });
                
    });


    jQuery(document).on("click", "#delete", function () {
        var num = jQuery(this).data("num");
        jQuery.ajax({
            type: "POST",
            url: base_url + "panel/settings/tax_rates/delete",
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
                toastr['success'](lang.deleted + ": ",lang.taxrate_deleted);
                $('#dynamic-table').DataTable().ajax.reload();
            }
        });
    });


    jQuery(".add_taxrate").on("click", function (e) {
        $('#taxmodal').modal('show');
        $('#tax_form').trigger("reset");
        $('#tax_form').parsley().reset();
        jQuery('#titsupplieri').html(lang.add + " " + lang.taxrate_title);
        jQuery('#footertaxrate').html(`<button data-dismiss="modal" class="pull-left btn btn-default" type="button"><i class="fa fa-reply"></i>${lang.go_back}</button><button id="submit_taxrate" class="btn btn-success" role="submit" form="tax_form" data-mode="add"><i class="fa fa-plus"></i> ${lang.add}</button>`);
    });

    jQuery(document).on("click", "#modify_tax", function () {
        jQuery('#titsupplieri').html(`${lang.edit} ${lang.tax_rate}`);
        $('#tax_form').trigger("reset");
        $('#tax_form').parsley().reset();
        var num = $(this).data('num');
        jQuery.ajax({
            type: "POST",
            url: base_url + "panel/settings/tax_rates/byID",
            data: "id=" + encodeURI(num) + "&token=" + token,
            cache: false,
            dataType: "json",
            success: function (data) {
                jQuery('#tax_name').val(data.name);
                jQuery('#tax_code').val(data.code);
                jQuery('#tax_rate').val(data.rate);
                jQuery('#tax_type').val(data.type)
                jQuery('#footertaxrate').html('<button data-dismiss="modal" class="pull-left btn btn-default" type="button"><i class="fa fa-reply"></i> '+lang.go_back+'</button><button id="submit_taxrate" class="btn btn-success" data-mode="modify" role="submit" form="tax_form" data-num="' + encodeURI(num) + '"><i class="fa fa-save"></i> '+lang.save+'</button>')
            }
        });
    });


    $(function () {
        $('#tax_form').parsley({
            errorsContainer: function(pEle) {
                var $err = pEle.$element.closest('.form-group');
                return $err;
            }
        }).on('form:submit', function(event) {
            var mode = jQuery('#submit_taxrate').data("mode");
            var id = jQuery('#submit_taxrate').data("num");

            var name = jQuery('#tax_name').val();
            var code = jQuery('#tax_code').val();
            var rate = jQuery('#tax_rate').val();
            var type = jQuery('#tax_type').val();

            var url = "";
            var dataString = $('#tax_form').serialize();

            if (mode == "add") {
                url = base_url + "panel/settings/tax_rates/add";
                jQuery.ajax({
                    type: "POST",
                    url: url,
                    data: dataString,
                    cache: false,
                    success: function (data) {
                        toastr['success'](lang.add, lang.taxrate_title + ": " + name + lang.added);
                        
                        setTimeout(function () {
                            $('#taxmodal').modal('hide');
                            find(data);
                            $('#dynamic-table').DataTable().ajax.reload();
                        }, 500);
                    }
                });
            } else {
                url = base_url + "panel/settings/tax_rates/edit";
                dataString =  dataString + "&id=" + encodeURI(id);
                jQuery.ajax({
                    type: "POST",
                    url: url,
                    data: dataString,
                    cache: false,
                    success: function (data) {
                        toastr['success'](lang.save,  lang.taxrate_title + ': ' + name +  " " + lang.updated);

                        setTimeout(function () {
                            $('#taxmodal').modal('hide');
                            find(id);
                            $('#dynamic-table').DataTable().ajax.reload();
                        }, 500);
                    }
                });
            }
            return false;
        });
    });

})(jQuery); 