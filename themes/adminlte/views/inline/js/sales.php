(function($){ 
    "use strict"; 
    <?php
        $v = "";
        if ($this->input->post('date_range')) {
            $dr = explode(' - ', $this->input->post('date_range'));
            $v .= "&start_date=" . $this->repairer->fsd($dr[0]);
            $v .= "&end_date=" . $this->repairer->fsd($dr[1]);
        }
    ?>

    function pqFormat(x) {
        if (x != null) {
            var d = '', pqc = x.split("___");
            for (var index = 0; index < pqc.length; ++index) {
                var pq = pqc[index];
                var v = pq.split("__");
                d += v[0]+'<br>';
            }
            return d;
        } else {
            return '';
        }
    }


    jQuery(document).on("click", "#email_invoice", function() {
        num = $(this).attr('data-num');
        email = $(this).attr('data-email');
        if(email !== '') {
            $.ajax({
                type: "post",
                url: base_url + "panel/pos/email_receipt",
                data: {email: email, id: num},
                dataType: "json",
                success: function (data) {
                    toastr.success(data.msg);
                },
                error: function () {
                    toastr.error(lang.ajax_request_failed);
                    return false;
                }
            });
        }else{
            bootbox.prompt({
                title: "Enter Email Address",
                inputType: 'email',
                value: "",
                callback: function (email_addr) {
                    if (email_addr != null) {
                        $.ajax({
                            type: "post",
                            url: site.base_url + "panel/pos/email_receipt",
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
        }
        return false;
    });


    function formatToMoney(x) {
        return formatMoney(x);
    }
    function getFormattedDate(date){
        var dd = date.getDate();
        var mm = date.getMonth()+1;
        var yyyy = date.getFullYear();
        return mm +'/'+dd+'/'+yyyy;
    }

    $(document).ready(function () {

        $('.date').datepicker({ dateFormat: 'mm-dd-yy' });
        var oTable = $('#dynamic-table').dataTable({
            "aaSorting": [[0, "desc"]],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "iDisplayLength": 10,
            'bProcessing': true, 'bServerSide': true,
            'sAjaxSource': '<?= base_url('panel/reports/getAllSales?v=1' . $v) ?>',
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
            {mRender: pqFormat},
            {mRender: formatToMoney},
            {mRender: formatToMoney},
            {mRender: formatToMoney},
            {mRender: formatToMoney},
            {mRender: formatToMoney},
            {"mRender": pay_status}, 
            null,
            ],
            dom: 'lfrtip',
            "fnFooterCallback": function (nRow, aaData, iStart, iEnd, aiDisplay) {
                var subtotal = 0, tax = 0;
                var gtotal = 0, paid = 0, balance = 0;
                for (var i = 0; i < aaData.length; i++) {
                    subtotal += parseFloat(aaData[aiDisplay[i]][4]);
                    tax += parseFloat(aaData[aiDisplay[i]][5]);
                    gtotal += parseFloat(aaData[aiDisplay[i]][6]);
                    paid += parseFloat(aaData[aiDisplay[i]][7]);
                    balance += parseFloat(aaData[aiDisplay[i]][8]);
                }
                var nCells = nRow.getElementsByTagName('th');
                nCells[4].innerHTML = formatMoney(parseFloat(subtotal));
                nCells[5].innerHTML = formatMoney(parseFloat(tax));
                nCells[6].innerHTML = formatMoney(parseFloat(gtotal));
                nCells[7].innerHTML = formatMoney(parseFloat(paid));
                nCells[8].innerHTML = formatMoney(parseFloat(balance));
            }
        });
    });



    function pay_status(x) {


    if(x == null) {
        return '';
    } else if(x == 'pending') {
        return '<div class="text-center"><span class="payment_status badge badge-warning">'+lang[x]+'</span></div>';
    } else if(x == 'completed' || x == 'paid' || x == 'sent' || x == 'received') {
        return '<div class="text-center"><span class="payment_status badge badge-success">'+lang[x]+'</span></div>';
    } else if(x == 'partial' || x == 'transferring' || x == 'ordered') {
        return '<div class="text-center"><span class="payment_status badge badge-info">'+lang[x]+'</span></div>';
    } else if(x == 'due' || x == 'returned') {
        return '<div class="text-center"><span class="payment_status badge badge-danger">'+lang[x]+'</span></div>';
    } else {
        return '<div class="text-center"><span class="payment_status badge badge-default">'+x+'</span></div>';
    }
    }
})(jQuery); 
