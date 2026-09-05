<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Validate official FICT campus email domain
     * Accepted format: *.fict@krw.horizon.ac.id
     */
    public function is_valid_fict_email($email) {
        $email = strtolower(trim($email));
        // Check if string ends with fict@krw.horizon.ac.id
        return (bool) preg_match('/^[a-zA-Z0-9._%+-]+\.fict@krw\.horizon\.ac\.id$/i', $email) 
            || (bool) preg_match('/^[a-zA-Z0-9._%+-]+fict@krw\.horizon\.ac\.id$/i', $email);
    }

    /**
     * Register new student user
     */
    public function register($data) {
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->insert('student_users', $data);
        return $this->db->insert_id();
    }

    /**
     * Get student user by ID
     */
    public function get_by_id($id) {
        return $this->db->where('id', $id)->get('student_users')->row();
    }

    /**
     * Get student user by email
     */
    public function get_by_email($email) {
        return $this->db->where('email', trim($email))->get('student_users')->row();
    }

    /**
     * Check if email already registered
     */
    public function email_exists($email) {
        return $this->db->where('email', trim($email))->count_all_results('student_users') > 0;
    }

    /**
     * Check if NIM already used by another student
     */
    public function nim_exists($nim, $exclude_user_id = null) {
        $this->db->where('nim', trim($nim));
        if ($exclude_user_id) {
            $this->db->where('id !=', $exclude_user_id);
        }
        return $this->db->count_all_results('student_users') > 0;
    }

    /**
     * Update student biodata
     */
    public function update($id, $data) {
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db->where('id', $id)->update('student_users', $data);
    }

    /**
     * Check if student biodata is complete
     */
    public function is_biodata_complete($user) {
        if (!$user) return false;

        $required_fields = [
            'photo',
            'nim',
            'full_name',
            'birth_place',
            'birth_date',
            'gender',
            'phone',
            'study_program',
            'class_name',
            'address'
        ];

        foreach ($required_fields as $field) {
            if (empty($user->$field)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Verify password
     */
    public function verify_password($plain_password, $hashed_password) {
        return password_verify($plain_password, $hashed_password);
    }
}
