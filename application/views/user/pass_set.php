<div class="top-nav">
	<ion-icon class="icon" name="arrow-back-outline" onclick="window.localStorage.setItem('ref', 'profile');window.open('/', '_self')"></ion-icon>
	<div class="title" style="font-size: 1.1rem;font-weight: 600; padding: 0 .5rem">
	</div>
</div>

<div class="projects-section">
	<div class="projects-section-header">
		<p>
			Ubah Kata Sandi Akun
		</p>
	</div>
	<div class="project-boxes">
		
		<?= $this->session->flashdata('setting-msg') ?>

		<form action="" method="post" id="pass-form">
			<input type="hidden" name="save" value="true" />
			<div class="input-wrapper">
				<label class="label">Kata Sandi Lama</label>
				<input class="myinput" name="pass" type="text" autocomplete="off" required>
			</div>
			<div class="input-wrapper">
				<label class="label">Kata Sandi Baru</label>
				<input class="myinput" name="new_pass" type="text" placeholder="min 5 karakter" autocomplete="off" required>
			</div>
	
			<div class="text-center" style="margin:3rem 0 0 0">
				<input type="submit" value="Ubah" class="btn btn-primary" />
			</div>
		</form>

	</div>
</div>

<script>
	document.title = 'Ubah Kata Sandi';
</script>