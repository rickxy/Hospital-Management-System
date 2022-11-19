<?php
    session_start();
    unset($_SESSION['ad_id']);
    session_destroy();

    header("Location: his_admin_logout.php");
    exit;
?>