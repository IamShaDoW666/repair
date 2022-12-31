(function($){ 
    "use strict"; 
    $.widget.bridge('uibutton', $.ui.button)
  



    $(document).ready(function () {


        $("input[data-bootstrap-switch]").each(function(){
        $(this).bootstrapSwitch('state', $(this).prop('checked'));
        })

        $(document).on('click', '#add_product_row', function(e) {
            add_product_item({
            "id":"manual" + jQuery.now(),
            "label":"",
            "code":"manual" + jQuery.now(),
            "name":"",
            "price":0,
            "qty":1,
            "available_now":0,
            "total_qty":0,
            "type":"manual",
            "value":""
            }, true)
        });
        $(document).on('click', '.row_status', function(e) {
            var row = $(this).parent().closest('tr');
            var id = row.attr('id');

            $('#myModal .modal-dialog').load(site.base_url + 'panel/reparation/update_status/' + id);
            $('#myModal').modal('show');
            return false;
        });
    
    
        jQuery(document).on("click", "#status_change", function() {
            var id = jQuery(this).data("num");
            $('#myModal .modal-dialog').load(site.base_url + 'panel/reparation/update_status/' + id);
            $('#myModal').modal('show');
            return false;
        });
    
    
        $(":input").keypress(function(event){
            if ((event.which == '10' || event.which == '13') && event.target.nodeName !== 'TEXTAREA') {
                event.preventDefault();
            }
        });
        $("#model_name").select2({
            tags: true,
            tokenSeparators: [','],
            selectOnClose: true,
        });
    });
       
    function isEmptyObject(obj) {
        if (obj == null) return true;
        if (obj.length > 0)    return false;
        if (obj.length === 0)  return true;
        if (typeof obj !== "object") return true;
        for (var key in obj) {
            if (hasOwnProperty.call(obj, key)) return false;
        }
        return true;
    }
        
    window.client_name = function(x) {
        x = x.split('___');
        return `<a class="view_client" href="#view_client" data-toggle="modal" data-num="${x[0]}">${x[1]}</a>`;
    }

    window.status_ = function(x) {
        if (x == 'cancelled') {
            return '<div class="text-center"><span class="row_status badge" style="background-color:#000;"><?=lang('cancelled');?></span></div>';
        }
        x = x.split('____');
        return '<div class="text-center"><span id="" data-num="'+x[3]+'" data-repair="'+x[4]+'" class="row_status badge" style="background-color:'+x[1]+'; color:'+x[2]+';">'+x[0]+'</span></div>';
    }
    window.update_by = function(x) {
        if (x=='') {
            return lang.not_modified;
        }
        return x;
    }
    window.formatPayments = function(x) {
        if (x) {
            let payments = x.split(',');
            let paid = "";
            payments.forEach(payment => {
                let pay = payment.split('____');
                paid += pay[0] + ": " + formatMyDecimal(pay[1]) + "\n";
            });
            return paid;
        }
        return 0;
    }

    var substringMatcher = function(strs) {
        return function findMatches(q, cb) {
        var matches, substringRegex;
    
        // an array that will be populated with substring matches
        matches = [];
    
        // regex used to determine if a string contains the substring `q`
        let substrRegex = new RegExp(q, 'i');
    
        // iterate through the pool of strings and for any string that
        // contains the substring `q`, add it to the `matches` array
        strs.forEach(str => {
            if (substrRegex.test(str)) {
                matches.push(str);
            }
        });
    
        cb(matches);
        };
    };
    
    var manufacturers = [
        <?php foreach ($manufacturers as $manufacturer): ?>
            '<?=$manufacturer->name;?>',
        <?php endforeach; ?>
    ];
    $('.manufacturer_name_typeahead').typeahead({
        hint: true,
        highlight: true,
        minLength: 1
    }, {
        name: 'manufacturers',
        source: substringMatcher(manufacturers)
    });
    
    
    var categories = [
        <?php foreach (explode(',', $settings->category) as $line): ?>
            '<?=$line;?>',
        <?php endforeach; ?>
    ];
    $('.categories_typeahead').typeahead({
        hint: true,
        highlight: true,
        minLength: 1
    }, {
        name: 'categories',
        source: substringMatcher(categories)
    });
    
    $('.model_name_typeahead').typeahead(null, {
        name: 'model',
        display: 'name',
        source: function(query, syncResults, asyncResults) {
            $.get( site.base_url + 'panel/inventory/getModels/'+query+'?manufacturer='+encodeURI($('#reparation_manufacturer').val()), function(data) {
                asyncResults(data);
            });
        }
    });
    
    var defectSuggestions = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            url: site.base_url + 'panel/reparation/getDefects/%QUERY',
            wildcard: '%QUERY'
        }
    });
    
    $('.defect_typeahead').typeahead(null, {
        name: 'defect',
        display: 'defect',
        source: defectSuggestions
    });
    
    
    jQuery(".add_model").on("click", function (e) {
        $('#modelmodal').modal('show');
        $('#model_form').trigger("reset");
        $("#model_name").val("").trigger('change');
        $('#model_form').parsley().reset();

        jQuery('#model_title_head').html(lang.add + " " + lang.model_title);

        jQuery('#model_footer').html('<button data-dismiss="modal" class="pull-left btn btn-default" type="button"><i class="fa fa-reply"></i> '+lang.go_back+'</button><button id="submit_model" role="button" form="model_form" class="btn btn-success" data-mode="add"><i class="fa fa-user"></i> ' + lang.add + ' ' + lang.model_title + '</button>');
    });
    
    $(function () {
        $('#model_form').parsley({
        errorsContainer: function(pEle) {
            var $err = pEle.$element.closest('.form-group');
            return $err;
        }
        }).on('form:submit', function(event) {
        var mode = jQuery('#submit_model').data("mode");
        var id = jQuery('#submit_model').data("num");
    
        var name = jQuery('#model_name').val();
        var manufacturer = jQuery('#manufacturer_name').val();
        
        var url = "";
        var dataString = "";
    
        if (mode == "add") {
            url = base_url + "panel/inventory/add_model";
            dataString = $('#model_form').serialize();
            jQuery.ajax({
                type: "POST",
                url: url,
                data: dataString,
                cache: false,
                success: function (data) {
                    toastr['success'](lang.add, lang.model_title + ": " + name + " " + manufacturer + lang.added);

                    setTimeout(function () {
                        $('#modelmodal').modal('hide');
                        if ($('#reparationmodal').hasClass('show')) {
                            jQuery('#model').append('<option value="'+data+'">'+name+'</option>');
                            jQuery('#model').val(data);
                            $("#model").select2();
                        }else{
                            $('#dynamic-table').DataTable().ajax.reload();
                        }
                    }, 500);
    
                }
            });
        } else {
            url = base_url + "panel/inventory/edit_model";
            dataString = $('#model_form').serialize() + "&id=" + encodeURI(id);
            jQuery.ajax({
                type: "POST",
                url: url,
                data: dataString,
                cache: false,
                success: function (data) {
                    
                    
                    toastr['success'](lang.save,  lang.model_title + ': ' + name + " " + manufacturer +  " " + lang.updated);
                    
                    setTimeout(function () {
                        $('#modelmodal').modal('hide');
                        $('#dynamic-table').DataTable().ajax.reload();
                    }, 500);
                }
            });
        }
        return false;
        });
    });
    

    
    
    $(document).ready(function () {
        jQuery("#submit_prerepairs").on("click", function (e) {
            e.preventDefault();
            $('#preprepair_hide').empty();
            $('#prerepair_form :input').not(':submit').clone().hide().appendTo('#preprepair_hide');
            $('#prerepair').modal('hide');
        });
        jQuery("#exit_prepair").on("click", function (e) {
            e.preventDefault();
            $('#preprepair_hide').empty();
            $('#prerepair_form :input').not(':submit').clone().hide().appendTo('#preprepair_hide');
            $('#prerepair').modal('hide');
        });
    
        jQuery(document).on("click", ".prerepair_show", function(event) {
            event.preventDefault();
            $('#preprepair_hide').empty();
            $('#prerepair').modal({
                backdrop: 'static',
                keyboard: false
            }).appendTo('body');
        });
            
    });


    function IDGenerate() {
        var text = "";
        var hdntxt = "";
        var captchatext = "";
        var possible = "ABCDEFGHIkLMNOPQRSTUVWXYZ0123456789";
        for (var i = 0; i < 6; i++) {
            text += possible.charAt(Math.floor(Math.random() * possible.length));         
        }
    
        return text;
    }
    
    
    function update_by(x) {
        if (x=='') {
            return lang.not_modified;
        }
        return x;
    }
    jQuery(document).on("click", ".view", function () {
        var num = jQuery(this).data("num");
        find_reparation(num);
    });
    jQuery(document).on("click", ".view_client", function () {
        var num = jQuery(this).data("num");
        find_client(num);
    });
    
    var lock = null;
    $(document).ready(function () {
        lock = new PatternLock('#patternHolder',{
            enableSetPattern : true,
            onDraw:function(pattern){
                $('#patternlock').val(pattern);
            }
        });
    });
    function setEditPattern(argument) {
        lock.setPattern(argument);
    }
    function alphanumeric_unique() {
        return Math.random().toString(36).split('').filter( function(value, index, self) { 
            return self.indexOf(value) === index;
        }).join('').substr(2,8);
    }    
    jQuery(document).on("click", "#sendsmsfast", function() {
        var txt = jQuery('#fastsms').val();
        var number = jQuery('#rv_phone_number').val();
        jQuery.ajax({
            type: "POST",
            url: base_url + "panel/reparation/send_sms",
            data: "text=" + txt + "&number=" + number + "&token=" + token,
            cache: false,
            dataType: "json",
            success: function(data) {
                if(data.status == true) toastr['success']("<?= $this->lang->line('quick_sms');?>", '<?= $this->lang->line('sms_sent');?>');
                else toastr['error']("<?= $this->lang->line('quick_sms');?>", '<?= $this->lang->line('sms_not_sent');?>');
            }
        });
    });
    jQuery(document).on("click", "#delete_reparation", function () {
        var num = jQuery(this).data("num");
        bootbox.prompt({
            title: "Are you sure!",
            inputType: 'checkbox',
            inputOptions: [
                {
                    text: lang['want_to_add_to_stock-delete'],
                    value: '1',
                },
            ],
            callback: function (result) {
                if (result) {
                    var add_to_stock = false;
                    if (result.length == 1) {
                        add_to_stock = true;
                    }
                    jQuery.ajax({
                        type: "POST",
                        url: base_url + "panel/reparation/delete",
                        data: "id=" + encodeURI(num) + "&add_to_stock=" + encodeURI(add_to_stock),
                        cache: false,
                        dataType: "json",
                        success: function (data) {
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
                            toastr['success'](lang.deleted + ": ", lang.reparation_deleted);
                            $('#dynamic-table').DataTable().ajax.reload();
                        }
                    });
                }
            }
        });
    });


    jQuery(document).on("change", "#has_warranty", function () {
    if (parseInt($(this).val()) == 1) {
        $('#date_of_purchase').attr('required', true);
        $('#error_code').attr('required', true);
        $('#warranty_card_number').attr('required', true);
    }else{
        $('#date_of_purchase').removeAttr('required');
        $('#error_code').removeAttr('required');
        $('#warranty_card_number').removeAttr('required');
    }
    });
    
    
    jQuery(document).on("click", "#sign_repair", function () {
        let num = $(this).data('num');
        let mode = $(this).data('mode');
        $('#submit_sign').data('mode', mode);
        jQuery.ajax({
            type: "POST",
            url: site.base_url + "panel/misc/check_repair_signature",
            data: 'id='+num,
            cache: false,
            success: function (data) {
                $('#signature').html('');
                $('#submit_sign').hide();
                $('#reset_sign').hide();
                $('#sign_id').val(num);
                if (!data.exists) {
                    $('#signature_label').html(lang.customer_signature_sign_below);
                    $("#signature").jSignature();
                    $("#signature").resize();
                    $('#submit_sign').show();
                    $('#reset_sign').show();
                }else{
                    $('#signature_label').html(lang.customer_signature);
                    $("#signature").html('<img height="200px" src="<?= base_url('assets/uploads/signs/repair_'); ?>'+(data.name)+'">');
                }
            }
        });
    });
    
    jQuery(document).on("click", "#reset_sign", function () {
        $("#signature").jSignature('reset');
    });
    
    jQuery(document).on("click", "#submit_sign", function () {
        let mode = $('#submit_sign').data('mode');
        let num = $('#sign_id').val();
        if (mode == 'update_sign') {
            var datapair = $('#signature').jSignature("getData", 'base30');
            datapair = 'data='+(datapair[1])+'&id='+num;
            jQuery.ajax({
                type: "POST",
                url: site.base_url + "panel/misc/save_repair_signature",
                data: datapair,
                cache: false,
                success: function (data) {
                    $("#signature").jSignature('reset');
                    $('#signModal').modal('hide');
                }
            });
        }else{
            var datapair = $('#signature').jSignature("getData", 'base30');
            $('#repair_sign_id').val(datapair);
            $('#signModal').modal('hide');
        }
    });
    

    var count = 1;
    if(lang.upload_manager) {
        (function ($) {
            "use strict";
            $.fn.fileinputLocales['mylang'] = lang.upload_manager;
        })(window.jQuery);
    }
    jQuery(document).on("click", "#upload_modal_btn", function() {
        mode = $(this).attr('data-mode');
        num = $(this).attr('data-num');
        if (mode == 'edit') {
            $.ajax({
                type: 'POST',
                url: site.base_url + "panel/reparation/getAttachments",
                dataType: "json",
                data:({"id":num}),
                success: function (data) {
                    $('#upload_manager').fileinput('destroy');
                    $("#upload_manager").fileinput({
                        initialPreviewAsData: true, 
                        initialPreview: data.urls,
                        initialPreviewConfig: data.previews,
                        deleteUrl: site.base_url + "panel/reparation/delete_attachment",
                        maxFileSize: 999999,
                        uploadExtraData: {id:num},
                        uploadUrl: site.base_url + "panel/reparation/upload_attachments",
                        uploadAsync: false,
                        overwriteInitial: false,
                        showPreview: true,
                        language: 'mylang',
                    }).on('filebatchuploadsuccess', function(event, data, previewId, index) {
                        $('#dynamic-table').DataTable().ajax.reload();
                    });
                }
            });
        }
        jQuery('#upload_modal').modal("show");
    });
    
    function IDGenerator() {
    
        this.length = 6;
        this.timestamp = +new Date;
        
        var _getRandomInt = function( min, max ) {
            return Math.floor( Math.random() * ( max - min + 1 ) ) + min;
        }
        
        this.generate = function() {
            var ts = this.timestamp.toString();
            var parts = ts.split( "" ).reverse();
            var id = "";
            
            for( var i = 0; i < this.length; ++i ) {
                var index = _getRandomInt( 0, parts.length - 1 );
                id += parts[index];  
            }
            
            return id;
        }
    
        
    }
    
    var submitActor = null;
    
    jQuery(".add_reparation").on("click", function (e) {
        

        $('#preprepair_hide').empty();
        $('#prerepair_form')[0].reset();
    
    
        $("#reparation_manufacturer, #reparation_model, #service_charges").val("").trigger('change');
        $('#rpair_form').find("input[type=text], textarea").val("").trigger('change');
    
        $('#rpair_form').find("select").val("").trigger('change');
        $('#rpair_form').parsley().reset();
        items = {};
        $('#prTable tbody').empty();
        $('#prTable tbody').html(`<tr><td colspan="4">${lang.nothing_to_display}</td></tr>`);
        localStorage.removeItem('slitems');
        loadRItems();
    
        let code = IDGenerate();
        $('#code').val(code);

        // Upload Manager Start
        $('#attachment_data').val('');
        $('#upload_manager').fileinput('destroy');
        $("#upload_manager").fileinput({
            uploadUrl: site.base_url + "panel/reparation/upload_attachments",
            uploadAsync: false,
            language: 'mylang',
        }).on('filebatchuploadsuccess', function(event, data, previewId, index) {
            response = data.response;
            data = JSON.parse(response.data);
            $('#attachment_data').val(data.join(','))
        });
        // Upload Manager End
    
        $('#reparationmodal').modal({
            backdrop: 'static',
            keyboard: false
        });
    
        jQuery('#titReparation').html(lang.add + " " + lang.reparation_title);
    
        
        $('.footerReparation').remove();
        let footer = '<div class="col-xs-12 col-md-6 footerReparation">';


        footer += `
            <button id="upload_modal_btn" class="btn btn-success " data-mode="add"><i class="fa fa-cloud"></i> <span class="d-none d-sm-inline">${lang.upload_file}</span></button>`;

        footer += `<button class="btn btn-primary" id="sign_repair" href="#signModal" data-toggle="modal" data-mode="add_signature"><i class="fas fa-signature"></i> <span class="d-none d-sm-inline">${lang.sign_repair}</span></button>`;


        footer += `<button href="#prerepair" class="prerepair_show btn btn-primary"><i class="fa fa-plus-circle"></i> <span class="d-none d-sm-inline">${lang.pre_repair_checklist}</span></button>`;

        footer += `<button id="repair_submit"  role="button" form="rpair_form"  class="repair_submit btn btn-success" data-mode="add"><i class="fa fa-plus"></i>${lang.add}</span></button>`;
        footer += `<button id="repair_submit_"  role="button" form="rpair_form"  class="repair_submit btn btn-success" data-again="true" data-mode="add"><i class="fa fa-plus"></i> ${lang.add_again}</span></button>`;

        footer += '</div>';
        jQuery('#footerReparationDiv').append(footer);

        let $submitActors = $('.repair_submit');
        $('.repair_submit').on("click", function (e) {
            submitActor = $(this);
        });

    });
    jQuery(document).on("click", "#modify_reparation", function () {
        $('#rpair_form').find("input[type=text], textarea").val("");
        $('#rpair_form').find("select").val("").trigger('change');
        var num = $(this).data('num');
        jQuery('#titReparation').html(`${lang.edit} ${lang.reparation_title}`);
        jQuery.ajax({
            type: "POST",
            url: base_url + "panel/reparation/getReparationByID",
            data: "id=" + encodeURI(num) + "&token=" + token,
            cache: false,
            dataType: "json",
            success: function (data) {
                if (data.status < 1) {
                    toastr['error'](lang.cancelled_reparation_not_editable);
                    $('#reparationmodal').modal('hide');
                    return;
                }
                
                jQuery('#r_order_discount').val(data.order_discount);

                jQuery('#titReparation').html(lang.edit + " " + lang.reparation_title + data.model_name);
                jQuery('#warranty').val(data.warranty).trigger("change");

                $('#client_name').append(new Option(data.name, data.client_id, false, true)).trigger('change');
                //  jQuery('#client_name').val(parseInt(data.client_id)).trigger("change");
                jQuery('#category').val(data.category);
                jQuery('#reparation_model').val(data.model_name);
                jQuery('#reparation_manufacturer').val(data.manufacturer);
                jQuery('#defect').val(data.defect);
                jQuery('#service_charges').val(data.service_charges);
                jQuery('#potax2').val(parseInt(data.tax_id)).trigger("change");
                jQuery('#assigned_to').val(parseInt(data.assigned_to)).trigger("change");
                jQuery('#comment').val(data.comment);
                jQuery('#imei').val(data.imei);
                jQuery('#diagnostics').val(data.diagnostics);
                jQuery('#expected_close_date').val(fsd(data.expected_close_date));
    
                jQuery('#has_warranty').val(data.has_warranty).trigger("change");
                jQuery('#accessories').val(data.accessories);
                jQuery('#repair_type').val(data.repair_type);
                jQuery('#warranty_card_number').val(data.warranty_card_number);
                jQuery('#date_of_purchase').val(fsd(data.date_of_purchase));
                jQuery('#client_date').val(fsd(data.client_date));
    
                jQuery('#error_code').val(data.error_code).trigger("change");
                jQuery('#code').val(data.code);
    
    
                var ci = data.items;
                items = {};
                $('#prTable tbody').empty();
                $('#prTable tbody').html(`<tr><td colspan="4">${lang.nothing_to_display}</td></tr>`);
                localStorage.removeItem('slitems');
                loadRItems();
                $.each(ci, function() { add_product_item(this); });
        
                var IS_JSON = true;
                try {
                    var json = $.parseJSON(data.custom_field);
                } catch(err) {
                    IS_JSON = false;
                }                
    
                if(IS_JSON)  {
                    $.each(json, function(id_field, val_field) {
                        jQuery('#custom_'+id_field).val(val_field);
                    });
                }
    
                    //
                $('#preprepair_hide').empty();
                $('#prerepair_form')[0].reset();
    
                // Custom Toggles
                var IS_JSON = true;
                try {
                    var json = $.parseJSON(data.custom_toggles);
                } catch(err) {
                    IS_JSON = false;
                }
                console.log(data.custom_toggles);
                if(IS_JSON) {
                    $.each(json, function(id_field, val_field) {
                        if (parseInt(val_field) == 1) {
                            document.getElementById('checktoggle_'+id_field).checked = true;
                        }else{
                            document.getElementById('checktoggle_'+id_field).checked = false;
                        }
                    });
                }
    
                jQuery('input[name=cust_pin_code]').val(data.pin_code);
                jQuery('input[name=patternlock]').val(data.pattern);
                if (data.pattern && data.pattern !== '') {
                    setEditPattern(data.pattern);
                }
                $('#prerepair_form :input').not(':submit').clone().hide().appendTo('#preprepair_hide');
    


                $('.footerReparation').remove();
                let footer = '<div class="col-xs-12 col-md-6 footerReparation">';


                footer += `<button id="upload_modal_btn" class="btn btn-success pull-left" data-mode="edit" data-num="${encodeURI(num)}"><i class="fa fa-cloud"></i> <span class="d-none d-sm-inline">${lang.view_attached}</span></button>`;

                footer += `<a id="sign_repair" class="btn btn-success" data-mode="update_sign" href="#signModal"  data-toggle="modal" data-num="${encodeURI(num)}"><i class="fas fa-signature"></i> <span class="d-none d-sm-inline">${lang.sign_repair}</span></a>`;


                footer += `<button href="#prerepair" class="prerepair_show btn btn-primary"><i class="fa fa-plus-circle"></i> <span class="d-none d-sm-inline">${lang.pre_repair_checklist}</span></button>`;



                footer += `
                    <button id="repair_submit" class="repair_submit btn btn-success" role="button" form="rpair_form"  data-mode="modify" data-num="${encodeURI(num)}"><i class="fa fa-save"></i> <span class="d-none d-sm-inline">${lang.save_reparation}</span></button>`;
                    footer += '</div>';
                jQuery('#footerReparationDiv').append(footer);
                
                jQuery('#status_edit').val(data.status).trigger('change');

                if (parseInt(data.sms) === 1) { 
                    $('#repair_sms').prop('checked', true); 
                    $('#repair_sms').bootstrapSwitch('state', true);
                }else{
                    $('#repair_sms').bootstrapSwitch('state', false);
                }

                if (parseInt(data.email) === 1) { 
                $('#repair_email').prop('checked', true); 
                    $('#repair_email').bootstrapSwitch('state', true);
                }else{
                    $('#repair_email').bootstrapSwitch('state', false);
                }

                
        let $submitActors = $('.repair_submit');
        $('.repair_submit').on("click", function (e) {
            submitActor = $(this);
        });

            }
        });
    });
    $("#add_item").autocomplete({
            source: function (request, response) {
                $.ajax({
                    type: 'get',
                    url: '<?= site_url('panel/inventory/suggestions'); ?>',
                    dataType: "json",
                    data: {
                        term: request.term,
                        model_id: $("#model").val(),
                    },
                    success: function (data) {
                        response(data);
                    }
                });
            },
            
            minLength: 1,
            autoFocus: false,
            delay: 250,
            response: function (event, ui) {
                if ($(this).val().length >= 16 && ui.content[0].id == 0) {
                    bootbox.alert(lang.no_product_found, function () {
                        $('#add_item').focus();
                    });
                    $(this).val('');
                }
                else if (ui.content.length == 1 && ui.content[0].id != 0) {
                    ui.item = ui.content[0];
                    $(this).data('ui-autocomplete')._trigger('select', 'autocompleteselect', ui);
                    $(this).autocomplete('close');
                    $(this).removeClass('ui-autocomplete-loading');
                }
                else if (ui.content.length == 1 && ui.content[0].id == 0) {
                    bootbox.alert(lang.no_product_found, function () {
                        $('#add_item').focus();
                    });
                    $(this).val('');
    
                }
            },
            select: function (event, ui) {
                event.preventDefault();
                if (ui.item.id !== 0) {
                    if (ui.item.type != 'service' && parseInt(site.settings.enable_overselling) == 0) {
                        if (ui.item.total_qty > 0) {
                            if (localStorage.getItem('prods')) {
                                let slitems = JSON.parse(localStorage.getItem('prods'));
                                item_id = ui.item.id;
                                if (slitems[item_id]) {
                                    if (slitems[item_id].available_now != 0) {
                                        var row = add_product_item(ui.item);
                                        if (row)
                                            $(this).val('');
                                    }else{
                                        alert(ui.item.label + lang.not_in_stock);
                                    }
                                }else{
                                    var row = add_product_item(ui.item);
                                    if (row)
                                        $(this).val(''); 
                                }
                            }else{
                                    var row = add_product_item(ui.item);
                                    if (row)
                                        $(this).val(''); 
                            }
                        }else{
                            alert(ui.item.label + lang.not_in_stock);
                        }
                    }else{
                        var row = add_product_item(ui.item);
                        if (row)
                            $(this).val(''); 
                    }
    
                    
                } else {
                    bootbox.alert(lang.no_product_found);
                }
            }
        });
        $( "#add_item" ).autocomplete( "option", "appendTo", ".combo" );
    
    
    $(document).on('click', '#add_status_text', function () {
    bootbox.prompt({ 
        title: lang.change_status_desc,
        inputType: 'textarea',
        callback: function (result) {
        if (result) {
            $('#status_text').val(result);
        }
        }
    });
    });
    $(document).on('click', '.del', function () {
        var id = $(this).attr('id');
        $(this).closest('#row_' + id).remove();
        delete items[id];
        if(items.hasOwnProperty(id)) { } else {
            localStorage.setItem('slitems', JSON.stringify(items));
            loadRItems();
            return;
        }
        calculate_price();
    });
    
    if (localStorage.getItem('slitems')) {
        loadRItems();
    }
        function calculate_price() {
            var rows = $('#prTable').children('tbody').children('tr');
            var pp = 0;
            $.each(rows, function () {
                pp += parseFloat(parseFloat($(this).find('.rprice').val())*parseFloat($(this).find('.rquantity').val()));
            });
            var service_charges = $('#service_charges').val() ? parseFloat($('#service_charges').val()) : 0;
            $('#potax2').val();
            $('#price_span').html(parseFloat(pp ? pp : 0, 4));
            var potax2 = $('#potax2').val();
            total = $('#totalprice_span').html();
            total = total ? parseFloat(total) : 0;
            total += service_charges;
            invoice_tax = 0;
            $.each(tax_rates, function () {
                if (this.id == potax2) {
                    if (this.type == 2) {
                        invoice_tax = parseFloat(this.rate);
                    }
                    if (this.type == 1) {
                        invoice_tax = parseFloat((((total) * this.rate) / 100), 4);
                    }
                }
            });


            var product_discount = 0;
            let ds = 0;
            if ($('#r_order_discount').val()) {
                product_discount = $('#r_order_discount').val() ? $('#r_order_discount').val() : '0';
                ds = formatDecimal((parseFloat(product_discount) / parseFloat(total)) * 100);
            }
            $('#rtds').text((ds + '%'));

    
            $('#totalprice_span').html(parseFloat((parseFloat(pp)), 4));
            $('#sc_span').html(formatDecimal(service_charges));
            $('#tax_span').html(parseFloat(invoice_tax ? invoice_tax : 0));
            let gtotal = (total + invoice_tax) - product_discount; 
            $('#gtotal').html(formatDecimal(gtotal));
            return true;
        }

        

        $(document).on('change keyup', '#r_order_discount', function () {
            loadRItems();
        });
        var invoice_tax = null;
        var total = null;
        $('#potax2').on('change', function() {
            var potax2 = $('#potax2').val();
            var service_charges = $('#service_charges').val() ? parseFloat($('#service_charges').val()) : 0;
            total = $('#totalprice_span').html();
            total = total ? parseFloat(total) : 0;
    
            $.each(tax_rates, function () {
                if (this.id == potax2) {
                    if (this.type == 2) {
                        invoice_tax = parseFloat(this.rate);
                    }
                    if (this.type == 1) {
                        invoice_tax = parseFloat((((total) * this.rate) / 100), 4);
                    }
                }
            });


    
            $('#tax_span').html(formatDecimal(invoice_tax));
            $('#gtotal').html(formatDecimal((invoice_tax + total)));
        });
    
    
        
        let old_row_qty = 1;
        let old_row_price = 1;
        
        $('#rpair_form').on("change", '.mname', function () {
            var row = $(this).closest('tr');
            if(row){
                var name = $(this).val(),
                item_id = row.attr('data-item-id');
                console.log(name);

                console.log(item_id);
                if(items[item_id]) {
                    item = items[item_id];
                    console.log(item);

                items[item_id].name = name;
                localStorage.setItem('slitems', JSON.stringify(items));
                }
                
                loadRItems();
            }
            
        });

        $('#rpair_form').on("focus", '.repair_price', function () {
            old_row_price = $(this).val();
        }).on("change", '.repair_price', function () {
            if (!is_numeric($(this).val()) || parseFloat($(this).val()) < 0) {
                $(this).val(old_row_price);
                return;
            }
            var row = $(this).closest('tr');
            if(row){
                var new_price = parseFloat($(this).val()), item_id = row.attr('data-item-id');
                if(items[item_id]){
                item = items[item_id];
                items[item_id].price = new_price;
                localStorage.setItem('slitems', JSON.stringify(items));
                }
                
                loadRItems();
            }
            
        });
        $('#rpair_form').on("focus", '.repair_quantity', function () {
            old_row_qty = $(this).val();
        }).on("change", '.repair_quantity', function () {
            if (!is_numeric($(this).val()) || parseFloat($(this).val()) < 0) {
                $(this).val(old_row_qty);
                return;
            }
            var row = $(this).closest('tr');
            if(row) {
                var new_qty = parseInt($(this).val()),
                item_id = row.attr('data-item-id');
                console.log(new_qty);
                if(items[item_id]){
                    item = items[item_id];
                    items[item_id].qty = new_qty;
                    localStorage.setItem('slitems', JSON.stringify(items));
                }
            
            }
            
            loadRItems();
        });
    
    
        $(document).on('change', '#service_charges', function () {
            calculate_price();
        });
        $(document).on('keyup', '#service_charges', function () {
            calculate_price();
        });
        function loadRItems() {
            if (localStorage.getItem('slitems')) {
                items = JSON.parse(localStorage.getItem('slitems'));
                var pp = 0;
                $("#prTable tbody").empty();
                $.each(items, function () {
                    var row_no = this.id;
                    var item_id = this.id;
                    var newTr = $('<tr id="row_' + row_no + '" class="item_' + this.id + '" data-item-id="' + row_no + '"></tr>');


                    let tr_html = '';
                    if(this.type == 'manual' || this.code.substring(0, 6) == 'manual'){
                        tr_html = '<td><input name="item_id[]" id="item_id" type="hidden" value="' + this.id + '"><input name="item_type[]" id="item_type" type="hidden" value="' + this.type + '"><input name="item_name[]" type="text" class="form-control mname" value="' + this.name + '"><input name="item_code[]" type="hidden" value="' + this.code + '"></td>';
                    }else{
                        tr_html = '<td><input name="item_id[]" id="item_id" type="hidden" value="' + this.id + '"><input name="item_name[]" type="hidden" value="' + this.name + '"><input name="item_code[]" type="hidden" value="' + this.code + '"><span id="name_' + row_no + '">' + this.name + ' (' + this.code + ')</span></td>';
                    }


                    tr_html += '<td>'+'<input class="form-control text-center rquantity repair_quantity" name="item_quantity[]" type="text" value="' + parseInt(this.qty) + '" data-id="' + row_no + '" data-item="' + this.id + '" id="quantity_' + row_no + '" onClick="this.select();"></td>';
                    tr_html += '<td>'+'<input class="form-control text-center rprice repair_price" name="item_price[]" type="text" value="' + formatDecimal(this.price) + '" data-id="' + row_no + '" data-item="' + this.id + '" id="item_price_' + row_no + '" onClick="this.select();"></td>';
                    tr_html += '<td class="text-center"><i class="fa fa-times tip del" id="' + row_no + '" title="Remove" style="cursor:pointer;"></i></td>';
                    newTr.html(tr_html);
                    newTr.prependTo("#prTable");
                    pp += (parseFloat(this.price)*parseFloat(this.qty));
                    $('.item_' + item_id).addClass('warning');
                });
                $('#price_span').html(pp);
                var service_charges = parseFloat($('#service_charges').val());
                var total_ = parseFloat(pp) + service_charges;
                $('#totalprice_span').html(total_);
                var potax2 = $('#potax2').val();
                $.each(tax_rates, function () {
                    if (this.id == potax2) {
                        if (this.type == 2) {
                            invoice_tax = parseFloat(this.rate);
                        }
                        if (this.type == 1) {
                            invoice_tax = parseFloat((((total_) * this.rate) / 100), 4);
                        }
                    }
                });

                var product_discount = 0;
                let ds = 0;
                if ($('#r_order_discount').val()) {
                    product_discount = parseFloat($('#r_order_discount').val() ? $('#r_order_discount').val() : '0');
                    ds = formatDecimal((parseFloat(product_discount) / parseFloat(total_)) * 100);
                }
                
                $('#rtds').text(ds + '%');

                $('#sc_span').html(service_charges?service_charges:0);
                $('#tax_span').html(invoice_tax?invoice_tax:0);
                $('#gtotal').html(formatDecimal((invoice_tax?invoice_tax:0) + (total_?total_:0) - parseFloat(product_discount)));
            }else{
                var service_charges = ($('#service_charges').val()) ? $('#service_charges').val() : '0';
                var potax2 = $('#potax2').val();
                $.each(tax_rates, function () {
                    if (this.id == potax2) {
                        if (this.type == 2) {
                            invoice_tax = formatDecimal(this.rate);
                        }
                        if (this.type == 1) {
                            invoice_tax = formatDecimal((((service_charges) * this.rate) / 100), 4);
                        }
                    }
                });

                var product_discount = 0;
                let ds = 0;
                if ($('#r_order_discount').val()) {
                    product_discount = parseFloat($('#r_order_discount').val() ? $('#r_order_discount').val() : '0');
                    ds = formatDecimal((parseFloat(product_discount) / parseFloat(total_)) * 100);
                }
                
                $('#rtds').text(ds + '%');
                $('#tax_span').html(invoice_tax);
                $('#price_span').html(0);
                $('#sc_span').html(formatDecimal(service_charges?service_charges:0))
                $('#gtotal').html(formatDecimal(parseFloat(service_charges?service_charges:0) + parseFloat(invoice_tax) - parseFloat(product_discount)) );

            }
        }
    let items = {};
    function add_product_item(item, manual = false) {

            if (item == null) {
                return false;
            }
            if(manual){
                items[item.id] = item;
            }else{
            item_id = item.id;
            if (items[item_id]) {
                items[item_id].qty = (parseFloat(items[item_id].qty) + 1).toFixed(2);
                if (item.type != 'service') {
                    items[item_id].available_now = (parseFloat(items[item_id].available_now) - 1).toFixed(2);
                }
            } else {
                items[item_id] = item;
                if (item.type != 'service') {
                    items[item_id].available_now -= 1;
                }
                
            }
            }

            localStorage.setItem('slitems', JSON.stringify(items));
            loadRItems();
            return true;
        }
    $('select').select2({placeholder: lang.select_placeholder, theme: 'bootstrap4'});
    

    $(document).ready(function () {

    
        $('#rpair_form').parsley({
        errorsContainer: function(pEle) {
            var $err = pEle.$element.closest('.form-group');
            return $err;
        }
        }).on('form:submit', function(event) {

        if (null === submitActor) {
            submitActor = $(submitActors[0]);
        }

        jQuery('#repair_submit').attr('disabled', true);
    
        var again = submitActor.data("again");
        var mode = submitActor.data("mode");
        var id = submitActor.data("num");
        var code = jQuery('#code').val();
        var status_code = jQuery('#status_edit').val();
        var url = "";
        var dataString = new FormData($('#rpair_form')[0]);
        if ($('#category_select').val() == 'other') {
            $('#category_select').attr('required', false);
            $('#category_input').attr('required', true);
        }
        dataString.append('code',code);
        dataString.append('status',status_code);
        var sms = $('#repair_sms').prop('checked');
        var email = $('#repair_email').prop('checked');
        dataString.append('sms', sms);
        dataString.append('email', email);
    
        if (mode == "add") {
            if(!again){
            <?php if($settings->open_report_on_repair_add > 0): ?>
                newWindow = window.open("", "_blank");
            <?php endif;?>
            }
            url = base_url + "panel/reparation/add";
            $.ajax({
                url: url,
                type: "POST",
                data:  dataString,
                contentType:false,
                cache: false,
                processData:false,
                success: function (result) {
                    jQuery('#repair_submit').removeAttr('disabled');
    
                    toastr['success'](lang.add, lang.reparation_title + ": " + lang.added);

                    if(again){
                        setTimeout(function () {
                            $('.add_reparation').click();
                            $('#dynamic-table').DataTable().ajax.reload();
                            $('#dynamic-table-completed').DataTable().ajax.reload();
                        }, 500);
                        
                    }else{
                        <?php if($settings->open_report_on_repair_add > 0): ?>
                        newWindow.location = base_url + "panel/reparation/invoice/" + encodeURI(result.id) + "/" + (<?=$settings->open_report_on_repair_add;?>);
                        <?php endif;?>


                        setTimeout(function () {
                            $('#reparationmodal').modal('hide');
                            $('#dynamic-table').DataTable().ajax.reload();
                            $('#dynamic-table-completed').DataTable().ajax.reload();
                        }, 500);
                    }
                    
                    
    
                }
            });
    
        } else {
            url = base_url + "panel/reparation/edit";
            dataString.append('id',id);
            $.ajax({
                url: url,
                type: "POST",
                data:  dataString,
                contentType:false,
                cache: false,
                processData:false,
                success: function (result) {
                    jQuery('#repair_submit').removeAttr('disabled');
                
                    toastr['success'](lang.edit, lang.reparation_title + ": " + name + " " + lang.edited);
                    setTimeout(function () {
                        $('#reparationmodal').modal('hide');
                        $('#dynamic-table').DataTable().ajax.reload();
                        $('#dynamic-table-completed').DataTable().ajax.reload();
                    }, 500);
                }
            });
        }
        return false;
        });


    });

    jQuery('.inp_cat').hide();
    jQuery("#category_select").on("select2:select", function (e) {
        var selected = jQuery("#category_select").val();
        if(selected === 'other') {
            jQuery('.select_cat').hide();
            jQuery('.inp_cat').show();
            jQuery('#category_input').val('');
            jQuery('#category_input').focus();
        } else {
            jQuery('#category_select').val(selected);
        }
    });
    
    function find_reparation(num) {
        jQuery.ajax({
            type: "POST",
            url: base_url + "panel/reparation/getReparationByID",
            data: "id=" + num,
            cache: false,
            dataType: "json",
            success: function(data) {
                console.log(data);
                if (typeof data.name === 'undefined') {
                    alert('Not Found');
                } else {
                    jQuery('#titoloOE').html(lang.reparation_title + ": " + " " + data.model_name + " <span>");
                    jQuery('#rv_client').html(data.name);
                    jQuery('#rv_condition').html(data.status);
                    jQuery('#rv_created_at').html(fld(data.date_opening));
                    jQuery('#rv_defect').html(data.defect);
                    jQuery('#rv_category').html(data.category);
                    jQuery('#rv_model').html(data.manufacturer + ' ' + data.model_name);
                    jQuery('#rv_price').html('site.settings.currency' + formatMoney(data.grand_total));
                    jQuery('#rv_phone_number').html(data.telephone);
                    jQuery('#rv_phone_number').val(data.telephone);
                    jQuery('#rv_rep_code').html(data.code);
                    jQuery('#rv_comment').html(data.comment);
                    jQuery('#rv_imei').html(data.imei);
                    jQuery('#rv_diagnostics').html(data.diagnostics);
                    warranties = site.warranties;
                    jQuery('#rv_warranty').html(warranties[data.warranty]);
    
                    jQuery('.show_custom').html('');
                    var IS_JSON = true;
                    try
                    {
                        var json = $.parseJSON(data.custom_field);
                    }
                    catch(err)
                    {
                        IS_JSON = false;
                    }                
                    if(IS_JSON) 
                    {
                        $.each(json, function(id_field, val_field) {
                            jQuery('#v'+id_field).html(val_field);
                        });
                    }
    
                    var string = "<div class=\"pull-right btn-group\">"+'<span class="pull-left badge badge-info label-xs" style="padding:6px 12px;" ><label for="sms">'+lang.reparation_sms+'</label><input type="checkbox" '+(parseInt(data.sms) === 1 ? 'checked' : '' )+' disabled value="1" name="sms"></span><span  style="padding:6px 12px;" class="pull-left badge badge-warning label-xs"><label for="email">'+lang.send_email_check+'</label><input type="checkbox" '+(parseInt(data.email) === 1 ? 'checked' : '' )+' disabled value="1" name="email"></span>';
                    <?php if($this->Admin || $this->GP['repair-view_files']): ?>
                        string += '<button id="upload_modal_btn" class="btn btn-success pull-left" data-mode="edit" data-num="' + encodeURI(num) + '"><i class="fa fa-cloud"></i> '+lang.view_attached+'</button>';
                    <?php endif;?> 
                    string += `<a target='_blank' href="${site.base_url}panel/reparation/invoice/${data.id}/0/" class="btn btn-default"><i class="fa fa-print"></i> ${lang.report}</a><a target='_blank' href="${site.base_url}/panel/reparation/invoice/${data.id}/1" class="btn btn-default"><i class="fa fa-print"></i> ${lang.invoice}</a><button data-dismiss="modal" class="btn btn-default" type="button"><i class="fa fa-reply"></i> ${lang.go_back}</button></div><div class="btn-group pull-left">`;
    
                    <?php if($this->Admin || $GP['repair-delete']): ?>
                        string += "<button data-dismiss=\"modal\" id=\"delete_reparation\" data-num=\"" + data.id + "\" class=\"btn btn-danger\" type=\"button\"><i class=\"fa fa-trash-o \"></i> "+lang.delete+"</button>";
                    <?php endif; ?>
                    <?php if($this->Admin || $GP['repair-edit']): ?>
                        string += "<button id=\"modify_reparation\" data-dismiss=\"modal\" href=\"#reparationmodal\" data-toggle=\"modal\" data-num=\"" + data.id + "\" class=\"btn btn-success\"><i class=\"fas fa-edit\"></i>"+lang.modify+"</button>";
                    <?php endif; ?>
                    next_status = data.next_status
                    
                    if (data.status > 0 && next_status) {
                        string = string + "<button type=\"button\" id=\"status_change\" class=\"btn btn-primary\" data-to_status=\"" + next_status.id + "\" data-num=\"" + data.id + "\"><i class=\"fa fa-check\"></i> "+lang.update_status+" </button>";
                    }
                    string = string + "</div>";
    
                    if (data.status > 0) {
                        jQuery('#rv_condition').html(data.status_name);
                        jQuery('#rv_condition').css('color',data.fg_color);
                        jQuery('#rv_condition').css('background-color',data.bg_color);
                    } else {
                        jQuery('#rv_condition').html(lang.cancelled);
                        jQuery('#rv_condition').css('color', '#FFF');
                        jQuery('#rv_condition').css('background-color', '#000');
    
                    }
    

                    timeline = `<div class="timeline">
                    <!-- timeline time label -->
                    <div class="time-label">
                        <span class="bg-red">${lang.status_changes_title}</span>
                    </div>
                    <!-- /.timeline-label -->`
                    
    
                    $.each(data.timeline, function(){
                    timeline += ` <!-- timeline item -->
                    <div>
                        <i class="fas ${this.log ? 'fa-edit' : 'fa-envelope'} bg-blue"></i>
                        <div class="timeline-item">
                        <span class="time"><i class="fas fa-clock"></i> ${this.date}</span>
                        <h3 class="timeline-header">${this.log ? lang.edit : this.updated_by_name + ' changed status to ' + this.label}</h3>

                        <div class="timeline-body">
                        ${this.description || (this.log ? '<div class="log">'+printJson(this.log)+'</div>' : '')}
                        </div>
                        
                        </div>
                    </div>
                    <!-- END timeline item -->`;
                    });
    

                    timeline += `<div>
                        <i class="fas fa-clock bg-gray"></i>
                    </div>
                    </div>`;

                    $('#timeline').html(timeline);
    
                    jQuery('#footerOR').html(string);
                }
            }
        });
    }

    function printJson(x){
            var str = '';
        var response=jQuery.parseJSON(x);
        if(typeof response =='object')
        {
        for (var i = 0; i < response.length; i++) {
            if(response[i][0] == 'custom_toggles') {
            }else{
            str += '<b>'+response[i][0]+'</b>' + ': ' +  response[i][1] + ' <i class="fas fa-arrow-right"></i> ' +  response[i][2] + '<br>';
            }
        }

        }
        else
        {
            if(response ===false)
            {
            // the response was a string "false", parseJSON will convert it to boolean false
            }
            else
            {
            // the response was something else
            }
        }
        return str;

    

    }
    jQuery(document).on("click", ".add_c", function (e) {
        $('#clientmodal').modal('show');
        $('#client_form').trigger("reset");
        $('#client_form').parsley().reset();
        $('#showIfImage').hide();
    

        jQuery('#titclienti').html(lang.add + " " + lang.client_title);

        jQuery('#footerClient1').html('<button data-dismiss="modal" class="pull-left btn btn-default" type="button"><i class="fa fa-reply"></i> '+lang.go_back+'</button><button role="button" form="client_form" id="submit_client" class="btn btn-success" data-mode="add"><i class="fa fa-user"></i> '+lang.add + '' + lang.client_title +'</button>');
    });
    
    function showImage(url) {
        var img = new Image();
        img.src = url;
        img.onload = function() {
            bootbox.dialog({ message: "<a target='_blank' href='"+url+"'><center><img src='"+url+"'></center></a>" , backdrop:true, onEscape:true}).find("div.modal-dialog").css({ "width": (this.width)+40+"px"});
        }
    
    };
    
    
    jQuery(document).on("click", "#view_image_in", function (e) {
        e.preventDefault();
        image_name = $(this).attr('data-num');
        if (image_name) {
            showImage(site.base_url + 'assets/uploads/images/'+image_name);
        }else{
            bootbox.alert({
                message: lang.client_no_image,
                backdrop: true
            });
        }
    });
    
    jQuery(document).on("click", "#delete_customer_image", function (e) {
        e.preventDefault();
        var num = jQuery(this).attr("data-num");
        jQuery.ajax({
            type: "POST",
            url: base_url + "panel/customers/delete_image",
            data: "id=" + encodeURI(num),
            cache: false,
            dataType: "json",
            success: function (data) {
                if (data.success) {
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
                    toastr['success']("client image removed");
                    $('#showIfImage').hide();
    
                }else{
                    toastr['error']("error client image not removed");
                }
            }
        });
    });
    
    jQuery(document).on("click", "#modify_client", function () {
            jQuery('#titclienti').html(`${lang.edit} ${lang.client_title}`);
            var num = jQuery(this).data("num");
            $('#client_form').trigger("reset");
            $('#client_form').parsley().reset();
    
            jQuery.ajax({
                type: "POST",
                url: base_url + "panel/customers/getCustomerByID",
                data: "id=" + encodeURI(num) + "&token=" + token,
                cache: false,
                dataType: "json",
                success: function (data) {
                    jQuery('#name1').val(data.name);
                    jQuery('#company1').val(data.company);
                    jQuery('#route').val(data.address);
                    jQuery('#locality').val(data.city)
                    jQuery('#telephone').val(data.telephone);
                    jQuery('#email1').val(data.email)
                    jQuery('#comment1').val(data.comment);
                    jQuery('#postal_code').val(data.postal_code);
                    jQuery('#vat1').val(data.vat);
                    jQuery('#cf1').val(data.cf);
    
                    $('#showIfImage').hide();
                    if (data.image) {
                        $('#showIfImage').show();
                        $('#view_image_in').attr('data-num', data.image);
                        $('#delete_customer_image').attr('data-num', data.id);
                    }
                    jQuery('#footerClient1').html(`<button data-dismiss="modal" class="pull-left btn btn-default" type="button"><i class="fa fa-reply"></i> ${lang.go_back}</button><button id="submit_client" role="button" form="client_form" class="btn btn-success" data-mode="modify" data-num="${encodeURI(num)}"><i class="fa fa-save"></i> ${lang.save} ${lang.client_title}</button>`)
                }
            });
        });
    
    $(function () {

    $( "#client_name" ).select2({
        ajax: {
            url: site.base_url + "panel/customers/getAjax/no",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        },
    });   

    $('#client_form').parsley({
        errorsContainer: function(pEle) {
            var $err = pEle.$element.closest('.form-group');
            return $err;
        }
    }).on('form:submit', function(event) {
        var mode = jQuery('#submit_client').data("mode");
        var id = jQuery('#submit_client').data("num");
    
        var name = jQuery('#name1').val();
        var company = jQuery('#company1').val();
        var address = jQuery('#address1').val();
        var city = jQuery('#city1').val();
        var telephone = jQuery('#telephone').val();
        var email = jQuery('#email1').val();
        var comment = jQuery('#comment1').val();
        var vat = jQuery('#vat1').val();
        var cf = jQuery('#cf1').val();
    
        var url = "";
        var formData = new FormData($('form#client_form')[0]);
        if (mode == "add") {
            url = base_url + "panel/customers/add";
            jQuery.ajax({
                url: url,
                type: 'POST',
                data: formData,
                async: false,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    if(data.success)  {
                        toastr['success'](lang.add, lang.client_title + " " + name + " " + company +  lang.added);
                        if (data.error) {
                            toastr['error'](data.error);
                        }
                        setTimeout(function () {
                            $('#clientmodal').modal('hide');
                            jQuery('#client_name').append('<option value="'+data.id+'">'+name+' '+company+'</option>');
                            if ($('#reparationmodal').hasClass('show')) {
                                $('#client_name').val(data.id);
                                $("#client_name").select2();
                            }else{
                                find_client(data.id);
                                $('#dynamic-table').DataTable().ajax.reload();
                                $('#view_client').modal('show');
                            }
                        }, 500);
                    }else{
                        toastr['error'](data.error);

                    }

                    
                }
            });
        } else {
            formData.append('id', id);
            url = base_url + "panel/customers/edit";
            jQuery.ajax({
                url: url,
                type: 'POST',
                data: formData,
                async: false,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    if(data.success)  {

                        toastr['success'](lang.edit, lang.client_title + ": " + name + " " + company + lang.updated);
                        if (data.error) {
                            toastr['error'](data.error);
                        }
                        setTimeout(function () {
                            $('#clientmodal').modal('hide');
                            find_client(id);
                            $('#dynamic-table').DataTable().ajax.reload();
                            $('#view_client').modal('show');
                        }, 500);
                    }else{
                        toastr['error'](data.error);

                    }
                }
            });
        }
        return false;
    });
    });
    
    
    jQuery(document).on("click", "#status_change_inline", function () {
        var num = jQuery(this).data("num");
        var repair = jQuery(this).data("repair");
        var statuses = <?=json_encode($statuses);?>;
        dropdown = '<select class="form-control" id="status_dropdown" data-repair="'+repair+'">';
        $.each(statuses, function() { 
            dropdown += '<option '+(num==this.id ? 'selected' : '')+' value="'+this.id+'">'+this.label+'</option>';
        });
        dropdown += '</select>';
        $(this).parent().html(dropdown);
    });
    
    jQuery(document).on("change", "#status_dropdown", function () {
    new_value = $(this).val();
    var repair = jQuery(this).data("repair");
    $(this).parent().html(set_status_by_id(new_value));
    // Ajax Change Status
    jQuery.ajax({
        type: "POST",
        url: base_url + "panel/reparation/status_toggle",
        data: "id=" + encodeURI(repair) + "&to_status="+encodeURI(new_value),
        cache: false,
        dataType: "json",
        success: function(data) {
            if (data.success) {
                msg = '';
                if (data.data.sms_sent) {
                    msg += lang.sms_sent + "\n";
                }else{
                    msg += lang.sms_not_sent + "\n";
                }
                if (data.data.email_sent) {
                    msg += lang.email_sent + "\n";
                }else{
                    msg += lang.email_not_sent + "\n";
                }
                toastr['success']( lang.status_changed_to + " " + data.data.label+"\n"+msg);
    
                $('#dynamic-table').DataTable().ajax.reload();
                $('#dynamic-table-completed').DataTable().ajax.reload();
    
            } else {
                toastr['error'](lang.error_support);
            }
        }
    });
    
    
    });
    
    
    function set_status_by_id(id) {
        var statuses = <?=json_encode($statuses);?>;
        status = null;
        $.each(statuses, function() { 
            if (id == this.id) {
                status = this;
            }
        });
        if (status) {
            return '<span class="row_status badge" style="background-color:'+status.bg_color+'; color:'+status.fg_color+';">'+status.label+'</span>';
        }
    }
    
    function reparationID_link(x) {
        x = x.split('___');
        return '<a data-dismiss="modal" class="view" href="#view_reparation" data-toggle="modal" data-num="'+x[0]+'">'+x[1]+'</a>';
    }

    var status_ = function(x) {
        if (x == 'cancelled') {
            return '<div class="text-center"><span class="row_status badge" style="background-color:#000;">'+lang.cancelled+'</span></div>';
        }
        x = x.split('____');
        return '<div class="text-center"><span id="" data-num="'+x[3]+'" data-repair="'+x[4]+'" class="row_status badge" style="background-color:'+x[1]+'; color:'+x[2]+';">'+x[0]+'</span></div>';
   };


    
    // View Client - FIND
    var oTable;
    function find_client(num) {
        jQuery.ajax({
            type: "POST",
            url: base_url + "panel/customers/getCustomerByID",
            data: "id=" + encodeURI(num) + "&token=" + token,
            cache: false,
            dataType: "json",
            success: function (data) {
                if (typeof data.name === 'undefined') {
                    $('#view_client').modal('hide');
                    toastr['error']('No Client', '');
                } else {
                    jQuery('#titoloclienti').html('Client: ' + data.name);
                    jQuery( ".flatb.add" ).data( "name", data.name+' '+data.company);
                    jQuery( ".flatb.add" ).data( "id_name", data.id);
                    jQuery( ".flatb.lista" ).data( "name", data.name+' '+data.company);
                    jQuery('#v_name').html(data.name);
                    jQuery('#v_company').html(data.company);
                    jQuery('#v_address').html(data.address);
                    jQuery('#v_city').html(data.city)
                    jQuery('#v_telephone').html(data.telephone);
                    jQuery('#v_email').html(data.email)
                    jQuery('#v_comment').html(data.comment);
                    jQuery('#v_vat').html(data.vat);
                    jQuery('#v_postal_code').html(data.postal_code);
                    jQuery('#v_cf').html(data.cf);
    
                    if ($.fn.DataTable.isDataTable('#dynamic-table2') ) {
                        $('#dynamic-table2').DataTable().destroy();
                    }
    
                    var tableCR = $('#dynamic-table2').dataTable({
                        "aaSorting": [[3, "asc"]],
                        "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                        "iDisplayLength": parseInt(site.settings.rows_per_page),
                        'bProcessing': true, 'bServerSide': true,
                        'sAjaxSource': site.base_url + 'panel/reparation/getAllReparations/'+data.id,
                        'fnServerData': function (sSource, aoData, fnCallback) {
                            aoData.push({
                                "name": get_csrf_token_name,
                                "name": get_csrf_hash
                            });
                            $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
                        }, 
                        "aoColumns": [
                            {"mRender": reparationID_link},
                            null,
                            null,
                            null,
                            null,
                            {"mRender": status_},
                            null,
                            {"mRender": update_by},
                            {"mRender": formatMyDecimal},
                        ],
                    });
    
                    var string = "<button data-dismiss=\"modal\" class=\"btn btn-default\" type=\"button\"><i class=\"fa fa-reply\"></i> "+lang.go_back+"</button>";
                    <?php if($this->Admin || $GP['customers-edit']): ?>
                        string += "<button data-dismiss=\"modal\" id=\"modify_client\" href=\"#clientmodal\" data-toggle=\"modal\" data-num=\"" + encodeURI(num) + "\" class=\"btn btn-success\"><i class=\"fa fa-pencil\"></i> "+lang.modify+"</button>";
                    <?php endif; ?>
                    <?php if($this->Admin || $GP['customers-delete']): ?>
                        string += "<button id=\"delete_client\" data-dismiss=\"modal\" data-num=\"" + encodeURI(num) + "\" class=\"btn btn-danger\" type=\"button\"><i class=\"fa fa-trash-o \"></i> "+lang.delete+"</button>";
                    <?php endif; ?>
                    jQuery('#footerClient').html(string);
                }
            }
        });
    }
    





    var placeSearch, autocomplete;
    
    var componentForm = {
        street_number: 'long_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        postal_code: 'short_name'
    };
    
    
    function initAutocomplete() {
        if(document.getElementById('autocomplete')) {
        autocomplete = new google.maps.places.Autocomplete(
        (document.getElementById('autocomplete')),
            {types: ['geocode']});
        autocomplete.addListener('place_changed', fillInAddress);
        }
    }
    
    function fillInAddress() {
        var place = autocomplete.getPlace();
    
        for (var component in componentForm) {
        document.getElementById(component).value = '';
        document.getElementById(component).disabled = false;
        }
    
    
        var fullAddress = [];
        for (var i = 0; i < place.address_components.length; i++) {
            var addressType = place.address_components[i].types[0];
            if (componentForm[addressType]) {
                var val = place.address_components[i][componentForm[addressType]];
                document.getElementById(addressType).value = val;
            }
            if (addressType == "street_number") {
                fullAddress[0] = val;
            } else if (addressType == "route") {
                fullAddress[1] = val;
            }
        }
        document.getElementById('route').value = fullAddress.join(" ");
        if (document.getElementById('route').value !== "") {
        document.getElementById('route').disabled = false;
        }
    }
    
    window.geolocate = function(){
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var geolocation = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
                };
                var circle = new google.maps.Circle({
                center: geolocation,
                radius: position.coords.accuracy
                });
                autocomplete.setBounds(circle.getBounds());
            });
        }
    }



        $(function () {
            $('#datetimepicker1').datetimepicker({
                viewMode: 'years',
                format: 'MM/YYYY'
            });
        });




    $(document).ready(function() {
        if($('.todo-list').length) {
            $('.todo-list').sortable({
                placeholder         : 'sort-highlight',
                handle              : '.handle',
                forcePlaceholderSize: true,
                zIndex              : 999999,
                update : function () {
                    var order = $('.todo-list').sortable('serialize', { attribute: 'status-id' });
                    $.post(site.base_url + "panel/settings/updatePosition?"+order);
                }
            });
            $('.my-colorpicker1').colorpicker();
        }
    });


    $(document).ready(function() {
        $('#send_email').change(function() {
            if ($(this).prop('checked')) {
                $('.email_area').slideDown();
                $('#email_text').prop('required', true);
            }else{
                $('.email_area').slideUp();
                $('#email_text').prop('required', false);
            }
        });
        $('#send_sms').change(function() {
            if ($(this).prop('checked')) {
                $('.sms_area').slideDown();
                $('#sms_text').prop('required', true);
            }else{
                $('.sms_area').slideUp();
                $('#sms_text').prop('required', false);
            }
        });
    });

    jQuery("#add_status").on("click", function (e) {
        $('#status_form').trigger("reset");
        $('#status_form').parsley().reset();
        
        $('#status_modal').modal('show');
        $('#status_form').find("input").val("");
        jQuery('#send_sms').prop('checked', false);
        jQuery('#send_email').prop('checked', false);
        jQuery('.email_area').hide();
        jQuery('.sms_area').hide();
        jQuery('#email_text').prop('required', false);
        jQuery('#sms_text').prop('required', false);
        jQuery('#titrstat').html(lang.add + " " + lang.repair_status);

        jQuery('#footerrStat').html('<button data-dismiss="modal" class="pull-left btn btn-default" type="button"><i class="fa fa-reply"></i> '+lang.go_back+'</button><button role="button" form="status_form" id="submit_status" class="btn btn-success" data-mode="add"><i class="fa fa-user"></i> ' + lang.add + ' ' +lang.repair_status+'</button>');
    });


    jQuery(document).on("click", "#delete", function () {
        var div = $(this).parent().parent();
        var num = jQuery(this).data("num");
        jQuery.ajax({
            type: "POST",
            url: base_url + "panel/settings/statusDelete",
            data: "id=" + encodeURI(num),
            cache: false,
            dataType: "json",
            success: function (data) {
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
                if (data.success) {
                    toastr['success'](lang.status_deleted);
                    div.remove();
                    var order = $('.todo-list').sortable('serialize', { attribute: 'status-id' });
                    $.post(site.base_url + "panel/settings/updatePosition?"+order);
                }else{
                    toastr['error'](lang.status_in_use);
                }
            
            }
        });
    });

    jQuery(document).on("click", "#modify_status", function () {
        $('#status_form').trigger("reset");
        $('#status_form').parsley().reset();
        
        jQuery('#titrstat').html(`${lang.edit} ${lang.repair_status}`);
        var num = jQuery(this).data("num");
        jQuery.ajax({
            type: "POST",
            url: base_url + "panel/settings/getStatusByID",
            data: "id=" + encodeURI(num),
            cache: false,
            dataType: "json",
            success: function (result) {
                jQuery('.email_area').hide();
                jQuery('.sms_area').hide();
                jQuery('#email_text').prop('required', false);
                jQuery('#sms_text').prop('required', false);

                let data = result.data;
                jQuery('#label').val(data.label);
                jQuery('#bg_color').val(data.bg_color);
                jQuery('#fg_color').val(data.fg_color);
                jQuery('#email_subject').val(data.email_subject);
                let send_email = data.send_email == "1" ? true : false;
                let send_sms = data.send_sms == "1" ? true : false;
                let completed = data.completed == "1" ? true : false;

                jQuery('#send_email').prop('checked', send_email);
                jQuery('#send_sms').prop('checked', send_sms);
                jQuery('#completed_status').prop('checked', completed);
                
                if (send_email) {
                    jQuery('.email_area').show();
                    $('#email_text').summernote('destroy');
                    jQuery('#email_text').val(data.email_text);
                    $('#email_text').summernote();

                    jQuery('#email_text').prop('required', true);
                }
                if (send_sms) {
                    jQuery('.sms_area').show();
                    jQuery('#sms_text').val(data.sms_text);
                    jQuery('#sms_text').prop('required', true);

                }
                jQuery('#footerrStat').html('<button data-dismiss="modal" class="pull-left btn btn-default" type="button"><i class="fa fa-reply"></i> '+lang.go_back+'</button><button id="submit_status" role="button" form="status_form" class="btn btn-success" data-mode="modify" data-num="' + encodeURI(num) + '"><i class="fa fa-save"></i> '+ lang.save + ' ' + lang.repair_status +'</button>')
            }
        });
    });

    $(function () {
        if($('#status_form').length > 0) {
            $('#status_form').parsley({
                errorsContainer: function(pEle) {
                    var $err = pEle.$element.closest('.form-group');
                    return $err;
                }
            }).on('form:submit', function(event) {
                var mode = jQuery('#submit_status').data("mode");
                var id = jQuery('#submit_status').data("num");
                var url = "";
                var dataString = $('#status_form').serialize();
                if (mode == "add") {
                    url = base_url + "panel/settings/status_add";
                    jQuery.ajax({
                        type: "POST",
                        url: url,
                        data: dataString,
                        cache: false,
                        success: function (data) {
                            toastr['success'](lang.repair_status_added);
                            setTimeout(function () {
                                $('#status_modal').modal('hide');
                                window.location.reload();
                            }, 500);
                        }
                    });
                } else {
                    url = base_url + "panel/settings/status_edit";
                    jQuery.ajax({

                        type: "POST",
                        url: url,
                        data: dataString + "&id=" + encodeURI(id),
                        cache: false,
                        success: function (data) {
                            toastr['success'](lang.repair_status_edited);
                            setTimeout(function () {
                                $('#status_modal').modal('hide');
                                window.location.reload();
                            }, 500);
                        }
                    });
                }
                return false;
            });
        }
        
    });

    // <!-- settings -->
    jQuery(document).ready(function () {
            if ($('#protocol').val() == 'smtp') {
                $('#smtp_config').slideDown();
            } else if ($('#protocol').val() == 'sendmail') {
                $('#sendmail_config').slideDown();
            }else if ($('#protocol').val() == 'mailchimp') {
                $('#mailchimp_config').slideDown();
            }
            $('#protocol').change(function () {
                if ($(this).val() == 'smtp') {
                    $('#sendmail_config').slideUp();
                    $('#mailchimp_config').slideUp();
                    $('#smtp_config').slideDown();
                } else if ($(this).val() == 'sendmail') {
                    $('#smtp_config').slideUp();
                    $('#mailchimp_config').slideUp();
                    $('#sendmail_config').slideDown();
                } else if ($(this).val() == 'mailchimp') {
                    $('#smtp_config').slideUp();
                    $('#sendmail_config').slideUp();
                    $('#mailchimp_config').slideDown();
                } else {
                    $('#smtp_config').slideUp();
                    $('#mailchimp_config').slideUp();
                    $('#sendmail_config').slideUp();
                }
            });
            $('.my-colorpicker1').colorpicker();

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

        jQuery(document).on("click", "#submit", function () {
            var url = "";
            var dataString = "";

            url = base_url + "panel/settings/save_settings";
            var dataString = $('#settings_form').serialize() + "&token="+ token;

            jQuery.ajax({
                type: "POST",
                url: url,
                data: dataString,
                cache: false,
                success: function (data) {
                    toastr['success'](lang.system_settings, lang.settings_updated);
                    $("#black").fadeIn(100);
                    window.location.reload();
                }
            });
            return false;
        });


            jQuery(document).on("click", ".nav-tabs a", function () {
                $(this).tab('show');
            });

            if(window.location.hash) {
                let hashe = window.location.hash;
                let link = hashe.split('__');
                $('.nav-tabs a[href="'+link[0]+'"]').tab('show') // Select tab by name
            }

            $('.more-list li a').on('click', function (e) {
                var link = $(this).attr('href');
                var link = link.substring(link.indexOf('#')+1);
                $('.nav-tabs a[href="#'+link+'"]').tab('show') // Select tab by name
                window.scrollTo(0, 0);
            });

            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            var target = $(e.target).attr("href") // activated tab
            if (target === '#appearance') {
                $('#logo_upload_div').show();
            }else{
                $('#logo_upload_div').hide();
            }
            });
    

        jQuery(document).on("click", "#twilio", function () {
            jQuery(".twilio-info").fadeTo( 120 , 1);
            jQuery(".nexmo-info").fadeTo( 120 , 0.3);
            jQuery(".smsgateway-info").fadeTo( 120 , 0.3);
            jQuery(".http_api-info").fadeTo( 120 , 0.3);
            jQuery(".message-bird-info").fadeTo( 120 , 0.3);

        });
        

        jQuery(document).on("click", "#nexmo", function () {
            jQuery(".nexmo-info").fadeTo( 120 , 1);
            jQuery(".twilio-info").fadeTo( 120 , 0.3);
            jQuery(".smsgateway-info").fadeTo( 120 , 0.3);
            jQuery(".http_api-info").fadeTo( 120 , 0.3);
            jQuery(".message-bird-info").fadeTo( 120 , 0.3);

        });

        jQuery(document).on("click", "#smsgateway", function () {
            jQuery(".smsgateway-info").fadeTo( 120 , 1);
            jQuery(".nexmo-info").fadeTo( 120 , 0.3);
            jQuery(".twilio-info").fadeTo( 120 , 0.3);
            jQuery(".http_api-info").fadeTo( 120 , 0.3);
            jQuery(".message-bird-info").fadeTo( 120 , 0.3);

        });

        jQuery(document).on("click", "#http_api", function () {
            jQuery(".http_api-info").fadeTo( 120 , 1);
            jQuery(".nexmo-info").fadeTo( 120 , 0.3);
            jQuery(".twilio-info").fadeTo( 120 , 0.3);
            jQuery(".smsgateway-info").fadeTo( 120 , 0.3);
            jQuery(".message-bird-info").fadeTo( 120 , 0.3);
        });

        jQuery(document).on("click", "#message-bird", function () {
            jQuery(".message-bird-info").fadeTo( 120 , 1);
            jQuery(".nexmo-info").fadeTo( 120 , 0.3);
            jQuery(".twilio-info").fadeTo( 120 , 0.3);
            jQuery(".smsgateway-info").fadeTo( 120 , 0.3);
            jQuery(".http_api-info").fadeTo( 120 , 0.3);
        });


        $("#t_mode").select2({placeholder: "Twilio Mode"});

        $("#category").select2({tags: true, tokenSeparators: [','],});
        $("#repair_custom_toggles").select2({tags: true, tokenSeparators: [','],});

        $("#custom_fields").select2({tags: true, tokenSeparators: [',']});


        jQuery(document).on("click", ".nav-tabs a", function () {
            $(this).tab('show');
        });


        if(window.location.hash) {
            $('.nav-tabs a[href="'+window.location.hash+'"]').tab('show') // Select tab by name
        }


        $("#logo_upload").change(function() {
            $("#error_message").empty(); // To remove the previous error message
            var file = this.files[0];
            var imagefile = file.type;
            var match= ["image/jpeg","image/png","image/jpg"];
            if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
            {
                $('#preview_logo').attr('src','<?=site_url('img').'/'.$settings->logo;?>');
                toastr['error'](lang.image_upload, lang.error);
                return false;
            }
            else
            {
                toastr['info'](lang.info, lang.uploading_image);
                var reader = new FileReader();
                reader.onload = imageIsLoaded;
                reader.readAsDataURL(this.files[0]);
                $( "#uploadimage .submit" ).trigger( "click" );
            }
        });


        jQuery(document).on("submit", "#uploadimage", function (event) {
            event.preventDefault();
            var formData = new FormData($(this)[0]);            

            var request = $.ajax({
                type: 'POST',
                url: base_url + 'panel/settings/upload_image',
                data: formData,
                contentType: false,
                processData: false,
                success: function(data){   
                    if(data != 'true') {
                        toastr['success'](lang.upload_success, lang.image)
                    } else {
                        toastr['error'](lang.error, "");
                    }
                }
            });             
        });

        jQuery(document).on("submit", "#uploadBackground", function (event) {
            event.preventDefault();
            var formData = new FormData($(this)[0]);            

            var request = $.ajax({
                type: 'POST',
                url: base_url + 'panel/settings/upload_background',
                data: formData,
                contentType: false,
                processData: false,
                success: function(data){   
                    if(data != 'true') {
                        toastr['success'](lang.upload_success, lang.image)
                    } else {
                        toastr['error'](lang.error, "");
                    }
                }
            });             
        });
        

    $("#background_upload").change(function() {
        $("#error_message").empty(); // To remove the previous error message
        var file = this.files[0];
        var imagefile = file.type;
        var match= ["image/jpeg","image/png","image/jpg"];
        if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
        {
            $('#preview_background').attr('src','<?=site_url('img').'/'.$settings->background;?>');
            toastr['error'](lang.image_upload, lang.error);
            return false;
        }
        else
        {
            toastr['error'](lang.info, lang.uploading_image);
            var reader = new FileReader();
            reader.onload = BGimageIsLoaded;
            reader.readAsDataURL(this.files[0]);
            $( "#uploadBackground .submit" ).trigger( "click" );
        }
    });


        function BGimageIsLoaded(e) {
                $('#preview_background').attr('src', e.target.result);
        };

        function imageIsLoaded(e) {
            $('#preview_logo').attr('src', e.target.result);
        };

        $.fn.realVal = function(){
            var $obj = $(this);
            var val = $obj.val();
            var type = $obj.attr('type');
            if (type && type==='checkbox') {
                var un_val = $obj.attr('data-unchecked');
                if (typeof un_val==='undefined') un_val = '';
                return $obj.prop('checked') ? val : un_val;
            } else {
                return val;
            }
        };

        var addRule = function(sheet, selector, styles) {
            if (sheet.insertRule) return sheet.insertRule(selector + " {" + styles + "}", sheet.cssRules.length);
            if (sheet.addRule) return sheet.addRule(selector, styles);
        };
    });




    $('#myModal').on('hidden.bs.modal', function () {
    $(this).removeData('bs.modal');
    });
    $('#myModalLG').on('hidden.bs.modal', function () {
    $(this).removeData('bs.modal');
    });
    $.widget.bridge('uibutton', $.ui.button);
    $.extend(true, $.fn.dataTable.defaults, {"oLanguage":lang.datatables_lang});
    jQuery(document).on("click", "#add_timestamp", function (e) {
        comment = $(this).next();
        comment.val(comment.val() + moment().format('DD-MM-YYYY @ hh:mm')+'h ');
        comment.focus();
    });


    <?php if ( $this->ion_auth->logged_in() ): ?>
        jQuery(document).on("submit", "#sendEmail", function (e) {
    e.preventDefault();
    $('#loadingmessage').show();  // show the loading message.
    emailto = jQuery('#emailto').val();
    subject = jQuery('#subject').val();
    body = jQuery('#body').val();
    jQuery.ajax({
        type: "POST",
        url: base_url + "panel/welcome/send_mail",
        data: $('#sendEmail').serialize(),
        cache: false,
        dataType: "json",
        success: function (data) {
        $('#loadingmessage').hide();
        if (data == 2) {
            toastr.info(lang.field_empty);
        }else if (data == 1) {
            toastr.success(lang.email_sent);
        }else{
            toastr.warning(lang.email_not_sent);
        }
        }
    });
    });
    jQuery(document).on("submit", "#SendSMS", function (e) {
    e.preventDefault();
    let dta = $(this).serialize();
    jQuery.ajax({
        type: "POST",
        url: base_url + "panel/reparation/send_sms",
        data: dta,
        cache: false,
        dataType: "json",
        success: function(data) {
            if(data.status == true) {
                toastr.success(lang.sms_sent);
            } else{
                toastr.warning(lang.sms_not_sent);
            }
        }  
    });
    });
    <?php endif;?>
    $(document).ready(function () {
        $('.summernote').summernote();
        $('input[type=checkbox]').iCheck({
            checkboxClass: 'icheckbox_flat',
            radioClass: 'iradio_flat'
        });
        $('#GPData').dataTable({
            "aaSorting": [[0, "asc"]],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, lang.all]],
            "iDisplayLength": 10,
        });
        $('.tip').tooltip();
        $(document).on('click', '.po-delete', function () {
            var id = $(this).attr('id');
            $(this).closest('tr').remove();
        });
        $(document).on('click', '.email_payment', function (e) {
            e.preventDefault();
            var link = $(this).attr('href');
            $.get(link, function(data) {
                bootbox.alert(data.msg);
            });
            return false;
        });
    });
})(jQuery); 
