<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Apicontroller extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
        /*
        $check_auth_client = $this->MyModel->check_auth_client();
		if($check_auth_client != true){
			die($this->output->get_output());
		}
		*/
        $this->load->helper('url');
        $this->load->helper('json_output');  
        $this->load->library('encryption');
        $this->load->model('LoginModel');
		$this->load->library('mainlogin');
		date_default_timezone_set('Asia/Kolkata');
    }
        public function index()
	{
            echo " Welcome ETI Survey Portal";
        }
        public function login_process()
	{
		$method = $_SERVER['REQUEST_METHOD'];

		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {

			$check_auth_client = $this->LoginModel->check_auth_client();
			
			if($check_auth_client == true){
				$params = $_REQUEST;
		        
		        $username = $params['username'];
		        $password = $params['password'];
                
                    $this->load->library('mainlogin');
                    $resp =  $this->mainlogin->login($username,$password); 
                    if($resp['status'] == 200){
                        json_output($resp['status'],$resp);
                    }
                    else{
                        echo json_encode($resp); 
                    }  
                 
			}
		}
	}

	public function logout()
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->LoginModel->check_auth_client();
			if($check_auth_client == true){
                            $params = $_REQUEST;
                            json_output(200,array('status' => 200,'message' => 'Logout Successfully'));
			}
		}
	}
        
        public function insert_api()
	{
		$method = $_SERVER['REQUEST_METHOD'];
                
                // check method is post or not
                
		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {

                        $check_auth_client = $this->LoginModel->check_auth_client();
			
			if($check_auth_client == true){
                            
				$params = $_REQUEST;
                                $data = array();
                                if(isset($params['name'])){
                                   $data['emp_name'] = $params['name']; 
                                }
                                else{
                                   echo json_encode(array('status' => 401,'message' => 'First name is compulsory.'));
                                    exit();
                                }
                                
                                if(isset($params['password'])){
                                   $password = $params['password']; 
                                }
                                else{
                                    echo json_encode(array('status' => 401,'message' => 'Password is compulsory.'));
                                    exit();
                                }
                                
                                if(isset($params['mobile'])){
                                   $data['emp_mobile'] = $params['mobile']; 
                                   $mobile = $params['mobile'];
                                }
                                else{
                                    echo json_encode(array('status' => 401,'message' => 'Mobile no is compulsory.'));
                                    exit();
                                }
                                
                                if(isset($params['designation'])){
                                   $data['emp_designation'] = $params['designation']; 
                                }
                                
                                
                                
                                $table = 'employee';
                                
                                $check_data = array(
                                    'emp_mobile' => $mobile
                                );
                                
                                // check user alreasy ready registered or not
                                
                                if($this->LoginModel->check_user_exist($table,$check_data) == TRUE){
                                    
                                   echo json_encode(array('status' => 204,'message' => 'Mobile number already registered.'));
                                   
                                }else{
                                    
                                        // encrypt password
                                        
                                        $password = $this->encryption->encrypt($password);
                                        
                                        $data['emp_password'] = $password;
                                        
                                        $this->load->library('mainlogin');
                                        
                                        $response =  $this->mainlogin->insert($table,$data);
                                        
                                        $id = $response['insert_id'];
                                        
                                        $resp = $this->mainlogin->employee_details($id);
                                        
                                        if($resp == ''){
                                          $response = array('status' => 400,'message' => 'Employee Not Found.');
                                            json_output($response['status'],$response);
                                            
                                        }else{
                                            $response = array('status' => 400,'data' => $resp);
                                            json_output($response['status'],$response);
                                            
                                        }
                                                
                                    }

			}

                }
	}
        
        //-------- employee salary details details ---//
        public function employee_salary_details() {
            $method = $_SERVER['REQUEST_METHOD'];
                
                // check method is post or not
                
		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {

                        $check_auth_client = $this->LoginModel->check_auth_client();
			
			if($check_auth_client == true){
                            
				$params = $_REQUEST;
                                $data = array();
                                $this->load->library('mainlogin');
                                if(isset($params['emp_id'])){
                                    $emp_id = $params['emp_id'];
                                    $condition = array('emp_id' => $emp_id);
                                    $table = "employee_salary";
                                    $resp =  $this->mainlogin->get_detaild_by_conditions($table,$condition);
                                    json_output(200,array('status' => 200,'data' => $resp));
                                }
                                else{
                                   echo json_encode(array('status' => 401,'message' => 'Employee Id is compulsory.'));
                                    exit();
                                }
                        }

                }
        }
        //-------- close employee salary details details ---//
        
        //-------- employee bank details ---//
        public function employee_bank_details() {
            $method = $_SERVER['REQUEST_METHOD'];
                
                // check method is post or not
                
		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {

                        $check_auth_client = $this->LoginModel->check_auth_client();
			
			if($check_auth_client == true){
                            
				$params = $_REQUEST;
                                $data = array();
                                $this->load->library('mainlogin');
                                if(isset($params['emp_id'])){
                                    $emp_id = $params['emp_id'];
                                    $condition = array('emp_id' => $emp_id);
                                    $table = "employee_bank_details";
                                    $resp =  $this->mainlogin->get_detaild_by_conditions($table,$condition);
                                    json_output(200,array('status' => 200,'data' => $resp));
                                }
                                else{
                                   echo json_encode(array('status' => 401,'message' => 'Employee Id is compulsory.'));
                                    exit();
                                }
                        }

                }
        }
        //-------- close employee bank details ---//
       
        public function survey()
	{
		$method = $_SERVER['REQUEST_METHOD'];
                
                // check method is post or not
                
		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {

                        $check_auth_client = $this->LoginModel->check_auth_client();
			
			if($check_auth_client == true){
                            
				$params = $_REQUEST;
                                $data = array();
                                  $this->load->library('mainlogin');
                                  
                                if(isset($params['survey_emp_name'])){
                                   $data['survey_emp_name'] = $params['survey_emp_name']; 
                                }
                                else{
                                   echo json_encode(array('status' => 401,'message' => 'Employee name is compulsory.'));
                                    exit();
                                }
                                
                                if(isset($params['survey_emp_mobile'])){
                                   $data['survey_emp_mobile'] = $params['survey_emp_mobile']; 
                                }
                                else{
                                    echo json_encode(array('status' => 401,'message' => 'Mobile no is compulsory.'));
                                    exit();
                                }
                                
                                if(isset($params['survey_junction_name'])){
                                   $data['survey_junction_name'] = $params['survey_junction_name'];  
                                }
                                else{
                                    echo json_encode(array('status' => 401,'message' => 'Site junction name is compulsory.'));
                                    exit();
                                }
                                
                                if(isset($params['img_type'])){
                                   $imgtype = $params['img_type']; 
                                }else{
                                    $imgtype = 'jpg';
                                }
                                
                                if(isset($params['survey_lat_log'])){
                                   $data['survey_lat_log'] = $params['survey_lat_log']; 
                                } 
                                
                                if(isset($params['survey_angle1']) && $params['survey_angle1'] != ''){
                                   $image = $params['survey_angle1']; 
                                   $directory_path = "survey/";
                                   $image_name = str_replace(' ', '_', $params['survey_junction_name'])."_angle1";
                                   $result =  $this->mainlogin->file_upload($image,$imgtype,$directory_path,$image_name); 
                                   if($result['status'] == 200){
                                       $data['survey_angle1'] = $result['image_name'];
                                   }
                                }
                                
                                if(isset($params['survey_angle2']) && $params['survey_angle2'] != ''){
                                   $image = $params['survey_angle2']; 
                                   $directory_path = "survey/";
                                   $image_name = str_replace(' ', '_', $params['survey_junction_name'])."_angle2";
                                   $result =  $this->mainlogin->file_upload($image,$imgtype,$directory_path,$image_name); 
                                   if($result['status'] == 200){
                                       $data['survey_angle2'] = $result['image_name'];
                                   }
                                }
                                
                                if(isset($params['survey_angle3']) && $params['survey_angle3'] != ''){
                                   $image = $params['survey_angle3']; 
                                   $directory_path = "survey/";
                                   $image_name = str_replace(' ', '_', $params['survey_junction_name'])."_angle3";
                                   $result =  $this->mainlogin->file_upload($image,$imgtype,$directory_path,$image_name); 
                                   if($result['status'] == 200){
                                       $data['survey_angle3'] = $result['image_name'];
                                   }
                                }
                                
                                if(isset($params['survey_angle4']) && $params['survey_angle4'] != ''){
                                   $image = $params['survey_angle4']; 
                                   $directory_path = "survey/";
                                   $image_name = str_replace(' ', '_', $params['survey_junction_name'])."_angle4";
                                   $result =  $this->mainlogin->file_upload($image,$imgtype,$directory_path,$image_name); 
                                   if($result['status'] == 200){
                                       $data['survey_angle4'] = $result['image_name'];
                                   }
                                   
                                }
                                
                                if(isset($params['survey_power_distance'])){
                                   $data['survey_power_distance'] = $params['survey_power_distance']; 
                                }
                                
                                if(isset($params['survey_fiber_requicred'])){
                                   $data['survey_fiber_requicred'] = $params['survey_fiber_requicred']; 
                                }
                                
                                if(isset($params['survey_comments'])){
                                   $data['survey_comments'] = $params['survey_comments']; 
                                }
                                
                                $table = 'survey';
                                 // encrypt password
                                        
                                        date_default_timezone_set('Asia/Kolkata');
                                        $expired_at =$timestamp = date("Y-m-d H:i:s");
//                                        $expired_at = date("Y-m-d H:i:s", strtotime('+12 hours'));
                                        $data['survey_date'] = $expired_at;
                                        $response =  $this->mainlogin->insert($table,$data);
                                        
                                        $id = $response['insert_id'];
                                        
                                        $response = array('status' => 200,'message' => 'Survey successfully complete survey is '.$id);
                                        json_output($response['status'],$response);       
                        }

                }
	}
        
        //-------- etinew site survey app --------//
        public function site_survey()
	{
		$method = $_SERVER['REQUEST_METHOD'];
                
                // check method is post or not
                
		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {

                        $check_auth_client = $this->LoginModel->check_auth_client();
			
			if($check_auth_client == true){
                            
				$params = $_REQUEST;
                                $data = array();
                                  $this->load->library('mainlogin');
                                  
                                if(isset($params['survey_emp_name'])){
                                   $data['survey_emp_name'] = $params['survey_emp_name']; 
                                }
                                else{
                                   echo json_encode(array('status' => 401,'message' => 'Employee name is compulsory.'));
                                    exit();
                                }
                                
                                if(isset($params['emp_id'])){
                                   $data['emp_id'] = $params['emp_id']; 
                                }
                                else{
                                   echo json_encode(array('status' => 401,'message' => 'Employee id compulsory.'));
                                    exit();
                                }
                                
                                if(isset($params['survey_emp_mobile'])){
                                   $data['survey_emp_mobile'] = $params['survey_emp_mobile']; 
                                }
                                else{
                                    echo json_encode(array('status' => 401,'message' => 'Mobile no is compulsory.'));
                                    exit();
                                }
                                
                                if(isset($params['survey_site_name'])){
                                   $data['survey_site_name'] = $params['survey_site_name'];  
                                }
                                else{
                                    echo json_encode(array('status' => 401,'message' => 'Site name is compulsory.'));
                                    exit();
                                }
                                
                                if(isset($params['survey_site_id'])){
                                   $data['survey_site_id'] = $params['survey_site_id'];  
                                }
                                else{
                                    echo json_encode(array('status' => 401,'message' => 'Site id is compulsory.'));
                                    exit();
                                }
                                
                                if(isset($params['coordinator'])){
                                   $data['coordinator_id'] = $params['coordinator'];  
                                }
                                else{
                                   echo json_encode(array('status' => 401,'message' => 'Coordinator is compulsory.'));
                                    exit();
                                }
                                
                                if(isset($params['project_id'])){
                                   $data['project_id'] = $params['project_id'];  
                                }
                                
                                if(isset($params['img_type'])){
                                   $imgtype = $params['img_type']; 
                                }else{
                                    $imgtype = 'jpg';
                                }
                                
                                if(isset($params['survey_lat'])){
                                   $data['survey_lat'] = $params['survey_lat']; 
                                } 
                                
                                if(isset($params['survey_long'])){
                                   $data['survey_long'] = $params['survey_long']; 
                                } 
                                
                                if(isset($params['survey_angle1']) && $params['survey_angle1'] != ''){
                                   $image = $params['survey_angle1']; 
                                   $directory_path = "site_image/";
                                   $image_name = str_replace(' ', '_', $params['survey_site_id'])."_angle1";
                                   $result =  $this->mainlogin->file_upload($image,$imgtype,$directory_path,$image_name); 
                                   if($result['status'] == 200){
                                       $data['survey_angle1'] = $result['image_name'];
                                   }
                                }
                                
                                if(isset($params['survey_angle2']) && $params['survey_angle2'] != ''){
                                   $image = $params['survey_angle2']; 
                                   $directory_path = "site_image/";
                                   $image_name = str_replace(' ', '_', $params['survey_site_id'])."_angle2";
                                   $result =  $this->mainlogin->file_upload($image,$imgtype,$directory_path,$image_name); 
                                   if($result['status'] == 200){
                                       $data['survey_angle2'] = $result['image_name'];
                                   }
                                }
                                
                                if(isset($params['survey_angle3']) && $params['survey_angle3'] != ''){
                                   $image = $params['survey_angle3']; 
                                   $directory_path = "site_image/";
                                   $image_name = str_replace(' ', '_', $params['survey_site_id'])."_angle3";
                                   $result =  $this->mainlogin->file_upload($image,$imgtype,$directory_path,$image_name); 
                                   if($result['status'] == 200){
                                       $data['survey_angle3'] = $result['image_name'];
                                   }
                                }
                                
                                if(isset($params['survey_angle4']) && $params['survey_angle4'] != ''){
                                   $image = $params['survey_angle4']; 
                                   $directory_path = "site_image/";
                                   $image_name = str_replace(' ', '_', $params['survey_site_id'])."_angle4";
                                   $result =  $this->mainlogin->file_upload($image,$imgtype,$directory_path,$image_name); 
                                   if($result['status'] == 200){
                                       $data['survey_angle4'] = $result['image_name'];
                                   }
                                   
                                }
                                
                                if(isset($params['survey_location'])){
                                   $data['survey_location'] = $params['survey_location']; 
                                }
                                
                                if(isset($params['survey_remark'])){
                                   $data['survey_remark'] = $params['survey_remark']; 
                                } 
                                
                                if(isset($params['site_status'])){
                                   $data['site_status'] = $params['site_status']; 
                                }
                                
                                $table = 'eti_site_survey';
                                 // encrypt password
                                        
                                        date_default_timezone_set('Asia/Kolkata');
                                        $expired_at =$timestamp = date("Y-m-d H:i:s");
//                                        $expired_at = date("Y-m-d H:i:s", strtotime('+12 hours'));
                                        $data['survey_date'] = $expired_at;
                                        $response =  $this->mainlogin->insert($table,$data);
                                        
                                        $id = $response['insert_id'];
                                        if($id != ''){
                                            if(isset($params['expense']) & isset($params['expense_type'])){
                                                $expense = $params['expense']; 
                                                $all_expense = explode(',',$expense);
                                                $expense_type = $params['expense_type'];
                                                $all_expense_type = explode(',',$expense_type);
                                                $expense_details = $params['expense_details'];
                                                $all_expense_detailse = explode(',',$expense_details);
                                                $table = "eti_site_survey_expense";
                                                $this->load->library('mainlogin');
                                                for($i=0;$i<count($all_expense_type);$i++){
                                                    $Expense_type = $all_expense_type[$i];
                                                    $Expense = $all_expense[$i];
                                                    $Expense_detailse = $all_expense_detailse[$i];
                                                    $data = array(
                                                            'site_survey_id' => $id,
                                                            'expense_type' => $Expense_type,
                                                            'expense' => $Expense,
                                                            'expense_details' => $Expense_detailse,
                                                            );
                                                    $response =  $this->mainlogin->insert($table,$data);
                                                }
                                            }
                                        }
                                        
                                        $response = array('status' => 200,'message' => 'Survey successfully complete survey is '.$id);
                                        json_output($response['status'],$response);       
                        }

                }
	}
        //-------- close eti new site survey app ---//
        
        //-------- eti new site survey update ---//
        public function site_survey_update_details()
	{
		$method = $_SERVER['REQUEST_METHOD'];
                
                // check method is post or not
                
		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {

                        $check_auth_client = $this->LoginModel->check_auth_client();
			
			if($check_auth_client == true){
                            
				$params = $_REQUEST;
                                $data = array();
                                  $this->load->library('mainlogin');
                                  
                                if(isset($params['site_survey_id '])){
                                   $site_survey_id  = $params['site_survey_id']; 
                                }
                                else{
                                   echo json_encode(array('status' => 401,'message' => 'Site Id Compulsory.'));
                                    exit();
                                }
                                
                                if(isset($params['emp_id'])){
                                   $data['emp_id'] = $params['emp_id']; 
                                }
                                
                                if(isset($params['survey_emp_mobile'])){
                                   $data['survey_emp_mobile'] = $params['survey_emp_mobile']; 
                                }
                                
                                if(isset($params['survey_site_name'])){
                                   $data['survey_site_name'] = $params['survey_site_name'];  
                                }
                                else{
                                    echo json_encode(array('status' => 401,'message' => 'Site name is compulsory.'));
                                    exit();
                                }
                                
                                if(isset($params['coordinator'])){
                                   $data['coordinator_id'] = $params['coordinator'];  
                                }
                                
                                if(isset($params['survey_lat'])){
                                   $data['survey_lat'] = $params['survey_lat']; 
                                } 
                                
                                if(isset($params['survey_long'])){
                                   $data['survey_long'] = $params['survey_long']; 
                                } 
                                
                                if(isset($params['survey_location'])){
                                   $data['survey_location'] = $params['survey_location']; 
                                }
                                
                                if(isset($params['survey_remark'])){
                                   $data['survey_remark'] = $params['survey_remark']; 
                                } 
                                
                                if(isset($params['site_status'])){
                                   $data['site_status'] = $params['site_status']; 
                                }
                                date_default_timezone_set('Asia/Kolkata');
                                $expired_at =$timestamp = date("Y-m-d H:i:s");
                                $data['survey_date'] = $expired_at;
                                $table = 'eti_site_survey';
                                
                                    $check_data = array('site_survey_id' => $site_survey_id);
                                    $this->load->library('mainlogin');
                                    if($this->mainlogin->check_user_exist($table,$check_data) == TRUE){
                                        $response =  $this->mainlogin->update_data($table,$check_data,$data);
                                        if(isset($params['expense']) & isset($params['expense_type'])){
                                                $expense = $params['expense']; 
                                                $all_expense = explode(',',$expense);
                                                $expense_type = $params['expense_type'];
                                                $all_expense_type = explode(',',$expense_type);
                                                $expense_details = $params['expense_details'];
                                                $all_expense_detailse = explode(',',$expense_details);
                                                $table = "eti_site_survey_expense";
                                                $condition = array('site_survey_id' => $site_survey_id);
                                                $this->load->library('mainlogin');
                                                $response =  $this->mainlogin->delete_records($table,$condition);
                                                for($i=0;$i<count($all_expense_type);$i++){
                                                    $Expense_type = $all_expense_type[$i];
                                                    $Expense = $all_expense[$i];
                                                    $Expense_detailse = $all_expense_detailse[$i];
                                                    $data = array(
                                                            'site_survey_id' => $site_survey_id,
                                                            'expense_type' => $Expense_type,
                                                            'expense' => $Expense,
                                                            'expense_details' => $Expense_detailse,
                                                            );
                                                    $response =  $this->mainlogin->insert($table,$data);
                                                }
                                            }
                                    }       
                                    
                                        $response = array('status' => 200,'message' => 'Survey successfully Updated');
                                        json_output($response['status'],$response);       
                        }

                }
	}
        //-------- close eti new site survey update ---//
        
        //-------- eti new site survey list ---//
        public function site_survey_list() {
            $method = $_SERVER['REQUEST_METHOD'];
                
                // check method is post or not
                
		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {

                        $check_auth_client = $this->LoginModel->check_auth_client();
			
			if($check_auth_client == true){
                            
				$params = $_REQUEST;
                                $data = array();
                                $this->load->library('mainlogin');
//                                if(isset($params['emp_id'])){
//                                    $data['emp_id'] = $params['emp_id'];
//                                }
                                  
                                if(isset($params['emp_mobile'])){
                                    $data['survey_emp_mobile'] = $params['emp_mobile'];
                                    $orderby = "site_survey_id";
                                    $table = "eti_site_survey";
                                    $resp =  $this->mainlogin->get_all_list_by_condition_with_orderby($table,$data,$orderby);
                                    json_output(200,array('status' => 200,'data' => $resp));
                                }
                                else{
                                   echo json_encode(array('status' => 401,'message' => 'Employee Id is compulsory.'));
                                    exit();
                                }
                        }

                }
        }
        //-------- close eti new site survey list ---//
        
        //-------- eti new site survey expense details ---//
        public function site_survey_expense() {
            $method = $_SERVER['REQUEST_METHOD'];
                
                // check method is post or not
                
		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {

                        $check_auth_client = $this->LoginModel->check_auth_client();
			
			if($check_auth_client == true){
                            
				$params = $_REQUEST;
                                $data = array();
                                $this->load->library('mainlogin');
                                if(isset($params['site_survey_id'])){
                                    $site_survey_id = $params['site_survey_id'];
                                    $condition = array('site_survey_id' => $site_survey_id);
                                    $table = "eti_site_survey_expense";
                                    $resp =  $this->mainlogin->get_detaild_by_conditions($table,$condition);
                                    json_output(200,array('status' => 200,'data' => $resp));
                                }
                                else{
                                   echo json_encode(array('status' => 401,'message' => 'Employee Id is compulsory.'));
                                    exit();
                                }
                        }

                }
        }
        //-------- close eti new site survey expense details ---//
        
        //------- send live current lication from app ----//
        public function employee_location_tracking()
	{
		$method = $_SERVER['REQUEST_METHOD'];
                
                // check method is post or not
                
		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {

                        $check_auth_client = $this->LoginModel->check_auth_client();
			
			if($check_auth_client == true){
                            
				$params = $_REQUEST;
                                $data = array();
                                  $this->load->library('mainlogin');
                                  
                                if(isset($params['emp_id'])){
                                   $data['emp_id'] = $params['emp_id']; 
                                }
                                else{
                                   echo json_encode(array('status' => 401,'message' => 'Employee Id is compulsory.'));
                                    exit();
                                }
                                
                                if(isset($params['latitude'])){
                                   $data['latitude'] = $params['latitude']; 
                                }
                                else{
                                    echo json_encode(array('status' => 401,'message' => 'Latitude no is compulsory.'));
                                    exit();
                                }
                                
                                if(isset($params['longitude'])){
                                   $data['longitude'] = $params['longitude'];  
                                }
                                else{
                                    echo json_encode(array('status' => 401,'message' => 'Longitude name is compulsory.'));
                                    exit();
                                }
                                
                                
                                if(isset($params['current_location'])){
                                   $data['current_location'] = $params['current_location']; 
                                }
                                
                                 
                                
                                $table = 'employee_location_activity';
                                 // encrypt password
                                        
                                        date_default_timezone_set('Asia/Kolkata');
                                        $expired_at =$timestamp = date("Y-m-d H:i:s");
                                        $data['current_datetime'] = $expired_at;
                                        $response =  $this->mainlogin->insert($table,$data);
                                        
                                        $id = $response['insert_id'];
                                        
                                        
                                        $response = array('status' => 200,'message' => 'Employee activity saved '.$id);
                                        json_output($response['status'],$response);       
                        }

                }
	}
        //-------- close send live current lication from app ------//
        
        public function get_coordinator_list(){
            $check_auth_client = $this->LoginModel->check_auth_client();
            if($check_auth_client == true){
                $this->load->library('mainlogin');
                $condition = array('status' => 1);
                $table = "coordinator";
                $resp =  $this->mainlogin->get_detaild_by_conditions($table,$condition);
                json_output(200,array('status' => 200,'data' => $resp));

            }
        }
        
        public function get_project_list(){
            $check_auth_client = $this->LoginModel->check_auth_client();
            if($check_auth_client == true){
                $this->load->library('mainlogin');
                $condition = array('status' => 1);
                $table = "project";
                $resp =  $this->mainlogin->get_detaild_by_conditions($table,$condition);
                json_output(200,array('status' => 200,'data' => $resp));

            }
        }
        
        public function getstate(){
            $method = $_SERVER['REQUEST_METHOD'];
            if($method != 'GET'){
                json_output(400,array('status' => 400,'message' => 'Bad request.'));
            } else {
//               echo $product_id =$this->uri->segment(4);   
               $product_id = $this->input->get('id', TRUE);
                $check_auth_client = $this->MyModel->check_auth_client();
                if($check_auth_client == true){
                    $this->load->library('mainlogin');
                    $resp =  $this->mainlogin->state($product_id); 
                    json_output(200,array('status' => 200,'data' => $resp));
                }
            }
        }
        
        public function getcity() {
            $method = $_SERVER['REQUEST_METHOD'];
            if($method != 'GET'){
                json_output(400,array('status' => 400,'message' => 'Bad request.'));
            } else {
//               echo $product_id =$this->uri->segment(4);   
               $id = $this->input->get('id', TRUE);
                $check_auth_client = $this->MyModel->check_auth_client();
                if($check_auth_client == true){
                    $this->load->library('mainlogin');
                    $resp =  $this->mainlogin->city($id); 
                    json_output(200,array('status' => 200,'data' => $resp));
                }
            }
        }
        
        public function getarea() {
            $method = $_SERVER['REQUEST_METHOD'];
            if($method != 'GET'){
                json_output(400,array('status' => 400,'message' => 'Bad request.'));
            } else {
//               echo $product_id =$this->uri->segment(4);   
               $id = $this->input->get('id', TRUE);
                $check_auth_client = $this->MyModel->check_auth_client();
                if($check_auth_client == true){
                    $this->load->library('mainlogin');
                    $resp =  $this->mainlogin->area($id); 
                    json_output(200,array('status' => 200,'data' => $resp));
                }
            }
        }
        
        public function availability(){
            $check_auth_client = $this->MyModel->check_auth_client();
            if($check_auth_client == true){
                $this->load->library('mainlogin');
                $resp =  $this->mainlogin->pandit_table(); 
                json_output(200,array('status' => 200,'data' => $resp));

            }
        }
        
        public function complete_profile1()
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
                    $check_auth_client = $this->MyModel->check_auth_client();
                    if($check_auth_client == true){
                        $params = $_REQUEST;
                        print_r($params);
//                        $darray
                     echo json_encode($params['image']);
                    }
                }
        }
        
        public function complete_profile()
	{
		$method = $_SERVER['REQUEST_METHOD'];
                
		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
                    $check_auth_client = $this->MyModel->check_auth_client();
                    if($check_auth_client == true){
                        $params = $_REQUEST;
                        echo $admin_id = $params['Admin-ID']; 
                        $data = array();
                        
                        if(isset($params['first_name']) & !empty($params['first_name'])){
                                   $data['first_name'] = $params['first_name']; 
                        }
                        if(isset($params['last_name']) & !empty($params['last_name'])){
                                   $data['last_name'] = $params['last_name']; 
                        }
                        if(isset($params['email']) & !empty($params['email'])){
                                   $data['email'] = $params['email']; 
                        } 
                        if(isset($params['current_address']) & !empty($params['current_address'])){
                                   $data['current_address'] = $params['current_address']; 
                        } 
                        if(isset($params['parmanent_address']) & !empty($params['parmanent_address'])){
                                   $data['parmanent_address'] = $params['parmanent_address']; 
                        }
                        if(isset($params['city']) & !empty($params['city'])){
                                   $data['city'] = $params['city']; 
                        }
//                        $area = $params['area']; 
                        if(isset($params['state']) & !empty($params['state'])){
                                   $data['state'] = $params['state']; 
                        }
                        if(isset($params['country']) & !empty($params['country'])){
                                   $data['country'] = $params['country']; 
                        }
                        if(isset($params['lat']) & !empty($params['lat'])){
                                   $data['lat'] = $params['lat']; 
                        }
                        if(isset($params['lot']) & !empty($params['lot'])){
                                   $data['lot'] = $params['lot']; 
                        } 
                        if(isset($params['availability']) & !empty($params['availability'])){
                                   $data['availability'] = $params['availability']; 
                        } 
                        if(isset($params['qualification']) & !empty($params['qualification'])){
                                   $data['qualification'] = $params['qualification']; 
                        } 
                        if(isset($params['experties']) & !empty($params['experties'])){
                                   $data['experties'] = $params['experties']; 
                        }
                        if(isset($params['image']) & !empty($params['image'])){
                                   $image = $params['image']; 
                                   $image_type = $params['image_type']; 
                        }else{
                            $image = '';
                        }
                        $updated_at = date('Y-m-d H:i:s');
                        $this->load->library('mainlogin');
                        if($image == 'Blank' || $image == 'blank' || $image == ''){
                            $result = array('status' => 401);
                        }else{
                            $directory_path = "pandit_image/";
                            
                           $result =  $this->mainlogin->file_upload($image,$image_type,$directory_path); 
                           print_r($result);
                        }
		        
                        if($result['status'] == 200){
                            $check_image_exist =  $this->mainlogin->admin_image_exist($admin_id); 
                            print_r($check_image_exist);
//                            $check_image_exist = NULL;
                            if($check_image_exist->image != '' || $check_image_exist->image != NULL || $check_image_exist->image != 'blank'){
                                $path = './pandit_image/'.$check_image_exist->image;
//                                unlink($path);
                            }
                            $image_name = $result['image_name'];
                            $image_path = $result['image_path'];
                            $data['image'] = $image_name;
                            $data['updated_at'] = $updated_at;
                            $response =  $this->mainlogin->update_profile($admin_id,$data);
                            if($response['status'] == 200){
                                $resp = $this->mainlogin->admin_details($admin_id);
                                $response = array('status' => 200, 'message' => 'Data has been updated.', 'image_path' => $image_path, 'data' => $resp);
                            }
                            json_output($response['status'],$response);
                        }else{
                            $data['updated_at'] = $updated_at;
                            $response =  $this->mainlogin->update_profile($admin_id,$data);
                            if($response['status'] == 200){
                                $resp = $this->mainlogin->admin_details($admin_id);
                                $response = array('status' => 200, 'message' => 'Data has been updated.','data' => $resp);
                            }
                            json_output($response['status'],$response);
                        }
                    }
		}
	}
        
        public function complete_profile2()
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
                    $check_auth_client = $this->MyModel->check_auth_client();
                    if($check_auth_client == true){
                        $params = $_REQUEST;
                        $admin_id = $params['Admin-ID']; 
                        $first_name = $params['first_name']; 
                        $last_name = $params['last_name']; 
                        $email = $params['email']; 
                        $login_type_id = $params['login_type_id']; 
                        $current_address = $params['current_address']; 
                        $parmanent_address = $params['parmanent_address']; 
                        $area = $params['area']; 
                        $city = $params['city']; 
                        $state = $params['state']; 
                        $country = $params['country']; 
                        $lat = $params['lat']; 
                        $lot = $params['lot'];
                        $image = $params['image']; 
                        $image_type = $params['image_type']; 
                        $availability = $params['availability']; 
                        $qualification = $params['qualification'];
                        $experties = $params['experties'];
                        $this->load->library('mainlogin');
                        if($image == 'Blank' || $image == 'blank' || $image == ''){
                            $result = array('status' => 401);
                        }else{
                           $result =  $this->mainlogin->file_upload($image,$image_type); 
                        }
		        
                        if($result['status'] == 200){
                            $check_image_exist =  $this->mainlogin->admin_image_exist($admin_id); 
                            if($check_image_exist->image != '' || $check_image_exist->image != NULL || $check_image_exist->image != 'blank'){
                                $path = './pandit_image/'.$check_image_exist->image;
//                                unlink($path);
                            }
                            $image_name = $result['image_name'];
                            $image_path = $result['image_path'];
                            $data = array(
                                    'first_name' => $first_name,
                                    'last_name' => $last_name,
                                    'email' => $email,
                                    'current_address' => $current_address,
                                    'parmanent_address' => $parmanent_address,
                                    'city' => $city,
                                    'parmanent_address' => $parmanent_address,
                                    'country' => $country,
                                    'lat' => $lat,
                                    'lot' => $lot,
                                    'image' => $image_name,
                                    'availability' => $availability,
                                    'qualification' => $qualification,
                                    'experties' => $experties,
                                );  
                            $response =  $this->mainlogin->update_profile($admin_id,$data);
                            if($response['status'] == 200){
                                $resp = $this->mainlogin->admin_details($admin_id);
                                $response = array('status' => 200, 'message' => 'Data has been updated.', 'image_path' => $image_path, 'data' => $resp);
                            }
                            json_output($response['status'],$response);
                        }else{
                            $data = array(
                                    'login_type_id' => $login_type_id,
                                    'first_name' => $first_name,
                                    'last_name' => $last_name,
                                    'email' => $email,
                                    'current_address' => $current_address,
                                    'parmanent_address' => $parmanent_address,
                                    'area' => $area,
                                    'city' => $city,
                                    'parmanent_address' => $parmanent_address,
                                    'country' => $country,
                                    'lat' => $lat,
                                    'lot' => $lot,
                                    'availability' => $availability,
                                    'qualification' => $qualification,
                                    'experties' => $experties,
                                );
                            $response =  $this->mainlogin->update_profile($admin_id,$data);
                            if($response['status'] == 200){
                                $resp = $this->mainlogin->admin_details($admin_id);
                                $response = array('status' => 200, 'message' => 'Data has been updated.','data' => $resp);
                            }
                            json_output($response['status'],$response);
                        }
                    }
		}
	}
        
        public function update_current_location(){
            $method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
                    $check_auth_client = $this->MyModel->check_auth_client();
                    if($check_auth_client == true){
                        $params = $_REQUEST;
//                        print_r($params);
                        $admin_id = $params['Admin-ID']; 
                        $current_address = $params['current_address']; 
                        $lat = $params['lat']; 
                        $lot = $params['lot'];
                        $updated_at = date('Y-m-d H:i:s');
                        $table = "pandit_time_availability";
                        $this->load->library('mainlogin');
                        
                            $data = array(
                                    'current_address' => $current_address,
                                    'lat' => $lat,
                                    'lot' => $lot,
                                    'updated_at' => $updated_at,
                                    );
                            $response =  $this->mainlogin->update_profile($admin_id,$data);
                            if($response['status'] == 200){
                                $resp = $this->mainlogin->admin_details($admin_id);
                                $response = array('status' => 200, 'message' => 'Data has been updated.','data' => $resp);
                            }
                            else{
                                $response = array('status' => 400, 'message' => 'Current location can not updated.');
                            }
                            json_output($response['status'],$response);
                    }
                }
        }

        public function change_password(){
            $method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
                    $check_auth_client = $this->MyModel->check_auth_client();
                    if($check_auth_client == true){
                        $this->load->library('mainlogin');
                        $params = $_REQUEST;
//                        print_r($params);
                        $admin_id = $params['Admin-ID']; 
                        $old_password = $params['old_password']; 
                        $new_password = $params['new_password']; 
                        $resp = $this->mainlogin->admin_details($admin_id);
                        $hashed_password = $resp->password;
                        $hashed_password = $this->encryption->decrypt($hashed_password);
                        if($old_password == $hashed_password){
                            $updated_at = date('Y-m-d H:i:s');
                            $this->load->library('mainlogin');
                            $password = $this->encryption->encrypt($new_password);
                            $data = array(
                                'password' => $password,
                                'updated_at' => $updated_at,
                                );
                            $response =  $this->mainlogin->update_profile($admin_id,$data);
                                if($response['status'] == 200){
                                    $response = array('status' => 200, 'message' => 'Password has been updated.');
                                }
                                else{
                                    $response = array('status' => 400, 'message' => 'Password can not updated, Please Try Again!');
                                }
                        }else{
                            
                            $response = array('status' => 400, 'message' => 'Old Password Not Matched.'.$hashed_password);
                        }
                        
                            json_output($response['status'],$response);
                    }
                }
        }
        
        public function pandit_time_availability()
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
                    $check_auth_client = $this->MyModel->check_auth_client();
                    if($check_auth_client == true){
                        $params = $_REQUEST;
//                        print_r($params);
                        $admin_id = $params['Admin-ID']; 
                        $availability = $params['availability']; 
                        $from_time = $params['from_time']; 
                        $to_time = $params['to_time']; 
                        $toTime = explode(',',$to_time);
                        $fromTime = explode(',',$from_time);
                        $table = "pandit_time_availability";
                        $this->load->library('mainlogin');
                        for($i=0;$i<count($fromTime);$i++){
                            $fromtime = $fromTime[$i];
                            $totime = $toTime[$i];
                            $data = array(
                                    'availability' => $availability,
                                    'from_time' => $fromtime,
                                    'to_time' => $totime,
                                    'admin_id' => $admin_id,
                                    );
                            $response =  $this->mainlogin->insert($table,$data);
                        }
                     echo json_encode($response);
                    }
                }
        }
        
        public function pandit_time_availability_list()
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
                    $check_auth_client = $this->MyModel->check_auth_client();
                    if($check_auth_client == true){
                        $params = $_REQUEST;
//                        print_r($params);
                        $admin_id = $params['Admin-ID']; 
                        $availability = $params['availability']; 
                        $data = array(
                            'availability' => $availability,
                            'admin_id' => $admin_id
                        );
                        $table = "pandit_time_availability";
                        $this->load->library('mainlogin');
                        $response =  $this->mainlogin->panditTimeAvailabilityList($table,$data);
                        json_output(200,array('status' => 200,'Data' => $response));
                    }
                }
        }
        
        public function update_pandit_time_availability()
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
                    $check_auth_client = $this->MyModel->check_auth_client();
                    if($check_auth_client == true){
                        $params = $_REQUEST;
//                        print_r($params);
                        $admin_id = $params['Admin-ID']; 
                        $availability = $params['availability']; 
                        $from_time = $params['from_time']; 
                        $to_time = $params['to_time']; 
                        $toTime = explode(',',$to_time);
                        $fromTime = explode(',',$from_time);
                        $delete_data = array(
                            'availability' => $availability,
                            'admin_id' => $admin_id
                        );
                        $this->load->library('mainlogin');
                        $table = "pandit_time_availability";
                        $delete_response =  $this->mainlogin->delete_records($table,$delete_data);
                        if($delete_response['status'] == 200){
                            
                            for($i=0;$i<count($fromTime);$i++){
                                $fromtime = $fromTime[$i];
                                $totime = $toTime[$i];
                                $data = array(
                                        'availability' => $availability,
                                        'from_time' => $fromtime,
                                        'to_time' => $totime,
                                        'admin_id' => $admin_id,
                                        );
                                $response =  $this->mainlogin->insert($table,$data);
                            }
                            $responselist =  $this->mainlogin->panditTimeAvailabilityList($table,$delete_data);
                            json_output(200,array('status' => 200,'Message' => 'Time Updated Successfully','Data' => $responselist));
                        }else{
                            json_output(400,array('status' => 400,'Message' => 'Time can not updated successfully'));
                        }
                        
                    }
                }
        }
        
        public function send_mobile_otp()
	{
            $this->load->library('mainlogin');
            $response =  $this->mainlogin->send_otp();
            $response = str_replace(' ', '', $response);
            $response2 =  $this->mainlogin->send_otp_status($response);
            echo "response = ".$response2;
        }
        
        // check otp message send or not
        public function mobile_otp_status()
	{
            $this->load->library('mainlogin');
            $response =  $this->mainlogin->send_oto_verification();
            $response = str_replace(' ', '', $response);
            $response2 =  $this->mainlogin->send_otp_status($response);
            echo "response = ".$response2;
        }
        
        public function verify_mobile_otp(){
            $method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
                    $check_auth_client = $this->MyModel->check_auth_client();
                    if($check_auth_client == true){
                        $this->load->library('mainlogin');
                        $params = $_REQUEST;
                        $admin_id = $params['Admin-ID']; 
                        $otp = $params['otp'];
                        $table = 'admin';
                        $otp_data = array(
                                            'table' => $table,
                                            'id' => $admin_id,
                                            'otp' => $otp,
                                        );
                        $response =  $this->mainlogin->verify_otp($otp_data);
                         json_output($response['status'],$response);
                    }
                }
        }
        
        // resend otp
        public function resend_mobile_otp()
	{
            $method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
                    $check_auth_client = $this->MyModel->check_auth_client();
                    if($check_auth_client == true){
                        $params = $_REQUEST;
                        $mobile = $params['mobile']; 
                        $id = $params['Admin-ID']; 
                        $table = 'admin';
                        $otp_data = array(
                            'table' => $table,
                            'id' => $id,
                            'mobile' => $mobile,
                        );
                        $this->load->library('mainlogin');
                        $otp_resp = $this->mainlogin->send_otp_verification($otp_data);   
                        $result = array('status' => 200, 'data' =>$otp_resp);
                        json_output($result['status'],$result);
                    }
                }
        }
        
        public function getservice_list() {
            $check_auth_client = $this->MyModel->check_auth_client();
            if($check_auth_client == true){
                
                $this->load->library('mainpooja');
                $resp =  $this->mainpooja->poojaservice_list(); 
                json_output(200,array('status' => 200,'data' => $resp));

            }
        }
        
        public function getpriest_list() {
            $check_auth_client = $this->MyModel->check_auth_client();
            if($check_auth_client == true){
                
                $this->load->library('mainpooja');
                $resp =  $this->mainpooja->priest_list();
                json_output(200,array('status' => 200,'data' => $resp));

            }
        }
        
        // create_priest_pooja_service_pandit_relationship() is used to create relationship between priest, pooja service and pandit
        // thist function created pooja service list for pandit acoording to priest relationship
        public function create_priest_pooja_service_pandit_relationship()
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
                    $check_auth_client = $this->MyModel->check_auth_client();
                    if($check_auth_client == true){
                        $params = $_REQUEST;
//                        print_r($params);
                        $admin_id = $params['Admin-ID']; 
                        $priest_id = $params['priest_id']; 
                        $service_id = $params['service_id']; 
                        $serviceid = explode(',',$service_id);
                        $table = "priest_pooja_service_pandit_relationship";
                        $this->load->library('mainlogin');
                        for($i=0;$i<count($serviceid);$i++){
                            $pooja_service_id = $serviceid[$i];
                            $data = array(
                                    'priest_id' => $priest_id,
                                    'service_id' => $pooja_service_id,
                                    'admin_id' => $admin_id,
                                    );
                            $response =  $this->mainlogin->insert($table,$data);
                        }
                     echo json_encode($response);
                    }
                }
        }
        
        // fetch priest_pooja_service_preist_relationship_list
        public function priest_pooja_service_pandit_relationship_list()
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
                    $check_auth_client = $this->MyModel->check_auth_client();
                    if($check_auth_client == true){
                        $params = $_REQUEST;
                        $admin_id = $params['Admin-ID']; 
                        $this->load->library('mainlogin');
                        // select all unique priest_id from priest_pooja_service_pandit_relationship table to fetch multiple relationship uniquly 
                        $priest_resp =  $this->mainlogin->unique_priest_list_from_priest_pooja_service_pandit_relationship($admin_id);
//                        print_r($priest_resp);
                        $main_resp = array();
                        $main_result = array();
                        if($priest_resp != NULL){
                           for($i=0;$i<count($priest_resp);$i++){
                            $priest_id = $priest_resp[$i]->priest_id;
                            $main_result[$i]['priest_id'] = $priest_id;
                            $main_result[$i]['priest_name'] = $priest_resp[$i]->priest_name_en;
                            $main_resp =  $this->mainlogin->pooja_service_list_from_priest_pooja_service_pandit_relationship($admin_id,$priest_id);
                            $main_result[$i]['services'] = $main_resp;
                            
                        }
                          json_output(200,array('status' => 200,'data' => $main_result, 'count' =>count($priest_resp)));  
                        }else{
                           json_output(400,array('status' => 400,'message' => 'Record Not Found !'));
                        }
                        
                    }
                }
        }
        
        public function poojalist_by_priest_and_service() {
            $method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
                    $check_auth_client = $this->MyModel->check_auth_client();
                    if($check_auth_client == true){
                        $params = $_REQUEST;
//                        print_r($params);
                        $priest_preference_id = $params['priest_preference_id']; 
                        $pooja_service_id = $params['pooja_service_id']; 
                        $this->load->library('mainpooja');
                        $response =  $this->mainpooja->getPoojalist_by_priest_and_service($priest_preference_id,$pooja_service_id);
                        json_output(200,array('status' => 200,'data' => $response));
                    }
                }
//           $qry = "SELECT pooja_list_table.*, priest_preference_pooja_relationship.priest_preference_id FROM pooja_list_table LEFT JOIN priest_preference_pooja_relationship ON pooja_list_table.id = priest_preference_pooja_relationship.pooja_id where pooja_list_table.pooja_service_id = 11 AND priest_preference_pooja_relationship.priest_preference_id = 1"; 
        }
        
        public function create_priest_pooja_pandit_relationship()
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
                    $check_auth_client = $this->MyModel->check_auth_client();
                    if($check_auth_client == true){
                        $params = $_REQUEST;
//                        print_r($params);
                        $admin_id = $params['Admin-ID']; 
                        $priest_preference_pooja_id = $params['priest_preference_pooja_id']; 
                        $contt = count($priest_preference_pooja_id);
                        $table = "priest_pooja_pandit_relationship";
                        $this->load->library('mainlogin');
                        for($i=0; $i<$contt; $i++){
                            $preference_id = $priest_preference_pooja_id[$i];
                            $this->load->library('mainpooja');
                            $resp =  $this->mainpooja->priest_preference_pooja_by_id($preference_id);
                            $data = array(
                                    'priest_preference_pooja_id' => $preference_id,
                                    'pooja_id' => $resp->pooja_id,
                                    );
                            $response =  $this->mainlogin->insert($table,$data);
                        }
                     echo json_encode($response);
                    }
                }
        }
        
        public function get_version(){
            $check_auth_client = $this->LoginModel->check_auth_client();
            if($check_auth_client == true){
                $this->load->library('mainlogin');
                $condition = array('config_name' => 'version');
                $table = "admin_configuration";
                $resp =  $this->mainlogin->get_detaild_by_conditions($table,$condition);
                json_output(200,array('status' => 200,'data' => $resp));

            }
        }
        
        /*-----------insert Preventive Maintenance---------*/     
    public function preventive_maintenance(){
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->LoginModel->check_auth_client();
			if($check_auth_client == true){
				$this->load->library('form_validation');
				$params = $_REQUEST;
				$data = array();
				if(isset($params['emp_id']) && !empty($params['emp_id'])){
					$data['emp_id'] = $params['emp_id'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'employee id is compulsory.'));
					exit();
				}
				if(isset($params['circuit_id']) && !empty($params['circuit_id'])){
					$data['circuit_id'] = $params['circuit_id'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'circuit id is compulsory.'));
					exit();
				}
				if(isset($params['customer_name']) && !empty($params['customer_name'])){
					$data['customer_name'] = $params['customer_name'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'customer name is compulsory.'));
					exit();
				}
				if(isset($params['location']) && !empty($params['location'])){
					$data['location'] = $params['location'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'location is compulsory.'));
					exit();
				}
				$employee_detail=$this->mainlogin->get_detaild_by_conditions('employee',array('emp_id'=>$data['emp_id'],'status'=>1));
				if(empty($employee_detail)){
				    echo json_encode(array('status' => 401,'message' => 'employee id invalid'));
					exit();
				}
				$preventive_maintenance_detail=$this->mainlogin->get_detaild_by_conditions('preventive_maintenance',array('circuit_id'=>$data['circuit_id'],'status'=>1));
				if(!empty($preventive_maintenance_detail)){
				    echo json_encode(array('status' => 401,'message' => 'circuit id already exists'));
					exit();
				}
				$this->load->library('upload');
                if(isset($_FILES['customer_building']['tmp_name'])){
					if (file_exists($_FILES['customer_building']['tmp_name'])){
						$config = array();
						$filename = md5(uniqid(rand(), true)).$_FILES['customer_building']['name'];
						$config['upload_path']   = './preventive_maintenance/';
						$config['allowed_types'] = 'gif|jpg|png|bmp|jpeg|pdf';
						$config['file_name'] = $filename;
						$config['max_size']      = 2048000;
						$this->upload->initialize($config);
						if (!$this->upload->do_upload('customer_building')) {
							$error = array('error' => $this->upload->display_errors());
							$data['error'] = $error;
							json_output(202,array('status' => 401,'message' => $error));
						}else{
							$uploaddata = $this->upload->data();
							$data['customer_building']=$uploaddata['file_name'];
						}
					}
				}
				if(isset($_FILES['customer_rack']['tmp_name'])){
					if (file_exists($_FILES['customer_rack']['tmp_name'])){
						$config = array();
						$filename = md5(uniqid(rand(), true)).$_FILES['customer_rack']['name'];
						$config['upload_path']   = './preventive_maintenance/';
						$config['allowed_types'] = 'gif|jpg|png|bmp|jpeg|pdf';
						$config['file_name'] = $filename;
						$config['max_size']      = 2048000;
						$this->upload->initialize($config);
						if (!$this->upload->do_upload('customer_rack')) {
							$error = array('error' => $this->upload->display_errors());
							$data['error'] = $error;
							json_output(202,array('status' => 401,'message' => $error));
						}else{
							$uploaddata = $this->upload->data();
							$data['customer_rack']=$uploaddata['file_name'];
						}
					}
				}
                if(isset($_FILES['customer_poe']['tmp_name'])){
					if (file_exists($_FILES['customer_poe']['tmp_name'])){
						$config = array();
						$filename = md5(uniqid(rand(), true)).$_FILES['customer_poe']['name'];
						$config['upload_path']   = './preventive_maintenance/';
						$config['allowed_types'] = 'gif|jpg|png|bmp|jpeg|pdf';
						$config['file_name'] = $filename;
						$config['max_size']      = 2048000;
						$this->upload->initialize($config);
						if (!$this->upload->do_upload('customer_poe')) {
							$error = array('error' => $this->upload->display_errors());
							$data['error'] = $error;
							json_output(202,array('status' => 401,'message' => $error));
						}else{
							$uploaddata =$this->upload->data();
							$data['customer_poe']=$uploaddata['file_name'];
						}
					}
				}
				if(isset($_FILES['customer_pole']['tmp_name'])){
					if (file_exists($_FILES['customer_pole']['tmp_name'])){
						$config = array();
						$filename = md5(uniqid(rand(), true)).$_FILES['customer_pole']['name'];
						$config['upload_path']   = './preventive_maintenance/';
						$config['allowed_types'] = 'gif|jpg|png|bmp|jpeg|pdf';
						$config['file_name'] = $filename;
						$config['max_size']      = 2048000;
						$this->upload->initialize($config);
						if (!$this->upload->do_upload('customer_pole')) {
							$error = array('error' => $this->upload->display_errors());
							$data['error'] = $error;
							json_output(202,array('status' => 401,'message' => $error));
						}else{
							$uploaddata = $this->upload->data();
							$data['customer_pole']=$uploaddata['file_name'];
						}
					}
				}
				if(isset($_FILES['tower_picture']['tmp_name'])){
					if (file_exists($_FILES['tower_picture']['tmp_name'])){
						$config = array();
						$filename = md5(uniqid(rand(), true)).$_FILES['tower_picture']['name'];
						$config['upload_path']   = './preventive_maintenance/';
						$config['allowed_types'] = 'gif|jpg|png|bmp|jpeg|pdf';
						$config['file_name'] = $filename;
						$config['max_size']      = 2048000;
						$this->upload->initialize($config);
						if (!$this->upload->do_upload('tower_picture')) {
							$error = array('error' => $this->upload->display_errors());
							$data['error'] = $error;
							json_output(202,array('status' => 401,'message' => $error));
						}else{
							$uploaddata = $this->upload->data();
							$data['tower_picture']=$uploaddata['file_name'];
						}
					}
				}
				if(isset($_FILES['tower_ubr']['tmp_name'])){
					if (file_exists($_FILES['tower_ubr']['tmp_name'])){
						$config = array();
						$filename = md5(uniqid(rand(), true)).$_FILES['tower_ubr']['name'];
						$config['upload_path']   = './preventive_maintenance/';
						$config['allowed_types'] = 'gif|jpg|png|bmp|jpeg|pdf';
						$config['file_name'] = $filename;
						$config['max_size']      = 2048000;
						$this->upload->initialize($config);
						if (!$this->upload->do_upload('tower_ubr')) {
							$error = array('error' => $this->upload->display_errors());
							$data['error'] = $error;
							json_output(202,array('status' => 401,'message' => $error));
						}else{
							$uploaddata = $this->upload->data();
							$data['tower_ubr']=$uploaddata['file_name'];
						}
					}
				}
				if(isset($_FILES['tower_poe']['tmp_name'])){
					if (file_exists($_FILES['tower_poe']['tmp_name'])){
						$config = array();
						$filename = md5(uniqid(rand(), true)).$_FILES['tower_poe']['name'];
						$config['upload_path']   = './preventive_maintenance/';
						$config['allowed_types'] = 'gif|jpg|png|bmp|jpeg|pdf';
						$config['file_name'] = $filename;
						$config['max_size']      = 2048000;
						$this->upload->initialize($config);
						if (!$this->upload->do_upload('tower_poe')) {
							$error = array('error' => $this->upload->display_errors());
							$data['error'] = $error;
							json_output(202,array('status' => 401,'message' => $error));
						}else{
							$uploaddata = $this->upload->data();
							$data['tower_poe']=$uploaddata['file_name'];
						}
					}
				}
				if(isset($_FILES['tower_mcb']['tmp_name'])){
					if (file_exists($_FILES['tower_mcb']['tmp_name'])){
						$config = array();
						$filename = md5(uniqid(rand(), true)).$_FILES['tower_mcb']['name'];
						$config['upload_path']   = './preventive_maintenance/';
						$config['allowed_types'] = 'gif|jpg|png|bmp|jpeg|pdf';
						$config['file_name'] = $filename;
						$config['max_size']      = 2048000;
						$this->upload->initialize($config);
						if (!$this->upload->do_upload('tower_mcb')) {
							$error = array('error' => $this->upload->display_errors());
							$data['error'] = $error;
							json_output(202,array('status' => 401,'message' => $error));
						}else{
							$uploaddata = $this->upload->data();
							$data['tower_mcb']=$uploaddata['file_name'];
						}
					}
				}
				if(isset($_FILES['power_cable']['tmp_name'])){
					if (file_exists($_FILES['power_cable']['tmp_name'])){
						$config = array();
						$filename = md5(uniqid(rand(), true)).$_FILES['power_cable']['name'];
						$config['upload_path']   = './preventive_maintenance/';
						$config['allowed_types'] = 'gif|jpg|png|bmp|jpeg|pdf';
						$config['file_name'] = $filename;
						$config['max_size']      = 2048000;
						$this->upload->initialize($config);
						if (!$this->upload->do_upload('power_cable')) {
							$error = array('error' => $this->upload->display_errors());
							$data['error'] = $error;
							json_output(202,array('status' => 401,'message' => $error));
						}else{
							$uploaddata = $this->upload->data();
							$data['power_cable']=$uploaddata['file_name'];
						}
					}
				}
				if(isset($_FILES['customer_power_parameter1']['tmp_name'])){
					if (file_exists($_FILES['customer_power_parameter1']['tmp_name'])){
						$config = array();
						$filename = md5(uniqid(rand(), true)).$_FILES['customer_power_parameter1']['name'];
						$config['upload_path']   = './preventive_maintenance/';
						$config['allowed_types'] = 'gif|jpg|png|bmp|jpeg|pdf';
						$config['file_name'] = $filename;
						$config['max_size']      = 2048000;
						$this->upload->initialize($config);
						if (!$this->upload->do_upload('customer_power_parameter1')) {
							$error = array('error' => $this->upload->display_errors());
							$data['error'] = $error;
							json_output(202,array('status' => 401,'message' => $error));
						}else{
							$uploaddata = $this->upload->data();
							$data['customer_power_parameter1']=$uploaddata['file_name'];
						}
					}
				}
				if(isset($_FILES['customer_power_parameter2']['tmp_name'])){
					if (file_exists($_FILES['customer_power_parameter2']['tmp_name'])){
						$config = array();
						$filename = md5(uniqid(rand(), true)).$_FILES['customer_power_parameter2']['name'];
						$config['upload_path']   = './preventive_maintenance/';
						$config['allowed_types'] = 'gif|jpg|png|bmp|jpeg|pdf';
						$config['file_name'] = $filename;
						$config['max_size']      = 2048000;
						$this->upload->initialize($config);
						if (!$this->upload->do_upload('customer_power_parameter2')) {
							$error = array('error' => $this->upload->display_errors());
							$data['error'] = $error;
							json_output(202,array('status' => 401,'message' => $error));
						}else{
							$uploaddata = $this->upload->data();
							$data['customer_power_parameter2']=$uploaddata['file_name'];
						}
					}
				}
				if(isset($_FILES['customer_power_parameter3']['tmp_name'])){
					if (file_exists($_FILES['customer_power_parameter3']['tmp_name'])){
						$config = array();
						$filename = md5(uniqid(rand(), true)).$_FILES['customer_power_parameter3']['name'];
						$config['upload_path']   = './preventive_maintenance/';
						$config['allowed_types'] = 'gif|jpg|png|bmp|jpeg|pdf';
						$config['file_name'] = $filename;
						$config['max_size']      = 2048000;
						$this->upload->initialize($config);
						if (!$this->upload->do_upload('customer_power_parameter3')) {
							$error = array('error' => $this->upload->display_errors());
							$data['error'] = $error;
							json_output(202,array('status' => 401,'message' => $error));
						}else{
							$uploaddata = $this->upload->data();
							$data['customer_power_parameter3']=$uploaddata['file_name'];
						}
					}
				}
				if(isset($_FILES['bts_power_parameter1']['tmp_name'])){
					if (file_exists($_FILES['bts_power_parameter1']['tmp_name'])){
						$config = array();
						$filename = md5(uniqid(rand(), true)).$_FILES['bts_power_parameter1']['name'];
						$config['upload_path']   = './preventive_maintenance/';
						$config['allowed_types'] = 'gif|jpg|png|bmp|jpeg|pdf';
						$config['file_name'] = $filename;
						$config['max_size']      = 2048000;
						$this->upload->initialize($config);
						if (!$this->upload->do_upload('bts_power_parameter1')) {
							$error = array('error' => $this->upload->display_errors());
							$data['error'] = $error;
							json_output(202,array('status' => 401,'message' => $error));
						}else{
							$uploaddata = $this->upload->data();
							$data['bts_power_parameter1']=$uploaddata['file_name'];
						}
					}
				}
				if(isset($_FILES['bts_power_parameter2']['tmp_name'])){
					if (file_exists($_FILES['bts_power_parameter2']['tmp_name'])){
						$config = array();
						$filename = md5(uniqid(rand(), true)).$_FILES['bts_power_parameter2']['name'];
						$config['upload_path']   = './preventive_maintenance/';
						$config['allowed_types'] = 'gif|jpg|png|bmp|jpeg|pdf';
						$config['file_name'] = $filename;
						$config['max_size']      = 2048000;
						$this->upload->initialize($config);
						if (!$this->upload->do_upload('bts_power_parameter2')) {
							$error = array('error' => $this->upload->display_errors());
							$data['error'] = $error;
							json_output(202,array('status' => 401,'message' => $error));
						}else{
							$uploaddata =$this->upload->data();
							$data['bts_power_parameter2']=$uploaddata['file_name'];
						}
					}
				}
				if(isset($_FILES['bts_power_parameter3']['tmp_name'])){
					if (file_exists($_FILES['bts_power_parameter3']['tmp_name'])){
						$config = array();
						$filename = md5(uniqid(rand(), true)).$_FILES['bts_power_parameter3']['name'];
						$config['upload_path']   = './preventive_maintenance/';
						$config['allowed_types'] = 'gif|jpg|png|bmp|jpeg|pdf';
						$config['file_name'] = $filename;
						$config['max_size']      = 2048000;
						$this->upload->initialize($config);
						if (!$this->upload->do_upload('bts_power_parameter3')) {
							$error = array('error' => $this->upload->display_errors());
							$data['error'] = $error;
							json_output(202,array('status' => 401,'message' => $error));
						}else{
							$uploaddata = $this->upload->data();
							$data['bts_power_parameter3']=$uploaddata['file_name'];
						}
					}
				}
				if(isset($_FILES['rf_snap']['tmp_name'])){
					if (file_exists($_FILES['rf_snap']['tmp_name'])){
						$config = array();
						$filename = md5(uniqid(rand(), true)).$_FILES['rf_snap']['name'];
						$config['upload_path']   = './preventive_maintenance/';
						$config['allowed_types'] = 'gif|jpg|png|bmp|jpeg|pdf';
						$config['file_name'] = $filename;
						$config['max_size']      = 2048000;
						$this->upload->initialize($config);
						if (!$this->upload->do_upload('rf_snap')) {
							$error = array('error' => $this->upload->display_errors());
							$data['error'] = $error;
							json_output(202,array('status' => 401,'message' => $error));
						}else{
							$uploaddata = $this->upload->data();
							$data['rf_snap']=$uploaddata['file_name'];
						}
					}
				}
				if(isset($_FILES['customer_sign_off']['tmp_name'])){
					if (file_exists($_FILES['customer_sign_off']['tmp_name'])){
						$config = array();
						$filename = md5(uniqid(rand(), true)).$_FILES['customer_sign_off']['name'];
						$config['upload_path']   = './preventive_maintenance/';
						$config['allowed_types'] = 'gif|jpg|png|bmp|jpeg|pdf';
						$config['file_name'] = $filename;
						$config['max_size']      = 2048000;
						$this->upload->initialize($config);
						if (!$this->upload->do_upload('customer_sign_off')) {
							$error = array('error' => $this->upload->display_errors());
							$data['error'] = $error;
							json_output(202,array('status' => 401,'message' => $error));
						}else{
							$uploaddata = $this->upload->data();
							$data['customer_sign_off']=$uploaddata['file_name'];
						}
					}
				}
				date_default_timezone_set('Asia/Kolkata');
				$response =  $this->mainlogin->insert('preventive_maintenance',$data);
				json_output(200,$response);
			}
		}
	}
	/*-----------Close insert Preventive Maintenance---------*/
	
	    /*-----------Preventive Maintenance List---------*/     
    public function preventive_maintenance_list(){
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->LoginModel->check_auth_client();
			if($check_auth_client == true){
				$this->load->library('form_validation');
				$params = $_REQUEST;
				$data = array();
				if(isset($params['emp_id']) && !empty($params['emp_id'])){
					$data['emp_id'] = $params['emp_id'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'employee id is compulsory.'));
					exit();
				}
				if(isset($params['date']) && !empty($params['date'])){
					$data['date_time>='] = date('Y-m-d',strtotime($params['date'])).' 00:00:00';
					$data['date_time<='] = date('Y-m-d',strtotime($params['date'])).' 23:59:59';
				}
				$resp =  $this->mainlogin->get_detaild_by_conditions('preventive_maintenance',$data);
				if(!empty($resp)){
				    $resp=array_reverse($resp);
				}else{
				    $resp=array();
				}
                json_output(200,array('status' => 200,'data_array' => $resp,'image_url'=>base_url('preventive_maintenance/')));
			}
		}
    }
	/*-----------Close Preventive Maintenance List---------*/
	
	/*-----------Network Diagram---------*/     
    public function network_diagram(){
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->LoginModel->check_auth_client();
			if($check_auth_client == true){
				$this->load->library('form_validation');
				$params = $_REQUEST;
				$data = array();
				if(isset($params['emp_id']) && !empty($params['emp_id'])){
					$data['emp_id'] = $params['emp_id'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'employee id is compulsory.'));
					exit();
				}
				if(isset($params['circuit_id']) && !empty($params['circuit_id'])){
					$data['circuit_id'] = $params['circuit_id'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'circuit id is compulsory.'));
					exit();
				}
				if(isset($params['customer_name']) && !empty($params['customer_name'])){
					$data['customer_name'] = $params['customer_name'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'customer name is compulsory.'));
					exit();
				}
				if(isset($params['location']) && !empty($params['location'])){
					$data['location'] = $params['location'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'location is compulsory.'));
					exit();
				}
				$employee_detail=$this->mainlogin->get_detaild_by_conditions('employee',array('emp_id'=>$data['emp_id'],'status'=>1));
				if(empty($employee_detail)){
				    echo json_encode(array('status' => 401,'message' => 'employee id invalid'));
					exit();
				}
				$preventive_maintenance_detail=$this->mainlogin->get_detaild_by_conditions('network_diagram',array('circuit_id'=>$data['circuit_id'],'status'=>1));
				if(!empty($preventive_maintenance_detail)){
				    echo json_encode(array('status' => 401,'message' => 'circuit id already exists'));
					exit();
				}
				$this->load->library('upload');
                if(isset($_FILES['customer_signoff']['tmp_name'])){
					if (file_exists($_FILES['customer_signoff']['tmp_name'])){
						$config = array();
						$filename = md5(uniqid(rand(), true)).$_FILES['customer_signoff']['name'];
						$config['upload_path']   = './network_diagram/';
						$config['allowed_types'] = 'gif|jpg|png|bmp|jpeg|pdf';
						$config['file_name'] = $filename;
						$config['max_size']      = 2048000;
						$this->upload->initialize($config);
						if (!$this->upload->do_upload('customer_signoff')) {
							$error = array('error' => $this->upload->display_errors());
							$data['error'] = $error;
							json_output(202,array('status' => 401,'message' => $error));
							exit();
						}else{
							$uploaddata =$this->upload->data();
							$data['customer_signoff']=$uploaddata['file_name'];
						}
					}
				}
				date_default_timezone_set('Asia/Kolkata');
				$response =  $this->mainlogin->insert('network_diagram',$data);
				json_output(200,$response);
			}
		}
	}
	/*-----------Close Network Diagram---------*/ 
	
	/*-----------Network Diagram List---------*/     
    public function network_diagram_list(){
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->LoginModel->check_auth_client();
			if($check_auth_client == true){
				$this->load->library('form_validation');
				$params = $_REQUEST;
				$data = array();
				if(isset($params['emp_id']) && !empty($params['emp_id'])){
					$data['emp_id'] = $params['emp_id'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'employee id is compulsory.'));
					exit();
				}
				if(isset($params['date']) && !empty($params['date'])){
					$data['date_time>='] = date('Y-m-d',strtotime($params['date'])).' 00:00:00';
					$data['date_time<='] = date('Y-m-d',strtotime($params['date'])).' 23:59:59';
				}
				$resp =  $this->mainlogin->get_detaild_by_conditions('network_diagram',$data);
				if(!empty($resp)){
				    $resp=array_reverse($resp);
				}else{
				    $resp=array();
				}
                json_output(200,array('status' => 200,'data_array' => $resp,'image_url'=>base_url('network_diagram/')));
			}
		}
    }
	/*-----------Close Network Diagram List---------*/
	/*----------start cpe survey-------------------*/
	public function insert_cpe_survey(){
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->LoginModel->check_auth_client();
			if($check_auth_client == true){
				$this->load->library('form_validation');
				$this->load->library('upload');
				$params = $_REQUEST;
				$data = array();
				if(isset($params['emp_id']) && !empty($params['emp_id'])){
					$data['emp_id'] = $params['emp_id'];
					if($this->mainlogin->check_user_exist('employee',$data)==FALSE){
						json_output(401,array('status' => 401,'message' => 'invalid employee id.'));
						return;
					}
				}else{
					json_output(401,array('status' => 401,'message' => 'employee id is compulsory.'));
					return;
				}
				if(isset($params['circuit_id_or_ticket_id']) && !empty($params['circuit_id_or_ticket_id'])){
					$data['circuit_id_or_ticket_id'] = $params['circuit_id_or_ticket_id'];
					if($this->mainlogin->check_user_exist('cpe_survey',array('circuit_id_or_ticket_id'=>$data['circuit_id_or_ticket_id']))==TRUE){
						json_output(401,array('status' => 401,'message' => 'circuit id or ticket id already exists'));
						return;
					}
				}else{
					json_output(401,array('status' => 401,'message' => 'circuit id or ticket id is compulsory.'));
					return;
				}
				if(isset($params['no_of_bts']) && !empty($params['no_of_bts']) || isset($params['no_of_bts']) &&  $params['no_of_bts']==0 && strlen($params['no_of_bts'])>0){
					$data['no_of_bts'] = $params['no_of_bts'];
				}else{
					json_output(401,array('status' => 401,'message' => 'no of bts is compulsory.'));
					return;
				}
				if(isset($params['site_a_name']) && !empty($params['site_a_name'])){
					$data['site_a_name'] = $params['site_a_name'];
				}else{
					json_output(401,array('status' => 401,'message' => 'site a name is compulsory.'));
					return;
				}
				if(isset($params['site_a_id']) && !empty($params['site_a_id'])){
					$data['site_a_id'] = $params['site_a_id'];
				}else{
					json_output(401,array('status' => 401,'message' => 'site a id is compulsory.'));
					return;
				}
				if(isset($params['site_a_address']) && !empty($params['site_a_address'])){
					$data['site_a_address'] = $params['site_a_address'];
				}else{
					json_output(401,array('status' => 401,'message' => 'site a address is compulsory.'));
					return;
				}
				if(isset($params['customer_name']) && !empty($params['customer_name'])){
					$data['customer_name'] = $params['customer_name'];
				}else{
					json_output(401,array('status' => 401,'message' => 'customer name is compulsory.'));
					return;
				}
				$data['survey_date']=date('Y-m-d');
				if(isset($params['field_engineer_name']) && !empty($params['field_engineer_name'])){
					$data['field_engineer_name'] = $params['field_engineer_name'];
				}else{
					json_output(401,array('status' => 401,'message' => 'field engineer name is compulsory.'));
					return;
				}
				if(isset($params['latitude_longitude']) && !empty($params['latitude_longitude'])){
					$data['latitude_longitude'] = $params['latitude_longitude'];
				}else{
					json_output(401,array('status' => 401,'message' => 'latitude longitude is compulsory.'));
					return;
				}
				if(isset($params['amsl']) && !empty($params['amsl'])){
					$data['amsl'] = $params['amsl'];
				}else{
					json_output(401,array('status' => 401,'message' => 'amsl is compulsory.'));
					return;
				}
				if(isset($params['az_angle']) && !empty($params['az_angle'])){
					$data['az_angle'] = $params['az_angle'];
				}else{
					json_output(401,array('status' => 401,'message' => 'az angle is compulsory.'));
					return;
				}
				if(isset($params['structure']) && !empty($params['structure'])){
					$data['structure'] = $params['structure'];
				}else{
					json_output(401,array('status' => 401,'message' => 'structure is compulsory.'));
					return;
				}
				if(isset($params['tower_base']) && !empty($params['tower_base'])){
					$data['tower_base'] = $params['tower_base'];
				}else{
					json_output(401,array('status' => 401,'message' => 'tower base is compulsory.'));
					return;
				}
				if(isset($params['building_height_numeric']) && !empty($params['building_height_numeric'])){
					$data['building_height_numeric'] = $params['building_height_numeric'];
				}else{
					json_output(401,array('status' => 401,'message' => 'building height numeric is compulsory.'));
					return;
				}
				if(isset($params['required_mast_height']) && !empty($params['required_mast_height'])){
					$data['required_mast_height'] = $params['required_mast_height'];
				}else{
					json_output(401,array('status' => 401,'message' => 'required mast height is compulsory.'));
					return;
				}
				if(isset($params['mast_type']) && !empty($params['mast_type'])){
					$data['mast_type'] = $params['mast_type'];
				}else{
					json_output(401,array('status' => 401,'message' => 'mast type is compulsory.'));
					return;
				}
				if(isset($params['detail_or_height_of_existing_mast']) && !empty($params['detail_or_height_of_existing_mast'])){
					$data['detail_or_height_of_existing_mast'] = $params['detail_or_height_of_existing_mast'];
				}
				if(isset($params['parent_bts_name_or_id']) && !empty($params['parent_bts_name_or_id'])){
					$data['parent_bts_name_or_id'] = $params['parent_bts_name_or_id'];
				}else{
					json_output(401,array('status' => 401,'message' => 'parent bts name or id is compulsory.'));
					return;
				}
				if(isset($params['antenna_mounting_height']) && !empty($params['antenna_mounting_height'])){
					$data['antenna_mounting_height'] = $params['antenna_mounting_height'];
				}else{
					json_output(401,array('status' => 401,'message' => 'antenna mounting height is compulsory.'));
					return;
				}
				if(isset($params['cable_length']) && !empty($params['cable_length'])){
					$data['cable_length'] = $params['cable_length'];
				}else{
					json_output(401,array('status' => 401,'message' => 'cable length is compulsory.'));
					return;
				}
				if(isset($params['cable_duct']) && !empty($params['cable_duct'])){
					$data['cable_duct'] = $params['cable_duct'];
				}else{
					json_output(401,array('status' => 401,'message' => 'cable duct is compulsory.'));
					return;
				}
				if(isset($params['earthing_availability']) && !empty($params['earthing_availability'])){
					$data['earthing_availability'] = $params['earthing_availability'];
				}else{
					json_output(401,array('status' => 401,'message' => 'earthing availability is compulsory.'));
					return;
				}
				if(isset($params['customer_ups_earthing']) && !empty($params['customer_ups_earthing'])){
					$data['customer_ups_earthing'] = $params['customer_ups_earthing'];
				}else{
					json_output(401,array('status' => 401,'message' => 'customer ups earthing is compulsory.'));
					return;
				}
				if(isset($params['area_required_for_mast_pole']) && !empty($params['area_required_for_mast_pole'])){
					$data['area_required_for_mast_pole'] = $params['area_required_for_mast_pole'];
				}else{
					json_output(401,array('status' => 401,'message' => 'area required for mast pole is compulsory.'));
					return;
				}
				if(isset($params['area_available_for_mast_pole']) && !empty($params['area_available_for_mast_pole'])){
					$data['area_available_for_mast_pole'] = $params['area_available_for_mast_pole'];
				}else{
					json_output(401,array('status' => 401,'message' => 'area available for mast pole is compulsory.'));
					return;
				}
				if(isset($params['msc_availability']) && !empty($params['msc_availability'])){
					$data['msc_availability'] = $params['msc_availability'];
				}else{
					json_output(401,array('status' => 401,'message' => 'msc availability is compulsory.'));
					return;
				}
				if(isset($params['rack_on_floor']) && !empty($params['rack_on_floor'])){
					$data['rack_on_floor'] = $params['rack_on_floor'];
				}else{
					json_output(401,array('status' => 401,'message' => 'rack on floor is compulsory.'));
					return;
				}
				if(isset($params['los_obstruction_details']) && !empty($params['los_obstruction_details'])){
					$data['los_obstruction_details'] = $params['los_obstruction_details'];
				}
				if(isset($params['comment_remark']) && !empty($params['comment_remark'])){
					$data['comment_remark'] = $params['comment_remark'];
				}
				if(isset($_FILES['customer_building']['tmp_name'])){
					if (file_exists($_FILES['customer_building']['tmp_name'])){
						$config = array();
						$filename = md5(uniqid(rand(), true)).$_FILES['customer_building']['name'];
						$config['upload_path']   = './cpe_survey/';
						$config['allowed_types'] = 'jpg|png|bmp|jpeg';
						$config['file_name'] = $filename;
						$config['max_size']      = 2048000;
						$this->upload->initialize($config);
						if (!$this->upload->do_upload('customer_building')) {
							$error = array('error' => $this->upload->display_errors());
							$data['error'] = $error;
							json_output(202,array('status' => 401,'message' => $error));
							return;
						}else{
							$uploaddata = $this->upload->data();
							$data['customer_building']=$uploaddata['file_name'];
						}
					}
				}
				if(isset($_FILES['existing_structure']['tmp_name'])){
					if (file_exists($_FILES['existing_structure']['tmp_name'])){
						$config = array();
						$filename = md5(uniqid(rand(), true)).$_FILES['existing_structure']['name'];
						$config['upload_path']   = './cpe_survey/';
						$config['allowed_types'] = 'jpg|png|bmp|jpeg';
						$config['file_name'] = $filename;
						$config['max_size']      = 2048000;
						$this->upload->initialize($config);
						if (!$this->upload->do_upload('existing_structure')) {
							$error = array('error' => $this->upload->display_errors());
							$data['error'] = $error;
							json_output(202,array('status' => 401,'message' => $error));
							return;
						}else{
							$uploaddata = $this->upload->data();
							$data['existing_structure']=$uploaddata['file_name'];
						}
					}
				}
				if(isset($_FILES['pole_location']['tmp_name'])){
					if (file_exists($_FILES['pole_location']['tmp_name'])){
						$config = array();
						$filename = md5(uniqid(rand(), true)).$_FILES['pole_location']['name'];
						$config['upload_path']   = './cpe_survey/';
						$config['allowed_types'] = 'jpg|png|bmp|jpeg';
						$config['file_name'] = $filename;
						$config['max_size']      = 2048000;
						$this->upload->initialize($config);
						if (!$this->upload->do_upload('pole_location')) {
							$error = array('error' => $this->upload->display_errors());
							$data['error'] = $error;
							json_output(202,array('status' => 401,'message' => $error));
							return;
						}else{
							$uploaddata = $this->upload->data();
							$data['pole_location']=$uploaddata['file_name'];
						}
					}
				}
				/*if(isset($_FILES['panoramic_snap']['tmp_name'])){
					if (file_exists($_FILES['panoramic_snap']['tmp_name'])){
						$config = array();
						$filename = md5(uniqid(rand(), true)).$_FILES['panoramic_snap']['name'];
						$config['upload_path']   = './cpe_survey/';
						$config['allowed_types'] = 'jpg|png|bmp|jpeg';
						$config['file_name'] = $filename;
						$config['max_size']      = 2048000;
						$this->upload->initialize($config);
						if (!$this->upload->do_upload('panoramic_snap')) {
							$error = array('error' => $this->upload->display_errors());
							$data['error'] = $error;
							json_output(202,array('status' => 401,'message' => $error));
							return;
						}else{
							$uploaddata = $this->upload->data();
							$data['panoramic_snap']=$uploaddata['file_name'];
						}
					}
				}*/
				$filenames = array();
				if(isset($_FILES['panoramic_snap']) && !empty($_FILES['panoramic_snap'])){
				    // var_dump($_FILES);
				    $countfiles = count($_FILES['panoramic_snap']['name']);
				    for($i=0;$i<$countfiles;$i++){
				        if(!empty($_FILES['panoramic_snap']['name'][$i])){
				            $_FILES['file']['name'] = $_FILES['panoramic_snap']['name'][$i];
				            $_FILES['file']['type'] = $_FILES['panoramic_snap']['type'][$i];
				            $_FILES['file']['tmp_name'] = $_FILES['panoramic_snap']['tmp_name'][$i];
				            $_FILES['file']['error'] = $_FILES['panoramic_snap']['error'][$i];
				            $_FILES['file']['size'] = $_FILES['panoramic_snap']['size'][$i];
				            $config = array();
				            $filename = md5(uniqid(rand(), true)).$_FILES['panoramic_snap']['name'][$i];
				            $config['upload_path']   = './cpe_survey/';
				            $config['allowed_types'] = 'jpg|png|bmp|jpeg';
				            $config['file_name'] = $filename;
				            $config['max_size']      = 2048000;
				            $this->upload->initialize($config);
				            if($this->upload->do_upload('file')){
				                $uploadData = $this->upload->data();
				                $filename = $uploadData['file_name'];
				                $filenames[] = $filename;
				            }else{
				                json_output(401,array('status' => 401,'message' =>$this->upload->display_errors()));
				                return;
				            }
				        }
				    }
				    $data['panoramic_snap']=implode(',',$filenames);
				}
				if(isset($_FILES['server_room']['tmp_name'])){
					if (file_exists($_FILES['server_room']['tmp_name'])){
						$config = array();
						$filename = md5(uniqid(rand(), true)).$_FILES['server_room']['name'];
						$config['upload_path']   = './cpe_survey/';
						$config['allowed_types'] = 'jpg|png|bmp|jpeg';
						$config['file_name'] = $filename;
						$config['max_size']      = 2048000;
						$this->upload->initialize($config);
						if (!$this->upload->do_upload('server_room')) {
							$error = array('error' => $this->upload->display_errors());
							$data['error'] = $error;
							json_output(202,array('status' => 401,'message' => $error));
							return;
						}else{
							$uploaddata = $this->upload->data();
							$data['server_room']=$uploaddata['file_name'];
						}
					}
				}
				$res=$this->mainlogin->insert('cpe_survey',$data);
				json_output($res['status'],$res);
			}
		}
	}
	/*----------close cpe survey-------------------*/
	
	/*----------close bts survey-------------------*/
	public function insert_bts_survey(){
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->LoginModel->check_auth_client();
			if($check_auth_client == true){
				$this->load->library('form_validation');
				$this->load->library('upload');
				$params = $_REQUEST;
				$data = array();
				if(isset($params['emp_id']) && !empty($params['emp_id'])){
					$data['emp_id'] = $params['emp_id'];
					if($this->mainlogin->check_user_exist('employee',$data)==FALSE){
						json_output(401,array('status' => 401,'message' => 'invalid employee id.'));
						return;
					}
				}else{
					json_output(401,array('status' => 401,'message' => 'employee id is compulsory.'));
					return;
				}
				if(isset($params['cpe_survey_id']) && !empty($params['cpe_survey_id'])){
					$data['cpe_survey_id'] = $params['cpe_survey_id'];
				}else{
					json_output(401,array('status' => 401,'message' => 'cpe survey id is compulsory.'));
					return;
				}
				if(isset($params['bts_form_no']) && !empty($params['bts_form_no'])){
					$data['bts_form_no'] = $params['bts_form_no'];
				}else{
					json_output(401,array('status' => 401,'message' => 'bts form no is compulsory.'));
					return;
				}
				if(isset($params['site_b_name']) && !empty($params['site_b_name'])){
					$data['site_b_name'] = $params['site_b_name'];
				}else{
					json_output(401,array('status' => 401,'message' => 'site b name is compulsory.'));
					return;
				}
				if(isset($params['site_b_id']) && !empty($params['site_b_id'])){
					$data['site_b_id'] = $params['site_b_id'];
					if($this->mainlogin->check_user_exist('bts_survey',array('site_b_id'=>$data['site_b_id']))==TRUE){
						json_output(401,array('status' => 401,'message' => 'site b id already exists'));
						return;
					}
				}else{
					json_output(401,array('status' => 401,'message' => 'site b id is compulsory.'));
					return;
				}
				if(isset($params['site_b_address']) && !empty($params['site_b_address'])){
					$data['site_b_address'] = $params['site_b_address'];
				}else{
					json_output(401,array('status' => 401,'message' => 'site b address is compulsory.'));
					return;
				}
				if(isset($params['parent_bts_name_address_id']) && !empty($params['parent_bts_name_address_id'])){
					$data['parent_bts_name_address_id'] = $params['parent_bts_name_address_id'];
				}else{
					json_output(401,array('status' => 401,'message' => 'parent bts name address id is compulsory.'));
					return;
				}
				
				if(isset($params['latitude_longitude']) && !empty($params['latitude_longitude'])){
					$data['latitude_longitude'] = $params['latitude_longitude'];
				}else{
					json_output(401,array('status' => 401,'message' => 'latitude longitude is compulsory.'));
					return;
				}
				if(isset($params['amsl']) && !empty($params['amsl'])){
					$data['amsl'] = $params['amsl'];
				}else{
					json_output(401,array('status' => 401,'message' => 'amsl is compulsory.'));
					return;
				}
				if(isset($params['az_angle']) && !empty($params['az_angle'])){
					$data['az_angle'] = $params['az_angle'];
				}else{
					json_output(401,array('status' => 401,'message' => 'az angle is compulsory.'));
					return;
				}
				if(isset($params['building_height']) && !empty($params['building_height'])){
					$data['building_height'] = $params['building_height'];
				}else{
					json_output(401,array('status' => 401,'message' => 'building height is compulsory.'));
					return;
				}
				if(isset($params['tower_base']) && !empty($params['tower_base'])){
					$data['tower_base'] = $params['tower_base'];
				}
				if(isset($params['bts_name_id']) && !empty($params['bts_name_id'])){
					$data['bts_name_id'] = $params['bts_name_id'];
				}else{
					json_output(401,array('status' => 401,'message' => 'bts name id is compulsory.'));
					return;
				}
				if(isset($params['antenna_mounting_height']) && !empty($params['antenna_mounting_height'])){
					$data['antenna_mounting_height'] = $params['antenna_mounting_height'];
				}else{
					json_output(401,array('status' => 401,'message' => 'antenna mounting height is compulsory.'));
					return;
				}
				if(isset($params['cable_length']) && !empty($params['cable_length'])){
					$data['cable_length'] = $params['cable_length'];
				}else{
					json_output(401,array('status' => 401,'message' => 'cable length is compulsory.'));
					return;
				}
				if(isset($params['cable_duct']) && !empty($params['cable_duct'])){
					$data['cable_duct'] = $params['cable_duct'];
				}else{
					json_output(401,array('status' => 401,'message' => 'cable duct is compulsory.'));
					return;
				}
				if(isset($params['space_available_for_idu']) && !empty($params['space_available_for_idu'])){
					$data['space_available_for_idu'] = $params['space_available_for_idu'];
				}else{
					json_output(401,array('status' => 401,'message' => 'space available for idu is compulsory.'));
					return;
				}
				if(isset($params['power_available_for_idu_check_box']) && !empty($params['power_available_for_idu_check_box'])){
					$data['power_available_for_idu_check_box'] = $params['power_available_for_idu_check_box'];
				}else{
					json_output(401,array('status' => 401,'message' => 'power available for idu check box is compulsory.'));
					return;
				}
				if(isset($params['comments_remarks']) && !empty($params['comments_remarks'])){
					$data['comments_remarks'] = $params['comments_remarks'];
				}/*else{
					json_output(401,array('status' => 401,'message' => 'comments remarks is compulsory.'));
					return;
				}*/
				
				if(isset($_FILES['comments_remarks']['tmp_name'])){
					if (file_exists($_FILES['comments_remarks']['tmp_name'])){
						$config = array();
						$filename = md5(uniqid(rand(), true)).$_FILES['comments_remarks']['name'];
						$config['upload_path']   = './bts_survey/';
						$config['allowed_types'] = 'jpg|png|bmp|jpeg';
						$config['file_name'] = $filename;
						$config['max_size']      = 2048000;
						$this->upload->initialize($config);
						if (!$this->upload->do_upload('comments_remarks')) {
							$error = array('error' => $this->upload->display_errors());
							$data['error'] = $error;
							json_output(202,array('status' => 401,'message' => $error));
							return;
						}else{
							$uploaddata = $this->upload->data();
							$data['comments_remarks']=$uploaddata['file_name'];
						}
					}
				}
				if(isset($_FILES['full_tower_snap']['tmp_name'])){
					if (file_exists($_FILES['full_tower_snap']['tmp_name'])){
						$config = array();
						$filename = md5(uniqid(rand(), true)).$_FILES['full_tower_snap']['name'];
						$config['upload_path']   = './bts_survey/';
						$config['allowed_types'] = 'jpg|png|bmp|jpeg';
						$config['file_name'] = $filename;
						$config['max_size']      = 2048000;
						$this->upload->initialize($config);
						if (!$this->upload->do_upload('full_tower_snap')) {
							$error = array('error' => $this->upload->display_errors());
							$data['error'] = $error;
							json_output(202,array('status' => 401,'message' => $error));
							return;
						}else{
							$uploaddata = $this->upload->data();
							$data['full_tower_snap']=$uploaddata['file_name'];
						}
					}
				}
				if(isset($_FILES['shelter_snap_open']['tmp_name'])){
					if (file_exists($_FILES['shelter_snap_open']['tmp_name'])){
						$config = array();
						$filename = md5(uniqid(rand(), true)).$_FILES['shelter_snap_open']['name'];
						$config['upload_path']   = './bts_survey/';
						$config['allowed_types'] = 'jpg|png|bmp|jpeg';
						$config['file_name'] = $filename;
						$config['max_size']      = 2048000;
						$this->upload->initialize($config);
						if (!$this->upload->do_upload('shelter_snap_open')) {
							$error = array('error' => $this->upload->display_errors());
							$data['error'] = $error;
							json_output(202,array('status' => 401,'message' => $error));
							return;
						}else{
							$uploaddata = $this->upload->data();
							$data['shelter_snap_open']=$uploaddata['file_name'];
						}
					}
				}
				if(isset($_FILES['shelter_snap_close']['tmp_name'])){
					if (file_exists($_FILES['shelter_snap_close']['tmp_name'])){
						$config = array();
						$filename = md5(uniqid(rand(), true)).$_FILES['shelter_snap_close']['name'];
						$config['upload_path']   = './bts_survey/';
						$config['allowed_types'] = 'jpg|png|bmp|jpeg';
						$config['file_name'] = $filename;
						$config['max_size']      = 2048000;
						$this->upload->initialize($config);
						if (!$this->upload->do_upload('shelter_snap_close')) {
							$error = array('error' => $this->upload->display_errors());
							$data['error'] = $error;
							json_output(202,array('status' => 401,'message' => $error));
							return;
						}else{
							$uploaddata = $this->upload->data();
							$data['shelter_snap_close']=$uploaddata['file_name'];
						}
					}
				}
				if(isset($_FILES['boundary_wall']['tmp_name'])){
					if (file_exists($_FILES['boundary_wall']['tmp_name'])){
						$config = array();
						$filename = md5(uniqid(rand(), true)).$_FILES['boundary_wall']['name'];
						$config['upload_path']   = './bts_survey/';
						$config['allowed_types'] = 'jpg|png|bmp|jpeg';
						$config['file_name'] = $filename;
						$config['max_size']      = 2048000;
						$this->upload->initialize($config);
						if (!$this->upload->do_upload('boundary_wall')) {
							$error = array('error' => $this->upload->display_errors());
							$data['error'] = $error;
							json_output(202,array('status' => 401,'message' => $error));
							return;
						}else{
							$uploaddata = $this->upload->data();
							$data['boundary_wall']=$uploaddata['file_name'];
						}
					}
				}
				if(isset($_FILES['tower_base_image']['tmp_name'])){
					if (file_exists($_FILES['tower_base_image']['tmp_name'])){
						$config = array();
						$filename = md5(uniqid(rand(), true)).$_FILES['tower_base_image']['name'];
						$config['upload_path']   = './bts_survey/';
						$config['allowed_types'] = 'jpg|png|bmp|jpeg';
						$config['file_name'] = $filename;
						$config['max_size']      = 2048000;
						$this->upload->initialize($config);
						if (!$this->upload->do_upload('tower_base_image')) {
							$error = array('error' => $this->upload->display_errors());
							$data['error'] = $error;
							json_output(202,array('status' => 401,'message' => $error));
							return;
						}else{
							$uploaddata = $this->upload->data();
							$data['tower_base_image']=$uploaddata['file_name'];
						}
					}
				}
				/*if(isset($_FILES['panoramic_snap']['tmp_name'])){
					if (file_exists($_FILES['panoramic_snap']['tmp_name'])){
						$config = array();
						$filename = md5(uniqid(rand(), true)).$_FILES['panoramic_snap']['name'];
						$config['upload_path']   = './bts_survey/';
						$config['allowed_types'] = 'jpg|png|bmp|jpeg';
						$config['file_name'] = $filename;
						$config['max_size']      = 2048000;
						$this->upload->initialize($config);
						if (!$this->upload->do_upload('panoramic_snap')) {
							$error = array('error' => $this->upload->display_errors());
							$data['error'] = $error;
							json_output(202,array('status' => 401,'message' => $error));
							return;
						}else{
							$uploaddata = $this->upload->data();
							$data['panoramic_snap']=$uploaddata['file_name'];
						}
					}
				}*/
				$filenames = array();
				if(isset($_FILES['panoramic_snap']) && !empty($_FILES['panoramic_snap'])){
				    // var_dump($_FILES);
				    $countfiles = count($_FILES['panoramic_snap']['name']);
				    for($i=0;$i<$countfiles;$i++){
				        if(!empty($_FILES['panoramic_snap']['name'][$i])){
				            $_FILES['file']['name'] = $_FILES['panoramic_snap']['name'][$i];
				            $_FILES['file']['type'] = $_FILES['panoramic_snap']['type'][$i];
				            $_FILES['file']['tmp_name'] = $_FILES['panoramic_snap']['tmp_name'][$i];
				            $_FILES['file']['error'] = $_FILES['panoramic_snap']['error'][$i];
				            $_FILES['file']['size'] = $_FILES['panoramic_snap']['size'][$i];
				            $config = array();
				            $filename = md5(uniqid(rand(), true)).$_FILES['panoramic_snap']['name'][$i];
				            $config['upload_path']   = './bts_survey/';
				            $config['allowed_types'] = 'jpg|png|bmp|jpeg';
				            $config['file_name'] = $filename;
				            $config['max_size']      = 2048000;
				            $this->upload->initialize($config);
				            if($this->upload->do_upload('file')){
				                $uploadData = $this->upload->data();
				                $filename = $uploadData['file_name'];
				                $filenames[] = $filename;
				            }else{
				                json_output(401,array('status' => 401,'message' =>$this->upload->display_errors()));
				                return;
				            }
				        }
				    }
				    $data['panoramic_snap']=implode(',',$filenames);
				}
				if(isset($_FILES['rack']['tmp_name'])){
					if (file_exists($_FILES['rack']['tmp_name'])){
						$config = array();
						$filename = md5(uniqid(rand(), true)).$_FILES['rack']['name'];
						$config['upload_path']   = './bts_survey/';
						$config['allowed_types'] = 'jpg|png|bmp|jpeg';
						$config['file_name'] = $filename;
						$config['max_size']      = 2048000;
						$this->upload->initialize($config);
						if (!$this->upload->do_upload('rack')) {
							$error = array('error' => $this->upload->display_errors());
							$data['error'] = $error;
							json_output(202,array('status' => 401,'message' => $error));
							return;
						}else{
							$uploaddata = $this->upload->data();
							$data['rack']=$uploaddata['file_name'];
						}
					}
				}
				if(isset($_FILES['smps']['tmp_name'])){
					if (file_exists($_FILES['smps']['tmp_name'])){
						$config = array();
						$filename = md5(uniqid(rand(), true)).$_FILES['smps']['name'];
						$config['upload_path']   = './bts_survey/';
						$config['allowed_types'] = 'jpg|png|bmp|jpeg';
						$config['file_name'] = $filename;
						$config['max_size']      = 2048000;
						$this->upload->initialize($config);
						if (!$this->upload->do_upload('smps')) {
							$error = array('error' => $this->upload->display_errors());
							$data['error'] = $error;
							json_output(202,array('status' => 401,'message' => $error));
							return;
						}else{
							$uploaddata = $this->upload->data();
							$data['smps']=$uploaddata['file_name'];
						}
					}
				}
				if(isset($_FILES['earthing_bar']['tmp_name'])){
					if (file_exists($_FILES['earthing_bar']['tmp_name'])){
						$config = array();
						$filename = md5(uniqid(rand(), true)).$_FILES['earthing_bar']['name'];
						$config['upload_path']   = './bts_survey/';
						$config['allowed_types'] = 'jpg|png|bmp|jpeg';
						$config['file_name'] = $filename;
						$config['max_size']      = 2048000;
						$this->upload->initialize($config);
						if (!$this->upload->do_upload('earthing_bar')) {
							$error = array('error' => $this->upload->display_errors());
							$data['error'] = $error;
							json_output(202,array('status' => 401,'message' => $error));
							return;
						}else{
							$uploaddata = $this->upload->data();
							$data['earthing_bar']=$uploaddata['file_name'];
						}
					}
				}
				if(isset($_FILES['ac']['tmp_name'])){
					if (file_exists($_FILES['ac']['tmp_name'])){
						$config = array();
						$filename = md5(uniqid(rand(), true)).$_FILES['ac']['name'];
						$config['upload_path']   = './bts_survey/';
						$config['allowed_types'] = 'jpg|png|bmp|jpeg';
						$config['file_name'] = $filename;
						$config['max_size']      = 2048000;
						$this->upload->initialize($config);
						if (!$this->upload->do_upload('ac')) {
							$error = array('error' => $this->upload->display_errors());
							$data['error'] = $error;
							json_output(202,array('status' => 401,'message' => $error));
							return;
						}else{
							$uploaddata = $this->upload->data();
							$data['ac']=$uploaddata['file_name'];
						}
					}
				}
				if(isset($_FILES['battery']['tmp_name'])){
					if (file_exists($_FILES['battery']['tmp_name'])){
						$config = array();
						$filename = md5(uniqid(rand(), true)).$_FILES['battery']['name'];
						$config['upload_path']   = './bts_survey/';
						$config['allowed_types'] = 'jpg|png|bmp|jpeg';
						$config['file_name'] = $filename;
						$config['max_size']      = 2048000;
						$this->upload->initialize($config);
						if (!$this->upload->do_upload('battery')) {
							$error = array('error' => $this->upload->display_errors());
							$data['error'] = $error;
							json_output(202,array('status' => 401,'message' => $error));
							return;
						}else{
							$uploaddata = $this->upload->data();
							$data['battery']=$uploaddata['file_name'];
						}
					}
				}
				if(isset($_FILES['generator']['tmp_name'])){
					if (file_exists($_FILES['generator']['tmp_name'])){
						$config = array();
						$filename = md5(uniqid(rand(), true)).$_FILES['generator']['name'];
						$config['upload_path']   = './bts_survey/';
						$config['allowed_types'] = 'jpg|png|bmp|jpeg';
						$config['file_name'] = $filename;
						$config['max_size']      = 2048000;
						$this->upload->initialize($config);
						if (!$this->upload->do_upload('generator')) {
							$error = array('error' => $this->upload->display_errors());
							$data['error'] = $error;
							json_output(202,array('status' => 401,'message' => $error));
							return;
						}else{
							$uploaddata = $this->upload->data();
							$data['generator']=$uploaddata['file_name'];
						}
					}
				}
				$res=$this->mainlogin->insert('bts_survey',$data);
				$data1=array('cpe_survey_id'=>$data['cpe_survey_id']);
				$resp =  $this->mainlogin->get_detaild_by_conditions('cpe_survey',$data1);
				if(!empty($resp)){
				    $resp=$resp[0];
				    $bts_array=$this->mainlogin->get_detaild_by_conditions('bts_survey',array('cpe_survey_id'=>$data['cpe_survey_id']));
				    if(empty($bts_array)){
				        $bts_array=array();
				    }
				    $res['remaining']=$resp->no_of_bts-count($bts_array);
				    json_output($res['status'],$res);
				}else{
				    json_output(400,array('status'=>400,'message'=>'Somthing wrong'));
				}
			}
		}
	}
	/*----------close bts survey-------------------*/
    public function employee_details() {
            $method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->LoginModel->check_auth_client();
			if($check_auth_client == true){
                $params = $_REQUEST;
                if(isset($params['emp_id']) && !empty($params['emp_id'])){
					$condition = array(
                        'emp_id' => $params['emp_id'],
                    );
				}else{
					json_output(401,array('status' => 401,'message' => 'employee id is compulsory.'));
					return;
				}
                $condition2 = array(
                    'status' => 1
                );
                $table = "employee";
                $emp_resp =  $this->mainlogin->sit_survey_details_by_condition($table,$condition);
                if(empty($emp_resp)){
                    json_output(401,array('status' => 401,'message' => 'invalid emp_id.'));
					return;
                }
                $table2 = "employee_salary";
                $salary_resp =  $this->mainlogin->sit_expense_details_by_condition($table2,$condition);
                $table3 = "employee_bank_details";
                $bank_resp =  $this->mainlogin->sit_expense_details_by_condition($table3,$condition);
                /*$table4 = "department";
                $department_resp =  $this->mainlogin->get_detaild_by_conditions($table4,$condition2);
                $table5 = "designation";
                $designation_resp =  $this->mainlogin->get_detaild_by_conditions($table5,$condition2);
                $table6 = "technology";
                $technology_resp =  $this->mainlogin->get_detaild_by_conditions($table6,$condition2);*/
                $data=$emp_resp[0];
                if(!empty($salary_resp)){
                    foreach($salary_resp[0] as $key=>$val){
                        $data->$key=$val;
                    }
                }
                if($bank_resp){
                    foreach($bank_resp[0] as $key=>$val){
                        $data->$key=$val;
                    }
                }
                $data1=array(
                    'status'=>200,
                    'data'=>$data
                );
                //$data['data'].=$salary_resp[0];
                
                json_output($data1['status'],$data1);
                //$this->load->view('employee_details',$data);
			}
		}
    }
    
    public function insert_musk_bts(){
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->LoginModel->check_auth_client();
			if($check_auth_client == true){
				$this->load->library('form_validation');
				$this->load->library('upload');
				$params = $_REQUEST;
				$data = array();
				if(isset($params['emp_id']) && !empty($params['emp_id'])){
					$data['emp_id'] = $params['emp_id'];
					if($this->mainlogin->check_user_exist('employee',$data)==FALSE){
						json_output(401,array('status' => 401,'message' => 'invalid employee id.'));
						return;
					}
				}else{
					json_output(401,array('status' => 401,'message' => 'employee id is compulsory.'));
					return;
				}
				if(isset($params['circuit_id_ticket_id']) && !empty($params['circuit_id_ticket_id'])){
					$data['circuit_id_ticket_id'] = $params['circuit_id_ticket_id'];
					if($this->mainlogin->check_user_exist('musk_bts',array('circuit_id_ticket_id'=>$data['circuit_id_ticket_id']))==TRUE){
						json_output(401,array('status' => 401,'message' => 'circuit id or ticket id already exists'));
						return;
					}
				}else{
					json_output(401,array('status' => 401,'message' => 'circuit id or ticket id is compulsory.'));
					return;
				}
				if(isset($params['site_name']) && !empty($params['site_name'])){
					$data['site_name'] = $params['site_name'];
				}else{
					json_output(401,array('status' => 401,'message' => 'site name is compulsory.'));
					return;
				}
				if(isset($params['site_id']) && !empty($params['site_id'])){
					$data['site_id'] = $params['site_id'];
				}else{
					json_output(401,array('status' => 401,'message' => 'site id is compulsory.'));
					return;
				}
				if(isset($params['site_address']) && !empty($params['site_address'])){
					$data['site_address'] = $params['site_address'];
				}else{
					json_output(401,array('status' => 401,'message' => 'site address is compulsory.'));
					return;
				}
				if(isset($params['parent_bts_name_address_id']) && !empty($params['parent_bts_name_address_id'])){
					$data['parent_bts_name_address_id'] = $params['parent_bts_name_address_id'];
				}else{
					json_output(401,array('status' => 401,'message' => 'parent bts name address id is compulsory.'));
					return;
				}
				if(isset($params['customer_name']) && !empty($params['customer_name'])){
					$data['customer_name'] = $params['customer_name'];
				}else{
					json_output(401,array('status' => 401,'message' => 'customer name is compulsory.'));
					return;
				}
				if(isset($params['field_engineer_name']) && !empty($params['field_engineer_name'])){
					$data['field_engineer_name'] = $params['field_engineer_name'];
				}else{
					json_output(401,array('status' => 401,'message' => 'field engineer name is compulsory.'));
					return;
				}
				$data['survey_date']=date('Y-m-d');
				if(isset($params['customer_name']) && !empty($params['customer_name'])){
					$data['customer_name'] = $params['customer_name'];
				}else{
					json_output(401,array('status' => 401,'message' => 'customer name is compulsory.'));
					return;
				}
				
				if(isset($params['latitude_longitude']) && !empty($params['latitude_longitude'])){
					$data['latitude_longitude'] = $params['latitude_longitude'];
				}else{
					json_output(401,array('status' => 401,'message' => 'latitude longitude is compulsory.'));
					return;
				}
				if(isset($params['amsl']) && !empty($params['amsl'])){
					$data['amsl'] = $params['amsl'];
				}else{
					json_output(401,array('status' => 401,'message' => 'amsl is compulsory.'));
					return;
				}
				if(isset($params['az_angle']) && !empty($params['az_angle'])){
					$data['az_angle'] = $params['az_angle'];
				}else{
					json_output(401,array('status' => 401,'message' => 'az angle is compulsory.'));
					return;
				}
				if(isset($params['building_height']) && !empty($params['building_height'])){
					$data['building_height'] = $params['building_height'];
				}else{
					json_output(401,array('status' => 401,'message' => 'building height is compulsory.'));
					return;
				}
				if(isset($params['tower_base']) && !empty($params['tower_base'])){
					$data['tower_base'] = $params['tower_base'];
				}
				if(isset($params['bts_name_id']) && !empty($params['bts_name_id'])){
					$data['bts_name_id_varchar'] = $params['bts_name_id'];
				}
				if(isset($params['antenna_mounting_height']) && !empty($params['antenna_mounting_height'])){
					$data['antenna_mounting_height'] = $params['antenna_mounting_height'];
				}else{
					json_output(401,array('status' => 401,'message' => 'antenna mounting height is compulsory.'));
					return;
				}
				if(isset($params['cable_length']) && !empty($params['cable_length'])){
					$data['cable_length'] = $params['cable_length'];
				}else{
					json_output(401,array('status' => 401,'message' => 'cable length is compulsory.'));
					return;
				}
				if(isset($params['cable_duct']) && !empty($params['cable_duct'])){
					$data['cable_duct'] = $params['cable_duct'];
				}else{
					json_output(401,array('status' => 401,'message' => 'cable duct is compulsory.'));
					return;
				}
				if(isset($params['space_available_for_idu']) && !empty($params['space_available_for_idu'])){
					$data['space_available_for_idu'] = $params['space_available_for_idu'];
				}else{
					json_output(401,array('status' => 401,'message' => 'space available for idu is compulsory.'));
					return;
				}
				if(isset($params['power_available_for_idu_check_box']) && !empty($params['power_available_for_idu_check_box'])){
					$data['power_available_for_idu_check_box'] = $params['power_available_for_idu_check_box'];
				}else{
					json_output(401,array('status' => 401,'message' => 'power available for idu check box is compulsory.'));
					return;
				}
				if(isset($params['comments_remarks']) && !empty($params['comments_remarks'])){
					$data['comments_remarks'] = $params['comments_remarks'];
				}/*else{
					json_output(401,array('status' => 401,'message' => 'comments remarks is compulsory.'));
					return;
				}*/
				
				if(isset($_FILES['comments_remarks']['tmp_name'])){
					if (file_exists($_FILES['comments_remarks']['tmp_name'])){
						$config = array();
						$filename = md5(uniqid(rand(), true)).$_FILES['comments_remarks']['name'];
						$config['upload_path']   = './musk_bts/';
						$config['allowed_types'] = 'jpg|png|bmp|jpeg';
						$config['file_name'] = $filename;
						$config['max_size']      = 2048000;
						$this->upload->initialize($config);
						if (!$this->upload->do_upload('comments_remarks')) {
							$error = array('error' => $this->upload->display_errors());
							$data['error'] = $error;
							json_output(202,array('status' => 401,'message' => $error));
							return;
						}else{
							$uploaddata = $this->upload->data();
							$data['comments_remarks']=$uploaddata['file_name'];
						}
					}
				}
				if(isset($_FILES['full_tower_snap']['tmp_name'])){
					if (file_exists($_FILES['full_tower_snap']['tmp_name'])){
						$config = array();
						$filename = md5(uniqid(rand(), true)).$_FILES['full_tower_snap']['name'];
						$config['upload_path']   = './musk_bts/';
						$config['allowed_types'] = 'jpg|png|bmp|jpeg';
						$config['file_name'] = $filename;
						$config['max_size']      = 2048000;
						$this->upload->initialize($config);
						if (!$this->upload->do_upload('full_tower_snap')) {
							$error = array('error' => $this->upload->display_errors());
							$data['error'] = $error;
							json_output(202,array('status' => 401,'message' => $error));
							return;
						}else{
							$uploaddata = $this->upload->data();
							$data['full_tower_snap']=$uploaddata['file_name'];
						}
					}
				}
				if(isset($_FILES['shelter_snap_open']['tmp_name'])){
					if (file_exists($_FILES['shelter_snap_open']['tmp_name'])){
						$config = array();
						$filename = md5(uniqid(rand(), true)).$_FILES['shelter_snap_open']['name'];
						$config['upload_path']   = './musk_bts/';
						$config['allowed_types'] = 'jpg|png|bmp|jpeg';
						$config['file_name'] = $filename;
						$config['max_size']      = 2048000;
						$this->upload->initialize($config);
						if (!$this->upload->do_upload('shelter_snap_open')) {
							$error = array('error' => $this->upload->display_errors());
							$data['error'] = $error;
							json_output(202,array('status' => 401,'message' => $error));
							return;
						}else{
							$uploaddata = $this->upload->data();
							$data['shelter_snap_open']=$uploaddata['file_name'];
						}
					}
				}
				if(isset($_FILES['shelter_snap_close']['tmp_name'])){
					if (file_exists($_FILES['shelter_snap_close']['tmp_name'])){
						$config = array();
						$filename = md5(uniqid(rand(), true)).$_FILES['shelter_snap_close']['name'];
						$config['upload_path']   = './musk_bts/';
						$config['allowed_types'] = 'jpg|png|bmp|jpeg';
						$config['file_name'] = $filename;
						$config['max_size']      = 2048000;
						$this->upload->initialize($config);
						if (!$this->upload->do_upload('shelter_snap_close')) {
							$error = array('error' => $this->upload->display_errors());
							$data['error'] = $error;
							json_output(202,array('status' => 401,'message' => $error));
							return;
						}else{
							$uploaddata = $this->upload->data();
							$data['shelter_snap_close']=$uploaddata['file_name'];
						}
					}
				}
				if(isset($_FILES['boundary_wall']['tmp_name'])){
					if (file_exists($_FILES['boundary_wall']['tmp_name'])){
						$config = array();
						$filename = md5(uniqid(rand(), true)).$_FILES['boundary_wall']['name'];
						$config['upload_path']   = './musk_bts/';
						$config['allowed_types'] = 'jpg|png|bmp|jpeg';
						$config['file_name'] = $filename;
						$config['max_size']      = 2048000;
						$this->upload->initialize($config);
						if (!$this->upload->do_upload('boundary_wall')) {
							$error = array('error' => $this->upload->display_errors());
							$data['error'] = $error;
							json_output(202,array('status' => 401,'message' => $error));
							return;
						}else{
							$uploaddata = $this->upload->data();
							$data['boundary_wall']=$uploaddata['file_name'];
						}
					}
				}
				if(isset($_FILES['tower_base_image']['tmp_name'])){
					if (file_exists($_FILES['tower_base_image']['tmp_name'])){
						$config = array();
						$filename = md5(uniqid(rand(), true)).$_FILES['tower_base_image']['name'];
						$config['upload_path']   = './musk_bts/';
						$config['allowed_types'] = 'jpg|png|bmp|jpeg';
						$config['file_name'] = $filename;
						$config['max_size']      = 2048000;
						$this->upload->initialize($config);
						if (!$this->upload->do_upload('tower_base_image')) {
							$error = array('error' => $this->upload->display_errors());
							$data['error'] = $error;
							json_output(202,array('status' => 401,'message' => $error));
							return;
						}else{
							$uploaddata = $this->upload->data();
							$data['tower_base_image']=$uploaddata['file_name'];
						}
					}
				}
				/*if(isset($_FILES['panoramic_snap']['tmp_name'])){
					if (file_exists($_FILES['panoramic_snap']['tmp_name'])){
						$config = array();
						$filename = md5(uniqid(rand(), true)).$_FILES['panoramic_snap']['name'];
						$config['upload_path']   = './musk_bts/';
						$config['allowed_types'] = 'jpg|png|bmp|jpeg';
						$config['file_name'] = $filename;
						$config['max_size']      = 2048000;
						$this->upload->initialize($config);
						if (!$this->upload->do_upload('panoramic_snap')) {
							$error = array('error' => $this->upload->display_errors());
							$data['error'] = $error;
							json_output(202,array('status' => 401,'message' => $error));
							return;
						}else{
							$uploaddata = $this->upload->data();
							$data['panoramic_snap']=$uploaddata['file_name'];
						}
					}
				}*/
				$filenames = array();
				if(isset($_FILES['panoramic_snap']) && !empty($_FILES['panoramic_snap'])){
				    // var_dump($_FILES);
				    $countfiles = count($_FILES['panoramic_snap']['name']);
				    for($i=0;$i<$countfiles;$i++){
				        if(!empty($_FILES['panoramic_snap']['name'][$i])){
				            $_FILES['file']['name'] = $_FILES['panoramic_snap']['name'][$i];
				            $_FILES['file']['type'] = $_FILES['panoramic_snap']['type'][$i];
				            $_FILES['file']['tmp_name'] = $_FILES['panoramic_snap']['tmp_name'][$i];
				            $_FILES['file']['error'] = $_FILES['panoramic_snap']['error'][$i];
				            $_FILES['file']['size'] = $_FILES['panoramic_snap']['size'][$i];
				            $config = array();
				            $filename = md5(uniqid(rand(), true)).$_FILES['panoramic_snap']['name'][$i];
				            $config['upload_path']   = './musk_bts/';
				            $config['allowed_types'] = 'jpg|png|bmp|jpeg';
				            $config['file_name'] = $filename;
				            $config['max_size']      = 2048000;
				            $this->upload->initialize($config);
				            if($this->upload->do_upload('file')){
				                $uploadData = $this->upload->data();
				                $filename = $uploadData['file_name'];
				                $filenames[] = $filename;
				            }else{
				                json_output(401,array('status' => 401,'message' =>$this->upload->display_errors()));
				                return;
				            }
				        }
				    }
				    $data['panoramic_snap']=implode(',',$filenames);
				}
				if(isset($_FILES['rack']['tmp_name'])){
					if (file_exists($_FILES['rack']['tmp_name'])){
						$config = array();
						$filename = md5(uniqid(rand(), true)).$_FILES['rack']['name'];
						$config['upload_path']   = './musk_bts/';
						$config['allowed_types'] = 'jpg|png|bmp|jpeg';
						$config['file_name'] = $filename;
						$config['max_size']      = 2048000;
						$this->upload->initialize($config);
						if (!$this->upload->do_upload('rack')) {
							$error = array('error' => $this->upload->display_errors());
							$data['error'] = $error;
							json_output(202,array('status' => 401,'message' => $error));
							return;
						}else{
							$uploaddata = $this->upload->data();
							$data['rack']=$uploaddata['file_name'];
						}
					}
				}
				if(isset($_FILES['smps']['tmp_name'])){
					if (file_exists($_FILES['smps']['tmp_name'])){
						$config = array();
						$filename = md5(uniqid(rand(), true)).$_FILES['smps']['name'];
						$config['upload_path']   = './musk_bts/';
						$config['allowed_types'] = 'jpg|png|bmp|jpeg';
						$config['file_name'] = $filename;
						$config['max_size']      = 2048000;
						$this->upload->initialize($config);
						if (!$this->upload->do_upload('smps')) {
							$error = array('error' => $this->upload->display_errors());
							$data['error'] = $error;
							json_output(202,array('status' => 401,'message' => $error));
							return;
						}else{
							$uploaddata = $this->upload->data();
							$data['smps']=$uploaddata['file_name'];
						}
					}
				}
				if(isset($_FILES['earthing_bar']['tmp_name'])){
					if (file_exists($_FILES['earthing_bar']['tmp_name'])){
						$config = array();
						$filename = md5(uniqid(rand(), true)).$_FILES['earthing_bar']['name'];
						$config['upload_path']   = './musk_bts/';
						$config['allowed_types'] = 'jpg|png|bmp|jpeg';
						$config['file_name'] = $filename;
						$config['max_size']      = 2048000;
						$this->upload->initialize($config);
						if (!$this->upload->do_upload('earthing_bar')) {
							$error = array('error' => $this->upload->display_errors());
							$data['error'] = $error;
							json_output(202,array('status' => 401,'message' => $error));
							return;
						}else{
							$uploaddata = $this->upload->data();
							$data['earthing_bar']=$uploaddata['file_name'];
						}
					}
				}
				if(isset($_FILES['ac']['tmp_name'])){
					if (file_exists($_FILES['ac']['tmp_name'])){
						$config = array();
						$filename = md5(uniqid(rand(), true)).$_FILES['ac']['name'];
						$config['upload_path']   = './musk_bts/';
						$config['allowed_types'] = 'jpg|png|bmp|jpeg';
						$config['file_name'] = $filename;
						$config['max_size']      = 2048000;
						$this->upload->initialize($config);
						if (!$this->upload->do_upload('ac')) {
							$error = array('error' => $this->upload->display_errors());
							$data['error'] = $error;
							json_output(202,array('status' => 401,'message' => $error));
							return;
						}else{
							$uploaddata = $this->upload->data();
							$data['ac']=$uploaddata['file_name'];
						}
					}
				}
				if(isset($_FILES['battery']['tmp_name'])){
					if (file_exists($_FILES['battery']['tmp_name'])){
						$config = array();
						$filename = md5(uniqid(rand(), true)).$_FILES['battery']['name'];
						$config['upload_path']   = './musk_bts/';
						$config['allowed_types'] = 'jpg|png|bmp|jpeg';
						$config['file_name'] = $filename;
						$config['max_size']      = 2048000;
						$this->upload->initialize($config);
						if (!$this->upload->do_upload('battery')) {
							$error = array('error' => $this->upload->display_errors());
							$data['error'] = $error;
							json_output(202,array('status' => 401,'message' => $error));
							return;
						}else{
							$uploaddata = $this->upload->data();
							$data['battery']=$uploaddata['file_name'];
						}
					}
				}
				if(isset($_FILES['generator']['tmp_name'])){
					if (file_exists($_FILES['generator']['tmp_name'])){
						$config = array();
						$filename = md5(uniqid(rand(), true)).$_FILES['generator']['name'];
						$config['upload_path']   = './musk_bts/';
						$config['allowed_types'] = 'jpg|png|bmp|jpeg';
						$config['file_name'] = $filename;
						$config['max_size']      = 2048000;
						$this->upload->initialize($config);
						if (!$this->upload->do_upload('generator')) {
							$error = array('error' => $this->upload->display_errors());
							$data['error'] = $error;
							json_output(202,array('status' => 401,'message' => $error));
							return;
						}else{
							$uploaddata = $this->upload->data();
							$data['generator']=$uploaddata['file_name'];
						}
					}
				}
				$res=$this->mainlogin->insert('musk_bts',$data);
				json_output($res['status'],$res);
			}
		}
	}
	
	public function ubr_form_list(){
	    $method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->LoginModel->check_auth_client();
			if($check_auth_client == true){
			    $params = $_REQUEST;
				$data = array();
				if(isset($params['emp_id']) && !empty($params['emp_id'])){
					$data['emp_id'] = $params['emp_id'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'employee id is compulsory.'));
					exit();
				}
				$resp =  $this->mainlogin->get_detaild_by_conditions('cpe_survey',$data);
				if(!empty($resp)){
				    $resp=array_reverse($resp);
				    foreach($resp as $key=>$val){
				        $cpe_images=array();
				        $i=0;
				        foreach($val as $key1=>$val1){
				            if(str_replace('_'," ",$key1)!='panoramic snap'){
				            $imageFileType = strtolower(pathinfo($val1,PATHINFO_EXTENSION));
				            $cpe_image=(object)array();
				            if($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif" ) {
				                $cpe_image->name =str_replace('_'," ",$key1);
				                $cpe_image->image_name=$val1;
				                $cpe_images[$i]=$cpe_image;
				                $i++;
				            }
				            }
				        }
				        $bts_array=$this->mainlogin->get_detaild_by_conditions('bts_survey',array('cpe_survey_id'=>$val->cpe_survey_id));
				        foreach($bts_array as $key2=>$val2){
				            $bts_images=array();
				            $i=0;
				            foreach($val2 as $key3=>$val3){
				                $imageFileType = strtolower(pathinfo($val3,PATHINFO_EXTENSION));
				                if($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif" ) {
				                    $bts_image=(object)array();
				                    $bts_image->name =str_replace('_'," ",$key3);
    				                $bts_image->image_name=$val3;
    				                $bts_images[$i]=$bts_image;
    				                $i++;
				                }
				            }
				            $bts_array[$key2]->bts_images=$bts_images;
				        }
				        $resp[$key]->cpe_images=$cpe_images;
				        $resp[$key]->bts_array=$bts_array;
				    }
				}else{
				    $resp=array();
				}
				json_output(200,array('status' => 200,'data_array' => $resp,'cpe_url'=>base_url('cpe_survey/'),'bts_url'=>base_url('bts_survey/')));
			}
		}
	}
	
	public function musk_bts_list(){
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->LoginModel->check_auth_client();
			if($check_auth_client == true){
			    $params = $_REQUEST;
				$data = array();
				if(isset($params['emp_id']) && !empty($params['emp_id'])){
					$data['emp_id'] = $params['emp_id'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'employee id is compulsory.'));
					return;
				}
				if(isset($params['date']) && !empty($params['date'])){
					$data['survey_date'] = date('Y-m-d',strtotime($params['date']));
				}
				$resp =  $this->mainlogin->get_detaild_by_conditions('musk_bts',$data);
				if(!empty($resp)){
				    $resp=array_reverse($resp);
				    foreach($resp as $key=>$val){
				        $musk_bts_images=array();
				        $i=0;
				        foreach($val as $key1=>$val1){
				            $imageFileType = strtolower(pathinfo($val1,PATHINFO_EXTENSION));
				            $musk_bts_image=(object)array();
				            if($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif" ) {
				                $musk_bts_image->name =str_replace('_'," ",$key1);
				                $musk_bts_image->image_name=$val1;
				                $musk_bts_images[$i]=$musk_bts_image;
				                $i++;
				            }
				        }
				        $resp[$key]->cpe_images=$musk_bts_images;
				    }
				}else{
				    $resp=array();
				}
				json_output(200,array('status' => 200,'data_array' => $resp,'cpe_url'=>base_url('musk_bts/')));
			}
		}
	}
	
	public function insert_i_and_c(){
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->LoginModel->check_auth_client();
			if($check_auth_client == true){
				$this->load->library('form_validation');
				$this->load->library('upload');
				$params = $_REQUEST;
				$data = array();
				if(isset($params['emp_id']) && !empty($params['emp_id'])){
					$data['emp_id'] = $params['emp_id'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'emp_id is compulsory.'));
					return;
				}
				if(isset($params['ticket_id_circuit_id']) && !empty($params['ticket_id_circuit_id'])){
					$data['ticket_id_circuit_id'] = $params['ticket_id_circuit_id'];
					if($this->mainlogin->check_user_exist('i_and_c',array('ticket_id_circuit_id'=>$data['ticket_id_circuit_id']))==TRUE){
						json_output(401,array('status' => 401,'message' => 'ticket id and circuit id already exists'));
						return;
					}
				}else{
					echo json_encode(array('status' => 401,'message' => 'ticket_id_circuit_id is compulsory.'));
					return;
				}
				if(isset($params['customer']) && !empty($params['customer'])){
					$data['customer'] = $params['customer'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'customer is compulsory.'));
					return;
				}
				if(isset($params['site_a_name']) && !empty($params['site_a_name'])){
					$data['site_a_name'] = $params['site_a_name'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'site_a_name is compulsory.'));
					return;
				}
				if(isset($params['site_a_id']) && !empty($params['site_a_id'])){
					$data['site_a_id'] = $params['site_a_id'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'site_a_id is compulsory.'));
					return;
				}
				if(isset($params['site_b_name']) && !empty($params['site_b_name'])){
					$data['site_b_name'] = $params['site_b_name'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'site_b_name is compulsory.'));
					return;
				}
				if(isset($params['site_b_id']) && !empty($params['site_b_id'])){
					$data['site_b_id'] = $params['site_b_id'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'site_b_id is compulsory.'));
					return;
				}
				if(isset($params['location']) && !empty($params['location'])){
					$data['location'] = $params['location'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'location is compulsory.'));
					return;
				}
				if(isset($params['link_type']) && !empty($params['link_type'])){
					$data['link_type'] = $params['link_type'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'link_type is compulsory.'));
					return;
				}
				if(isset($params['link_site_down_reason']) && !empty($params['link_site_down_reason'])){
					$data['link_site_down_reason'] = $params['link_site_down_reason'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'link_site_down_reason is compulsory.'));
					return;
				}
				if(isset($params['equipment_type']) && !empty($params['equipment_type'])){
					$data['equipment_type'] = $params['equipment_type'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'equipment_type is compulsory.'));
					return;
				}
				$data['inc_visit_date']=date('Y-m-d');
				if(isset($params['height_of_pole_mast']) && !empty($params['height_of_pole_mast'])){
					$data['height_of_pole_mast'] = $params['height_of_pole_mast'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'height_of_pole_mast is compulsory.'));
					return;
				}
				if(isset($params['ip_details']) && !empty($params['ip_details'])){
					$data['ip_details'] = $params['ip_details'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'ip_details is compulsory.'));
					return;
				}
				if(isset($params['equipment_serial_number']) && !empty($params['equipment_serial_number'])){
					$data['equipment_serial_number'] = $params['equipment_serial_number'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'equipment_serial_number is compulsory.'));
					return;
				}
				if(isset($params['pole_mast_installed_by_us']) && !empty($params['pole_mast_installed_by_us'])){
					$data['pole_mast_installed_by_us'] = $params['pole_mast_installed_by_us'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'pole_mast_installed_by_us is compulsory.'));
					return;
				}
				if(isset($params['basic_hygiene_at_site']) && !empty($params['basic_hygiene_at_site'])){
					$data['basic_hygiene_at_site'] = $params['basic_hygiene_at_site'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'basic_hygiene_at_site is compulsory.'));
					return;
				}
				if(isset($params['total_ubr_installed_at_sites']) && !empty($params['total_ubr_installed_at_sites'])){
					$data['total_ubr_installed_at_sites'] = $params['total_ubr_installed_at_sites'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'total_ubr_installed_at_sites is compulsory.'));
					return;
				}
				if(isset($params['achieved_rssi']) && !empty($params['achieved_rssi'])){
					$data['achieved_rssi'] = $params['achieved_rssi'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'achieved_rssi is compulsory.'));
					return;
				}
				if(isset($params['quantity_of_cat_6_cable_used']) && !empty($params['quantity_of_cat_6_cable_used'])){
					$data['quantity_of_cat_6_cable_used'] = $params['quantity_of_cat_6_cable_used'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'quantity_of_cat_6_cable_used is compulsory.'));
					return;
				}
				if(isset($params['quantity_of_power_cable_used']) && !empty($params['quantity_of_power_cable_used'])){
					$data['quantity_of_power_cable_used'] = $params['quantity_of_power_cable_used'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'quantity_of_power_cable_used is compulsory.'));
					return;
				}
				if(isset($params['quantity_of_earthing_cable_used']) && !empty($params['quantity_of_earthing_cable_used'])){
					$data['quantity_of_earthing_cable_used'] = $params['quantity_of_earthing_cable_used'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'quantity_of_earthing_cable_used is compulsory.'));
					return;
				}
				if(isset($params['replaced_material_during_maintenance']) && !empty($params['replaced_material_during_maintenance'])){
					$data['replaced_material_during_maintenance'] = $params['replaced_material_during_maintenance'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'replaced_material_during_maintenance is compulsory.'));
					return;
				}
				if(isset($params['any_other_material']) && !empty($params['any_other_material'])){
					$data['any_other_material'] = $params['any_other_material'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'any_other_material is compulsory.'));
					return;
				}
				if(isset($_FILES['image_of_basic_hygiene_at_site']['tmp_name'])){
					if (file_exists($_FILES['image_of_basic_hygiene_at_site']['tmp_name'])){
						$config = array();
						$filename = md5(uniqid(rand(), true)).$_FILES['image_of_basic_hygiene_at_site']['name'];
						$config['upload_path']   = './i_and_c/';
						$config['allowed_types'] = 'jpg|png|bmp|jpeg';
						$config['file_name'] = $filename;
						$config['max_size']      = 2048000;
						$this->upload->initialize($config);
						if (!$this->upload->do_upload('image_of_basic_hygiene_at_site')) {
							$error = array('error' => $this->upload->display_errors());
							$data['error'] = $error;
							json_output(202,array('status' => 401,'message' => $error));
							return;
						}else{
							$uploaddata = $this->upload->data();
							$data['image_of_basic_hygiene_at_site']=$uploaddata['file_name'];
						}
					}
				}
				if(isset($_FILES['image_of_equipment']['tmp_name'])){
					if (file_exists($_FILES['image_of_equipment']['tmp_name'])){
						$config = array();
						$filename = md5(uniqid(rand(), true)).$_FILES['image_of_equipment']['name'];
						$config['upload_path']   = './i_and_c/';
						$config['allowed_types'] = 'jpg|png|bmp|jpeg';
						$config['file_name'] = $filename;
						$config['max_size']      = 2048000;
						$this->upload->initialize($config);
						if (!$this->upload->do_upload('image_of_equipment')) {
							$error = array('error' => $this->upload->display_errors());
							$data['error'] = $error;
							json_output(202,array('status' => 401,'message' => $error));
							return;
						}else{
							$uploaddata = $this->upload->data();
							$data['image_of_equipment']=$uploaddata['file_name'];
						}
					}
				}
				if(isset($_FILES['image_of_earthing']['tmp_name'])){
					if (file_exists($_FILES['image_of_earthing']['tmp_name'])){
						$config = array();
						$filename = md5(uniqid(rand(), true)).$_FILES['image_of_earthing']['name'];
						$config['upload_path']   = './i_and_c/';
						$config['allowed_types'] = 'jpg|png|bmp|jpeg';
						$config['file_name'] = $filename;
						$config['max_size']      = 2048000;
						$this->upload->initialize($config);
						if (!$this->upload->do_upload('image_of_earthing')) {
							$error = array('error' => $this->upload->display_errors());
							$data['error'] = $error;
							json_output(202,array('status' => 401,'message' => $error));
							return;
						}else{
							$uploaddata = $this->upload->data();
							$data['image_of_earthing']=$uploaddata['file_name'];
						}
					}
				}
				if(isset($_FILES['image_of_faulty_equipment']['tmp_name'])){
					if (file_exists($_FILES['image_of_faulty_equipment']['tmp_name'])){
						$config = array();
						$filename = md5(uniqid(rand(), true)).$_FILES['image_of_faulty_equipment']['name'];
						$config['upload_path']   = './i_and_c/';
						$config['allowed_types'] = 'jpg|png|bmp|jpeg';
						$config['file_name'] = $filename;
						$config['max_size']      = 2048000;
						$this->upload->initialize($config);
						if (!$this->upload->do_upload('image_of_faulty_equipment')) {
							$error = array('error' => $this->upload->display_errors());
							$data['error'] = $error;
							json_output(202,array('status' => 401,'message' => $error));
							return;
						}else{
							$uploaddata = $this->upload->data();
							$data['image_of_faulty_equipment']=$uploaddata['file_name'];
						}
					}
				}
				if(isset($_FILES['image_of_pole_mast_installed']['tmp_name'])){
					if (file_exists($_FILES['image_of_pole_mast_installed']['tmp_name'])){
						$config = array();
						$filename = md5(uniqid(rand(), true)).$_FILES['image_of_pole_mast_installed']['name'];
						$config['upload_path']   = './i_and_c/';
						$config['allowed_types'] = 'jpg|png|bmp|jpeg';
						$config['file_name'] = $filename;
						$config['max_size']      = 2048000;
						$this->upload->initialize($config);
						if (!$this->upload->do_upload('image_of_pole_mast_installed')) {
							$error = array('error' => $this->upload->display_errors());
							$data['error'] = $error;
							json_output(202,array('status' => 401,'message' => $error));
							return;
						}else{
							$uploaddata = $this->upload->data();
							$data['image_of_pole_mast_installed']=$uploaddata['file_name'];
						}
					}
				}
				if(isset($_FILES['image_routing_pics']['tmp_name'])){
					if (file_exists($_FILES['image_routing_pics']['tmp_name'])){
						$config = array();
						$filename = md5(uniqid(rand(), true)).$_FILES['image_routing_pics']['name'];
						$config['upload_path']   = './i_and_c/';
						$config['allowed_types'] = 'jpg|png|bmp|jpeg';
						$config['file_name'] = $filename;
						$config['max_size']      = 2048000;
						$this->upload->initialize($config);
						if (!$this->upload->do_upload('image_routing_pics')) {
							$error = array('error' => $this->upload->display_errors());
							$data['error'] = $error;
							json_output(202,array('status' => 401,'message' => $error));
							return;
						}else{
							$uploaddata = $this->upload->data();
							$data['image_routing_pics']=$uploaddata['file_name'];
						}
					}
				}
				$res=$this->mainlogin->insert('i_and_c',$data);
				json_output($res['status'],$res);
			}
		}
	}
	
	public function i_and_c_list(){
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->LoginModel->check_auth_client();
			if($check_auth_client == true){
			    $params = $_REQUEST;
				$data = array();
				if(isset($params['emp_id']) && !empty($params['emp_id'])){
					$data['emp_id'] = $params['emp_id'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'employee id is compulsory.'));
					return;
				}
				if(isset($params['date']) && !empty($params['date'])){
					$data['inc_visit_date'] = date('Y-m-d',strtotime($params['date']));
				}
				$resp =  $this->mainlogin->get_detaild_by_conditions('i_and_c',$data);
				if(!empty($resp)){
				    $resp=array_reverse($resp);
				    foreach($resp as $key=>$val){
				        $musk_bts_images=array();
				        $i=0;
				        foreach($val as $key1=>$val1){
				            $imageFileType = strtolower(pathinfo($val1,PATHINFO_EXTENSION));
				            $musk_bts_image=(object)array();
				            if($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif" ) {
				                $musk_bts_image->name =str_replace('_'," ",$key1);
				                $musk_bts_image->image_name=$val1;
				                $musk_bts_images[$i]=$musk_bts_image;
				                $i++;
				            }
				        }
				        $resp[$key]->i_and_c_images=$musk_bts_images;
				    }
				}else{
				    $resp=array();
				}
				json_output(200,array('status' => 200,'data_array' => $resp,'i_and_c_url'=>base_url('i_and_c/')));
			}
		}
	}
	
	public function insert_o_and_m(){
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->LoginModel->check_auth_client();
			if($check_auth_client == true){
				$this->load->library('form_validation');
				$this->load->library('upload');
				$params = $_REQUEST;
				$data = array();
				if(isset($params['emp_id']) && !empty($params['emp_id'])){
					$data['emp_id'] = $params['emp_id'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'emp_id is compulsory.'));
					return;
				}
				if(isset($params['ticket_id_circuit_id']) && !empty($params['ticket_id_circuit_id'])){
					$data['ticket_id_circuit_id'] = $params['ticket_id_circuit_id'];
					if($this->mainlogin->check_user_exist('o_and_m',array('ticket_id_circuit_id'=>$data['ticket_id_circuit_id']))==TRUE){
						json_output(401,array('status' => 401,'message' => 'ticket id and circuit id already exists'));
						return;
					}
				}else{
					echo json_encode(array('status' => 401,'message' => 'ticket_id_circuit_id is compulsory.'));
					return;
				}
				if(isset($params['customer']) && !empty($params['customer'])){
					$data['customer'] = $params['customer'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'customer is compulsory.'));
					return;
				}
				if(isset($params['site_a_name']) && !empty($params['site_a_name'])){
					$data['site_a_name'] = $params['site_a_name'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'site_a_name is compulsory.'));
					return;
				}
				if(isset($params['site_a_id']) && !empty($params['site_a_id'])){
					$data['site_a_id'] = $params['site_a_id'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'site_a_id is compulsory.'));
					return;
				}
				if(isset($params['site_b_name']) && !empty($params['site_b_name'])){
					$data['site_b_name'] = $params['site_b_name'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'site_b_name is compulsory.'));
					return;
				}
				if(isset($params['site_b_id']) && !empty($params['site_b_id'])){
					$data['site_b_id'] = $params['site_b_id'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'site_b_id is compulsory.'));
					return;
				}
				if(isset($params['location']) && !empty($params['location'])){
					$data['location'] = $params['location'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'location is compulsory.'));
					return;
				}
				if(isset($params['link_type']) && !empty($params['link_type'])){
					$data['link_type'] = $params['link_type'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'link_type is compulsory.'));
					return;
				}
				if(isset($params['link_site_down_reason']) && !empty($params['link_site_down_reason'])){
					$data['link_site_down_reason'] = $params['link_site_down_reason'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'link_site_down_reason is compulsory.'));
					return;
				}
				if(isset($params['equipment_type']) && !empty($params['equipment_type'])){
					$data['equipment_type'] = $params['equipment_type'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'equipment_type is compulsory.'));
					return;
				}
				$data['inc_visit_date']=date('Y-m-d');
				if(isset($params['height_of_pole_mast']) && !empty($params['height_of_pole_mast'])){
					$data['height_of_pole_mast'] = $params['height_of_pole_mast'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'height_of_pole_mast is compulsory.'));
					return;
				}
				if(isset($params['ip_details']) && !empty($params['ip_details'])){
					$data['ip_details'] = $params['ip_details'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'ip_details is compulsory.'));
					return;
				}
				if(isset($params['equipment_serial_number']) && !empty($params['equipment_serial_number'])){
					$data['equipment_serial_number'] = $params['equipment_serial_number'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'equipment_serial_number is compulsory.'));
					return;
				}
				if(isset($params['pole_mast_installed_by_us']) && !empty($params['pole_mast_installed_by_us'])){
					$data['pole_mast_installed_by_us'] = $params['pole_mast_installed_by_us'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'pole_mast_installed_by_us is compulsory.'));
					return;
				}
				if(isset($params['basic_hygiene_at_site']) && !empty($params['basic_hygiene_at_site'])){
					$data['basic_hygiene_at_site'] = $params['basic_hygiene_at_site'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'basic_hygiene_at_site is compulsory.'));
					return;
				}
				if(isset($params['total_ubr_installed_at_sites']) && !empty($params['total_ubr_installed_at_sites'])){
					$data['total_ubr_installed_at_sites'] = $params['total_ubr_installed_at_sites'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'total_ubr_installed_at_sites is compulsory.'));
					return;
				}
				if(isset($params['achieved_rssi']) && !empty($params['achieved_rssi'])){
					$data['achieved_rssi'] = $params['achieved_rssi'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'achieved_rssi is compulsory.'));
					return;
				}
				if(isset($params['quantity_of_cat_6_cable_used']) && !empty($params['quantity_of_cat_6_cable_used'])){
					$data['quantity_of_cat_6_cable_used'] = $params['quantity_of_cat_6_cable_used'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'quantity_of_cat_6_cable_used is compulsory.'));
					return;
				}
				if(isset($params['quantity_of_power_cable_used']) && !empty($params['quantity_of_power_cable_used'])){
					$data['quantity_of_power_cable_used'] = $params['quantity_of_power_cable_used'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'quantity_of_power_cable_used is compulsory.'));
					return;
				}
				if(isset($params['quantity_of_earthing_cable_used']) && !empty($params['quantity_of_earthing_cable_used'])){
					$data['quantity_of_earthing_cable_used'] = $params['quantity_of_earthing_cable_used'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'quantity_of_earthing_cable_used is compulsory.'));
					return;
				}
				if(isset($params['replaced_material_during_maintenance']) && !empty($params['replaced_material_during_maintenance'])){
					$data['replaced_material_during_maintenance'] = $params['replaced_material_during_maintenance'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'replaced_material_during_maintenance is compulsory.'));
					return;
				}
				if(isset($params['any_other_material']) && !empty($params['any_other_material'])){
					$data['any_other_material'] = $params['any_other_material'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'any_other_material is compulsory.'));
					return;
				}
				if(isset($_FILES['image_of_basic_hygiene_at_site']['tmp_name'])){
					if (file_exists($_FILES['image_of_basic_hygiene_at_site']['tmp_name'])){
						$config = array();
						$filename = md5(uniqid(rand(), true)).$_FILES['image_of_basic_hygiene_at_site']['name'];
						$config['upload_path']   = './o_and_m/';
						$config['allowed_types'] = 'jpg|png|bmp|jpeg';
						$config['file_name'] = $filename;
						$config['max_size']      = 2048000;
						$this->upload->initialize($config);
						if (!$this->upload->do_upload('image_of_basic_hygiene_at_site')) {
							$error = array('error' => $this->upload->display_errors());
							$data['error'] = $error;
							json_output(202,array('status' => 401,'message' => $error));
							return;
						}else{
							$uploaddata = $this->upload->data();
							$data['image_of_basic_hygiene_at_site']=$uploaddata['file_name'];
						}
					}
				}
				if(isset($_FILES['image_of_equipment']['tmp_name'])){
					if (file_exists($_FILES['image_of_equipment']['tmp_name'])){
						$config = array();
						$filename = md5(uniqid(rand(), true)).$_FILES['image_of_equipment']['name'];
						$config['upload_path']   = './o_and_m/';
						$config['allowed_types'] = 'jpg|png|bmp|jpeg';
						$config['file_name'] = $filename;
						$config['max_size']      = 2048000;
						$this->upload->initialize($config);
						if (!$this->upload->do_upload('image_of_equipment')) {
							$error = array('error' => $this->upload->display_errors());
							$data['error'] = $error;
							json_output(202,array('status' => 401,'message' => $error));
							return;
						}else{
							$uploaddata = $this->upload->data();
							$data['image_of_equipment']=$uploaddata['file_name'];
						}
					}
				}
				if(isset($_FILES['image_of_earthing']['tmp_name'])){
					if (file_exists($_FILES['image_of_earthing']['tmp_name'])){
						$config = array();
						$filename = md5(uniqid(rand(), true)).$_FILES['image_of_earthing']['name'];
						$config['upload_path']   = './o_and_m/';
						$config['allowed_types'] = 'jpg|png|bmp|jpeg';
						$config['file_name'] = $filename;
						$config['max_size']      = 2048000;
						$this->upload->initialize($config);
						if (!$this->upload->do_upload('image_of_earthing')) {
							$error = array('error' => $this->upload->display_errors());
							$data['error'] = $error;
							json_output(202,array('status' => 401,'message' => $error));
							return;
						}else{
							$uploaddata = $this->upload->data();
							$data['image_of_earthing']=$uploaddata['file_name'];
						}
					}
				}
				if(isset($_FILES['image_of_faulty_equipment']['tmp_name'])){
					if (file_exists($_FILES['image_of_faulty_equipment']['tmp_name'])){
						$config = array();
						$filename = md5(uniqid(rand(), true)).$_FILES['image_of_faulty_equipment']['name'];
						$config['upload_path']   = './o_and_m/';
						$config['allowed_types'] = 'jpg|png|bmp|jpeg';
						$config['file_name'] = $filename;
						$config['max_size']      = 2048000;
						$this->upload->initialize($config);
						if (!$this->upload->do_upload('image_of_faulty_equipment')) {
							$error = array('error' => $this->upload->display_errors());
							$data['error'] = $error;
							json_output(202,array('status' => 401,'message' => $error));
							return;
						}else{
							$uploaddata = $this->upload->data();
							$data['image_of_faulty_equipment']=$uploaddata['file_name'];
						}
					}
				}
				if(isset($_FILES['image_of_pole_mast_installed']['tmp_name'])){
					if (file_exists($_FILES['image_of_pole_mast_installed']['tmp_name'])){
						$config = array();
						$filename = md5(uniqid(rand(), true)).$_FILES['image_of_pole_mast_installed']['name'];
						$config['upload_path']   = './o_and_m/';
						$config['allowed_types'] = 'jpg|png|bmp|jpeg';
						$config['file_name'] = $filename;
						$config['max_size']      = 2048000;
						$this->upload->initialize($config);
						if (!$this->upload->do_upload('image_of_pole_mast_installed')) {
							$error = array('error' => $this->upload->display_errors());
							$data['error'] = $error;
							json_output(202,array('status' => 401,'message' => $error));
							return;
						}else{
							$uploaddata = $this->upload->data();
							$data['image_of_pole_mast_installed']=$uploaddata['file_name'];
						}
					}
				}
				if(isset($_FILES['image_routing_pics']['tmp_name'])){
					if (file_exists($_FILES['image_routing_pics']['tmp_name'])){
						$config = array();
						$filename = md5(uniqid(rand(), true)).$_FILES['image_routing_pics']['name'];
						$config['upload_path']   = './o_and_m/';
						$config['allowed_types'] = 'jpg|png|bmp|jpeg';
						$config['file_name'] = $filename;
						$config['max_size']      = 2048000;
						$this->upload->initialize($config);
						if (!$this->upload->do_upload('image_routing_pics')) {
							$error = array('error' => $this->upload->display_errors());
							$data['error'] = $error;
							json_output(202,array('status' => 401,'message' => $error));
							return;
						}else{
							$uploaddata = $this->upload->data();
							$data['image_routing_pics']=$uploaddata['file_name'];
						}
					}
				}
				$res=$this->mainlogin->insert('o_and_m',$data);
				json_output($res['status'],$res);
			}
		}
	}
	
	public function o_and_m_list(){
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->LoginModel->check_auth_client();
			if($check_auth_client == true){
			    $params = $_REQUEST;
				$data = array();
				if(isset($params['emp_id']) && !empty($params['emp_id'])){
					$data['emp_id'] = $params['emp_id'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'employee id is compulsory.'));
					return;
				}
				if(isset($params['date']) && !empty($params['date'])){
					$data['inc_visit_date'] = date('Y-m-d',strtotime($params['date']));
				}
				$resp =  $this->mainlogin->get_detaild_by_conditions('o_and_m',$data);
				if(!empty($resp)){
				    $resp=array_reverse($resp);
				    foreach($resp as $key=>$val){
				        $musk_bts_images=array();
				        $i=0;
				        foreach($val as $key1=>$val1){
				            $imageFileType = strtolower(pathinfo($val1,PATHINFO_EXTENSION));
				            $musk_bts_image=(object)array();
				            if($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif" ) {
				                $musk_bts_image->name =str_replace('_'," ",$key1);
				                $musk_bts_image->image_name=$val1;
				                $musk_bts_images[$i]=$musk_bts_image;
				                $i++;
				            }
				        }
				        $resp[$key]->o_and_m_images=$musk_bts_images;
				    }
				}else{
				    $resp=array();
				}
				json_output(200,array('status' => 200,'data_array' => $resp,'o_and_m_url'=>base_url('o_and_m/')));
			}
		}
	}
	
	public function exiting_site(){
	    $method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->LoginModel->check_auth_client();
			if($check_auth_client == true){
			    $params = $_REQUEST;
			    if(isset($params['emp_id']) && !empty($params['emp_id'])){
					$emp_id = $params['emp_id'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'employee id is compulsory.'));
					return;
				}
				if(isset($params['site_type']) && !empty($params['site_type'])){
					$site_type = $params['site_type'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'site type is compulsory.'));
					return;
				}
				$resp =  $this->mainlogin->get_detaild_by_conditions('employee',array('emp_id'=>$emp_id));
				if(empty($resp)){
				    json_output(401,array('status' => 401,'message' => 'employee does not exist!'));
				    return;
				}else{
				    $con=array('emp_id'=>$emp_id);
				    if($site_type=='i_and_c'){
				        $resp =  $this->mainlogin->get_detaild_by_conditions('i_and_c',$con);
				    }else if($site_type=='bts'){
				        $resp =  $this->mainlogin->get_detaild_by_conditions('bts_survey',$con);
				    }else if($site_type=='cpe'){
				        $resp =  $this->mainlogin->get_detaild_by_conditions('cpe_survey',$con);
				    }else if($site_type=='o_and_m'){
				        $resp =  $this->mainlogin->get_detaild_by_conditions('o_and_m',$con);
				    }else{
				        json_output(401,array('status' => 401,'message' => 'Site type does not exist!'));
				        return;
				    }
				    if(!empty($resp)){
				        $resp=array_reverse($resp);
				    }
				    $coordinator =  $this->mainlogin->get_detaild_by_conditions('coordinator',array('status'=>1));
				    json_output(200,array('status' => 200,'data_array' => $resp,'coordinator_list'=>$coordinator));
				}
			}
		}
	}
	
	public function insert_conveyance(){
	    $method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->LoginModel->check_auth_client();
			if($check_auth_client == true){
			    $this->load->library('form_validation');
				$this->load->library('upload');
			    $params = $_REQUEST;
			    $in_data=array();
			    if(isset($params['emp_id']) && !empty($params['emp_id'])){
					$in_data['emp_id']=$emp_id = $params['emp_id'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'employee id is compulsory.'));
					return;
				}
				if(isset($params['site_type']) && !empty($params['site_type'])){
					$in_data['site_type']=$site_type = $params['site_type'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'site type is compulsory.'));
					return;
				}
				if(isset($params['site_id']) && !empty($params['site_id'])){
					$in_data['site_id']=$site_id = $params['site_id'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'site id is compulsory.'));
					return;
				}
				if(isset($params['coordinator_id']) && !empty($params['coordinator_id'])){
					$in_data['coordinator_id']= $params['coordinator_id'];
					if(!$this->mainlogin->check_user_exist('coordinator',array('coordinator_id'=>$in_data['coordinator_id'],'status'=>1))==TRUE){
					    json_output(401,array('status' => 401,'message' => 'coordinator id does not exist!'));
				        return;
					}
				}else{
					echo json_encode(array('status' => 401,'message' => 'coordinator id is compulsory.'));
					return;
				}
				if(isset($params['expense_type']) && !empty($params['expense_type'])){
					$in_data['expense_type']= $params['expense_type'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'expense type is compulsory.'));
					return;
				}
				if(isset($params['expense_price']) && !empty($params['expense_price'])){
					$in_data['expense_price']=$expense_price= $params['expense_price'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'expense price is compulsory.'));
					return;
				}
				if(isset($params['location']) && !empty($params['location'])){
					$in_data['location']= $params['location'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'location is compulsory.'));
					return;
				}
				$in_data['date']=date('Y-m-d');
				if(isset($params['remark']) && !empty($params['remark'])){
					$in_data['remark']= $params['remark'];
				}
				$resp =  $this->mainlogin->get_detaild_by_conditions('employee',array('emp_id'=>$emp_id));
				if(empty($resp)){
				    json_output(401,array('status' => 401,'message' => 'employee does not exist!'));
				    return;
				}else{
				    $con=array('emp_id'=>$emp_id);
				    $table='';
				    $site_type=str_replace(" ","",$site_type);
				    if($site_type=='i_and_c'){
				        $table="i_and_c";
				        $con['ticket_id_circuit_id']=$site_id;
				    }else if($site_type=='bts'){
				        $table="bts_survey";
				        $con['site_b_id']=$site_id;
				    }else if($site_type=='cpe'){
				        $table="cpe_survey";
				        $con['circuit_id_or_ticket_id']=$site_id;
				    }else if($site_type=='o_and_m'){
				        $table="o_and_m";
				        $con['ticket_id_circuit_id']=$site_id;
				    }else{
				        json_output(401,array('status' => 401,'message' => 'Site type does not exist!'));
				        return;
				    }
				    if(empty($table) || empty($con)){
				        json_output(401,array('status' => 401,'message' => 'something went wrong!'));
				        return;
				    }else{
				        if($this->mainlogin->check_user_exist($table,$con)==TRUE){
				            $expense_price=explode (",",$expense_price);
				            $sub_total=0;
				            foreach($expense_price as $val){
				                $sub_total+=$val;
				            }
				            $in_data['total_expense']=$sub_total;
				            $filenames = array();
				            
				            if(isset($_FILES['expense_images']) && !empty($_FILES['expense_images'])){
				               // var_dump($_FILES);
                                $countfiles = count($_FILES['expense_images']['name']);
                                for($i=0;$i<$countfiles;$i++){
                                    if(!empty($_FILES['expense_images']['name'][$i])){
                                        $_FILES['file']['name'] = $_FILES['expense_images']['name'][$i];
                                      $_FILES['file']['type'] = $_FILES['expense_images']['type'][$i];
                                      $_FILES['file']['tmp_name'] = $_FILES['expense_images']['tmp_name'][$i];
                                      $_FILES['file']['error'] = $_FILES['expense_images']['error'][$i];
                                      $_FILES['file']['size'] = $_FILES['expense_images']['size'][$i];
                                      $config = array();
                                      $filename = md5(uniqid(rand(), true)).$_FILES['expense_images']['name'][$i];
                                      $config['upload_path']   = './conveyance/';
                                      $config['allowed_types'] = 'jpg|png|bmp|jpeg';
                                      $config['file_name'] = $filename;
                                      $config['max_size']      = 2048000;
                                      $this->upload->initialize($config);
                                      if($this->upload->do_upload('file')){
                                          $uploadData = $this->upload->data();
                                          $filename = $uploadData['file_name'];
                                          $filenames[] = $filename;
                                        }else{
                                            json_output(401,array('status' => 401,'message' =>$this->upload->display_errors()));
                                            return;
                        				}
                                    }
                                }
                                $in_data['expense_images']=implode(',',$filenames);
				            }
				            $in_data['date']=date('Ý-m-d');
				            $res=$this->mainlogin->insert('conveyance',$in_data);
				            json_output($res['status'],$res);
				            return;
				        }else{
				            json_output(401,array('status' => 401,'message' => 'Site id does not exist!'));
				            return;
				        }
				    }
				}
			}
		}
	}
	
	public function conveyance_list(){
	    $method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->LoginModel->check_auth_client();
			if($check_auth_client == true){
			    $this->load->library('form_validation');
				$this->load->library('upload');
			    $params = $_REQUEST;
			    $in_data=array();
			    if(isset($params['emp_id']) && !empty($params['emp_id'])){
					$in_data['emp_id'] =$emp_id= $params['emp_id'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'employee id is compulsory.'));
					return;
				}
				if(isset($params['conveyance_status']) && !empty($params['conveyance_status'])){
					if($params['conveyance_status']=="pending"){
					    $in_data['conveyance_status']=0;
					}else if($params['conveyance_status']=="confirm"){
					    $in_data['conveyance_status']=1;
					}
				}
				$in_data['status']=1;
				if($this->mainlogin->check_user_exist('employee',array('emp_id'=>$emp_id))==TRUE){
    				$resp =  $this->mainlogin->get_detaild_by_conditions('conveyance',$in_data);
    				if(!empty($resp)){
    				    $resp=array_reverse($resp);
    				    foreach($resp as $key=>$val){
    				        $coordinator_array=array('coordinator_id'=>$val->coordinator_id);
    				        $coordinator =  $this->mainlogin->get_detaild_by_conditions('coordinator',$coordinator_array);
    				        if(!empty($coordinator)){
    				            $resp[$key]->coordinator_name=$coordinator[0]->coordinator_name;
    				        }else{
    				            $resp[$key]->coordinator_name='';
    				        }
    				    }
    				}
    				json_output(200,array('status' => 200,'data_array' => $resp,'image_url'=>base_url('conveyance')));
				}else{
				    json_output(401,array('status' => 401,'message'=>"invalid emp id"));
				}
			}
		}
	}
	
	public function new_material_purchase(){
	    $method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->LoginModel->check_auth_client();
			if($check_auth_client == true){
			    $this->load->library('form_validation');
				$this->load->library('upload');
			    $params = $_REQUEST;
			    $in_data=array();
			    if(isset($params['emp_id']) && !empty($params['emp_id'])){
					$in_data['emp_id'] =$emp_id= $params['emp_id'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'employee id is compulsory.'));
					return;
				}
				if(isset($params['site_name']) && !empty($params['site_name'])){
					$in_data['site_name'] = $params['site_name'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'site name is compulsory.'));
					return;
				}
				if(isset($params['site_id']) && !empty($params['site_id'])){
					$in_data['site_id'] = $params['site_id'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'site id is compulsory.'));
					return;
				}
				if(isset($params['location']) && !empty($params['location'])){
					$in_data['location'] = $params['location'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'location is compulsory.'));
					return;
				}
				if(isset($params['customer_name']) && !empty($params['customer_name'])){
					$in_data['customer_name'] = $params['customer_name'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'customer name is compulsory.'));
					return;
				}
				if(isset($params['item_name']) && !empty($params['item_name'])){
					$in_data['item_name'] = $params['item_name'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'item name is compulsory.'));
					return;
				}
				if(isset($params['quantity']) && !empty($params['quantity'])){
					$in_data['quantity'] = $params['quantity'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'quantity is compulsory.'));
					return;
				}
				if(isset($params['price']) && !empty($params['price'])){
					$in_data['price'] = $params['price'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'price is compulsory.'));
					return;
				}
				if(isset($_FILES['invoice_or_bill']['tmp_name'])){
					if (file_exists($_FILES['invoice_or_bill']['tmp_name'])){
						$config = array();
						$filename = md5(uniqid(rand(), true)).$_FILES['invoice_or_bill']['name'];
						$config['upload_path']   = './material_purchase/';
						$config['allowed_types'] = 'jpg|png|bmp|jpeg';
						$config['file_name'] = $filename;
						$config['max_size']      = 2048000;
						$this->upload->initialize($config);
						if (!$this->upload->do_upload('invoice_or_bill')) {
							$error = array('error' => $this->upload->display_errors());
							$data['error'] = $error;
							json_output(202,array('status' => 401,'message' => $error));
							return;
						}else{
							$uploaddata = $this->upload->data();
							$in_data['invoice_or_bill']=$uploaddata['file_name'];
						}
					}
				}
				$in_data['date'] =date('Y-m-d');
				if(!$this->mainlogin->check_user_exist('employee',array('emp_id'=>$emp_id))==TRUE){
				    json_output(401,array('status'=>401,'message'=>"invalid emp id"));
				    return;
				}
				do{
				    $in_data['item_id'] ='eti'.time();
				}while($this->mainlogin->check_user_exist('material_purchase',array('item_id'=>$in_data['item_id']))==TRUE);
				$res=$this->mainlogin->insert('material_purchase',$in_data);
				json_output($res['status'],$res);
				return;
			}
		}
	}
	
	public function previous_material_purchase_list(){
	    $method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->LoginModel->check_auth_client();
			if($check_auth_client == true){
			    $this->load->library('form_validation');
				$this->load->library('upload');
			    $params = $_REQUEST;
			    $in_data=array();
			    if(isset($params['emp_id']) && !empty($params['emp_id'])){
					$in_data['emp_id'] =$emp_id= $params['emp_id'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'employee id is compulsory.'));
					return;
				}
				$in_data['status']=1;
				if(!$this->mainlogin->check_user_exist('employee',array('emp_id'=>$emp_id))==TRUE){
				    json_output(401,array('status'=>401,'message'=>"invalid emp id"));
				    return;
				}
				$resp =  $this->mainlogin->get_detaild_by_conditions('material_purchase',$in_data);
				if(!empty($resp)){
				    //$resp=array_reverse($resp);
				}
				json_output(200,array('status' => 200,'data_array' => $resp,'image_url'=>base_url('material_purchase')));
			}
		}
	}
	
	public function new_material_consumption(){
	    $method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->LoginModel->check_auth_client();
			if($check_auth_client == true){
			    $this->load->library('form_validation');
				$this->load->library('upload');
			    $params = $_REQUEST;
			    $in_data=array();
			    if(isset($params['emp_id']) && !empty($params['emp_id'])){
					$in_data['emp_id']=$emp_id = $params['emp_id'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'employee id is compulsory.'));
					return;
				}
				if(isset($params['site_type']) && !empty($params['site_type'])){
					$in_data['site_type']=$site_type = $params['site_type'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'site type is compulsory.'));
					return;
				}
				if(isset($params['site_id']) && !empty($params['site_id'])){
					$in_data['site_id']=$site_id = $params['site_id'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'site id is compulsory.'));
					return;
				}
				if(isset($params['location']) && !empty($params['location'])){
					$in_data['location'] = $params['location'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'location is compulsory.'));
					return;
				}
				if(isset($params['material_used']) && !empty($params['material_used'])){
					$in_data['material_used'] = $params['material_used'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'material used is compulsory.'));
					return;
				}
				if(isset($params['item_name']) && !empty($params['item_name'])){
					$in_data['item_name'] = $params['item_name'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'item name is compulsory.'));
					return;
				}
				if(isset($params['quantity']) && !empty($params['quantity'])){
					$in_data['quantity'] = $params['quantity'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'quantity is compulsory.'));
					return;
				}
				$resp =  $this->mainlogin->get_detaild_by_conditions('employee',array('emp_id'=>$emp_id));
				if(empty($resp)){
				    json_output(401,array('status' => 401,'message' => 'employee does not exist!'));
				    return;
				}else{
				    $con=array('emp_id'=>$emp_id);
				    $table='';
				    if($site_type=='i_and_c'){
				        $table="i_and_c";
				        $con['ticket_id_circuit_id']=$site_id;
				    }else if($site_type=='o_and_m'){
				        $table="o_and_m";
				        $con['ticket_id_circuit_id']=$site_id;
				    }else{
				        json_output(401,array('status' => 401,'message' => 'Site type does not exist!'));
				        return;
				    }
				    if(empty($table) || empty($con)){
				        json_output(401,array('status' => 401,'message' => 'something went wrong!'));
				        return;
				    }else{
				        if($this->mainlogin->check_user_exist($table,$con)==TRUE){
				            $in_data['consumption_date']=date('Y-m-d');
				            $res=$this->mainlogin->insert('material_consumption',$in_data);
            				json_output($res['status'],$res);
            				return;
				        }else{
				            json_output(400,array('status' => 400,'message' => 'something went wrong!'));
				            return;
				        }
				    }
				}
			}
		}
	}
	
	public function previous_material_consumption_list(){
	    $method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->LoginModel->check_auth_client();
			if($check_auth_client == true){
			    $this->load->library('form_validation');
				$this->load->library('upload');
			    $params = $_REQUEST;
			    $in_data=array();
			    if(isset($params['emp_id']) && !empty($params['emp_id'])){
					$in_data['emp_id'] =$emp_id= $params['emp_id'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'employee id is compulsory.'));
					return;
				}
				if(isset($params['date']) && !empty($params['date'])){
					$in_data['consumption_date'] = date('Y-m-d',strtotime($params['date']));
				}
				if(isset($params['site_type']) && !empty($params['site_type'])){
					$in_data['site_type'] = $params['site_type'];
				}
				$in_data['status']=1;
				if(!$this->mainlogin->check_user_exist('employee',array('emp_id'=>$emp_id))==TRUE){
				    json_output(401,array('status'=>401,'message'=>"invalid emp id"));
				    return;
				}
				$resp =  $this->mainlogin->get_detaild_by_conditions('material_consumption',$in_data);
				if(!empty($resp)){
				    $resp=array_reverse($resp);
				}
				json_output(200,array('status' => 200,'data_array' => $resp));
			}
		}
	}
	
	public function material_issue_or_stock(){
	    $method = $_SERVER['REQUEST_METHOD'];
		if($method != 'POST'){
			json_output(400,array('status' => 400,'message' => 'Bad request.'));
		} else {
			$check_auth_client = $this->LoginModel->check_auth_client();
			if($check_auth_client == true){
			    $params = $_REQUEST;
			    if(isset($params['emp_id']) && !empty($params['emp_id'])){
					$emp_id= $params['emp_id'];
				}else{
					echo json_encode(array('status' => 401,'message' => 'employee id is compulsory.'));
					return;
				}
			    $resp=$this->LoginModel->material_issue_list_for_user($emp_id);
			    if(empty($resp)){
			        $resp=array();
			    }
			    json_output(200,array('status' => 200,'data_array' => $resp));
			}
		}
	}
	/*public function test_file(){
	    $this->load->library('form_validation');
				$this->load->library('upload');
	    /*foreach ($_FILES as $index => $value){
            if ($value['expense_images'] != ''){
                $this->load->library('upload');
                $config = array();
						$filename = md5(uniqid(rand(), true)).$value['expense_images']['name'];
						$config['upload_path']   = './test/';
						$config['allowed_types'] = 'jpg|png|bmp|jpeg';
						$config['file_name'] = $filename;
						$config['max_size']      = 2048000;
						$this->upload->initialize($config);
                //upload the image
                if ( ! $this->upload->do_upload($index)){
                    $error['upload_error'] = $this->upload->display_errors("<span class='error'>", "</span>");
                    json_output(401,array('status' => 401,'message' =>$error));
                    return;
                }else{
                    $data[$key] = array('upload_data' => $this->upload->data());
                    
                }
            }
        }
        json_output(200,array('status' => 200,'message' =>"success"));
        $data = array();
        $countfiles = count($_FILES['expense_images']['name']);
        for($i=0;$i<$countfiles;$i++){
            if(!empty($_FILES['expense_images']['name'][$i])){
                $_FILES['file']['name'] = $_FILES['expense_images']['name'][$i];
              $_FILES['file']['type'] = $_FILES['expense_images']['type'][$i];
              $_FILES['file']['tmp_name'] = $_FILES['expense_images']['tmp_name'][$i];
              $_FILES['file']['error'] = $_FILES['expense_images']['error'][$i];
              $_FILES['file']['size'] = $_FILES['expense_images']['size'][$i];
              $config = array();
						$filename = md5(uniqid(rand(), true)).$_FILES['expense_images']['name'][$i];
						$config['upload_path']   = './test/';
						$config['allowed_types'] = 'jpg|png|bmp|jpeg';
						$config['file_name'] = $filename;
						$config['max_size']      = 2048000;
						$this->upload->initialize($config);
						if($this->upload->do_upload('file')){
						 $uploadData = $this->upload->data();
                            $filename = $uploadData['file_name'];
                
                            // Initialize array
                            $data['filenames'][] = $filename;
						}else{
						    json_output(401,array('status' => 401,'message' =>'error'));
						}
            }
        }
        json_output(200,array('status' => 200,'message' =>"success","data"=>$data));
        //var_dump($_FILES);
	}*/
}
