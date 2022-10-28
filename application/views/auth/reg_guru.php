<div class="login">
	<div class="login__content">
		<div class="login__img">
			<img src="/assets/img/img-login.svg" alt="">
		</div>
		<div class="login__forms" id="login-up">
			<form action="/auth/login" class="login__registre" id="regForm" method="post">
				<h1 class="login__title">Buat Akun Guru</h1>

				<div class="login__box">
					<i class='bx bx-user login__icon'></i>
					<input type="text" name="fullname" placeholder="Nama Lengkap" class="login__input">
				</div>

				<div class="login__box">
					<i class='bx bx-user login__icon'></i>
					<input type="text" name="username" placeholder="Username" class="login__input">
				</div>

				<div class="login__box">
					<i class='bx bx-at login__icon'></i>
					<input type="text" name="email" placeholder="Email aktif" class="login__input">
				</div>

				<div class="login__box">
					<i class='bx bx-lock-alt login__icon'></i>
					<input type="password" name="password" placeholder="Password" class="login__input">
				</div>

				<div class="login__box">
					<i class='bx bxl-whatsapp login__icon'></i>
					<input type="number" name="what" placeholder="No WhatsApp aktif" class="login__input">
				</div>
				
				<div class="login__box">
					<i class='bx bx-key login__icon'></i>
					<input type="text" autocomplete="off" name="reg_code" placeholder="Kode Undangan (Opsional)" class="login__input">
				</div>

				<input type="hidden" name="is_guru" id="is_guru" value="oke" />

				<button type="submit" class="login__button" id="btn_reg">Buat Akun</button>

				<div>
					<span class="login__account">Sudah punya akun ?</span>
					<span class="login__signup" onclick="window.location.assign('/auth')">Masuk</span>
				</div>


			</form>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {

		$("#regForm").on("submit", function(event) {
			event.preventDefault();

			$.ajax({
				url: "/auth/register",
				type: "POST",
				data: $(this).serialize(),
				success: function(resp) {
					resp = JSON.parse(resp);
					let pesan = resp.text;

					if (resp.status) {
						Swal.fire({
							icon: 'success',
							title: 'Pendaftaran Berhasil!',
							text: 'Anda akan di arahkan ke form login dalam 3 Detik',
							timer: 3000,
							showCancelButton: false,
							showConfirmButton: false
						})
						.then (function() {
							$('#login-up').trigger("reset");
							$('#sign-in').click();
						});
					} else {
						Swal.fire(
							'Pendaftaran Gagal!',
							pesan + '',
							'error'
						);
					}
					console.info(resp);
				},

				error: function(response) {
					Swal.fire(
						'Opps!',
						'server error!',
						'error'
					);
					console.error(response);
				}
			});

		});
	});
</script>