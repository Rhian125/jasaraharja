<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_rumah_sakit extends CI_Model {
  function __construct() {
    parent::__construct();
  }
  
  #Get Nama Kolom
  public function select_column_name($db) {
    $query = $this->db->query("select COLUMN_NAME
                              from INFORMATION_SCHEMA.COLUMNS
                              where TABLE_SCHEMA='$db' and TABLE_NAME='tbl_rumahsakit'");
    return $query->result();
  }
  
  #Export Data
  public function export() {
    $query = $this->db->query("select * from tbl_rumahsakit");
    return $query->result();
  }
  
  #Hitung Jumlah text
  public function record_count() {
    return $this->db->count_all("tbl_rumahsakit");
  }
  
  #tampilkan data
  public function fetch_text($limit, $start) {
    $this->db->select('*');
    $this->db->from('tbl_rumahsakit');
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
      $this->db->like("text_title", $key);
      $this->db->or_like("text_description", $key);
    } else {
      $this->db->like($column_name, $key);
    }
    return $this->db->count_all_results("tbl_rumahsakit");
  }
  
  #Tampilkan data yang dicari
  public function fetch_text_search($limit, $start, $key, $column_name) {
    $this->db->select('*');
    $this->db->from('tbl_rumahsakit');
    
    if ($column_name == "") {
      $this->db->like("text_title", $key);
      $this->db->or_like("text_description", $key);
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
    $this->db->insert('tbl_rumahsakit', $data);
  }
  
  #Edit data sesuai ID terpilih
  public function edit($data) {
    #update data
    $this->db->update('tbl_rumahsakit', $data, array(
      'text_id' => $data['text_id']
    ));
  }
  
  #Delete data sesuai ID terpilih
  public function delete($id) {
    #delete data
    $this->db->delete('tbl_rumahsakit', array(
      'text_id' => $id
    ));
  }
}
?>
