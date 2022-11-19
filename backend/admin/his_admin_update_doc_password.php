<?php
	session_start();
	include('assets/inc/config.php');
		if(isset($_POST['update_doc']))
		{
            $email=$_GET['email'];
            $pwd=sha1(md5($_GET['pwd']));
            $status = $_POST['status'];
                        
            //sql to insert captured values
            $query="UPDATE his_docs SET doc_pwd =? WHERE doc_email = ?";
            $query1 = "UPDATE his_pwdresets SET status =? WHERE email = ?";
            $stmt = $mysqli->prepare($query);
            $stmt1 = $mysqli->prepare($query1);
            $rc=$stmt->bind_param('ss', $pwd, $email);
            $rs=$stmt1->bind_param('ss', $status, $email);
            $stmt->execute();
            $stmt1->execute();
			
			if($stmt && $stmt1)
			{
				$success = "Password Updated";
			}
            else
            {
				$err = "Please Try Again Or Try Later";
            }
            			
		}
?>
<!--End Server Side-->
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
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Password Resets</a></li>
                                            <li class="breadcrumb-item active">Manage </li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Update Employee Password Details</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 
                        <!-- Form row -->
                        <?php
                            $email=$_GET['email'];
                            $ret="SELECT  * FROM his_pwdresets WHERE email=?";
                            $stmt= $mysqli->prepare($ret) ;
                            $stmt->bind_param('i',$email);
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
                                        <form method="post" enctype="multipart/form-data">
                                            
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="inputCity" class="col-form-label">Email</label>
                                                    <input required="required"  type="email" value="<?php echo $row->email;?>" class="form-control" name="doc_email" id="inputCity">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="inputCity" class="col-form-label">Password</label>
                                                    <input required="required"  type="text" value="<?php echo $row->pwd;?>"  name="doc_pwd" class="form-control" id="inputCity">
                                                </div>
                                                <div class="form-group col-md-6" style="display:none">
                                                    <label for="inputCity" class="col-form-label">Reset Status</label>
                                                    <input required="required"  type="text" value="Reset"  name="status" class="form-control" id="inputCity">
                                                </div>  
                                                
                                            </div>                                            

                                            <button type="submit" name="update_doc" class="ladda-button btn btn-success" data-style="expand-right">Update Password</button>

                                        </form>
                                        <!--End Patient Form-->
                                    </div> <!-- end card-body -->
                                </div> <!-- end card-->
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->
                        <?php }?>

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