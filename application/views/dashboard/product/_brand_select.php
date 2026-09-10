<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php if ($this->db->table_exists('brands')):
    $brands = $this->brand_model->get_brands();
    $selected_brand_id = (!empty($product) && !empty($product->brand_id)) ? $product->brand_id : 0; ?>
    <div class="form-group">
        <label class="control-label"><?php echo trans("brand"); ?></label>
        <select name="brand_id" class="form-control custom-select">
            <option value="0"><?php echo trans("select_brand"); ?></option>
            <?php if (!empty($brands)):
                foreach ($brands as $brand): ?>
                    <option value="<?php echo $brand->id; ?>" <?php echo ($selected_brand_id == $brand->id) ? 'selected' : ''; ?>><?php echo get_brand_name($brand); ?></option>
                <?php endforeach;
            endif; ?>
        </select>
    </div>
<?php endif; ?>
