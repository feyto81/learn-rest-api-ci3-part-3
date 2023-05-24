<?php

use chriskacerguis\RestServer\RestController;

class Buku extends RestController
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_buku', 'buku');
    }
    public function index_get()
    {
        $id = $this->get('id_buku');
        $data_buku = $this->buku->getData($id);
        if ($data_buku) {
            $this->response([
                'status' => true,
                'message' => 'Berhasil mendapatkan data',
                'result' => $data_buku
            ], self::HTTP_NOT_FOUND);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], self::HTTP_NOT_FOUND);
        }
    }

    public function index_post()
    {
        $this->form_validation->set_rules(
            'judul',
            'Judul buku',
            'required',
            array(
                'required' => '{field} wajib diisi'
            )
        );
        $this->form_validation->set_rules(
            'penulis',
            'Penulis buku',
            'required',
            array(
                'required' => '{field} wajib diisi'
            )
        );
        $this->form_validation->set_rules(
            'tahun',
            'Tahun terbit',
            'required|numeric',
            array(
                'required' => '{field} wajib diisi',
                'numeric' => '{field} harus angka',
            )
        );
        $this->form_validation->set_rules(
            'stok',
            'Stok buku',
            'required|numeric',
            array(
                'required' => '{field} wajib diisi',
                'numeric' => '{field} harus angka',
            )
        );
        $this->form_validation->set_rules(
            'harga_beli',
            'Harga beli',
            'required|numeric',
            array(
                'required' => '{field} wajib diisi',
                'numeric' => '{field} harus angka',
            )
        );
        $this->form_validation->set_rules(
            'harga_jual',
            'Harga jual',
            'required|numeric',
            array(
                'required' => '{field} wajib diisi',
                'numeric' => '{field} harus angka',
            )
        );

        $this->form_validation->set_rules(
            'penerbit',
            'Penerbit buku',
            'required',
            array(
                'required' => '{field} wajib diisi',
            )
        );
        if ($this->form_validation->run() === false) {
            $this->response([
                'status' => false,
                'message' => strip_tags(validation_errors()),
            ], self::HTTP_BAD_REQUEST);
        } else {
            $data = [
                'judul' => $this->post('judul'),
                'penulis' => $this->post('penulis'),
                'tahun' => $this->post('tahun'),
                'penerbit' => $this->post('penerbit'),
                'stok' => $this->post('stok'),
                'harga_beli' => $this->post('harga_beli'),
                'harga_jual' => $this->post('harga_jual'),
            ];

            $saved = $this->buku->insert_data($data);
            if ($saved > 0) {
                $this->response([
                    'status' => true,
                    'message' => 'Berhasil menambahkan dataH'
                ], self::HTTP_CREATED);
            } else {
                $this->response([
                    'status' => true,
                    'message' => 'Gagal menambahkan dataH'
                ], self::HTTP_BAD_REQUEST);
            }
        }
    }
}
