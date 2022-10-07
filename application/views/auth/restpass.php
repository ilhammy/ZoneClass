<div class="login">
	<div class="login__content">
		<div class="login__img">
			<img src="/assets/img/img-login.svg" alt="">
		</div>
		<div class="login__forms">
			<form action="/reset_password/token/<?= $token ?>" class="login__registre" id="login-in" method="post">
				<h1 class="login__title">Reset Password</h1>

				<div class="login_msg">
					<?= $this->session->flashdata('auth_msg') ?>
					<?= validation_errors(); ?>
				</div>

				<div class="login__box">
					<i class='bx bx-lock login__icon'></i>
					<input type="text" name="password" placeholder="Password baru" class="login__input" autocomplete="off">
				</div>
				<div class="login__box">
					<i class='bx bx-lock login__icon'></i>
					<input type="text" name="passconf" placeholder="Konfirmasi Password" class="login__input" autocomplete="off">
				</div>

				<input type="submit" class="login__button" value="Submit">
			</form>
		</div>
	</div>
</div>