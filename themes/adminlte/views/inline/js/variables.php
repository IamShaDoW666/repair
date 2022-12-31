<?php 
    $Settings = $settings;
    if ( !$this->ion_auth->logged_in() )
        unset($Settings->setting_id, $Settings->smtp_user, $Settings->smtp_pass, $Settings->smtp_port,$Settings->default_email, $Settings->smtp_crypto, $Settings->smtp_host, $Settings->google_api_key, $Settings->nexmo_api_key,$Settings->nexmo_api_secret,$Settings->twilio_account_sid,$Settings->twilio_auth_token,$Settings->twilio_number, $Settings->reparation_table_state); 
?>
(function($){ 
    "use strict"; 
    window.base_url = "<?=site_url();?>";
    window.token = "<?=$_SESSION['token']?>";
    window.site = <?= json_encode(array('base_url' => base_url(), 'assets' => $assets,'settings' => $Settings, 'dateFormats' => $dateFormats, 'warranties' => array(
        '0' => lang('no_warranty'),
        '1M' => lang('1M'),
        '2M' => lang('2M'),
        '3M' => lang('3M'),
        '4M' => lang('4M'),
        '5M' => lang('5M'),
        '6M' => lang('6M'),
        '7M' => lang('7M'),
        '8M' => lang('8M'),
        '9M' => lang('9M'),
        '10M' => lang('10M'),
        '11M' => lang('11M'),
        '12M' => lang('12M'),
    ) ));?>;
    window.tax_rates = <?php echo json_encode($taxRates); ?>;
    window.lang = <?php echo json_encode($this->lang->language); ?>;


    window.get_csrf_token_name = "<?= $this->security->get_csrf_token_name() ?>";
    window.get_csrf_hash = "<?= $this->security->get_csrf_hash() ?>";


})(jQuery); 