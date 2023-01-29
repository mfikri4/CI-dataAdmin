<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Admin_model"); //load model admin
    }

    //method pertama yang akan di eksekusi
    public function index()
    {

        $data["title"] = "List Data Admin";
        //ambil fungsi getAll untuk menampilkan semua data admin
        $data["data_admin"] = $this->Admin_model->getAll();
        //load view header.php pada folder views/templates
        $this->load->view('templates/header', $data);
        $this->load->view('templates/menu');
        //load view index.php pada folder views/admin
        $this->load->view('admin/index', $data);
        $this->load->view('templates/footer');
    }

    //method add digunakan untuk menampilkan form tambah data admin
    public function add()
    {
        $Admin = $this->Admin_model; //objek model
        $validation = $this->form_validation; //objek form validation
        $validation->set_rules($Admin->rules()); //menerapkan rules validasi pada admin_model
        //kondisi jika semua kolom telah divalidasi, maka akan menjalankan method save pada admin_model
        if ($validation->run()) {
            $Admin->save();
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Data Admin berhasil disimpan. 
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button></div>');
            redirect("admin");
        }
        $data["title"] = "Tambah Data Admin";
        $this->load->view('templates/header', $data);
        $this->load->view('templates/menu');
        $this->load->view('admin/add', $data);
        $this->load->view('templates/footer');
    }

    public function edit($id = null)
    {
        if (!isset($id)) redirect('admin');

        $Admin = $this->Admin_model;
        $validation = $this->form_validation;
        $validation->set_rules($Admin->rules());

        if ($validation->run()) {
            $Admin->update();
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Data Admin berhasil disimpan.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button></div>');
            redirect("admin");
        }
        $data["title"] = "Edit Data Admin";
        $data["data_admin"] = $Admin->getById($id);
        if (!$data["data_admin"]) show_404();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/menu');
        $this->load->view('admin/edit', $data);
        $this->load->view('templates/footer');
    }

    public function delete()
    {
        $id = $this->input->get('id_user');
        if (!isset($id)) show_404();
        $this->Admin_model->delete($id);
        $msg['success'] = true;
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
        Data Admin berhasil dihapus.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button></div>');
        $this->output->set_output(json_encode($msg));
    }
}
