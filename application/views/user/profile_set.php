<?php
$ttl = profileValue('tgl_lahir');
$ttl = date('Y-m-d', $ttl);
if ($ttl == 0) $ttl = null;
?>

<div class="projects-section">
	<div class="projects-section-header">
		<p>
			Pengaturan Profile
		</p>
	</div>
	<div class="project-boxes">
		<?= validation_errors('<div class="alert alert-info">', '</div>') ?>
		<?= $this->session->flashdata('setting-msg') ?>

		<form action="" method="post" id="formnya" style="margin-bottom: 3rem">
			<div class="input-wrapper">
				<label class="label">Username</label>
				<input class="myinput" type="text" value="<?= dataUserValue('username') ?>" required disabled>
			</div>
			<div class="input-wrapper">
				<label class="label">Nama Lengkap</label>
				<input class="myinput" name="fname" type="text" value="<?= profileValue('fullname') ?>" required>
			</div>
			<div class="input-wrapper">
				<label class="label">Jenis Kelamin</label>
				<select class="myinput" name="kel" required>
					<option value="Pria" <?= (profileValue('kelamin') === 'Pria')? 'selected' : '' ?>>Pria</option>
					<option value="Wanita" <?= (profileValue('kelamin') !== 'Pria')? 'selected' : '' ?>>Wanita</option>
				</select>
			</div>
			<div class="input-wrapper">
				<label class="label">Tanggal Lahir</label>
				<input class="myinput" name="ttl" type="date" value="<?= $ttl ?>" required>
			</div>
			<div class="input-wrapper">
				<label class="label">No Whatsapp</label>
				<input class="myinput" name="whatsapp" type="number" value="<?= profileValue('whatsapp') ?>" required>
			</div>
			<div class="input-wrapper">
				<label class="label">Email</label>
				<input class="myinput" type="email" value="<?= dataUserValue('email') ?>" required disabled>
			</div>
			
			<div class="text-center" style="margin:3rem 0 0 0">
				<input name="save" type="submit" value="Simpan" class="btn btn-primary" />
			</div>
		</form>

	</div>
</div>

<script>
	document.title = 'Pengaturan Profile';
</script>