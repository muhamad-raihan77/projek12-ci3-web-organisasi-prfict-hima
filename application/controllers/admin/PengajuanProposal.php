<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PengajuanProposal extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Pengajuan_proposal_model');
        $this->load->model('Division_model');
        $this->load->library('upload');
        $this->load->library('pdf_generator');

        if (!$this->session->userdata('admin_logged_in')) {
            redirect('admin/login');
        }
    }

    /**
     * Admin Index - List all proposal submissions
     */
    public function index() {
        $data['title'] = 'Kelola Pengajuan Proposal | Admin PR FICT';
        $data['active_menu'] = 'pengajuan_proposal';
        $data['proposals'] = $this->Pengajuan_proposal_model->get_all();
        $data['divisions'] = $this->Division_model->get_all();
        $data['stats'] = $this->Pengajuan_proposal_model->get_stats();

        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/pengajuan_proposal', $data);
        $this->load->view('admin/templates/footer');
    }

    /**
     * Admin Add Proposal
     */
    public function add() {
        $this->form_validation->set_rules('nama_program', 'Nama Program', 'required|trim');
        $this->form_validation->set_rules('divisi', 'Divisi', 'required|trim');
        $this->form_validation->set_rules('pic', 'PIC', 'required|trim');
        $this->form_validation->set_rules('tanggal_pelaksanaan', 'Tanggal Pelaksanaan', 'required|trim');
        $this->form_validation->set_rules('lokasi', 'Lokasi', 'required|trim');
        $this->form_validation->set_rules('projek_brief', 'Projek Brief', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('admin/pengajuan-proposal');
            return;
        }

        $pdf_file_name = NULL;
        if (!empty($_FILES['proposal_file']['name'])) {
            $upload_result = $this->_upload_pdf();
            if ($upload_result['status'] === false) {
                $this->session->set_flashdata('error', 'Gagal mengunggah berkas PDF: ' . $upload_result['error']);
                redirect('admin/pengajuan-proposal');
                return;
            }
            $pdf_file_name = $upload_result['file_name'];
        }

        $data = [
            'user_id'             => NULL,
            'nama_program'        => $this->input->post('nama_program', TRUE),
            'divisi'              => $this->input->post('divisi', TRUE),
            'pic'                 => $this->input->post('pic', TRUE),
            'tanggal_pelaksanaan' => $this->input->post('tanggal_pelaksanaan', TRUE),
            'lokasi'              => $this->input->post('lokasi', TRUE),
            'projek_brief'        => $this->input->post('projek_brief', TRUE),
            'proposal_file'       => $pdf_file_name,
            'catatan'             => $this->input->post('catatan', TRUE),
            'status'              => $this->input->post('status', TRUE) ? $this->input->post('status', TRUE) : 'Submit'
        ];

        $this->Pengajuan_proposal_model->insert($data);
        $this->session->set_flashdata('success', 'Pengajuan proposal berhasil ditambahkan oleh admin.');
        redirect('admin/pengajuan-proposal');
    }

    /**
     * Admin Edit Proposal details
     */
    public function edit($id) {
        $proposal = $this->Pengajuan_proposal_model->get_by_id($id);
        if (!$proposal) {
            show_404();
            return;
        }

        $this->form_validation->set_rules('nama_program', 'Nama Program', 'required|trim');
        $this->form_validation->set_rules('divisi', 'Divisi', 'required|trim');
        $this->form_validation->set_rules('pic', 'PIC', 'required|trim');
        $this->form_validation->set_rules('tanggal_pelaksanaan', 'Tanggal Pelaksanaan', 'required|trim');
        $this->form_validation->set_rules('lokasi', 'Lokasi', 'required|trim');
        $this->form_validation->set_rules('projek_brief', 'Projek Brief', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('admin/pengajuan-proposal');
            return;
        }

        $pdf_file_name = $proposal->proposal_file;
        if (!empty($_FILES['proposal_file']['name'])) {
            $upload_result = $this->_upload_pdf();
            if ($upload_result['status'] === false) {
                $this->session->set_flashdata('error', 'Gagal mengunggah berkas PDF: ' . $upload_result['error']);
                redirect('admin/pengajuan-proposal');
                return;
            }
            if ($pdf_file_name && file_exists('./uploads/proposal_files/' . $pdf_file_name)) {
                @unlink('./uploads/proposal_files/' . $pdf_file_name);
            }
            $pdf_file_name = $upload_result['file_name'];
        }

        $data = [
            'nama_program'        => $this->input->post('nama_program', TRUE),
            'divisi'              => $this->input->post('divisi', TRUE),
            'pic'                 => $this->input->post('pic', TRUE),
            'tanggal_pelaksanaan' => $this->input->post('tanggal_pelaksanaan', TRUE),
            'lokasi'              => $this->input->post('lokasi', TRUE),
            'projek_brief'        => $this->input->post('projek_brief', TRUE),
            'proposal_file'       => $pdf_file_name,
            'catatan'             => $this->input->post('catatan', TRUE)
        ];

        $this->Pengajuan_proposal_model->update($id, $data);
        $this->session->set_flashdata('success', 'Data pengajuan proposal berhasil diperbarui.');
        redirect('admin/pengajuan-proposal');
    }

    /**
     * Admin update status & catatan revisi
     */
    public function update_status($id) {
        $proposal = $this->Pengajuan_proposal_model->get_by_id($id);
        if (!$proposal) {
            show_404();
            return;
        }

        $status = $this->input->post('status', TRUE);
        $catatan_revisi = $this->input->post('catatan_revisi', TRUE);

        if (in_array($status, ['Submit', 'Review', 'Revisi', 'Approve', 'Ditolak'])) {
            $admin_name = $this->session->userdata('admin_name') ? $this->session->userdata('admin_name') : 'Admin';
            $this->Pengajuan_proposal_model->update_status($id, $status, $catatan_revisi, $admin_name);
            $this->session->set_flashdata('success', 'Status pengajuan proposal berhasil diperbarui menjadi "' . $status . '".');
        } else {
            $this->session->set_flashdata('error', 'Status pengajuan tidak valid.');
        }

        redirect('admin/pengajuan-proposal');
    }

    /**
     * Admin delete proposal
     */
    public function delete($id) {
        $this->Pengajuan_proposal_model->delete($id);
        $this->session->set_flashdata('success', 'Data pengajuan proposal berhasil dihapus.');
        redirect('admin/pengajuan-proposal');
    }

    /**
     * Admin download PDF summary
     */
    public function pdf($id) {
        $proposal = $this->Pengajuan_proposal_model->get_by_id($id);
        if (!$proposal) {
            show_404();
            return;
        }

        $data['proposal'] = $proposal;
        $data['history'] = $this->Pengajuan_proposal_model->get_history($id);

        $html = $this->load->view('frontend/pengajuan_proposal/pdf_summary', $data, TRUE);
        $filename = 'Proposal_' . url_title($proposal->nama_program, '_', TRUE) . '.pdf';
        $this->pdf_generator->generate($html, $filename);
    }

    /**
     * Upload PDF helper
     */
    private function _upload_pdf() {
        $config['upload_path'] = './uploads/proposal_files/';
        $config['allowed_types'] = 'pdf';
        $config['max_size'] = 10240; // 10MB
        $config['encrypt_name'] = TRUE;

        if (!is_dir($config['upload_path'])) {
            @mkdir($config['upload_path'], 0755, TRUE);
        }

        $this->upload->initialize($config);

        if ($this->upload->do_upload('proposal_file')) {
            return [
                'status' => true,
                'file_name' => $this->upload->data('file_name')
            ];
        }

        return [
            'status' => false,
            'error' => $this->upload->display_errors('', '')
        ];
    }
}
