(function($){ 
    "use strict"; 
        $(document).ready(function () {
        $('.daterange').daterangepicker({
            ranges   : {
            'Today'       : [moment(), moment()],
            'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month'  : [moment().startOf('month'), moment().endOf('month')],
            'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            locale: {
                format: (site.dateFormats.js_sdate).toUpperCase()
            },
        }, function (start, end) {
                start_date = start.format('YYYY-MM-DD');
                end_date = end.format('YYYY-MM-DD');

                $('#start_date').val(start_date);
                $('#end_date').val(end_date);
        });
    });
    var oTable;
    var datatableInit = function(status = null) {
       
        var search = $('.dataTables_filter input').val();
        if ($.fn.DataTable.isDataTable('#dynamic-table') ) {
            $('#dynamic-table').DataTable().destroy();
        }
        var oTable = $('#dynamic-table').DataTable({
                "aaSorting": [[8, "desc"]],
                "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                "iDisplayLength": <?=$settings->rows_per_page;?>,
                'bProcessing': true, 'bServerSide': true,
                'sAjaxSource': site.base_url + 'panel/reparation/getAllReparations',
                'fnServerData': function (sSource, aoData, fnCallback) {
                    aoData.push({
                        "name": get_csrf_token_name,
                        "name": get_csrf_hash
                    });

                    if(status == 'completed'){
                        aoData.push({
                            "name": "completed",
                            "value": "true"
                        });
                    }
        
                    <?php if($this->input->post('has_warranty')): ?>
                    aoData.push({
                        "name": "has_warranty",
                        "value": "<?= $this->input->post('has_warranty');?>"
                    });
                    <?php endif;?>

                    <?php if($this->input->post('manufacturer')): ?>
                    aoData.push({
                        "name": "manufacturer",
                        "value": "<?= $this->input->post('manufacturer');?>"
                    });
                    <?php endif;?>

                    <?php if($this->input->post('client_id')): ?>
                    aoData.push({
                        "name": "client_id",
                        "value": "<?= $this->input->post('client_id');?>"
                    });
                    <?php endif;?>
                
                    <?php if($this->input->post('model')): ?>
                    aoData.push({
                        "name": "model",
                        "value": "<?= $this->input->post('model');?>"
                    });
                    <?php endif;?>

                    <?php if($this->input->post('imei')): ?>
                    aoData.push({
                        "name": "imei",
                        "value": "<?= $this->input->post('imei');?>"
                    });
                    <?php endif;?>

                    <?php if($this->input->post('status')): ?>
                    aoData.push({
                        "name": "status",
                        "value": "<?= $this->input->post('status');?>"
                    });
                    <?php endif;?>


                    if(parseInt(status) > 0) {
                        aoData.push({
                            "name": "status",
                            "value": status
                        });
                    }

                    <?php if($this->input->post('start_date') && $this->input->post('end_date')): ?>
                    aoData.push({
                        "name": "start_date",
                        "value": "<?= $this->input->post('start_date');?>"
                    });
                    aoData.push({
                        "name": "end_date",
                        "value": "<?= $this->input->post('end_date');?>"
                    });
                    <?php endif;?>
                    $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
                }, 
                "aoColumns": [
                    null,
                    null,
                    {"mRender": client_name},
                    null,
                    null,
                    null,
                    null,
                    null,
                    {"mRender": fld},
                    {"mRender": fld},
                    {"mRender": status_},
                    null,
                    null,
                    {"mRender": update_by},
                    null,
                    {"mRender": formatMyDecimal},
                    {"mRender": formatPayments},
                    null,
                ],

                dom: 'lBfrtip',
                buttons: [
                {
                    extend: 'colvis',
                    collectionLayout: 'fixed two-column'
                }],
                stateSave: true,
                "stateSaveParams": function (settings, data) {
                    data.search.search = "";
                },
                "stateSaveCallback": function (settings, data) {
                    $.ajax({
                        "url": site.base_url + 'panel/misc/state_save',
                        "data": {state: JSON.stringify(data), table:'reparations'},
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
                        "data": {table:'reparations'},
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
                "createdRow": function( row, data, dataIndex){
                    let x = data[11];
                    let warranty = data[17];
                    if (warranty !== '' && warranty !== null) {
                        if (warranty !== '0') {
                            $(row).addClass('warranty_row');
                        }
                    }

                    if (x == 'cancelled') {
                        $('td:first', row).attr('bgcolor', '#000');
                        $('td:first', row).attr('style', 'color:#FFF;vertical-align: inherit;');
                    }else if(x){
                        x = x.split('____');
                        $('td:first', row).attr('bgcolor', x[1]);
                        $('td:first', row).attr('style', 'color:'+x[2]+';vertical-align: inherit;');
                        $('td:first', row).attr('style', 'color:'+x[2]+';vertical-align: inherit;background-color:'+x[1]+';');
                        $('td:first a', row).attr('style', 'color:'+x[2]+';vertical-align: inherit;');
                    }
                
                    $('td:not(:first-child)', row).attr('style', 'vertical-align: inherit;');
                    $('td', row).attr('align', 'center');
                },
                'fnRowCallback': function (nRow, aData, iDisplayIndex) {
                    nRow.id = aData[0];
                    nRow.className = "invoice_link";
                    return nRow;
                },
                "fnFooterCallback": function (nRow, aaData, iStart, iEnd, aiDisplay) {
                    var subtotal = 0;
                    for (var i = 0; i < aaData.length; i++) {
                        subtotal += parseFloat(aaData[aiDisplay[i]][16]);
                    }
                    var nCells = nRow.getElementsByTagName('th');
                    if(nCells[16]){
                        nCells[16].innerHTML = formatMoney(parseFloat(subtotal));
                    }
                }
            });

    };


        $(document).ready(function () {

            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                var target = $(e.target).attr("data-table") // activated tab
                datatableInit(target);
            });

            datatableInit();

            jQuery(document).on("click", "#print_reparation", function() {
                var num = jQuery(this).data("num");
                var tipo = jQuery(this).data("type");
                toastr['success']("<?= $this->lang->line('reparation_is_printing');?>");
                var thePopup = window.open( base_url + "panel/reparation/invoice/" + encodeURI(num) + "/" + tipo, '_blank', "width=890, height=700");
            });
            $.fn.modal.Constructor.prototype.enforceFocus = $.noop;

        });

    jQuery(document).on("click", ".view", function () {
        var num = jQuery(this).data("num");
        find_reparation(num);
    });


    jQuery(document).on("click", "#email_invoice", function() {
        num = $(this).attr('data-num');
        email = $(this).attr('data-email');

        bootbox.prompt({
            title: "Enter Email Address",
            inputType: 'email',
            value: email,
            callback: function (email_addr) {
                if (email_addr != null) {
                    $.ajax({
                        type: "post",
                        url: "<?= base_url('panel/reparation/email_invoice') ?>",
                        data: {email: email_addr, id: num},
                        dataType: "json",
                        success: function (data) {
                            toastr.success(data.msg);
                        },
                        error: function () {
                            toastr.error(lang.ajax_request_failed);
                            return false;
                        }
                    });
                }
            }
        });
        return false;
    });

    if (getUrlVars()["id"]) {
        find_reparation(getUrlVars()["id"]);
        $('#view_reparation').modal('show');
    }
    function getUrlVars() {
        var vars = {};
        var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function (m, key, value) {
            vars[key] = value;
        });
        return vars;
    }
})(jQuery); 
