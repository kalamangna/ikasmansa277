<?php
class Page_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this -> load -> database();        
    }

    public function get_page_by_slug($slug) {
    return $this->db->get_where('pages', ['slug' => $slug])->row_array();
    }
    public function get_pages() {
        return $this->db->get('pages')->result_array();
    }

    public function get_page($id) {
        return $this->db->get_where('pages', ['id' => $id])->row_array();
    }

    public function insert_page($data) {
        return $this->db->insert('pages', $data);
    }

    public function update_page($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('pages', $data);
    }

    public function delete_page($id) {
        $this->db->where('id', $id);
        return $this->db->delete('pages');
    }    
}


