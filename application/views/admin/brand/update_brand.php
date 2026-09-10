<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-lg-5 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?php echo trans("update_brand"); ?></h3>
                </div>
                <div class="right">
                    <a href="<?php echo admin_url(); ?>brands" class="btn btn-success btn-add-new">
                        <i class="fa fa-list-ul"></i>&nbsp;&nbsp;<?php echo trans('brands'); ?>
                    </a>
                </div>
            </div>
            <?php echo form_open('brand_controller/update_brand_post'); ?>
            <input type="hidden" name="id" value="<?php echo $brand->id; ?>">
            <div class="box-body">
                <?php $this->load->view('admin/includes/_messages'); ?>
                <?php foreach ($this->languages as $language): ?>
                    <div class="form-group">
                        <label><?php echo trans("brand_name"); ?><?php echo item_count($this->languages) > 1 ? ' (' . $language->name . ')' : ''; ?></label>
                        <input type="text" class="form-control" name="name_lang_<?php echo $language->id; ?>" value="<?php echo parse_serialized_name_array($brand->name_data, $language->id, false); ?>" placeholder="<?php echo trans("brand_name"); ?>" maxlength="255" <?php echo ($language->id == $this->selected_lang->id) ? 'required' : ''; ?>>
                    </div>
                <?php endforeach; ?>
                <div class="form-group">
                    <label class="control-label"><?php echo trans("slug"); ?>
                        <small>(<?php echo trans("slug_exp"); ?>)</small>
                    </label>
                    <input type="text" class="form-control" name="slug" value="<?php echo html_escape($brand->slug); ?>" placeholder="<?php echo trans("slug"); ?>">
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
