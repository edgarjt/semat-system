<?php
session_start();

if ($_SESSION['status_session']){
    header("Location: intro.php");
}else {
    header("Location: login.php");
}