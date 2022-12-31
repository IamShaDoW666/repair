<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="myModalLabel"><?php echo lang('add_category'); ?></h5>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa">&times;</i>
            </button>
        </div>
        <?php $attrib = array('data-toggle' => 'validator', 'role' => 'form', 'id'=>"form_cat");
        echo form_open_multipart("panel/settings/add_category", $attrib); ?>
        <div class="modal-body">
            <p><?= lang('enter_info'); ?></p>

            <div class="form-group">
                <?= lang('category_code', 'code'); ?>
                <?= form_input('code', set_value('code'), 'data-parsley-minlength="3" class="form-control" id="code" required="required"'); ?>
            </div>

            <div class="form-group">
                <?= lang('category_name', 'name'); ?>
                <?= form_input('name', set_value('name'), 'data-parsley-minlength="3" class="form-control gen_slug" id="name" required="required"'); ?>
            </div>

            <div class="form-group">
                <?= lang("category_image", "image") ?>
                <input id="image" type="file" data-browse-label="<?= lang('browse'); ?>" name="userfile" data-show-upload="false" data-show-preview="false" class="form-control file">
            </div>
            <div class="form-group">
                <?= lang("parent_category", "parent") ?>
                <?php
                $cat[''] = lang('select').' '.lang('parent_category');
                if ($categories) {
                    foreach ($categories as $pcat) {
                        $cat[$pcat->id] = $pcat->name;
                    }
                }
                
                echo form_dropdown('parent', $cat, (isset($_POST['parent']) ? $_POST['parent'] : ''), 'class="form-control select" id="parent" style="width:100%"')
                ?>
            </div>
        </div>
        <div class="modal-footer">
            <?php echo form_submit('add_category', lang('add_category'), 'class="btn btn-primary"'); ?>
        </div>
    <?php echo form_close(); ?>
        </div>
