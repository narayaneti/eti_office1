<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LoginModel extends CI_Model {

    var $client_service = "eti-survey";
    var $auth_key       = "eti@5454";

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
        $q  = $this->db->select('*')->from('employee')->where('emp_username',$username)->get()->row();
        
        if($q == ""){
            return array('status' => 204,'message' => 'Employee not found.');
        } else {
            $hashed_password = $q->emp_password;
            $emp_id             = $q->emp_id;
            $login_status              = $q->login_status;
            $coordinator_id = $q->coordinator_id;
            if($login_status == 0){
                

                $hashed_password = $this->encryption->decrypt($hashed_password);

//                 echo $hashed_password ." ".$password;

                   if ($hashed_password == $password) {
                        date_default_timezone_set('Asia/Kolkata');
                        $last_login = date('Y-m-d H:i:s');
                        $token = crypt(substr( md5(rand()), 0, 7),'');
                        $this->db->trans_start();
                        $this->db->where('emp_id',$emp_id)->update('employee',array('login_status' => 1));
                        $this->db->insert('employee_authentication',array('emp_id' => $emp_id,'token' => $token,'created_at' => $last_login));
                        $this->db->insert('employee_token',array('emp_id' => $emp_id,'token' => $token,'created_at' => $last_login));
                            if ($this->db->trans_status() === FALSE){

                                 $this->db->trans_rollback();
                                return array('status' => 500,'message' => 'Internal server error.');
                            } else {
                                $coord_data = $this->db->select('coordinator_id,coordinator_name')->from('coordinator')->where('coordinator_id',$coordinator_id)->get()->row();
                                
                                $this->db->trans_commit();
                                
                                if($coord_data != ''){
                                   return array('status' => 200,'message' => 'Successfully login.','token' => $token, 'data' => $q, 'coordinator_data' => $coord_data); 
                                }else{
                                    return array('status' => 200,'message' => 'Successfully login.','token' => $token, 'data' => $q);
                                }
                            } 

                    } else {
                        return array('status' => 204,'message' => 'Wrong password.');

                }
            }else{
                return array('status' => 204,'message' => 'Already login, please contact to Hr department.');
            }
            
        }
    }
    
    public function admin_login($username,$password){
        date_default_timezone_set('Asia/Kolkata');
        $q  = $this->db->select('*')->from('admin')->where('username',$username)->get()->row();
        //  check details from admin table
        if($q != ""){
            $hashed_password = $q->password;
            
            
            $edata = array(
                'resp' => $q
            );
            
            $hashed_password = $this->encryption->decrypt($hashed_password);
            
            
//             echo $hashed_password ." ".$password;

               if ($hashed_password == $password) {
                      
                        if ($this->db->trans_status() === FALSE){

                             $this->db->trans_rollback();
                            return array('status' => 500,'message' => 'Internal server error.');
                        } else {

                            $this->db->trans_commit();

                            return array('status' => 200,'message' => 'Successfully login.', 'data' => $edata);
                        } 
                    
                } else {
                    return array('status' => 204,'message' => 'Wrong password.');
            }
        }
        else{
                $q  = $this->db->select('*')->from('employee')->where('emp_username',$username)->get()->row();
                if($q != ""){  //  check details from employee table table
                    $hashed_password = $q->emp_password;


                    $edata = array(
                        'resp' => $q
                    );

                    $hashed_password = $this->encryption->decrypt($hashed_password);

        //             echo $hashed_password ." ".$password;

                       if ($hashed_password == $password) {
                           if($q->panel_login_status == 1 & $q->status == 1){
                               if ($this->db->trans_status() === FALSE){

                                     $this->db->trans_rollback();
                                    return array('status' => 500,'message' => 'Internal server error.');
                                } else {

                                    $this->db->trans_commit();

                                    return array('status' => 200,'message' => 'Successfully login.', 'data' => $edata);
                                } 
                           }else{
                               return array('status' => 204,'message' => 'You have not authorized for login!');
                           }



                        } else {
                            return array('status' => 204,'message' => 'Wrong password.');

                    }

                }else {

                    return array('status' => 204,'message' => 'Admin not found.');
                }
        }
        
    }

    public function logout1($admin_id,$authorization)
    {
        $this->db->where('admin_id',$admin_id)->where('token',$authorization)->delete('admin_authentication');
        return array('status' => 200,'message' => 'Successfully logout.');
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
        return array('status' => 200,'message' => 'Data has been created.','insert_id' => $insert_id);
        
    }
    
    public function all_list($table,$data,$orderby)
    {
        return $this->db->select('*')->from($table)->where($data)->order_by($orderby,'desc')->get()->result();
    }
    
    public function update_data($table,$condition,$data)
    {
        $this->db->where($condition)->update($table,$data);
        return array('status' => 200,'message' => 'Data has been updated.');
    }
    
    public function delete_data($table,$delete_data)
    {
        $this->db->where($delete_data)->delete($table);
        return array('status' => 200,'message' => 'Data has been deleted.');
    }
    
    public function get_detaild_by_conditions($table,$condition)
    {
        return $this->db->select('*')->from($table)->where($condition)->get()->result();
    }
    
    public function two_table_join_with_one_common_field($table1,$table2,$field1,$field2){
        $this->db->select('t1.*');
        $this->db->select('t2.*');
        $this->db->join("'$table1 as pt','t1.$field1 = t2.$field2','left'");
        $query = $this->db->get("$table2 as t2");
        if ($query->num_rows() > 0) {
        return $query->result();
        } else {
        return NULL;
        }
    }
    
    public function all_employee()
    {
        return $this->db->select('*')->from('employee')->where('status',1)->get()->result();
    }
    
     public function employee_list_with_designation(){
        $this->db->select('em.*');
        $this->db->select('dd.designation,dd.designation_id');
        $this->db->join('employee as em','em.designation_id = dd.designation_id','left');
        $this->db->where('em.status',1);
        $query = $this->db->get('designation as dd');
        if ($query->num_rows() > 0) {
        return $query->result();
        } else {
        return NULL;
        }
    }
    
    public function employee_details_data($id)
    {
        return $this->db->select('*')->from('employee')->where('emp_id',$id)->order_by('emp_id','desc')->get()->row();
    }
    
    public function assigned_teamleader_employee_list(){
        $this->db->select('em.*');
        $this->db->select('cd.coordinator_id,cd.coordinator_name');
        $this->db->join('coordinator as cd','cd.coordinator_id = em.coordinator_id','left');
        $this->db->where('em.status',1);
        $this->db->where('em.coordinator_id != ','');
        $this->db->where('em.coordinator_id != ','NULL');
        $query = $this->db->get('employee as em');
        if ($query->num_rows() > 0) {
        return $query->result();
        } else {
        return NULL;
        }
    }
    
    public function project_list_with_client(){
        $this->db->select('pp.*');
        $this->db->select('cl.client_id, cl.client_name');
        $this->db->join('clients as cl','cl.client_id = pp.client_id','left');
        $query = $this->db->get('project as pp');
        if ($query->num_rows() > 0) {
        return $query->result();
        } else {
        return NULL;
        }
    }
    
    // het employee nama with basic salary details
    public function get_employee_salary_details($emp_id){
        $this->db->select('emp.*');
        $this->db->select('es.emp_salary_id, es.emp_salary_net, es.emp_salary_gross, es.emp_salary_pf, es.emp_salary_esic, es.emp_salary_tax, es.emp_salary_other, es.emp_salary_insurance, es.emp_salary_ta, es.emp_salary_da');
        $this->db->select('cor.coordinator_name');
        $this->db->select('des.designation');
        $this->db->select('dep.department');
        $this->db->select('bnk.emp_bank_name,bnk.emp_account_holder,bnk.emp_account_no,bnk.emp_bank_ifsc,');
        $this->db->join('employee_salary as es','emp.emp_id = es.emp_id','left');
        $this->db->join('coordinator as cor','emp.coordinator_id = cor.coordinator_id','left');
        $this->db->join('department as dep','emp.department_id = dep.department_id','left');
        $this->db->join('designation as des','emp.designation_id = des.designation_id','left');
        $this->db->join('employee_bank_details as bnk','emp.emp_id = bnk.emp_id','left');
        $this->db->where('emp.emp_id',$emp_id);
        $this->db->where('emp.status',1);
        $query = $this->db->get('employee as emp');
        if ($query->num_rows() > 0) {
        return $query->result();
        } else {
        return NULL;
        } 
    }
    
    // get employee generated salary details by accountant
    public function get_employee_generated_salary_details($emp_id){
        $this->db->select('mon.*');
        $this->db->select('emp.emp_name,emp.emp_username,emp.emp_mobile,emp.emp_email');
        $this->db->select('es.emp_salary_id, es.emp_salary_net, es.emp_salary_gross, es.emp_salary_pf, es.emp_salary_esic, es.emp_salary_tax, es.emp_salary_other, es.emp_salary_insurance, es.emp_salary_ta, es.emp_salary_da');
        $this->db->select('bnk.emp_bank_name,bnk.emp_account_holder,bnk.emp_account_no,bnk.emp_bank_ifsc,');
        $this->db->join('employee_salary as es','mon.emp_id = es.emp_id','left');
        $this->db->join('employee_bank_details as bnk','mon.emp_id = bnk.emp_id','left');
        $this->db->join('employee as emp','mon.emp_id = emp.emp_id','left');
        $this->db->where('mon.emp_id',$emp_id);
        $query = $this->db->get('monthly_salary as mon');
        if ($query->num_rows() > 0) {
        return $query->result();
        } else {
        return NULL;
        } 
    }
    
    // get employee paid/generate salary list by month and year
    public function get_employee_salary_list_by_month($month, $year){
        $this->db->select('mon.*');
        $this->db->select('emp.emp_name,emp.emp_username,emp.emp_mobile,emp.emp_email');
        $this->db->join('employee as emp','mon.emp_id = emp.emp_id','left');
        $this->db->where('MONTH(mon.month_name)',$month);
        $this->db->where('YEAR(mon.month_name)',$year);
        $query = $this->db->get('monthly_salary as mon');
        if ($query->num_rows() > 0) {
        return $query->result();
        } else {
        return NULL;
        } 
    }
    
    // get employee paid/generate salary list by month, year and emp_id
    public function get_employee_salary_list_by_month_and_emp_id($month, $year, $emp_id){
        $this->db->select('mon.*');
        $this->db->select('emp.emp_name,emp.emp_username,emp.emp_mobile,emp.emp_email');
        $this->db->join('employee as emp','mon.emp_id = emp.emp_id','left');
        $this->db->where('MONTH(mon.month_name)',$month);
        $this->db->where('YEAR(mon.month_name)',$year);
        $this->db->where('mon.emp_id',$emp_id);
        $query = $this->db->get('monthly_salary as mon');
        if ($query->num_rows() > 0) {
        return $query->result();
        } else {
        return NULL;
        }
    }
    
    // get employee paid/generate salary list by emp_id
    public function get_employee_salary_list_by_emp_id($emp_id){
        $this->db->select('mon.*');
        $this->db->select('emp.emp_name,emp.emp_username,emp.emp_mobile,emp.emp_email');
        $this->db->join('employee as emp','mon.emp_id = emp.emp_id','left');
        $this->db->where('mon.emp_id',$emp_id);
        $query = $this->db->get('monthly_salary as mon');
        if ($query->num_rows() > 0) {
        return $query->result();
        } else {
        return NULL;
        }
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
        $this->db->where('country_code',$data);
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
//        $this->db->select('image');
//        $this->db->from('admin');
//        $this->db->where('admin_id',$id);
//        $query = $this->db->get();
//        if ($query->num_row() > 0) {
//        return $query->result();
//        } else {
//        return NULL;
//        }
        return $this->db->select('image')->from('admin')->where('admin_id',$id)->order_by('admin_id','desc')->get()->row();
    }
    
    public function all_servey_list()
    {
        return $this->db->select('*')->from('survey')->where('status',1)->order_by('survey_id','desc')->get()->result();
    }
    
    // get all active site survey list
    public function all_sit_survey_list()
    {
        $this->db->select('ss.*');
        $this->db->select('pp.coordinator_name');
        $this->db->join('coordinator as pp','pp.coordinator_id = ss.coordinator_id','left');
        $this->db->where('ss.status',1);
        $this->db->order_by('ss.site_survey_id','desc');
        $query = $this->db->get('eti_site_survey as ss');
        if ($query->num_rows() > 0) {
        return $query->result();
        } else {
        return NULL;
        }
    }
    
    // get all active site survey list according to coordinator
    public function all_sit_survey_list_by_coordinator($coordinator_id)
    {
        $this->db->select('ss.*');
        $this->db->select('pp.coordinator_name');
        $this->db->join('coordinator as pp','pp.coordinator_id = ss.coordinator_id','left');
        $this->db->where('ss.status',1);
        $this->db->where('ss.coordinator_id',$coordinator_id);
        $this->db->order_by('ss.site_survey_id','desc');
        $query = $this->db->get('eti_site_survey as ss');
        if ($query->num_rows() > 0) {
        return $query->result();
        } else {
        return NULL;
        }
    }
    
    // get site survey list where status pending by coordinator
    public function sit_survey_list_with_coordinator_and_project()
    {
        $this->db->select('ss.*');
        $this->db->select('pp.coordinator_name');
        $this->db->join('coordinator as pp','pp.coordinator_id = ss.coordinator_id','left');
        $this->db->where('ss.status',1);
        $this->db->order_by('ss.site_survey_id','desc');
        $this->db->where('ss.expense_status_by_coordinator','Pending');
        $query = $this->db->get('eti_site_survey as ss');
        if ($query->num_rows() > 0) {
        return $query->result();
        } else {
        return NULL;
        }
    }
    
    // get site survey list according to coodinator where status pending by coordinator
    public function sit_survey_list_with_coordinator_and_project_by_coordinator($coordinator_id)
    {
        $this->db->select('ss.*');
        $this->db->select('pp.coordinator_name');
        $this->db->join('coordinator as pp','pp.coordinator_id = ss.coordinator_id','left');
        $this->db->join('project as pr','ss.project_work_order_no = pr.project_work_order_no','left');
        $this->db->where('ss.status',1);
        $this->db->where('ss.expense_status_by_coordinator','Pending');
        $this->db->where('ss.coordinator_id',$coordinator_id);
        $this->db->order_by('ss.site_survey_id','desc');
        $query = $this->db->get('eti_site_survey as ss');
        if ($query->num_rows() > 0) {
        return $query->result();
        } else {
        return NULL;
        }
    }
    
    // get site survey list where expense approved by coordinator
    public function sit_survey_list_approved_by_coordinator()
    {
        $this->db->select('ss.*');
        $this->db->select('pp.coordinator_name');
        $this->db->join('coordinator as pp','pp.coordinator_id = ss.coordinator_id','left');
        $this->db->where('ss.status',1);
        $this->db->where('ss.expense_status_by_coordinator','Approved');
        $this->db->where('ss.expense_approved_by_project_manager','Pending');
        $this->db->where('ss.paid_amount_status_by_accountant','Unpaid');
        $this->db->order_by('ss.site_survey_id','desc');
        $query = $this->db->get('eti_site_survey as ss');
        if ($query->num_rows() > 0) {
        return $query->result();
        } else {
        return NULL;
        }
    }
    
    // get site survey list where expense approved by project manager
    public function sit_survey_list_approved_by_project_manager()
    {
        $this->db->select('ss.*');
        $this->db->select('pp.coordinator_name');
        $this->db->join('coordinator as pp','pp.coordinator_id = ss.coordinator_id','left');
        $this->db->where('ss.status',1);
        $this->db->where('ss.expense_status_by_coordinator','Approved');
        $this->db->where('ss.expense_approved_by_project_manager','Approved');
        $this->db->where('ss.paid_amount_status_by_accountant','Unpaid');
        $this->db->order_by('ss.site_survey_id','desc');
        $query = $this->db->get('eti_site_survey as ss');
        if ($query->num_rows() > 0) {
        return $query->result();
        } else {
        return NULL;
        }
    }
    
    // get site survey list where expense approved by project manager nad partial paid by accountant
    public function sit_survey_list_partial_paid_accountant()
    {
        $this->db->select('ss.*');
        $this->db->select('pp.coordinator_name');
        $this->db->join('coordinator as pp','pp.coordinator_id = ss.coordinator_id','left');
        $this->db->where('ss.status',1);
        $this->db->where('ss.expense_status_by_coordinator','Approved');
        $this->db->where('ss.expense_approved_by_project_manager','Approved');
        $this->db->where('ss.paid_amount_status_by_accountant','Partial Paid');
        $this->db->order_by('ss.site_survey_id','desc');
        $query = $this->db->get('eti_site_survey as ss');
        if ($query->num_rows() > 0) {
        return $query->result();
        } else {
        return NULL;
        }
    }
    
    public function sit_survey_list_with_coordinator_and_project_by_coordinator_and_approved_by_coordinator($coordinator_id)
    {
        $this->db->select('ss.*');
        $this->db->select('pp.coordinator_name');
        $this->db->join('coordinator as pp','pp.coordinator_id = ss.coordinator_id','left');
        $this->db->where('ss.status',1);
        $this->db->where('ss.coordinator_id',$coordinator_id);
        $this->db->where('ss.expense_status_by_coordinator','Approved');
        $this->db->order_by('ss.site_survey_id','desc');
        $query = $this->db->get('eti_site_survey as ss');
        if ($query->num_rows() > 0) {
        return $query->result();
        } else {
        return NULL;
        }
    }
    
    public function sit_survey_detais_with_coordinator_and_project($site_survey_id)
    {
        $this->db->select('ss.*');
        $this->db->select('pp.coordinator_name');
        $this->db->join('coordinator as pp','pp.coordinator_id = ss.coordinator_id','left');
        $this->db->where('ss.site_survey_id',$site_survey_id);
        $query = $this->db->get('eti_site_survey as ss');
        if ($query->num_rows() > 0) {
        return $query->result();
        } else {
        return NULL;
        }
    }
    
    public function sit_survey_detais_approved_by_project_manager($site_survey_id)
    {
        $this->db->select('ss.*');
        $this->db->select('pp.coordinator_name');
        $this->db->join('coordinator as pp','pp.coordinator_id = ss.coordinator_id','left');
        $this->db->where('ss.site_survey_id',$site_survey_id);
        $query = $this->db->get('eti_site_survey as ss');
        if ($query->num_rows() > 0) {
        return $query->result();
        } else {
        return NULL;
        }
    }
    
    public function sit_survey_detais_partial_paid($site_survey_id) {
        $this->db->select('ss.*');
        $this->db->select('pp.coordinator_name');
        $this->db->join('coordinator as pp','pp.coordinator_id = ss.coordinator_id','left');
        $this->db->where('ss.site_survey_id',$site_survey_id);
        $query = $this->db->get('eti_site_survey as ss');
        if ($query->num_rows() > 0) {
        return $query->result();
        } else {
        return NULL;
        }
    }
    
    // get client details using work order number (woc)
    function get_client_details_by_woc($woc){
        $this->db->select('pp.*');
        $this->db->select('cl.*');
        $this->db->join('clients as cl','pp.client_id = cl.client_id','left');
        $this->db->where('pp.project_work_order_no',$woc);
        $query = $this->db->get('project as pp');
        if ($query->num_rows() > 0) {
        return $query->result();
        } else {
        return NULL;
        }
    }
    
    // get all expense details
    function get_all_expense_sheet() {
        return $this->db->select('*')->from('expense_sheet')->where('debit_amount != ',0,FALSE)->order_by('expense_sheet_id','desc')->get()->result();
    }
    
    // get coordinator details where not have dashboard access permission
    public function coordinator_list_with_no_access_panel() {
        $this->db->select('emp.emp_id,emp.emp_username');
        $this->db->select('cor.coordinator_id,cor.coordinator_name');
        $this->db->join('employee as emp','emp.emp_id = cor.emp_id','inner');
        $this->db->where('emp.panel_login_status',0);
        $this->db->where('cor.status',1);
        $query = $this->db->get('coordinator as cor');
        if ($query->num_rows() > 0) {
        return $query->result();
        } else {
        return NULL;
        }
    }
    
    // get coordinator details where have dashboard access permission
    public function coordinator_list_with_access_panel() {
        $this->db->select('emp.emp_id,emp.emp_username');
        $this->db->select('cor.coordinator_id,cor.coordinator_name');
        $this->db->join('employee as emp','emp.emp_id = cor.emp_id','inner');
        $this->db->where('emp.panel_login_status',1);
        $this->db->where('cor.status',1);
        $query = $this->db->get('coordinator as cor');
        if ($query->num_rows() > 0) {
        return $query->result();
        } else {
        return NULL;
        }
    }
    
    public function site_survey_pic_name($survey_id){
        
        return $this->db->select('survey_site_name,survey_angle1,survey_angle2,survey_angle3,survey_angle4')->from('eti_site_survey')->where('site_survey_id',$survey_id)->order_by('site_survey_id','desc')->get()->result();
    }
    
    // get all employee location visit activity
    public function employee_location_activity(){
        $this->db->select('emploc.*');
        $this->db->select('emp.emp_name,emp.emp_mobile,emp.emp_email');
        $this->db->join('employee as emp','emploc.emp_id = emp.emp_id','inner');
        $this->db->where('emp.status',1);
        $this->db->order_by('emploc.emp_activity_id','desc');
        $query = $this->db->get('employee_location_activity as emploc');
        if ($query->num_rows() > 0) {
        return $query->result();
        } else {
        return NULL;
        }
    }
    
    public function survey_pic_name($survey_id){
        
        return $this->db->select('survey_junction_name,survey_angle1,survey_angle2,survey_angle3,survey_angle4')->from('survey')->where('survey_id',$survey_id)->order_by('survey_id','desc')->get()->result();
    }

    public function all_shopkeeper()
    {
        return $this->db->select('*')->from('admin')->where('login_type_id',4)->order_by('admin_id','desc')->get()->result();
    }
    
    public function unique_priestList_from_priest_pooja_service_pandit_relationship($admin_id){
        $this->db->select('pt.priest_id');
        $this->db->select('pp.priest_name_en');
        $this->db->join('priest_pooja_service_pandit_relationship as pt','pt.priest_id = pp.id','left');
        $this->db->where('pt.admin_id',$admin_id);
        $this->db->group_by('pt.priest_id');
        $query = $this->db->get('priest_type as pp');
        if ($query->num_rows() > 0) {
        return $query->result();
        } else {
        return NULL;
        }
    }
    
    public function poojaServiceList_from_priest_pooja_service_pandit_relationship($admin_id,$priest_id){
        $this->db->select('pt.service_id');
        $this->db->select('pt.priest_pooja_service_pandit_id');
        $this->db->select('ps.service_name_en');
        $this->db->select('ps.service_name_hi');
        $this->db->join('priest_pooja_service_pandit_relationship as pt','pt.service_id = ps.service_id','left');
        $this->db->where('pt.admin_id',$admin_id);
        $this->db->where('pt.priest_id',$priest_id);
        $query = $this->db->get('pooja_service as ps');
        if ($query->num_rows() > 0) {
        return $query->result();
        } else {
        return NULL;
        }
    }
    
    public function team_member_list($coordinator_id){
		$this->db->select('emp.emp_id,emp.emp_name');
		$this->db->join('employee as emp','emp.emp_id=tl.emp_id','inner');
		$this->db->where('tl.coordinator_id',$coordinator_id);
		$this->db->order_by('tl.team_lead_id','desc');
		$query = $this->db->get('team_lead as tl');
        if ($query->num_rows() > 0) {
        	return $query->result();
        } else {
        	return NULL;
        }
	}
	
	public function material_issue_list($coordinator_id){
		$this->db->select('emp.emp_id,emp.emp_name,emp.emp_mobile,mis.*');
		$this->db->join('employee as emp','emp.emp_id=mis.emp_id','inner');
		$this->db->where('mis.coordinator_id',$coordinator_id);
		$this->db->order_by('mis.material_issue_or_stock_id','desc');
		$query = $this->db->get('material_issue_or_stock as mis');
        if ($query->num_rows() > 0) {
        	return $query->result();
        } else {
        	return NULL;
        }
	}
	
	public function material_issue_list_for_user($coordinator_id){
		$this->db->select('emp.emp_name as coordinator_name,emp.emp_mobile as coordinator_mobile,mis.*');
		$this->db->join('employee as emp','emp.emp_id=mis.coordinator_id','inner');
		$this->db->where('mis.emp_id',$coordinator_id);
		$this->db->order_by('mis.material_issue_or_stock_id','desc');
		$query = $this->db->get('material_issue_or_stock as mis');
        if ($query->num_rows() > 0) {
        	return $query->result();
        } else {
        	return NULL;
        }
	}
	
	public function employee_location_activity_by_date($from_date,$to_date){
	    $this->db->distinct('emp_id');
	    $this->db->select('employee_location_activity.emp_id');
	    $this->db->where('current_datetime>=',$from_date);
	    $this->db->where('current_datetime<=',$to_date);
	    $this->db->order_by('emp_activity_id','desc');
	    $query = $this->db->get('employee_location_activity');
	    if ($query->num_rows() > 0) {
        	return $query->result();
        } else {
        	return NULL;
        }
	}
	
	public function all_employee_location_activity(){
	    $this->db->distinct('emp_id');
	    $this->db->select('employee_location_activity.emp_id');
	    $this->db->order_by('emp_activity_id','desc');
	    $query = $this->db->get('employee_location_activity');
	    if ($query->num_rows() > 0) {
        	return $query->result();
        } else {
        	return NULL;
        }
	}
	
	public function last_employee_location_activity_by_emp_id($emp_id){
	    $this->db->select('*');
	    $this->db->join('employee as emp','emp.emp_id=ela.emp_id','inner');
	    $this->db->where('ela.emp_id',$emp_id);
	    $this->db->order_by('ela.emp_activity_id','desc');
	    $this->db->limit(1, 0);
	    $query = $this->db->get('employee_location_activity as ela');
	    if ($query->num_rows() > 0) {
        	return $query->result();
        } else {
        	return NULL;
        }
	}
	
	public function all_employee_location_activity_by_emp_id($emp_id,$from_date,$to_date){
	    $this->db->select('*');
	    $this->db->join('employee as emp','emp.emp_id=ela.emp_id','inner');
	    $this->db->where('ela.emp_id',$emp_id);
	    $this->db->where('ela.current_datetime>=',$from_date);
	    $this->db->where('ela.current_datetime<=',$to_date);
	    $this->db->order_by('ela.emp_activity_id','asc');
	    $query = $this->db->get('employee_location_activity as ela');
	    if ($query->num_rows() > 0) {
        	return $query->result();
        } else {
        	return NULL;
        }
	}

// SELECT pt.`service_id`, pt.`priest_pooja_service_pandit_id`, ps.service_name_en, ps.service_name_hi FROM `priest_pooja_service_pandit_relationship` AS pt LEFT JOIN pooja_service AS ps ON pt.`service_id` = ps.service_id WHERE pt.`admin_id` = 15 AND pt.`priest_id` = 1
    
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
