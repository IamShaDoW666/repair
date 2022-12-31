(function($){ 
    "use strict"; 
    var ac = false, rbcitems = {};
    if (localStorage.getItem('rbcitems')) {
        rbcitems = JSON.parse(localStorage.getItem('rbcitems'));
    }

    let print_items = $('#print_items').val();
    if(print_items !== "") {
        localStorage.setItem('rbcitems', JSON.parse(print_items));
    }

    $(document).ready(function() {
        <?php if ($this->input->post('print')) { ?>
            $(window).on('load', function () {
                $('html, body').animate({
                    scrollTop: ($("#barcode-con").offset().top)-15
                }, 1000);
            });
        <?php } ?>
        if (localStorage.getItem('rbcitems')) {
            loadItems();
        }
        $("#add_item").autocomplete({
            source: '<?= site_url('panel/reparation/suggestions'); ?>',
            minLength: 1,
            autoFocus: false,
            delay: 250,
            response: function (event, ui) {
                if ($(this).val().length >= 16 && ui.content[0].id == 0) {
                    alert(lang.no_book_found);
                    $('#add_item').focus();
                    $(this).val('');
                }
                else if (ui.content.length == 1 && ui.content[0].id != 0) {
                    ui.item = ui.content[0];
                    $(this).data('ui-autocomplete')._trigger('select', 'autocompleteselect', ui);
                    $(this).autocomplete('close');
                    $(this).removeClass('ui-autocomplete-loading');
                }
                else if (ui.content.length == 1 && ui.content[0].id == 0) {
                    alert(lang.no_book_found);
                    $('#add_item').focus();
                    $(this).val('');
                }
            },
            select: function (event, ui) {
                event.preventDefault();
                if (ui.item.id !== 0) {
                    var row = add_product_item(ui.item);
                    if (row) {
                        $(this).val('');
                    }
                } else {
                    alert(lang.no_book_found);
                }
            }
        });
        check_add_item_val();

        $('#style').change(function (e) {
            localStorage.setItem('bcstyle', $(this).val());
            if ($(this).val() == 50) {
                $('.cf-con').slideDown();
            } else {
                $('.cf-con').slideUp();
            }
        });
        let style = localStorage.getItem('bcstyle');
        if (style) {
            $('#style').val(style);
            if (style == 50) {
                $('.cf-con').slideDown();
            } else {
                $('.cf-con').slideUp();
            }
        }

        $('#cf_width').change(function (e) {
            localStorage.setItem('cf_width', $(this).val());
        });

        let cf_width = localStorage.getItem('cf_width');
        if (cf_width) {
            $('#cf_width').val(cf_width);
        }

        $('#cf_height').change(function (e) {
            localStorage.setItem('cf_height', $(this).val());
        });

        let cf_height = localStorage.getItem('cf_height');
        if (cf_height ) {
            $('#cf_height').val(cf_height);
        }

        $('#cf_orientation').change(function (e) {
            localStorage.setItem('cf_orientation', $(this).val());
        });
        let cf_orientation = localStorage.getItem('cf_orientation');
        if (cf_orientation ) {
            $('#cf_orientation').val(cf_orientation);
        }

        $(document).on('ifChecked', '#client_name', function(event) {
            localStorage.setItem('bcclient_name', 1);
        });
        $(document).on('ifUnchecked', '#client_name', function(event) {
            localStorage.setItem('bcclient_name', 0);
        });

        let client_name = localStorage.getItem('bcclient_name');
        if (client_name) {
            if (client_name == 1)
                $('#client_name').iCheck('check');
            else
                $('#client_name').iCheck('uncheck');
        }


        $(document).on('ifChecked', '#price', function(event) {
            localStorage.setItem('bcprice', 1);
        });
        $(document).on('ifUnchecked', '#price', function(event) {
            localStorage.setItem('bcprice', 0);
        });

        let price = localStorage.getItem('bcprice');
        if (price) {
            if (price == 1)
                $('#price').iCheck('check');
            else
                $('#price').iCheck('uncheck');
        }


        $(document).on('ifChecked', '#defect', function(event) {
            localStorage.setItem('bcdefect', 1);
        });
        $(document).on('ifUnchecked', '#defect', function(event) {
            localStorage.setItem('bcdefect', 0);
        });

        let defect = localStorage.getItem('bcdefect');
        if (defect) {
            if (defect == 1)
                $('#defect').iCheck('check');
            else
                $('#defect').iCheck('uncheck');
        }

        $(document).on('ifChecked', '#imei', function(event) {
            localStorage.setItem('bcimei', 1);
        });
        $(document).on('ifUnchecked', '#imei', function(event) {
            localStorage.setItem('bcimei', 0);
            $('#currencies').iCheck('uncheck');
        });
        let imei = localStorage.getItem('bcimei');
        if (imei) {
            if (imei == 1)
                $('#imei').iCheck('check');
            else
                $('#imei').iCheck('uncheck');
        }


        $(document).on('ifChecked', '#model', function(event) {
            localStorage.setItem('bcmodel', 1);
        });
        $(document).on('ifUnchecked', '#model', function(event) {
            localStorage.setItem('bcmodel', 0);
            $('#currencies').iCheck('uncheck');
        });

        let model = localStorage.getItem('bcmodel');
        if (model ) {
            if (model == 1)
                $('#model').iCheck('check');
            else
                $('#model').iCheck('uncheck');
        }

        $(document).on('ifChecked', '.checkbox', function(event) {
            var item_id = $(this).attr('data-item-id');
            var vt_id = $(this).attr('id');
            rbcitems[item_id]['selected_variants'][vt_id] = 1;
            localStorage.setItem('rbcitems', JSON.stringify(rbcitems));
        });
        $(document).on('ifUnchecked', '.checkbox', function(event) {
            var item_id = $(this).attr('data-item-id');
            var vt_id = $(this).attr('id');
            rbcitems[item_id]['selected_variants'][vt_id] = 0;
            localStorage.setItem('rbcitems', JSON.stringify(rbcitems));
        });

        $(document).on('click', '.del', function () {
            var id = $(this).attr('id');
            delete rbcitems[id];
            localStorage.setItem('rbcitems', JSON.stringify(rbcitems));
            $(this).closest('#row_' + id).remove();
        });

        jQuery(document).on("click", "#reset", function (e) {

                if (confirm("Are You Sure")) {
                    if (localStorage.getItem('rbcitems')) {
                        localStorage.removeItem('rbcitems');
                    }
                    if (localStorage.getItem('bcstyle')) {
                        localStorage.removeItem('bcstyle');
                    }
                   
                    if (localStorage.getItem('bcclient_name')) {
                        localStorage.removeItem('bcclient_name');
                    }
                    if (localStorage.getItem('bcimei')) {
                        localStorage.removeItem('bcimei');
                    }

                    if (localStorage.getItem('bcmodel')) {
                        localStorage.removeItem('bcmodel');
                    }
                    if (localStorage.getItem('bcdefect')) {
                        localStorage.removeItem('bcdefect');
                    }

                    $('#modal-loading').show();
                    window.location.replace("<?= site_url('panel/reparation/print_barcodes'); ?>");
                }
        });

        var old_row_qty;
        $(document).on("focus", '.quantity', function () {
            old_row_qty = $(this).val();
        }).on("change", '.quantity', function () {
            var row = $(this).closest('tr');
            if (!is_numeric($(this).val())) {
                $(this).val(old_row_qty);
                alert(lang.unexpected_value);
                return;
            }
            var new_qty = parseFloat($(this).val()),
            item_id = row.attr('data-item-id');
            rbcitems[item_id].qty = new_qty;
            localStorage.setItem('rbcitems', JSON.stringify(rbcitems));
        });

    });

    function add_product_item(item) {
        ac = true;
        if (item == null) {
            return false;
        }
        item_id = item.id;
        if (rbcitems[item_id]) {
            rbcitems[item_id].qty = parseFloat(rbcitems[item_id].qty) + 1;
        } else {
            rbcitems[item_id] = item;
        }

        localStorage.setItem('rbcitems', JSON.stringify(rbcitems));
        loadItems();
        return true;

    }

    function loadItems () {

        if (localStorage.getItem('rbcitems')) {
            $("#bcTable tbody").empty();
            rbcitems = JSON.parse(localStorage.getItem('rbcitems'));

            $.each(rbcitems, function () {
                var item = this;
                var row_no = item.id;
                var newTr = $('<tr id="row_' + row_no + '" class="row_' + item.id + '" data-item-id="' + item.id + '"></tr>');
                let tr_html = '<td><input name="product[]" type="hidden" value="' + item.id + '"><span id="name_' + row_no + '">' + item.name + ' (' + item.model + ')</span></td>';
                tr_html += '<td><input class="form-control quantity text-center" name="quantity[]" type="text" value="' + (item.qty) + '" data-id="' + row_no + '" data-item="' + item.id + '" id="quantity_' + row_no + '" onClick="this.select();"></td>';
                tr_html += '<td class="text-center"><i class="fa fa-times tip del" id="' + row_no + '" title="Remove" style="cursor:pointer;"></i></td>';
                newTr.html(tr_html);
                newTr.appendTo("#bcTable");
            });
            $('input[type="checkbox"],[type="radio"]').not('.skip').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%'
            });
            return true;
        }
    }

function check_add_item_val() {
    jQuery(document).on("keypress", "#add_item", function (e) {
        if (e.keyCode == 13 || e.keyCode == 9) {
            e.preventDefault();
            $(this).autocomplete("search");
        }
    });
}

function printContent(div_id){
        var contents = $("#page").html();
        var frame1 = $('<iframe />');
        frame1[0].name = "frame1";
        frame1.css({ "position": "absolute", "top": "-1000000px" });
        $("body").append(frame1);
        var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
        frameDoc.document.open();
        //Create a new HTML document.
        frameDoc.document.write('<html><head><title>Print Barcode</title>');
        frameDoc.document.write('</head><body>');
        //Append the external CSS file.
        // frameDoc.document.write('<html><head><title>Print Barcode</title>');
        frameDoc.document.write('<style type="text/css" media="print">@page{size:landscape;}</style><html><head><title>Print Barcodes</title>');
        frameDoc.document.write('<link rel="stylesheet" href="<?=$assets;?>/plugins/bootstrap/dist/css/bootstrap.min.css">');
        frameDoc.document.write('<link rel="stylesheet" href="<?=$assets;?>/dist/css/custom/rbarcode_print.css">');
        frameDoc.document.write('<style type="text/css" > table tr td {font-size:12px;}table > thead > tr >th , table> tbody > tr > td {font-size:10px}  #dontprint{display:none} .dontshow{display:display} </style>');
        //Append the DIV contents.
        frameDoc.document.write(contents);
        frameDoc.document.write('</body></html>');
        frameDoc.document.close();
        setTimeout(function () {
            window.frames["frame1"].focus();
            window.frames["frame1"].print();
            frame1.remove();
        }, 2000);
}

function customPrint() {
    printContent('page');
}

})(jQuery); 
