<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Applicants extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Applicant_model');
        $this->load->model('Division_model');
        $this->load->library('pagination');
        
        if (!$this->session->userdata('admin_logged_in')) {
            redirect('admin/login');
        }
    }

    /**
     * List all applicants with filters
     */
    public function index() {
        $data['title'] = 'Data Pendaftar | Admin PR FICT';
        $data['active_menu'] = 'applicants';
        
        // Filters
        $filters = [
            'search' => $this->input->get('search'),
            'division_id' => $this->input->get('division_id'),
            'status' => $this->input->get('status'),
            'date_from' => $this->input->get('date_from'),
            'date_to' => $this->input->get('date_to'),
        ];
        
        $data['filters'] = $filters;
        $data['divisions'] = $this->Division_model->get_all();
        
        // Pagination
        $per_page = 10;
        $page = max(1, (int) $this->input->get('page'));
        $offset = ($page - 1) * $per_page;
        
        $data['applicants'] = $this->Applicant_model->get_all($filters, $per_page, $offset);
        $data['total'] = $this->Applicant_model->count_all($filters);
        $data['per_page'] = $per_page;
        $data['current_page'] = $page;
        $data['total_pages'] = ceil($data['total'] / $per_page);
        
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/applicants', $data);
        $this->load->view('admin/templates/footer');
    }

    /**
     * View applicant detail
     */
    public function detail($id) {
        $data['applicant'] = $this->Applicant_model->get_by_id($id);
        
        if (!$data['applicant']) {
            show_404();
        }
        
        $data['title'] = 'Detail Pendaftar | Admin PR FICT';
        $data['active_menu'] = 'applicants';
        
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/applicant_detail', $data);
        $this->load->view('admin/templates/footer');
    }

    /**
     * Update applicant status
     */
    public function update_status() {
        $id = $this->input->post('applicant_id');
        $status = $this->input->post('status');
        
        $valid_statuses = ['Menunggu', 'Seleksi Administrasi', 'Interview', 'Lolos', 'Tidak Lolos'];
        
        if (!in_array($status, $valid_statuses)) {
            $this->session->set_flashdata('error', 'Status tidak valid.');
            redirect('admin/pendaftar');
            return;
        }
        
        if ($this->Applicant_model->update_status($id, $status)) {
            $this->session->set_flashdata('success', 'Status berhasil diperbarui.');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui status.');
        }
        
        redirect('admin/pendaftar/detail/' . $id);
    }

    /**
     * Delete applicant
     */
    public function delete($id) {
        if ($this->Applicant_model->delete($id)) {
            $this->session->set_flashdata('success', 'Data pendaftar berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data pendaftar.');
        }
        redirect('admin/pendaftar');
    }

    /**
     * Generate PDF for applicant
     */
    public function generate_pdf($id) {
        $applicant = $this->Applicant_model->get_by_id($id);
        
        if (!$applicant) {
            show_404();
        }

        $data['applicant'] = $applicant;
        $html = $this->load->view('frontend/pdf_template', $data, TRUE);
        
        $this->load->library('Pdf_generator');
        $this->pdf_generator->generate($html, 'Bukti_Pendaftaran_' . $applicant->registration_code . '.pdf');
    }

    /**
     * Export page
     */
    public function export() {
        $data['title'] = 'Export Data | Admin PR FICT';
        $data['active_menu'] = 'export';
        $data['divisions'] = $this->Division_model->get_all();
        
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/export', $data);
        $this->load->view('admin/templates/footer');
    }

    /**
     * Export to CSV
     */
    public function export_csv() {
        $filters = [
            'division_id' => $this->input->get('division_id'),
            'status' => $this->input->get('status'),
        ];
        
        $applicants = $this->Applicant_model->get_for_export($filters);
        
        $filename = 'Data_Pendaftar_PRFICT_' . date('Y-m-d_H-i-s') . '.csv';
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $output = fopen('php://output', 'w');
        
        // BOM for Excel UTF-8
        fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));
        
        // Header row
        fputcsv($output, [
            'No', 'Kode Pendaftaran', 'Nama Lengkap', 'NIM', 'Program Studi',
            'Semester', 'Jenis Kelamin', 'Email', 'WhatsApp', 'Divisi',
            'Alasan Bergabung', 'Pengalaman Organisasi', 'Keahlian',
            'Status', 'Tanggal Daftar'
        ]);
        
        $no = 1;
        foreach ($applicants as $a) {
            fputcsv($output, [
                $no++,
                $a->registration_code,
                $a->full_name,
                $a->nim,
                $a->study_program,
                $a->semester,
                $a->gender,
                $a->email,
                $a->whatsapp,
                $a->division_name,
                $a->reason,
                $a->organization_experience,
                $a->skills,
                $a->status,
                date('d/m/Y H:i', strtotime($a->created_at))
            ]);
        }
        
        fclose($output);
        exit;
    }
}
