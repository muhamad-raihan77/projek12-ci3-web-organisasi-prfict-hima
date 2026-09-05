<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProgramKerja extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Program_kerja_model');
        $this->load->model('Division_model');
    }

    public function index() {
        $data['title'] = 'Program Kerja | PR FICT Horizon University';
        $data['active_menu'] = 'program_kerja';
        $data['programs'] = $this->Program_kerja_model->get_all();
        $data['divisions'] = $this->Division_model->get_all();
        $data['stats'] = $this->Program_kerja_model->get_stats();

        $this->load->view('templates/header', $data);
        $this->load->view('frontend/program_kerja', $data);
        $this->load->view('templates/footer');
    }
}
