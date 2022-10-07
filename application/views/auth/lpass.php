<div class="login">
	<div class="login__content">
		<div class="login__img">
			<img src="/assets/img/img-login.svg" alt="">
		</div>
		<div class="login__forms">
			<form action="" class="login__registre" id="login-in" method="post">
				<h1 class="login__title">Lupa Kata Sandi</h1>

				<div class="login_msg">
					<?= $this->session->flashdata('auth_msg') ?>
				</div>

				<div class="login__box">
					<i class='bx bx-at login__icon'></i>
					<input type="email" name="email" placeholder="Email" class="login__input" required="">
				</div>
				<input type="hidden" name="tkn" value="<?= base64_encode($web_name) ?>">

				<input type="submit" name="lpass" class="login__button" value="Submit" />

				<div>
					<span class="login__account">Sudah punya akun ?</span>
					<a href="/auth"><span class="login__signin" id="sign-up">Masuk</span></a>
				</div>
			</form>

		</div>
	</div>
</div>