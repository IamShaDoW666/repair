(function($){ 
    "use strict"; 
    $(document).ready(function () {
        var oTable = $('#dynamic-table').dataTable({
            "aaSorting": [[0, "asc"]],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "iDisplayLength": parseInt(site.settings.rows_per_page),
            'bProcessing': true, 'bServerSide': false,
            'sAjaxSource': site.base_url + 'panel/settings/getSMSGateways',
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


        $('#smsgateway_form').parsley({
          errorsContainer: function(pEle) {
              var $err = pEle.$element.closest('.form-group');
              return $err;
          }
      }).on('form:submit', function(event) {
        var mode = jQuery('#submit_smsgateway').data("mode");
        var id = jQuery('#submit_smsgateway').data("num");

        var name = jQuery('#smsgateway_name').val();
        var code = jQuery('#smsgateway_code').val();
        var rate = jQuery('#smsgateway_rate').val();
        var type = jQuery('#smsgateway_type').val();

        var url = "";
        var dataString = $('#smsgateway_form').serialize();

        if (mode == "add") {
            url = base_url + "panel/settings/add_smsgateway";
            jQuery.ajax({
                type: "POST",
                url: url,
                data: dataString,
                cache: false,
                success: function (data) {
                    toastr['success'](lang.add, lang.smsgateway + ": " + name + lang.added);
                    setTimeout(function () {
                        $('#smsgatewaymodal').modal('hide');
                        find(data);
                        $('#dynamic-table').DataTable().ajax.reload();
                    }, 500);
                }
            });
        } else {
            url = base_url + "panel/settings/edit_smsgateway";
            dataString =  dataString + "&id=" + encodeURI(id);
            jQuery.ajax({
                type: "POST",
                url: url,
                data: dataString,
                cache: false,
                success: function (data) {
                    toastr['success'](lang.save,  lang.smsgateway + ': ' + name +  " " + lang.updated);
                    setTimeout(function () {
                        $('#smsgatewaymodal').modal('hide');
                        find(id);
                        $('#dynamic-table').DataTable().ajax.reload();
                    }, 500);
                }
            });
        }
          return false;
      });
    });


    jQuery(document).on("click", "#add_additional_field", function (e) {
        e.preventDefault();
        let html = `<tr> 
            <td><input type="text" class="form-control" placeholder="${lang.parameter_name}" name="postdata[name][]"></td> 
            <td><input type="text" class="form-control" placeholder="${lang.parameter_value}" name="postdata[value][]"></td> 
            <td><i id="remove_field" class="fa fa-times"></i></td> 
        </tr>`
        $('#additional_post_data tbody').append(html);
    });



    jQuery(document).on("click", "#remove_field", function (e) {
        e.preventDefault();
        $(this).parent().parent().remove();
    });


    jQuery(document).on("click", "#delete", function () {
        var num = jQuery(this).data("num");
        jQuery.ajax({
            type: "POST",
            url: base_url + "panel/settings/delete_smsgateway",
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
                toastr['success'](lang.deleted + ": ", lang.smsgateway_deleted);
                $('#dynamic-table').DataTable().ajax.reload();
            }
        });
    });

    jQuery(".add_smsgateway").on("click", function (e) {
        $('#smsgatewaymodal').modal('show');
        $('#smsgateway_form').trigger("reset");
        $('#smsgateway_form').parsley().reset();
        $('#additional_post_data tbody').empty();
        let html = `<tr> 
            <td><input type="text" class="form-control" placeholder="${lang.parameter_name}" name="postdata[name][]"></td> 
            <td><input type="text" class="form-control" placeholder="${lang.parameter_value}" name="postdata[value][]"></td> 
            <td><i id="remove_field" class="fa fa-times"></i></td> 
        </tr>`
        $('#additional_post_data tbody').append(html);
        jQuery('#titsupplieri').html(lang.add + " " + lang.smsgateway);
        jQuery('#footersmsgateway').html(`<button data-dismiss="modal" class="pull-left btn btn-default" type="button"><i class="fa fa-reply"></i>${lang.go_back}</button><button id="submit_smsgateway" class="btn btn-success" role="submit" form="smsgateway_form"  data-mode="add"><i class="fa fa-user"></i> ${lang.add}</button>`);
    });

    jQuery(document).on("click", "#modify_sms_gateway", function () {
        jQuery('#titsupplieri').html(`${lang.edit} ${lang.sms_gateway}`);
        $('#smsgateway_form').trigger("reset");
        $('#smsgateway_form').parsley().reset();
        var num = $(this).data('num');
        jQuery.ajax({
            type: "POST",
            url: base_url + "panel/settings/get_smsgateway_id",
            data: "id=" + encodeURI(num),
            cache: false,
            dataType: "json",
            success: function (data) {
                data = data.data;
                $('#smsgateway_name').val(data.name)
                $('#smsgateway_url').val(data.url)
                $('#smsgateway_toname').val(data.to_name)
                $('#smsgateway_messagename').val(data.message_name)
                $('#smsgateway_notes').val(data.notes)

                var IS_JSON = true;
                try {
                    var json = $.parseJSON(data.postdata);
                } catch(err) {
                    IS_JSON = false;
                }                

                if(IS_JSON)  {
                    $('#additional_post_data tbody').empty();
                    $.each(json, function(key, value){
                        let html = `<tr> 
                            <td><input value="${key}" type="text" class="form-control" placeholder="${lang.parameter_name}" name="postdata[name][]"></td> 
                            <td><input value="${value}" type="text" class="form-control" placeholder="${lang.parameter_value}" name="postdata[value][]"></td> 
                            <td><i id="remove_field" class="fa fa-times"></i></td> 
                        </tr>`;
                        $('#additional_post_data tbody').append(html);
                    });
                }
                jQuery('#footersmsgateway').html(`<button data-dismiss="modal" class="pull-left btn btn-default" type="button"><i class="fa fa-reply"></i> ${lang.go_back}</button><button id="submit_smsgateway" class="btn btn-success" data-mode="modify" role="submit" form="smsgateway_form" data-num="${encodeURI(num)}"><i class="fa fa-save"></i> ${lang.save}</button>`)
            }
        });
    });

})(jQuery); 