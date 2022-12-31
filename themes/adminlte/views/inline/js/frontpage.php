(function($){ 
    "use strict"; 

        var base_url = "<?=site_url();?>";
    var site = <?= json_encode(array('base_url' => base_url(), 'dateFormats' => $dateFormats));?>;
    window.lang = <?php echo json_encode($this->lang->language); ?>;

    jQuery(document).ready(function () {
        
        var postJSON;
        postJSON = 'aa'
    
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "progressBar": true,
            "positionClass": "toast-bottom-right",
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
    
        jQuery(document).on("click", "#submit_track", function () {
                $('#loadingmessage').show();  // show the loading message.
    
                var code = jQuery('#code').val();
                var id = jQuery('#repair_id').val();
                var url = "";
                var dataString = "";
                url = site.base_url + "welcome/status";
                dataString = "code=" + code + '&id=' + id;
                jQuery.ajax({
                    type: "POST",
                    url: url,
                    data: dataString,
                    cache: false,
                    dataType: "json",
                    success: function (data) {
                        $('#loadingmessage').hide();
                        if(isEmpty(data)) {toastr['error'](lang.error, lang.main_invalid_code);}
                        else {
                            var status = "<span class='label' style='background-color:"+data.bg_color+"; color:"+data.fg_color+"'>"+data.status+"</span>";
                            toastr['success'](lang.main_success, lang.main_success_code)
                            jQuery('#client_name').html(data.name);
                            jQuery('#status').html(status);
                            jQuery('#date_opening').html(fld(data.date_opening));
                            jQuery('#defect').html(data.defect);
                            jQuery('#model_name').html(data.model_name);
    
                
                            jQuery('#grand_total').html("site.settings.currency "+(parseFloat(data.grand_total)).toFixed(2));
                            jQuery('#advance').html("site.settings.currency "+data.advance);
                            jQuery('#result').fadeIn(1000);
                            jQuery('#comment').html(data.comment);
                            jQuery('#diagnostics').html(data.diagnostics);
    
                            if(data.date_closing == null) {
                            jQuery('.centre_box div.date_closing_div').hide();
                            } else {
                            jQuery('.centre_box div.date_closing_div').fadeIn();
                            jQuery('#date_closing').html(fsd(data.date_closing))
                            }
                        }
                    }
                });
            });
    
        });
    
            <?php if($this->input->get('code')): ?>
        setTimeout(function () {
            $('#submit_track').click();
        }, 500);
        <?php endif;?>
    
        function isEmpty(obj) {
            return Object.keys(obj).length === 0;
        }



    function fld(oObj) {
        if (oObj != null) {
            var aDate = oObj.split('-');
            var bDate = aDate[2].split(' ');
            let year = aDate[0], month = aDate[1], day = bDate[0], time = bDate[1];
            if (site.dateFormats.js_sdate == 'dd-mm-yyyy') return day + '-' + month + '-' + year + ' ' + time;
            else if (site.dateFormats.js_sdate === 'dd/mm/yyyy') return day + '/' + month + '/' + year + ' ' + time;
            else if (site.dateFormats.js_sdate == 'dd.mm.yyyy') return day + '.' + month + '.' + year + ' ' + time;
            else if (site.dateFormats.js_sdate == 'mm/dd/yyyy') return month + '/' + day + '/' + year + ' ' + time;
            else if (site.dateFormats.js_sdate == 'mm-dd-yyyy') return month + '-' + day + '-' + year + ' ' + time;
            else if (site.dateFormats.js_sdate == 'mm.dd.yyyy') return month + '.' + day + '.' + year + ' ' + time;
            else return oObj;
        } else {
            return '';
        }
    }
})(jQuery); 
