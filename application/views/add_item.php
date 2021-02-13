<?php include 'files/session.php'; ?>
<!DOCTYPE html>
<head>
<title>PoojaPath | Add Pooja </title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="" />
<?php include_once 'files/meta.php'; ?>
</head>
<body>
<section id="container">
<!--header start-->
<?php include'files/header.php';?>
<!--header end-->
<!--sidebar start-->
<?php include 'files/left_sidebar.php';?>
<!--sidebar end-->
<!--main content start-->
<section id="main-content">
	<section class="wrapper">
	<div class="form-w3layouts">
        <!-- page start-->
        <!-- page start-->
        <div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Insert New Items
                            <div class="col-lg-12">
                                       <?php 
                                            echo validation_errors(); 
                                            if(isset($message)){
                                                echo "<h2 class='success'>$message</h2><hr/>";
                                            }
                                            if(isset($error)){
                                                echo "<h2 class='error'>$error</h2><hr/>";
                                            }
                                       ?>
                                </div>
                        </header>
                        <div class="panel-body">
                            <div class="">
                                <form role="form" action="<?php echo base_url();?>index.php/admin/poojacontroller/insertItem" method="post" enctype="multipart/form-data">
                               <div class="col-lg-3 form-group">
                                    <label for="exampleInputEmail1">Enter Item Name (English)</label>
                                    <input type="text" class="form-control" name="item_name_en" id="item_name_en" placeholder="Item Name (English)" required="">
                                </div>
                                <div class="col-lg-3 form-group">
                                    <label for="exampleInputEmail1">Enter Item Name (Hindi)</label>
                                    <input type="text" class="form-control" name="item_name_hi" id="item_name_hi" placeholder="Item Name (Hindi)" required="">
                                </div>
                                <div class="col-lg-6 form-group">
                                    <label for="exampleInputService1">Enter Description</label>
                                    <input type="text" class="form-control" name="item_description" id="item_description" placeholder="Item Description" required="">
                                </div>
                                <div class="col-lg-1 form-group">
                                    <label for="exampleInputService1">Price</label>
                                    <input type="number" class="form-control" name="item_price" id="item_price" placeholder="Item Price" required="">
                                </div>
                                <div class="col-lg-1 form-group">
                                    <label for="exampleInputService1">Quantity</label>
                                    <input type="number" class="form-control" name="item_qty" id="item_qty" placeholder="Item Price" required="">
                                </div>
                                <div class="col-lg-2 form-group">
                                    <label for="exampleInputDescription1">Quantity Type</label>
                                    <select class="form-control" name="item_qty_type" id="item_qty_type" required="">
                                        <option value=''> Select Quantity Type </option>
                                        <option value="Packet">Packet</option>
                                        <option value="Liter">Liter</option>
                                        <option value="Gram">Gram</option>
                                        <option value="KG">KG</option>
                                        <option value="Dozen">Dozen</option>
                                    </select>
                                </div>
                                <div class="col-lg-4 form-group">
                                    <label for="exampleInputFile">Upload Item Image</label>
                                    <input type="file" name="item_image" id="item_image" required="">
                                    <div id="setImage"></div> 
                                </div>
                                <div class="col-lg-4 form-group"> </div>
                                <div class="col-lg-2 form-group">
                                    <button type="submit" class="btn btn-info" id="submit">INSERT NEW ITEM</button>
                                </div>
                                <div class="col-lg-2 form-group">
                                    <input type="reset" name="reset" class="btn btn-danger" value="CLEAR FIELDS" >
                                </div> 
                            </form>
                            </div>

                        </div>
                        <div class="panel panel-default">
    <div class="panel-heading">
     All Item List
    </div>
    <div>
      <table class="table" ui-jq="footable" ui-options='{
        "paging": {
          "enabled": true
        },
        "filtering": {
          "enabled": true
        },
        "sorting": {
          "enabled": true
        }}'>
        <thead>
          <tr>
            <th data-breakpoints="xs">SN</th>
            <th>Name (English)</th>
            <th>Name (Hindi)</th>
            <th>Price</th>
            <th>Qty</th>
            <th>Qty Type</th>
            <th>Image</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        
        <tbody>
            <?php 
        if(isset($resp)){
            $sn = 1;
            foreach ($resp as $key => $value) {
                echo "<tr data-expanded='true'>";
                echo "<td>$sn</td>";
                echo "<td>$value->item_name_en</td>";
                echo "<td>$value->item_name_hi</td>";
                echo "<td>$value->item_price</td>";
                echo "<td>$value->item_qty</td>";
                echo "<td>$value->item_qty_type</td>";
                $item_image = str_replace(' ', '_', $value->item_image);
                echo "<td><img src='".base_url()."images/items/$item_image' width='60'/></td>";
                echo "<td>Active</td>";
                echo "<td><a class='badge badge-primary' href=''>View Details</a></td>";
                echo "</tr>";
                $sn = $sn+1;
            }
        }
        ?>
        </tbody>
      </table>
    </div>
  </div>
                    </section>

            </div>
            
        </div>
      


        <!-- page end-->
        </div>
</section>
 <!-- footer -->
		  <?php include_once 'files/footer.php'; ?>
  <!-- / footer -->
</section>
<!--main content end-->
</section>
<script src="<?php echo base_url();?>js/bootstrap.js"></script>
<script src="<?php echo base_url();?>js/jquery.dcjqaccordion.2.7.js"></script>
<script src="<?php echo base_url();?>js/scripts.js"></script>
<script src="<?php echo base_url();?>js/jquery.slimscroll.js"></script>
<script src="<?php echo base_url();?>js/jquery.nicescroll.js"></script>
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="<?php echo base_url();?>js/flot-chart/excanvas.min.js"></script><![endif]-->
<script src="<?php echo base_url();?>js/jquery.scrollTo.js"></script>
<!-- morris JavaScript -->	
<script>
	$(document).ready(function() {
		//BOX BUTTON SHOW AND CLOSE
	   jQuery('.small-graph-box').hover(function() {
		  jQuery(this).find('.box-button').fadeIn('fast');
	   }, function() {
		  jQuery(this).find('.box-button').fadeOut('fast');
	   });
	   jQuery('.small-graph-box .box-close').click(function() {
		  jQuery(this).closest('.small-graph-box').fadeOut(200);
		  return false;
	   });
	   
	    //CHARTS
	    function gd(year, day, month) {
			return new Date(year, month - 1, day).getTime();
		}
		
		graphArea2 = Morris.Area({
			element: 'hero-area',
			padding: 10,
        behaveLikeLine: true,
        gridEnabled: false,
        gridLineColor: '#dddddd',
        axes: true,
        resize: true,
        smooth:true,
        pointSize: 0,
        lineWidth: 0,
        fillOpacity:0.85,
			data: [
				{period: '2015 Q1', iphone: 2668, ipad: null, itouch: 2649},
				{period: '2015 Q2', iphone: 15780, ipad: 13799, itouch: 12051},
				{period: '2015 Q3', iphone: 12920, ipad: 10975, itouch: 9910},
				{period: '2015 Q4', iphone: 8770, ipad: 6600, itouch: 6695},
				{period: '2016 Q1', iphone: 10820, ipad: 10924, itouch: 12300},
				{period: '2016 Q2', iphone: 9680, ipad: 9010, itouch: 7891},
				{period: '2016 Q3', iphone: 4830, ipad: 3805, itouch: 1598},
				{period: '2016 Q4', iphone: 15083, ipad: 8977, itouch: 5185},
				{period: '2017 Q1', iphone: 10697, ipad: 4470, itouch: 2038},
			
			],
			lineColors:['#eb6f6f','#926383','#eb6f6f'],
			xkey: 'period',
            redraw: true,
            ykeys: ['iphone', 'ipad', 'itouch'],
            labels: ['All Visitors', 'Returning Visitors', 'Unique Visitors'],
			pointSize: 2,
			hideHover: 'auto',
			resize: true
		});
		
	   
	});
	</script>
<!-- calendar -->
	<script type="text/javascript" src="<?php echo base_url();?>js/monthly.js"></script>
	<script type="text/javascript">
		$(window).load( function() {

			$('#mycalendar').monthly({
				mode: 'event',
				
			});

			$('#mycalendar2').monthly({
				mode: 'picker',
				target: '#mytarget',
				setWidth: '250px',
				startHidden: true,
				showTrigger: '#mytarget',
				stylePast: true,
				disablePast: true
			});

		switch(window.location.protocol) {
		case 'http:':
		case 'https:':
		// running on a server, should be good.
		break;
		case 'file:':
		alert('Just a heads-up, events will not work when run locally.');
		}

		});
	</script>
	<!-- //calendar -->
</body>
</html>
