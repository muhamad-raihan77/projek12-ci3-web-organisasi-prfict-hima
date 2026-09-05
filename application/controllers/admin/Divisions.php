<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Divisions extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Division_model');
        
        if (!$this->session->userdata('admin_logged_in')) {
            redirect('admin/login');
        }
    }

    /**
     * List all divisions
     */
    public function index() {
        $data['title'] = 'Kelola Divisi | Admin PR FICT';
        $data['active_menu'] = 'divisions';
        $data['divisions'] = $this->Division_model->get_all();
        
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/divisions', $data);
        $this->load->view('admin/templates/footer');
    }

    /**
     * Add new division
     */
    public function add() {
        $this->form_validation->set_rules('name', 'Nama Divisi', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('description', 'Deskripsi', 'required|trim');
        $this->form_validation->set_rules('icon', 'Icon', 'required|trim');
        
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors('', ''));
            redirect('admin/divisi');
            return;
        }
        
        $data = [
            'name' => $this->input->post('name', TRUE),
            'description' => $this->input->post('description', TRUE),
            'icon' => $this->input->post('icon', TRUE),
            'is_active' => 1,
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        if ($this->Division_model->insert($data)) {
            $this->session->set_flashdata('success', 'Divisi berhasil ditambahkan.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menambahkan divisi.');
        }
        
        redirect('admin/divisi');
    }

    /**
     * Edit division
     */
    public function edit($id) {
        $this->form_validation->set_rules('name', 'Nama Divisi', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('description', 'Deskripsi', 'required|trim');
        $this->form_validation->set_rules('icon', 'Icon', 'required|trim');
        
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors('', ''));
            redirect('admin/divisi');
            return;
        }
        
        $data = [
            'name' => $this->input->post('name', TRUE),
            'description' => $this->input->post('description', TRUE),
            'icon' => $this->input->post('icon', TRUE),
        ];
        
        if ($this->Division_model->update($id, $data)) {
            $this->session->set_flashdata('success', 'Divisi berhasil diperbarui.');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui divisi.');
        }
        
        redirect('admin/divisi');
    }

    /**
     * Delete division
     */
    public function delete($id) {
        if ($this->Division_model->has_applicants($id)) {
            $this->session->set_flashdata('error', 'Divisi tidak dapat dihapus karena masih memiliki pendaftar.');
            redirect('admin/divisi');
            return;
        }
        
        if ($this->Division_model->delete($id)) {
            $this->session->set_flashdata('success', 'Divisi berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus divisi.');
        }
        
        redirect('admin/divisi');
    }

    /**
     * Toggle division active status
     */
    public function toggle($id) {
        if ($this->Division_model->toggle_active($id)) {
            $this->session->set_flashdata('success', 'Status divisi berhasil diubah.');
        } else {
            $this->session->set_flashdata('error', 'Gagal mengubah status divisi.');
        }
        
        redirect('admin/divisi');
    }
}
