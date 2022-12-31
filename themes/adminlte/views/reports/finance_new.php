<script src="<?=$assets;?>/plugins/flot/jquery.flot.js"></script>    
<script src="<?=$assets;?>/plugins/flot/plugins/jquery.flot.pie.js"></script>    
<script src="<?=$assets;?>/plugins/flot/plugins/jquery.flot.categories.js"></script>   
<script src="<?=$assets;?>/plugins/flot/plugins/jquery.flot.resize.js"></script>   
<script src="<?=$assets;?>/plugins/flot/plugins/jquery.flot.time.js"></script>   

          <div id="poststuff" >
            <div class="postbox">
              <div class="stats_range">
                <ul>
                  <li class="range_tab">
                    <a href="<?=base_url().uri_string();?>?start=<?=date($dateFormats['php_sdate'],strtotime('first day of last year'));?>"><?=lang('year');?></a>
                  </li>
                  <li class="range_tab">
                    <a href="<?=base_url().uri_string();?>?start=<?=date($dateFormats['php_sdate'],strtotime('first day of last month'));?>&end=<?=date($dateFormats['php_sdate'],strtotime('last day of last month'));?>"><?=lang('last_month');?></a>
                  </li>
                  <li class="range_tab">
                    <a href="<?=base_url().uri_string();?>?start=<?=date($dateFormats['php_sdate'], strtotime(date('Y-m-1')));?>"><?=lang('this_month');?></a>
                  </li>
                  <li  class="range_tab">
                    <a href="<?=base_url().uri_string();?>?start=<?=date($dateFormats['php_sdate'],strtotime("-7 days"));?>"><?=lang('last_7_days');?></a>
                  </li>
                  <li class="custom">
                    <form  method="get">
                      <input type="text" placeholder="" value="<?=set_value('start');?>" name="start" class="form-control date" autocomplete="off" id="start_date" style="display: inline; width: auto;"> 
                      <span>--</span>            
                      <input type="text" placeholder="" value="<?=set_value('end');?>" name="end" class="form-control date" autocomplete="off" id="end_date" style="display: inline; width: auto;">      
                      
                      <span>--</span>            
                        <?php
                            $us = ['' => lang('please_select')];
                            foreach ($users as $user) {
                                $us[$user->id] = $user->first_name.' '.$user->last_name;
                            }
                        ?>
                        <?= form_dropdown('created_by', $us, set_value('created_by'), 'class="form-control" style="display: inline; width: auto;" '); ?>
                      <button type="submit" class="btn btn-primary" value="Go">Go</button>
                    </form>
                  </li>
                </ul>
              </div>
              <div class="inside chart-with-sidebar">
                <div class="row">
                  <div class="col-md-3 no-padding">
                    <div class="chart-sidebar">
                      <ul class="chart-legend">
                       
                        <li style="border-color: #ecf0f1" class="highlight_series " data-series="0" data-tip="">
                          <strong><?=$reports_data['order_counts_total'];?></strong> <?=lang('gross sales in this period');?>               
                        </li>
                      </ul>
                      <ul class="chart-widgets">
                      </ul>
                    </div>
                  </div>
                  <div class="col-md-9 no-padding">
                    <div class="chart-container">
                      <div class="chart-placeholder main"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>


<input type="hidden" id="reports_data" value="<?=htmlspecialchars(json_encode($reports_data));?>"/>
<script src="<?=base_url();?>panel/misc/js/finance"></script>
