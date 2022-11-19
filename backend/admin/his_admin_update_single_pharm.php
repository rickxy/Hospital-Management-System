
<?php
	session_start();
	include('assets/inc/config.php');
		if(isset($_POST['update_pharmaceutical']))
		{
			$phar_name = $_POST['phar_name'];
			$phar_desc = $_POST['phar_desc'];
            $phar_qty = $_POST['phar_qty'];
            $phar_cat = $_POST['phar_cat'];
            $phar_bcode = $_GET['phar_bcode'];
            $phar_vendor = $_POST['phar_vendor'];
                
            //sql to insert captured values
			$query="UPDATE  his_pharmaceuticals SET phar_name = ?, phar_desc = ?, phar_qty = ?, phar_cat = ?, phar_vendor = ? WHERE phar_bcode = ?";
			$stmt = $mysqli->prepare($query);
			$rc=$stmt->bind_param('ssssss', $phar_name, $phar_desc, $phar_qty, $phar_cat, $phar_vendor, $phar_bcode);
			$stmt->execute();
			/*
			*Use Sweet Alerts Instead Of This Fucked Up Javascript Alerts
			*echo"<script>alert('Successfully Created Account Proceed To Log In ');</script>";
			*/ 
			//declare a varible which will be passed to alert function
			if($stmt)
			{
				$success = "Pharmaceutical  Updated";
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
            <?php
                $phar_bcode = $_GET['phar_bcode'];
                $ret="SELECT  * FROM his_pharmaceuticals WHERE phar_bcode=?";
                $stmt= $mysqli->prepare($ret) ;
                $stmt->bind_param('s',$phar_bcode);
                $stmt->execute() ;//ok
                $res=$stmt->get_result();
                //$cnt=1;
                while($row=$res->fetch_object())
                {
            ?>
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
                                                <li class="breadcrumb-item"><a href="javascript: void(0);">Pharmaceuticals</a></li>
                                                <li class="breadcrumb-item active">Manage Pharmaceutical</li>
                                            </ol>
                                        </div>
                                        <h4 class="page-title">Update #<?php echo $row->phar_bcode;?> - <?php echo $row->phar_name;?></h4>
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
                                                    <div class="form-group col-md-6">
                                                        <label for="inputEmail4" class="col-form-label">Pharmaceutical Name</label>
                                                        <input type="text" required="required" value="<?php echo $row->phar_name;?>" name="phar_name" class="form-control" id="inputEmail4" >
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="inputPassword4" class="col-form-label">Pharmaceutical Quantity(Cartons)</label>
                                                        <input required="required" type="text" value="<?php echo $row->phar_qty;?>" name="phar_qty" class="form-control"  id="inputPassword4">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputAddress" class="col-form-label">Pharmaceutical Description</label>
                                                    <textarea required="required"  type="text" class="form-control" name="phar_desc" id="editor"><?php echo $row->phar_desc;?></textarea>
                                                </div>
                                                <div class="form-row">
                                                <div class="form-group col-md-6">
                                                        <label for="inputPassword4" class="col-form-label">Pharmaceutical Vendor</label>
                                                        <input required="required" type="text" value="<?php echo $row->phar_vendor;?>" name="phar_vendor" class="form-control"  id="inputPassword4">
                                                </div>
                                                

                                                <div class="form-group col-md-6">
                                                        <label for="inputState" class="col-form-label">Pharmaceutical Category</label>
                                                        <select id="inputState" required="required" name="phar_cat" class="form-control">
                                                        <!--Fetch All Pharmaceutical Categories-->
                                                        <?php
                                                    
                                                            $ret="SELECT * FROM  his_pharmaceuticals_categories ORDER BY RAND() "; 
                                                            $stmt= $mysqli->prepare($ret) ;
                                                            $stmt->execute() ;//ok
                                                            $res=$stmt->get_result();
                                                            $cnt=1;
                                                            while($row=$res->fetch_object())
                                                            {
                                                        ?>
                                                            <option><?php echo $row->pharm_cat_name;?></option>
                                                        <?php }?>    
                                                        </select>
                                                    </div>
                                                    
                                                </div>
                                            <button type="submit" name="update_pharmaceutical" class="ladda-button btn btn-warning" data-style="expand-right">Update Pharmaceutical</button>

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
            <?php }?>
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