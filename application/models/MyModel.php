<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MyModel extends CI_Model {

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

    public function login($username,$password)
    {
        $q  = $this->db->select('*')->from('admin')->where('username',$username)->get()->row();
        
        if($q == ""){
            return array('status' => 204,'message' => 'Username not found.');
        } else {
            $hashed_password = $q->password;
            $id              = $q->admin_id;
            $first_name              = $q->first_name;
            $last_name              = $q->last_name;
            $email              = $q->email;
            $mobile              = $q->mobile;
            $current_address              = $q->current_address;
            $parmanent_address              = $q->parmanent_address;
            $area              = $q->area;
            $city              = $q->city;
            $state              = $q->state;
            $country              = $q->country;
            $lat              = $q->lat;
            $lot             = $q->lot;
            $last_login              = $q->last_login;
            $edata = array(
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $email,
                'mobile' => $mobile,
                'current_address' => $current_address,
                'parmanent_address' => $parmanent_address,
                'area' => $area,
                'city' => $city,
                'state' => $state,
                'country' => $country,
                'lat' => $lat,
                'lot' => $lot,
                'last_login' => $last_login,
            );
            $hashed_password = $this->encryption->decrypt($hashed_password);
             echo $hashed_password ." ".$password;
        //exit;
//            if (hash_equals($hashed_password, crypt($password, $hashed_password))) {
                 if ($hashed_password == $password) {
               $last_login = date('Y-m-d H:i:s');
               $token = crypt(substr( md5(rand()), 0, 7),'');
               $expired_at = date("Y-m-d H:i:s", strtotime('+12 hours'));
               $this->db->trans_start();
               $this->db->where('admin_id',$id)->update('admin',array('last_login' => $last_login));
               $this->db->insert('admin_authentication',array('admin_id' => $id,'token' => $token,'expired_at' => $expired_at));
               if ($this->db->trans_status() === FALSE){
                  $this->db->trans_rollback();
                  return array('status' => 500,'message' => 'Internal server error.');
               } else {
                  $this->db->trans_commit();
                  return array('status' => 200,'message' => 'Successfully login.','id' => $id, 'token' => $token, 'data' => $edata);
               }
            } else {
                echo "Wrong password";
               return array('status' => 204,'message' => 'Wrong password.');
               
            }
        }
    }

    public function logout1()
    {
        $admin_id  = $this->input->get_request_header('Admin-ID', TRUE);
        $token     = $this->input->get_request_header('Authorization', TRUE);
        $this->db->where('admin_id',$admin_id)->where('token',$token)->delete('admin_authentication');
        return array('status' => 200,'message' => 'Successfully logout.');
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
    
    public function create_data_api($table,$data)
    {
        $this->db->insert($table,$data);
        $insert_id = $this->db->insert_id();
        
        return array('status' => 201,'message' => 'Data has been created.','insert_id' => $insert_id);
    }
    
    public function admin_detail_data($id)
    {
        return $this->db->select('*')->from('admin')->where('admin_id',$id)->order_by('admin_id','desc')->get()->row();
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
