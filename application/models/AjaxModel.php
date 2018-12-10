<?php  
 class AjaxModel extends CI_Model  
 {  
      var $table = "access_point";  
      var $select_column = array("id", "merk", "type", "sn", "mac_address", "status_ap", "location_type", "last_update_by", "last_update");  
      var $order_column = array("id", "merk", "type", "sn", "mac_address", "status_ap", "location_type", "last_update_by", "last_update");  

      function make_query($type,$status_ap,$location_type)  
      {  
           $this->db->select($this->select_column);  
           $this->db->from($this->table);
           // print_r($type);
           $this->db->like('type', $type);
           $this->db->like('status_ap', $status_ap);
           $this->db->like('location_type', $location_type);    
           if(isset($_POST["search"]["value"]))  
           {  
                // $this->db->like("id", $_POST["search"]["value"]);  
                // $this->db->or_like("merk", $_POST["search"]["value"]);  
                // $this->db->or_like("type", $_POST["search"]["value"]);  
                // $this->db->or_like("sn", $_POST["search"]["value"]);  
                // $this->db->or_like("mac_address", $_POST["search"]["value"]);  
                // $this->db->or_like("status_ap", $_POST["search"]["value"]);  
                // $this->db->or_like("location_type", $_POST["search"]["value"]);  
                // $this->db->or_like("last_update_by", $_POST["search"]["value"]);  
                // $this->db->or_like("last_update", $_POST["search"]["value"]);  
           } else {

           } 
           if(isset($_POST["order"]))  
           {  
                $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);  
           }  
           else  
           {  
                $this->db->order_by('id', 'ASC');  
           }  
      }  
      function make_datatables($type,$status_ap,$location_type){  
           $this->make_query($type,$status_ap,$location_type);  
           if($_POST["length"] != -1)  
           {  
                $this->db->limit($_POST['length'], $_POST['start']);  
           }  
           $query = $this->db->get();
           return $query->result();  
      }  
      function get_filtered_data($type,$status_ap,$location_type){  
           $this->make_query($type,$status_ap,$location_type);  
           $query = $this->db->get();  
           return $query->num_rows();  
      }       
      function get_all_data()  
      {  
           $this->db->select("*");  
           $this->db->from($this->table);  
           return $this->db->count_all_results();  
      }  
 }  