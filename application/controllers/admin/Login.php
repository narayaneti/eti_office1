<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends CI_Controller {

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

      
        
        $this->load->database();
        $this->load->library('encryption');
        
        $this->load->library('zip');
        $this->load->library('mainlogin');
        }
	
	public function index($msg = null)
	{
		$data['msg'] = $msg;
                $this->load->view('index', $data);
        }
        public function process(){
        
        $this->form_validation->set_rules('mobile', 'Mobile', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                if(isset($this->session->userdata['admin_in'])){
                    $this->load->view('dashboard');
                }else{
                    $this->load->view('login');
                    $data = array(
                    'error_message' => 'Invalid Mobile No or Password'
                    );
                    $this->load->view('login', $data);
                }
            } else {
                $mobile = $this->input->post('mobile');
                $password = $this->input->post('password');
                
//                $result = $this->login_database->login($data);
                $this->load->library('mainlogin');
                $resp =  $this->mainlogin->login($mobile,$password); 
                if ($resp['status'] == 200) {
                    $mobile = $this->input->post('mobile');
                    print_r($resp);
                    $result = $this->login_database->read_user_information($mobile);
                    if ($result != false) {
                    $session_data = array(
                    'first_name' => $result[0]->first_name,
                    'last_name' => $result[0]->last_name,
                    'email' => $result[0]->email,
                    'email' => $result[0]->mobile,
                    );
                    // Add user data in session
                    $this->session->set_userdata('admin_in', $session_data);
                    $this->load->view('dashboard');
                    }
                } else {
                    $data = array(
                    'error_message' => 'Invalid Username or Password'
                    );
                    $this->load->view('login', $data);
//                    redirect('user/index',$data);
                }
            }
        }
        
        public function auth() {
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
        
        // Logout from admin page
            public function logout() {

            // Removing session data
            $sess_array = array(
            'username' => ''
            );
            $this->session->unset_userdata('admin_in', $sess_array);
            $data['error_message'] = 'Successfully Logout';
            $this->load->view('login', $data);
            }
}
