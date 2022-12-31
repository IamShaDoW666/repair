(function($){ 
    "use strict"; 
    $(document).ready(function () {

    $("#date").datetimepicker({
        format: site.dateFormats.js_ldate,
        fontAwesome: true,
        language: 'sma',
        weekStart: 1,
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        forceParse: 0,
        defaultDate: $('#date').val()
    });

    $(document).on('change', '.paid_by', function () {
        var p_val = $(this).val();
        localStorage.setItem('paid_by', p_val);
        $('#rpaidby').val(p_val);
        if (p_val == 'cash') {
            $('.pcheque_1').hide();
            $('.pcc_1').hide();
            $('.pcash_1').show();
            $('#amount_1').focus();
        } else if (p_val == 'CC' || p_val == 'stripe' || p_val == 'ppp' || p_val == 'authorize') {
            if (p_val == 'CC') {
                $('#ppp-stripe').hide();
            } else {
                $('#ppp-stripe').show();
            }
            $('.pcheque_1').hide();
            $('.pcash_1').hide();
            $('.pcc_1').show();
            $('#swipe_1').focus();
        } else if (p_val == 'Cheque') {
            $('.pcc_1').hide();
            $('.pcash_1').hide();
            $('.pcheque_1').show();
            $('#cheque_no_1').focus();
        } else {
            $('.pcheque_1').hide();
            $('.pcc_1').hide();
            $('.pcash_1').hide();
        }
        if (p_val == 'gift_card') {
            $('.gc').show();
            $('#gift_card_no').focus();
        } else {
            $('.gc').hide();
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

    $('.swipe').keypress(function (e) {
        var self = $(this);
        var id = 1;
        var TrackData = $(this).val();
        if (e.keyCode == 13) {
            e.preventDefault();

            var p = new SwipeParserObj(TrackData);

            if (p.hasTrack1) {
                var CardType = null;
                var ccn1 = p.account.charAt(0);
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

                $('#pcc_no_' + id).val(p.account);
                $('#pcc_holder_' + id).val(p.account_name);
                $('#pcc_month_' + id).val(p.exp_month);
                $('#pcc_year_' + id).val(p.exp_year);
                $('#pcc_cvv2_' + id).val('');
                $('#pcc_type_' + id).val(CardType);
                self.val('');
            }
            else {
                $('#pcc_no_' + id).val('');
                $('#pcc_holder_' + id).val('');
                $('#pcc_month_' + id).val('');
                $('#pcc_year_' + id).val('');
                $('#pcc_cvv2_' + id).val('');
                $('#pcc_type_' + id).val('');
            }

            $('#pcc_cvv2_' + id).focus();
        }

    }).blur(function (e) {
        $(this).val('');
    }).focus(function (e) {
        $(this).val('');
    });
    let p_val = $('#payment_paid_by').val();
    localStorage.setItem('paid_by', p_val);
    if (p_val == 'cash') {
        $('.pcheque_1').hide();
        $('.pcc_1').hide();
        $('.pcash_1').show();
        $('#amount_1').focus();
    } else if (p_val == 'CC') {
        $('.pcheque_1').hide();
        $('.pcash_1').hide();
        $('.pcc_1').show();
        $('#pcc_no_1').focus();
    } else if (p_val == 'Cheque') {
        $('.pcc_1').hide();
        $('.pcash_1').hide();
        $('.pcheque_1').show();
        $('#cheque_no_1').focus();
    } else {
        $('.pcheque_1').hide();
        $('.pcc_1').hide();
        $('.pcash_1').hide();
    }
    $('#paid_by_1').select2("val", p_val);
});
})(jQuery); 
