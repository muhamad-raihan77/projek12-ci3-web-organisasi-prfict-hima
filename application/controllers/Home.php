<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Division_model');
        $this->load->model('Organization_model');
    }

    public function index() {
        $data['title'] = 'Open Recruitment PR FICT 2026 | Program Representative FICT';
        $data['divisions'] = $this->Division_model->get_active();
        $data['org_members'] = $this->Organization_model->get_active();
        
        $this->load->view('templates/header', $data);
        $this->load->view('frontend/home', $data);
        $this->load->view('templates/footer');
    }
}
