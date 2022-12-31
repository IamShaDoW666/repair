<html xmlns="http://www.w3.org/TR/REC-html40">
<head>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">
<link rel="stylesheet" href="<?=$assets;?>dist/css/custom/report_template4.css">

<title><?=lang('service_order');?> #<?=$db['id'];?></title></head>

<body>
<div id="header">
<table width="100%" border="0" cellpadding="5" cellspacing="4" bgcolor="#EDEDEA">
  <tr>
        <td width="50%" valign="top" bgcolor="#EDEDEA"><span class="style15"><img src="<?=base_url();?>assets/uploads/logos/<?=$settings->logo;?>" alt="" width="auto" height="80" align="left"/><?=$settings->title;?><br>
          </span><span class="style16"><?=$settings->address;?><br>
          <?=lang('phone');?>: <?=$settings->phone;?>, </br> <?=lang('semail');?>: <?=$settings->invoice_mail;?></span></td>
        <td width="48" valign="top" bgcolor="#EDEDEA" class="no_print" style="cursor: pointer;" onClick="window.print()"><div align="center"><img src="<?=base_url();?>assets/images/printer.png" width="48" height="48"></div></td>
      <td width="50%" valign="top" bgcolor="#EDEDEA"><div align="right" style="text-transform: uppercase; font-weight: bold"><span><?=lang('service_order');?></span><span>          <br>
        </span></div>
      <div align="right" style="text-transform: uppercase; font-weight: bold">#<?=str_pad($db['id'], 4, '0', STR_PAD_LEFT);?></div></td>
      </tr>
    </table>
</div>
<table border=0 cellspacing=0 cellpadding=0 align=center
 width=100%>
  <tr>
    <td colspan=9 nowrap></td>
  </tr>
  <tr>
    <td height="25" colspan="9" valign=top nowrap><div align="right"><?= $this->repairer->barcode($db['code'], 'code128', 20, false); ?> &nbsp;&nbsp;</div></td>
  </tr>
  <tr>
    <td height="25" colspan="9" valign=top nowrap><table width="100%" border="0" cellspacing="10" cellpadding="10">
      <?php $wm = array('1' => lang('in_warranty'), '2' => lang('out_warranty')); ?>
      <tr>
        <td width="15%" bgcolor="#EDEDEA"><div align="center"><strong><?=lang('sdate_opening');?>:</strong></div></td>
        <td width="35%" class="td_bold"><div align="center"><strong><?=$db['client_date'];?></strong></div></td>
        <td width="15%" bgcolor="#EDEDEA"><div align="center"><strong><?=lang('repair_type');?></strong></div></td>
        <td width="35%" class="td_bold"><div align="center"><strong><?=$wm[$db['has_warranty']];?></strong></div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="25" colspan="9" valign=top nowrap><table width="100%" border="0" cellpadding="0" cellspacing="0" id="order_info">
      <tr>
        <td width="50%" height="35" class="border_table"><span style="font-size:14px; font-family:'Open Sans Semibold', 'sans-serif'; color:#404040;"><strong>&nbsp;&nbsp;</strong></span><span style="font-size:14px; color:#404040;"><strong><?=lang('sclient_name');?></strong></span></td>
        <td width="50%" height="35" class="border_table"><span class="style14">&nbsp;&nbsp;<?=lang('product_repair');?></span></td>
      </tr>
      <tr>
        <td width="50%" valign="top" class="border_table"><table width="100%" border="0" cellspacing="10" cellpadding="10">
          <tr>
            <td class="td_bold"><strong><?= $client->name;?></strong></td>
          </tr>
          
          <tr>
            <td class="td_bold"><strong><?= $client->telephone;?></strong></td>
          </tr>

          <tr>
            <td class="td_bold"><strong><?= $client->address;?></strong></td>
          </tr>

          <tr>
            <td class="td_bold"><strong><?= $client->email;?></strong></td>
          </tr>
        </table></td>
        <td width="50%" class="border_table"><table width="100%" border="0" cellpadding="5" cellspacing="4" class="no_border_table">
          <tr>
            <td width="31%"><div align="right"><?=lang('manufacturer');?>:</div></td>
            <td width="69%" class="td_bold"><strong><?=$db['manufacturer'];?></strong></td>
          </tr>
         
           <tr>
            <td><div align="right"><?=lang('sproduct');?></div></td>
            <td class="td_bold"><strong><?= $db['repair_type'];?></strong></td>
          </tr>
          <tr>
            <td><div align="right"><?=lang('scategory');?></div></td>
            <td class="td_bold"><strong><?= $db['category'];?></strong></td>
          </tr>
          <tr>
            <td><div align="right"><?=lang('smodel');?></div></td>
            <td class="td_bold"><strong><?= $db['model_name'];?></strong></td>
          </tr>
          <tr>
            <td><div align="right"><?=lang('sserial_number');?></div></td>
            <td class="td_bold"><strong><?= $db['imei'];?></strong></td>
          </tr>
           <tr>
            <td><div align="right"><?=lang('scard_number');?></div></td>
            <td class="td_bold"><strong><?= $db['warranty_card_number'];?></strong></td>
          </tr>
          <tr>
            <td><div align="right"><?=lang('spurchased_date');?></div></td>
            <td class="td_bold"><strong><?= $db['date_of_purchase'];?></strong></td>
          </tr>

        </table></td>
      </tr>
      <tr>
        <td height="35" class="border_table"><strong>&nbsp;&nbsp;<?=lang('sdefect');?>:&nbsp;&nbsp;</strong></br>&nbsp;&nbsp;<strong><?= $db['defect'];?></strong></td>
        <td height="35" class="border_table"><strong>&nbsp;&nbsp;<?=lang('sdiagnostic');?>:&nbsp;&nbsp;</strong></br>&nbsp;&nbsp;</td>
      </tr>
      <tr>
        <td height="35" class="border_table">&nbsp;</td>
        <td height="35" class="border_table"><strong>&nbsp;&nbsp;<?=lang('scomment');?>&nbsp;&nbsp;</strong></br>&nbsp;&nbsp;<strong><?=$db['comment'];?></strong></td>
      </tr>
      <tr>
        <td valign="top" class="border_table"><table width="100%" border="0" cellspacing="4" cellpadding="5">
          <tr>
            <td class="td_bold">&nbsp;</td>
          </tr>
        </table></td>
        <td valign="top" class="border_table"><table width="100%" border="0" cellspacing="4" cellpadding="5">
          <tr>
            <td class="td_bold">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="9" valign=top nowrap></td>
  </tr>
  
  <tr>
    <td height="25" colspan="9" valign=bottom>&nbsp;&nbsp;&nbsp;</td>
  </tr>
  <tr>
    <td height="25" colspan="9" valign=bottom bgcolor="#EDEDEA"><div align="center" class="td_bold"><strong><span style="font-size: 12px">
      <?=$settings->disclaimer;?></span></strong><br>
    <br>
    </div></td>
  </tr>
  <tr>
    <td height="25" colspan="9" valign=bottom nowrap></td>
  </tr>
  <tr>
    <td height="25" colspan="9" valign=bottom nowrap><table width="100%" border="0" cellspacing="4" cellpadding="5">
      <tr>
        <td width="53%">&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td width="47%">&nbsp;&nbsp;&nbsp;&nbsp;</td>
      </tr>
      <tr>
        <td class="td_bold"><?=lang('sclient_sign');?>: . . . . . . . . . . . . . . . . . .</td>
        <td class="td_bold"><?=lang('scompany');?>: . . . . . . . . . . . . . . . . . .</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="25" colspan="9" valign=bottom nowrap></v:textbox>
      <table cellpadding=0 cellspacing=0 width="100%">
        <tr>
          <td>            </td>
        </tr>
        </table>    </td>
  </tr>
</table>

<div id="footer">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
              <td bgcolor="#EDEDEA"><table width="100%" border="0" cellspacing="4" cellpadding="5">
                <tr>
                  <td class="td_bold"><?=lang('check_status');?>:  
                <?=base_url();?><br>
                  <?=lang('sorder_number');?>: <strong><?=str_pad($db['id'], 4, '0', STR_PAD_LEFT);?></strong> |  <?=lang('sverification_number');?>: <strong><?=$db['code'];?></strong></td>
                </tr>
              </table>
                </td>
      <td width="116"><div align="center">
      <?= $this->repairer->qrcode('link', urlencode(base_url() . 'welcome/index/?code=' . $db['code'] . '&id=' . $db['id']) , 1); ?>
      </div></td>
    </tr>
          </table>
</div>

</body>
</html>
