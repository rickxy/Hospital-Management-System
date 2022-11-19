
<?php
	session_start();
	include('assets/inc/config.php');
        if(isset($_POST['add_equipments']))
        
        {
        
		    $eqp_code = $_POST['eqp_code'];
			$eqp_name = $_POST['eqp_name'];
            $eqp_vendor = $_POST['eqp_vendor'];
            $eqp_desc = $_POST['eqp_desc'];
            $eqp_dept = $_POST['eqp_dept'];
            $eqp_status = $_POST['eqp_status'];
            $eqp_qty = $_POST['eqp_qty'];
                
            //sql to insert captured values
			$query="INSERT INTO his_equipments (eqp_code, eqp_name, eqp_vendor, eqp_desc, eqp_dept, eqp_status, eqp_qty) VALUES (?,?,?,?,?,?,?)";
			$stmt = $mysqli->prepare($query);
			$rc=$stmt->bind_param('sssssss', $eqp_code, $eqp_name, $eqp_vendor, $eqp_desc, $eqp_dept, $eqp_status, $eqp_qty);
			$stmt->execute();
			/*
			*Use Sweet Alerts Instead Of This Fucked Up Javascript Alerts
			*echo"<script>alert('Successfully Created Account Proceed To Log In ');</script>";
			*/ 
			//declare a varible which will be passed to alert function
			if($stmt)
			{
				$success = "Laboratory Equipment Added";
			}
			else {
				$err = "Please Try Again Or Try Later";
			}
			
			
		}
?>
<!--End Server Side-->
<!--End Patient Registration-->
<!DOCTYPE html>
<html lang="en">
    
    <!--Head-->
    <?php include('assets/inc/head.php');?>
    <body>

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Topbar Start -->
            <?php include("assets/inc/nav.php");?>
            <!-- end Topbar -->

            <!-- ========== Left Sidebar Start ========== -->
            <?php include("assets/inc/sidebar.php");?>
            <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <div class="content-page">
                <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">
                        
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="his_admin_dashboard.php">Dashboard</a></li>
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Laboratory</a></li>
                                            <li class="breadcrumb-item active">Add Equipment</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Add Laboratory Equipment</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 
                        <!-- Form row -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title">Fill all fields</h4>
                                        <!--Add Patient Form-->
                                        <form method="post">
                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label for="inputEmail4" class="col-form-label">Equipment Name</label>
                                                    <input type="text" required="required" name="eqp_name" class="form-control" id="inputEmail4" >
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="inputPassword4" class="col-form-label">Equipment Vendor</label>
                                                    <input required="required" type="text" name="eqp_vendor" class="form-control"  id="inputPassword4">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="inputPassword4" class="col-form-label">Equipment Quantity </label>
                                                    <input required="required" type="text"  name="eqp_qty" class="form-control"  id="inputPassword4">
                                                </div>
                                                <div class="form-group col-md-4" style="display:none">
                                                    <label for="inputPassword4" class="col-form-label">Equipment Department</label>
                                                    <input required="required" type="text" value="Laboratory" name="eqp_dept" class="form-control"  id="inputPassword4">
                                                </div>
                                                <div class="form-group col-md-6" style="display:none">
                                                    <label for="inputPassword4" class="col-form-label">Equipment Status</label>
                                                    <input required="required" type="text" value="Functioning" name="eqp_status" class="form-control"  id="inputPassword4">
                                                </div>
                                                
                                            </div>

                                            <div class="form-group">
                                                    <label for="inputPassword4" class="col-form-label">Equipment Barcode(EAN-8)</label>
                                                    <?php 
                                                        $length = 10;    
                                                        $bcode =  substr(str_shuffle('0123456789'),1,$length);
                                                    ?>
                                                    <input required="required" readonly type="text" value="<?php echo $bcode;?>" name="eqp_code" class="form-control"  id="inputPassword4">
                                            </div>

                                            <div class="form-group" style="style:display-none">
                                                <label for="inputAddress" class="col-form-label">Pharmaceutical Category Description</label>
                                                <textarea required="required" type="text" class="form-control" name="eqp_desc" id="editor"></textarea>
                                            </div>

                                           <button type="submit" name="add_equipments" class="ladda-button btn btn-success" data-style="expand-right">Add Equipment</button>

                                        </form>
                                     
                                    </div> <!-- end card-body -->
                                </div> <!-- end card-->
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->

                    </div> <!-- container -->

                </div> <!-- content -->

                <!-- Footer Start -->
                <?php include('assets/inc/footer.php');?>
                <!-- end Footer -->

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->
        <!--Load CK EDITOR Javascript-->
        <script src="//cdn.ckeditor.com/4.6.2/basic/ckeditor.js"></script>
        <script type="text/javascript">
        CKEDITOR.replace('editor')
        </script>
       
        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- Vendor js -->
        <script src="assets/js/vendor.min.js"></script>

        <!-- App js-->
        <script src="assets/js/app.min.js"></script>

        <!-- Loading buttons js -->
        <script src="assets/libs/ladda/spin.js"></script>
        <script src="assets/libs/ladda/ladda.js"></script>

        <!-- Buttons init js-->
        <script src="assets/js/pages/loading-btn.init.js"></script>
        
    </body>

</html>