<?php
class Mainlogin{

   protected $CI;
    public function __construct()
        {
                // Assign the CodeIgniter super-object
                $this->CI =& get_instance();
        }

    
    function login($username,$password){
        $CI =& get_instance();
        $CI->load->model('LoginModel');
        return $response = $CI->LoginModel->login($username,$password);
    }
    
    function admin_login($username,$password){
        $CI =& get_instance();
        $CI->load->model('LoginModel');
        return $response = $CI->LoginModel->admin_login($username,$password);
    }
            
    function logout($admin_id,$authorization){
        $CI =& get_instance();
        $CI->load->model('LoginModel');
        return $response = $CI->MyModel->logout1($admin_id,$authorization);
    }
    
    function insert($table,$data){
        $CI =& get_instance();
        $CI->load->model('LoginModel');
        return $response = $CI->LoginModel->create_data_api($table,$data);
    }
    
    function check_user_exist($table,$check_data){
        $CI =& get_instance();
        $CI->load->model('LoginModel');
        return $response = $CI->LoginModel->check_user_exist($table,$check_data); 
    }
    
    function get_detaild_by_conditions($table,$condition){
        $CI =& get_instance();
        $CI->load->model('LoginModel');
        return $response = $CI->LoginModel->get_detaild_by_conditions($table,$condition); 
    }
    
    function get_all_list_by_condition_with_orderby($table,$data,$orderby){
        $CI =& get_instance();
        $CI->load->model('LoginModel');
        return $response = $CI->LoginModel->get_detaild_by_conditions($table,$data,$orderby); 
    }
    
    function update_data($table,$condition,$data){
        $CI =& get_instance();
        $CI->load->model('LoginModel');
        return $response = $CI->LoginModel->update_data($table,$condition,$data);
    }
            
    function employee_details($id){
        $CI =& get_instance();
        $CI->load->model('LoginModel');
        return $response = $CI->LoginModel->employee_details_data($id);
    }
    
    function update_profile($admin_id,$data){
        $CI =& get_instance();
        $CI->load->model('LoginModel');
        $response = $CI->LoginModel->update_admin_details($admin_id,$data);
        return $response;
    }
    
    function pandit_table(){
        $CI =& get_instance();
        $CI->load->model('LoginModel');
        $response = $CI->LoginModel->pandit_availability();
        return $response;
    }
    
    function file_upload($image,$imgtype,$directory_path,$image_name){
      $CI =& get_instance();
      $CI->load->helper('url');
      $CI->load->helper('form');
      $CI->load->helper('text');
      $image = base64_decode($image);
      $filename = $image_name.'.'.$imgtype;
//      $path = "./pandit_image/".$filename;
      $path = "./".$directory_path.$filename;
      if(file_put_contents($path, $image)){
          $full_path = base_url().$directory_path.$filename;
          $result = array(
              'status' => 200,
              'image_name' => $filename,
          );
      }else{
          $result = array(
              'status' => 400,
          );
      }
      
      return $result;
    }
    
    function admin_image_exist($admin_id){
        $CI =& get_instance();
        $CI->load->model('LoginModel');
        return $response = $CI->LoginModel->admin_image_details($admin_id);
    }
    
    function employee_list(){
        $CI =& get_instance();
        $CI->load->model('LoginModel');
        return $response = $CI->LoginModel->all_employee(); 
    }
    
    function employee_list_with_designation(){
        $CI =& get_instance();
        $CI->load->model('LoginModel');
        return $response = $CI->LoginModel->employee_list_with_designation(); 
    }
    
    function servey_list(){
        $CI =& get_instance();
        $CI->load->model('LoginModel');
        return $response = $CI->LoginModel->all_servey_list(); 
    }
    
    function survey_pic_name($survey_id){
        $CI =& get_instance();
        $CI->load->model('LoginModel');
        return $response = $CI->LoginModel->survey_pic_name($survey_id);
    }
    
    function site_survey_pic_name($site_survey_id){
        $CI =& get_instance();
        $CI->load->model('LoginModel');
        return $response = $CI->LoginModel->site_survey_pic_name($site_survey_id);
    }
    
    function enter(){
        $CI =& get_instance();
            if($CI->session->userdata['admin_in'] != ''){
               $username = ($CI->session->userdata['admin_in']['first_name']);
                $email = ($CI->session->userdata['admin_in']['email']);
            }else{
            redirect(base_url().'index.php/admin/user');
            }
    }
    
    // get all active site survey list
    function all_sit_survey_list(){
        $CI =& get_instance();
        $CI->load->model('LoginModel');
        return $response = $CI->LoginModel->all_sit_survey_list();  
    }
    
    // get all active site survey listaccording to coordinator
    function all_sit_survey_list_by_coordinator($coordinator_id){
        $CI =& get_instance();
        $CI->load->model('LoginModel');
        return $response = $CI->LoginModel->all_sit_survey_list_by_coordinator($coordinator_id);  
    }
    
    // get site survey expense list where expense is not approved by coordinator
    function sit_survey_list(){
        $CI =& get_instance();
        $CI->load->model('LoginModel');
        return $response = $CI->LoginModel->sit_survey_list_with_coordinator_and_project();  
    }
    
    // get site survey expense list according coordinator where status bending by coordinator
    function sit_survey_list_by_coordinator($coordinator_id){
        $CI =& get_instance();
        $CI->load->model('LoginModel');
        return $response = $CI->LoginModel->sit_survey_list_with_coordinator_and_project_by_coordinator($coordinator_id);  
    }
    
    // get site survey expense details where status bending by coordinator
    function sit_survey_detais_with_coordinator_and_project($site_survey_id){
        $CI =& get_instance();
        $CI->load->model('LoginModel');
        return $response = $CI->LoginModel->sit_survey_detais_with_coordinator_and_project($site_survey_id);  
    }
    
    // get site survey list where expense is approved by coordinator
    function sit_survey_expense_list_approved_by_coordinator(){
        $CI =& get_instance();
        $CI->load->model('LoginModel');
        return $response = $CI->LoginModel->sit_survey_list_approved_by_coordinator();  
    }
    
    // get site survey expense details where expense approved by project manager
    function sit_survey_detais_approved_project_manager($site_survey_id){
        $CI =& get_instance();
        $CI->load->model('LoginModel');
        return $response = $CI->LoginModel->sit_survey_detais_approved_by_project_manager($site_survey_id);  
    }
    
    // get site survey list where expense is approved by project manager
    function sit_survey_expense_list_approved_by_project_manager(){
        $CI =& get_instance();
        $CI->load->model('LoginModel');
        return $response = $CI->LoginModel->sit_survey_list_approved_by_project_manager();  
    }
    
    // get site survey list where expense approved by project manager and partial paid by accountant
    function sit_survey_list_partial_paid_by_accountant(){
        $CI =& get_instance();
        $CI->load->model('LoginModel');
        return $response = $CI->LoginModel->sit_survey_list_partial_paid_accountant();  
    }
    
    // get site survey expense details where expense approved by project manager
    function sit_survey_detais_partial_paid($site_survey_id){
        $CI =& get_instance();
        $CI->load->model('LoginModel');
        return $response = $CI->LoginModel->sit_survey_detais_partial_paid($site_survey_id);  
    }
    
    function sit_survey_expense_list_approved_by_coordinator_with_coordinator_id($coordinator_id){
        $CI =& get_instance();
        $CI->load->model('LoginModel');
        return $response = $CI->LoginModel->sit_survey_list_with_coordinator_and_project_by_coordinator_and_approved_by_coordinator($coordinator_id);  
    }
    
    function sit_survey_details_by_condition($table,$condition){
        $CI =& get_instance();
        $CI->load->model('LoginModel');
        return $response = $CI->LoginModel->get_detaild_by_conditions($table,$condition);  
    }
    
    function sit_expense_details_by_condition($table2,$condition) {
        $CI =& get_instance();
        $CI->load->model('LoginModel');
        return $response = $CI->LoginModel->get_detaild_by_conditions($table2,$condition); 
    }
    
    // get client details using work order number (woc)
    function get_client_details_by_woc($woc){
        $CI =& get_instance();
        $CI->load->model('LoginModel');
        return $response = $CI->LoginModel->get_client_details_by_woc($woc); 
    }
    
    function assigned_teamleader_employee_list(){
        $CI = & get_instance();
        $CI->load->model('LoginModel');
        return $response = $CI->LoginModel->assigned_teamleader_employee_list();
    }
            
    function project_list(){
        $CI =& get_instance();
        $CI->load->model('LoginModel');
        return $response = $CI->LoginModel->project_list_with_client();
    }
    
    function get_all_expense_sheet(){
        $CI =& get_instance();
        $CI->load->model('LoginModel');
        return $response = $CI->LoginModel->get_all_expense_sheet();
    }
    
    // get employee salary details witn name and userid
    function get_employee_salary_details($emp_id){
        $CI =& get_instance();
        $CI->load->model('LoginModel');
        return $response = $CI->LoginModel->get_employee_salary_details($emp_id);  
    }
    
    // get employee generated salary details by hr and used this details by accountant
    function get_employee_generated_salary_details($emp_id){
        $CI =& get_instance();
        $CI->load->model('LoginModel');
        return $response = $CI->LoginModel->get_employee_generated_salary_details($emp_id);  
    }
    
    function get_employee_salary_list_by_month($month, $year){
        $CI =& get_instance();
        $CI->load->model('LoginModel');
        return $response = $CI->LoginModel->get_employee_salary_list_by_month($month, $year);  
    }
    
    function get_employee_salary_list_by_month_and_emp_id($month, $year, $emp_id){
        $CI =& get_instance();
        $CI->load->model('LoginModel');
        return $response = $CI->LoginModel->get_employee_salary_list_by_month_and_emp_id($month, $year, $emp_id); 
    }
    
    // get coordinator details where not have dashboard access permission
    function coordinator_list_with_no_access_panel() {
        $CI =& get_instance();
        $CI->load->model('LoginModel');
        return $response = $CI->LoginModel->coordinator_list_with_no_access_panel(); 
    }
    
    // get coordinator details where not have dashboard access permission
    function coordinator_list_with_access_panel() {
        $CI =& get_instance();
        $CI->load->model('LoginModel');
        return $response = $CI->LoginModel->coordinator_list_with_access_panel(); 
    }
    
    function employee_location_activity(){
        $CI =& get_instance();
        $CI->load->model('LoginModel');
        return $response = $CI->LoginModel->employee_location_activity(); 
    }
        
    function panditTimeAvailabilityList($table,$data){
        $CI =& get_instance();
        $CI->load->model('LoginModel');
        return $response = $CI->LoginModel->get_detaild_by_conditions($table,$data); 
    }
    
    function shopkeeper_list(){
        $CI =& get_instance();
        $CI->load->model('LoginModel');
        return $response = $CI->LoginModel->all_shopkeeper(); 
    }
            
    function send_otp_verification($data){
        $CI =& get_instance();
        $CI->load->model('LoginModel');
        $table = $data['table'];
        $mobileNumber = $data['mobile'];
        $admin_id = $data['id'];
        $rndno=rand(1000, 9999);
        $data = array(
            'verification_code' => $rndno,
        );
        $response = $CI->LoginModel->update_admin_details($admin_id,$data);
        
        $username = "escalatestechindia";
        $password = "kap@user!123";
        $senderId = "RMNDME";
        
        $message = urlencode("Poojapath mobile otp is : ".$rndno);
        $url="http://www.smsjust.com/sms/user/urlsms.php?username=$username&pass=$password&senderid=$senderId&dest_mobileno=$mobileNumber&message=$message&response=Y";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        $result = preg_replace('/\s/', '', $result);
        if(curl_errno($ch))
        {

            echo 'error:' . curl_error($ch);
        }
        curl_close($ch);
        $resp = array(
           'Databse Result' => $response, 
            'Message Referance' => $result,
        );
        return $resp;
    }
    
    function send_otp_testing($mobile){
        $CI =& get_instance();
        $CI->load->model('LoginModel');
//        $table = $data['table'];
        $mobileNumber = $mobile;
//        $admin_id = $data['id'];
        $rndno=rand(1000, 9999);
//        $data = array(
//            'verification_code' => $rndno,
//        );
//        $response = $CI->LoginModel->update_admin_details($admin_id,$data);
        
        $username = "escalatestechindia";
        $password = "kap@user!123";
        $senderId = "RMNDME";
        
        $message = urlencode("Poojapath mobile otp is : ".$rndno);
        $url="http://www.smsjust.com/sms/user/urlsms.php?username=$username&pass=$password&senderid=$senderId&dest_mobileno=$mobileNumber&message=$message&response=Y";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        $result = preg_replace('/\s/', '', $result);
        if(curl_errno($ch))
        {

            echo 'error:' . curl_error($ch);
        }
        curl_close($ch);
        $resp = array(
           'Message Referance' => $result,
        );
        return $resp;
    }
    
    function send_otp_status($response){
        $CI =& get_instance();
        echo $url="http://www.smsjust.com/sms/user/response.php?%20Scheduleid=$response";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        if(curl_errno($ch))
        {

            echo 'error:' . curl_error($ch);
        }
//        echo "<br/>status = ".$output1;
        curl_close($ch);
        return $result;
    }
    
    function verify_otp($data){
        $CI =& get_instance();
        $admin_id = $data['id'];
        $otp = $data['otp'];
        $table = $data['table'];
        $CI->load->model('LoginModel');
        $response = $CI->LoginModel->admin_details_data($admin_id);
        if($response->verification_code == $otp){
           $data = array(
            'verified' => 1,
            );
            $result = $CI->LoginModel->update_admin_details($admin_id,$data); 
            $resp = array('status' => 200, 'response' => 'Mobile successfully verified!');
        }else{
            $resp = array('status' => 400, 'response' => 'invailid otp, mobile no not verified!');
        }
        return $resp;
    }
    
    function verifyAdmin_mobile($admin_id){
        $CI =& get_instance();
        $data = array(
            'verified' => 1,
            );
        $CI->load->model('LoginModel');
        $result = $CI->LoginModel->update_admin_details($admin_id,$data); 
        return $resp = array('status' => 200, 'response' => 'Mobile successfully verified!');
    }
    
    function delete_records($table,$delete_data){
        $CI =& get_instance();
        $data = array(
            'verified' => 1,
            );
        $CI->load->model('LoginModel');
        $result = $CI->LoginModel->delete_data($table,$delete_data); 
        return $resp = array('status' => 200, 'response' => 'Mobile successfully verified!');
    }
    
    function unique_priest_list_from_priest_pooja_service_pandit_relationship($admin_id){
      $CI =& get_instance();  
      $CI->load->model('LoginModel');
      $result = $CI->LoginModel->unique_priestList_from_priest_pooja_service_pandit_relationship($admin_id); 
      return $result;
    }
    
    function pooja_service_list_from_priest_pooja_service_pandit_relationship($admin_id,$priest_id){
      $CI =& get_instance();  
      $CI->load->model('LoginModel');
      $result = $CI->LoginModel->poojaServiceList_from_priest_pooja_service_pandit_relationship($admin_id,$priest_id); 
      return $result;
    }
    
    
    
}

?>