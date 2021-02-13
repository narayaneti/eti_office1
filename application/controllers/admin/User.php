<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct() {
        parent::__construct();

        // Load form helper library
        $this->load->helper('form');
        
        // Load security helper
        $this->load->helper('url');
        
        // Load security helper
        $this->load->helper('security');

        // Load form validation library
        $this->load->library('form_validation');

        // Load session library
        $this->load->library('session');

      $this->load->library('encryption');
        
        $this->load->database();
       date_default_timezone_set('Asia/Kolkata');
        $this->load->library('mainlogin');
        }
	public function index()
	{
//            session_destroy();
		$this->load->view('login_page');
        }
        
        public function login_process(){
        
        $this->form_validation->set_rules('username', 'User name', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        date_default_timezone_set('Asia/Kolkata');

            if ($this->form_validation->run() == FALSE) {
                if(isset($this->session->userdata['admin_in'])){
                    $this->load->view('dashboard');
                }else{
                    $data = array(
                    'error_message' => 'Invalid User Name No or Password'
                    );
//                     redirect('admin/user',$data);
                     $this->index('login', $data);
                }
            } else {
                 $username = $this->input->post('username');
                 $password = $this->input->post('password');
                
//                $result = $this->login_database->login($data);
                $this->load->library('mainlogin');
                $resp =  $this->mainlogin->admin_login($username,$password); 
                if ($resp['status'] == 200) {
                    $username = $this->input->post('username');
                    if($resp['data']['resp']->role == 1 || $resp['data']['resp']->role == 2){
                        $session_data = array(
                        'admin_id' => $resp['data']['resp']->admin_id,
                        'username' => $resp['data']['resp']->username,
                        'role' => $resp['data']['resp']->role
                        );
                    }
                    else{
                        $session_data = array(
                        'admin_id' => $resp['data']['resp']->emp_id,
                        'username' => $resp['data']['resp']->emp_name,
                        'role' => $resp['data']['resp']->role
                        );
                    }
                    // Add user data in session
                    $this->session->set_userdata('admin_in', $session_data);
                     redirect('admin/user/dashboard');
                    
                } else {
                    $data = array(
                    'error_message' => 'Invalid Username or Password'
                    );
                    $this->load->view('login_page', $data);
//                    redirect('user/index',$data);
                }
            }
        }
        
        public function logout() {

            // Removing session data
            $sess_array = array(
            'username' => ''
            );
            $this->session->unset_userdata('admin_in', $sess_array);
            $data['error_message'] = 'Successfully Logout';
            $this->load->view('login_page', $data);
        }
        
       function enter(){
            if($this->session->userdata['admin_in'] != ''){
               $username = ($this->session->userdata['admin_in']['username']);
                $role = ($this->session->userdata['admin_in']['role']);
            }else{
            redirect(base_url().'index.php/admin/user');
            }
        }
        
        public function dashboard() {
            $this->enter();
            $this->load->library('mainlogin');
            $resp =  $this->mainlogin->get_detaild_by_conditions("employee",array('login_status' => 1));
            if(empty($resp)){
                $resp=array();
            }
            $data['active_emp']=count($resp);
            $resp =  $this->mainlogin->get_detaild_by_conditions("employee",array('login_status' => 0));
            if(empty($resp)){
                $resp=array();
            }
            $data['inactive_emp']=count($resp);
            
            $this->load->view('home',$data);
        }
        
        public function department() {
         $this->enter();   
         $data = array();
         if($this->input->post('department_name') != NULL){
            $department = $this->input->post('department_name');
            $table = 'department';
            $check_data = array('department' => $department);
            $this->load->library('mainlogin');
            if($this->mainlogin->check_user_exist($table,$check_data) == TRUE){
                $data['error'] = "Department already registered!";
            }else{
                $response =  $this->mainlogin->insert($table,$check_data);
            }
         }
         $condition = array('status' => 1);
         $table = "department";
         $resp =  $this->mainlogin->get_detaild_by_conditions($table,$condition);
         $data['resp'] = $resp;
         $this->load->view('department',$data);
        }
        
        public function designation() {
         $this->load->library('mainlogin');
         $this->enter();  
         $data = array();
         if($this->input->post('department_id') != NULL & $this->input->post('designation_name') != NULL){
            $department_id = $this->input->post('department_id');
            $designation_name = $this->input->post('designation_name');
            $table = 'designation';
            $check_data = array('designation' => $designation_name);
            
            if($this->mainlogin->check_user_exist($table,$check_data) == TRUE){
                $data['error'] = "Department already registered!";
            }else{
                $idata = array('department_id' => $department_id, 'designation' => $designation_name);
                $response =  $this->mainlogin->insert($table,$idata);
            }
         }
         $data = array();
         $condition1 = array('status' => 1);
         $table1 = "department";
         $dep_resp =  $this->mainlogin->get_detaild_by_conditions($table1,$condition1);
         $condition2 = array('status' => 1);
         $table2 = "designation";
         $des_resp =  $this->mainlogin->get_detaild_by_conditions($table2,$condition2);
         $data['dep_resp'] = $dep_resp;
         $data['des_resp'] = $des_resp;
         $this->load->view('designation',$data);
        }
        
        public function technology($technology_id = NULL) {
         $this->enter();   
         $data = array();
         if($this->input->post('technology_name') != NULL){
            $technology_name = $this->input->post('technology_name');
            $table = 'technology';
            $check_data = array('technology' => $technology_name);
            $this->load->library('mainlogin');
            if($this->mainlogin->check_user_exist($table,$check_data) == TRUE){
                $data['error'] = "Technology already registered!";
            }else{
                $response =  $this->mainlogin->insert($table,$check_data);
            }
         }
         if($this->input->post('action_name') == "edit"){
            $technology_name = $this->input->post('technology_name');
            $technology_id = $this->input->post('technology_id');
            $table = 'technology';
            $check_data = array('technology_id' => $technology_id);
            $tdata = array('technology' => $technology_name);
            $response =  $this->mainlogin->update_data($table,$check_data,$tdata);
         }
         $condition = array('status' => 1);
         $table = "technology";
         $resp =  $this->mainlogin->get_detaild_by_conditions($table,$condition);
         $data['resp'] = $resp;
         $this->load->view('technology',$data);
        }
        
        public function survey() {
            $this->enter();
            if($this->input->post('survey_id') != NULL){
                
               echo $survey_id = $this->input->post('survey_id');
               
                //load mainligin library
                $this->load->library('mainlogin');
                $resp =  $this->mainlogin->survey_pic_name($survey_id);
                
                print_r($resp);
                echo $name = $resp[0]->survey_junction_name;
                $this->zip->read_dir($name);
                if($resp[0]->survey_angle1 != ''){
                    $img = $resp[0]->survey_angle1;
                   echo $filepath1 = FCPATH."/survey/$img";
                    $this->zip->read_file($filepath1);
                }
                if($resp[0]->survey_angle2 != ''){
                    $img = $resp[0]->survey_angle2;
                   echo $filepath2 = FCPATH."/survey/$img";
                    $this->zip->read_file($filepath2);
                }
                if($resp[0]->survey_angle3 != ''){
                    $img = $resp[0]->survey_angle3;
                   echo $filepath3 = FCPATH."/survey/$img";
                    $this->zip->read_file($filepath3);
                }
                if($resp[0]->survey_angle4 != ''){
                    $img = $resp[0]->survey_angle4;
                   echo $filepath4 = FCPATH."/survey/$img";
                    $this->zip->read_file($filepath4);
                }

               
               $name = str_replace(' ', '_', $name);
               // Download
               $filename = $name.".zip";
               $this->zip->download($filename);
              
            }
            $this->load->library('mainlogin');
            $resp =  $this->mainlogin->servey_list();
            $data = array(
                    'resp' => $resp
                    );
            $this->load->view('index.php',$data);
        }
        
        public function createzip(){
            $this->enter();
            // Read file from path
            if($this->input->post('survey_id') != NULL){
                
               echo $survey_id = $this->input->post('survey_id');
               
                //load mainligin library
                $this->load->library('mainlogin');
                $resp =  $this->mainlogin->site_survey_pic_name($survey_id);
                
                print_r($resp);
                echo $name = $resp[0]->survey_junction_name;
                if($resp[0]->survey_angle1 != ''){
                    $img = $resp[0]->survey_angle1;
                   echo $filepath1 = FCPATH."/survey/$img";
                    $this->zip->read_file($filepath1);
                }
                if($resp[0]->survey_angle2 != ''){
                    $img = $resp[0]->survey_angle2;
                   echo $filepath2 = FCPATH."/survey/$img";
                    $this->zip->read_file($filepath1);
                }
                if($resp[0]->survey_angle3 != ''){
                    $img = $resp[0]->survey_angle3;
                   echo $filepath3 = FCPATH."/survey/$img";
                    $this->zip->read_file($filepath1);
                }
                if($resp[0]->survey_angle4 != ''){
                    $img = $resp[0]->survey_angle4;
                   echo $filepath4 = FCPATH."/survey/$img";
                    $this->zip->read_file($filepath1);
                }

               
               $name = str_replace(' ', '_', $name);
               // Download
               $filename = $name.".zip";
               $this->zip->download($filename);
               redirect('survey');
            }
        }
        
        public function all_zip(){
            $this->enter();
            $this->load->library('mainlogin');
            $resp =  $this->mainlogin->servey_list();
            $data = array(
                    'resp' => $resp
                    );
            $zip_file = array();
                    foreach ($resp as $key => $value) {
                        $name = $value->survey_junction_name;
                        $this->zip->read_dir($name);
                        if($value->survey_angle1 != ''){
                            $img = $value->survey_angle1;
                           $filepath1 = FCPATH."/survey/$img";
                            $this->zip->read_file($filepath1);
                        }
                        if($value->survey_angle2 != ''){
                            $img = $value->survey_angle2;
                           $filepath2 = FCPATH."/survey/$img";
                            $this->zip->read_file($filepath2);
                        }
                        if($value->survey_angle3 != ''){
                            $img = $value->survey_angle3;
                           $filepath3 = FCPATH."/survey/$img";
                            $this->zip->read_file($filepath3);
                        }
                        if($value->survey_angle4 != ''){
                            $img = $value->survey_angle4;
                           $filepath4 = FCPATH."/survey/$img";
                            $this->zip->read_file($filepath4);
                        }
                        $zip_file['file'] = $this->zip->get_zip();
//                        $name = str_replace(' ', '_', $name);
//               // Download
//               $filename = $name.".zip";
//               $this->zip->download($filename);
                        $this->zip->clear_data();
                    }
//            $this->load->view('index.php',$data);
                    foreach ($zip_file as $key => $value) {
                        $this->zip->read_file($value->file);
                    }
        $this->zip->download("file.zip");
        }
        
        // all active3 site survey list details with all expense details
        public function all_site_survey_list_details_with_expense() {
            $this->enter();
            if($this->input->post('survey_id') != NULL){
                
               echo $survey_id = $this->input->post('survey_id');
               
                //load mainligin library
                $this->load->library('mainlogin');
                $resp =  $this->mainlogin->site_survey_pic_name($survey_id);
                
                print_r($resp);
                echo $name = $resp[0]->survey_site_name;
                $this->zip->read_dir($name);
                if($resp[0]->survey_angle1 != ''){
                    $img = $resp[0]->survey_angle1;
                   echo $filepath1 = FCPATH."/site_image/$img";
                    $this->zip->read_file($filepath1);
                }
                if($resp[0]->survey_angle2 != ''){
                    $img = $resp[0]->survey_angle2;
                   echo $filepath2 = FCPATH."/site_image/$img";
                    $this->zip->read_file($filepath2);
                }
                if($resp[0]->survey_angle3 != ''){
                    $img = $resp[0]->survey_angle3;
                   echo $filepath3 = FCPATH."/site_image/$img";
                    $this->zip->read_file($filepath3);
                }
                if($resp[0]->survey_angle4 != ''){
                    $img = $resp[0]->survey_angle4;
                   echo $filepath4 = FCPATH."/site_image/$img";
                    $this->zip->read_file($filepath4);
                }

               
               $name = str_replace(' ', '_', $name);
               // Download
               $filename = $name.".zip";
               $this->zip->download($filename);
              
            }
            
                $this->load->library('mainlogin');
                $resp_survey_list =  $this->mainlogin->all_sit_survey_list();
                $final_list = array();
                $i = 0;
                foreach ($resp_survey_list as $key => $value) {
                    $site_survey_id = $value->site_survey_id;
                    $final_list[$i]['site_survey_id'] = $site_survey_id;
                    $final_list[$i]['survey_emp_name'] = $value->survey_emp_name;
                    $final_list[$i]['survey_emp_mobile'] = $value->survey_emp_mobile;
                    $final_list[$i]['survey_site_name'] = $value->survey_site_name;
                    $final_list[$i]['project_work_order_no'] = $value->project_work_order_no;
                    $final_list[$i]['coordinator_id'] = $value->coordinator_id;
                    $final_list[$i]['survey_lat'] = $value->survey_lat;
                    $final_list[$i]['survey_long'] = $value->survey_long;
                    $final_list[$i]['survey_location'] = $value->survey_location;
                    $final_list[$i]['site_status'] = $value->site_status;
                    $final_list[$i]['survey_date'] = $value->survey_date;
                    $final_list[$i]['survey_site_id'] = $value->survey_site_id;
                    $condition = array(
                        'site_survey_id' => $site_survey_id
                    );
                    $table2 = "eti_site_survey_expense";
                    $survey_exp_resp =  $this->mainlogin->sit_expense_details_by_condition($table2,$condition);
                    $expenseType = "";
                    $expenseExpense = "";
                    $total = 0;
                    foreach ($survey_exp_resp as $key => $valu2) {
                        $expenseType .= $valu2->expense_type."<br/>";
                        $expenseExpense .= $valu2->expense."<br/>";
                        $total = $total + $valu2->expense;
                    }
                    
                    $final_list[$i]['expense_type'] = $expenseType;
                    $final_list[$i]['expense'] = $expenseExpense;
                    $final_list[$i]['total_expense'] = $total;
                    
                    $i = $i+1;
                }
                $data = array(
                        'final_list' => $final_list
                        );
                $this->load->view('all_site_survey_list_with_expense',$data);
        }
        
         // all active site survey list
        public function all_site_survey_list() {
            $this->enter();
            if($this->input->post('survey_id') != NULL){
                
               echo $survey_id = $this->input->post('survey_id');
               
                //load mainligin library
                $this->load->library('mainlogin');
                $resp =  $this->mainlogin->site_survey_pic_name($survey_id);
                
                print_r($resp);
                echo $name = $resp[0]->survey_site_name;
                $this->zip->read_dir($name);
                if($resp[0]->survey_angle1 != ''){
                    $img = $resp[0]->survey_angle1;
                   echo $filepath1 = FCPATH."/site_image/$img";
                    $this->zip->read_file($filepath1);
                }
                if($resp[0]->survey_angle2 != ''){
                    $img = $resp[0]->survey_angle2;
                   echo $filepath2 = FCPATH."/site_image/$img";
                    $this->zip->read_file($filepath2);
                }
                if($resp[0]->survey_angle3 != ''){
                    $img = $resp[0]->survey_angle3;
                   echo $filepath3 = FCPATH."/site_image/$img";
                    $this->zip->read_file($filepath3);
                }
                if($resp[0]->survey_angle4 != ''){
                    $img = $resp[0]->survey_angle4;
                   echo $filepath4 = FCPATH."/site_image/$img";
                    $this->zip->read_file($filepath4);
                }

               
               $name = str_replace(' ', '_', $name);
               // Download
               $filename = $name.".zip";
               $this->zip->download($filename);
              
            }
            if($this->session->userdata['admin_in']['role'] == 5){
                $this->load->library('mainlogin');
                $emp_id = $this->session->userdata['admin_in']['admin_id'];
                $table = "coordinator";
                $condition = array(
                    'emp_id' => $emp_id
                );
                $coordinator_resp =  $this->mainlogin->get_detaild_by_conditions($table,$condition);
                $coordinator_id = $coordinator_resp[0]->coordinator_id;
                
                $resp =  $this->mainlogin->all_sit_survey_list_by_coordinator($coordinator_id);
                $data = array(
                        'resp' => $resp
                        );
                $this->load->view('all_site_survey_list',$data);
            }
            else{
                $this->load->library('mainlogin');
                $resp =  $this->mainlogin->all_sit_survey_list();
                $data = array(
                        'resp' => $resp
                        );
                $this->load->view('all_site_survey_list',$data);
            }
        }
        
        // get site survey expense detais where expense is not approved by coordinator
        public function all_site_expense_details($site_survey_id = NULL, $survey_date = NULL) {
            $this->enter();
            $this->load->library('mainlogin');
            $condition = array(
                'site_survey_id' => $site_survey_id
            );
            $table = "eti_site_survey";
            $site_resp =  $this->mainlogin->sit_survey_detais_with_coordinator_and_project($site_survey_id);
            $table2 = "eti_site_survey_expense";
            $exp_resp =  $this->mainlogin->sit_expense_details_by_condition($table2,$condition);
            $coordinator_id = $site_resp[0]->coordinator_id;
            $table3 = "project";
            $condition3 = array(
                'status' => 1
            );
            $project_resp =  $this->mainlogin->get_detaild_by_conditions($table3,$condition3);
            $condition4 = array('status' => 1);
            $table4 = "coordinator";
            $coordinator_resp =  $this->mainlogin->get_detaild_by_conditions($table4,$condition4);
            $data = array(
                    'site_resp' => $site_resp,
                    'exp_resp' => $exp_resp,
                    'project_resp' => $project_resp,
                    'coordinator_resp' => $coordinator_resp
                );
            $this->load->view('all_site_expense_details',$data);
        }
        
        //change coordinator
        public function change_survey_coordinator() {
            $this->enter();
            $method = $_SERVER['REQUEST_METHOD'];
            $params = $_REQUEST;
            $this->load->library('mainlogin');
            $data = array();
            if(isset($params['coordinator']) & isset($params['site_survey_id'])){
                $site_survey_id = $params['site_survey_id'];
                $coordinator = $params['coordinator'];
                $table = "eti_site_survey";
                $condition = array('site_survey_id' => $site_survey_id);
                $data = array('coordinator_id' => $coordinator);
                $response = $this->mainlogin->update_data($table,$condition,$data);
                $resp = array(
                    'message' => 'Coordinator Changed Successfully!'
                );
            }else{
                $resp = array(
                    'message' => 'Coordinator Can Not Changed Successfully'
                ); 
            }
                
                $this->load->view('defalt-message-page',$resp);
        }
        
        // get site survey list where expense is not approved by coordinator
        public function site_survey_list() {
            $this->enter();
            if($this->input->post('survey_id') != NULL){
                
               echo $survey_id = $this->input->post('survey_id');
               
                //load mainligin library
                $this->load->library('mainlogin');
                $resp =  $this->mainlogin->site_survey_pic_name($survey_id);
                
                print_r($resp);
                echo $name = $resp[0]->survey_site_name;
                $this->zip->read_dir($name);
                if($resp[0]->survey_angle1 != ''){
                    $img = $resp[0]->survey_angle1;
                   echo $filepath1 = FCPATH."/site_image/$img";
                    $this->zip->read_file($filepath1);
                }
                if($resp[0]->survey_angle2 != ''){
                    $img = $resp[0]->survey_angle2;
                   echo $filepath2 = FCPATH."/site_image/$img";
                    $this->zip->read_file($filepath2);
                }
                if($resp[0]->survey_angle3 != ''){
                    $img = $resp[0]->survey_angle3;
                   echo $filepath3 = FCPATH."/site_image/$img";
                    $this->zip->read_file($filepath3);
                }
                if($resp[0]->survey_angle4 != ''){
                    $img = $resp[0]->survey_angle4;
                   echo $filepath4 = FCPATH."/site_image/$img";
                    $this->zip->read_file($filepath4);
                }

               
               $name = str_replace(' ', '_', $name);
               // Download
               $filename = $name.".zip";
               $this->zip->download($filename);
              
            }
            echo "role =".$this->session->userdata['admin_in']['role'];
            if($this->session->userdata['admin_in']['role'] == 5){
                $this->load->library('mainlogin');
                $emp_id = $this->session->userdata['admin_in']['admin_id'];
                $table = "coordinator";
                $condition = array(
                    'emp_id' => $emp_id
                );
                $coordinator_resp =  $this->mainlogin->get_detaild_by_conditions($table,$condition);
                $coordinator_id = $coordinator_resp[0]->coordinator_id;
                
                $resp =  $this->mainlogin->sit_survey_list_by_coordinator($coordinator_id);
                $data = array(
                        'resp' => $resp
                        );
                $this->load->view('site_survey_list',$data);
            }
            else{
                $this->load->library('mainlogin');
                $resp =  $this->mainlogin->sit_survey_list();
                $data = array(
                        'resp' => $resp
                        );
                $this->load->view('site_survey_list',$data);
            }
        }
        
        // get site survey expense detais where expense is not approved by coordinator
        public function site_expense_details($site_survey_id = NULL, $survey_date = NULL) {
            $this->enter();
            $this->load->library('mainlogin');
            $condition = array(
                'site_survey_id' => $site_survey_id
            );
            $table = "eti_site_survey";
            $site_resp =  $this->mainlogin->sit_survey_detais_with_coordinator_and_project($site_survey_id);
            $table2 = "eti_site_survey_expense";
            $exp_resp =  $this->mainlogin->sit_expense_details_by_condition($table2,$condition);
            $coordinator_id = $site_resp[0]->coordinator_id;
            $table3 = "project";
            $condition3 = array(
                'status' => 1
            );
            $project_resp =  $this->mainlogin->get_detaild_by_conditions($table3,$condition3);
            $data = array(
                    'site_resp' => $site_resp,
                    'exp_resp' => $exp_resp,
                    'project_resp' => $project_resp
                );
            $this->load->view('site_expense_details',$data);
        }
        
        // approved_expense_by_coordinator() is used to approved site survey expense by coodinator
        public function approved_expense_by_coordinator(){
            $this->enter();
            $method = $_SERVER['REQUEST_METHOD'];
            $params = $_REQUEST;
            
            $data = array();
            if(isset($params['eti_survey_expense_id']) & isset($params['site_survey_id']) & isset($params['expense_by_coordinator']) & isset($params['expense_status_by_coordinator']) & isset($params['coordinator_comment']) & isset($params['project_work_order_no'])){
                $eti_survey_expense_id = $params['eti_survey_expense_id'];
                $site_survey_id = $params['site_survey_id'];
                $expense_by_coordinator = $params['expense_by_coordinator'];
                $coordinator_comment = $params['coordinator_comment'];
                $expense_status = $params['expense_status_by_coordinator'];
                $project_work_order_no = $params['project_work_order_no'];
//                $expenseByCoordinator = explode(',',$expense_by_coordinator);
//                $expenseStatus = explode(',',$expense_status);
//                $coordinatorComment = explode(',',$coordinator_comment);
                date_default_timezone_set('Asia/Kolkata');
                $last_update = date('Y-m-d H:i:s');
                $coordinator_id = $this->session->userdata['admin_in']['admin_id'];;
                $table1 = "eti_site_survey_expense";
                $table2 = "eti_site_survey";
                if(!empty($eti_survey_expense_id)){
                   for($i=0;$i<count($eti_survey_expense_id);$i++){
                                $expenseId = $eti_survey_expense_id[$i];
                                $condition1 = array('eti_survey_expense_id' => $expenseId );
                                $data = array(
                                        'expense_by_coordinator' => $expense_by_coordinator[$i],
                                        'remaining_amount' => $expense_by_coordinator[$i],
                                        'expense_status_by_coordinator' => $expense_status,
                                        'coordinator_comment' => $coordinator_comment[$i],
                                        'coordinator_id' => $coordinator_id,
                                        'coordinator_updated_date' => $last_update,
                                        );
                                $response = $this->mainlogin->update_data($table1,$condition1,$data);
                    }
                    $condition2 = array('site_survey_id' => $site_survey_id );
                    $data2 = array('expense_status_by_coordinator' => $expense_status,
                                    'project_work_order_no' => $project_work_order_no
                                    );
                    $response = $this->mainlogin->update_data($table2,$condition2,$data2);
                    $resp = array(
                        'message' => 'Expense details updated successfully by coordinator!'
                    ); 
                }else{
                   $resp = array(
                        'message' => 'Expense details Not Found!'
                    ); 
                }
                
                $this->load->view('defalt-message-page',$resp);
            }
            else{
                $resp = array(
                    'message' => 'Something Wrong, Please Try Again!'
                );
                $this->load->view('defalt-message-page',$resp);
                
            }
        }
        
        // site survey list where status approved by coordinator
        public function site_survey_list_approved_by_coordinator() {
            $this->enter();
            if($this->input->post('survey_id') != NULL){
                
               echo $survey_id = $this->input->post('survey_id');
               
                //load mainligin library
                $this->load->library('mainlogin');
                $resp =  $this->mainlogin->site_survey_pic_name($survey_id);
                
                print_r($resp);
                echo $name = $resp[0]->survey_site_name;
                $this->zip->read_dir($name);
                if($resp[0]->survey_angle1 != ''){
                    $img = $resp[0]->survey_angle1;
                   echo $filepath1 = FCPATH."/site_image/$img";
                    $this->zip->read_file($filepath1);
                }
                if($resp[0]->survey_angle2 != ''){
                    $img = $resp[0]->survey_angle2;
                   echo $filepath2 = FCPATH."/site_image/$img";
                    $this->zip->read_file($filepath2);
                }
                if($resp[0]->survey_angle3 != ''){
                    $img = $resp[0]->survey_angle3;
                   echo $filepath3 = FCPATH."/site_image/$img";
                    $this->zip->read_file($filepath3);
                }
                if($resp[0]->survey_angle4 != ''){
                    $img = $resp[0]->survey_angle4;
                   echo $filepath4 = FCPATH."/site_image/$img";
                    $this->zip->read_file($filepath4);
                }

               
               $name = str_replace(' ', '_', $name);
               // Download
               $filename = $name.".zip";
               $this->zip->download($filename);
              
            }
            if($this->session->userdata['admin_in']['role'] == 5){
                $this->load->library('mainlogin');
                $emp_id = $this->session->userdata['admin_in']['admin_id'];
                $table = "coordinator";
                $condition = array(
                    'emp_id' => $emp_id
                );
                $coordinator_resp =  $this->mainlogin->get_detaild_by_conditions($table,$condition);
                $coordinator_id = $coordinator_resp[0]->coordinator_id;
                
                $resp =  $this->mainlogin->sit_survey_expense_list_approved_by_coordinator_with_coordinator_id($coordinator_id);
                $data = array(
                        'resp' => $resp
                        );
                $this->load->view('site_survey_list_approved_by_coordinator',$data);
            }
            else{
                $this->load->library('mainlogin');
                $resp =  $this->mainlogin->sit_survey_expense_list_approved_by_coordinator();
                $data = array(
                        'resp' => $resp
                        );
                $this->load->view('site_survey_list_approved_by_coordinator',$data);
            }
        }
        
        public function upload() {
            $this->load->library('mainlogin');
            $this->load->model('LoginModel');
            $method = $_SERVER['REQUEST_METHOD'];
            if(isset($_POST['user_name'])){
                $post=$this->input->post();
                echo $user_name = $post['user_name'];
                $panditdata = array('verified' => 2);
                $response = $this->LoginModel->all_query($user_name);
                $data['response'] = $response;
                print_r($response);
                $this->load->view('upload',$data);
            }else{
            $this->load->view('upload');
            }
        }
        
        // site survey expense details where expense approved by coordinator
        public function site_expense_details_approved_by_coordinator($site_survey_id = NULL) {
            $this->enter();
            $this->load->library('mainlogin');
            $condition = array(
                'site_survey_id' => $site_survey_id
            );
            $table = "eti_site_survey";
            $site_resp =  $this->mainlogin->sit_survey_detais_with_coordinator_and_project($site_survey_id);
            $table2 = "eti_site_survey_expense";
            $exp_resp =  $this->mainlogin->sit_expense_details_by_condition($table2,$condition);
            $coordinator_id = $site_resp[0]->coordinator_id;
            $table3 = "coordinator";
            $condition3 = array(
                'coordinator_id' => $coordinator_id
            );
            $coordinator_resp =  $this->mainlogin->get_detaild_by_conditions($table3,$condition3);
            $data = array(
                    'site_resp' => $site_resp,
                    'exp_resp' => $exp_resp,
                    'coordinator_resp' => $coordinator_resp
                );
            $this->load->view('site_expense_details_approved_by_coordinator',$data);
        }
        
        // site survey expense approved by project manager
        public function approved_expense_by_project_manager(){
            $this->enter();
            $method = $_SERVER['REQUEST_METHOD'];
            $params = $_REQUEST;
            
            $data = array();
            if(isset($params['eti_survey_expense_id']) & isset($params['site_survey_id'])){
                $eti_survey_expense_id = $params['eti_survey_expense_id']; 
                $site_survey_id = $params['site_survey_id'];
            }
            else{
//                echo json_encode(array('status' => 401,'message' => 'Expense is compulsory.'));
                $resp = array(
                    'message' => 'Expense-Id is compulsory.!'
                );
                $this->load->view('defalt-message-page',$resp);
                exit();
            }
            
            if(isset($params['project_manager_comment']) & isset($params['expense_approved_by_project_manager'])){
                $project_manager_comment = $params['project_manager_comment'];
                $expense_approved_by_project_manager = $params['expense_approved_by_project_manager'];
                date_default_timezone_set('Asia/Kolkata');
                $last_update = date('Y-m-d H:i:s');
                $table1 = "eti_site_survey_expense";
                $table2 = "eti_site_survey";
                if(!empty($eti_survey_expense_id)){
                   for($i=0;$i<count($eti_survey_expense_id);$i++){
                                $expenseId = $eti_survey_expense_id[$i];
                                $condition1 = array('eti_survey_expense_id' => $expenseId );
                                $data = array('project_manager_comment' => $project_manager_comment[$i],
                                        'expense_approved_by_project_manager' => $expense_approved_by_project_manager,
                                        'project_manager_updated_date' => $last_update,
                                        );
                                $response = $this->mainlogin->update_data($table1,$condition1,$data);
                    }
                    $response = $this->mainlogin->update_data($table1,$condition1,$data);
                    $condition2 = array('site_survey_id' => $site_survey_id );
                    $data2 = array('expense_approved_by_project_manager' => $expense_approved_by_project_manager);
                    $response2 = $this->mainlogin->update_data($table2,$condition2,$data2);
                    $resp = array(
                        'message' => 'Expense approved by project manager!'
                    ); 
                }else{
                   $resp = array(
                        'message' => 'Expense details Not Found!'
                    ); 
                }
                
                $this->load->view('defalt-message-page',$resp);
            }
            else{
                $resp = array(
                    'message' => 'Something Wrong, Please Try Again!'
                );
                $this->load->view('defalt-message-page',$resp);
                exit();
            }
        }
        
        // site survey expense list where expense approved by project manager
        public function site_survey_list_approved_by_coordinator_and_project_manager() {
            $this->enter();
            if($this->input->post('survey_id') != NULL){
                
               echo $survey_id = $this->input->post('survey_id');
               
                //load mainligin library
                $this->load->library('mainlogin');
                $resp =  $this->mainlogin->site_survey_pic_name($survey_id);
                
                print_r($resp);
                echo $name = $resp[0]->survey_site_name;
                $this->zip->read_dir($name);
                if($resp[0]->survey_angle1 != ''){
                    $img = $resp[0]->survey_angle1;
                   echo $filepath1 = FCPATH."/site_image/$img";
                    $this->zip->read_file($filepath1);
                }
                if($resp[0]->survey_angle2 != ''){
                    $img = $resp[0]->survey_angle2;
                   echo $filepath2 = FCPATH."/site_image/$img";
                    $this->zip->read_file($filepath2);
                }
                if($resp[0]->survey_angle3 != ''){
                    $img = $resp[0]->survey_angle3;
                   echo $filepath3 = FCPATH."/site_image/$img";
                    $this->zip->read_file($filepath3);
                }
                if($resp[0]->survey_angle4 != ''){
                    $img = $resp[0]->survey_angle4;
                   echo $filepath4 = FCPATH."/site_image/$img";
                    $this->zip->read_file($filepath4);
                }

               
               $name = str_replace(' ', '_', $name);
               // Download
               $filename = $name.".zip";
               $this->zip->download($filename);
              
            }
            if($this->session->userdata['admin_in']['role'] == 5){
                $this->load->library('mainlogin');
                $emp_id = $this->session->userdata['admin_in']['admin_id'];
                $table = "coordinator";
                $condition = array(
                    'emp_id' => $emp_id
                );
                $coordinator_resp =  $this->mainlogin->get_detaild_by_conditions($table,$condition);
                $coordinator_id = $coordinator_resp[0]->coordinator_id;
                
                $resp =  $this->mainlogin->sit_survey_expense_list_approved_by_coordinator_with_coordinator_id($coordinator_id);
                $data = array(
                        'resp' => $resp
                        );
                $this->load->view('site_survey_list_approved_by_coordinator',$data);
            }
            else{
                $this->load->library('mainlogin');
                $resp =  $this->mainlogin->sit_survey_expense_list_approved_by_project_manager();
                $data = array(
                        'resp' => $resp
                        );
                $this->load->view('sit_survey_expense_list_approved_by_project_manager',$data);
            }
        }
        
        // site survey expense details where expense approved by project manager
        public function site_expense_details_approved_by_project_manager($site_survey_id = NULL) {
            $this->enter();
            $this->load->library('mainlogin');
            $condition = array(
                'site_survey_id' => $site_survey_id
            );
            $table = "eti_site_survey";
            $site_resp =  $this->mainlogin->sit_survey_detais_approved_project_manager($site_survey_id);
            $table2 = "eti_site_survey_expense";
            $exp_resp =  $this->mainlogin->sit_expense_details_by_condition($table2,$condition);
            $coordinator_id = $site_resp[0]->coordinator_id;
            $table3 = "coordinator";
            $condition3 = array(
                'coordinator_id' => $coordinator_id
            );
            $coordinator_resp =  $this->mainlogin->get_detaild_by_conditions($table3,$condition3);
            $data = array(
                    'site_resp' => $site_resp,
                    'exp_resp' => $exp_resp,
                    'coordinator_resp' => $coordinator_resp
                );
            $this->load->view('site_expense_details_approved_by_project_manager',$data);
        }
        
        // site_expense_paid_by_accountant() paid site survey expense by accountant
        public function site_expense_paid_by_accountant() {
            $this->enter();
            $this->load->library('mainlogin');
            $method = $_SERVER['REQUEST_METHOD'];
            $params = $_REQUEST;
            $data2 = array();
            if(isset($params['eti_survey_expense_id']) & isset($params['site_survey_id'])){
                $eti_survey_expense_id = $params['eti_survey_expense_id']; 
                $site_survey_id = $params['site_survey_id'];
                if(isset($params['name'])){
                    $data2['employee_name'] = $params['name'];
                }
                if(isset($params['project_work_order_no'])){
                    $data2['woc'] = $params['project_work_order_no'];
                    $woc = $params['project_work_order_no'];;
                }
                if(isset($params['coordinator'])){
                    $data2['coordinator'] = $params['coordinator'];
                }
                if(isset($params['accounting_head'])){
                    $data2['accounting_head'] = $params['accounting_head'];
                }
                if(isset($params['survey_remark'])){
                    $data2['remark'] = $params['survey_remark'];
                }
                if(isset($params['site_location'])){
                    $data2['location'] = $params['site_location'];
                }
                date_default_timezone_set('Asia/Kolkata');
                $last_update = date('Y-m-d H:i:s');
                $data2['description'] = "Site Survey expense";
                if($woc != '' & $woc != NULL){
                    $woc_resp =  $this->mainlogin->get_client_details_by_woc($woc);
                    if(!empty($woc_resp)){
                       $data2['client_name'] = $woc_resp[0]->client_name;
                       $data2['project_name'] = $woc_resp[0]->project_name;
                    }
                }
                if(isset($params['status_by_project_manager']) & isset($params['paid_amount']) & isset($params['paid_amount_status_by_accountant']) & isset($params['remaining_amount'])){
                    $paid_amount_status_by_accountant = $params['paid_amount_status_by_accountant'];
                    $paid_amount = $params['paid_amount'];
                    $status_by_project_manager = $params['status_by_project_manager'];
                    $remaining_amount = $params['remaining_amount'];
                    $table1 = "eti_site_survey_expense";
                    $table2 = "eti_site_survey";
                    $table3 = "expense_sheet";
                    $created_by = $this->session->userdata['admin_in']['admin_id'];
                    if(!empty($eti_survey_expense_id)){
                       for($i=0;$i<count($eti_survey_expense_id);$i++){
                                    $expenseId = $eti_survey_expense_id[$i];
                                    if($status_by_project_manager[$i] == "Approved"){
                                    $expense_data = array();
                                    $condition1 = array('eti_survey_expense_id' => $expenseId );
                                    $rmainingAmount = $remaining_amount[$i] - $paid_amount[$i];
                                    $data = array('paid_amount' => $paid_amount[$i],
                                            'paid_amount_status_by_accountant' => $paid_amount_status_by_accountant[$i],
                                            'remaining_amount' => $rmainingAmount,
                                            'paid_by' => $created_by,
                                            'accountant_updated_date' => $last_update,
                                            );
                                    $response = $this->mainlogin->update_data($table1,$condition1,$data);
                                    $expense_data = $data2;
                                    $expense_data['debit_amount'] = $paid_amount[$i];
                                    $expense_data['payment_date'] = $last_update;
                                    $expense_data['paid_by'] = $created_by;
                                    $response2 = $this->mainlogin->insert($table3,$expense_data);   
                                    }
                                    
                        }
                        
                        if(isset($params['final_paid_amount_status_by_accountant'])){
                            $condition2 = array('site_survey_id' => $site_survey_id );
                            
                            $paid_amount_status_by_accountant = $params['final_paid_amount_status_by_accountant'];
                            $data3 = array('paid_amount_status_by_accountant' => $paid_amount_status_by_accountant);
                            $response3 = $this->mainlogin->update_data($table2,$condition2,$data3);
                        }
                        
                        $resp = array(
                            'message' => 'Expense paid by accountant!'
                        ); 
                    }else{
                       $resp = array(
                            'message' => 'Expense can not paid!'
                        ); 
                    }
                
                $this->load->view('defalt-message-page',$resp);
            }
            }
            else{
                echo json_encode(array('status' => 401,'message' => 'Expense is compulsory.'));
                $resp = array(
                    'message' => 'Expense-Id is compulsory.!'
                );
                $this->load->view('defalt-message-page',$resp);
            }
        }
        
        // site survey expense list where expense partial paid by accountant
        public function site_survey_list_where_partial_paid() {
            $this->enter();
            if($this->input->post('survey_id') != NULL){
                
               echo $survey_id = $this->input->post('survey_id');
               
                //load mainligin library
                $this->load->library('mainlogin');
                $resp =  $this->mainlogin->site_survey_pic_name($survey_id);
                
                print_r($resp);
                echo $name = $resp[0]->survey_site_name;
                $this->zip->read_dir($name);
                if($resp[0]->survey_angle1 != ''){
                    $img = $resp[0]->survey_angle1;
                   echo $filepath1 = FCPATH."/site_image/$img";
                    $this->zip->read_file($filepath1);
                }
                if($resp[0]->survey_angle2 != ''){
                    $img = $resp[0]->survey_angle2;
                   echo $filepath2 = FCPATH."/site_image/$img";
                    $this->zip->read_file($filepath2);
                }
                if($resp[0]->survey_angle3 != ''){
                    $img = $resp[0]->survey_angle3;
                   echo $filepath3 = FCPATH."/site_image/$img";
                    $this->zip->read_file($filepath3);
                }
                if($resp[0]->survey_angle4 != ''){
                    $img = $resp[0]->survey_angle4;
                   echo $filepath4 = FCPATH."/site_image/$img";
                    $this->zip->read_file($filepath4);
                }

               
               $name = str_replace(' ', '_', $name);
               // Download
               $filename = $name.".zip";
               $this->zip->download($filename);
              
            }
            if($this->session->userdata['admin_in']['role'] == 5){
                $this->load->library('mainlogin');
                $emp_id = $this->session->userdata['admin_in']['admin_id'];
                $table = "coordinator";
                $condition = array(
                    'emp_id' => $emp_id
                );
                $coordinator_resp =  $this->mainlogin->get_detaild_by_conditions($table,$condition);
                $coordinator_id = $coordinator_resp[0]->coordinator_id;
                
                $resp =  $this->mainlogin->sit_survey_expense_list_approved_by_coordinator_with_coordinator_id($coordinator_id);
                $data = array(
                        'resp' => $resp
                        );
                $this->load->view('site_survey_list_approved_by_coordinator',$data);
            }
            else{
                $this->load->library('mainlogin');
                $resp =  $this->mainlogin->sit_survey_list_partial_paid_by_accountant();
                $data = array(
                        'resp' => $resp
                        );
                $this->load->view('sit_survey_expense_list_partial_paid_by_accountant',$data);
            }
        }
        
        public function site_expense_details_partial_paid($site_survey_id = NULL) {
            $this->enter();
            $this->load->library('mainlogin');
            $condition = array(
                'site_survey_id' => $site_survey_id
            );
            $condition2 = array(
                'site_survey_id' => $site_survey_id,
                'paid_amount_status_by_accountant' => 'Partial Paid',
            );
            $table = "eti_site_survey";
            $site_resp =  $this->mainlogin->sit_survey_detais_approved_project_manager($site_survey_id);
            $table2 = "eti_site_survey_expense";
            $exp_resp =  $this->mainlogin->sit_expense_details_by_condition($table2,$condition2);
            $coordinator_id = $site_resp[0]->coordinator_id;
            $table3 = "coordinator";
            $condition3 = array(
                'coordinator_id' => $coordinator_id
            );
            $coordinator_resp =  $this->mainlogin->get_detaild_by_conditions($table3,$condition3);
            $data = array(
                    'site_resp' => $site_resp,
                    'exp_resp' => $exp_resp,
                    'coordinator_resp' => $coordinator_resp
                );
            $this->load->view('site_expense_details_partial_paid',$data);
        }
        
        public function add_employee() {
            $this->enter();
            $condition = array('status' => 1);
            $table1 = "department";
            $department_resp =  $this->mainlogin->get_detaild_by_conditions($table1,$condition);
            $table2 = "designation";
            $designation_resp =  $this->mainlogin->get_detaild_by_conditions($table2,$condition);
            $table3 = "technology";
            $technology_resp =  $this->mainlogin->get_detaild_by_conditions($table3,$condition);
            $data = array(  'department_resp' => $department_resp,
                    'designation_resp' => $designation_resp,
                    'technology_resp' => $technology_resp,);
            $this->load->view('add_employee',$data);
        }
        
        public function register_employee(){
            $this->enter();
            $method = $_SERVER['REQUEST_METHOD'];
            $params = $_REQUEST;
            
            $data = array();
            if(isset($params['name1'])){
                $name = $params['name1']; 
                $data['emp_name'] = $name; 
            }
            else{
                echo json_encode(array('status' => 401,'message' => 'Employee name is compulsory.'));
                exit();
            }
            
            if(isset($params['employee_id'])){
                $employee_id = $params['employee_id'];
                $data['emp_username'] = $employee_id; 
            }
            else{
                echo json_encode(array('status' => 401,'message' => 'Employee-ID is compulsory.'));
                exit();
            }
            
            if(isset($params['mobile'])){
                $mobile = $params['mobile']; 
                $data['emp_mobile'] = $mobile; 
            }
            
            if(isset($params['email'])){
                $data['emp_email'] = $params['email']; 
            }
            else{
                echo json_encode(array('status' => 401,'message' => 'Email-Id is compulsory.'));
                exit();
            }
            
            if(isset($params['password'])){
                $password = $params['password'];
                $password = $this->encryption->encrypt($password);
                $data['emp_password'] = $password;  
            }
            else{
                echo json_encode(array('status' => 401,'message' => 'Password is compulsory.'));
                exit();
            }
            
            if(isset($params['training_days'])){
                $data['emp_training_days'] = $params['training_days']; 
            }
            
            if(isset($params['blood_group'])){
                $data['emp_blood_group'] = $params['blood_group']; 
            }
            
            if(isset($params['fname'])){
                $data['emp_father'] = $params['fname']; 
            }
            
            if(isset($params['mname'])){
                $data['emp_mother'] = $params['mname']; 
            }
            
            if(isset($params['dob'])){
                $data['emp_dob'] = $params['dob']; 
            }
            
            if(isset($params['joining_date'])){
                $data['emp_joining_date'] = $params['joining_date']; 
            }
            
            if(isset($params['qualification'])){
                $data['emp_qualification'] = $params['qualification']; 
            }
            
            if(isset($params['family_contact'])){
                $data['emp_family_contact'] = $params['family_contact']; 
            }
            
            if(isset($params['current_address'])){
                $data['emp_temp_address'] = $params['current_address']; 
            }
            
            if(isset($params['current_city'])){
                $data['emp_temp_city'] = $params['current_city']; 
            }
            
            if(isset($params['current_state'])){
                $data['emp_temp_state'] = $params['current_state']; 
            }
            
            if(isset($params['permanent_address'])){
                $data['emp_parmanent_address'] = $params['permanent_address']; 
            }
            
            if(isset($params['permanent_city'])){
                $data['emp_parmanent_city'] = $params['permanent_city']; 
            }
            
            if(isset($params['permanent_state'])){
                $data['emp_parmanent_state'] = $params['permanent_state']; 
            }
            
            if(isset($params['technology_id'])){
                $data['technology_id'] = $params['technology_id']; 
            }
            
            if(isset($params['designation_id'])){
                $data['designation_id'] = $params['designation_id']; 
            }
            
            if(isset($params['department_id'])){
                $data['department_id'] = $params['department_id']; 
            }
            
            $check_data = array(
                'emp_username' => $employee_id
            );
            $table = 'employee';
            $this->load->library('mainlogin');
            
            if($this->mainlogin->check_user_exist($table,$check_data) == TRUE){
                unset($data['emp_username']); 
//                $response =  $this->mainlogin->update_data($table,$check_data,$data);
//                print_r($data);
                echo "Employee already registered!";
            }else{
                $response =  $this->mainlogin->insert($table,$data);
                $emp_id = $response['insert_id'];
                    if($emp_id != ''){
                        
                        // bank details
                        if(isset($params['bank_name']) & isset($params['account_number'])){
                        $bank_data = array();
                        $bank_table = "employee_bank_details";
                        $bank_data['emp_id'] = $emp_id;
                        $bank_data['emp_username'] = $employee_id;
                        $bank_data['emp_bank_name'] = $params['bank_name']; 
                        $bank_data['emp_account_no'] = $params['account_number'];
                        if(isset($params['ifsc'])){
                            $bank_data['emp_bank_ifsc'] = $params['ifsc']; 
                        }
                        if(isset($params['account_holder'])){
                            $bank_data['emp_account_holder'] = $params['account_holder']; 
                        }
                        $bank_response =  $this->mainlogin->insert($bank_table,$bank_data);
                    }
                    
                    // salary details
                     if(isset($params['gross_salary']) & isset($params['net_salary'])){
                        $salary_data = array();
                        $salary_table = "employee_salary";
                        $salary_data['emp_id'] = $emp_id;
                        $salary_data['emp_username'] = $employee_id;
                        $salary_data['emp_salary_net'] = $params['net_salary'];
                        $salary_data['emp_salary_gross'] = $params['gross_salary'];
                        if(isset($params['pf'])){
                            $salary_data['emp_salary_pf'] = $params['pf']; 
                        }
                        
                        if(isset($params['esic'])){
                            $salary_data['emp_salary_esic'] = $params['esic']; 
                        }
                        
                        if(isset($params['tax'])){
                            $salary_data['emp_salary_tax'] = $params['tax']; 
                        }
                        
                        if(isset($params['other'])){
                            $salary_data['emp_salary_other'] = $params['other']; 
                        }
                        
                        if(isset($params['insurance'])){
                            $salary_data['emp_salary_insurance'] = $params['insurance']; 
                        }
                        
                        if(isset($params['ta'])){
                            $salary_data['emp_salary_ta'] = $params['ta']; 
                        }
                        
                        if(isset($params['da'])){
                            $salary_data['emp_salary_da'] = $params['da']; 
                        }
                        
                        $bank_response =  $this->mainlogin->insert($salary_table,$salary_data);
                     }   
                    
                }
                
               echo "Employee successfuly registered!";
            }
            
            
        }
        
        public function employee_list() {
            $this->load->library('mainlogin');
//            $resp =  $this->mainlogin->employee_list_with_designation();
            $resp =  $this->mainlogin->employee_list();
            $this->enter();
            $data = array(
                    'resp' => $resp
                    );
            $this->load->view('employeelist',$data);
        }
        
        public function employee_details($emp_id = NULL) {
            $method = $_SERVER['REQUEST_METHOD'];
            $params = $_REQUEST;
            $this->enter();
            $condition = array(
                'emp_id' => $emp_id,
            );
            $condition2 = array(
                'status' => 1
            );
            $table = "employee";
            $emp_resp =  $this->mainlogin->sit_survey_details_by_condition($table,$condition);
            $table2 = "employee_salary";
            $salary_resp =  $this->mainlogin->sit_expense_details_by_condition($table2,$condition);
            $table3 = "employee_bank_details";
            $bank_resp =  $this->mainlogin->sit_expense_details_by_condition($table3,$condition);
            $table4 = "department";
            $department_resp =  $this->mainlogin->get_detaild_by_conditions($table4,$condition2);
            $table5 = "designation";
            $designation_resp =  $this->mainlogin->get_detaild_by_conditions($table5,$condition2);
            $table6 = "technology";
            $technology_resp =  $this->mainlogin->get_detaild_by_conditions($table6,$condition2);
            $data = array(  'department_resp' => $department_resp,
                    'designation_resp' => $designation_resp,
                    'technology_resp' => $technology_resp,
                    'emp_resp' => $emp_resp,
                    'salary_resp' => $salary_resp,
                    'bank_resp' => $bank_resp
                );
            $this->load->view('employee_details',$data);
        }
        
        public function update_employee_details(){
            $this->enter();
            $method = $_SERVER['REQUEST_METHOD'];
            $params = $_REQUEST;
            
            $data = array();
            $condition = array();
            if(isset($params['name'])){
                $name = $params['name']; 
                $data['emp_name'] = $name; 
            }
            else{
                echo json_encode(array('status' => 401,'message' => 'Employee name is compulsory.'));
                exit();
            }
            
            if(isset($params['employee_id'])){
                $employee_id = $params['employee_id'];
                $condition['emp_username'] = $employee_id; 
            }
            else{
                echo json_encode(array('status' => 401,'message' => 'Employee-ID is compulsory.'));
                exit();
            }
            
            if(isset($params['emp_id'])){
                $emp_id = $params['emp_id'];
                $condition['emp_id'] = $emp_id; 
            }
            else{
                echo json_encode(array('status' => 401,'message' => 'Emp-ID is compulsory.'));
                exit();
            }
            
            if(isset($params['mobile'])){
                $mobile = $params['mobile']; 
                $data['emp_mobile'] = $mobile; 
            }
            
            if(isset($params['email'])){
                $data['emp_email'] = $params['email']; 
            }
            
            if(isset($params['training_days'])){
                $data['emp_training_days'] = $params['training_days']; 
            }
            
            if(isset($params['blood_group'])){
                $data['emp_blood_group'] = $params['blood_group']; 
            }
            
            if(isset($params['fname'])){
                $data['emp_father'] = $params['fname']; 
            }
            
            if(isset($params['mname'])){
                $data['emp_mother'] = $params['mname']; 
            }
            
            if(isset($params['dob'])){
                $data['emp_dob'] = $params['dob']; 
            }
            
            if(isset($params['joining_date'])){
                $data['emp_joining_date'] = $params['joining_date']; 
            }
            
            if(isset($params['qualification'])){
                $data['emp_qualification'] = $params['qualification']; 
            }
            
            if(isset($params['family_contact'])){
                $data['emp_family_contact'] = $params['family_contact']; 
            }
            
            if(isset($params['current_address'])){
                $data['emp_temp_address'] = $params['current_address']; 
            }
            
            if(isset($params['current_city'])){
                $data['emp_temp_city'] = $params['current_city']; 
            }
            
            if(isset($params['current_state'])){
                $data['emp_temp_state'] = $params['current_state']; 
            }
            
            if(isset($params['permanent_address'])){
                $data['emp_parmanent_address'] = $params['permanent_address']; 
            }
            
            if(isset($params['permanent_city'])){
                $data['emp_parmanent_city'] = $params['permanent_city']; 
            }
            
            if(isset($params['permanent_state'])){
                $data['emp_parmanent_state'] = $params['permanent_state']; 
            }
            
            if(isset($params['technology_id'])){
                $data['technology_id'] = $params['technology_id']; 
            }
            
            if(isset($params['designation_id'])){
                $data['designation_id'] = $params['designation_id']; 
            }
            
            if(isset($params['department_id'])){
                $data['department_id'] = $params['department_id']; 
            }
            
            $table = 'employee';
            $this->load->library('mainlogin');
             
                $emp_response =  $this->mainlogin->update_data($table,$condition,$data);

                        if(isset($params['bank_name']) & isset($params['account_number'])){
                        $bank_data = array();
                        $bank_table = "employee_bank_details";
                        $bank_data['emp_bank_name'] = $params['bank_name']; 
                        $bank_data['emp_account_no'] = $params['account_number'];
                        if(isset($params['ifsc'])){
                            $bank_data['emp_bank_ifsc'] = $params['ifsc']; 
                        }
                        if(isset($params['account_holder'])){
                            $bank_data['emp_account_holder'] = $params['account_holder']; 
                        }
                        $bank_response =  $this->mainlogin->update_data($bank_table,$condition,$bank_data);
                    }
                    
                    // salary details
                     if(isset($params['gross_salary']) & isset($params['net_salary'])){
                        $salary_data = array();
                        $salary_table = "employee_salary";
                        $salary_data['emp_salary_net'] = $params['net_salary'];
                        $salary_data['emp_salary_gross'] = $params['gross_salary'];
                        if(isset($params['pf'])){
                            $salary_data['emp_salary_pf'] = $params['pf']; 
                        }
                        
                        if(isset($params['esic'])){
                            $salary_data['emp_salary_esic'] = $params['esic']; 
                        }
                        
                        if(isset($params['tax'])){
                            $salary_data['emp_salary_tax'] = $params['tax']; 
                        }
                        
                        if(isset($params['other'])){
                            $salary_data['emp_salary_other'] = $params['other']; 
                        }
                        
                        if(isset($params['insurance'])){
                            $salary_data['emp_salary_insurance'] = $params['insurance']; 
                        }
                        
                        if(isset($params['ta'])){
                            $salary_data['emp_salary_ta'] = $params['ta']; 
                        }
                        
                        if(isset($params['da'])){
                            $salary_data['emp_salary_da'] = $params['da']; 
                        }
                        
                        $bank_response =  $this->mainlogin->update_data($salary_table,$salary_data,$salary_data);
                     }   
               echo "Employee details successfuly updated!";
        }
        
        public function employeeLoginActivation() {
            $this->load->library('mainlogin');
            $this->enter();
            if($this->input->post('emp_id') != NULL){
                $emp_id = $this->input->post('emp_id');
                $condition = array('emp_id' => $emp_id);
                $data = array('login_status' => 0);
                $table = "employee";
                $emp_response =  $this->mainlogin->update_data($table,$condition,$data);
            }
            $condition = array('login_status' => 1);
            $table = "employee";
            $resp =  $this->mainlogin->get_detaild_by_conditions($table,$condition);
            $data = array(
                    'resp' => $resp
                    );
            $this->load->view('employee_login_activation',$data);
        }
        
        public function coordinator() {
            $this->enter();   
            $data = array();
            if($this->input->post('action_name') == "add"){
            $emp_id = $this->input->post('emp_id');
            $table = 'coordinator';
            $check_data = array('emp_id' => $emp_id);
            $this->load->library('mainlogin');
                if($this->mainlogin->check_user_exist($table,$check_data) == TRUE){
                    $data['error'] = "Coordinator already registered!";
                }else{
                    $emp_table = "employee";
                    $emp_details =  $this->mainlogin->get_detaild_by_conditions($emp_table,$check_data);
                    $emp_name = $emp_details[0]->emp_name;
                    $insert_data = array(
                        'emp_id' => $emp_id,
                        'coordinator_name' => $emp_name
                    );
                    $response =  $this->mainlogin->insert($table,$insert_data);
                }
            }
            if($this->input->post('action_name') == "del"){
                $technology_name = $this->input->post('technology_name');
                $coordinator_id = $this->input->post('coordinator_id');
                $table = 'coordinator';
                $check_data = array('coordinator_id' => $coordinator_id);
                $response =  $this->mainlogin->delete_records($table,$check_data);
            }
            $condition = array('status' => 1);
            $table1 = "employee";
            $emp_resp =  $this->mainlogin->get_detaild_by_conditions($table1,$condition);
            $condition = array('status' => 1);
            $table2 = "coordinator";
            $resp =  $this->mainlogin->get_detaild_by_conditions($table2,$condition);
            $data['emp_resp'] = $emp_resp;
            $data['resp'] = $resp;
            $this->load->view('coordinator',$data);  
        }
        
        public function assignPanelToCoordinator() {
            $this->enter();   
            $data = array();
            $this->load->library('mainlogin');
            if($this->input->post('action_name') == "add"){
            $emp_id = $this->input->post('emp_id');
            $table = 'employee';
            $condition = array('emp_id' => $emp_id);
            $data = array('role' => 5, 'panel_login_status' => 1);
            $response =  $this->mainlogin->update_data($table,$condition,$data);
            }
            if($this->input->post('action_name') == "del"){
                $emp_id = $this->input->post('emp_id');
                $table = 'employee';
                $condition = array('emp_id' => $emp_id);
                $data = array('panel_login_status' => 0);
                $response =  $this->mainlogin->update_data($table,$condition,$data);
            }
            $resp =  $this->mainlogin->coordinator_list_with_no_access_panel();
            $access_resp =  $this->mainlogin->coordinator_list_with_access_panel();
            $data['resp'] = $resp;
            $data['access_resp'] = $access_resp;
            $this->load->view('assign_panel_to_coordinator',$data);  
        }
        
        public function client() {
         $this->load->library('mainlogin');
         $this->enter(); 
         $method = $_SERVER['REQUEST_METHOD'];
         $params = $_REQUEST;
         $data = array();
         $mdata = array();
         $output_data = array();
         if($this->input->post('action_name') == "add"){
            
            if($this->input->post('client_name') != NULL & $this->input->post('client_name') != ''){
               $client_name = $this->input->post('client_name');
               if(isset($params['client_address'])){
                   $data['client_address'] = $params['client_address'];
               }
               if(isset($params['client_city'])){
                   $data['client_city'] = $params['client_city'];
               }
               if(isset($params['client_state'])){
                   $data['client_state'] = $params['client_state'];
               }
               if(isset($params['client_gst_no'])){
                   $data['client_gst_no'] = $params['client_gst_no'];
               }
               if(isset($params['client_contact_person'])){
                   $data['client_contact_person'] = $params['client_contact_person'];
               }
               if(isset($params['client_contact_no'])){
                   $data['client_contact_no'] = $params['client_contact_no'];
               }
               $data['created_by'] = $this->session->userdata['admin_in']['admin_id'];
               $table = 'clients';
               $check_data = array('client_name' => $client_name);

               if($this->mainlogin->check_user_exist($table,$check_data) == TRUE){
                   $mdata['error'] = "Client already registered!";
               }else{
                   $data['client_name'] = $client_name;
                   $response =  $this->mainlogin->insert($table,$data);
               }
            } 
         }
         if($this->input->post('action_name') == "view"){
            if($this->input->post('client_id') != NULL & $this->input->post('client_id') != ''){
                $client_id = $this->input->post('client_id');
                $condition = array('client_id' => $client_id);
                $table = "clients";
                $client_details =  $this->mainlogin->get_detaild_by_conditions($table,$condition);
                $output_data['client_details'] = $client_details;
            } 
         }
         if($this->input->post('action_name') == "edit"){
            
            if($this->input->post('client_id') != NULL & $this->input->post('client_id') != ''){
               $client_id = $this->input->post('client_id');
               if(isset($params['client_name'])){
                   $data['client_name'] = $params['client_name'];
               }
               if(isset($params['client_address'])){
                   $data['client_address'] = $params['client_address'];
               }
               if(isset($params['client_city'])){
                   $data['client_city'] = $params['client_city'];
               }
               if(isset($params['client_state'])){
                   $data['client_state'] = $params['client_state'];
               }
               if(isset($params['client_gst_no'])){
                   $data['client_gst_no'] = $params['client_gst_no'];
               }
               if(isset($params['client_contact_person'])){
                   $data['client_contact_person'] = $params['client_contact_person'];
               }
               if(isset($params['client_contact_no'])){
                   $data['client_contact_no'] = $params['client_contact_no'];
               }
               $data['created_by'] = $this->session->userdata['admin_in']['admin_id'];
               $table = 'clients';
               $condition = array('client_id' => $client_id);
               $emp_response =  $this->mainlogin->update_data($table,$condition,$data);
            } 
         }
         
         $condition = array('status' => 1);
         $table = "clients";
         $resp =  $this->mainlogin->get_detaild_by_conditions($table,$condition);
         $output_data['resp'] = $resp;
         $this->load->view('client',$output_data);
        }
        
        public function project() {
         $this->load->library('mainlogin');
         $this->enter(); 
         $method = $_SERVER['REQUEST_METHOD'];
         $params = $_REQUEST;
         $data = array();
         $mdata = array();
         $output_data = array();
         if($this->input->post('action_name') == "add"){
            
            if($this->input->post('project_name') != NULL & $this->input->post('project_name') != ''){
               $project_name = $this->input->post('project_name');
               if(isset($params['client_id'])){
                   $data['client_id'] = $params['client_id'];
               }
               if(isset($params['project_work_order_no'])){
                   $data['project_work_order_no'] = $params['project_work_order_no'];
               }
               if(isset($params['project_work_order_date'])){
                   $data['project_work_order_date'] = $params['project_work_order_date'];
               }
               if(isset($params['project_approx_cost'])){
                   $data['project_approx_cost'] = $params['project_approx_cost'];
               }
               if(isset($params['project_approx_working_days'])){
                   $data['project_approx_working_days'] = $params['project_approx_working_days'];
               }
               $data['created_by'] = $this->session->userdata['admin_in']['admin_id'];
               $table = 'project';
               $check_data = array('project_name' => $project_name);

               if($this->mainlogin->check_user_exist($table,$check_data) == TRUE){
                   $mdata['error'] = "Project already registered!";
               }else{
                   $data['project_name'] = $project_name;
                   $response =  $this->mainlogin->insert($table,$data);
               }
            } 
         }
         if($this->input->post('action_name') == "view"){
            if($this->input->post('project_id') != NULL & $this->input->post('project_id') != ''){
                $project_id = $this->input->post('project_id');
                $condition = array('project_id' => $project_id);
                $table = "project";
                $client_details =  $this->mainlogin->get_detaild_by_conditions($table,$condition);
                $output_data['project_details'] = $client_details;
            } 
         }
         if($this->input->post('action_name') == "edit"){
            
            if($this->input->post('project_id') != NULL & $this->input->post('project_id') != ''){
               $project_id = $this->input->post('project_id');
               if(isset($params['project_name'])){
                   $data['project_name'] = $params['project_name'];
               }
               if(isset($params['client_id'])){
                   $data['client_id'] = $params['client_id'];
               }
               if(isset($params['project_work_order_no'])){
                   $data['project_work_order_no'] = $params['project_work_order_no'];
               }
               if(isset($params['project_work_order_date'])){
                   $data['project_work_order_date'] = $params['project_work_order_date'];
               }
               if(isset($params['project_approx_cost'])){
                   $data['project_approx_cost'] = $params['project_approx_cost'];
               }
               if(isset($params['project_approx_working_days'])){
                   $data['project_approx_working_days'] = $params['project_approx_working_days'];
               }
               $data['created_by'] = $this->session->userdata['admin_in']['admin_id'];
               $table = 'project';
               $data['created_by'] = $this->session->userdata['admin_in']['admin_id'];
               $table = 'project';
               $condition = array('project_id' => $project_id);
               $emp_response =  $this->mainlogin->update_data($table,$condition,$data);
            } 
         }
         
         $condition = array('status' => 1);
         $table1 = "clients";
         $client_list =  $this->mainlogin->get_detaild_by_conditions($table1,$condition);
         $output_data['client_list'] = $client_list;
         $table2 = "project";
         $resp =  $this->mainlogin->project_list();
         $output_data['resp'] = $resp;
         $this->load->view('project',$output_data);
        }
        
        public function teamLead() {
           $this->enter();   
            $data = array();
            if($this->input->post('action_name') == "add"){
                $coordinator_id = $this->input->post('coordinator_id');
                $emp_id = $this->input->post('emp_id');
                $created_by = $this->session->userdata['admin_in']['admin_id'];
                $data1 = array('coordinator_id' => $coordinator_id, 'created_by' => $created_by);
                $data2 = array('coordinator_id' => $coordinator_id, 'emp_id' => $emp_id, 'created_by' => $created_by);
                $condition = array('emp_id' => $emp_id);
                $this->load->library('mainlogin');
                $table1 = "employee";
                $table2 = 'team_lead';
                $response =  $this->mainlogin->update_data($table1,$condition,$data1);
                if($response['status'] == 200){
                   $response =  $this->mainlogin->insert($table2,$data2); 
                }
            }
            if($this->input->post('action_name') == "del"){
                $technology_name = $this->input->post('technology_name');
                $coordinator_id = $this->input->post('coordinator_id');
                $table = 'coordinator';
                $check_data = array('coordinator_id' => $coordinator_id);
                $response =  $this->mainlogin->delete_records($table,$check_data);
            }
            $condition = array('status' => 1);
            $table = "coordinator";
            $resp =  $this->mainlogin->get_detaild_by_conditions($table,$condition);
            $condition2 = array('status' => 1);
            $table2 = "employee";
            $emp_list =  $this->mainlogin->get_detaild_by_conditions($table2,$condition2);
            $data['emp_list'] = $emp_list;
            $data['resp'] = $resp;
            $assigned_emp_list =  $this->mainlogin->assigned_teamleader_employee_list();
            $data['assigned_emp_list'] = $assigned_emp_list;
            $this->load->view('team_lead',$data);   
        }
        
        public function all_expense_sheet() {
           $this->enter();   
           $resp =  $this->mainlogin->get_all_expense_sheet();
           $data = array('resp' => $resp);
           $this->load->view('get_all_expense_sheet',$data);   
        }
        
        public function createSalary() {
            $this->enter();  
            $condition = array('status' => 1);
            $table = "employee";
            $emp_list =  $this->mainlogin->get_detaild_by_conditions($table,$condition);
            $data['emp_list'] = $emp_list;
            $this->load->view('create-salary',$data);   
        }
        
        public function salaryStep1() {
            $this->enter();   
            $method = $_SERVER['REQUEST_METHOD'];
            $params = $_REQUEST;
            if(isset($params['emp_id']) & isset($params['month'])){
                $this->load->library('mainlogin');
                $emp_id = $params['emp_id'];
                $month_name = $params['month'];
                date_default_timezone_set('Asia/Kolkata');
                $date = DateTime::createFromFormat("Y-m-d", $month_name);
                $month = $date->format("m");
                $year = $date->format("Y");
                $check_data = array('emp_id' => $emp_id, 'MONTH(month_name)' => $month, 'YEAR(month_name)' => $year);
                $table = "monthly_salary";
                $response =  $this->mainlogin->check_user_exist($table,$check_data);
                if($response == FALSE){
                    $salary_details =  $this->mainlogin->get_employee_salary_details($emp_id);
                    $table3 = "project";
                    $condition3 = array(
                        'status' => 1
                    );
                    $project_resp =  $this->mainlogin->get_detaild_by_conditions($table3,$condition3);
                    if($salary_details != NULL){
                        $data = array('salary_details' => $salary_details, 'month_name' => $month_name, 'project_resp' => $project_resp);
                        $this->load->view('employee-salary-details',$data);
                    }
                } else {
                    $message = "Employee Salary Details Not Found !";
                    $resp = array(
                    'message' => $message
                    );
                    $this->load->view('defalt-message-page',$resp);
                }
            }else{
                $message = "Invaild Page Or Invailid Function";
//                $this->message($message);
                $resp = array(
                    'message' => $message
                );
                $this->load->view('defalt-message-page',$resp);
            }
        }
        
        public function generateMonthlySalary() {
            $this->enter();   
            $method = $_SERVER['REQUEST_METHOD'];
            $params = $_REQUEST;
            if(isset($params['emp_id']) & isset($params['woc']) & isset($params['monthly_salary_amount']) & isset($params['month_name']) & isset($params['net_salary']) & isset($params['total_salary']) & isset($params['total_present']) & isset($params['total_absent']) & isset($params['hr_status']) & isset($params['gross_salary']) & isset($params['other_salary']) & isset($params['advance_salary'])){
                $this->load->library('mainlogin');
                date_default_timezone_set('Asia/Kolkata');
                $data = array();
                $emp_id = $params['emp_id'];
                $month_name = $params['month_name'];
                $data['month_name'] = $month_name;
                $data['woc'] = $params['woc'];
                $data['emp_id'] = $emp_id;
                $data['net_salary'] = $params['net_salary'];
                $data['gross_salary'] = $params['gross_salary'];
                $data['total_present'] = $params['total_present'];
                $data['total_absent'] = $params['total_absent'];
                $data['other_salary'] = $params['other_salary'];
                $data['advance_salary'] = $params['advance_salary'];
                $data['monthly_salary_amount'] = $params['monthly_salary_amount'];
                $data['total_salary'] = $params['total_salary'];
                $data['hr_status'] = $params['hr_status'];
                if(isset($params['hr_comments'])){
                  $data['hr_comments'] = $params['hr_comments'];  
                }
                $last_update = date('Y-m-d H:i:s');
                $check_data = array('emp_id' => $emp_id, 'month_name' => $month_name);
                $table = "monthly_salary";
                $response =  $this->mainlogin->check_user_exist($table,$check_data);
                if($response == FALSE){
                    $response =  $this->mainlogin->insert($table,$data);
                    if($response['insert_id'] != ''){
                       $message = "Employee Salary Successfully Generated !"; 
                    }else{
                        $message = "Something Wrong, Please Try Again!";
                    }
                    $resp = array(
                            'message' => $message
                            );
                    $this->load->view('defalt-message-page',$resp);
                } else {
                    $message = "Employee Salary Already Generated !";
                    $resp = array(
                    'message' => $message
                    );
                    $this->load->view('defalt-message-page',$resp);
                }
            }else{
                $message = "Invaild Page Or Invailid Function / Mendatory Fields Required";
//                $this->message($message);
                $resp = array(
                    'message' => $message
                );
                $this->load->view('defalt-message-page',$resp);
            }
        }
        
        public function salaryStep2() {
            $this->enter();  
            $condition = array('status' => 1);
            $table = "employee";
            $emp_list =  $this->mainlogin->get_detaild_by_conditions($table,$condition);
            $data['emp_list'] = $emp_list;
            $this->load->view('create-salary-by-accountant',$data); 
        }
        
        // get employee generated salary details by hr
        public function getSalaryDetails() {
            $this->enter();   
            $method = $_SERVER['REQUEST_METHOD'];
            $params = $_REQUEST;
            if(isset($params['emp_id']) & isset($params['month'])){
                $this->load->library('mainlogin');
                date_default_timezone_set('Asia/Kolkata');
                $emp_id = $params['emp_id'];
                $month_name = $params['month'];
                $date = DateTime::createFromFormat("Y-m-d", $month_name);
                $month = $date->format("m");
                $year = $date->format("Y");
                $check_data = array('emp_id' => $emp_id, 'MONTH(month_name)' => $month, 'YEAR(month_name)' => $year, 'hr_status' => 'Approved', 'salary_status' => 'Unpaid');
                $table = "monthly_salary";
                $response =  $this->mainlogin->check_user_exist($table,$check_data);
                if($response == TRUE){
                    $salary_details =  $this->mainlogin->get_employee_generated_salary_details($emp_id);
                    if($salary_details != NULL){
                        $data = array('salary_details' => $salary_details);
                        $this->load->view('employee-generated-salary-details',$data);
                    }
                } else {
                    $message = "Employee Salary Details Not Found !";
                    $resp = array(
                    'message' => $message
                    );
                    $this->load->view('defalt-message-page',$resp);
                }
            }else{
                $message = "Invaild Page Or Invailid Function";
//                $this->message($message);
                $resp = array(
                    'message' => $message
                );
                $this->load->view('defalt-message-page',$resp);
            }
        }
        
        public function paySalary() {
            $this->enter();   
            $method = $_SERVER['REQUEST_METHOD'];
            $params = $_REQUEST;
            if(isset($params['emp_id']) & isset($params['month_name']) & isset($params['hr_status']) & isset($params['monthly_salary_id']) & isset($params['salary_status'])){
                $this->load->library('mainlogin');
                date_default_timezone_set('Asia/Kolkata');
                $data = array();
                $emp_id = $params['emp_id'];
                $month_name = $params['month_name'];
                $monthly_salary_id = $params['monthly_salary_id'];
                $date = DateTime::createFromFormat("Y-m-d", $month_name);
                $month = $date->format("m");
                $year = $date->format("Y");
                $check_data = array('monthly_salary_id' => $monthly_salary_id, 'MONTH(month_name)' => $month, 'YEAR(month_name)' => $year, 'hr_status' => 'Approved', 'salary_status' => 'Unpaid');
                $table = "monthly_salary";
                $response =  $this->mainlogin->check_user_exist($table,$check_data);
                if($response == TRUE){
                    $last_update = date('Y-m-d H:i:s');
                    $data['salary_status'] = $params['salary_status'];
                    if($params['salary_status'] == 'Paid'){
                       $data['accountant_status'] = "Approved";
                    }
                    $data['salary_paid_date'] = $last_update;
                    $condition = array('monthly_salary_id' => $monthly_salary_id, 'MONTH(month_name)' => $month, 'YEAR(month_name)' => $year);
                    $response =  $this->mainlogin->update_data($table,$condition,$data);
                    if($response['status'] == 200){
                       $message = "Employee Salary Successfully Paid !"; 
                    }else{
                        $message = "Something Wrong, Please Try Again!";
                    }
                    $resp = array(
                            'message' => $message
                            );
                    $this->load->view('defalt-message-page',$resp);
                } else {
                    $message = "Employee Salary Already Paid !";
                    $resp = array(
                    'message' => $message
                    );
                    $this->load->view('defalt-message-page',$resp);
                }
            }else{
                $message = "Invaild Page Or Invailid Function / Mendatory Fields Required";
//                $this->message($message);
                $resp = array(
                    'message' => $message
                );
                $this->load->view('defalt-message-page',$resp);
            }
        }
        
        public function paidSalaryList() {
            $this->enter(); 
            $method = $_SERVER['REQUEST_METHOD'];
            $params = $_REQUEST;
            date_default_timezone_set('Asia/Kolkata');
            if(isset($params['month']) & isset($params['emp_id'])){
                $condition2 = array('status' => 1);
                $table2 = "employee";
                $emp_list =  $this->mainlogin->get_detaild_by_conditions($table2,$condition2);
                $month = $params['month'];
                $emp_id = $params['emp_id'];
                $date = DateTime::createFromFormat("Y-m-d", $month);
                $month = $date->format("m");
                $year = $date->format("Y"); 
                if($emp_id != 'NULL'){
                    echo "one =".$emp_id;
                    $resp2 = $this->mainlogin->get_employee_salary_list_by_month_and_emp_id($month, $year, $emp_id);
                    $data = array('resp2' => $resp2, 'month' => $month, 'year' => $year,'emp_list' => $emp_list);
                }else{
                    $resp2 = $this->mainlogin->get_employee_salary_list_by_month($month, $year);
                    $data = array('resp' => $resp2, 'month' => $month, 'year' => $year,'emp_list' => $emp_list);
                }
                $this->load->view('paid-salary-list',$data);   
            }
            elseif (isset($params['month'])) {
                echo "two";
                $condition2 = array('status' => 1);
                $table2 = "employee";
                $emp_list =  $this->mainlogin->get_detaild_by_conditions($table2,$condition2);
                $month = $params['month'];
                $date = DateTime::createFromFormat("Y-m-d", $month);
                $month = $date->format("m");
                $year = $date->format("Y"); 
                $response = $this->mainlogin->get_employee_salary_list_by_month($month, $year);
                $data = array('resp' => $response, 'month' => $month, 'year' => $year,'emp_list' => $emp_list);
                $this->load->view('paid-salary-list',$data);   
            }else{
                $condition2 = array('status' => 1);
                $table2 = "employee";
                $emp_list =  $this->mainlogin->get_detaild_by_conditions($table2,$condition2);
                $data = array('emp_list' => $emp_list);
                $this->load->view('paid-salary-list',$data);   
            }
        }
        
        public function employeeLocationActivity1() {
            $this->enter();  
            $condition = array('status' => 1);
            $table = "employee";
            $resp =  $this->mainlogin->employee_location_activity();
            $data['resp'] = $resp;
            $this->load->view('employee_location_activity',$data);   
        }
        
        public function employeeLocationActivity() {
            $this->enter();
            $this->load->model('LoginModel');
            $from_date=date('Y-m-d')." 00:00:00";
            $to_date=date('Y-m-d')." 23:59:59";
            $today_active_user_id=$this->LoginModel->employee_location_activity_by_date($from_date,$to_date);
            $today_active_user=[];
            if(!empty($today_active_user_id)){
                foreach($today_active_user_id as $val){
                    $last_location=$this->LoginModel->last_employee_location_activity_by_emp_id($val->emp_id);
                    if(!empty($last_location)){
                        $today_active_user[]=$last_location[0];
                    }
                }
            }else{
                
            }
            //var_dump($today_active_user);
            $this->load->view('current_emp_location',array('today_active_user'=>$today_active_user));
        }
        
        public function employeeLocationActivity_user() {
            $this->enter();
            $this->load->model('LoginModel');
            $from_date=date('Y-m-d')." 00:00:00";
            $to_date=date('Y-m-d')." 23:59:59";
            $today_active_user_id=$this->LoginModel->all_employee_location_activity();
            $today_active_user=[];
            if(!empty($today_active_user_id)){
                foreach($today_active_user_id as $val){
                    $last_location=$this->LoginModel->last_employee_location_activity_by_emp_id($val->emp_id);
                    if(!empty($last_location)){
                        $today_active_user[]=$last_location[0];
                    }
                }
            }else{
                
            }
            //var_dump($today_active_user);
            $this->load->view('employeeLocationActivity_user',array('today_active_user'=>$today_active_user));
        }
        
        public function user_lication($id){
            $this->enter();
            $params=$this->input->post();
            $this->load->model('LoginModel');
            if(isset($params['date']) && !empty($params['date'])){
                $from_date=date('Y-m-d',strtotime($params['date']))." 00:00:00";
                $to_date=date('Y-m-d',strtotime($params['date']))." 23:59:59";
            }else{
                $from_date=date('Y-m-d')." 00:00:00";
                $to_date=date('Y-m-d')." 23:59:59";
            }
            $last_location=$this->LoginModel->all_employee_location_activity_by_emp_id($id,$from_date,$to_date);
            $this->load->view('user_lication',array('today_active_user'=>$last_location));
        }
        
        public function material_issue(){
			$this->enter();
			$this->load->model('LoginModel');
			$emp_id=$this->session->userdata['admin_in']['admin_id'];
			$method = $_SERVER['REQUEST_METHOD'];
			if($method == 'POST'){
				$this->form_validation->set_rules('emp_id', 'employee', 'trim|strip_tags|required');
				$this->form_validation->set_rules('item_name', 'item name', 'trim|strip_tags|required');
				$this->form_validation->set_rules('quantity', 'quantity', 'trim|strip_tags|required');
				$this->form_validation->set_rules('issue_date', 'issue date', 'trim|strip_tags|required');
				$params=$_REQUEST;
				if($this->form_validation->run() == TRUE){
					$in_data=array(
						'emp_id'=>$params['emp_id'],
						'coordinator_id'=>$emp_id,
						'item_name'=>$params['item_name'],
						'quantity'=>$params['quantity'],
						'issue_date'=>date('Y-m-d',strtotime($params['issue_date']))
					);
					if($this->mainlogin->check_user_exist('team_lead',array('coordinator_id'=>$emp_id,'emp_id'=>$params['emp_id']))==TRUE){
						$res=$this->mainlogin->insert('material_issue_or_stock',$in_data);
						if($res['status']==200){
							$this->session->set_userdata('message', "material successfully issue.");
						}else{
							$this->session->set_userdata('error', "Something went wrong! Please try again.");
						}
					}else{
						$this->session->set_userdata('error', "Something went wrong! Please try again.");
					}
				}
			}
			$data['team_list']=$this->LoginModel->team_member_list($emp_id);
			$data['material_issue_list']=$this->LoginModel->material_issue_list($emp_id);
			//var_dump($data['material_issue_list']);
			$this->load->view('material_issue',$data);
		}
        
        public function inactive_emp_list(){
            $resp =  $this->mainlogin->get_detaild_by_conditions("employee",array('login_status' => 0));
            if(empty($resp)){
                $resp=array();
            }
            $data['inactive_emp']=$resp;
            //var_dump($resp);
            $this->load->view('inactive_emp_list',$data);
        }
        
        public function active_emp_list(){
            $resp =  $this->mainlogin->get_detaild_by_conditions("employee",array('login_status' => 1));
            if(empty($resp)){
                $resp=array();
            }
            $data['active_emp']=$resp;
            //var_dump($resp);
            $this->load->view('active_emp_list',$data);
        }
        
        public function password(){
            echo $this->encryption->decrypt("d77cfa4c5b5e198556cc4f3eb5ba4296e2977026db849f1460a0b9111efe7da38a63474d67155674f9a0fecc6a5e39c6b3b31c2f9aec752553c9cf5e4f7f3e9cu7ajTtTuwtYIVFQjXmwe8cf8kTs0qQwcYbz58wDeQzU=");
        }
        
}
