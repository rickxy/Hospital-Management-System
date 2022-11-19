<!--Server side code to handle  Patient Registration-->
<?php
	session_start();
	include('assets/inc/config.php');
		if(isset($_POST['update_vendor']))
		{
			$v_name=$_POST['v_name'];
			$v_adr=$_POST['v_adr'];
			$v_number=$_GET['v_number'];
            $v_email=$_POST['v_email'];
            $v_phone = $_POST['v_phone'];
            $v_desc = $_POST['v_desc'];
            //$doc_pwd=sha1(md5($_POST['doc_pwd']));
            
            //sql to insert captured values
			$query="UPDATE  his_vendor SET v_name=?, v_adr=?,  v_email = ?, v_phone=?, v_desc=? WHERE v_number=?";
			$stmt = $mysqli->prepare($query);
			$rc=$stmt->bind_param('ssssss', $v_name, $v_adr,  $v_email, $v_phone, $v_desc, $v_number);
			$stmt->execute();
			/*
			*Use Sweet Alerts Instead Of This Fucked Up Javascript Alerts
			*echo"<script>alert('Successfully Created Account Proceed To Log In ');</script>";
			*/ 
			//declare a varible which will be passed to alert function
			if($stmt)
			{
				$success = "Vendor Details Updated";
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
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Vendor</a></li>
                                            <li class="breadcrumb-item active">Update Vendor</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Update Vendor Details</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 
                        <!-- Form row -->
                        <?php
                            $v_number=$_GET['v_number'];
                            $ret="SELECT  * FROM his_vendor WHERE v_number = ?";
                            $stmt= $mysqli->prepare($ret) ;
                            $stmt->bind_param('i',$v_number);
                            $stmt->execute() ;//ok
                            $res=$stmt->get_result();
                            //$cnt=1;
                            while($row=$res->fetch_object())
                            {
                        ?>
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title">Fill all fields</h4>
                                        <!--Add Patient Form-->
                                        <form method="post">
                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label for="inputEmail4" class="col-form-label">Vendor Name</label>
                                                    <input type="text" required="required" value="<?php echo $row->v_name;?>" name="v_name" class="form-control" id="inputEmail4" >
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="inputPassword4" class="col-form-label">Vendor Phone Number</label>
                                                    <input required="required" type="text" value="<?php echo $row->v_phone;?>" name="v_phone" class="form-control"  id="inputPassword4">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="inputPassword4" class="col-form-label">Vendor Address</label>
                                                    <input required="required" value="<?php echo $row->v_adr;?>" type="text" name="v_adr" class="form-control"  id="inputPassword4">
                                                </div>
                                            </div>

                                            
                                            <div class="form-group">
                                                <label for="inputAddress" class="col-form-label">Vendor Email</label>
                                                <input required="required" value="<?php echo $row->v_email;?>" type="email" class="form-control" name="v_email" id="inputAddress">
                                            </div>

                                            <div class="form-group">
                                                <label for="inputAddress" class="col-form-label">Vendor Details</label>
                                                <textarea  type="text" class="form-control" name="v_desc" id="editor"><?php echo $row->v_desc;?></textarea>
                                            </div>

                                            <button type="submit" name="update_vendor" class="ladda-button btn btn-success" data-style="expand-right">Update Vendor</button>

                                        </form>
                                        <!--End Patient Form-->
                                    </div> <!-- end card-body -->
                                </div> <!-- end card-->
                            </div> <!-- end col -->
                        </div>
                            <?php }?>
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

       
        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>
        <script src="//cdn.ckeditor.com/4.6.2/basic/ckeditor.js"></script>
        <script type="text/javascript">
        CKEDITOR.replace('editor')
        </script>

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