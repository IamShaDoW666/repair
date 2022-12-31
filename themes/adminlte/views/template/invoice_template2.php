
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="<?=$assets;?>dist/css/custom/table-print.css">
        <link rel="stylesheet" href="<?=$assets;?>dist/css/custom/bootstrap.min.css">
        <link href="https://fonts.googleapis.com/css?family=Prompt" rel="stylesheet">
        
        <script src="<?= $assets ?>plugins/jquery/jquery.min.js"></script>
        <script src="<?=$assets;?>plugins/jSignature/jSignature.min.js"></script>

        <title><?=lang('invoice');?></title>
     
        <link href="<?= $assets ?>dist/css/templates/invoice2.css" rel="stylesheet">
        <?php if(($pdf)): ?>
            <link href="<?= $assets ?>dist/css/templates/invoice2_pdf.css" rel="stylesheet">
        <?php endif; ?>
    </head>
<body>


<center>
    <div class="x_content" contentEditable="true">
        <?php if($is_a4): ?>
            <div id="copy" class="row" style="width: 21cm;height: 29.5cm;margin: 0 auto;padding:0;">
        <?php else: ?>
            <div id="copy" class="row" style="width: 21cm;height: 14.8cm;margin: 0 auto;padding:0;">
        <?php endif;?>
        <div class="col-md-12 col-sm-12 col-xs-12" style="padding: 0.5cm 21px 0px 21px;">
            <div class="col-xs-5" style="text-align:left;padding-left: 0;">
                <div class="text-muted well well-sm no-shadow head_left" style="background: #3d3d3d;border: 1px solid #2f2f2f;">
                    <h4 class="text-head1" style="margin-top: 0px;margin-bottom: 0px;color: #ffffff;"><?=lang('invoice');?> <?=($db['code']); ?></h4>
                    <h6 class="text-head1" style="margin-top: 0px;margin-bottom: 0px;color: #ffffff;"><?=lang('invoice_subheading');?></h6>                   
                </div>   
                
                <h5 style="margin: 4px 1px;" class="color"><?=lang('inv_date_opening');?>: <?= date('d/m/Y',strtotime($db['date_opening']));?></h5>
                <h5 style="margin: 4px 1px;" class="color"><?=lang('report_code');?>: <?=($db['id']); ?></h5>
                <h5 style="margin: 4px 1px;" class="color"><?=lang('report_client');?>:  <?= $client->name;?></h5>
                <h5 style="margin: 4px 1px;" class="color"><?=lang('report_telephone');?>: <?= $client->telephone;?> </h5>              
            </div>
            <div class="col-xs-4 bg-col" style="text-align:left;border-top: 1px solid #D8D8D8;background-color: #f5f5f5;border-right: 1px solid #D8D8D8;border-bottom: 1px solid #D8D8D8;padding: 10px;height:136px;">
                <h5 style="margin: 4px 1px;" class="color"><?=lang('bc_management');?></h5>
                <h5 style="margin: 4px 1px;" class="color">
                    <div id="" style="margin-left: -10px; margin-top: -3px;margin-bottom: 9px;">
                        <?= $this->repairer->barcode($db['code'], 'code128', 20, false); ?>
                    </div>
                </h5>  
                    <h5 style="margin: 5px 7px;" class="color">
                        <div style="float: left;margin-top: 0px;margin-left: -7px;margin-right: 8px;">
                            <?= $this->repairer->qrcode('link', urlencode(base_url()), 1); ?>
                        </div>                  
                    </h5>
                    <h4 style="margin: 23px 1px 0px 0px;font-size:16px;" class="color"><?=lang('check_online');?></h4>
                    <h5 style="margin: 4px 1px;font-size:10px;" class="color">
                        <?=base_url();?>
                    </h5>
                            
            </div>
            <div class="col-xs-3" style="padding-right: 0;">
                <h4 class="color" style="margin-top: 0px;margin-bottom: 0px;text-align: right;">
                    <img src="<?=base_url();?>assets/uploads/logos/<?=$settings->logo;?>" style="height: 70px;padding-bottom: 10px;;">
                </h4>
                <h4 class="color" style="margin-top: 0px;margin-bottom: 0px;text-align: right;"><?=$settings->title;?></h4>
                <h5 class="color" style="margin-top: 4px;margin-bottom: 0px;text-align: right;"><?=$settings->address;?></h5>
                <h5 class="color" style="margin-top: 4px;margin-bottom: 0px;text-align: right;"><?=lang('report_telephone');?>: <?=$settings->phone;?></h5>
            </div>
        </div>
        <div class="is-table-row col-md-12 col-sm-12 col-xs-12" style="padding: 5px 20px 0px 20px;">
    <div class="col-xs-1 bg-col" style="text-align:left;border-top: 1px solid #D8D8D8;background-color: #f5f5f5;
        border-right: 1px solid #D8D8D8;border-bottom: 1px solid #D8D8D8;border-left: 1px solid #D8D8D8;padding: 0px;height:30px;">
        <h5 class="color" style="text-align: center;margin-top: 10px;"><?=lang('inv_at');?></h5>
    </div>
    <div class="col-xs-2 bg-col" style="text-align:left;border-top: 1px solid #D8D8D8;background-color: #f5f5f5;
        border-right: 1px solid #D8D8D8;border-bottom: 1px solid #D8D8D8;padding: 0px;height:30px;">
        <h5 class="color" style="text-align: center;margin-top: 10px;"><?=lang('inv_item');?> </h5>
    </div>
    <div class="col-xs-3 bg-col" style="text-align:left;border-top: 1px solid #D8D8D8;background-color: #f5f5f5;
        border-right: 1px solid #D8D8D8;border-bottom: 1px solid #D8D8D8;padding: 0px;height:30px;">
        <h5 class="color" style="text-align: center;margin-top: 10px;"><?=lang('inv_defect');?></h5>
    </div>
    
    <div class="col-xs-4 bg-col" style="text-align:left;border-top: 1px solid #D8D8D8;background-color: #f5f5f5;
        border-right: 1px solid #D8D8D8;border-bottom: 1px solid #D8D8D8;padding: 0px;height:30px;">
        <h5 class="color" style="text-align: center;margin-top: 10px;"><?=lang('inv_details');?></h5>
    </div>

    <div class="col-xs-2 bg-col" style="width: 12.5%; text-align:left;border-top: 1px solid #D8D8D8;background-color: #f5f5f5;
        border-right: 1px solid #D8D8D8;border-bottom: 1px solid #D8D8D8;padding: 0px;height:30px;">
        <h5 class="color" style="text-align: center;margin-top: 10px;"><?=lang('inv_price');?></h5>                   
    </div>
</div>
       
            
        <div class="is-table-row col-md-12 col-sm-12 col-xs-12" style="table-layout: fixed;padding: 5px 20px 0px 20px;margin-top: -6px;">
            <div class="row_item col-xs-1" style="text-align:left;border-top: 1px solid #D8D8D8;
                border-right: 1px solid #D8D8D8;border-bottom: 1px solid #D8D8D8;border-left: 1px solid #D8D8D8;padding: 0px;">
                <h5 class="color" style="text-align: center;margin-top: 7px;padding-bottom: 125px;">1</h5>
            </div>
            <div class="row_item col-xs-2" style="text-align:left;border-top: 1px solid #D8D8D8;
                border-right: 1px solid #D8D8D8;border-bottom: 1px solid #D8D8D8;padding: 0px;">
                <h5 class="color" style="text-align: center;margin-top: 7px;padding-bottom: 125px;">
                    <?= $db['model_name'];?> <small><?= $db['imei'] ? '('.$db['imei'].')' : '';?></small>
                </h5>
            </div>
            <div class="row_item col-xs-3" style="text-align:left;border-top: 1px solid #D8D8D8;
                border-right: 1px solid #D8D8D8;border-bottom: 1px solid #D8D8D8;padding: 0px;">
                <h5 class="color" style="text-align: center;margin-top: 7px;padding-bottom: 125px;">
                    <?= $db['defect'];?>
                </h5>
            </div>
           
            <div class="row_item col-xs-4" style="text-align:left;border-top: 1px solid #D8D8D8;
                border-right: 1px solid #D8D8D8;border-bottom: 1px solid #D8D8D8;padding: 0px;">
                <h5 class="color" style="text-align: center;margin-top: 7px;padding-bottom: 125px;">
                    <?= $db['comment'];?>&nbsp;
                </h5>
            </div>

            <div class="row_item col-xs-2" style="width: 12.5%; text-align:left;border-top: 1px solid #D8D8D8;
                border-right: 1px solid #D8D8D8;border-bottom: 1px solid #D8D8D8;padding: 0px;">
                <h5 class="color" style="text-align: center;margin-top: 7px;padding-bottom: 125px;">
                  <?= $settings->currency;?><?=number_format($db['grand_total'], 2);?>
                </h5>                   
            </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12" style="padding: 5px 20px 0px 20px;margin-top: -6px;">
            <div class="col-xs-2 bg-col" style="text-align:left;border-top: 1px solid #D8D8D8;background-color: #f5f5f5;
                border-bottom: 1px solid #D8D8D8;border-left: 1px solid #D8D8D8;padding: 0px;height:30px;">
                <h5 class="color" style="text-align: center;margin-top: 7px;">&nbsp;</h5>
            </div>
            <div class="col-xs-7 bg-col" style="text-align:left;border-top: 1px solid #D8D8D8;background-color: #f5f5f5;
                border-bottom: 1px solid #D8D8D8;padding: 0px;height:30px;">
                <h5 class="color" style="text-align: center;margin-top: 7px;">&nbsp;</h5>
            </div>
            <div class="col-xs-1 bg-col" style="width: 12.4%;text-align:left;border-top: 1px solid #D8D8D8;background-color: #f5f5f5;
                border-right: 1px solid #D8D8D8;border-bottom: 1px solid #D8D8D8;padding: 0px;height:30px;">
                <h5 class="color" style="text-align: right;padding-right:10px;margin-top: 7px;"><?=lang('tax');?></h5>
            </div>
            <div class="col-xs-1 bg-col"  style="width: 12.5%; text-align:left;border-top: 1px solid #D8D8D8;background-color: #f5f5f5;
                border-right: 1px solid #D8D8D8;border-bottom: 1px solid #D8D8D8;padding: 0px;height:30px;">
                <h5 class="color" style="text-align: center;margin-top: 7px;"><?= $settings->currency;?> <?=number_format($db['tax'], 2);?></h5>                   
            </div>
        </div>

        <div class="col-md-12 col-sm-12 col-xs-12" style="padding: 5px 20px 0px 20px;margin-top: -6px;">
            <div class="col-xs-2 bg-col" style="text-align:left;border-top: 1px solid #D8D8D8;background-color: #f5f5f5;
                border-bottom: 1px solid #D8D8D8;border-left: 1px solid #D8D8D8;padding: 0px;height:30px;">
                <h5 class="color" style="text-align: center;margin-top: 7px;">&nbsp;</h5>
            </div>
            <div class="col-xs-7 bg-col" style="text-align:left;border-top: 1px solid #D8D8D8;background-color: #f5f5f5;
                border-bottom: 1px solid #D8D8D8;padding: 0px;height:30px;">
                <h5 class="color" style="text-align: center;margin-top: 7px;">&nbsp;</h5>
            </div>
            <div class="col-xs-1 bg-col" style="width: 12.4%;text-align:left;border-top: 1px solid #D8D8D8;background-color: #f5f5f5;
                border-right: 1px solid #D8D8D8;border-bottom: 1px solid #D8D8D8;padding: 0px;height:30px;">
                <h5 class="color" style="text-align: right;padding-right:10px;margin-top: 7px;"><?=lang('inv_total_price');?></h5>
            </div>
            <div class="col-xs-1 bg-col"  style="width: 12.5%; text-align:left;border-top: 1px solid #D8D8D8;background-color: #f5f5f5;
                border-right: 1px solid #D8D8D8;border-bottom: 1px solid #D8D8D8;padding: 0px;height:30px;">
                <h5 class="color" style="text-align: center;margin-top: 7px;"><?= $settings->currency;?> <?=number_format($db['grand_total'], 2);?></h5>                   
            </div>
        </div>

        <div class="col-md-12 col-sm-12 col-xs-12" style="padding: 5px 20px 0px 20px;margin-top: -6px;">
            <div class="col-xs-2 bg-col" style="text-align:left;border-top: 1px solid #D8D8D8;background-color: #f5f5f5;
                border-bottom: 1px solid #D8D8D8;border-left: 1px solid #D8D8D8;padding: 0px;height:30px;">
                <h5 class="color" style="text-align: center;margin-top: 7px;">&nbsp;</h5>
            </div>
            <div class="col-xs-7 bg-col" style="text-align:left;border-top: 1px solid #D8D8D8;background-color: #f5f5f5;
                border-bottom: 1px solid #D8D8D8;padding: 0px;height:30px;">
                <h5 class="color" style="text-align: center;margin-top: 7px;">&nbsp;</h5>
            </div>
            <div class="col-xs-1 bg-col" style="width: 12.4%;text-align:left;border-top: 1px solid #D8D8D8;background-color: #f5f5f5;
                border-right: 1px solid #D8D8D8;border-bottom: 1px solid #D8D8D8;padding: 0px;height:30px;">
                <h5 class="color" style="text-align: right;padding-right:10px;margin-top: 7px;"><?=lang('paid');?></h5>
            </div>
            <div class="col-xs-1 bg-col"  style="width: 12.5%; text-align:left;border-top: 1px solid #D8D8D8;background-color: #f5f5f5;
                border-right: 1px solid #D8D8D8;border-bottom: 1px solid #D8D8D8;padding: 0px;height:30px;">
                <h5 class="color" style="text-align: center;margin-top: 7px;"><?= $settings->currency;?> <?=number_format($db['paid'], 2);?></h5>                   
            </div>
        </div>

        <div class="col-md-12 col-sm-12 col-xs-12" style="padding: 5px 20px 0px 20px;margin-top: -6px;">
            <div class="col-xs-2 bg-col" style="text-align:left;border-top: 1px solid #D8D8D8;background-color: #f5f5f5;
                border-bottom: 1px solid #D8D8D8;border-left: 1px solid #D8D8D8;padding: 0px;height:30px;">
                <h5 class="color" style="text-align: center;margin-top: 7px;">&nbsp;</h5>
            </div>
            <div class="col-xs-7 bg-col" style="text-align:left;border-top: 1px solid #D8D8D8;background-color: #f5f5f5;
                border-bottom: 1px solid #D8D8D8;padding: 0px;height:30px;">
                <h5 class="color" style="text-align: center;margin-top: 7px;">&nbsp;</h5>
            </div>
            <div class="col-xs-1 bg-col" style="width: 12.4%;text-align:left;border-top: 1px solid #D8D8D8;background-color: #f5f5f5;
                border-right: 1px solid #D8D8D8;border-bottom: 1px solid #D8D8D8;padding: 0px;height:30px;">
                <h5 class="color" style="text-align: right;padding-right:10px;margin-top: 7px;"><?=lang('balance');?></h5>
            </div>
            <div class="col-xs-1 bg-col"  style="width: 12.5%; text-align:left;border-top: 1px solid #D8D8D8;background-color: #f5f5f5;
                border-right: 1px solid #D8D8D8;border-bottom: 1px solid #D8D8D8;padding: 0px;height:30px;">
                <h5 class="color" style="text-align: center;margin-top: 7px;"><?= $settings->currency;?> <?=number_format($db['grand_total'] - $db['paid'], 2);?></h5>                   
            </div>
            <small class="pull-right">
                <?php if($payments): ?>
                    <?php foreach ($payments as $payment){
                        echo sprintf(lang('paid_by_date'), lang($payment->paid_by), $this->repairer->formatMoney($payment->amount), $payment->date).'<br>';
                    }?>
                <?php endif; ?>
            </small>
        </div>


         <?php if($is_a4): ?>
            <div class="col-md-12 col-sm-12 col-xs-12" style="padding: 400px 20px 0px 80px;">
        <?php else: ?>
            <div class="col-md-12 col-sm-12 col-xs-12" style="padding: 40px 20px 0px 80px;">
        <?php endif;?>


            <div class="col-xs-6" style="text-align: left;padding: 0;">
                <h5 style="margin: 4px 1px 0px -52px;text-align: center;" class="color"><?=lang('sign_recipient');?> (.................................................)</h5>
            </div>
            <div class="col-xs-6" style="text-align: left;padding: 0;">
                <h5 style="margin: 4px 1px 0px -65px;text-align: center;" class="color"><?=lang('sign_client');?> (.................................................)</h5>
            </div>

        </div>

      </div>
      <?php if($two_copies): ?>
          <img src="<?=base_url();?>assets/images/cut.png" style="width: 27px;margin-top: -15px;margin-bottom: -100px;margin-left: -700px;">
          <div id="clone"></div>
      <?php endif;?>

    </div>
     
</center>
<div class="x_content">
    <div id="copy" class="row" style="width: 21cm;margin: 0 auto;padding:0;">
            <div class="col-md-12 col-sm-12 col-xs-12">

              <div class="<?=($db['invoice_sign'] && $db['invoice_sign'] !== '') ? '' : 'no-print';?> well" style="width:100%;background-color:lightgrey;color:black;border:5px;font:11px/15px;align-content:left  sans-serif;">

                    <?php if($db['invoice_sign'] && $db['invoice_sign'] !== ''): ?>
                        <label>Customer Signature: </label>
                        <div class="clearfix"></div>
                        <img height="200px" src="<?= base_url('assets/uploads/signs/invoice_').$db['invoice_sign']; ?>">
                        <div style="clear: both;"></div>
                    <?php else: ?>

                        <label id="signature_label">Customer Signature (Please sign below)</label>
                        <div id="signature"></div>
                        <input type="hidden" name="sign_id" id="sign_id" value="">
                        <br>
                        <button id="submit_sign" data-num="<?=$db['id'];?>" class="no-print btn-icon btn btn-primary btn-icon pull-right">Save</button>
                        <button id="reset_sign" class="no-print btn-icon btn btn-primary btn-icon pull-left">Reset</button>
                        <div class="clearfix"></div>
                    <?php endif; ?>

                </div>


                <div id="<?=($db['invoice_sign'] && $db['invoice_sign'] !== '') ? 'no-print' : 'print-only';?>" style="display: none;">
                    <label>Customer Signature (Please sign below)</label>
                    <div class="col-md-6" style="border-bottom: 2px solid black; width: 50%; margin-top: 80px;"></div>
                </div>
            </div>

    </div>
</div>
    <div id="print_button"><?= $this->lang->line('print');?></div>
    <script src="<?= $assets ?>dist/js/templates_print.js"></script>

</body>
</html>
