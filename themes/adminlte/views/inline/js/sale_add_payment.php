(function($){ 
    "use strict"; 
    let inv_customer_id = $('#invoice_customer_id').val()
    $(document).ready(function () {
        $('.file').fileinput();

        $(document).on('change', '.paid_by', function () {
            var p_val = $(this).val();
            $('#rpaidby').val(p_val);
            if (p_val == 'cash' || p_val == 'CC') {
                $('.pcheque_1').hide();
                $('.pcc_1').hide();
                $('.pcash_1').show();
                $('.v_1').hide();
                $('#amount_1').focus();
            } else if (p_val == 'Cheque') {
                $('.pcc_1').hide();
                $('.pcash_1').hide();
                $('.pcheque_1').show();
                $('.v_1').hide();
                $('#cheque_no_1').focus();
            } else if (p_val == 'voucher') {
                $('.v_1').show();
                $('.pcc_1').hide();
                $('.pcash_1').hide();
                $('.pcheque_1').hide();
                $('#voucher_no_1').focus();
            } else {
                $('.pcheque_1').hide();
                $('.pcc_1').hide();
                $('.pcash_1').hide();
                $('.v_1').hide();
            }
        });
        $('#pcc_no_1').change(function (e) {
            var pcc_no = $(this).val();
            localStorage.setItem('pcc_no_1', pcc_no);
            var CardType = null;
            var ccn1 = pcc_no.charAt(0);
            if (ccn1 == 4)
                CardType = 'Visa';
            else if (ccn1 == 5)
                CardType = 'MasterCard';
            else if (ccn1 == 3)
                CardType = 'Amex';
            else if (ccn1 == 6)
                CardType = 'Discover';
            else
                CardType = 'Visa';

            $('#pcc_type_1').select2("val", CardType);
        }); 
    });
    $(document).on('change', '.voucher_no', function () {
        var cn = $(this).val() ? $(this).val() : '';
        var payid = $(this).attr('id'),
            id = payid.substr(payid.length - 1);
        if (cn != '') {
            $.ajax({
                type: "get", async: false,
                url: site.base_url + "panel/sales/validate_voucher/" + cn,
                dataType: "json",
                success: function (data) {
                    if (data === false) {
                        $('#voucher_no_' + id).parent('.form-group').addClass('has-error');
                        bootbox.alert(lang.incorrect_gift_card);
                    } else if (data.customer_id !== null && parseInt( data.customer_id) !== inv_customer_id) {
                        $('#voucher_no_' + id).parent('.form-group').addClass('has-error');
                        bootbox.alert(lang.gift_card_not_for_customer);
                    } else {
                        $('#v_details_' + id).html('<small>Card No: ' + data.card_no + '<br>Value: ' + data.value + '</small>');
                        $('#voucher_no_' + id).parent('.form-group').removeClass('has-error');
                        $('#amount_' + id).val(gtotal >= data.value ? data.value : gtotal).focus();
                        $('#amount_' + id).attr('readonly', true);
                    }
                }
            });
        }
    });



    $(document).ready(function () {
    let p_val = $('#payment_paid_by').val()
    if(p_val) {
        localStorage.setItem('paid_by', p_val);
        if (p_val == 'cash' || p_val == 'CC') {
            $('.pcheque_1').hide();
            $('.pcc_1').hide();
            $('.pcash_1').show();
            $('.v_1').hide();
            $('#amount_1').focus();
        } else if (p_val == 'Cheque') {
            $('.pcc_1').hide();
            $('.pcash_1').hide();
            $('.pcheque_1').show();
            $('.v_1').hide();
            $('#cheque_no_1').focus();
        } else if (p_val == 'voucher') {
            $('.v_1').show();
            $('.pcc_1').hide();
            $('.pcash_1').hide();
            $('.pcheque_1').hide();
            $('#voucher_no_1').focus();
        } else {
            $('.pcheque_1').hide();
            $('.pcc_1').hide();
            $('.pcash_1').hide();
            $('.v_1').hide();
        }
        $('#paid_by_1').select2("val", p_val);
    }
   
});
})(jQuery); 
