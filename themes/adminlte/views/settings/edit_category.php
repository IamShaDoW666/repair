<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title" id="myModalLabel"><?php echo lang('edit_category'); ?></h5>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa">&times;</i>
            </button>
        </div>
        <?php $attrib = array('data-toggle' => 'validator', 'role' => 'form', 'id'=>'form_cat');
        echo form_open_multipart("panel/settings/edit_category/".$category->id, $attrib); ?>
        <div class="modal-body">
            <p><?= lang('update_info'); ?></p>

            <div class="form-group">
                <?= lang('category_code', 'code'); ?>
                <?= form_input('code', set_value('code', $category->code), 'class="form-control" id="code" required="required" data-parsley-minlength="3"'); ?>
            </div>

            <div class="form-group">
                <?= lang('category_name', 'name'); ?>
                <?= form_input('name', set_value('name', $category->name), 'class="form-control gen_slug" id="name" required="required" data-parsley-minlength="3"'); ?>
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
                echo form_dropdown('parent', $cat, (isset($_POST['parent']) ? $_POST['parent'] : $category->parent_id), 'class="form-control select" id="parent" style="width:100%"')
                ?>
            </div>
        </div>
        <div class="modal-footer">
            <?php echo form_submit('edit_category', lang('edit_category'), 'class="btn btn-primary"'); ?>
        </div>
    </div>
    <?php echo form_close(); ?>
