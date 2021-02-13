<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>ETI Office Management - Department</title>

  <!-- Custom fonts for this template -->
  <link href="<?php echo base_url(); ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="<?php echo base_url(); ?>css/sb-admin-2.min.css" rel="stylesheet">
  <!-- Custom css -->
  <link href="<?php echo base_url(); ?>css/common.css" rel="stylesheet">
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
#map{
    height: 500px;
}
      /* Optio
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
		
       <div class="row ">
           <div class="col-12">
                   <form action="<?= current_url() ?>" method="post">
               <div class="row mb-2">
                       <div class="col-6">
                           <input type="date" name="date" value="<?= set_value('date') ?>" class="form-control">
                       </div>
                       <div class="col-6 float-right text-right">
                           <a href="<?= base_url('admin/User/employeeLocationActivity_user') ?>" class="btn btn-danger">Back to employee list</a>
                           <button type="submit" class="btn btn-info">Search</button>
                        </div>
                    
               </div>
               </form>
            </div>
           <div class="col-12">
               <?php
               if(isset($today_active_user) && !empty($today_active_user)){
                ?>
               <div id="map" style="border: 2px solid #3872ac;"></div>	
               <?php
               }else{
                   ?>
                   <div class="col-12 text-center">
                       Data Not available
                   </div>
                   <?php
               }
               ?>	
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
  <?php include 'headerjs.php'; ?>
<script src="https://maps.googleapis.com/maps/api/js"></script>
  <!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCTaQIJ3bzE9tr-1J2zmNaSFwZZfLc_5Tg&callback=initMap&libraries=&v=weekly" defer></script>-->
  <script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCTaQIJ3bzE9tr-1J2zmNaSFwZZfLc_5Tg" async="" defer="defer" type="text/javascript"></script>
<script>
    /*// Initialize and add the map
function initMap() {
  // The location of Uluru
  var maplocation = [
//var maplocation=jQuery.parseJSON(MapPoints);
<?php
    if(isset($today_active_user) && !empty($today_active_user)){
        foreach($today_active_user as $val){
            ?>
            {lat:<?= $val->latitude ?>,lng:<?= $val->longitude ?>},
            <?php
        }
    }
?>
];
var i=1;
$.each(maplocation,function(key,value) {
  if(i==1){
  const uluru = { lat: value.lat, lng: value.lng };
  // The map, centered at Uluru
  const map = new google.maps.Map(document.getElementById("map"), {
    zoom: 4,
    center: uluru,
  });
  // The marker, positioned at Uluru
  const marker = new google.maps.Marker({
    position: uluru,
    map: map,
  });
  i=2;
  }else{
      const latLng = new google.maps.LatLng(value.lat, value.lng);
    new google.maps.Marker({
      position: latLng,
      map: map,
    });
  }
})
}*/
var maplocation = [
//var maplocation=jQuery.parseJSON(MapPoints);
<?php
    if(isset($today_active_user) && !empty($today_active_user)){
        foreach($today_active_user as $val){
            ?>
            {lat:"<?= $val->latitude ?>",lng:"<?= $val->longitude ?>",title:"<?= $val->emp_name.','.$val->emp_mobile.',<br>'.$val->current_location.',<br>'.$val->current_datetime ?>"},
            <?php
        }
    }
?>
];
var MY_MAPTYPE_ID = 'custom_style';

function initialize() {

    if (jQuery('#map').length > 0) {

        var locations = maplocation;
        window.map = new google.maps.Map(document.getElementById('map'), {
            //mapTypeId: google.maps.MapTypeId.ROADMAP,
            scrollwheel: false
        });

        var infowindow = new google.maps.InfoWindow();
        var flightPlanCoordinates = [];
        var bounds = new google.maps.LatLngBounds();

        for (i = 0; i < locations.length; i++) {
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i].lat, locations[i].lng),
                label: String(i),
                map: map
            });
            flightPlanCoordinates.push(marker.getPosition());
            bounds.extend(marker.position);

            google.maps.event.addListener(marker, 'click', (function (marker, i) {
                return function () {
					map.setCenter(marker.getPosition());
                    infowindow.setContent(locations[i]['title']);
                    infowindow.open(map, marker);
                }
            })(marker, i));
            map.setCenter(marker.getPosition());
            //infowindow.setContent("Last "+locations[i]['title']);
            //infowindow.open(map, marker);
            }
            
            
            map.fitBounds(bounds);

            var flightPath = new google.maps.Polyline({
                map: map,
                path: flightPlanCoordinates,
                strokeColor: "#000000",
                strokeOpacity: 2.0,
                strokeWeight: 4
            });

        }
    }
    google.maps.event.addDomListener(window, 'load', initialize);
    
    

var markers = [
<?php
$index = 1;
foreach($today_active_user as $x) {
?>
{"title":"Location <?=$index?>","lat":"<?= $val->latitude ?>","lng":"<?= $val->longitude ?>","description":""},
<?php
$index++;
}
?>

];
window.onload = function () {
var mapOptions = {
center: new google.maps.LatLng(markers[0].lat, markers[0].lng),
zoom: 10,
//mapTypeId: google.maps.MapTypeId.ROADMAP
};
var map = new google.maps.Map(document.getElementById("dvMap"), mapOptions);
var infoWindow = new google.maps.InfoWindow();
var lat_lng = new Array();
var latlngbounds = new google.maps.LatLngBounds();
for (i = 0; i < markers.length; i++) {
var data = markers[i]
var myLatlng = new google.maps.LatLng(data.lat, data.lng);
lat_lng.push(myLatlng);
var marker = new google.maps.Marker({
position: myLatlng,

map: map,
title: data.title
});
latlngbounds.extend(marker.position);
(function (marker, data) {
google.maps.event.addListener(marker, "click", function (e) {
infoWindow.setContent(data.description);
infoWindow.open(map, marker);
});
})(marker, data);
}
map.setCenter(latlngbounds.getCenter());
map.fitBounds(latlngbounds);

}
</script>
<?php /*<script type="text/javascript">
var MapPoints = [
//var maplocation=jQuery.parseJSON(MapPoints);
<?php
    if(isset($today_active_user) && !empty($today_active_user)){
        foreach($today_active_user as $val){
            ?>
            {lat:<?= $val->latitude ?>,lng:<?= $val->longitude ?>},
            <?php
        }
    }
?>
];

</script>*/ ?>
</body>

</html>
