(function($){ 
    "use strict"; 

        function jsonFormatter(json) {
        json = (json[8]);
        return renderjson(JSON.parse(json));
    }
        
    function actionValue(x) {
        x = x.split('___');
        if (x.length == 3) {
            amount = "";
            if (x[1] > 0) {
                amount = " +" + x[1] + " From " + x[2];
            }else{
                amount = " " +  x[1] + " From " + x[2];
            }
            return x[0] + amount;
        }
        return x[0];
    }

    function link_id(x) {
        x = x.split('___');
        return x[1];
    }
    var table;
    $(document).ready(function() {
        var datatableInit = function() {
            var $table = $('#dynamic-table');
            table = $table.DataTable({
                "aaSorting": [[5, "desc"]],
                "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                "iDisplayLength": <?=$settings->rows_per_page;?>,
                'bProcessing': false, 'bServerSide': true,
                'sAjaxSource': site.base_url + 'panel/log/getLog',
                'fnServerData': function (sSource, aoData, fnCallback) {
                    aoData.push({
                        "name": get_csrf_token_name,
                        "name": get_csrf_hash
                    });

                    aoData.push({
                        "name": "sRangeSeparator2",
                        "value": "-yadcf_delim-"
                    });
                    $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
                }, 
                "createdRow": function( row, data, dataIndex){
                    if (data[9]) {
                        if (data[10] == 'update' || data[10] == 'return-sale') {
                            color = 'warning';
                        }else if (data[10] == 'add' ) {
                            color = 'success';
                        }else if (data[10] == 'delete' ) {
                            color = 'danger';
                        }
                        
                        if(data[9] > 0){
                            $(row).addClass(color);
                        }else{
                            $(row).addClass(color);
                        }
                    }
                },
                "aoColumns": [
                    {
                        "width": '20px',
                        "className":      'details-control',
                        "orderable":      false,
                        "data":           null,
                        "defaultContent": ''
                    },
                    { 
                        width: '70px',
                        mRender: actionValue,
                    },
                    { width: '70px'},
                    { 
                        width: '70px',
                        mRender: link_id,

                    },
                    { width: '70px'},
                    { width: '70px',
                        mRender: fld,
                    },
                    { width: '70px'},
                ],
            });
        };

        
        datatableInit();
        // Add event listener for opening and closing details
        $('#dynamic-table tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = table.row( tr );
            if ( row.child.isShown() ) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            }
            else {
                // Open this row
                row.child( jsonFormatter(row.data()) ).show();
                tr.addClass('shown');
            }
        } );
        $('.yadcf-filter-range').addClass('form-control');
        $('.yadcf-filter-range').addClass('width_100');
    } );

    function scrollToTable() {
            $('html, body').animate({
                scrollTop: $("#dynamic-table").offset().top
            }, 500);
        }
})(jQuery); 
