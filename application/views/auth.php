<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- ===== CSS ===== -->
        <link rel="stylesheet" href="/assets/css/auth/styles.css">
    
        <!-- ===== BOX ICONS ===== -->
        <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>

        <title>Login</title>
    </head>
    <body>
        <div class="login">
            <div class="login__content">
                <div class="login__img">
                    <img src="/assets/img/img-login.svg" alt="">
                </div>

                <div class="login__forms">
                    <form action="/auth/login" class="login__registre" id="login-in" method="post">
                        <h1 class="login__title">Masuk Untuk Melanjutkan</h1>
                        
                        <div class="login_msg">
                        	<?= $this->session->flashdata('auth_msg') ?>
                        	<?= validation_errors(); ?>
                        </div>
    
                        <div class="login__box">
                            <i class='bx bx-user login__icon'></i>
                            <input type="text" name="username" placeholder="Username" class="login__input">
                        </div>
    
                        <div class="login__box">
                            <i class='bx bx-lock-alt login__icon'></i>
                            <input type="password" name="password" placeholder="Password" class="login__input">
                        </div>

                        <a href="#" class="login__forgot">Lupa password?</a>

                        <button type="submit" class="login__button">Masuk</button>

                        <div>
                            <span class="login__account">Belum punya akun ?</span>
                            <span class="login__signin" id="sign-up">Mendaftar</span>
                        </div>
                    </form>

                    <form action="/auth/register" method="post" class="login__create none" id="login-up">
                        <h1 class="login__title">Membuat Akun</h1>
    
                        <div class="login__box">
                            <i class='bx bx-user login__icon'></i>
                            <input type="text" name="username" placeholder="Username" class="login__input">
                        </div>
    
                        <div class="login__box">
                            <i class='bx bx-at login__icon'></i>
                            <input type="text" name="email" placeholder="Email" class="login__input">
                        </div>

                        <div class="login__box">
                            <i class='bx bx-lock-alt login__icon'></i>
                            <input type="password" name="password" placeholder="Password" class="login__input">
                        </div>

                        <button type="submit" class="login__button">Buat Akun</button>

                        <div>
                            <span class="login__account">Sudah punya akun ?</span>
                            <span class="login__signup" id="sign-in">Masuk</span>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <!--===== MAIN JS =====-->
        <script src="/assets/js/auth/main.js"></script>
    </body>
</html>