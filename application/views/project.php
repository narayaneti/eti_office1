<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>ETI Office Management - Project</title>

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
                <h6 class="m-0 font-weight-bold text-primary">
                    <?php 
                            if(isset($project_details)){ echo "Edit Project";} 
                            else{ echo "Add Project";}
                    ?>
                </h6>
            </div>
            <div class="card-body">
                <form action='<?php echo base_url(); ?>admin/user/project' method="post">
                    <div class="row date_body">
                        <div class="col-md-4 start_date form-group">
                            <select name="client_id" placeholder="Select Client" id="project_name" class="form-control" required="">
                                <option value=""> Select Client</option>
                                <?php 
                                if(isset($client_list)){
                                    $sn = 1;
                                    foreach ($client_list as $key => $value) {
                                        echo "<option value='$value->client_id'";
                                        if(isset($project_details)) {
                                            if($project_details[0]->client_id == $value->client_id){
                                                echo " selected"; 
                                            }
                                        }
                                        echo ">$value->client_name</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4 start_date form-group">
                            <input type="text" value="<?php if(isset($project_details)) { echo $project_details[0]->project_name; } ?>" name="project_name" placeholder="Enter Project Name.." id="project_name" class="form-control" required="">
                            
                            <?php 
                            if(isset($project_details)) 
                            {   echo "<input type='hidden' value='edit' name='action_name' placeholder='Enter Project Name..' id='project_name' class='form-control' required=''>";
                                echo "<input type='hidden' value='".$project_details[0]->project_id."' name='project_id' placeholder='Enter Project Name..' id='project_name' class='form-control' required=''>";
                            } 
                            else{ echo "<input type='hidden' value='add' name='action_name' placeholder='Enter Project Name..' id='project_name' class='form-control' required=''>";}
                            ?>
                        </div>
                        <div class="col-md-4 start_date form-group">
                            <input type="text" value="<?php if(isset($project_details)) { echo $project_details[0]->project_work_order_no; } ?>" name="project_work_order_no" placeholder="Enter Work Order Number.." id="project_work_order_no" class="form-control">
                        </div>
                        <div class="col-md-4 start_date form-group">
                            <input type="date" value="<?php if(isset($project_details)) { echo $project_details[0]->project_work_order_date; } ?>" name="project_work_order_date" placeholder="Enter Project Start Date.." id="project_name" class="form-control">
                        </div>
                        <div class="col-md-4 start_date form-group">
                            <input type="number" value="<?php if(isset($project_details)) { echo $project_details[0]->project_approx_cost; } ?>" name="project_approx_cost" placeholder="Enter Approx Project Cost.." id="project_name" class="form-control" required="">
                        </div>
                        <div class="col-md-4 start_date form-group">
                            <input type="number" value="<?php if(isset($project_details)) { echo $project_details[0]->project_approx_working_days; } ?>" name="project_approx_working_days" placeholder="Enter Total Project Working Days.." id="project_state" class="form-control" required="">
                        </div>
                        <div class="col-md-12 start_date form-group" style="text-align:right">
                            <?php 
                            if(isset($project_details)) 
                            { echo "<input type='submit' value='EDIT PROJECT DETAILS' name='submit' class='btn btn-success'/>"; } 
                            else{ echo "<input type='submit' value='ADD PROJECT' name='submit' class='btn btn-success'/>";}
                            ?>
                        </div>
                    </div>
                </form>
            </div>
           <div class="card-header py-3" style="border-top:1px solid #e3e6f0;">
              <h6 class="m-0 font-weight-bold text-primary"> Project List</h6>
            </div>
            <div class="card-body">
                <div class="row date_body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>S.N.</th>
                      <th>Project Name</th>
                      <th>Client</th>
                      <th>Work Order No</th>
                      <th>Work Order Date</th>
                      <th>Approx Cost</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>S.N.</th>
                      <th>Project Name</th>
                      <th>Client</th>
                      <th>Work Order No</th>
                      <th>Work Order Date</th>
                      <th>Approx Cost</th>
                      <th>Action</th>
                    </tr>
                  </tfoot>
                  <tbody id="dataTable1">
                       <?php 
                        if(isset($resp)){
                            $sn = 1;
                            foreach ($resp as $key => $value) {
                                echo "<tr>";
                                echo "<td>$sn</td>";
                                echo "<td>$value->project_name</td>";
                                echo "<td>$value->client_name</td>";
                                echo "<td>$value->project_work_order_no</td>";
                                echo "<td>$value->project_work_order_date</td>";
                                echo "<td>$value->project_approx_cost</td>";
                                echo "<td>";
                                echo "<form action='".base_url()."admin/user/project' method='post' style='float:left;'> <input type='hidden' value='$value->project_id' name='project_id'> <input type='hidden' value='view' name='action_name'><button type='submit' class='btn btn-primary'><i class='far fa-eye'></i></button></form>";
                                echo "<form action='".base_url()."admin/user/project' method='post' style='float:left;'> <input type='hidden' value='$value->project_id' name='project_id'> <input type='hidden' value='view' name='action_name'><button type='submit' class='btn btn-success'><i class='fas fa-edit'></i></button></form>";
                                echo "<form action='".base_url()."admin/user/project' method='post' style='float:left;'> <input type='hidden' value='$value->project_id' name='project_id'> <input type='hidden' value='del' name='action_name'><button type='submit' class='btn btn-danger'><i class='far fa-trash-alt'></i></button></form>";
                                echo "</td>";
                                echo "</tr>";
                                $sn = $sn+1;
                            }
                        }else{
                            echo 'No Record Found!';
                        }
                        ?>
                  </tbody>
                </table>
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
  <?php include 'headerjs.php'; ?>
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
