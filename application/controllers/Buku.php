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
        if ($this->_validationCheck() === false) {
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
                    'message' => 'Berhasil menambahkan data'
                ], self::HTTP_CREATED);
            } else {
                $this->response([
                    'status' => true,
                    'message' => 'Gagal menambahkan data'
                ], self::HTTP_BAD_REQUEST);
            }
        }
    }

    public function index_put()
    {
        $this->form_validation->set_data($this->put());

        if ($this->_validationCheck() === false) {
            $this->response([
                'status' => false,
                'message' => strip_tags(validation_errors()),
            ], self::HTTP_BAD_REQUEST);
        } else {
            $id = $this->put('id_buku');
            $data = [
                'judul' => $this->put('judul'),
                'penulis' => $this->put('penulis'),
                'tahun' => $this->put('tahun'),
                'penerbit' => $this->put('penerbit'),
                'stok' => $this->put('stok'),
                'harga_beli' => $this->put('harga_beli'),
                'harga_jual' => $this->put('harga_jual'),
                'kategori' => $this->put('id_kategori'),
            ];

            $updated = $this->buku->update_data($data, $id);
            if ($updated > 0) {
                $this->response([
                    'status' => true,
                    'message' => 'Berhasil memperbarui data'
                ], self::HTTP_OK);
            } else {
                $this->response([
                    'status' => true,
                    'message' => 'Gagal memperbarui data'
                ], self::HTTP_BAD_REQUEST);
            }
        }
    }

    private function _validationCheck()
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

        return $this->form_validation->run();
    }
}
