<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Brand_controller extends Admin_Core_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!is_admin()) {
            redirect(admin_url() . 'login');
        }
    }

    public function brands()
    {
        $data['title'] = trans("brands");
        $data['brands'] = $this->brand_model->get_brands();

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/brand/brands', $data);
        $this->load->view('admin/includes/_footer');
    }

    public function add_brand_post()
    {
        $this->form_validation->set_rules('name_lang_' . $this->selected_lang->id, trans("brand_name"), 'required|xss_clean|max_length[255]');
        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('error_form', validation_errors());
            $this->session->set_flashdata('form_data', $this->input->post());
            redirect($this->agent->referrer());
            return;
        }
        if ($this->brand_model->add_brand()) {
            reset_cache_data($this, "st");
            $this->session->set_flashdata('success_form', trans("msg_brand_added"));
        } else {
            $this->session->set_flashdata('error_form', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }

    public function update_brand($id)
    {
        $data['title'] = trans("update_brand");
        $data['brand'] = $this->brand_model->get_brand($id);
        if (empty($data['brand'])) {
            redirect(admin_url() . 'brands');
            return;
        }

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/brand/update_brand', $data);
        $this->load->view('admin/includes/_footer');
    }

    public function update_brand_post()
    {
        $id = $this->input->post('id', true);
        $this->form_validation->set_rules('name_lang_' . $this->selected_lang->id, trans("brand_name"), 'required|xss_clean|max_length[255]');
        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('error', validation_errors());
            redirect($this->agent->referrer());
            return;
        }
        if ($this->brand_model->update_brand($id)) {
            reset_cache_data($this, "st");
            $this->session->set_flashdata('success', trans("msg_updated"));
            redirect(admin_url() . 'brands');
            return;
        }
        $this->session->set_flashdata('error', trans("msg_error"));
        redirect($this->agent->referrer());
    }

    public function delete_brand_post()
    {
        $id = $this->input->post('id', true);
        if ($this->brand_model->delete_brand($id)) {
            reset_cache_data($this, "st");
            $this->session->set_flashdata('success', trans("msg_deleted"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
    }
}
