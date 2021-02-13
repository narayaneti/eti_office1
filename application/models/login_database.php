<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/* Author: Sanjay Soni
 * Description: Login model class
 */
class Login_database extends CI_Model{
    function __construct(){
        // Call the Model constructor
        parent::__construct();
    }

    // Read data using username and password
    public function login($data) {

    $condition = "username =" . "'" . $data['username'] . "' AND " . "password =" . "'" . $data['password'] . "'";
    $this->db->select('*');
    $this->db->from('admin');
    $this->db->where($condition);
    $this->db->limit(1);
    $query = $this->db->get();

    if ($query->num_rows() == 1) {
    return true;
    } else {
    return false;
    }
    }
    
    // Read data from database to show data in admin page
    public function read_user_information($username) {

    $condition = "username =" . "'" . $username . "'";
    $this->db->select('*');
    $this->db->from('admin');
    $this->db->where($condition);
    $this->db->limit(1);
    $query = $this->db->get();

    if ($query->num_rows() == 1) {
    return $query->result();
    } else {
    return false;
    }
    }
    
    public function all_query($data) {
       $response = $this->db->query($data); 
       return $response;
    }
}
?>     