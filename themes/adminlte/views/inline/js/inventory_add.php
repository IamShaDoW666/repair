(function($){ 
    "use strict"; 

    $(document).ready(function () {
        var items = {};
   
        $('#product_type').change(function () {
            var t = $(this).val();
            if (t !== 'standard') {
                $('.standard').slideUp();
                $('#cost').attr('required', 'required');
                $('#track_quantity').prop('checked', false);
                $('form[data-toggle="validator"]').bootstrapValidator('addField', 'cost');
            } else {
                $('.standard').slideDown();
                $('#track_quantity').prop('checked', true);
                $('#cost').removeAttr('required');
                $('form[data-toggle="validator"]').bootstrapValidator('removeField', 'cost');
            }

        });

        var t = $('#product_type').val();
        if (t !== 'standard') {
            $('.standard').slideUp();
            $('#cost').attr('required', 'required');

            $('#track_quantity').prop('checked', false);
            $('form[data-toggle="validator"]').bootstrapValidator('addField', 'cost');
        } else {
            $('.standard').slideDown();
            $('#track_quantity').prop('checked', true);
            $('#cost').removeAttr('required');
            $('form[data-toggle="validator"]').bootstrapValidator('removeField', 'cost');
        }
        

        function calculate_price() {
            var rows = $('#prTable').children('tbody').children('tr');
            var pp = 0;
            $.each(rows, function () {
                pp += formatDecimal(parseFloat($(this).find('.rprice').val())*parseFloat($(this).find('.rquantity').val()));
            });
            $('#price').val(pp);
            return true;
        }

        $(document).on('change', '.rquantity, .rprice', function () {
            calculate_price();
        });

        $(document).on('click', '.del', function () {
            var id = $(this).attr('id');
            delete items[id];
            $(this).closest('#row_' + id).remove();
            calculate_price();
        });
        var su = 2;
       
        $(document).on('click', '.delAttr', function () {
            $(this).closest("tr").remove();
        });
        $(document).on('click', '.attr-remove-all', function () {
            $('#attrTable tbody').empty();
            $('#attrTable').hide();
        });

    });

    $(document).ready(function () {
        var t = $('#product_type').val();
        if (t !== 'standard') {
            $('.standard').slideUp();
            $('#cost').attr('required', 'required');
            $('#track_quantity').iCheck('uncheck');
            $('form[data-toggle="validator"]').bootstrapValidator('addField', 'cost');
        } else {
            $('.standard').slideDown();
            $('#track_quantity').iCheck('check');
            $('#cost').removeAttr('required');
            $('form[data-toggle="validator"]').bootstrapValidator('removeField', 'cost');
        }
        $("#code").parent('.form-group').addClass("has-error");
        $("#code").focus();
    });
    jQuery(document).on("click", "#random_num", function () {
        $(this).parent('.input-group').children('input').val(generateCardNo(8));
    });
        function generateCardNo(x) {
    if(!x) { x = 16; }
    chars = "1234567890";
    no = "";
    for (var i=0; i<x; i++) {
       var rnum = Math.floor(Math.random() * chars.length);
       no += chars.substring(rnum,rnum+1);
   }
   return no;
}
<?php if (validation_errors()) { ?>
    var text = '<?= trim(validation_errors()); ?>';
    toastr.warning(text);
<?php } ?>
$(document).ready(function () {
        $('.gen_slug').change(function(e) {
            getSlug($(this).val(), 'products');
        });

        let selected_subcategory =  {id: '', text: lang.select_category_to_load};
        if($('#subcategory option').length > 0) { 
            selected_subcategory = {id: $( "#subcategory" ).val(), text: $( "#subcategory option:selected" ).text()};
        }
        $("#subcategory").empty().attr("placeholder", lang.select_category_to_load).select2({
            placeholder: lang.select_category_to_load, minimumResultsForSearch: 7, data: [
                selected_subcategory
            ]
        });
        $('.select').select2();
        $('#category').on('change', function (e) {
            var v = $(this).val();
            if (v) {
                $.ajax({
                    type: "get",
                    async: false,
                    url: "<?= base_url('panel/inventory/getSubCategories') ?>/" + v,
                    dataType: "json",
                    success: function (scdata) {
                        if (scdata != null) {
                            scdata.push({id: '', text: lang.select_subcategory});
                            $("#subcategory").select2("destroy").empty().attr("placeholder", lang.select_subcategory).select2({
                                placeholder: lang.select_category_to_load,
                                minimumResultsForSearch: 7,
                                data: scdata
                            });
                        } else {
                            $("#subcategory").select2("destroy").empty().attr("placeholder", lang.no_subcategory).select2({
                                placeholder: lang.no_subcategory,
                                minimumResultsForSearch: 7,
                                data: [{id: '', text: lang.no_subcategory}]
                            });
                        }
                    },
                    error: function () {
                        bootbox.alert(lang.ajax_error);
                        $('#modal-loading').hide();
                    }
                });
            } else {
                $("#subcategory").select2("destroy").empty().attr("placeholder", lang.select_category_to_load).select2({
                    placeholder: lang.select_category_to_load,
                    minimumResultsForSearch: 7,
                    data: [{id: '', text: lang.select_category_to_load}]
                });
            }
            $('#modal-loading').hide();
        });

        jQuery(document).on("keypress", "#code", function (e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                return false;
            }
        });
    });
})(jQuery); 
