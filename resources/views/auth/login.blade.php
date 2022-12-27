<!DOCTYPE html>
<html lang="<?= app()->getLocale() ?>">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/png" href="http://www.elink.com.ph/wp-content/uploads/2016/01/elink-logo-site.png">
        <title>Elink Employee Directory | Login</title>
        <link href="<?= asset('css/css.css') ?>" rel="stylesheet">

        @include('auth.styles')
    </head>
    <body>
        <div class="container">
            <div class="authentication-logo">
                <img src="<?= asset('img/elink-logo-site.png') ?>" alt="eLink Systems & Concepts Corp.">
                <h1>eLink  F A L C O N&nbsp;&nbsp;<span>∞&nbsp;&nbsp;HR Portal</span></h1>
            </div>
            <div class="content">
                <h2>LOGIN WITH YOUR ACCOUNT</h2>
                <div class="links">
                    <form method="POST" action="<?= route('login') ?>">
                        @csrf
                        <div class="form-group">
                            <input class="form-input" type="text" name="email" placeholder="Username" required autofocus/>
                        </div>
                        <div class="form-group">
                            <input class="form-input" type="password" name="password" value="" placeholder="Password" required/>
                        </div>
                    <?php
                        if ($errors->has('password')) {
                    ?>
                        <span class="invalid-feedback"><?= $errors->first('password') ?></span>
                    <?php
                        }
                        if ($errors->has('email')) {
                    ?>
                        <span class="invalid-feedback"><?= $errors->first('email') ?></span>
                    <?php
                        }
                    ?>
                        <div class="form-group">
                            <button class="button flat" name="submit">
                                <span class="icon">
                                    <img src="<?= asset('img/arrow-right.gif') ?>" alt="→">
                                </span> 
                                Login
                            </button>
                        </div>
                    </form>
                </div>
                <div class="links-small">
                    <a href="<?= route('password.forgot') ?>">Forgot Password</a>
                </div>
            </div>
        </div>
    </body>
    <footer>
        <div class="copyright">© Copyright <?= date('Y') ?> • eLink Systems & Concepts Corp.</div>
    </footer>
</html>
