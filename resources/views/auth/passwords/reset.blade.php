<!DOCTYPE html>
<html lang="<?= app()->getLocale() ?>">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/png" href="http://www.elink.com.ph/wp-content/uploads/2016/01/elink-logo-site.png">
        <title>Human Resources Gateway | Reset Password</title>
        <link href="<?= asset('css/css.css') ?>" rel="stylesheet">

        @include('auth.styles')
    </head>
    <body>
        <div class="container">
            <div class="authentication-logo">
                <img src="<?= asset('img/main-logo.png') ?>" alt="Human Resources Gateway">
                <!-- <h1>eLink  F A L C O N&nbsp;&nbsp;<span>∞&nbsp;&nbsp;HR Portal</span></h1> -->
            </div>
            <div class="content">
                <h2>FORGOT PASSWORD</h2>
                <div class="links">
                    <form method="POST" action="">
                        @csrf
                        <div class="form-group">
                            <input id="email" type="email" placeholder="Email Address" class="form-input" name="email" required autocomplete="email" autofocus>
                        </div>
                    <?php
                        if ($errors->has('email')) {
                    ?>
                        <span class="invalid-feedback"><?= $errors->first('email') ?></span>
                    <?php
                        }
                        if (Session::has('Success')) {
                    ?>
                        <span><?=Session::get('Success') ?></span>
                    <?php
                        }
                    ?>
                        <div class="form-group">
                            <button class="button flat" name="submit">Reset Password</button>
                        </div>
                    </form>
                </div>
                <div class="links-small">
                    <a href="<?= route('login') ?>">Login</a>
                </div>
            </div>
        </div>
    </body>
    <footer>
        <img src="<?= asset('img/elink-text-logo.png') ?>" alt="eLink Systems & Concepts Corp.">
        <div class="copyright">© Copyright <?= date('Y') ?></div>
    </footer>
</html>
