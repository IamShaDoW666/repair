(function($){ 
    "use strict"; 

<?php
$v = "";
if ($this->input->post('date_range')) {
    $dr = explode(' - ', $this->input->post('date_range'));
    $v .= "&start_date=" . $this->repairer->fsd($dr[0]);
    $v .= "&end_date=" . $this->repairer->fsd($dr[1]);
}
?>$(document).ready(function () {
        jQuery(document).on("click", "#pdf", function (event) {
            event.preventDefault();
            window.location.href = "<?=site_url('panel/reports/getDrawerReport/pdf/?v=1'.$v)?>";
            return false;
        });
        jQuery(document).on("click", "#xls", function (event) {
            event.preventDefault();
            window.location.href = "<?=site_url('panel/reports/getDrawerReport/0/xls/?v=1'.$v)?>";
            return false;
        });
    });

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

function formatToMoney(x) {
    return formatMoney(x);
}

function formatProfit(x) {
    if (x < 0) {
        return '<span class="badge badge-danger">'+formatToMoney(x)+'</span>'
    }else{
        return '<span class="badge badge-success">'+formatToMoney(x)+'</span>'
    }
}

    $(document).ready(function () {
        var tt = '';
        $('.date').datepicker({ dateFormat: 'mm-dd-yy' });
        var oTable = $('#dynamic-table').dataTable({
            "aaSorting": [[0, "desc"]],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "iDisplayLength": 10,
            'bProcessing': true, 'bServerSide': true,
            'sAjaxSource': '<?= site_url('panel/reports/getDrawerReport?v=1' . $v) ?>',
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
            ],
            'fnRowCallback': function (nRow, aData, iDisplayIndex) {
                var oSettings = oTable.fnSettings();
                nRow.id = aData[6];
                if (aData[7] == 'open') {
                    nRow.className = "register_link danger";
                }else{
                    nRow.className = "register_link success";
                }
                return nRow;
            },
            columnDefs: [
                { width: 200, targets: [4] }
            ],
        });
    });
})(jQuery); 
