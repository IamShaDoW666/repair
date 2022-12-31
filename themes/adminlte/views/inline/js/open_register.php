(function($){ 
    "use strict"; 

    $(document).ready(function() {
      $('#cash_in_hand').change(function(e) {
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
        $("#cash_in_hand").val(total.toFixed(2));
        return total;

    }

    jQuery(document).on("submit", "#open_register_form", function (e) {
      e.preventDefault();
      $('#open_register_form')[0].submit();
    })


    jQuery(document).ready( function($) {

// Disable scroll when focused on a number input.

$('form').on('focus', 'input[type=number]', function(e) {

    $(this).on('wheel', function(e) {

        e.preventDefault();

    });

});



// Restore scroll on number inputs.

$('form').on('blur', 'input[type=number]', function(e) {

    $(this).off('wheel');

});



// Disable up and down keys.

$('form').on('keydown', 'input[type=number]', function(e) {

    if ( e.which == 38 || e.which == 40 )

        e.preventDefault();

});  

  

});
})(jQuery); 
