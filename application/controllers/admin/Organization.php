<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Organization extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Organization_model');
        
        // Check admin login
        if (!$this->session->userdata('admin_logged_in')) {
            redirect('admin/login');
        }
    }

    /**
     * List all organization members
     */
    public function index() {
        $data['title'] = 'Struktur Organisasi | Admin PR FICT';
        $data['active_menu'] = 'organization';
        $data['members'] = $this->Organization_model->get_all();
        
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/organization', $data);
        $this->load->view('admin/templates/footer');
    }

    /**
     * Add new member
     */
    public function add() {
        $this->form_validation->set_rules('name', 'Nama', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('position', 'Jabatan', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('division', 'Divisi', 'required|trim|max_length[100]');
        
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors('', ''));
            redirect('admin/organisasi');
            return;
        }
        
        $data = [
            'name'              => $this->input->post('name', TRUE),
            'position'          => $this->input->post('position', TRUE),
            'division'          => $this->input->post('division', TRUE),
            'motto'             => $this->input->post('motto', TRUE),
            'description'       => $this->input->post('description', TRUE),
            'social_instagram'  => $this->input->post('social_instagram', TRUE),
            'social_linkedin'   => $this->input->post('social_linkedin', TRUE),
            'display_order'     => $this->input->post('display_order') ? (int)$this->input->post('display_order') : $this->Organization_model->get_next_order(),
            'is_active'         => 1
        ];
        
        // Handle photo upload
        if (!empty($_FILES['photo']['name'])) {
            $photo = $this->_upload_photo();
            if ($photo === false) {
                redirect('admin/organisasi');
                return;
            }
            $data['photo'] = $photo;
        }
        
        if ($this->Organization_model->insert($data)) {
            $this->session->set_flashdata('success', 'Anggota berhasil ditambahkan.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menambahkan anggota.');
        }
        
        redirect('admin/organisasi');
    }

    /**
     * Edit member
     */
    public function edit($id) {
        $member = $this->Organization_model->get_by_id($id);
        if (!$member) {
            $this->session->set_flashdata('error', 'Anggota tidak ditemukan.');
            redirect('admin/organisasi');
            return;
        }

        $this->form_validation->set_rules('name', 'Nama', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('position', 'Jabatan', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('division', 'Divisi', 'required|trim|max_length[100]');
        
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors('', ''));
            redirect('admin/organisasi');
            return;
        }
        
        $data = [
            'name'              => $this->input->post('name', TRUE),
            'position'          => $this->input->post('position', TRUE),
            'division'          => $this->input->post('division', TRUE),
            'motto'             => $this->input->post('motto', TRUE),
            'description'       => $this->input->post('description', TRUE),
            'social_instagram'  => $this->input->post('social_instagram', TRUE),
            'social_linkedin'   => $this->input->post('social_linkedin', TRUE),
            'display_order'     => (int)$this->input->post('display_order'),
        ];
        
        // Handle photo upload
        if (!empty($_FILES['photo']['name'])) {
            $photo = $this->_upload_photo();
            if ($photo === false) {
                redirect('admin/organisasi');
                return;
            }
            // Delete old photo
            if ($member->photo) {
                $old_photo_path = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'organization' . DIRECTORY_SEPARATOR . $member->photo;
                $old_photo_path = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $old_photo_path);
                if (file_exists($old_photo_path)) {
                    unlink($old_photo_path);
                }
            }
            $data['photo'] = $photo;
        }
        
        if ($this->Organization_model->update($id, $data)) {
            $this->session->set_flashdata('success', 'Data anggota berhasil diperbarui.');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui data anggota.');
        }
        
        redirect('admin/organisasi');
    }

    /**
     * Delete member
     */
    public function delete($id) {
        $member = $this->Organization_model->get_by_id($id);
        if (!$member) {
            $this->session->set_flashdata('error', 'Anggota tidak ditemukan.');
            redirect('admin/organisasi');
            return;
        }

        // Delete photo file if exists
        if ($member->photo) {
            $old_photo_path = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'organization' . DIRECTORY_SEPARATOR . $member->photo;
            $old_photo_path = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $old_photo_path);
            if (file_exists($old_photo_path)) {
                unlink($old_photo_path);
            }
        }
        
        if ($this->Organization_model->delete($id)) {
            $this->session->set_flashdata('success', 'Anggota berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus anggota.');
        }
        
        redirect('admin/organisasi');
    }

    /**
     * Toggle active status
     */
    public function toggle($id) {
        if ($this->Organization_model->toggle_active($id)) {
            $this->session->set_flashdata('success', 'Status anggota berhasil diubah.');
        } else {
            $this->session->set_flashdata('error', 'Gagal mengubah status anggota.');
        }
        
        redirect('admin/organisasi');
    }

    /**
     * Handle photo upload with security validation
     * Only allows JPG, JPEG, PNG, WEBP — max 2MB
     */
    private function _upload_photo() {
        // Create directory if not exists
        $upload_path = FCPATH . 'uploads/organization/';
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0755, TRUE);
        }

        $config['upload_path']      = $upload_path;
        $config['allowed_types']    = 'jpg|jpeg|png|webp';
        $config['max_size']         = 2048; // 2MB
        $config['encrypt_name']     = TRUE;
        $config['file_ext_tolower'] = TRUE;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('photo')) {
            $this->session->set_flashdata('error', 'Upload foto gagal: ' . $this->upload->display_errors('', ''));
            return false;
        }

        $upload_data = $this->upload->data();
        return $upload_data['file_name'];
    }
}
