<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends CI_Controller {
  function __construct() {
    parent::__construct();
    $this->load->model("m_login");
    $this->load->model("m_widget");
    
  }
  
  public function index() {
    if (!($this->session->userdata('id_admin'))) {
      #Tampilkan Halaman Login Pertama kali
      $this->load->view("login_page");
    }else{

      $data['call']=$this->m_widget->call();
      $data['submision']=$this->m_widget->submision();
      $data['hospital']=$this->m_widget->hospital();
      $data['users']=$this->m_widget->users();
      $this->load->view("template/header");
      $this->load->view("template/sidebar");
      $this->load->view("content",$data);
      $this->load->view("template/footer");
    }
  }
  
  public function login() {
    #Cek apakah kegiatan post di lakukan
    if ($_POST) {
      #Inisialisasi username & password ke variabel $data
      $data['username'] = $this->input->post('username');
      $data['password'] = md5($this->input->post('password'));

      #Cek ke model apakah data inisialisasi ada dalam database
      $result           = $this->m_login->login($data);
      if (!empty($result)) { #Jika data ada
        #Buat array untuk menampung value kedalam session
        $data = array(
          'id_admin' 	 => $result->id_admin,
          'username' 	 => $result->username,
          'password' 	 => $result->password,
          'nama_lengkap' => $result->nama_lengkap,
          'emai'		 => $result->emai,
          'hp_admin' 	 => $result->hp_admin
        );
        #Set value ke session
        $this->session->set_userdata($data);
        #Alihkan
        redirect('home');
      } else { #Jika tidak ada
        #Kirim pesan jika value salah
        $this->session->set_flashdata('login', 'Username atau password salah!');
        #Alihkan
        redirect('home');
      }
    }
  }
  
  public function logout() {
    $this->session->sess_destroy();
    redirect('' . base_url());
  }
  
}
?>