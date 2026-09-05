<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registration extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Applicant_model');
        $this->load->model('Division_model');
        $this->load->model('Student_model');
        $this->load->library('upload');
    }

    /**
     * Check access prerequisites (Login, Complete Biodata, No existing application)
     */
    private function _check_access() {
        if (!$this->session->userdata('student_logged_in')) {
            $this->session->set_userdata('intended_url', 'pendaftaran');
            $this->session->set_flashdata('error', 'Silakan mendaftar akun dan login terlebih dahulu untuk mendaftar organisasi.');
            redirect('auth/login');
        }

        $student_id = $this->session->userdata('student_id');
        $user = $this->Student_model->get_by_id($student_id);

        if (!$user) {
            $this->session->unset_userdata(['student_logged_in', 'student_id', 'student_name', 'student_email']);
            redirect('auth/login');
        }

        if (!$this->Student_model->is_biodata_complete($user)) {
            $this->session->set_flashdata('error', 'Silakan lengkapi biodata terlebih dahulu sebelum melakukan pendaftaran organisasi.');
            redirect('dashboard');
        }

        if ($this->Applicant_model->has_applied($user->id, $user->email, $user->nim)) {
            $this->session->set_flashdata('error', 'Anda sudah pernah mengirim pendaftaran organisasi. Pendaftaran hanya dapat dilakukan satu kali.');
            redirect('dashboard');
        }

        return $user;
    }

    /**
     * Registration form page
     */
    public function index() {
        $user = $this->_check_access();

        $data['title'] = 'Form Pendaftaran Organisasi | Open Recruitment PR FICT 2026';
        $data['divisions'] = $this->Division_model->get_active();
        $data['user'] = $user;

        $this->load->view('templates/header', $data);
        $this->load->view('frontend/registration', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Process registration form submission
     */
    public function submit() {
        $user = $this->_check_access();

        // Form Validation for fields that are user-editable during registration
        $this->form_validation->set_rules('semester', 'Semester', 'required|numeric|greater_than[0]|less_than[15]');
        $this->form_validation->set_rules('division_id', 'Pilihan Divisi', 'required|numeric');
        $this->form_validation->set_rules('reason', 'Alasan Bergabung', 'required|trim|min_length[20]');
        $this->form_validation->set_rules('agreement', 'Persetujuan', 'required');

        $this->form_validation->set_message('required', '{field} wajib diisi.');
        $this->form_validation->set_message('min_length', '{field} minimal {param} karakter.');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Form Pendaftaran Organisasi | Open Recruitment PR FICT 2026';
            $data['divisions'] = $this->Division_model->get_active();
            $data['user'] = $user;

            $this->load->view('templates/header', $data);
            $this->load->view('frontend/registration', $data);
            $this->load->view('templates/footer');
            return;
        }

        // Handle optional CV upload
        $cv_name = null;
        if (!empty($_FILES['cv']['name'])) {
            $cv_name = $this->_upload_cv();
            if ($cv_name === false) {
                $data['title'] = 'Form Pendaftaran Organisasi | Open Recruitment PR FICT 2026';
                $data['divisions'] = $this->Division_model->get_active();
                $data['user'] = $user;
                $data['upload_error'] = $this->upload->display_errors('', '');

                $this->load->view('templates/header', $data);
                $this->load->view('frontend/registration', $data);
                $this->load->view('templates/footer');
                return;
            }
        }

        // Prepare data from student biodata + form choices
        $applicant_data = [
            'user_id' => $user->id,
            'full_name' => $user->full_name,
            'nim' => $user->nim,
            'study_program' => $user->study_program,
            'semester' => $this->input->post('semester', TRUE),
            'gender' => $user->gender,
            'email' => $user->email,
            'whatsapp' => $user->phone,
            'division_id' => $this->input->post('division_id', TRUE),
            'reason' => $this->input->post('reason', TRUE),
            'organization_experience' => $user->organization_experience,
            'skills' => $this->input->post('skills', TRUE) ?: $user->achievements,
            'photo' => $user->photo,
            'cv' => $cv_name,
            'status' => 'Menunggu'
        ];

        // Insert to database
        $reg_code = $this->Applicant_model->insert($applicant_data);

        if ($reg_code) {
            $this->session->set_flashdata('success', 'Pendaftaran organisasi Anda berhasil dikirim! Menunggu verifikasi admin.');
            redirect('pendaftaran/berhasil/' . $reg_code);
        } else {
            $this->session->set_flashdata('error', 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.');
            redirect('pendaftaran');
        }
    }

    /**
     * Registration success page
     */
    public function success($code) {
        if (!$this->session->userdata('student_logged_in')) {
            redirect('auth/login');
        }

        $data['applicant'] = $this->Applicant_model->get_by_code($code);

        if (!$data['applicant']) {
            show_404();
        }

        $data['title'] = 'Pendaftaran Berhasil | PR FICT 2026';

        $this->load->view('templates/header', $data);
        $this->load->view('frontend/registration_success', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Generate PDF
     */
    public function generate_pdf($code) {
        if (!$this->session->userdata('student_logged_in')) {
            redirect('auth/login');
        }

        $applicant = $this->Applicant_model->get_by_code($code);

        if (!$applicant) {
            show_404();
        }

        $data['applicant'] = $applicant;
        $html = $this->load->view('frontend/pdf_template', $data, TRUE);

        $this->load->library('Pdf_generator');
        $this->pdf_generator->generate($html, 'Bukti_Pendaftaran_' . $code . '.pdf');
    }

    /**
     * Upload CV helper
     */
    private function _upload_cv() {
        $config['upload_path'] = './uploads/cv/';
        $config['allowed_types'] = 'pdf';
        $config['max_size'] = 5120; // 5MB
        $config['encrypt_name'] = TRUE;

        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0755, TRUE);
        }

        $this->upload->initialize($config);

        if ($this->upload->do_upload('cv')) {
            return $this->upload->data('file_name');
        }
        return false;
    }
}
