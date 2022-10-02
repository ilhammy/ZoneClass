<div class="profile-box">
	<div class="profile-box-header">
		<img src="<?= profileValue('foto') ?>" class="foto" />
		<h1><?= profileValue('fullname') ?></h1>
		<h2><?= $this->session->userdata('username') ?></h2>
	</div>
</div>