<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
  <div class="col-12">
    <div class="card">

      <div class="card-header">
              <h3 class="card-title"><i class="fa-fw fa fa-plus"></i><?= lang('add_product'); ?></h3>
          </div>
      <!-- /.card-header -->
      <div class="card-body">


                    <div class="col-lg-12">
                        <?php
                        $attrib = array('data-toggle' => 'validator', 'role' => 'form');
                        echo form_open_multipart("panel/inventory/edit/".$product->id, $attrib)
                        ?>
                <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <?= lang("product_type", "type") ?>
                                <?php
                                $opts = array('standard' => lang('standard'), 'service' => lang('service'));
                                echo form_dropdown('type', $opts, (isset($_POST['type']) ? $_POST['type'] : ($product ? $product->type : '')), 'class="form-control" id="product_type" required="required"');
                                ?>
                            </div>
                            <div class="form-group all">
                                <?= lang("product_name", 'name') ?>
                                <?= form_input('name', (isset($_POST['name']) ? $_POST['name'] : ($product ? $product->name : '')), 'class="form-control" id="name" required="required"'); ?>
                            </div>
                            <div class="form-group all">
                                <?= lang("product_code", 'code') ?>
                                <div class="input-group">
                                    <?= form_input('code', (isset($_POST['code']) ? $_POST['code'] : ($product ? $product->code : '')), 'class="form-control" id="code"  required="required"') ?>
                                    <span class="input-group-addon pointer" id="random_num" style="padding: 1px 10px;">
                                        <i class="fa fa-random"></i>
                                    </span>
                                </div>
                                <span class="help-block"><?= lang('you_scan_your_barcode_too') ?></span>
                            </div>

                            <div class="form-group all">
                                <?= lang("product_price", 'price') ?>
                                <?= form_input('price', (isset($_POST['price']) ? $_POST['price'] : ($product ? ($product->price) : '')), 'class="form-control tip" id="price" required="required"') ?>
                            </div>
                            <div class="form-group standard">
                                <?= lang("quantity", 'quantity') ?>
                                <?= form_input('quantity', (isset($_POST['quantity']) ? $_POST['quantity'] : ($product ? $this->repairer->formatDecimal($product->quantity) : '')), 'class="form-control tip" id="quantity" disabled="disabled"') ?>
                            </div>

                           
                            
                        </div>
                        <div class="col-md-4">
                            <div class="form-group standard">
                                <div class="form-group all">
                                    <?= lang("supplier", "supplier") ?>
                                    <?php
                                    $sup = array();
                                    if($suppliers): foreach ($suppliers as $supplier) {
                                        $sup[$supplier->id] = $supplier->name;
                                    }endif;
                                    echo form_dropdown('supplier[]', $sup, explode(',', $product->supplier), 'class="form-control select" multiple id="supplier" placeholder="' . lang("select") . " " . lang("supplier") . '" required="required" style="width:100%"')
                                    ?>
                                </div>
                            </div>

                            <div class="form-group all">
                                <?= lang("category", "category") ?>
                                <?php
                                    $cat[''] = lang('please_select');
                                foreach ($categories as $category) {
                                    $cat[$category->id] = $category->name;
                                }
                                echo form_dropdown('category', $cat, (isset($_POST['category']) ? $_POST['category'] : ($product ? $product->category_id : '')), 'class="form-control select" id="category" placeholder="' . lang("select") . " " . lang("category") . '" style="width:100%"')
                                ?>
                            </div>
                            <div class="form-group all">
                                <?= lang("subcategory", "subcategory") ?>
                                <div class="controls" id="subcat_data"> 
                                    <select style="width: 100%;" name="subcategory" id="subcategory">
                                        <option selected value="<?= $product->subcategory_id; ?>"><?= $product->subcategory; ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group all">
                                <?= lang("model_title", 'model') ?>
                                <select name="model" class="form-control select" id="model" placeholder="Select Model" style="width:100%">  
                                    <option></option>
                                    <?php if ($models): ?>
                                        <?php foreach ($models as $model): ?>
                                            <option value="<?= $model->id ?>" <?= ($model->id == $product->model_id) ? 'selected' : '' ?>><?= $model->name; ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <?php if ($settings->tax1) { ?>
                                <div class="form-group all">
                                    <?= lang("product_tax", 'tax_rate') ?>
                                    <?php
                                    $tr[""] = "";
                                    foreach ($tax_rates as $tax) {
                                        $tr[$tax['id']] = $tax['name'];
                                    }
                                    echo form_dropdown('tax_rate', $tr, (isset($_POST['tax_rate']) ? $_POST['tax_rate'] : ($product ? $product->tax_rate : $settings->default_tax_rate)), 'class="form-control select" id="tax_rate" placeholder="' . lang("select") . ' ' . lang("product_tax") . '" style="width:100%"')
                                    ?>
                                </div>
                                <div class="form-group all">
                                    <?= lang("tax_method", 'tax_method') ?>
                                    <?php
                                    $tm = array('0' => lang('inclusive'), '1' => lang('exclusive'));
                                    echo form_dropdown('tax_method', $tm, (isset($_POST['tax_method']) ? $_POST['tax_method'] : ($product ? $product->tax_method : '')), 'class="form-control select" id="tax_method" placeholder="' . lang("select") . ' ' . lang("tax_method") . '" style="width:100%"')
                                    ?>
                                </div>
                            <?php } ?>
                             <div class="form-group standard">
                                <?= lang("alert_quantity", 'alert_quantity') ?>
                                <?= form_input('alert_quantity', (isset($_POST['alert_quantity']) ? $_POST['alert_quantity'] : ($product ? $this->repairer->formatQuantity($product->alert_quantity) : '')), 'class="form-control tip" id="alert_quantity"') ?>
                            </div>
                            <div class="form-group standard">
                                <?= lang('product_unit', 'unit'); ?>
                                <?= form_input('unit', (isset($_POST['unit']) ? $_POST['unit'] : ($product ? $product->unit : '')), 'class="form-control" id="unit"'); ?>
                            </div>
                            <div class="form-group standard">
                                <?= lang("product_cost", 'cost') ?>
                                <?= form_input('cost', (isset($_POST['cost']) ? $_POST['cost'] : ($product ? ($product->cost) : '')), 'class="form-control tip" id="cost" required="required"') ?>
                            </div>

                            <div class="form-group all">
                                <?= lang("product_image", "product_image") ?>
                                <input id="product_image" type="file" data-browse-label="<?= lang('browse'); ?>" name="product_image" data-show-upload="false"
                                       data-show-preview="false" accept="image/*" class="form-control file">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group all">
                                <?= lang("product_details", 'details') ?>
                                <?= form_textarea('details', (isset($_POST['details']) ? $_POST['details'] : ($product ? $product->details : '')), 'class="form-control" id="details"'); ?>
                            </div>

                            <div class="form-group">
                                <?php echo form_submit('edit_product', lang("edit_product"), 'class="btn btn-primary"'); ?>
                            </div>

                        </div>
                    </div>
                        
                        <?= form_close(); ?>
                </div>
            </div>
            <!-- /.box-body -->
          </div>
      </div>
  </div>
  <script type="text/javascript" src="<?=base_url();?>panel/misc/js/inventory_add"></script>

