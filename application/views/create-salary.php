<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>ETI Office Management - Create Salary</title>

  <!-- Custom fonts for this template -->
  <link href="<?php echo base_url(); ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="<?php echo base_url(); ?>css/sb-admin-2.min.css" rel="stylesheet">
  <!-- Custom css -->
  <link href="<?php echo base_url(); ?>css/common.css" rel="stylesheet">
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
              <h6 class="m-0 font-weight-bold text-primary">Create Employee Salary</h6>
            </div>
            <div class="card-body">
                <form action='<?php echo base_url(); ?>admin/user/salaryStep1' method='post'>
                <div class="row date_body">
                    <div class="col-md-4 start_date form-group">
                                <select name="emp_id" id="emp_id" class="form-control" required="">
                                    <option value=""> Select Employee</option>
                                <?php 
                                    if(isset($emp_list)){
                                        foreach ($emp_list as $key => $value) {
                                            echo "<option value='$value->emp_id'>$value->emp_name  ($value->emp_username)</option>";
                                        }
                                    }
                                ?>
                                </select>
                            </div>
                            <div class="col-md-4 start_date form-group">
                                <input type="date" class="form-control" name="month" required=""/>
                                <!--<input type="hidden" value="salaryStep1" class="form-control" name="action" required=""/>-->
                            </div>
                            <div class="col-md-4 start_date form-group" style="text-align:right">
                                <input type="submit" id="submit" value="CREATE SALARY" name="submit"class="btn btn-success" >
                            </div>
                </div>
                </form>
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
    <script>
    $(document).ready(function() {
      function validateForm() {
          var coordinator_id = $("#coordinator_id option:selected").val();
          var aurl ="<?php echo base_url(); ?>admin/User/teamLead";
          var action_name = "view";
          var dd;
          if(coordinator_id == "" || coordinator_id == null){
              alert("Please select team leader");
              return flase;
          }
//          else{
//              var dataString = 'action_name='+ action_name + '&coordinator_id=' + coordinator_id; 
//                  $.ajax({
//                          type: "POST",
//                          url: aurl, 
//                          data: dataString,
//                          dataType: "text",  
//                 //         cache:false,
//                          success: 
//                               function(data){
//                               var obj = jQuery.parseJSON(data);
//                               var bo1 = obj[0].emp_id;
//                               var con1 = 0;
//                               var sn = 1;
//                               var str = "";
//                               str += "<table class='table table-bordered' id='dataTable' width='100%' cellspacing='0'><thead><tr><th>S.N.</th><th>Emp Id</th><th>Name</th><th>Mobile</th><th>Family Cont.</th><th>DOJ</th><th>Action</th></tr></thead><tfoot><tr><th>S.N.</th><th>Emp Id</th><th>Name</th><th>Mobile</th><th>Family Cont.</th><th>DOJ</th><th>Action</th></tr></tfoot><tbody>";
//                                   $.each( obj, function( key, value ) {
//                                      str += "<tr>";
//                                      str += "<td>"+sn+"</td>";
//                                      str += "<td>"+obj[con1].emp_username+"</td>"
//                                      str += "<td>"+obj[con1].emp_name+"</td>";
//                                      str += "<td>"+obj[con1].emp_mobile+"</td>";
//                                      str += "<td>"+obj[con1].emp_family_contact+"</td>";
//                                      str += "<td>"+obj[con1].emp_joining_date+"</td>";
//                                      str += "<td><a href='<?php echo base_url(); ?>admin/user/employee_details/"+obj[con1].emp_id+"' target='_blank'>View Details</a></td>";
//                                      str += "</tr>";
//                                      con1++;
//                                      sn = sn+1;
//                                    });
//                                str += "</tbody></table>";
//                                    $("#dataTable1").html(str);
//                                    $('#dataTable').DataTable();
//                                   if(data != "No any relationship found!"){
//                                     $('#responseData').html("<table class='table' ui-jq='footable' ui-options=''><thead><tr><th>Rel. Id</th><th>Name In English</th><th>Name In Hindi</th><th>Pooja Service</th><th>Admin</th> <th>Created At</th></tr></thead><tbody>"+data+"</tbody></table>");
//                                  }else{
//                                      $('#responseData').html("<h4>No Relationship Found!</h4>");
//                                  }
//    //                               alert(data);  //as a debugging message.
//                            }
//                        });
//            }
        }
    });
  </script>
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
  <?php include 'headerjs.php'; ?>

</body>

</html>
