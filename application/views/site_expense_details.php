<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>SB Admin 2 - Tables</title>

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
              <h6 class="m-0 font-weight-bold text-primary">Employee Site Location Visit/Survey Expense Details</h6>
            </div>
            <div class="card-body">
            <form action='<?php echo base_url(); ?>admin/user/change_survey_coordinator' onsubmit="return validateForm()" method='post'>
            <div class="row date_body">
            	<div class="col-sm-3 start_date form-group">
                    <label for="start_date">Name</label>
                    <input type="text" value="<?php echo $site_resp[0]->survey_emp_name; ?>" name="name" placeholder="Employee Name" id="name" class="form-control" readonly="">
                </div>
                <div class="col-sm-2 start_date form-group">
                    <label for="start_date">Mobile</label>
                    <input type="text" value="<?php echo $site_resp[0]->survey_emp_mobile; ?>" name="mobile" placeholder="Employee Mobile No" id="name" class="form-control" readonly="">
                </div>
                <div class="col-sm-4 start_date form-group">
                    <label for="start_date">Site Name</label>
                    <input type="text" value="<?php echo $site_resp[0]->survey_site_name; ?>" name="site_name" placeholder="Site Name" id="site_name" class="form-control" readonly="">
                </div>
                <div class="col-sm-3 start_date form-group">
                    <label for="start_date">Site Id</label>
                    <input type="text" value="<?php echo $site_resp[0]->survey_site_id; ?>" name="site_id" placeholder="Site Id" id="site_name" class="form-control" readonly="">
                </div>
                
                <div class="col-sm-2 start_date form-group">
                    <label for="start_date">Latitude</label>
                    <input type="text" value="<?php echo $site_resp[0]->survey_lat; ?>" name="site_id" placeholder="Site Id" id="site_name" class="form-control" readonly="">
                </div>
                <div class="col-sm-2 start_date form-group">
                    <label for="start_date">Longitude</label>
                    <input type="text" value="<?php echo $site_resp[0]->survey_long; ?>" name="site_id" placeholder="Site Id" id="site_name" class="form-control" readonly="">
                </div>
                <div class="col-sm-2 start_date form-group">
                    <label for="start_date">Site Location</label>
                    <input type="text" value="<?php echo $site_resp[0]->survey_location; ?>" name="site_id" placeholder="Site Id" id="site_name" class="form-control" readonly="">
                </div>
                <div class="col-sm-2 start_date form-group">
                    <label for="start_date">Survey Date</label>
                    <input type="text" value="<?php echo $site_resp[0]->survey_date; ?>" name="site_id" placeholder="Site Id" id="site_name" class="form-control" readonly="">
                </div>
                <div class="col-sm-2 start_date form-group">
                    <label for="start_date">Site Status</label>
                    <input type="text" value="<?php echo $site_resp[0]->site_status; ?>" name="site_status" placeholder="Site Status" id="site_status" class="form-control" readonly="">
                </div>
                
                <div class="col-sm-6 start_date form-group">
                    <label for="start_date">Coordinator</label>
                    <select name="coordinator" class="form-control" required="">
                        <?php
                            if(isset($coordinator_resp)){
                                foreach ($coordinator_resp as $key => $value) {
                                    echo "<option value='$value->coordinator_id'";
                                    if($site_resp[0]->coordinator_id == $value->coordinator_id){ echo " selected ";}
                                    echo ">$value->coordinator_name</option>";
                                } 
                            }
                        ?>
                    </select>
                </div>
                <div class="col-sm-6 form-group">
                    <input type="hidden" value="<?php echo $site_resp[0]->site_survey_id; ?>" name="site_survey_id" placeholder="Employee Name" id="site_survey_id" class="form-control" readonly="" required="">
                </div>
                <div class="col-sm-12 start_date form-group">
                    <label for="start_date"></label>
                    <input type="submit" class="btn btn-danger" name="change_coordinator" value="Change Coordinator"/>
                </div>
                
                <div class="col-sm-12 start_date form-group">
                    <label for="start_date">Remark</label>
                    <input type="text" value="<?php echo $site_resp[0]->survey_remark; ?>" name="survey_remark" placeholder="Remark" id="survey_remark" class="form-control" readonly="">
                </div>
                </div>
                </form>
                <a href="" class="btn btn-success" style="margin-bottom:10px;" download="name.csv">DOWNLOAD CSV</a>
              <div class="table-responsive">
                  <form action='<?php echo base_url(); ?>admin/user/approved_expense_by_coordinator' onsubmit="return validateForm()" method='post'>
                    <table class="table table-bordered" id="dataTable" width="115%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>S.N.</th>
                      <th>Expense Type</th>
                      <th>Expense Amount</th>
                      <th>Expense Details</th>
                      <th>Expense By Coordinator</th>
                      <th>Comments</th>
                      <th>Paid Status</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>S.N.</th>
                      <th>Expense Type</th>
                      <th>Expense Amount</th>
                      <th>Expense Details</th>
                      <th>Expense By Coordinator</th>
                      <th>Comments</th>
                      <th>Paid Status</th>
                    </tr>
                  </tfoot>
                  <tbody id="dataTable1">
                       <?php 
                        if(isset($exp_resp)){
                            $sn = 1;
                            foreach ($exp_resp as $key => $value) {
                                echo "<tr>";
                                echo "<td>$sn<input type='hidden' value='$value->eti_survey_expense_id' name='eti_survey_expense_id[]' readonly/></td>";
                                echo "<td><input type='text' value='$value->expense_type' class='form-control' name='expense_type[]' readonly/></td>";
                                echo "<td><input type='text' value='$value->expense' class='form-control' name='expense[]' readonly/></td>";
                                echo "<td><input type='text' value='$value->expense_details' class='form-control' name='expense_details[]' readonly/></td>";
                                echo "<td><input type='number' value='$value->expense_by_coordinator' class='form-control' name='expense_by_coordinator[]' required/></td>";
                                echo "<td><input type='text' value='$value->coordinator_comment' class='form-control' name='coordinator_comment[]' required/></td>";
                                echo "<td><input type='text' value='$value->paid_amount_status_by_accountant' class='form-control' name='paid_amount_status_by_accountant[]' readonly/></td>";
                                echo "</tr>";
                                $sn = $sn+1;
                            }
                        }else{
                            echo 'No Record Found!';
                        }
                        ?>
                  </tbody>
                </table>
                      <div class="row">
                      <div class="col-md-4">
                          <select name='expense_status_by_coordinator' class='form-control' required><option value=''> Select Expense Status </option><option value='Pending'>Pending</option><option value='Approved'>Approved</option></select>
                      </div>
                      <div class="col-md-4">
                            <select name='project_work_order_no' class='form-control' required>
                                <option value=''> Select WOC  </option>
                                <?php
                                if(isset($project_resp)){
                                    foreach ($project_resp as $key => $value){
                                        echo "<option";
                                        echo " value='$value->project_work_order_no'";
                                        if($value->project_work_order_no == $site_resp[0]->project_work_order_no){ echo " selected"; }
                                        echo ">$value->project_work_order_no</option>";
                                    }
                                }
                                ?>
                            </select>
                          <input type="hidden" value="<?php echo $site_resp[0]->site_survey_id; ?>" name="site_survey_id" id="site_survey_id" class="form-control" readonly="" required="">
                      </div>
                          <div class="col-md-4" style="text-align:right;">
                          <input type="submit" name="submit" value="Approved & Submit Expense Details" class="btn btn-info" />
                      </div>
                          <div class="col-md-12">&nbsp;</div>
                      </div> 
                  </form>
              </div>
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
$("a[download]").click(function(){
    $("#dataTable1").toCSV(this);    
});
jQuery.fn.toCSV = function(link) {
  var $link = $(link);
  var data = $(this).first(); //Only one table
  var csvData = [];
  var tmpArr = [];
  var tmpStr = '';
  data.find("tr").each(function() {
      if($(this).find("th").length) {
          $(this).find("th").each(function() {
            tmpStr = $(this).text().replace(/"/g, '""');
            tmpArr.push('"' + tmpStr + '"');
          });
          csvData.push(tmpArr);
      } else {
          tmpArr = [];
             $(this).find("td").each(function() {
                  if($(this).text().match(/^-{0,1}\d*\.{0,1}\d+$/)) {
                      tmpArr.push(parseFloat($(this).text()));
                  } else {
                      tmpStr = $(this).text().replace(/"/g, '""');
                      tmpArr.push('"' + tmpStr + '"');
                  }
             });
          csvData.push(tmpArr.join(','));
      }
  });
  var output = csvData.join('\n');
  var uri = 'data:application/csv;charset=UTF-8,' + encodeURIComponent(output);
  $link.attr("href", uri);
}
</script>
</body>
</html>
