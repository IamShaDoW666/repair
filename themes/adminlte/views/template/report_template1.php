<?php
$tax = $db['tax'];
$price_without_tax = $db['total']; // PRICE WITHOUT TAX
$total = $db['grand_total']; // PRICE WITH TAX
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?= $this->lang->line('report');?></title>
        <link href="<?= $assets ?>dist/css/custom/invoice.css" rel="stylesheet">
        <!-- jQuery 2.2.3 -->
        <script src="<?= $assets ?>plugins/jquery/jquery.min.js"></script>
        
        <!-- Accounting.js -->
        <script src="<?= $assets ?>plugins/custom/accounting.min.js"></script>
    </head>

    <body>
        <div id="editable_invoice"><?= $this->lang->line('editable_invoice');?></div>
        <div class="halfinvoice">
            <header class="clearfix">
                <div id="logo">
                    <img src="<?= base_url(); ?>assets/uploads/logos/<?= $settings->logo; ?>">
                </div>
                 <div id="company" contentEditable="true">
                    <h2 class="name"><?= $settings->title; ?></h2>
                    <div><?= $settings->invoice_name; ?></div>
                    <div><?= $settings->address; ?></div>
                    <div><?= $settings->phone; ?></div>
                    <div><a href="mailto:<?= $settings->invoice_mail; ?>"><?= $settings->invoice_mail; ?></a></div>
                    <div><?= $settings->vat; ?></div>
                </div>
            </header>
            <main>
                <div id="details" class="clearfix">
                    <div id="client" contentEditable="true">
                        <div class="to"><?= $this->lang->line('client_title');?>:</div>
                        <h2 class="name"><?=$db['name']; ?></h2>
                        <div class="company"><?=($client ? $client->company : ''); ?></div>
                        <div class="address"><?=($client ? $client->address : ''); ?></div>
                        <div class="postal_code"><?=($client ? $client->city : ''); ?> <?=($client ? $client->postal_code : ''); ?></div>
                        <div class="email"><a <?= $client ? 'href="mailto:'.$client->email.'"' : ''; ?> ><?=$client ? $client->email : ''; ?></a></div>
                        <div class="telephone"><?=$client ? $client->telephone : ''; ?></div>
                    </div>
                    <div id="invoice" contentEditable="true">
                        <h1><?= $this->lang->line('report').' '.$db['model_name'];?></h1>
                        <div class="date"><?= $this->lang->line('date_opening');?>: <?= date_format(date_create($db['date_opening']),"Y/m/d"); ?></div>
                    </div>
                </div>

                <div id="dati">
                    <div class="col"><b><?= $this->lang->line('reparation_imei');?>:</b> <?=$db['imei'];?></div>
                    <div class="col"><b><?= $this->lang->line('model_name');?>:</b> <?=$db['model_name'];?></div>
                    <div class="col"><b><?= $this->lang->line('reparation_category');?>:</b> <?=$db['category'];?></div>
                    <div class="col"><b><?= $this->lang->line('reparation_defect');?>:</b> <?=$db['defect'];?></div>
                    <div class="col"><b><?= $this->lang->line('grand_total');?>:</b><?=$this->repairer->formatDecimal($db['grand_total']);?></div>
                    <div class="col"><b><?= $this->lang->line('paid');?>:</b><?=$this->repairer->formatDecimal($db['paid']);?></div>
                    <div class="col"><b><?= $this->lang->line('balance');?>:</b><?=$this->repairer->formatDecimal($db['grand_total'] - $db['paid']);?></div>
                    <div class="col"><b><?= $this->lang->line('code');?>:</b> <?=$db['code'];?></div>
                    <?php $custom_fields = explode(',', $settings->custom_fields);
                    if (!empty(array_filter($custom_fields))) {
                        $value = json_decode($db['custom_field'], true);
                        foreach($custom_fields as $line){ 
                             if(!empty(array_filter($value))): ?>
                                <div class="col"><b> <?= $line; ?> :</b> <?= $value[bin2hex($line)]; ?></div>
                    <?php 
                            endif;
                        } 
                    }
                    ?>
                    <div class="col txt"><textarea id="comment" onkeyup="auto_grow(this)" contentEditable="true"><?=$db['comment']; ?></textarea></div>
                    <div style="clear: both;"></div>
                </div>
                <?= $settings->disclaimer; ?>

            </main>
            <div id="print_button"><?= $this->lang->line('print');?></div>
        </div>
    </body>


    <script src="<?= $assets ?>dist/js/templates_print.js"></script>

</html>

