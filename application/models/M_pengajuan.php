<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_pengajuan extends CI_Model {
  function __construct() {
    parent::__construct();
  }
  
  #Get Nama Kolom
  public function select_column_name($db) {
    $query = $this->db->query("select COLUMN_NAME
                              from INFORMATION_SCHEMA.COLUMNS
                              where TABLE_SCHEMA='$db' and TABLE_NAME='tbl_hubungi'");
    return $query->result();
  }
  
  #Export Data
  public function export() {
    $query = $this->db->query("select * from tbl_hubungi");
    return $query->result();
  }
  
  #Hitung Jumlah text
  public function record_count() {
    return $this->db->count_all("tbl_hubungi");
  }
  
  #tampilkan data
  public function fetch_text($limit, $start) {
    $this->db->select('*');
    $this->db->from('tbl_hubungi');
    $this->db->limit($limit, $start);
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
      foreach ($query->result() as $row) {
        $data[] = $row;
      }
      return $data;
    }
    return false;
  }
  
  #Hitung data yang di cari 
  public function record_count_search($key, $column_name) {
    if ($column_name == "") {
      $this->db->or_like("nm_lengkap", $key);
    } else {
      $this->db->like($column_name, $key);
    }
    return $this->db->count_all_results("tbl_hubungi");
  }
  
  #Tampilkan data yang dicari
  public function fetch_text_search($limit, $start, $key, $column_name) {
    $this->db->select('*');
    $this->db->from('tbl_hubungi');
    
    if ($column_name == "") {
      $this->db->or_like("nm_lengkap", $key);
    } else {
      $this->db->like($column_name, $key);
    }
    
    $this->db->limit($limit, $start);
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
      foreach ($query->result() as $row) {
        $data[] = $row;
      }
      return $data;
    }
    return null;
    
  }
  
  #Masukkan data ke DB
  public function input($data) {
    #insert data
    $this->db->insert('tbl_hubungi', $data);
  }
  
  #Edit data sesuai ID terpilih
  public function edit($data) {
    #update data
    $this->db->update('tbl_hubungi', $data, array(
      'id_hubungi' => $data['id_hubungi']
    ));
  }
  
  #Delete data sesuai ID terpilih
  public function delete($id) {
    #delete data
    $this->db->delete('tbl_hubungi', array(
      'id_hubungi' => $id
    ));
  }
}
?>