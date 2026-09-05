<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Program_kerja_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Get all program kerja with documentation list attached
     */
    public function get_all() {
        $programs = $this->db->order_by('created_at', 'DESC')->get('program_kerja')->result();
        foreach ($programs as &$p) {
            $p->dokumentasi = $this->get_dokumentasi($p->id);
        }
        return $programs;
    }

    /**
     * Get single program kerja by ID
     */
    public function get_by_id($id) {
        $program = $this->db->get_where('program_kerja', ['id' => $id])->row();
        if ($program) {
            $program->dokumentasi = $this->get_dokumentasi($program->id);
        }
        return $program;
    }

    /**
     * Insert new program kerja
     */
    public function insert($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->insert('program_kerja', $data);
        return $this->db->insert_id();
    }

    /**
     * Update program kerja
     */
    public function update($id, $data) {
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db->where('id', $id)->update('program_kerja', $data);
    }

    /**
     * Delete program kerja
     */
    public function delete($id) {
        // Delete documentation files from storage first
        $docs = $this->get_dokumentasi($id);
        foreach ($docs as $d) {
            $file_path = './uploads/program_dokumentasi/' . $d->file_name;
            if (file_exists($file_path)) {
                @unlink($file_path);
            }
        }
        return $this->db->where('id', $id)->delete('program_kerja');
    }

    /**
     * Get documentation list by program_kerja_id
     */
    public function get_dokumentasi($program_kerja_id) {
        return $this->db->where('program_kerja_id', $program_kerja_id)->order_by('uploaded_at', 'DESC')->get('program_dokumentasi')->result();
    }

    /**
     * Get single documentation by ID
     */
    public function get_dokumentasi_by_id($id) {
        return $this->db->get_where('program_dokumentasi', ['id' => $id])->row();
    }

    /**
     * Insert documentation image
     */
    public function insert_dokumentasi($data) {
        $data['uploaded_at'] = date('Y-m-d H:i:s');
        $this->db->insert('program_dokumentasi', $data);
        return $this->db->insert_id();
    }

    /**
     * Delete documentation image by ID
     */
    public function delete_dokumentasi($id) {
        $doc = $this->get_dokumentasi_by_id($id);
        if ($doc) {
            $file_path = './uploads/program_dokumentasi/' . $doc->file_name;
            if (file_exists($file_path)) {
                @unlink($file_path);
            }
            return $this->db->where('id', $id)->delete('program_dokumentasi');
        }
        return false;
    }

    /**
     * Get statistics for admin dashboard
     */
    public function get_stats() {
        $total = $this->db->count_all('program_kerja');
        $berjalan = $this->db->where('status', 'Berjalan')->count_all_results('program_kerja');
        $selesai = $this->db->where('status', 'Selesai')->count_all_results('program_kerja');
        $belum_dimulai = $this->db->where('status', 'Belum Dimulai')->count_all_results('program_kerja');

        return (object) [
            'total' => $total,
            'berjalan' => $berjalan,
            'selesai' => $selesai,
            'belum_dimulai' => $belum_dimulai
        ];
    }
}
