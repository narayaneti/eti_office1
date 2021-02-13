<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>ETI Office Management | Add Employee</title>

  <!-- Custom fonts for this template -->
  <link href="<?php echo base_url(); ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="<?php echo base_url(); ?>css/sb-admin-2.min.css" rel="stylesheet">

  <!-- Custom styles for this page -->
  <link href="<?php echo base_url(); ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<style>
.cal_date{
	display: inline-block;
	width:50%;
}
.end_date{
	text-align:right;
}
.date_body{
	padding-bottom:10px;
}
.download_button{
	    background-color: #fff;
    border: 0;
    color: blue;
}
@media(max-width:768px){
	.start_date,.end_date{
		text-align:center;
	}
}
</style>
</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <?php include_once 'files/left_sidebar.php'; ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <?php include_once 'files/header.php'; ?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
       <div class="container-fluid">
		
       <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Employee Official Details</h6>
            </div>
            <div class="card-body">
            <div class="row date_body">
            	<div class="col-sm-6 start_date form-group">
                    <label for="start_date">Employee Full Name</label>
                    <input type="text" value="<?php echo $emp_resp[0]->emp_name; ?>" name="name" placeholder="Employee Name" id="name" class="form-control" required="">
                    <input type="hidden" value="<?php echo $emp_resp[0]->emp_id; ?>" name="emp_id" placeholder="Emp Id" id="site_name" class="form-control" required="" readonly="">
                </div>
                <div class="col-sm-6 start_date form-group">
                    <label for="start_date">Mobile</label>
                    <input type="text" value="<?php echo $emp_resp[0]->emp_mobile; ?>" name="mobile" placeholder="Employee Mobile No" id="name" class="form-control" required="">
                </div>
                <div class="col-sm-6 start_date form-group">
                    <label for="start_date">Email Id</label>
                    <input type="email" value="<?php echo $emp_resp[0]->emp_email; ?>" name="email" placeholder="Employee Email Id" id="name" class="form-control" required="">
                </div>
                <div class="col-sm-6 start_date form-group">
                    <label for="start_date">Employee Id</label>
                    <input type="text" value="<?php echo $emp_resp[0]->emp_username; ?>" name="employee_id" placeholder="Employee Id" id="site_name" class="form-control" required="" readonly="">
                </div>
                
                <div class="col-sm-6 start_date form-group">
                    <label for="start_date">Department</label>
                    <select name="department_id" placeholder="department" id="department_id" class="form-control" required="">
                        <option value="">Select Department</option>
                        <?php 
                        if(isset($department_resp)){
                            $sn = 1;
                            foreach ($department_resp as $key => $value) {
                                echo "<option value='$value->department_id'";
                                if($emp_resp[0]->department_id == $value->department_id) echo " selected";
                                    echo">$value->department</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="col-sm-6 start_date form-group">
                    <label for="start_date">Designation </label>
                    <select name="designation_id" placeholder="Designation" id="designation_id" class="form-control" required>
                        <option value="">Select Designation</option>
                        <?php 
                        if(isset($designation_resp)){
                            $sn = 1;
                            foreach ($designation_resp as $key => $value) {
                                echo "<option value='$value->department_id'";
                                if($emp_resp[0]->designation_id == $value->designation_id) echo " selected";
                                    echo">$value->designation</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="col-sm-6 start_date form-group">
                    <label for="start_date">Technology </label>
                    <select name="technology_id" placeholder="Designation" id="technology_id" class="form-control" required="">
                        <option value="">Select Technology</option>
                        <?php 
                        if(isset($technology_resp)){
                            $sn = 1;
                            foreach ($technology_resp as $key => $value) {
                                echo "<option value='$value->technology_id'";
                                if($emp_resp[0]->technology_id == $value->technology_id) echo " selected";
                                    echo">$value->technology</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="col-sm-6 start_date form-group">
                    <label for="start_date">Joining Date</label>
                    <input type="date" value="<?php echo $emp_resp[0]->emp_joining_date; ?>" name="joining_date" placeholder="Site Id" id="joining_date" class="form-control" required="">
                </div>
                <div class="col-sm-6 start_date form-group">
                    <label for="start_date">Training Days</label>
                    <input type="text" value="<?php echo $emp_resp[0]->emp_training_days; ?>" name="training_days" placeholder="Training Days" id="training_days" class="form-control">
                </div>
                <div class="col-sm-6 start_date form-group">
                    <label for="start_date">Password</label>
                    <input type="text" value="<?php echo $this->encryption->decrypt($emp_resp[0]->emp_password); ?>" name="emp_password" placeholder="Training Days" id="training_days" class="form-control" readonly="">
                </div>
                </div>
            </div>
            <div class="card-header py-3" style="border-top: 1px solid #e3e6f0;">
              <h6 class="m-0 font-weight-bold text-primary">Employee Banking Details</h6>
            </div>
            <div class="card-body">
            <div class="row date_body">
                <div class="col-sm-6 start_date form-group">
                    <label for="start_date">Bank Name</label>
                    <input type="text" value="<?php echo $bank_resp[0]->emp_bank_name; ?>" name="bank_name" placeholder="Bank Name" id="name" class="form-control" required="">
                </div>
                <div class="col-sm-6 start_date form-group">
                    <label for="start_date">IFSC Codes</label>
                    <input type="text" value="<?php echo $bank_resp[0]->emp_bank_ifsc; ?>" name="ifsc" placeholder="IFSC Codes" id="name" class="form-control" required="">
                </div>
            	<div class="col-sm-6 start_date form-group">
                    <label for="start_date">Account Holder Name</label>
                    <input type="text" value="<?php echo $bank_resp[0]->emp_account_holder; ?>" name="account_holder" placeholder="Account Holder Name" id="name" class="form-control" required="">
                </div>
                <div class="col-sm-6 start_date form-group">
                    <label for="start_date">Account No</label>
                    <input type="text" value="<?php echo $bank_resp[0]->emp_account_no; ?>" name="account_number" placeholder="Account No" id="name" class="form-control" required="">
                </div>
            </div>
            </div>
            <div class="card-header py-3" style="border-top: 1px solid #e3e6f0;">
              <h6 class="m-0 font-weight-bold text-primary">Employee Salary Details</h6>
            </div>
            <div class="card-body">
            <div class="row date_body">
                <div class="col-sm-6 start_date form-group">
                    <label for="start_date">Gross Salary</label>
                    <input type="number" value="<?php echo $salary_resp[0]->emp_salary_gross; ?>" name="gross_salary" placeholder="Gross Salary" id="name" class="form-control" required="">
                </div>
                <div class="col-sm-6 start_date form-group">
                    <label for="start_date">Net Salary</label>
                    <input type="number" value="<?php echo $salary_resp[0]->emp_salary_net; ?>" name="net_salary" placeholder="Net Salary" id="name" class="form-control" required="">
                </div>
                <div class="col-sm-6 start_date form-group">
                    <label for="start_date">Provident Fund</label>
                    <input type="number" value="<?php echo $salary_resp[0]->emp_salary_pf; ?>" name="pf" placeholder="Provident Fund" id="name" class="form-control" required="">
                </div>
                <div class="col-sm-6 start_date form-group">
                    <label for="start_date">ESIC</label>
                    <input type="number" value="<?php echo $salary_resp[0]->emp_salary_esic; ?>" name="esic" placeholder="ESIC" id="name" class="form-control" required="">
                </div>
            	<div class="col-sm-6 start_date form-group">
                    <label for="start_date">Other</label>
                    <input type="number" value="<?php echo $salary_resp[0]->emp_salary_other; ?>" name="other" placeholder="Other" id="name" class="form-control" required="">
                </div>
                <div class="col-sm-6 start_date form-group">
                    <label for="start_date">Tax</label>
                    <input type="number" value="<?php echo $salary_resp[0]->emp_salary_tax; ?>" name="tax" placeholder="Tax" id="name" class="form-control" required="">
                </div>
                <div class="col-sm-6 start_date form-group">
                    <label for="start_date">Insurance</label>
                    <input type="text" value="<?php echo $salary_resp[0]->emp_salary_insurance; ?>" name="insurance" placeholder="Insurance" id="name" class="form-control" required="">
                </div>
                <div class="col-sm-6 start_date form-group">
                    <label for="start_date">Travelling Allowance</label>
                    <input type="number" value="<?php echo $salary_resp[0]->emp_salary_ta; ?>" name="ta" placeholder="Travelling Allowance" id="name" class="form-control" required="">
                </div>
                <div class="col-sm-6 start_date form-group">
                    <label for="start_date">Dearness Allowance</label>
                    <input type="number" value="<?php echo $salary_resp[0]->emp_salary_da; ?>" name="da" placeholder="Dearness Allowance" id="name" class="form-control" required="">
                </div>
                
            </div>
            </div>
            <div class="card-header py-3" style="border-top: 1px solid #e3e6f0;">
              <h6 class="m-0 font-weight-bold text-primary">Employee Personal Details</h6>
            </div>
           <div class="card-body">
            <div class="row date_body">
            	<div class="col-sm-6 start_date form-group">
                    <label for="start_date">Employee DOB</label>
                    <input type="date" value="<?php echo $emp_resp[0]->emp_dob; ?>" name="dob" placeholder="Employee DOB" id="dob" class="form-control" required="">
                </div>
                <div class="col-sm-6 start_date form-group">
                    <label for="start_date">Employee Blood Group</label>
                    <input type="text" value="<?php echo $emp_resp[0]->emp_blood_group; ?>" name="blood_group" placeholder="Employee Blood Group" id="blood_group" class="form-control" required="">
                </div>
                <div class="col-sm-6 start_date form-group">
                    <label for="start_date">Father's Name</label>
                    <input type="text" value="<?php echo $emp_resp[0]->emp_father; ?>" name="fname" placeholder="Employee Father's Name" id="name" class="form-control" required="">
                </div>
                <div class="col-sm-6 start_date form-group">
                    <label for="start_date">Mother's Name</label>
                    <input type="text" value="<?php echo $emp_resp[0]->emp_mother; ?>" name="mname" placeholder="Employee Mother's Name" id="name" class="form-control" required="">
                </div>
                <div class="col-sm-6 start_date form-group">
                    <label for="start_date">Highest Qualification</label>
                    <input type="text" value="<?php echo $emp_resp[0]->emp_qualification; ?>" name="qualification" placeholder="Highest Qualification" id="dob" class="form-control" required="">
                </div>
                <div class="col-sm-6 start_date form-group">
                    <label for="start_date">Family Contact No</label>
                    <input type="text" value="<?php echo $emp_resp[0]->emp_family_contact; ?>" name="family_contact" placeholder="Employee Family Contact No" id="blood_group" class="form-control" required="">
                </div>
                <div class="col-sm-6 start_date form-group">
                    <label for="start_date">Current Address</label>
                    <input type="text" value="<?php echo $emp_resp[0]->emp_temp_address; ?>" name="current_address" placeholder="HN, Colony, Street, Landmark (Full Address) " id="name" class="form-control" required="">
                </div>
                <div class="col-sm-6 start_date form-group">
                    <label for="start_date">Current City</label>
                    <input type="text" value="<?php echo $emp_resp[0]->emp_temp_city; ?>" name="current_city" placeholder="Current City" id="current_city" class="form-control" required="">
                </div>
                <div class="col-sm-6 start_date form-group">
                    <label for="start_date">Current State</label>
                    <input type="text" value="<?php echo $emp_resp[0]->emp_temp_state; ?>" name="current_state" placeholder="Current State" id="site_name" class="form-control" required="">
                </div>
                <div class="col-sm-6 start_date form-group">
                    <label for="start_date">Permanent Address</label>
                    <input type="text" value="<?php echo $emp_resp[0]->emp_parmanent_address; ?>" name="permanent_address" placeholder="HN, Colony, Street, Landmark (Full Address) " id="name" class="form-control" required="">
                </div>
                <div class="col-sm-6 start_date form-group">
                    <label for="start_date">Permanent City</label>
                    <input type="text" value="<?php echo $emp_resp[0]->emp_parmanent_city; ?>" name="permanent_city" placeholder="Permanent City" id="current_city" class="form-control" required="">
                </div>
                <div class="col-sm-6 start_date form-group">
                    <label for="start_date">Permanent State</label>
                    <input type="text" value="<?php echo $emp_resp[0]->emp_parmanent_state; ?>" name="permanent_state" placeholder="Permanent State" id="site_name" class="form-control" required="">
                </div>
                
                
                </div>
               <button  type="submit" name="submit" id="submit" class="btn btn-success" style="margin-bottom:10px;">Update Details</a>
             
            </div>
           
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Your Website 2019</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="login.html">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="<?php echo base_url(); ?>vendor/jquery/jquery.min.js"></script>
  <script src="<?php echo base_url(); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?php echo base_url(); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?php echo base_url(); ?>js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="<?php echo base_url(); ?>vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo base_url(); ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="<?php echo base_url(); ?>js/demo/datatables-demo.js"></script>
<script>
$(document).ready(function() {
     $("#submit").on("click", function() {
        
                var aurl = "<?php echo base_url(); ?>index.php/admin/User/update_employee_details";
                var designation_id = $('select[name="designation_id"]').val();
                var department_id = $('select[name="department_id"]').val();
                var technology_id = $('select[name="technology_id"]').val();
                var emp_id = $("input[name='emp_id']").val();
                alert(emp_id);
                var name = $("input[name='name']").val();
                var mobile = $("input[name='mobile']").val();
                var email = $("input[name='email']").val();
                var employee_id = $("input[name='employee_id']").val();
                var password = $("input[name='password']").val();
                var joining_date = $("input[name='joining_date']").val();
                var training_days = $("input[name='training_days']").val();
                var bank_name = $("input[name='bank_name']").val();
                var ifsc = $("input[name='ifsc']").val();
                var account_holder = $("input[name='account_holder']").val();
                var account_number = $("input[name='account_number']").val();
                var gross_salary = $("input[name='gross_salary']").val();
                var net_salary = $("input[name='net_salary']").val();
                var pf = $("input[name='pf']").val();
                var esic = $("input[name='esic']").val();
                var other = $("input[name='other']").val();
                var tax = $("input[name='tax']").val();
                var insurance = $("input[name='insurance']").val();
                var ta = $("input[name='ta']").val();
                var da = $("input[name='da']").val();
                var dob = $("input[name='dob']").val();
                var blood_group = $("input[name='blood_group']").val();
                var fname = $("input[name='fname']").val();
                var mname = $("input[name='mname']").val();
                var qualification = $("input[name='qualification']").val();
                var family_contact = $("input[name='family_contact']").val();
                var current_address = $("input[name='current_address']").val();
                var current_city = $("input[name='current_city']").val();
                var current_state = $("input[name='current_state']").val();
                var permanent_address = $("input[name='permanent_address']").val();
                var permanent_city = $("input[name='permanent_city']").val();
                var permanent_state = $("input[name='permanent_state']").val();
                var dataString1 = 'emp_id=' + emp_id + '&name='+ name + '&mobile=' + mobile + '&email=' + email + '&employee_id=' + employee_id + '&password=' + password + '&joining_date='+ joining_date + '&training_days='+ training_days + '&bank_name='+ bank_name + '&designation_id=' + designation_id;
                dataString1 += '&ifsc='+ ifsc + '&account_holder=' + account_holder + '&account_number=' + account_number + '&gross_salary=' + gross_salary + '&net_salary=' + net_salary + '&pf='+ pf + '&esic='+ esic + '&other='+ other;
                dataString1 += '&tax='+ tax + '&insurance=' + insurance + '&ta=' + ta + '&da=' + da + '&dob=' + dob + '&blood_group='+ blood_group + '&fname='+ fname + '&mname='+ mname;
                dataString1 += '&qualification='+ qualification + '&family_contact=' + family_contact + '&current_address=' + current_address + '&current_city=' + current_city + '&current_state=' + current_state + '&permanent_address='+ permanent_address + '&permanent_city='+ permanent_city + '&permanent_state='+ permanent_state;
                dataString1 += '&department_id='+ department_id + '&technology_id=' + technology_id
                alert(dataString1);
                $.ajax({
                    type: "POST",
                    url: aurl, 
                    data: dataString1,
                    dataType: "text",  
           //         cache:false,
                    success: 
                         function(data){
                             if(data != "No any relationship found!"){
                               $('#responseData').html("<table class='table' ui-jq='footable' ui-options=''><thead><tr><th>Rel. Id</th><th>Name In English</th><th>Name In Hindi</th><th>Pooja Service</th><th>Admin</th> <th>Created At</th></tr></thead><tbody>"+data+"</tbody></table>");
                            }else{
                                $('#responseData').html("<h4>No Relationship Found!</h4>");
                            }
                           alert(data);  //as a debugging message.
                    }
                });
            
                return false;
    });
});
</script>
</body>

</html>

?>