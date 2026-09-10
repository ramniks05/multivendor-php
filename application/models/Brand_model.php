<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Brand_model extends CI_Model
{
    public function get_brands()
    {
        $this->db->order_by('id', 'ASC');
        return $this->db->get('brands')->result();
    }

    public function get_brand($id)
    {
        $this->db->where('id', clean_number($id));
        return $this->db->get('brands')->row();
    }

    public function add_brand()
    {
        $name_array = array();
        foreach ($this->languages as $language) {
            $name_array[] = array(
                'lang_id' => $language->id,
                'name' => trim($this->input->post('name_lang_' . $language->id, true))
            );
        }
        $main_name = trim($this->input->post('name_lang_' . $this->selected_lang->id, true));
        if (empty($main_name)) {
            return false;
        }
        $slug = trim($this->input->post('slug', true));
        if (empty($slug)) {
            $slug = str_slug($main_name);
        } else {
            $slug = str_slug($slug);
        }
        $data = array(
            'slug' => $this->make_unique_slug($slug),
            'name_data' => serialize($name_array),
            'created_at' => date('Y-m-d H:i:s')
        );
        return $this->db->insert('brands', $data);
    }

    public function update_brand($id)
    {
        $brand = $this->get_brand($id);
        if (empty($brand)) {
            return false;
        }
        $name_array = array();
        foreach ($this->languages as $language) {
            $name_array[] = array(
                'lang_id' => $language->id,
                'name' => trim($this->input->post('name_lang_' . $language->id, true))
            );
        }
        $main_name = trim($this->input->post('name_lang_' . $this->selected_lang->id, true));
        if (empty($main_name)) {
            return false;
        }
        $slug = trim($this->input->post('slug', true));
        if (empty($slug)) {
            $slug = str_slug($main_name);
        } else {
            $slug = str_slug($slug);
        }
        $data = array(
            'slug' => $this->make_unique_slug($slug, $id),
            'name_data' => serialize($name_array)
        );
        $this->db->where('id', clean_number($id));
        return $this->db->update('brands', $data);
    }

    public function delete_brand($id)
    {
        $id = clean_number($id);
        $this->db->where('id', $id);
        if ($this->db->delete('brands')) {
            if ($this->db->field_exists('brand_id', 'products')) {
                $this->db->where('brand_id', $id)->update('products', array('brand_id' => 0));
            }
            return true;
        }
        return false;
    }

    private function make_unique_slug($slug, $except_id = null)
    {
        if (empty($slug)) {
            $slug = uniqid();
        }
        $this->db->where('slug', $slug);
        if (!empty($except_id)) {
            $this->db->where('id !=', clean_number($except_id));
        }
        $row = $this->db->get('brands')->row();
        if (!empty($row)) {
            return $slug . '-' . time();
        }
        return $slug;
    }
}
