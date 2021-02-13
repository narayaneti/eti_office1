<?php
if (isset($this->session->userdata['admin_in'])) {
$username = ($this->session->userdata['admin_in']['first_name']);
$email = ($this->session->userdata['admin_in']['email']);
} else {
   redirect('user/index');
}