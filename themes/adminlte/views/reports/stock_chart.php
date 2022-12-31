<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script src="<?= $assets ?>plugins/chart.js/Chart.min.js"></script>
<script src="<?= $base_url ?>panel/misc/js/stock?"></script>


<div class="row">
  <div class="col-12">
    <div class="card">

    
      <div class="card-body">
          <?php if ($totals) { ?>
           <div class="row">
                <div class="col-lg-6 col-xs-12">
                  <!-- small box -->
                  <div class="small-box bg-aqua">
                    <div class="inner">
                      <h3><?= $this->repairer->formatQuantity($totals->total_items) ?></h3>
                      <p><?= lang('total_items') ?></p>
                    </div>
                    <div class="icon">
                      <i class="ion ion-bag"></i>
                    </div>
                  </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-6 col-xs-12">
                  <!-- small box -->
                  <div class="small-box bg-green">
                    <div class="inner">
                      <h3><?= $this->repairer->formatQuantity($totals->total_quantity) ?></h3>
                      <p><?= lang('total_quantity') ?></p>
                    </div>
                    <div class="icon">
                      <i class="ion ion-stats-bars"></i>
                    </div>
                  </div>
                </div>
                <div class="clearfix" style="margin-top:20px;"></div>
        </div>
                
            <?php } ?>
            <canvas id="stock-chart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
      </div>
  </div>
</div>
