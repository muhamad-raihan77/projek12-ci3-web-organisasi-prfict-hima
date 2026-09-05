<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PengajuanProposal extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Pengajuan_proposal_model');
        $this->load->model('Division_model');
        $this->load->model('Student_model');
        $this->load->library('upload');
        $this->load->library('pdf_generator');

        // Check login
        if (!$this->session->userdata('student_logged_in')) {
            $this->session->set_flashdata('error', 'Silakan login terlebih dahulu untuk menguji/mengirimkan pengajuan proposal.');
            redirect('auth/login');
        }
    }

    /**
     * List proposals submitted by the current user
     */
    public function index() {
        $student_id = $this->session->userdata('student_id');
        $data['title'] = 'Pengajuan Proposal | PR FICT';
        $data['active_menu'] = 'pengajuan_proposal';
        $data['proposals'] = $this->Pengajuan_proposal_model->get_by_user_id($student_id);
        $data['user'] = $this->Student_model->get_by_id($student_id);

        $this->load->view('templates/header', $data);
        $this->load->view('frontend/pengajuan_proposal/index', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Form & submit new proposal
     */
    public function tambah() {
        $student_id = $this->session->userdata('student_id');
        $user = $this->Student_model->get_by_id($student_id);

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('nama_program', 'Nama Program', 'required|trim');
            $this->form_validation->set_rules('divisi', 'Divisi', 'required|trim');
            $this->form_validation->set_rules('pic', 'PIC / Penanggung Jawab', 'required|trim');
            $this->form_validation->set_rules('tanggal_pelaksanaan', 'Tanggal Pelaksanaan', 'required|trim');
            $this->form_validation->set_rules('lokasi', 'Lokasi', 'required|trim');
            $this->form_validation->set_rules('projek_brief', 'Projek Brief', 'required|trim');

            $this->form_validation->set_message('required', '{field} wajib diisi.');

            $pdf_file_name = NULL;
            $upload_error = NULL;

            // Handle proposal file PDF upload
            if (!empty($_FILES['proposal_file']['name'])) {
                $upload_result = $this->_upload_pdf();
                if ($upload_result['status'] === false) {
                    $upload_error = $upload_result['error'];
                } else {
                    $pdf_file_name = $upload_result['file_name'];
                }
            } else {
                $upload_error = 'Berkas Proposal dalam format PDF wajib diunggah.';
            }

            if ($this->form_validation->run() == TRUE && empty($upload_error)) {
                $insert_data = [
                    'user_id'             => $student_id,
                    'nama_program'        => $this->input->post('nama_program', TRUE),
                    'divisi'              => $this->input->post('divisi', TRUE),
                    'pic'                 => $this->input->post('pic', TRUE),
                    'tanggal_pelaksanaan' => $this->input->post('tanggal_pelaksanaan', TRUE),
                    'lokasi'              => $this->input->post('lokasi', TRUE),
                    'projek_brief'        => $this->input->post('projek_brief', TRUE),
                    'proposal_file'       => $pdf_file_name,
                    'catatan'             => $this->input->post('catatan', TRUE),
                    'status'              => 'Submit'
                ];

                $this->Pengajuan_proposal_model->insert($insert_data);
                $this->session->set_flashdata('success', 'Pengajuan proposal berhasil dikirimkan!');
                redirect('pengajuan-proposal');
                return;
            } else {
                $data['upload_error'] = $upload_error;
            }
        }

        $data['title'] = 'Buat Pengajuan Proposal Baru | PR FICT';
        $data['active_menu'] = 'pengajuan_proposal';
        $data['divisions'] = $this->Division_model->get_all();
        $data['user'] = $user;

        $this->load->view('templates/header', $data);
        $this->load->view('frontend/pengajuan_proposal/form', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Edit proposal (e.g. if user is revising)
     */
    public function edit($id) {
        $student_id = $this->session->userdata('student_id');
        $proposal = $this->Pengajuan_proposal_model->get_by_id($id);

        if (!$proposal || $proposal->user_id != $student_id) {
            show_404();
            return;
        }

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('nama_program', 'Nama Program', 'required|trim');
            $this->form_validation->set_rules('divisi', 'Divisi', 'required|trim');
            $this->form_validation->set_rules('pic', 'PIC / Penanggung Jawab', 'required|trim');
            $this->form_validation->set_rules('tanggal_pelaksanaan', 'Tanggal Pelaksanaan', 'required|trim');
            $this->form_validation->set_rules('lokasi', 'Lokasi', 'required|trim');
            $this->form_validation->set_rules('projek_brief', 'Projek Brief', 'required|trim');

            $pdf_file_name = $proposal->proposal_file;
            $upload_error = NULL;

            if (!empty($_FILES['proposal_file']['name'])) {
                $upload_result = $this->_upload_pdf();
                if ($upload_result['status'] === false) {
                    $upload_error = $upload_result['error'];
                } else {
                    // Delete old PDF file if uploaded new
                    if ($pdf_file_name && file_exists('./uploads/proposal_files/' . $pdf_file_name)) {
                        @unlink('./uploads/proposal_files/' . $pdf_file_name);
                    }
                    $pdf_file_name = $upload_result['file_name'];
                }
            }

            if ($this->form_validation->run() == TRUE && empty($upload_error)) {
                $update_data = [
                    'nama_program'        => $this->input->post('nama_program', TRUE),
                    'divisi'              => $this->input->post('divisi', TRUE),
                    'pic'                 => $this->input->post('pic', TRUE),
                    'tanggal_pelaksanaan' => $this->input->post('tanggal_pelaksanaan', TRUE),
                    'lokasi'              => $this->input->post('lokasi', TRUE),
                    'projek_brief'        => $this->input->post('projek_brief', TRUE),
                    'proposal_file'       => $pdf_file_name,
                    'catatan'             => $this->input->post('catatan', TRUE),
                ];

                // If proposal was in 'Revisi', update status back to 'Submit' or 'Review'
                if ($proposal->status == 'Revisi') {
                    $update_data['status'] = 'Submit';
                }

                $this->Pengajuan_proposal_model->update($id, $update_data);
                $this->Pengajuan_proposal_model->add_history($id, isset($update_data['status']) ? $update_data['status'] : $proposal->status, 'Proposal diperbarui oleh mahasiswa', $proposal->pic);

                $this->session->set_flashdata('success', 'Pengajuan proposal berhasil diperbarui.');
                redirect('pengajuan-proposal');
                return;
            } else {
                $data['upload_error'] = $upload_error;
            }
        }

        $data['title'] = 'Edit Pengajuan Proposal | PR FICT';
        $data['active_menu'] = 'pengajuan_proposal';
        $data['proposal'] = $proposal;
        $data['divisions'] = $this->Division_model->get_all();

        $this->load->view('templates/header', $data);
        $this->load->view('frontend/pengajuan_proposal/form', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Delete user proposal
     */
    public function delete($id) {
        $student_id = $this->session->userdata('student_id');
        $proposal = $this->Pengajuan_proposal_model->get_by_id($id);

        if ($proposal && $proposal->user_id == $student_id) {
            $this->Pengajuan_proposal_model->delete($id);
            $this->session->set_flashdata('success', 'Pengajuan proposal berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Tidak dapat menghapus proposal.');
        }
        redirect('pengajuan-proposal');
    }

    /**
     * Generate summary PDF of the proposal submission
     */
    public function generate_pdf($id) {
        $student_id = $this->session->userdata('student_id');
        $proposal = $this->Pengajuan_proposal_model->get_by_id($id);

        if (!$proposal || $proposal->user_id != $student_id) {
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
