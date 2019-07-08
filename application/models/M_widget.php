<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_widget extends CI_Model {
  function __construct() {
    parent::__construct();
  }
  
  public function call() {
    return $this->db->count_all("tbl_hubungi");
  }

  public function submision() {
    return $this->db->count_all("tbl_pengajuan");
  }

  public function hospital() {
    return $this->db->count_all("tbl_rumahsakit");
  }

  public function users() {
    return $this->db->count_all("tbl_user");
  }
}
?>