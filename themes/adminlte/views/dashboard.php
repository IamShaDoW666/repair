<!-- ChartJS -->
<script src="<?= $assets ?>plugins/chart.js/Chart.min.js"></script>

<!-- FLOT CHARTS -->
<script src="<?= $assets ?>plugins/flot/jquery.flot.js"></script>
<!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
<script src="<?= $assets ?>plugins/flot/plugins/jquery.flot.resize.js"></script>

<!-- fullCalendar -->
<link rel="stylesheet" href="<?= $assets ?>plugins/fullcalendar/main.css">
<script src="<?= $assets ?>plugins/fullcalendar/main.js"></script>

<script src='<?= $assets ?>plugins/fullcalendar/locales-all.js'></script>
       
 <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?= $reparation_count; ?></h3>
                <p><?= lang('reparation_title'); ?></p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="<?= base_url('panel/reparation'); ?>" class="small-box-footer"><?=lang('more_info');?> <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <!-- ./col -->
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?= $clients_count; ?></h3>
                <p><?= lang('client_title'); ?></p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="<?= base_url('panel/customers'); ?>" class="small-box-footer"><?=lang('more_info');?> <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?= $stock_count; ?></h3>
                <p><?= lang('products'); ?></p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="<?= base_url('panel/inventory'); ?>" class="small-box-footer"><?=lang('more_info');?> <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>


        <div class="row">
          <section class="col-lg-7 connectedSortable ui-sortable">

            <?php if($this->Admin || $this->GP['reports-finance']): ?>
              <!-- Custom tabs (Charts with tabs)-->
              <div class="card">
                <div class="card-header ui-sortable-handle" style="cursor: move;">
                  <h3 class="card-title">
                    <i class="ion ion-stats-bars"></i>
                    <?= lang('revenue_chart'); ?>
                  </h3>
                   <!-- tools box -->
                 
                  <!-- /. tools -->

                </div><!-- /.card-header -->
                <div class="card-body">
                  <div id="area-chart" style="height: 338px;" class="full-width-chart"></div>
                </div><!-- /.card-body -->
              </div>
              <!-- /.card -->
            <?php endif;?>



            <!-- Custom tabs (Chartts with tabs)-->
              <div class="card">
                <div class="card-header ui-sortable-handle" style="cursor: move;">
                  <h3 class="card-title">
                    <i class="fas fa-calendar"></i>
                    <?= lang('calendar'); ?>
                  </h3>
                </div><!-- /.card-header -->
                <div class="card-body">
                  <div id="calendar"></div>
                </div><!-- /.card-body -->
              </div>
              <!-- /.card -->

          </section>


          <section class="col-lg-5 connectedSortable ui-sortable">
              <?php if($this->Admin || $this->GP['reports-stock']): ?>
               <!-- Custom tabs (Chartts with tabs)-->
              <div class="card">
                <div class="card-header ui-sortable-handle" style="cursor: move;">
                  <h3 class="card-title">
                    <i class="fa fa-th"></i>
                    <?= lang('stock'); ?>
                  </h3>
                </div><!-- /.card-header -->
                <div class="card-body">
                  <canvas id="stock-chart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div><!-- /.card-body -->
              </div>
              <!-- /.card -->
              <?php endif;?>



              <?php if($this->Admin || $this->GP['dashboard-qemail']): ?>
               <!-- Custom tabs (Chartts with tabs)-->
              <div class="card">
                <div class="card-header ui-sortable-handle" style="cursor: move;">
                  <h3 class="card-title">
                    <i class="fa fa-envelope"></i>
                    <?= lang('qemail'); ?>
                  </h3>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <form action="#" method="post" id="send_email_form" >
                    <div class="form-group">
                      <input type="email" class="form-control" required name="emailto" id="emailto_" placeholder="<?= lang('email_to'); ?>">
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control" required name="subject" id="subject_" placeholder="<?= lang('email_subject'); ?>">
                    </div>
                    <div>
                      <textarea name="body" id="body_" required class="summernote" placeholder="<?= lang('email_body'); ?>" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                    </div>
                  </form>
                </div>
                <div class="card-footer clearfix">
              <button type="submit" form="send_email_form" class="pull-right btn btn-default"><?= lang('email_send'); ?>
                <i class="fa fa-arrow-circle-right"></i></button>
                </div><!-- /.card-body -->
              </div>
              <!-- /.card -->
              <?php endif;?>



          <?php if($this->Admin || $this->GP['dashboard-qsms']): ?>


             <!-- Custom tabs (Chartts with tabs)-->
              <div class="card">
                <div class="card-header ui-sortable-handle" style="cursor: move;">
                  <h3 class="card-title">
                    <i class="fa fa-envelope"></i>
                    <?= lang('quick_sms'); ?>
                  </h3>
                </div><!-- /.card-header -->
                <div class="card-body">

                    <form action="#" id="send_quicksms" method="post">
                      <div class="form-group">
                        <input type="text" required class="form-control" name="number" id="phone_number" placeholder="Number eg. (+923001234567)">
                      </div>
                      <div>
                        <textarea required="" name="text" id="fastsms" class="textarea" placeholder="SMS Text" style="width: 100%; height: 80px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                      </div>
                    </form>
                 

                </div>

                 <div class="card-footer clearfix">
                    <button type="submit" class="pull-right btn btn-default" form="send_quicksms"><?= lang('email_send'); ?>
                      <i class="fa fa-arrow-circle-right"></i></button>
                  </div>


              </div>
              <!-- /.card -->
        <?php endif; ?>

          </section>
        </div>
        <script type="text/javascript" src="<?=base_url();?>panel/misc/js/dashboard"></script>
