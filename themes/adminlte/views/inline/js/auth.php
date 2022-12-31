(function($){ 
    "use strict"; 
    <?php if ($this->mSettings->enable_recaptcha): ?>
    window.onload = function() {
      var recaptcha = document.forms["login_form"]["g-recaptcha-response"];
      recaptcha.required = true;
      recaptcha.oninvalid = function(e) {
        alert(lang.complete_captcha);
      }
    }
    <?php endif; ?>
})(jQuery); 