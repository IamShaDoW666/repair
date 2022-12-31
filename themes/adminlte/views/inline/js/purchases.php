(function($){ 
    "use strict"; 

    
    $(document).ready(function () {
        var oTable = $('#POData').dataTable({
            "aaSorting": [[1, "desc"]],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100,lang.all]],
            "iDisplayLength": parseInt(site.settings.rows_per_page),
            'bProcessing': true, 'bServerSide': true,
            'sAjaxSource': '<?= site_url('panel/purchases/getPurchases'); ?>',
            'fnServerData': function (sSource, aoData, fnCallback) {
                aoData.push({
                    "name": "<?=$this->security->get_csrf_token_name()?>",
                    "value": "<?=$this->security->get_csrf_hash()?>"
                });
                $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
            },
            "aoColumns": [
                    {"bSortable": false,"mRender": checkbox},
                    {"mRender": fld},
                    null, 
                    null, 
                    {"mRender": row_status}, 
                    {"mRender": currencyFormat}, 
                    {"bSortable": false, "mRender": attachment}, 
                    {"bSortable": false}
                ],
            'fnRowCallback': function (nRow, aData, iDisplayIndex) {
                nRow.id = aData[0];
                nRow.className = "purchase_link";
                return nRow;
            },
            "fnFooterCallback": function (nRow, aaData, iStart, iEnd, aiDisplay) {
                var total = 0, paid = 0, balance = 0;
                for (var i = 0; i < aaData.length; i++) {
                    total   +=  parseInt(aaData[aiDisplay[i]]['5']);
                }
                var nCells = nRow.getElementsByTagName('th');
                nCells[5].innerHTML = 'site.settings.currency ' + (total);
            }
        })
    });
   
    $('body').on('click', '.purchase_link td:not(:first-child, :nth-child(5), :nth-last-child(2), :last-child)', function() {
        $('#myModal .modal-dialog').load(site.base_url + 'panel/purchases/modal_view/' + $(this).parent('.purchase_link').attr('id'));
        $('#myModal').modal('show');
    });
 $('body').on('click', '.bpo', function(e) {
        e.preventDefault();
        $(this).popover({html: true, trigger: 'manual'}).popover('toggle');
        return false;
    });
    $('body').on('click', '.bpo-close', function(e) {
        $('.bpo').popover('hide');
        return false;
    });
})(jQuery); 
