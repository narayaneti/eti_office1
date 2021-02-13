<?php
class Mainpooja{

   protected $CI;
    public function __construct()
        {
                // Assign the CodeIgniter super-object
                $this->CI =& get_instance();
        }
    
    function show_hello_world()
    {
        $text = "Hello World";
        return $text;
    }
    
    function priest_list(){
        $CI =& get_instance();
        $CI =& get_instance();
        $CI->load->model('PoojaModel');
        return $response = $CI->PoojaModel->all_priest(); 
    }
    
    function priest_by_id($id){
        $CI =& get_instance();
        $CI =& get_instance();
        $CI->load->model('PoojaModel');
        return $response = $CI->PoojaModel->priest_details_by_id($id);
    }
            
    function insert_data($table,$data){
        $CI =& get_instance();
        $CI =& get_instance();
        $CI->load->model('PoojaModel');
        return $response = $CI->PoojaModel->create_data($table,$data); 
    }
    
    function poojaservice_list(){
        $CI =& get_instance();
        $CI =& get_instance();
        $CI->load->model('PoojaModel');
        return $response = $CI->PoojaModel->all_poojaservice(); 
    }
    
    function poojaservice_by_id($id){
        $CI =& get_instance();
        $CI =& get_instance();
        $CI->load->model('PoojaModel');
        return $response = $CI->PoojaModel->pooja_service_by_id($id);
    }
    
    function poojas_list(){
        $CI =& get_instance();
        $CI =& get_instance();
        $CI->load->model('PoojaModel');
        return $response = $CI->PoojaModel->all_poojas(); 
    }
    
    function details_by_conditions($table,$data){
        $CI =& get_instance();
        $CI =& get_instance();
        $CI->load->model('PoojaModel');
        return $response = $CI->PoojaModel->select_details_by_conditions($table,$data); 
    }
    
    function create_priest_pooja_relationship($table,$data){
        $CI =& get_instance();
        $CI =& get_instance();
        $CI->load->model('PoojaModel');
        return $response = $CI->PoojaModel->create_data($table,$data); 
    }
      
    function getRelatationship_by_priest($id){
        $CI =& get_instance();
        $CI =& get_instance();
        $CI->load->model('PoojaModel');
        return $response = $CI->PoojaModel->get_priest_pooja_relationship_by_priest($id); 
    }
    
    function pooja_details_by_id($id){
        $CI =& get_instance();
        $CI =& get_instance();
        $CI->load->model('PoojaModel');
        return $response = $CI->PoojaModel->poojas_detail_by_id($id);
    }
    
    function getRelatationship_by_pooja($id){
        $CI =& get_instance();
        $CI->load->model('PoojaModel');
        return $response = $CI->PoojaModel->get_priest_pooja_relationship_by_pooja($id); 
    }
    
    function getPoojalist_by_priest_and_service($priest_preference_id,$pooja_service_id){
        $CI =& get_instance();
        $CI->load->model('PoojaModel');
        return $response = $CI->PoojaModel->get_poojalist_by_priest_and_service($priest_preference_id,$pooja_service_id); 
    }
    
    function image_upload($image_data){
      $image = $image_data['image'];
      $image_path = $image_data['upload_path'];
      $temp_name = $image_data['temp_name'];
      $CI =& get_instance();
      $CI->load->helper('url');
      $CI->load->helper('form');
      $CI->load->helper('text');
      $image_name = md5(uniqid(rand(), true)).$temp_name;
      $config['upload_path']   = $image_path; 
      $config['allowed_types'] = 'gif|jpg|png|bmp|jpeg'; 
      $config['file_name'] = $image_name;
      $config['max_size']      = 2048000; 
//    $config['max_width']     = 1024; 
//    $config['max_height']    = 768;  
      $CI->load->library('upload', $config);

      if (!$CI->upload->do_upload($image)) {
            $error = array('error' => $CI->upload->display_errors()); 
            $CI->mainlogin->enter(); 
            $resp =  $CI->mainpooja->priest_list();
            $result = array(
              'status' => 400,
              'error' => $error,
            );
        }
        else{
            $result = array(
              'status' => 200,
              'image_name' => $image_name,
            );
        }
      
      
      return $result;
    }
    
    function priest_preference_pooja_by_id($priest_preference_pooja_id){
        $CI =& get_instance();
        $CI->load->model('PoojaModel');
        return $response = $CI->PoojaModel->get_priest_pooja_relationship_by_id($priest_preference_pooja_id); 
    }
    
    /**
     * get_pooja_item_list_for_particular_pooja() is used to get itel list for particular pooja
     * @param type $pooja_id is used to idetifiy particular pooja item list
     */
    function get_pooja_item_list_for_particular_pooja($pooja_id){
        $CI =& get_instance();
        $CI->load->model('PoojaModel');
        return $response = $CI->PoojaModel->get_pooja_item_list_for_pooja($pooja_id); 
    }
    
    function update_profile1($admin_id,$data){
        $CI =& get_instance();
        $CI->load->model('LoginModel');
        $response = $CI->LoginModel->update_admin_details($admin_id,$data);
        return $response;
    }
    
    function pandit_table1(){
        $CI =& get_instance();
        $CI->load->model('LoginModel');
        $response = $CI->LoginModel->pandit_availability();
        return $response;
    }
    
    function file_upload1($image,$imgtype){
      $CI =& get_instance();
      $CI->load->helper('url');
      $CI->load->helper('form');
      $CI->load->helper('text');
      $image = base64_decode($image);
      $image_name = md5(uniqid(rand(), true));
      $filename = $image_name . '.' . $imgtype;
      $path = "./pandit_image/".$filename;
      if(file_put_contents($path . $filename, $image)){
          $result = array(
              'status' => 200,
              'image_name' => $filename,
              'image_path' => $path,
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
    
    function pandit_list(){
        $CI =& get_instance();
        $CI->load->model('LoginModel');
        return $response = $CI->LoginModel->all_pandit(); 
    }
    
    function item_list(){
        $CI =& get_instance();
        $CI =& get_instance();
        $CI->load->model('PoojaModel');
        return $response = $CI->PoojaModel->all_item_list(); 
    }
    
    
}

?>