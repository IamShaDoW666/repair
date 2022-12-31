(function($){ 
    "use strict"; 

    $(document).ready(function () {

    $('body').on('click', '.bpo', function(e) {
        e.preventDefault();
        $(this).popover({html: true, trigger: 'manual'}).popover('toggle');
        return false;
    });
    $('body').on('click', '.bpo-close', function(e) {
        $('.bpo').popover('hide');
        return false;
    });

    var oTable = $('#dynamic-table').DataTable({
        "aaSorting": [[3, "asc"]],
        "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        "iDisplayLength": parseInt(site.settings.rows_per_page),
        'bProcessing': true, 'bServerSide': true,
        'sAjaxSource': site.base_url + 'panel/customers/getAllCustomers',
        'fnServerData': function (sSource, aoData, fnCallback) {
            aoData.push({
                "name": get_csrf_token_name,
                "name": get_csrf_hash
            });
            $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback,
                'async': false,
            });
        }, 
        "responsive": true,  "autoWidth": false,
        "aoColumns": [
        {"bSortable": false, "mRender": checkbox}, 
        null,
        null,
        null,
        null,
        null,
        null,
        {mRender: formatMyDecimal},
        null
        ],
        dom: 'lBfrtip',

        "buttons": [{
            extend: 'colvis',
            collectionLayout: 'fixed two-column'
        }],

        language: {
            buttons: {
                colvis: 'Change columns'
            }
        },
        stateSave: true,
        "stateSaveParams": function (settings, data) {
            data.search.search = "";
            data.yadcfState = "";
            $.each(data.columns, function() { 
                this.search.search = '';
            });
        },
        
        "stateSaveCallback": function (settings, data) {
            $.ajax({
                "url": site.base_url + 'panel/misc/state_save',
                "data": {state: JSON.stringify(data), table:'clients'},
                "dataType": "json",
                "type": "POST",
                "success": function () {
                }
            });
        },
        'stateLoadCallback': function (settings) {
            var o;
            $.ajax ({
                'url': site.base_url + 'panel/misc/load_state',
                "data": {table:'clients'},
                'async': false,
                'dataType': 'json',
                'success': function (json) {
                    if (undefined === json) {

                    }else{
                        o = json;
                    }
                }
            });
            return o;
        },
    });
    });

    jQuery(document).on("click", "#view_image", function (e) {
    e.preventDefault();
    image_name = $(this).data('num');
    if (image_name) {
        showImage(site.base_url + 'assets/uploads/images/'+image_name);
    }else{
        bootbox.alert({
            message: lang.client_no_image,
            backdrop: true
        });
    }
    });



    jQuery(document).on("click", "#delete_client", function () {
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
                    url: base_url + "panel/customers/delete",
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
                        toastr['success'](lang.deleted + ": ", lang.client_deleted);
                        $('#dynamic-table').DataTable().ajax.reload();
                    }
                });

            }
        }
    });
    
    });
    if (getUrlVars()["id"]) {
        find_client(getUrlVars()["id"]);
        $('#view_client').modal('show');
    }

    function getUrlVars() {
        var vars = {};
        var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function (m, key, value) {
            vars[key] = value;
        });
        return vars;
    }
})(jQuery); 