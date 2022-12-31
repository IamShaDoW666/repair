(function($){ 
    "use strict"; 
        $(document).ready(function() {
            $('#total_cash_submitted').change(function(e) {
                if ($(this).val() && !is_numeric($(this).val())) {
                    bootbox.alert("Unexpected Value");
                    $(this).val('');
                }
            })
        });

        function countCash(class_cur, amount) {
            var total = amount * $("."+class_cur).val();
            $(".v" + class_cur).val(total.toFixed(2));
            getTotal();
        }

        function countTotal(class_cur, amount) {
            var round_amount = Math.round($(".v" + class_cur).val() / amount) * amount;
            $(".v" + class_cur).val(round_amount.toFixed(2));
            $("."+class_cur).val((round_amount.toFixed(2) / amount));
            getTotal();
        }

        function getTotal() {
            var total = 0;
            $('.cash').each(function(){
                total += parseFloat($(this).val());
            });
            $("#total_cash_submitted").val(total.toFixed(2));
            return total;
        }
})(jQuery); 