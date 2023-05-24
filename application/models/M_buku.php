<?php

class M_buku extends CI_Model
{
    public function getData($id = null)
    {
        if ($id === null) {
            return $this->db->query(
                "SELECT a.*,b.nama_kategori FROM book a LEFT JOIN kategori b ON a.kategori = b.id"
            )->result_array();
            // return $this->db->get('book')->result_array();
        } else {
            return $this->db->query(
                "SELECT a.*,b.nama_kategori FROM book a LEFT JOIN kategori b ON a.kategori = b.id WHERE a.id= '" . $id . "'"
            )->result_array();
            // return $this->db->get_where('book', ['id' => $id])->result_array();
        }
    }

    public function insert_data($data)
    {
        $this->db->insert('book', $data);
        return $this->db->affected_rows();
    }

    public function update_data($data, $id)
    {
        $this->db->update('book', $data, ['id' => $id]);
        return $this->db->affected_rows();
    }
}
