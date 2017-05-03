<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>CodeX: Student</title>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:700,300,600,400' rel='stylesheet' type='text/css'>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
    <link rel="stylesheet" href="/codex/assets/css/main.css">

</head>
<body>

<nav class="navbar navbar-default navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">CodeX</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

            <ul class="nav navbar-nav navbar-right">
               <li><a href="http://<?php echo $_SERVER['SERVER_NAME']; ?>/CodeX/student/">Home <span class="sr-only">(current)</span></a></li>
               <li><a href="http://<?php echo $_SERVER['SERVER_NAME']; ?>/CodeX/student/practice/">Practice</a></li>
               <li><a href="http://<?php echo $_SERVER['SERVER_NAME']; ?>/CodeX/student/submissions/">My Submissions</a></li>
               <li><a href="http://<?php echo $_SERVER['SERVER_NAME']; ?>/CodeX/student/contests/">Contests</a></li>
               <li class="dropdown profile">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $_SESSION['username']." "; ?> <span class="caret"></span></a>
                  <ul class="dropdown-menu" role="menu">
                     <li><a href="http://<?php echo $_SERVER['SERVER_NAME']; ?>/codex/logout/">Logout</a></li>
                  </ul>
               </li>
            </ul>
        </div>    </div><!-- /.container-fluid -->
</nav>

<div class="container-fluid">
    <div class="row">

        <section class="col-sm-12 col-md-12 main">