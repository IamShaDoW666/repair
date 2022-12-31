<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="<?=$assets;?>dist/css/custom/table-print.css">
        <link rel="stylesheet" href="<?=$assets;?>bower_components/bootstrap/dist/css/bootstrap.min.css">

        <link rel="preconnect" href="https://fonts.gstatic.com"> 
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
        <script src="<?=$assets;?>bower_components/jquery/dist/jquery.min.js"></script>
        <title><?=lang('report');?></title>
        <link href="<?= $assets ?>dist/css/templates/report5.css" rel="stylesheet">
       
    </head>
<body>

<div class="container">
    <div class="row">
        <div class="col-xs-7">            
            <p class="mt-3">
                <span class="title">Datum inname:</span> <?=date('d M Y', strtotime($db['date_opening']));?><br>
                <span class="title">Reparatie code:</span> <?=($db['code']); ?></p> 
            <p class="mt-1"> 
                <span class="title">Klantgegevens</span><br>
                <span class="title">Naam:</span> <?= $client->name;?><br>
                <span class="title">Telefoonnummer:</span> <?= $client->telephone;?> <br>
                <span class="title">Email adres:</span> <?= $client->email;?> 
            </p>
        </div>
        <div class="col-xs-5">
            <img style="width: 100%;" src="<?=base_url();?>assets/uploads/logos/<?=$settings->logo;?>" style="height: 70px;padding-bottom: 10px;">
            <p class="large mt-5">Service innamebewijs</p>
        </div>
    </div>
</div>
<div class="container" style="border-top: 2px solid rgb(198, 198, 198)">
    <div class="row">
        <div class="col-xs-4">
                <p><?=$db['model_name'];?></p>
                <p><span class="title">Serienummer:</span> <?=$db['imei'];?></p>
                <p><span class="title">Status:</span>  <?=$status->label;?></p>
                <p><span class="title">Defect:</span>  <?=$db['defect'];?></p>

            <p class="mt-3">
                <span class="title">Ingenomen door:</span><br>
                <?=$user->first_name.' '.$user->last_name;?>
            </p>
        </div>
        <div class="col-xs-8">
            <p><span class="title">Probleem omschrijving:</span><br>
               <?=$db['comment'];?> 
            </p>
            <p class="mt-3">
                <span class="title">Zichtbare schade:</span><br>
                <?=$db['diagnostics'];?>
            </p>
            <p class="mt-3">
                <span class="title">Ingeleverd met:</span><br>
                <?=$db['accessories'];?>
            </p>
        </div>
    </div>
</div>
<div class="container" style="border-top: 2px solid rgb(198, 198, 198)">
    <div class="row">
        <div class="col-xs-12">
            <p class="small">Door hier mijn handtekening te zetten, ga ik akkoord met de Algemene voorwaarden van De Apple Meneer en dat:<br>
            - De Apple Meneer niet aansprakelijk worden gesteld indien tijdens de reparatie, service en/of het onderhoud de gegevens op mijn apparaat verloren gaan of beschadigd raken of daar inbreuk op wordt gemaakt.<br>
            - Het mijn verantwoordelijkheid is om een <strong>reservekopie</strong> te maken van mijn gegevens voordat ik mijn product voor reparatie/service/onderhoud naar De Apple Meneer breng, met het oog op eventueel gegevensverlies ten gevolge van de onderhouds- of reparatiewerkzaamheden.<br>
            - De Apple Meneer niet verantwoordelijk of aansprakelijk is voor enige gevolgschade ontstaan door de bij inname aanwezige schade en/of defect, veroorzaakt door transport, onderzoek of enig andere handeling die noodzakelijk is voor het uitvoeren van deze reparatie.<br>
            - Goederen die ter reparatie worden aangeboden, worden mogelijk niet gerepareerd maar vervangen door (fabrieksnieuwe) goederen van hetzelfde type<br>
        </p>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-xs-6">
           <p style="border-bottom: 1px solid rgb(198, 198, 198);">Ik ben akkoord met bovenstaande en de algemene voorwaarden:
            <br><br><br><br>
            </p>
            <p class="small">
                <?=date('d M Y', strtotime($db['date_opening']));?>
            </p>
            <p class="mt-3"><?=$settings->title;?></p>
            <p><?=$settings->address;?></p>
            <p><?=$settings->postcode;?></p>
            <p><?=$settings->phone;?></p>
            <p><?= $user->email;?> </p>
        </div>
        <div class="col-xs-6">
                <p style="border-bottom: 1px solid rgb(198, 198, 198);">Retour ontvangen d.d.
                <br><br><br><br><br>
            </p>
        </div>
    </div>
</div>
<div id="print_button"><?= $this->lang->line('print');?></div>
<script src="<?= $assets ?>dist/js/templates_print.js"></script>

</body>
</html>
