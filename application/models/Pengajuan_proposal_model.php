<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengajuan_proposal_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Get all proposal submissions (Admin view) with student details if available
     */
    public function get_all() {
        $this->db->select('pengajuan_pelaksanaan.*, student_users.full_name as student_name, student_users.email as student_email');
        $this->db->from('pengajuan_pelaksanaan');
        $this->db->join('student_users', 'student_users.id = pengajuan_pelaksanaan.user_id', 'left');
        $this->db->order_by('pengajuan_pelaksanaan.created_at', 'DESC');
        return $this->db->get()->result();
    }

    /**
     * Get proposal submission by ID
     */
    public function get_by_id($id) {
        $this->db->select('pengajuan_pelaksanaan.*, student_users.full_name as student_name, student_users.email as student_email');
        $this->db->from('pengajuan_pelaksanaan');
        $this->db->join('student_users', 'student_users.id = pengajuan_pelaksanaan.user_id', 'left');
        $this->db->where('pengajuan_pelaksanaan.id', $id);
        return $this->db->get()->row();
    }

    /**
     * Get proposal submissions by user_id
     */
    public function get_by_user_id($user_id) {
        return $this->db->where('user_id', $user_id)
                        ->order_by('created_at', 'DESC')
                        ->get('pengajuan_pelaksanaan')
                        ->result();
    }

    /**
     * Insert new proposal submission
     */
    public function insert($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->insert('pengajuan_pelaksanaan', $data);
        $insert_id = $this->db->insert_id();

        // Add history log
        $this->add_history($insert_id, isset($data['status']) ? $data['status'] : 'Submit', 'Pengajuan proposal dibuat', isset($data['pic']) ? $data['pic'] : 'Pemohon');

        return $insert_id;
    }

    /**
     * Update proposal submission
     */
    public function update($id, $data) {
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db->where('id', $id)->update('pengajuan_pelaksanaan', $data);
    }

    /**
     * Update proposal status with catatan revisi
     */
    public function update_status($id, $status, $catatan_revisi = null, $changed_by = 'Admin') {
        $update_data = [
            'status' => $status,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        if ($catatan_revisi !== null) {
            $update_data['catatan_revisi'] = $catatan_revisi;
        }

        $result = $this->db->where('id', $id)->update('pengajuan_pelaksanaan', $update_data);
        if ($result) {
            $this->add_history($id, $status, $catatan_revisi, $changed_by);
        }
        return $result;
    }

    /**
     * Delete proposal submission
     */
    public function delete($id) {
        $proposal = $this->get_by_id($id);
        if ($proposal) {
            if ($proposal->proposal_file) {
                $file_path = './uploads/proposal_files/' . $proposal->proposal_file;
                if (file_exists($file_path)) {
                    @unlink($file_path);
                }
            }
            return $this->db->where('id', $id)->delete('pengajuan_pelaksanaan');
        }
        return false;
    }

    /**
     * Add log history for approval / status changes
     */
    public function add_history($pengajuan_id, $status, $catatan = null, $changed_by = 'Admin') {
        return $this->db->insert('approval_history', [
            'pengajuan_id' => $pengajuan_id,
            'status'       => $status,
            'catatan'      => $catatan,
            'changed_by'   => $changed_by,
            'created_at'   => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Get approval history for a proposal
     */
    public function get_history($pengajuan_id) {
        return $this->db->where('pengajuan_id', $pengajuan_id)
                        ->order_by('created_at', 'DESC')
                        ->get('approval_history')
                        ->result();
    }

    /**
     * Get proposal statistics
     */
    public function get_stats() {
        $total = $this->db->count_all('pengajuan_pelaksanaan');
        $submit = $this->db->where('status', 'Submit')->count_all_results('pengajuan_pelaksanaan');
        $review = $this->db->where('status', 'Review')->count_all_results('pengajuan_pelaksanaan');
        $revisi = $this->db->where('status', 'Revisi')->count_all_results('pengajuan_pelaksanaan');
        $approve = $this->db->where('status', 'Approve')->count_all_results('pengajuan_pelaksanaan');
        $ditolak = $this->db->where('status', 'Ditolak')->count_all_results('pengajuan_pelaksanaan');

        return (object) [
            'total' => $total,
            'submit' => $submit,
            'review' => $review,
            'revisi' => $revisi,
            'approve' => $approve,
            'ditolak' => $ditolak
        ];
    }
}
