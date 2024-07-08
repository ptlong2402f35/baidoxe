<?php

function redirect($location, $message)
{

    if ($message) {
        if (!isset($_SESSION['username'])) {
            session_start();
        }
        $_SESSION['message'] = $message;
    }
    echo '<script>';
    echo 'console.log("location === ' . $_SESSION['message'] . "" . '");';
    echo '</script>';
    $locationRedirect = 'location: ' . $location . '.php';
    header($locationRedirect);
    exit();
}

function showPopup()
{
    if (isset($_SESSION['message'])) {
        $message = $_SESSION['message'];
        unset($_SESSION['message']);
        echo '<script type="text/javascript">';
        echo ' window.onload = function() {';
        echo 'alert("' . $message . '");';
        echo ' };';
        echo '</script>';
        return $message;
    }
    return null;
}
