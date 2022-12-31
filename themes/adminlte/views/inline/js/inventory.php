(function($){ 
    "use strict"; 

    var oTable;
    $(document).ready(function () {

        $('body').on('click', '#delete_products', function(e) {
            bootbox.confirm(lang.r_u_sure, function(result){ 
                if(result){
                    e.preventDefault();
                    $('#form_action').val('delete');
                    $('#action-form').submit();
                }
            });
        });



        oTable = $('#PRData').dataTable({
            "aaSorting": [[2, "asc"]],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "iDisplayLength": parseInt(site.settings.rows_per_page),
            'bProcessing': true, 'bServerSide': true,
            'sAjaxSource': '<?= site_url('panel/inventory/getProducts'); ?>',
            'fnServerData': function (sSource, aoData, fnCallback) {
                aoData.push({
                    "name": get_csrf_token_name,
                    "name": get_csrf_hash
                });
                $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
            },
            'fnRowCallback': function (nRow, aData, iDisplayIndex) {
                nRow.id = aData[0];
                nRow.className = "product_link";
                return nRow;
            },
            "aoColumns": [
                {"bSortable": false, "mRender": checkbox}, 
                    {"bSortable": false, "mRender": img_hl},
                null,
                null,
                {'mRender': currencyFormat},
                {'mRender': currencyFormat},
                {'mRender': parseInt},
                {'mRender': parseInt},
                {"bSortable": false}, 
                
            ]
        });

    });

    $('body').on('click', '.product_link td:not(:first-child, :nth-child(2), :last-child)', function() {
        $('#myModal .modal-dialog').load(site.base_url + 'panel/inventory/modal_view/' + $(this).parent('.product_link').attr('id'));
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
