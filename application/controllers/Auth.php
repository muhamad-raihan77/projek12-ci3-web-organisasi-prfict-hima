<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Student_model');
    }

    /**
     * Account Registration Page & Submission
     */
    public function register() {
        if ($this->session->userdata('student_logged_in')) {
            redirect('dashboard');
        }

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('full_name', 'Nama Lengkap', 'required|trim|max_length[150]');
            $this->form_validation->set_rules('email', 'Email Kampus', 'required|trim|valid_email|callback_check_fict_email|callback_check_email_registered');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
            $this->form_validation->set_rules('password_confirm', 'Konfirmasi Password', 'required|matches[password]');

            $this->form_validation->set_message('required', '{field} wajib diisi.');
            $this->form_validation->set_message('valid_email', 'Format email tidak valid.');
            $this->form_validation->set_message('min_length', '{field} minimal {param} karakter.');
            $this->form_validation->set_message('matches', 'Konfirmasi password tidak cocok dengan password.');

            if ($this->form_validation->run() == TRUE) {
                $data = [
                    'full_name' => $this->input->post('full_name', TRUE),
                    'email' => strtolower($this->input->post('email', TRUE)),
                    'password' => $this->input->post('password')
                ];

                $user_id = $this->Student_model->register($data);

                if ($user_id) {
                    $this->session->set_flashdata('success', 'Pendaftaran akun berhasil! Silakan login untuk melanjutkan.');
                    redirect('auth/login');
                } else {
                    $this->session->set_flashdata('error', 'Gagal mendaftar akun. Silakan coba lagi.');
                }
            }
        }

        $data['title'] = 'Daftar Akun Mahasiswa FICT | PR FICT 2026';
        $this->load->view('templates/header', $data);
        $this->load->view('frontend/register', $data);
        $this->load->view('templates/footer');
    }

    /**
     * User Login Page & Submission
     */
    public function login() {
        if ($this->session->userdata('student_logged_in')) {
            redirect('dashboard');
        }

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('email', 'Email Kampus', 'required|trim|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'required');

            $this->form_validation->set_message('required', '{field} wajib diisi.');
            $this->form_validation->set_message('valid_email', 'Format email tidak valid.');

            if ($this->form_validation->run() == TRUE) {
                $email = strtolower($this->input->post('email', TRUE));
                $password = $this->input->post('password');

                // FICT Email check first
                if (!$this->Student_model->is_valid_fict_email($email)) {
                    $this->session->set_flashdata('error', 'Hanya mahasiswa Fakultas FICT (email resmi fict@krw.horizon.ac.id) yang dapat login.');
                } else {
                    $user = $this->Student_model->get_by_email($email);

                    if (!$user) {
                        $this->session->set_flashdata('error', 'Akun belum terdaftar. Silakan buat akun terlebih dahulu.');
                    } else if (!$this->Student_model->verify_password($password, $user->password)) {
                        $this->session->set_flashdata('error', 'Email kampus atau password salah.');
                    } else {
                        // Set Session
                        $session_data = [
                            'student_logged_in' => TRUE,
                            'student_id' => $user->id,
                            'student_name' => $user->full_name,
                            'student_email' => $user->email
                        ];
                        $this->session->set_userdata($session_data);

                        $this->session->set_flashdata('success', 'Selamat datang kembali, ' . htmlspecialchars($user->full_name) . '!');
                        
                        // Redirect to intended URL if exists, otherwise to dashboard
                        $intended_url = $this->session->userdata('intended_url');
                        if ($intended_url) {
                            $this->session->unset_userdata('intended_url');
                            redirect($intended_url);
                        } else {
                            redirect('dashboard');
                        }
                    }
                }
            }
        }

        $data['title'] = 'Login Mahasiswa FICT | PR FICT 2026';
        $this->load->view('templates/header', $data);
        $this->load->view('frontend/login', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Logout
     */
    public function logout() {
        $this->session->unset_userdata(['student_logged_in', 'student_id', 'student_name', 'student_email']);
        $this->session->set_flashdata('success', 'Anda telah berhasil logout.');
        redirect('auth/login');
    }

    /**
     * Callback: Check official FICT campus email domain
     */
    public function check_fict_email($email) {
        if (!$this->Student_model->is_valid_fict_email($email)) {
            $this->form_validation->set_message('check_fict_email', 'Pendaftaran hanya diperuntukkan bagi mahasiswa Fakultas FICT yang menggunakan email resmi kampus.');
            return FALSE;
        }
        return TRUE;
    }

    /**
     * Callback: Check if email is already registered in student_users
     */
    public function check_email_registered($email) {
        if ($this->Student_model->email_exists($email)) {
            $this->form_validation->set_message('check_email_registered', 'Email sudah terdaftar. Silakan login ke akun Anda.');
            return FALSE;
        }
        return TRUE;
    }
}
