<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_model extends CI_Model
{
    private $table = 'admin';

    //validasi form, method ini akan mengembailkan data berupa rules validasi form       
    public function rules()
    {
        return [
            [
                'field' => 'name',  //samakan dengan atribute name pada tags input
                'label' => 'Nama',  // label yang kan ditampilkan pada pesan error
                'rules' => 'trim|required' //rules validasi
            ],
            [
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'trim|required'
            ],
            [
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'trim|required'
            ],
            [
                'field' => 'level',
                'label' => 'Level',
                'rules' => 'trim|required'
            ]
        ];
    }

    //menampilkan data admin berdasarkan id admin
    public function getById($id)
    {
        return $this->db->get_where($this->table, ["id_user" => $id])->row();
        //query diatas seperti halnya query pada mysql 
        //select * from admin where IdMhsw='$id'
    }

    //menampilkan semua data admin
    public function getAll()
    {
        $this->db->from($this->table);
        $this->db->order_by("id_user", "desc");
        $query = $this->db->get();
        return $query->result();
        //fungsi diatas seperti halnya query 
        //select * from admin order by IdMhsw desc
    }

    //menyimpan data admin
    public function save()
    {
        $data = array(
            "name"      => $this->input->post('name'),
            "email"     => $this->input->post('email'),
            "password"  => $this->input->post('password'),
            "level"     => $this->input->post('level')
        );
        return $this->db->insert($this->table, $data);
    }

    //edit data admin
    public function update()
    {
        $data = array(
            "name"      => $this->input->post('name'),
            "email"     => $this->input->post('email'),
            "password"  => $this->input->post('password'),
            "level"     => $this->input->post('level')
        );
        return $this->db->update($this->table, $data, array('id_user' => $this->input->post('id_user')));
    }
    
    //hapus data admin
    public function delete($id)
    {
        return $this->db->delete($this->table, array("id_user" => $id));
    }
}