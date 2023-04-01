<?php

if (isset($_SESSION['user_id'])) {
    // User is already logged in, redirect to dashboard or home page
    dump($_SESSION);
    // header('Location: dashboard.php');
    // exit();
}
