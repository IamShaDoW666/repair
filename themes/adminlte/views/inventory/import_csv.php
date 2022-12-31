<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
  <div class="col-12">
    <div class="card">

      <div class="card-header">
              <h3 class="card-title"><i class="fa-fw fa fa-plus"></i><?= lang('import_products_by_csv'); ?></h3>
          </div>
      <!-- /.card-header -->
      <div class="card-body">
        

                <?php
                $attrib = array('class' => 'form-horizontal', 'data-toggle' => 'validator', 'role' => 'form');
                echo form_open_multipart("panel/inventory/import_csv", $attrib)
                ?>
                <div class="row">
                    <div class="col-md-12">

                        <div class="well well-small">
                            <a href="<?php echo base_url(); ?>assets/csv/sample_inventory.csv"
                               class="btn-icon btn btn-primary btn-icon pull-right"><i
                                    class="fa fa-download img-circle text-primary"></i> <?= lang("download_current_file") ?></a>
                            <p>
                                <span class="text-warning"><?= lang("csv1"); ?></span><br/><?= lang("csv2"); ?> <span
                                class="text-info">(<?= lang("name") . ', ' . lang("code") . ', ' . lang("category_code") . ', ' .  lang("cost") . ', ' . lang("price") . ', ' . lang("alert_quantity") . ', ' . lang("tax") . ', ' . lang("tax_method") . ', ' . lang("image") . ', ' . lang("subcategory_code"); ?>
                                )</span> <?= lang("csv3"); ?>
                            </p>
                            <p><?= lang('images_location_tip'); ?></p>
                            <span class="text-primary"><?= lang('csv_update_tip'); ?></span>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="csv_file"><?= lang("upload_file"); ?></label>
                                <input type="file" data-browse-label="<?= lang('browse'); ?>" name="userfile" class="form-control file" data-show-upload="false" data-show-preview="false" id="csv_file" required="required"/>
                            </div>

                            <div class="form-group">
                                <button class="btn-icon btn btn-primary" role="submit">
                                    <i class="fa fa-upload img-circle text-primary"></i>
                                    <?= $this->lang->line("import");?>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <?= form_close(); ?>
      </div>
  </div>
</div>
