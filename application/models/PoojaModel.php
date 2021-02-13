<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PoojaModel extends CI_Model {

    var $client_service = "frontend-poojapth";
    var $auth_key       = "4253k9";

    public function check_auth_client(){
        $client_service = $this->input->get_request_header('Client-Service', TRUE);
        $auth_key  = $this->input->get_request_header('Auth-Key', TRUE);
        
        if($client_service == $this->client_service && $auth_key == $this->auth_key){
            return true;
        } else {
            return json_output(401,array('status' => 401,'message' => 'Unauthorized.'));
        }
    }


    public function auth()
    {
        $admin_id  = $this->input->get_request_header('User-ID', TRUE);
        $token     = $this->input->get_request_header('Authorization', TRUE);
        $q  = $this->db->select('expired_at')->from('admin_authentication')->where('admin_id',$admin_id)->where('token',$token)->get()->row();
        if($q == ""){
            return json_output(401,array('status' => 401,'message' => 'Unauthorized.'));
        } else {
            if($q->expired_at < date('Y-m-d H:i:s')){
                return json_output(401,array('status' => 401,'message' => 'Your session has been expired.'));
            } else {
                $updated_at = date('Y-m-d H:i:s');
                $expired_at = date("Y-m-d H:i:s", strtotime('+12 hours'));
                $this->db->where('admin_id',$admin_id)->where('token',$token)->update('admin_authentication',array('expired_at' => $expired_at,'updated_at' => $updated_at));
                return array('status' => 200,'message' => 'Authorized.');
            }
        }
    }
    
    public function all_query($data) {
       $response = $this->db->query($data); 
       return $response;
    }
    
    public function all_priest()
    {
        return $this->db->select('*')->from('priest_preference')->where('status',1)->get()->result();
    }
    
    public function all_poojaservice()
    {
        return $this->db->select('*')->from('pooja_service')->where('status',1)->get()->result();
    }
    
    public function all_poojas()
    {
        return $this->db->select('*')->from('pooja_list_table')->where('status',1)->get()->result();
    }
    
    public function priest_details_by_id($id)
    {
        return $this->db->select('*')->from('priest_preference')->where('id',$id)->order_by('id','desc')->get()->row();
    }
    
    public function pooja_service_by_id($id)
    {
        return $this->db->select('*')->from('pooja_service')->where('service_id',$id)->order_by('service_id','desc')->get()->row();
    }
    
    public function check_user_exist($table,$data)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($data);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
                return TRUE;
        } else {
                return FALSE;
        }
    }
    
    public function select_details_by_conditions($table,$data)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($data);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
//            $query = $this->db->$query->result();
                return $query->result();
        } else {
                return FALSE;
        }
    }
    
    public function get_priest_pooja_relationship_by_priest($id)
    {
        $this->db->select('*');
        $this->db->from('priest_preference_pooja_relationship');
        $this->db->where('priest_preference_id',$id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
        return $query->result();
        } else {
        return NULL;
        }

    }
    
    public function get_priest_pooja_relationship_by_pooja($id){
        $this->db->select('*');
        $this->db->from('priest_preference_pooja_relationship');
        $this->db->where('pooja_id',$id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
        return $query->result();
        } else {
        return NULL;
        }
    }

    public function poojas_detail_by_id($id)
    {
        return $this->db->select('*')->from('pooja_list_table')->where('id',$id)->order_by('id','desc')->get()->row();
    }
    
    public function get_poojalist_by_priest_and_service($priest_preference_id,$pooja_service_id){
        $this->db->select('pooja_list_table.*,priest_preference_pooja_relationship.priest_preference_id,priest_preference_pooja_relationship.priest_preference_pooja_id');
        $this->db->from('pooja_list_table');
        $this->db->join('priest_preference_pooja_relationship','pooja_list_table.id=priest_preference_pooja_relationship.pooja_id','LEFT');
        $this->db->where('pooja_list_table.pooja_service_id',$pooja_service_id);
        $this->db->where('priest_preference_pooja_relationship.priest_preference_id',$priest_preference_id);
        $query=$this->db->get();
        
        if ($query->num_rows() > 0) {
        return $query->result_array();
        } else {
        return NULL;
        }
    }
    
    public function get_priest_pooja_relationship_by_id($id)
    {
        return $this->db->select('*')->from('priest_preference_pooja_relationship')->where('priest_preference_pooja_id',$id)->order_by('priest_preference_pooja_id','desc')->get()->row();
    }
    
    public function all_item_list()
    {
        return $this->db->select('*')->from('items')->where('status',1)->get()->result();
    }
    
    public function get_pooja_item_list_for_pooja($pooja_id){
        $this->db->select('pooja_item_list.*,items.item_name_en,items.item_name_hi,items.item_image,items.item_price,items.item_qty,items.item_qty_type');
        $this->db->from('pooja_item_list');
        $this->db->join('items','pooja_item_list.item_id = items.item_id','LEFT');
        $this->db->where('pooja_item_list.pooja_id',$pooja_id);
        $query=$this->db->get();
        
        if ($query->num_rows() > 0) {
        return $query->result_array();
        } else {
        return NULL;
        }
    }
    
    public function create_data($table,$data)
    {
        $this->db->insert($table,$data);
        $insert_id = $this->db->insert_id();
        return array('status' => 200,'message' => 'Data has been created.','insert_id' => $insert_id);
        
    }
    
    public function admin_details_data($id)
    {
        return $this->db->select('*')->from('admin')->where('admin_id',$id)->order_by('admin_id','desc')->get()->row();
    }
    
    public function country_all_data()
    {
       $this->db->select('*');
        $this->db->from('country');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
        return $query->result();
        } else {
        return NULL;
        }

    }
    
    public function state_data($data)
    {
        $this->db->select('*');
        $this->db->from('state');
        $this->db->where('country_id',$data);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
        return $query->result();
        } else {
        return NULL;
        }

    }
    
    public function city_data($data)
    {
        $this->db->select('*');
        $this->db->from('city');
        $this->db->where('state_id',$data);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
        return $query->result();
        } else {
        return NULL;
        }

    }
    
    public function area_data($data)
    {
        $this->db->select('*');
        $this->db->from('area');
        $this->db->where('city_id',$data);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
        return $query->result();
        } else {
        return NULL;
        }

    }
    
    public function pandit_availability()
    {
       $this->db->select('*');
        $this->db->from('pandit_table');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
        return $query->result();
        } else {
        return NULL;
        }

    }
    
    public function update_admin_details($id,$data)
    {
        if($this->db->where('admin_id',$id)->update('admin',$data)){
            return array('status' => 200,'message' => 'Data has been updated.');  
        }else{
            return array('status' => 401,'message' => 'Data can not updated.');
        }
    }
    
    public function admin_image_details($id)
    {
        return $this->db->select('image')->from('admin')->where('admin_id',$id)->order_by('admin_id','desc')->get()->row();
    }
    
    
    public function book_all_data()
    {
        return $this->db->select('id,title,author')->from('books')->order_by('id','desc')->get()->result();
    }

    public function book_detail_data($id)
    {
        return $this->db->select('id,title,author')->from('books')->where('id',$id)->order_by('id','desc')->get()->row();
    }

    public function book_create_data($data)
    {
        $this->db->insert('books',$data);
        return array('status' => 201,'message' => 'Data has been created.');
    }

    public function book_update_data($id,$data)
    {
        $this->db->where('id',$id)->update('books',$data);
        return array('status' => 200,'message' => 'Data has been updated.');
    }

    public function book_delete_data($id)
    {
        $this->db->where('id',$id)->delete('books');
        return array('status' => 200,'message' => 'Data has been deleted.');
    }

}
