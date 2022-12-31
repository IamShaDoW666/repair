<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $this->lang->line("purchase") . " " . $inv->reference_no; ?></title>
    <link rel="stylesheet" href="<?= $assets; ?>plugins/bootstrap/dist/css/bootstrap.min.css">
</head>

<body>
<div id="wrap">
    <div class="row">
        <div class="col-lg-12">
            <?php if ($logo) {?>
                <div class="text-center" style="margin-bottom:20px;">
                    <img width="100" src="data:image/png;base64,<?= $this->repairer->imgto64('assets/uploads/logos/' . $Settings->logo); ?>" alt="<?=$Settings->title;?>">
                </div>
            <?php }
            ?>
            <div class="well well-sm">
                <div class="row bold">
                    <div class="col-xs-4"><?=lang("date");?>: <?=$this->repairer->hrld($inv->date);?>
                        <br><?=lang("ref");?>: <?=$inv->reference_no;?></div>
                    <div class="col-xs-6 pull-right text-right order_barcodes">
                        <?= $this->repairer->barcode($inv->reference_no, 'code128', 66, false); ?>
                        <?= $this->repairer->qrcode('link', urlencode(site_url('purchases/view/' . $inv->id)), 2); ?>
                        
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="clearfix"></div>
            <div class="row padding10">
                <div class="col-xs-5">
                    <h2 class=""><?=$supplier->company ? $supplier->company : $supplier->name;?></h2>
                    <?=$supplier->company ? "" : "Attn: " . $supplier->name?>
                    <?php
                        echo $supplier->address . "<br />" . $supplier->city . " " . $supplier->postal_code . " " . $supplier->state . "<br />" . $supplier->country;
                        echo "<p>";
                        if ($supplier->vat_no != "-" && $supplier->vat_no != "") {
                            echo "<br>" . lang("vat_no") . ": " . $supplier->vat_no;
                        }
                        
                        echo "</p>";
                        echo lang("tel") . ": " . $supplier->phone . "<br />" . lang("email") . ": " . $supplier->email;
                    ?>
                    <div class="clearfix"></div>
                </div>
                <div class="col-xs-5">
                    <h2 class=""><?=$Settings->title;?></h2>
                    <div class="clearfix"></div>
                </div>
            </div>
            <p>&nbsp;</p>

            <div class="clearfix"></div>
            <?php
                $col = 4;
                if ($inv->status == 'partial') {
                    $col++;
                }
                if ($Settings->product_discount && $inv->product_discount != 0) {
                    $col++;
                }
                if ($Settings->tax1 && $inv->product_tax > 0) {
                    $col++;
                }
                if ( $Settings->product_discount && $inv->product_discount != 0 && $Settings->tax1 && $inv->product_tax > 0) {
                    $tcol = $col - 2;
                } elseif ( $Settings->product_discount && $inv->product_discount != 0) {
                    $tcol = $col - 1;
                } elseif ($Settings->tax1 && $inv->product_tax > 0) {
                    $tcol = $col - 1;
                } else {
                    $tcol = $col;
                }
            ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                    <tr class="active">
                        <th><?=lang("no");?></th>
                        <th><?=lang("description");?> (<?=lang('code');?>)</th>
                        <th><?=lang("quantity");?></th>
                        <?php
                            if ($inv->status == 'partial') {
                                echo '<th>'.lang("received").'</th>';
                            }
                        ?>
                        <th><?=lang("unit_cost");?></th>
                        <?php
                            if ($Settings->tax1 && $inv->product_tax > 0) {
                                echo '<th>' . lang("tax") . '</th>';
                            }
                        ?>
                        <?php
                            if ($Settings->product_discount && $inv->product_discount != 0) {
                                echo '<th>' . lang("discount") . '</th>';
                            }
                        ?>
                        <th><?=lang("subtotal");?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $r = 1;
                        foreach ($rows as $row):
                            ?>
                            <tr>
                                <td style="text-align:center; width:40px; vertical-align:middle;"><?=$r;?></td>
                                <td style="vertical-align:middle;">
                                    <?= $row->product_code.' - '.$row->product_name; ?>
                                    <?=$row->details ? '<br>' . $row->details : '';?>
                                </td>
                                <td style="width: 80px; text-align:center; vertical-align:middle;"><?=$this->repairer->formatQuantity($row->quantity); ?></td>
                                <?php
                                    if ($inv->status == 'partial') {
                                        echo '<td style="text-align:center;vertical-align:middle;width:120px;">'.$this->repairer->formatQuantity($row->quantity).'</td>';
                                    }
                                ?>
                                <td style="text-align:right; width:100px;"><?=$this->repairer->formatMoney($row->net_unit_cost);?></td>
                                <?php
                                    if ($Settings->tax1 && $inv->product_tax > 0) {
                                        echo '<td style="width: 100px; text-align:right; vertical-align:middle;">' . ($row->item_tax != 0 && $row->tax_code ? '<small>(' . $row->tax_code . ')</small> ' : '') . $this->repairer->formatMoney($row->item_tax) . '</td>';
                                    }
                                ?>
                                <?php
                                    if ($Settings->product_discount && $inv->product_discount != 0) {
                                        echo '<td style="width: 100px; text-align:right; vertical-align:middle;">' . ($row->discount != 0 ? '<small>(' . $row->discount . ')</small> ' : '') . $this->repairer->formatMoney($row->item_discount) . '</td>';
                                    }
                                ?>
                                <td style="text-align:right; width:120px;"><?=$this->repairer->formatMoney($row->subtotal);?></td>
                            </tr>
                            <?php
                            $r++;
                        endforeach;
                    ?>
                    </tbody>
                    <tfoot>

                    <?php if ($inv->grand_total != $inv->total) { ?>
                        <tr>
                            <td colspan="<?= $tcol; ?>"
                                style="text-align:right;"><?= lang("total"); ?>
                                (site.settings.currency)
                            </td>
                            <?php
                            if ($Settings->tax1 && $inv->product_tax > 0) {
                                echo '<td style="text-align:right;">' . $this->repairer->formatMoney($inv->product_tax) . '</td>';
                            }
                            if ($Settings->product_discount && $inv->product_discount != 0) {
                                echo '<td style="text-align:right;">' . $this->repairer->formatMoney($inv->product_discount) . '</td>';
                            }
                            ?>
                            <td style="text-align:right;"><?= $this->repairer->formatMoney($inv->total + $inv->product_tax); ?></td>
                        </tr>
                    <?php } ?>
                    <?php if ($inv->order_discount != 0) {
                        echo '<tr><td colspan="' . $col . '" style="text-align:right;">' . lang("order_discount") . ' (' . $Settings->currency . ')</td><td style="text-align:right;">'.($inv->order_discount_id ? '<small>('.$inv->order_discount_id.')</small> ' : '') . ($inv->order_discount) . '</td></tr>';
                    }
                    ?>
                    <?php if ($Settings->tax2 && $inv->order_tax != 0) {
                        echo '<tr><td colspan="' . $col . '" style="text-align:right;">' . lang("order_tax") . ' (' . $Settings->currency . ')</td><td style="text-align:right;">' . $this->repairer->formatMoney($inv->order_tax) . '</td></tr>';
                    }
                    ?>
                    <?php if ($inv->shipping != 0) {
                        echo '<tr><td colspan="' . $col . '" style="text-align:right;">' . lang("shipping") . ' (' . $Settings->currency . ')</td><td style="text-align:right;">' . $this->repairer->formatMoney($inv->shipping) . '</td></tr>';
                    }
                    ?>
                    <tr>
                        <td colspan="<?= $col; ?>"
                            style="text-align:right; font-weight:bold;"><?= lang("total_amount"); ?>
                            (site.settings.currency)
                        </td>
                        <td style="text-align:right; font-weight:bold;"><?= $this->repairer->formatMoney($inv->grand_total); ?></td>
                    </tr>
                    

                    </tfoot>
                </table>
            </div>

            <div class="row">
                <div class="col-xs-7 pull-left">
                    <?php if ($inv->note || $inv->note != "") {?>
                        <div class="well well-sm">
                            <p class="bold"><?= lang("note");?>:</p>

                            <div><?=$this->repairer->decode_html($inv->note);?></div>
                        </div>
                    <?php }
                    ?>
                </div>
                <div class="col-xs-4 col-xs-offset-1 pull-right">
                    <p><?= lang("order_by");?>: <?=$created_by->first_name . ' ' . $created_by->last_name;?> </p>

                    <p>&nbsp;</p>

                    <p>&nbsp;</p>
                    <hr>
                    <p><?= lang("stamp_sign");?></p>
                </div>
            </div>

        </div>
    </div>
</div>
</body>
</html>