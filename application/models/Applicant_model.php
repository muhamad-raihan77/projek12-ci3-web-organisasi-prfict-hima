<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Applicant_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Generate unique registration code
     * Format: PRFICT-2026-0001
     */
    public function generate_registration_code() {
        $year = date('Y');
        $prefix = "PRFICT-{$year}-";
        
        $this->db->select_max('registration_code');
        $this->db->like('registration_code', $prefix, 'after');
        $result = $this->db->get('applicants')->row();
        
        if ($result && $result->registration_code) {
            $last_number = (int) substr($result->registration_code, -4);
            $new_number = $last_number + 1;
        } else {
            $new_number = 1;
        }
        
        return $prefix . str_pad($new_number, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Insert new applicant
     */
    public function insert($data) {
        $data['registration_code'] = $this->generate_registration_code();
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->insert('applicants', $data);
        return $data['registration_code'];
    }

    /**
     * Get applicant by registration code
     */
    public function get_by_code($code) {
        $this->db->select('applicants.*, divisions.name as division_name');
        $this->db->from('applicants');
        $this->db->join('divisions', 'divisions.id = applicants.division_id');
        $this->db->where('applicants.registration_code', $code);
        return $this->db->get()->row();
    }

    /**
     * Get applicant by ID
     */
    public function get_by_id($id) {
        $this->db->select('applicants.*, divisions.name as division_name');
        $this->db->from('applicants');
        $this->db->join('divisions', 'divisions.id = applicants.division_id');
        $this->db->where('applicants.id', $id);
        return $this->db->get()->row();
    }

    /**
     * Get applicant by user_id
     */
    public function get_by_user_id($user_id) {
        $this->db->select('applicants.*, divisions.name as division_name');
        $this->db->from('applicants');
        $this->db->join('divisions', 'divisions.id = applicants.division_id');
        $this->db->where('applicants.user_id', $user_id);
        return $this->db->get()->row();
    }

    /**
     * Get applicant by email
     */
    public function get_by_email($email) {
        $this->db->select('applicants.*, divisions.name as division_name');
        $this->db->from('applicants');
        $this->db->join('divisions', 'divisions.id = applicants.division_id');
        $this->db->where('applicants.email', $email);
        return $this->db->get()->row();
    }

    /**
     * Check if user has already submitted an application
     */
    public function has_applied($user_id = null, $email = null, $nim = null) {
        $this->db->from('applicants');
        $this->db->group_start();
        if ($user_id) {
            $this->db->where('user_id', $user_id);
        }
        if ($email) {
            $this->db->or_where('email', $email);
        }
        if ($nim) {
            $this->db->or_where('nim', $nim);
        }
        $this->db->group_end();
        return $this->db->count_all_results() > 0;
    }

    /**
     * Check if NIM already exists
     */
    public function nim_exists($nim) {
        return $this->db->where('nim', $nim)->count_all_results('applicants') > 0;
    }

    /**
     * Check if email already exists
     */
    public function email_exists($email) {
        return $this->db->where('email', $email)->count_all_results('applicants') > 0;
    }

    /**
     * Get all applicants with filters
     */
    public function get_all($filters = [], $limit = 10, $offset = 0) {
        $this->db->select('applicants.*, divisions.name as division_name');
        $this->db->from('applicants');
        $this->db->join('divisions', 'divisions.id = applicants.division_id');
        
        $this->_apply_filters($filters);
        
        $this->db->order_by('applicants.created_at', 'DESC');
        $this->db->limit($limit, $offset);
        return $this->db->get()->result();
    }

    /**
     * Count all applicants with filters
     */
    public function count_all($filters = []) {
        $this->db->from('applicants');
        $this->db->join('divisions', 'divisions.id = applicants.division_id');
        $this->_apply_filters($filters);
        return $this->db->count_all_results();
    }

    /**
     * Apply filters to query
     */
    private function _apply_filters($filters) {
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $this->db->group_start();
            $this->db->like('applicants.full_name', $search);
            $this->db->or_like('applicants.nim', $search);
            $this->db->or_like('applicants.registration_code', $search);
            $this->db->or_like('applicants.email', $search);
            $this->db->group_end();
        }
        
        if (!empty($filters['division_id'])) {
            $this->db->where('applicants.division_id', $filters['division_id']);
        }
        
        if (!empty($filters['status'])) {
            $this->db->where('applicants.status', $filters['status']);
        }
        
        if (!empty($filters['date_from'])) {
            $this->db->where('DATE(applicants.created_at) >=', $filters['date_from']);
        }
        
        if (!empty($filters['date_to'])) {
            $this->db->where('DATE(applicants.created_at) <=', $filters['date_to']);
        }
    }

    /**
     * Update applicant status
     */
    public function update_status($id, $status) {
        return $this->db->where('id', $id)->update('applicants', [
            'status' => $status,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Delete applicant
     */
    public function delete($id) {
        $applicant = $this->get_by_id($id);
        if ($applicant) {
            // Delete uploaded files
            if ($applicant->photo && file_exists('./uploads/photos/' . $applicant->photo)) {
                unlink('./uploads/photos/' . $applicant->photo);
            }
            if ($applicant->cv && file_exists('./uploads/cv/' . $applicant->cv)) {
                unlink('./uploads/cv/' . $applicant->cv);
            }
            return $this->db->where('id', $id)->delete('applicants');
        }
        return false;
    }

    /**
     * Dashboard Statistics
     */
    public function get_stats() {
        $stats = new stdClass();
        $stats->total = $this->db->count_all('applicants');
        $stats->today = $this->db->where('DATE(created_at)', date('Y-m-d'))->count_all_results('applicants');
        $stats->menunggu = $this->db->where('status', 'Menunggu')->count_all_results('applicants');
        $stats->seleksi = $this->db->where('status', 'Seleksi Administrasi')->count_all_results('applicants');
        $stats->interview = $this->db->where('status', 'Interview')->count_all_results('applicants');
        $stats->lolos = $this->db->where('status', 'Lolos')->count_all_results('applicants');
        $stats->tidak_lolos = $this->db->where('status', 'Tidak Lolos')->count_all_results('applicants');
        return $stats;
    }

    /**
     * Get recent applicants
     */
    public function get_recent($limit = 5) {
        $this->db->select('applicants.*, divisions.name as division_name');
        $this->db->from('applicants');
        $this->db->join('divisions', 'divisions.id = applicants.division_id');
        $this->db->order_by('applicants.created_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result();
    }

    /**
     * Get all applicants for export (no pagination)
     */
    public function get_for_export($filters = []) {
        $this->db->select('applicants.*, divisions.name as division_name');
        $this->db->from('applicants');
        $this->db->join('divisions', 'divisions.id = applicants.division_id');
        $this->_apply_filters($filters);
        $this->db->order_by('applicants.created_at', 'DESC');
        return $this->db->get()->result();
    }
}
