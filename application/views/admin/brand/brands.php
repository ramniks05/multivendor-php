<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-lg-5 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans("add_brand"); ?></h3>
            </div>
            <?php echo form_open('brand_controller/add_brand_post'); ?>
            <div class="box-body">
                <?php $this->load->view('admin/includes/_messages_form'); ?>
                <?php foreach ($this->languages as $language): ?>
                    <div class="form-group">
                        <label><?php echo trans("brand_name"); ?><?php echo item_count($this->languages) > 1 ? ' (' . $language->name . ')' : ''; ?></label>
                        <input type="text" class="form-control" name="name_lang_<?php echo $language->id; ?>" placeholder="<?php echo trans("brand_name"); ?>" maxlength="255" <?php echo ($language->id == $this->selected_lang->id) ? 'required' : ''; ?>>
                    </div>
                <?php endforeach; ?>
                <div class="form-group">
                    <label class="control-label"><?php echo trans("slug"); ?>
                        <small>(<?php echo trans("slug_exp"); ?>)</small>
                    </label>
                    <input type="text" class="form-control" name="slug" placeholder="<?php echo trans("slug"); ?>">
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><?php echo trans('add_brand'); ?></button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
    <div class="col-lg-7 col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans('brands'); ?></h3>
            </div>
            <div class="col-sm-12">
                <?php $this->load->view('admin/includes/_messages'); ?>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" role="grid">
                        <thead>
                        <tr role="row">
                            <th width="20"><?php echo trans('id'); ?></th>
                            <th><?php echo trans('brand_name'); ?></th>
                            <th><?php echo trans('slug'); ?></th>
                            <th class="th-options"><?php echo trans('options'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($brands)):
                            foreach ($brands as $item): ?>
                                <tr>
                                    <td><?php echo html_escape($item->id); ?></td>
                                    <td><?php echo get_brand_name($item); ?></td>
                                    <td><?php echo html_escape($item->slug); ?></td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn bg-purple dropdown-toggle btn-select-option" type="button" data-toggle="dropdown"><?php echo trans('select_option'); ?>
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu options-dropdown">
                                                <li>
                                                    <a href="<?php echo admin_url(); ?>update-brand/<?php echo $item->id; ?>"><i class="fa fa-edit option-icon"></i><?php echo trans('edit'); ?></a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0)" onclick="delete_item('brand_controller/delete_brand_post','<?php echo $item->id; ?>','<?php echo trans("confirm_brand"); ?>');"><i class="fa fa-trash option-icon"></i><?php echo trans('delete'); ?></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach;
                        endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
