<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Hubungi extends CI_Controller {
  function __construct() {
    parent::__construct();
    $this->load->model("m_hubungi");
    $this->load->library("pagination");
    $this->load->library('excel');
  }
  
  public function index() {
    if (!($this->session->userdata('id_admin'))) {
      $this->load->view("login_page");
    } else {
      
      $this->session->unset_userdata('sess_cari_text');
      $this->session->unset_userdata('sess_cari_text2');
      #set Limit
      if ($this->uri->segment(3) != "") {
        $limit = $this->uri->segment(3);
      } else {
        $limit = 5;
      }
      
      #Config for pagination...
      $config                = array();
      $config["base_url"]    = base_url() . "pengajuan/text/index/" . $limit;
      $config["total_rows"]  = $this->m_hubungi->record_count();
      $config["per_page"]    = $limit;
      $config["uri_segment"] = 4;
      
      #Config css for pagination...
      $config['full_tag_open']   = '<ul class="pagination">';
      $config['full_tag_close']  = '</ul>';
      $config['first_link']      = "First";
      $config['last_link']       = "Last";
      $config['first_tag_open']  = '<li>';
      $config['first_tag_close'] = '</li>';
      $config['prev_link']       = '&laquo';
      $config['prev_tag_open']   = '<li class="prev">';
      $config['prev_tag_close']  = '</li>';
      $config['next_link']       = '&raquo';
      $config['next_tag_open']   = '<li>';
      $config['next_tag_close']  = '</li>';
      $config['last_tag_open']   = '<li>';
      $config['last_tag_close']  = '</li>';
      $config['cur_tag_open']    = '<li class="active"><a href="#">';
      $config['cur_tag_close']   = '</a></li>';
      $config['num_tag_open']    = '<li>';
      $config['num_tag_close']   = '</li>';
      
      #Check Page in Segement 3...
      if ($this->uri->segment(4) == "") {
        $data['number'] = 0;
      } else {
        $data['number'] = $this->uri->segment(4);
      }
      
      #Generate Pagination...
      $this->pagination->initialize($config);
      $page           = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
      $data["text"]   = $this->m_hubungi->fetch_text($config["per_page"], $page);
      $data["column"] = $this->m_hubungi->select_column_name($this->db->database);
      $data["links"]  = $this->pagination->create_links();
      
      #Generate Template...
      $this->load->view('template/header');
      $this->load->view('template/sidebar');
      $this->load->view('hubungi', $data);
      $this->load->view('template/footer');
      
    }
  }
  
  public function result() {
    if (!($this->session->userdata('user_id'))) {
      $this->load->view("login_page");
    } else {
      #Set Key Search to Session...
      if ($this->input->post('key')) {
        $data['cari'] = $this->input->post('key');
        $this->session->set_userdata('sess_cari_text', $data['cari']);
        $this->session->set_userdata('sess_cari_text2', $this->input->post('column_name'));
      } else {
        $data['cari'] = $this->session->userdata('sess_cari_text');
      }
      
      #set Limit
      if ($this->uri->segment(3) != '') {
        $limit = $this->uri->segment(3);
      } else {
        $limit = 5;
      }
      
      #Config for pagination...
      $config                = array();
      $config["base_url"]    = base_url() . "index.php/text/result/" . $limit . "/" . $data['cari'];
      $config["total_rows"]  = $this->m_hubungi->record_count_search($data['cari'], $this->input->post('column_name'));
      $config["per_page"]    = $limit;
      $config["uri_segment"] = 5;
      
      #Config css for pagination...
      $config['full_tag_open']   = '<ul class="pagination">';
      $config['full_tag_close']  = '</ul>';
      $config['first_link']      = "First";
      $config['last_link']       = "Last";
      $config['first_tag_open']  = '<li>';
      $config['first_tag_close'] = '</li>';
      $config['prev_link']       = '&laquo';
      $config['prev_tag_open']   = '<li class="prev">';
      $config['prev_tag_close']  = '</li>';
      $config['next_link']       = '&raquo';
      $config['next_tag_open']   = '<li>';
      $config['next_tag_close']  = '</li>';
      $config['last_tag_open']   = '<li>';
      $config['last_tag_close']  = '</li>';
      $config['cur_tag_open']    = '<li class="active"><a href="#">';
      $config['cur_tag_close']   = '</a></li>';
      $config['num_tag_open']    = '<li>';
      $config['num_tag_close']   = '</li>';
      
      #Check Page in Segement 3...
      if ($this->uri->segment(5) == "") {
        $data['number'] = 0;
      } else {
        $data['number'] = $this->uri->segment(5);
      }
      
      #Generate Pagination...
      $this->pagination->initialize($config);
      $page           = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
      $data["text"]   = $this->m_hubungi->fetch_text_search($config["per_page"], $page, $data['cari'], $this->input->post('column_name'));
      $data["column"] = $this->m_hubungi->select_column_name($this->db->database);
      $data["links"]  = $this->pagination->create_links();
      
      #Generate Template...
      $this->load->view('_template/header');
      $this->load->view('_template/sidebar_menu');
      $this->load->view('text', $data);
      $this->load->view('_template/footer');
      
    }
  }
  
  #Insert Data
  public function input() {
    #get data
    $data['text_id']       = "";
    $data['text_title']     = $this->input->post('text_title');
    $data['text_description']   = $this->input->post('text_description');
    #call function input from model
    $this->m_hubungi->input($data);
    #redirect to page
    redirect('text');
  }
  
  #Update Data
  public function edit() {
    $data['text_id']       =  $this->input->post('text_id');
    $data['text_title']     = $this->input->post('text_title');
    $data['text_description']   = $this->input->post('text_description');
    $this->m_hubungi->edit($data);
    redirect('text');
  }
  
  #Delete Data
  public function delete() {
    $this->m_hubungi->delete($this->input->post('text_id'));
    redirect('text');
  }
  
}
?>