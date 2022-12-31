<!DOCTYPE html>
<html>
<head>
	<title>Repair Reciept</title>
    <script src="<?= $assets;?>plugins/jquery/dist/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?= $assets;?>/dist/css/custom/thermal.css">
    <script src="<?= $assets;?>plugins/jquery/dist/jquery.min.js"></script>
	<link href="<?= $assets ?>dist/css/templates/invoice3.css" rel="stylesheet">

</head>
<body>

  <div id="invoice-POS">
    
    <center id="top">
      <div class="logo">
      	<img style="width: 100%;" src="<?=base_url();?>assets/uploads/logos/<?=$settings->logo; ?>">
      </div>
      <div class="info"> 
        <h2><?=$settings->title;?></h2>
        <p> 
            <?=lang('client_address');?> : <?=$settings->address;?></br>
            <?=lang('client_email');?>   : <?=$settings->invoice_mail;?></br>
            <?=lang('client_telephone');?>   : <?=$settings->phone;?></br>
        </p>
      </div><!--End Info-->
    </center><!--End InvoiceTop-->
	<div class="clearfix"></div>
    
    <div id="mid">
      <div class="info">
      	<h2></h2>
      	<center>
	    	<div id="" style="margin-left: -10px; margin-top: -3px;margin-bottom: 9px;">
		        <?= $this->repairer->barcode(($db['code']), 'code128', 30, true); ?>
		    </div>
		</center>
        <h2><?=lang('customer_name');?>: <?=$db['name'];?></h2>
		<div class="clearfix"></div>
      </div>

    </div><!--End Invoice Mid-->
   
    <div id="bot">
		<div id="table">
			<table>
				<tr class="tabletitle">
					<td class="item"><h2><?=lang('repair_item');?></h2></td>
					<td class="Hours"></td>
					<td class="Rate price"></h2></td>
				</tr>

				<tr class="service">
					<td colspan="3" class="tableitem"><p class="itemtext">
						<strong><?= $db['model_name'];?></strong>
						<small><?= $db['imei'] ? '('.$db['imei'].')' : '';?>
						<br>
						<?=$db['defect'];?></small>
					</p></td>
				</tr>

				<tr class="tabletitle">
					<td></td>
					<td class="Rate"><h2><?=lang('tax');?></h2></td>
					<td class="payment"><h2><?=$settings->currency; ?> <?=number_format($db['tax'], 2); ?></h2></td>
				</tr>

				<tr class="tabletitle">
					<td></td>
					<td class="Rate"><h2><?=lang('total_price');?></h2></td>
					<td class="payment"><h2><?=$settings->currency; ?> <?=number_format($db['grand_total'], 2); ?></h2></td>
				</tr>

				<tr class="tabletitle">
					<td></td>
					<td class="Rate"><h2><?=lang('paid');?></h2></td>
					<td class="payment"><h2><?=$settings->currency; ?> <?=number_format($db['paid'], 2); ?></h2></td>
				</tr>

				<tr class="tabletitle">
					<td></td>
					<td class="Rate"><h2><?=lang('balance');?></h2></td>
					<td class="payment"><h2><?=$settings->currency; ?> <?=$db['grand_total'] - $db['paid']; ?></h2></td>
				</tr>



			</table>

			<small style="text-align: right !important;">
                <?php if($payments): ?>
                    <?php foreach ($payments as $payment){
                        echo sprintf(lang('paid_by_date'), lang($payment->paid_by), $this->repairer->formatMoney($payment->amount), $payment->date).'<br>';
                    }?>
                <?php endif; ?>
            </small>
		</div><!--End Table-->

		<div id="legalcopy">
			<p class="legal"><?=$settings->disclaimer;?> 
			</p>


		</div>
			<center>
				<?= $this->repairer->qrcode('link', urlencode(base_url()), 1); ?>
			</center>
			<div class="clearfix"></div>


        
	</div><!--End InvoiceBot-->
	
  </div><!--End Invoice-->

  <script src="<?= $assets ?>dist/js/templates_print.js"></script>

</body>
</html>
