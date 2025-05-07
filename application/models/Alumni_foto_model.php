<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alumni_foto_model extends CI_Model {
    public function insert($data)
    {
        return $this->db->insert('alumni_foto', $data);
    }

    public function get_foto_by_alumni($id_alumni)
    {
        return $this->db->get_where('alumni_foto', ['id_alumni' => $id_alumni])->result();
    }
}

