(function($){ 
    "use strict"; 

    $(document).ready(function() {
        let customer_email = $('#customer_email').val();
        let invoice_id = $('#invoice_id').val();
        jQuery(document).on("click", "#email_button", function() {
            bootbox.prompt({
                title: "Enter Email Address",
                inputType: 'email',
                value: customer_email,
                callback: function (email) {
                    if (email != null) {
                        $.ajax({
                            type: "post",
                            url: "<?= base_url('panel/pos/email_receipt') ?>",
                            data: {email: email, id: invoice_id},
                            dataType: "json",
                            success: function (data) {
                                toastr.success(data.msg);
                            },
                            error: function () {
                                toastr.error(lang.ajax_request_failed);
                                return false;
                            }
                        });
                    }
                }
            });
            return false;
        });
    });
})(jQuery); 
