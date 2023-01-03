<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Page Not Found</title>
    <link rel="icon" type="image/png" href="<?= asset('img/bootstrap.min.css') ?>">
    <link href="<?= asset('css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css">
    <link href="<?= asset('css/styles.css') ?>" rel="stylesheet" type="text/css">
    <link href="<?= asset('css/custom.css') ?>" rel="stylesheet" type="text/css">
    <style>
    body{
        font-family: "Source Sans Pro", "Segoe UI", Frutiger, "Frutiger Linotype", "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
        background: url('<?= asset('img/blue.jpg') ?>') no-repeat center center/cover;
        text-align: center;
        color: #fff;
        margin: 0;
        position: relative;
    }

    .main-logo{
        margin: 20px auto 0;
        width: 100%;
        text-align: center;
        padding: 10px;
        position: relative;
        z-index: 150;
        background: #fff;
    }

    .main-logo img{
        width: 150px;
        margin: 0 auto !important;
    }

    h1{
        font-size: 280px;
        font-weight: bold;
        line-height: 100%;
        margin: -20px auto 20px;
        color: #fff;
    }

    p{
        font-size: 24px;
        line-height: 30px;
        margin-bottom: 40px;
        color: #fff;
    }
    </style>
</head>
<body>
    <div class="main-logo">
        <a href="<?= url('home') ?>">
            <img src="<?= asset('img/main-logo.png') ?>" alt="eLink Systems & Concepts Corp.">
        </a>
    </div>

    <div class="main-error">
        <h1>404</h1>
        <p>Sorry, the page you are looking for could not be found!</p>
        <a class="btn btn-primary" href="<?= url('home') ?>">Go back home</a>
    </div>
</body>
