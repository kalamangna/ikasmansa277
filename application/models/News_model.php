<?php
class News_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }
    public function get_news_by_slug($slug) {
        return $this->db->get_where('news', ['slug' => $slug])->row_array();
    }
    public function get_news() {
        return $this->db->get('news')->result_array();
    }

    public function get_news_item($id) {
        return $this->db->get_where('news', ['id' => $id])->row_array();
    }

    public function insert_news($data) {
        return $this->db->insert('news', $data);
    }

    public function update_news($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('news', $data);
    }

    public function delete_news($id) {
        $this->db->where('id', $id);
        return $this->db->delete('news');
    }
}
