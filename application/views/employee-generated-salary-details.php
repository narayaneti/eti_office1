<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>ETI Office Management - Employee Salary Details</title>

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
tr .sorting{
    width:60px !important;
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
              <h6 class="m-0 font-weight-bold text-primary">Employee Salary Details</h6>
            </div>
            <div class="card-body">
                <form action='<?php echo base_url(); ?>admin/user/paySalary' onsubmit="return validateForm()" method='post'>
            <div class="row date_body">
            	<div class="col-sm-6 start_date form-group">
                    <label for="start_date">Name</label>
                    <input type="text" value="<?php echo $salary_details[0]->emp_name; ?>" name="name" placeholder="Employee Name" id="name" class="form-control" readonly="">
                    <input type="hidden" value="<?php echo $salary_details[0]->emp_id; ?>" name="emp_id" class="form-control" readonly="">
                </div>
                <div class="col-sm-6 start_date form-group">
                    <label for="start_date">Mobile</label>
                    <input type="text" value="<?php echo $salary_details[0]->emp_mobile; ?>" name="mobile" placeholder="Employee Mobile No" id="name" class="form-control" readonly="">
                </div>
                <div class="col-sm-6 start_date form-group">
                    <label for="start_date">User Id</label>
                    <input type="text" value="<?php echo $salary_details[0]->emp_username; ?>" name="emp_username" placeholder="emp_username" id="emp_username" class="form-control" readonly="">
                </div>
                <div class="col-sm-6 start_date form-group">
                    <label for="start_date">Mobile No</label>
                    <input type="text" value="<?php echo $salary_details[0]->emp_mobile; ?>" name="emp_mobile" placeholder="Mobile No" id="site_name" class="form-control" readonly="">
                </div>
                <div class="col-sm-6 start_date form-group">
                    <label for="start_date">Email Id</label>
                    <input type="text" value="<?php echo $salary_details[0]->emp_email; ?>" name="emp_email" placeholder="Rmail Id" id="emp_email" class="form-control" readonly="">
                </div>
                <div class="col-md-12 start_date">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Bank Details</h6>
                    </div>
                </div>
                <div class="col-sm-6 start_date form-group">
                    <label for="start_date">Bank Name</label>
                    <input type="text" value="<?php echo $salary_details[0]->emp_bank_name; ?>" name="emp_bank_name" placeholder="Rmail Id" id="emp_bank_name" class="form-control" readonly="">
                </div>
                <div class="col-sm-6 start_date form-group">
                    <label for="start_date">Account Holder</label>
                    <input type="text" value="<?php echo $salary_details[0]->emp_account_holder; ?>" name="emp_account_holder" placeholder="Rmail Id" id="emp_account_holder" class="form-control" readonly="">
                </div>
                <div class="col-sm-6 start_date form-group">
                    <label for="start_date">Account No</label>
                    <input type="text" value="<?php echo $salary_details[0]->emp_account_no; ?>" name="emp_account_no" placeholder="Rmail Id" id="emp_account_no" class="form-control" readonly="">
                </div>
                <div class="col-sm-6 start_date form-group">
                    <label for="start_date">IFSC Code</label>
                    <input type="text" value="<?php echo $salary_details[0]->emp_bank_ifsc; ?>" name="emp_bank_ifsc" placeholder="Rmail Id" id="emp_bank_ifsc" class="form-control" readonly="">
                </div>
                <div class="col-md-12 start_date">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Salary Details</h6>
                    </div>
                </div>
                <div class="col-sm-6 start_date form-group">
                    <label for="start_date">PF</label>
                    <input type="text" value="<?php echo $salary_details[0]->emp_salary_pf; ?>" name="emp_salary_pf" placeholder="PF" id="emp_salary_net" class="form-control" readonly="">
                </div>
                <div class="col-sm-6 start_date form-group">
                    <label for="start_date">ESIC</label>
                    <input type="text" value="<?php echo $salary_details[0]->emp_salary_esic; ?>" name="emp_salary_esic" placeholder="ESIC" id="emp_salary_gross" class="form-control" readonly="">
                </div>
                <div class="col-sm-6 start_date form-group">
                    <label for="start_date">Tax</label>
                    <input type="text" value="<?php echo $salary_details[0]->emp_salary_tax; ?>" name="emp_salary_tax" placeholder="Tax" id="emp_salary_net" class="form-control" readonly="">
                </div>
                <div class="col-sm-6 start_date form-group">
                    <label for="start_date">Other</label>
                    <input type="text" value="<?php echo $salary_details[0]->emp_salary_other; ?>" name="emp_salary_other" placeholder="Other" id="emp_salary_other" class="form-control" readonly="">
                </div>
                <div class="col-sm-6 start_date form-group">
                    <label for="start_date">TA</label>
                    <input type="text" value="<?php echo $salary_details[0]->emp_salary_ta; ?>" name="emp_salary_ta" placeholder="TA" id="emp_salary_ta" class="form-control" readonly="" readonly="">
                </div>
                
                <div class="col-sm-6 start_date form-group">
                    <label for="start_date">DA</label>
                    <input type="text" value="<?php echo $salary_details[0]->emp_salary_da; ?>" name="emp_salary_da" placeholder="DA" id="emp_salary_da" class="form-control" readonly="" readonly="">
                </div>
                <div class="col-sm-6 start_date form-group">
                    <label for="start_date">Net Salary*</label>
                    <input type="text" value="<?php echo $salary_details[0]->emp_salary_net; ?>" name="net_salary" placeholder="Net Salary" id="emp_salary_net" class="form-control" readonly="" readonly="">
                </div>
                
                <div class="col-sm-6 start_date form-group">
                    <label for="start_date">Gross Salary*</label>
                    <input type="text" value="<?php echo $salary_details[0]->emp_salary_gross; ?>" name="gross_salary" placeholder="Gross Salary" id="emp_salary_gross" class="form-control" readonly="" readonly="">
                </div>
                <div class="col-sm-6 start_date form-group">
                    <label for="start_date">Total Present*</label>
                    <input type="number" value="<?php echo $salary_details[0]->total_present; ?>"  name="total_present" placeholder="Total Present" id="total_present" class="form-control" required="" readonly="">
                </div>
                <div class="col-sm-6 start_date form-group">
                    <label for="start_date">Total Absent*</label>
                    <input type="number" value="<?php echo $salary_details[0]->total_absent; ?>"  name="total_absent" placeholder="Total Absent" id="total_absent" class="form-control" required="" readonly="">
                </div>
                <div class="col-sm-6 start_date form-group">
                    <label for="start_date">Other(Extra Paiyable Money)* </label>
                    <input type="number" value="<?php echo $salary_details[0]->other_salary; ?>"  name="other_salary" placeholder="Extra Paiyable Money" id="other_salary" class="form-control" required="" readonly="">
                </div>
                <div class="col-sm-6 start_date form-group">
                    <label for="start_date">Advance Paid Amount*</label>
                    <input type="number" value="<?php echo $salary_details[0]->advance_salary; ?>"  name="advance_salary" placeholder="Advance Paid Amount" id="advance_salary" class="form-control" required="" readonly="">
                </div>
                <div class="col-sm-6 start_date form-group">
                    <label for="start_date">Paiyable Monthly Salary*</label>
                    <input type="number" value="<?php echo $salary_details[0]->monthly_salary_amount; ?>"  name="monthly_salary_amount" placeholder="Extra Paiyable Money" id="monthly_salary" class="form-control" required="" readonly="">
                </div>
                <div class="col-sm-6 start_date form-group">
                    <label for="start_date">Total Paiyable Salary*</label>
                    <input type="text" value="<?php echo $salary_details[0]->total_salary; ?>" name="total_salary" placeholder="Total Paiyable Amount" id="total_salary" class="form-control" required="" readonly="">
                </div>
                <div class="col-sm-6 start_date form-group">
                    <label for="start_date">Hr Status*</label>
                    <input type="text" value="<?php echo $salary_details[0]->hr_status; ?>" name="hr_status" placeholder="Month Name" id="months_salary" class="form-control" readonly="">
                </div>
                <div class="col-sm-6 start_date form-group">
                    <label for="start_date">Month*</label>
                    <input type="date" value="<?php echo $salary_details[0]->month_name; ?>" name="month_name" placeholder="Month Name" id="months_salary" class="form-control" readonly="">
                </div>
                <div class="col-md-6 start_date form-group">
                    <label for="start_date">WOC*</label>
                    <input type="text" value="<?php echo $salary_details[0]->woc; ?>" name="woc" placeholder="WOC" id="woc" class="form-control" readonly="">
                </div>
                <div class="col-sm-6 start_date form-group">
                    <label for="start_date">Hr Comments</label>
                    <input type="text" value="<?php echo $salary_details[0]->hr_comments; ?>" name="hr_comments" placeholder="Comments" id="hr_comments" class="form-control" readonly="">
                </div>
                <div class="col-sm-6 start_date form-group">
                    <label for="start_date">Salary Status**</label>
                    <select name="salary_status" class="form-control" required="">
                        <option value="">Select Salary Status</option>
                        <option value="Unpaid">Unpaid</option>
                        <option value="Paid">Paid</option>
                    </select>
                </div>
                <div class="col-sm-6 start_date form-group">
                    <input type="hidden" value="<?php echo $salary_details[0]->monthly_salary_id; ?>" name="monthly_salary_id" placeholder="monthly_salary_id" id="monthly_salary_id" class="form-control" readonly="">
                </div>
                <div class="col-md-2 start_date form-group" style="">
                    <input type="submit" id="submit" value="PAY SALARY" name="submit"class="btn btn-success" >
                </div>
                </div>
                </form>  
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

</script>
</body>
</html>
