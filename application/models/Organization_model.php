<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Organization_model extends CI_Model {

    private $table = 'organization_members';

    public function __construct() {
        parent::__construct();
    }

    /**
     * Get all active members ordered by display_order
     */
    public function get_active() {
        return $this->db->where('is_active', 1)
                        ->order_by('display_order', 'ASC')
                        ->get($this->table)
                        ->result();
    }

    /**
     * Get all members (active & inactive)
     */
    public function get_all() {
        return $this->db->order_by('display_order', 'ASC')
                        ->get($this->table)
                        ->result();
    }

    /**
     * Get member by ID
     */
    public function get_by_id($id) {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }

    /**
     * Insert new member
     */
    public function insert($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    /**
     * Update member
     */
    public function update($id, $data) {
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    /**
     * Delete member
     */
    public function delete($id) {
        return $this->db->where('id', $id)->delete($this->table);
    }

    /**
     * Toggle active status
     */
    public function toggle_active($id) {
        $member = $this->get_by_id($id);
        if ($member) {
            $new_status = $member->is_active ? 0 : 1;
            return $this->update($id, ['is_active' => $new_status]);
        }
        return false;
    }

    /**
     * Count active members
     */
    public function count_active() {
        return $this->db->where('is_active', 1)->count_all_results($this->table);
    }

    /**
     * Get next display order
     */
    public function get_next_order() {
        $max = $this->db->select_max('display_order')->get($this->table)->row();
        return ($max && $max->display_order) ? $max->display_order + 1 : 1;
    }
}
