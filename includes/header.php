<?php
    ob_start();
    session_start();

    define('ADMIN_LOGIN', 'admin');
    define('ADMIN_PASS', 'admin');

    if ($_SESSION['user_login'] != ADMIN_LOGIN && $_SESSION['user_pass'] != ADMIN_PASS) {
        header("Location: login.php");
        exit;
    }


    include 'config/dbconnect.php';

?><!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="CRM">
    <title>CRM</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link href="css/style.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<div id="wrapper">

    <!-- Left Menu -->
    <?php include 'menu.php'; ?>
    <!--  -->

    <main id="page-content-wrapper">
        <!-- User info, logout, date etc. -->
        <?php include 'user.php'; ?>
        <!--  -->
        <div class="tab-content">