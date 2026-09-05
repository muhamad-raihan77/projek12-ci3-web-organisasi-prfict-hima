<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Get admin by email
     */
    public function get_by_email($email) {
        return $this->db->get_where('users_admin', ['email' => $email])->row();
    }

    /**
     * Verify login credentials
     */
    public function login($email, $password) {
        $admin = $this->get_by_email($email);
        if ($admin && password_verify($password, $admin->password)) {
            return $admin;
        }
        return false;
    }

    /**
     * Get admin by ID
     */
    public function get_by_id($id) {
        return $this->db->get_where('users_admin', ['id' => $id])->row();
    }
}
