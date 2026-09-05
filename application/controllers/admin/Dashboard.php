<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Applicant_model');
        $this->load->model('Division_model');
        $this->load->model('Program_kerja_model');
        
        // Check admin login
        if (!$this->session->userdata('admin_logged_in')) {
            redirect('admin/login');
        }
    }

    public function index() {
        $data['title'] = 'Dashboard | Admin PR FICT';
        $data['active_menu'] = 'dashboard';
        $data['stats'] = $this->Applicant_model->get_stats();
        $data['division_stats'] = $this->Division_model->count_per_division();
        $data['recent'] = $this->Applicant_model->get_recent(5);
        $data['proker_stats'] = $this->Program_kerja_model->get_stats();
        
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/dashboard', $data);
        $this->load->view('admin/templates/footer');
    }
}
