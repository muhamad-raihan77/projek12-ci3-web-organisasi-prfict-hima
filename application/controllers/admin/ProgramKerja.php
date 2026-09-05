<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProgramKerja extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Program_kerja_model');
        $this->load->model('Division_model');
        $this->load->library('upload');

        if (!$this->session->userdata('admin_logged_in')) {
            redirect('admin/login');
        }
    }

    public function index() {
        $data['title'] = 'Kelola Program Kerja | Admin PR FICT';
        $data['active_menu'] = 'program_kerja';
        $data['programs'] = $this->Program_kerja_model->get_all();
        $data['divisions'] = $this->Division_model->get_all();
        $data['stats'] = $this->Program_kerja_model->get_stats();

        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/program_kerja', $data);
        $this->load->view('admin/templates/footer');
    }

    public function add() {
        $this->form_validation->set_rules('nama_program', 'Nama Program', 'required|trim');
        $this->form_validation->set_rules('divisi', 'Divisi', 'required|trim');
        $this->form_validation->set_rules('pic', 'PIC', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('admin/program-kerja');
            return;
        }

        $data = [
            'nama_program' => $this->input->post('nama_program', TRUE),
            'divisi'       => $this->input->post('divisi', TRUE),
            'activity'     => $this->input->post('activity', TRUE),
            'target'       => $this->input->post('target', TRUE),
            'pic'          => $this->input->post('pic', TRUE),
            'status'       => $this->input->post('status', TRUE) ? $this->input->post('status', TRUE) : 'Belum Dimulai'
        ];

        $this->Program_kerja_model->insert($data);
        $this->session->set_flashdata('success', 'Program kerja berhasil ditambahkan.');
        redirect('admin/program-kerja');
    }

    public function edit($id) {
        $program = $this->Program_kerja_model->get_by_id($id);
        if (!$program) {
            show_404();
            return;
        }

        $this->form_validation->set_rules('nama_program', 'Nama Program', 'required|trim');
        $this->form_validation->set_rules('divisi', 'Divisi', 'required|trim');
        $this->form_validation->set_rules('pic', 'PIC', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('admin/program-kerja');
            return;
        }

        $data = [
            'nama_program' => $this->input->post('nama_program', TRUE),
            'divisi'       => $this->input->post('divisi', TRUE),
            'activity'     => $this->input->post('activity', TRUE),
            'target'       => $this->input->post('target', TRUE),
            'pic'          => $this->input->post('pic', TRUE),
            'status'       => $this->input->post('status', TRUE)
        ];

        $this->Program_kerja_model->update($id, $data);
        $this->session->set_flashdata('success', 'Program kerja berhasil diperbarui.');
        redirect('admin/program-kerja');
    }

    public function delete($id) {
        $this->Program_kerja_model->delete($id);
        $this->session->set_flashdata('success', 'Program kerja berhasil dihapus.');
        redirect('admin/program-kerja');
    }

    public function update_status($id) {
        $status = $this->input->post('status', TRUE);
        if (in_array($status, ['Belum Dimulai', 'Berjalan', 'Selesai'])) {
            $this->Program_kerja_model->update($id, ['status' => $status]);
            $this->session->set_flashdata('success', 'Status program kerja berhasil diubah.');
        }
        redirect('admin/program-kerja');
    }

    public function upload_dokumentasi($id) {
        $program = $this->Program_kerja_model->get_by_id($id);
        if (!$program) {
            show_404();
            return;
        }

        if (empty($_FILES['dokumentasi_files']['name'][0])) {
            $this->session->set_flashdata('error', 'Pilih minimal satu file gambar untuk diupload.');
            redirect('admin/program-kerja');
            return;
        }

        $upload_dir = './uploads/program_dokumentasi/';
        if (!is_dir($upload_dir)) {
            @mkdir($upload_dir, 0777, TRUE);
        }

        $filesCount = count($_FILES['dokumentasi_files']['name']);
        $upload_success = 0;

        for ($i = 0; $i < $filesCount; $i++) {
            if (empty($_FILES['dokumentasi_files']['name'][$i])) continue;

            $_FILES['file']['name']     = $_FILES['dokumentasi_files']['name'][$i];
            $_FILES['file']['type']     = $_FILES['dokumentasi_files']['type'][$i];
            $_FILES['file']['tmp_name'] = $_FILES['dokumentasi_files']['tmp_name'][$i];
            $_FILES['file']['error']    = $_FILES['dokumentasi_files']['error'][$i];
            $_FILES['file']['size']     = $_FILES['dokumentasi_files']['size'][$i];

            $config['upload_path']   = $upload_dir;
            $config['allowed_types'] = 'jpg|jpeg|png|webp|JPG|JPEG|PNG|WEBP';
            $config['max_size']      = 10240; // 10MB
            $config['encrypt_name']  = TRUE;

            $this->upload->initialize($config);

            if ($this->upload->do_upload('file')) {
                $fileData = $this->upload->data();
                $this->Program_kerja_model->insert_dokumentasi([
                    'program_kerja_id' => $id,
                    'file_name'        => $fileData['file_name'],
                    'caption'          => $this->input->post('caption', TRUE)
                ]);
                $upload_success++;
            }
        }

        if ($upload_success > 0) {
            $this->session->set_flashdata('success', "$upload_success foto dokumentasi berhasil diupload.");
        } else {
            $this->session->set_flashdata('error', 'Gagal mengupload foto dokumentasi. Pastikan format gambar sesuai (jpg, png, webp) & ukuran max 10MB.');
        }

        redirect('admin/program-kerja');
    }

    public function delete_dokumentasi($id) {
        $this->Program_kerja_model->delete_dokumentasi($id);
        $this->session->set_flashdata('success', 'Foto dokumentasi berhasil dihapus.');
        redirect('admin/program-kerja');
    }
}
