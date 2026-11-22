
<?php
    session_start();
    include('assets/inc/config.php');

    if (isset($_POST['update_profile'])) {
        $ad_fname = $_POST['ad_fname'];
        $ad_lname = $_POST['ad_lname'];
        $ad_id = $_SESSION['ad_id'];
        $ad_email = $_POST['ad_email'];

        $ad_dpic = $_FILES["ad_dpic"]["name"];

        move_uploaded_file(
            $_FILES["ad_dpic"]["tmp_name"],
            "assets/images/users/" . $_FILES["ad_dpic"]["name"]
        );

        // Update admin profile
        $query = "UPDATE his_admin SET ad_fname=?, ad_lname=?, ad_email=?, ad_dpic=? WHERE ad_id=?";
        $stmt = $mysqli->prepare($query);

        if ($stmt) {
            $stmt->bind_param(
                'ssssi',
                $ad_fname,
                $ad_lname,
                $ad_email,
                $ad_dpic,
                $ad_id
            );

            if ($stmt->execute()) {
                $success = "Profile Updated";
            } else {
                $err = "Please Try Again Or Try Later";
            }

            $stmt->close();
        } else {
            $err = "Please Try Again Or Try Later";
        }
    }

    // Change Password
    if (isset($_POST['update_pwd'])) {

        $ad_id = $_SESSION['ad_id'];

        $old_pwd = $_POST['old_pwd'] ?? '';
        $new_pwd = $_POST['ad_pwd'] ?? '';
        $confirm_pwd = $_POST['confirm_pwd'] ?? '';

        // Check all password fields
        if ($old_pwd === '' || $new_pwd === '' || $confirm_pwd === '') {

            $err = "All password fields are required.";

        }

        // Check new password and confirm password
        elseif ($new_pwd !== $confirm_pwd) {

            $err = "New password and confirm password do not match.";

        } else {

            // Fetch current admin password
            $query = "SELECT ad_pwd FROM his_admin WHERE ad_id = ?";
            $stmt = $mysqli->prepare($query);

            if ($stmt) {

                $stmt->bind_param('i', $ad_id);
                $stmt->execute();

                $result = $stmt->get_result();
                $admin = $result->fetch_assoc();

                $stmt->close();

                // Verify old password
                if (!$admin || !hash_equals($admin['ad_pwd'], sha1(md5($old_pwd)))) {

                    $err = "Old password is incorrect.";

                } else {

                    // Keep existing password hashing format for compatibility
                    $hashed_pwd = sha1(md5($new_pwd));

                    // Update new password
                    $query = "UPDATE his_admin SET ad_pwd = ? WHERE ad_id = ?";
                    $stmt = $mysqli->prepare($query);

                    if ($stmt) {

                        $stmt->bind_param('si', $hashed_pwd, $ad_id);

                        if ($stmt->execute()) {

                            $success = "Password Updated Successfully.";

                        } else {

                            $err = "Unable to update password. Please try again.";

                        }

                        $stmt->close();

                    } else {

                        $err = "Unable to update password. Please try again.";

                    }
                }

            } else {

                $err = "Unable to verify password. Please try again.";

            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<?php include('assets/inc/head.php'); ?>

<body>

    <!-- Begin page -->
    <div id="wrapper">

        <!-- Topbar Start -->
        <?php include('assets/inc/nav.php'); ?>
        <!-- end Topbar -->

        <!-- Left Sidebar Start -->
        <?php include('assets/inc/sidebar.php'); ?>
        <!-- Left Sidebar End -->

        <?php

            $aid = $_SESSION['ad_id'];

            $ret = "SELECT * FROM his_admin WHERE ad_id = ?";
            $stmt = $mysqli->prepare($ret);

            $stmt->bind_param('i', $aid);
            $stmt->execute();

            $res = $stmt->get_result();

            while ($row = $res->fetch_object()) {

        ?>

        <div class="content-page">
            <div class="content">

                <div class="container-fluid">

                    <!-- Page Title -->
                    <div class="row">
                        <div class="col-12">

                            <div class="page-title-box">

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item">
                                            <a href="javascript: void(0);">Dashboard</a>
                                        </li>

                                        <li class="breadcrumb-item active">
                                            Profile
                                        </li>
                                    </ol>
                                </div>

                                <h4 class="page-title">
                                    <?php echo $row->ad_fname; ?>
                                    <?php echo $row->ad_lname; ?>'s Profile
                                </h4>

                            </div>

                        </div>
                    </div>

                    <!-- Profile Content -->
                    <div class="row">

                        <div class="col-lg-4 col-xl-4">

                            <div class="card-box text-center">

                                <img
                                    src="assets/images/users/<?php echo $row->ad_dpic; ?>"
                                    class="rounded-circle avatar-lg img-thumbnail"
                                    alt="profile-image"
                                >

                                <h4 class="mb-0">
                                    <?php echo $row->ad_fname; ?>
                                    <?php echo $row->ad_lname; ?>
                                </h4>

                                <p class="text-muted">
                                    @System_Administrator_HMIS
                                </p>

                                <div class="text-left mt-3">

                                    <p class="text-muted mb-2 font-13">
                                        <strong>Full Name :</strong>
                                        <span class="ml-2">
                                            <?php echo $row->ad_fname; ?>
                                            <?php echo $row->ad_lname; ?>
                                        </span>
                                    </p>

                                    <p class="text-muted mb-2 font-13">
                                        <strong>Email :</strong>
                                        <span class="ml-2">
                                            <?php echo $row->ad_email; ?>
                                        </span>
                                    </p>

                                </div>

                            </div>

                        </div>

                        <div class="col-lg-8 col-xl-8">

                            <div class="card-box">

                                <ul class="nav nav-pills navtab-bg nav-justified">

                                    <li class="nav-item">
                                        <a
                                            href="#aboutme"
                                            data-toggle="tab"
                                            aria-expanded="false"
                                            class="nav-link active"
                                        >
                                            Update Profile
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a
                                            href="#settings"
                                            data-toggle="tab"
                                            aria-expanded="false"
                                            class="nav-link"
                                        >
                                            Change Password
                                        </a>
                                    </li>

                                </ul>

                                <div class="tab-content">

                                    <!-- Update Profile Tab -->
                                    <div class="tab-pane show active" id="aboutme">

                                        <form method="post" enctype="multipart/form-data">

                                            <h5 class="mb-4 text-uppercase">
                                                <i class="mdi mdi-account-circle mr-1"></i>
                                                Personal Info
                                            </h5>

                                            <div class="row">

                                                <div class="col-md-6">

                                                    <div class="form-group">

                                                        <label for="firstname">
                                                            First Name
                                                        </label>

                                                        <input
                                                            type="text"
                                                            name="ad_fname"
                                                            class="form-control"
                                                            id="firstname"
                                                            placeholder="<?php echo $row->ad_fname; ?>"
                                                        >

                                                    </div>

                                                </div>

                                                <div class="col-md-6">

                                                    <div class="form-group">

                                                        <label for="lastname">
                                                            Last Name
                                                        </label>

                                                        <input
                                                            type="text"
                                                            name="ad_lname"
                                                            class="form-control"
                                                            id="lastname"
                                                            placeholder="<?php echo $row->ad_lname; ?>"
                                                        >

                                                    </div>

                                                </div>

                                            </div>

                                            <div class="row">

                                                <div class="col-md-6">

                                                    <div class="form-group">

                                                        <label for="useremail">
                                                            Email Address
                                                        </label>

                                                        <input
                                                            type="email"
                                                            name="ad_email"
                                                            class="form-control"
                                                            id="useremail"
                                                            placeholder="<?php echo $row->ad_email; ?>"
                                                        >

                                                    </div>

                                                </div>

                                                <div class="col-md-6">

                                                    <div class="form-group">

                                                        <label for="profilepicture">
                                                            Profile Picture
                                                        </label>

                                                        <input
                                                            type="file"
                                                            name="ad_dpic"
                                                            class="form-control btn btn-success"
                                                            id="profilepicture"
                                                        >

                                                    </div>

                                                </div>

                                            </div>

                                            <div class="text-right">

                                                <button
                                                    type="submit"
                                                    name="update_profile"
                                                    class="btn btn-success waves-effect waves-light mt-2"
                                                >
                                                    <i class="mdi mdi-content-save"></i>
                                                    Save
                                                </button>

                                            </div>

                                        </form>

                                    </div>
                                    <!-- End Update Profile Tab -->


                                    <!-- Change Password Tab -->
                                    <div class="tab-pane" id="settings">

                                        <form method="post">

                                            <h5 class="mb-4 text-uppercase">
                                                <i class="mdi mdi-account-circle mr-1"></i>
                                                Change Password
                                            </h5>

                                            <div class="row">

                                                <div class="col-md-6">

                                                    <div class="form-group">

                                                        <label for="old_pwd">
                                                            Old Password
                                                        </label>

                                                        <input
                                                            type="password"
                                                            class="form-control"
                                                            name="old_pwd"
                                                            id="old_pwd"
                                                            placeholder="Enter Old Password"
                                                            required
                                                        >

                                                    </div>

                                                </div>

                                                <div class="col-md-6">

                                                    <div class="form-group">

                                                        <label for="new_pwd">
                                                            New Password
                                                        </label>

                                                        <input
                                                            type="password"
                                                            class="form-control"
                                                            name="ad_pwd"
                                                            id="new_pwd"
                                                            placeholder="Enter New Password"
                                                            required
                                                        >

                                                    </div>

                                                </div>

                                            </div>

                                            <div class="form-group">

                                                <label for="confirm_pwd">
                                                    Confirm Password
                                                </label>

                                                <input
                                                    type="password"
                                                    class="form-control"
                                                    name="confirm_pwd"
                                                    id="confirm_pwd"
                                                    placeholder="Confirm New Password"
                                                    required
                                                >

                                            </div>

                                            <div class="text-right">

                                                <button
                                                    type="submit"
                                                    name="update_pwd"
                                                    class="btn btn-success waves-effect waves-light mt-2"
                                                >
                                                    <i class="mdi mdi-content-save"></i>
                                                    Update Password
                                                </button>

                                            </div>

                                        </form>

                                    </div>
                                    <!-- End Change Password Tab -->

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <!-- Footer Start -->
            <?php include("assets/inc/footer.php"); ?>
            <!-- end Footer -->

        </div>

        <?php } ?>

    </div>

    <!-- END wrapper -->

    <div class="rightbar-overlay"></div>

    <!-- Vendor js -->
    <script src="assets/js/vendor.min.js"></script>

    <!-- App js -->
    <script src="assets/js/app.min.js"></script>

</body>

</html>
