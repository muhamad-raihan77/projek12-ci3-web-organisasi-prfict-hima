<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Student_model');
        $this->load->model('Applicant_model');
        $this->load->library('upload');

        // Check if student is logged in
        if (!$this->session->userdata('student_logged_in')) {
            $this->session->set_flashdata('error', 'Silakan login terlebih dahulu untuk mengakses dashboard.');
            redirect('auth/login');
        }
    }

    /**
     * User Dashboard
     */
    public function dashboard() {
        $student_id = $this->session->userdata('student_id');
        $user = $this->Student_model->get_by_id($student_id);

        if (!$user) {
            $this->session->unset_userdata(['student_logged_in', 'student_id', 'student_name', 'student_email']);
            redirect('auth/login');
        }

        $is_complete = $this->Student_model->is_biodata_complete($user);
        $applicant = $this->Applicant_model->get_by_user_id($student_id);

        // Fallback check by email if not linked by user_id
        if (!$applicant && $user->email) {
            $applicant = $this->Applicant_model->get_by_email($user->email);
        }

        $data['title'] = 'Dashboard Calon Anggota | PR FICT 2026';
        $data['user'] = $user;
        $data['is_complete'] = $is_complete;
        $data['applicant'] = $applicant;

        $this->load->view('templates/header', $data);
        $this->load->view('frontend/dashboard', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Edit / Complete Biodata Form & Submission
     */
    public function biodata() {
        $student_id = $this->session->userdata('student_id');
        $user = $this->Student_model->get_by_id($student_id);

        if (!$user) {
            redirect('auth/login');
        }

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('full_name', 'Nama Lengkap', 'required|trim|max_length[150]');
            $this->form_validation->set_rules('nim', 'NIM', 'required|trim|max_length[20]|callback_check_nim_unique');
            $this->form_validation->set_rules('birth_place', 'Tempat Lahir', 'required|trim');
            $this->form_validation->set_rules('birth_date', 'Tanggal Lahir', 'required|trim');
            $this->form_validation->set_rules('gender', 'Jenis Kelamin', 'required|in_list[Laki-laki,Perempuan]');
            $this->form_validation->set_rules('phone', 'Nomor HP/WhatsApp', 'required|trim|min_length[10]|max_length[15]');
            $this->form_validation->set_rules('study_program', 'Program Studi', 'required|trim');
            $this->form_validation->set_rules('class_name', 'Kelas', 'required|trim');
            $this->form_validation->set_rules('address', 'Alamat Lengkap', 'required|trim');

            $this->form_validation->set_message('required', '{field} wajib diisi.');
            $this->form_validation->set_message('min_length', '{field} minimal {param} karakter.');
            $this->form_validation->set_message('max_length', '{field} maksimal {param} karakter.');

            $photo_name = $user->photo;

            // Handle photo upload
            if (!empty($_FILES['photo']['name'])) {
                $uploaded_photo = $this->_upload_photo();
                if ($uploaded_photo === false) {
                    $data['upload_error'] = $this->upload->display_errors('', '');
                } else {
                    // Delete old photo if exists
                    if ($photo_name && file_exists('./uploads/photos/' . $photo_name)) {
                        unlink('./uploads/photos/' . $photo_name);
                    }
                    $photo_name = $uploaded_photo;
                }
            }

            if ($this->form_validation->run() == TRUE && empty($data['upload_error'])) {
                // If photo is missing and user has no existing photo
                if (empty($photo_name)) {
                    $data['upload_error'] = 'Foto Profil wajib diunggah.';
                } else {
                    $update_data = [
                        'full_name' => $this->input->post('full_name', TRUE),
                        'nim' => $this->input->post('nim', TRUE),
                        'birth_place' => $this->input->post('birth_place', TRUE),
                        'birth_date' => $this->input->post('birth_date', TRUE),
                        'gender' => $this->input->post('gender', TRUE),
                        'phone' => $this->input->post('phone', TRUE),
                        'study_program' => $this->input->post('study_program', TRUE),
                        'class_name' => $this->input->post('class_name', TRUE),
                        'address' => $this->input->post('address', TRUE),
                        'organization_experience' => $this->input->post('organization_experience', TRUE),
                        'achievements' => $this->input->post('achievements', TRUE),
                        'photo' => $photo_name
                    ];

                    $this->Student_model->update($student_id, $update_data);
                    
                    // Update session name if changed
                    $this->session->set_userdata('student_name', $update_data['full_name']);

                    $this->session->set_flashdata('success', 'Biodata berhasil diperbarui.');
                    redirect('dashboard');
                }
            }
        }

        $data['title'] = 'Lengkapi Biodata | PR FICT 2026';
        $data['user'] = $user;
        $data['is_complete'] = $this->Student_model->is_biodata_complete($user);

        $this->load->view('templates/header', $data);
        $this->load->view('frontend/biodata', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Upload photo helper
     */
    private function _upload_photo() {
        $config['upload_path'] = './uploads/photos/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size'] = 2048; // 2MB
        $config['encrypt_name'] = TRUE;

        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0755, TRUE);
        }

        $this->upload->initialize($config);

        if ($this->upload->do_upload('photo')) {
            return $this->upload->data('file_name');
        }
        return false;
    }

    /**
     * Callback: Check if NIM is unique among students
     */
    public function check_nim_unique($nim) {
        $student_id = $this->session->userdata('student_id');
        if ($this->Student_model->nim_exists($nim, $student_id)) {
            $this->form_validation->set_message('check_nim_unique', 'NIM sudah terdaftar pada akun lain.');
            return FALSE;
        }
        return TRUE;
    }
}
