<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Admin_model');
    }

    /**
     * Login page
     */
    public function login() {
        if ($this->session->userdata('admin_logged_in')) {
            redirect('admin/dashboard');
        }
        
        $data['title'] = 'Admin Login | PR FICT';
        $this->load->view('admin/login', $data);
    }

    /**
     * Process login
     */
    public function process() {
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Admin Login | PR FICT';
            $this->load->view('admin/login', $data);
            return;
        }

        $email = $this->input->post('email', TRUE);
        $password = $this->input->post('password');

        $admin = $this->Admin_model->login($email, $password);

        if ($admin) {
            $session_data = [
                'admin_id' => $admin->id,
                'admin_name' => $admin->name,
                'admin_email' => $admin->email,
                'admin_logged_in' => TRUE
            ];
            $this->session->set_userdata($session_data);
            redirect('admin/dashboard');
        } else {
            $this->session->set_flashdata('error', 'Email atau password salah.');
            redirect('admin/login');
        }
    }

    /**
     * Logout
     */
    public function logout() {
        $this->session->unset_userdata(['admin_id', 'admin_name', 'admin_email', 'admin_logged_in']);
        $this->session->sess_destroy();
        redirect('admin/login');
    }
}
