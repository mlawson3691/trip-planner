<?php
    $website = require_once __DIR__.'/../app/app.php';
    $website->run();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
<!-- stylesheets -->
    <link href='/assets/css/bootstrap.min.css' rel='stylesheet' type='text/css'>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-T8Gy5hrqNKT+hzMclPo118YTQO6cYprQmhrYwIiQ/3axmI1hQomh7Ud2hPOy8SP1" crossorigin="anonymous">
    <link href='/assets/css/styles.css' rel='stylesheet' type='text/css'>
<!-- fonts -->
    <link href='https://fonts.googleapis.com/css?family=Slabo+27px' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Josefin+Slab:400,100,300,600,700' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Playfair+Display:400,400italic,700,700italic,900,900italic' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Arapey:400,400italic' rel='stylesheet' type='text/css'>
<!-- script tags -->
    <script src='/assets/js/jquery-3.1.1.min.js'></script>
    <script src='/assets/js/bootstrap.min.js'></script>
    <script src="/assets/js/scripts.js"></script>
    <title>Trip Planner</title>
</head>
</html>
