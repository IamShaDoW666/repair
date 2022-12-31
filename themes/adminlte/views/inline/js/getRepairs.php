(function($){ 
    "use strict"; 
        $('#view-repars-table').dataTable({
        "aaSorting": [[3, "asc"]],
        "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        "iDisplayLength": parseInt(site.settings.rows_per_page),
        'bProcessing': true, 'bServerSide': true,
        'sAjaxSource': site.base_url + 'panel/reparation/getAllReparations/<?=$id;?>',
        'fnServerData': function (sSource, aoData, fnCallback) {
            aoData.push({
                "name": get_csrf_token_name,
                "name": get_csrf_hash
            });
            $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
        }, 
        "aoColumns": [
            {"mRender": reparationID_link},
            null,
            null,
            null,
            null,
            {"mRender": status},
            null,
            {"mRender": update_by},
            {"mRender": formatMyDecimal},
        ],
            "fnFooterCallback": function (nRow, aaData, iStart, iEnd, aiDisplay) {
            var subtotal = 0;
            for (var i = 0; i < aaData.length; i++) {
                subtotal += parseFloat(aaData[aiDisplay[i]][8]);
            }
            var nCells = nRow.getElementsByTagName('th');
            nCells[8].innerHTML = formatMoney(parseFloat(subtotal));
        }
    });
})(jQuery); 
