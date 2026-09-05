<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Division_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Get all divisions
     */
    public function get_all() {
        return $this->db->order_by('name', 'ASC')->get('divisions')->result();
    }

    /**
     * Get active divisions only
     */
    public function get_active() {
        return $this->db->where('is_active', 1)->order_by('name', 'ASC')->get('divisions')->result();
    }

    /**
     * Get division by ID
     */
    public function get_by_id($id) {
        return $this->db->get_where('divisions', ['id' => $id])->row();
    }

    /**
     * Insert new division
     */
    public function insert($data) {
        $this->db->insert('divisions', $data);
        return $this->db->insert_id();
    }

    /**
     * Update division
     */
    public function update($id, $data) {
        return $this->db->where('id', $id)->update('divisions', $data);
    }

    /**
     * Delete division
     */
    public function delete($id) {
        return $this->db->where('id', $id)->delete('divisions');
    }

    /**
     * Toggle division active status
     */
    public function toggle_active($id) {
        $division = $this->get_by_id($id);
        if ($division) {
            $new_status = $division->is_active ? 0 : 1;
            return $this->update($id, ['is_active' => $new_status]);
        }
        return false;
    }

    /**
     * Count applicants per division
     */
    public function count_per_division() {
        $this->db->select('divisions.name, COUNT(applicants.id) as total');
        $this->db->from('divisions');
        $this->db->join('applicants', 'applicants.division_id = divisions.id', 'left');
        $this->db->where('divisions.is_active', 1);
        $this->db->group_by('divisions.id');
        $this->db->order_by('divisions.name', 'ASC');
        return $this->db->get()->result();
    }

    /**
     * Check if division has applicants
     */
    public function has_applicants($id) {
        return $this->db->where('division_id', $id)->count_all_results('applicants') > 0;
    }
}
