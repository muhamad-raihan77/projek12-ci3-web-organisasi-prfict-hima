<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Status extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Applicant_model');
    }

    /**
     * Check status page
     */
    public function index() {
        $data['title'] = 'Cek Status Pendaftaran | PR FICT 2026';
        $data['applicant'] = null;
        
        $this->load->view('templates/header', $data);
        $this->load->view('frontend/check_status', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Process status check
     */
    public function check() {
        $code = $this->input->post('registration_code', TRUE);
        
        if (empty($code)) {
            $this->session->set_flashdata('error', 'Masukkan kode pendaftaran.');
            redirect('cek-status');
            return;
        }

        $data['title'] = 'Status Pendaftaran | PR FICT 2026';
        $data['applicant'] = $this->Applicant_model->get_by_code($code);
        $data['searched'] = true;
        
        if (!$data['applicant']) {
            $data['not_found'] = true;
        }
        
        $this->load->view('templates/header', $data);
        $this->load->view('frontend/check_status', $data);
        $this->load->view('templates/footer');
    }
}
