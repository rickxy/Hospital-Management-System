<!--Server side code to handle  Patient Registration-->
<?php
	session_start();
	include('assets/inc/config.php');
		if(isset($_POST['update_patient_mdr']))
		{
			//$mdr_pat_name = $_POST['mdr_pat_name'];
			//$mdr_pat_number = $_POST['mdr_pat_number'];
            //$pres_pat_type = $_POST['pres_pat_type'];
            $mdr_pat_adr = $_POST['mdr_pat_adr'];
            $mdr_pat_age = $_POST['mdr_pat_age'];
            $mdr_number = $_GET['mdr_number'];
            $mdr_pat_prescr = $_POST['mdr_pat_prescr'];
            $mdr_pat_ailment = $_POST['mdr_pat_ailment'];
            //sql to insert captured values
			$query="UPDATE  his_medical_records SET  mdr_pat_adr = ?, mdr_pat_age = ?,  mdr_pat_prescr = ?, mdr_pat_ailment = ? WHERE mdr_number = ?";
			$stmt = $mysqli->prepare($query);
			$rc=$stmt->bind_param('sssss',  $mdr_pat_adr, $mdr_pat_age, $mdr_pat_prescr, $mdr_pat_ailment, $mdr_number);
			$stmt->execute();
			/*
			*Use Sweet Alerts Instead Of This Fucked Up Javascript Alerts
			*echo"<script>alert('Successfully Created Account Proceed To Log In ');</script>";
			*/ 
			//declare a varible which will be passed to alert function
			if($stmt)
			{
				$success = "Patient Medical Record Updated";
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
                $mdr_number = $_GET['mdr_number'];
                $ret="SELECT  * FROM his_medical_records WHERE mdr_number=?";
                $stmt= $mysqli->prepare($ret) ;
                $stmt->bind_param('s',$mdr_number);
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
                                                <li class="breadcrumb-item"><a href="javascript: void(0);">Medical Records</a></li>
                                                <li class="breadcrumb-item active">Manage Medical Record</li>
                                            </ol>
                                        </div>
                                        <h4 class="page-title">Update Medical Record</h4>
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
                                                        <label for="inputEmail4" class="col-form-label">Patient Name</label>
                                                        <input type="text" required="required" readonly name="mdr_pat_name" value="<?php echo $row->mdr_pat_name;?>" class="form-control" id="inputEmail4" placeholder="Patient's Name">
                                                    </div>

                                                    <div class="form-group col-md-4">
                                                        <label for="inputPassword4" class="col-form-label">Patient Age</label>
                                                        <input required="required" type="text"  name="mdr_pat_age" value="<?php echo $row->mdr_pat_age;?>" class="form-control"  id="inputPassword4" placeholder="Patient`s Last Name">
                                                    </div>

                                                    <div class="form-group col-md-4">
                                                        <label for="inputPassword4" class="col-form-label">Patient Address</label>
                                                        <input required="required" type="text"  name="mdr_pat_adr" value="<?php echo $row->mdr_pat_adr;?>" class="form-control"  id="inputPassword4" placeholder="Patient`s Last Name">
                                                    </div>

                                                </div>

                                                <div class="form-row">

                                                    <div class="form-group col-md-6">
                                                        <label for="inputEmail4" class="col-form-label">Patient Number</label>
                                                        <input type="text" required="required" readonly name="mdr_pat_number" value="<?php echo $row->mdr_pat_number;?>" class="form-control" id="inputEmail4" placeholder="DD/MM/YYYY">
                                                    </div>

                                                    <div class="form-group col-md-6">
                                                        <label for="inputPassword4" class="col-form-label">Patient Ailment</label>
                                                        <input required="required" type="text"  name="mdr_pat_ailment" value="<?php echo $row->mdr_pat_ailment;?>" class="form-control"  id="inputPassword4" placeholder="Patient`s Age">
                                                    </div>
                                                </div>
                                               
                                                <hr>
                                                <div class="form-row">
                                                    
                                            
                                                    <div class="form-group col-md-2" style="display:none">
                                                        <?php 
                                                            $length = 5;    
                                                            $pres_no =  substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1,$length);
                                                        ?>
                                                        <label for="inputZip" class="col-form-label">Medical Record Number</label>
                                                        <input type="text" name="mdr_number" value="<?php echo $pres_no;?>" class="form-control" id="inputZip">
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                        <label for="inputAddress" class="col-form-label">Patient's Prescription</label>
                                                        <textarea required="required"  type="text" class="form-control" name="mdr_pat_prescr" id="editor"><?php echo $row->mdr_pat_prescr;?> </textarea>
                                                </div>
                                                <?php }?>

                                                <button type="submit" name="update_patient_mdr" class="ladda-button btn btn-warning" data-style="expand-right">Update Patient Medical Record</button>

                                            </form>
                                            <!--End Patient Form-->
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