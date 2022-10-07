<div class="profile-box">
	<div class="profile-box-header">
		<img src="<?= profileValue('foto') ?>" class="foto" />
		<h1><?= profileValue('fullname') ?></h1>
		<h2><?= $this->session->userdata('username') ?></h2>
	</div>
	
	<div class="profile-box-menus">
		<a href="/settings/profile">
			<ion-icon name="settings-outline" class="icon"></ion-icon>
			<span class="name">Pengaturan</span>
			<ion-icon name="chevron-forward-outline" class="arrow"></ion-icon>
		</a>
		<a href="/logout">
			<ion-icon name="log-out-outline" class="icon"></ion-icon>
			<span class="name">Log Out</span>
			<ion-icon name="chevron-forward-outline" class="arrow"></ion-icon>
		</a>
	</div>
</div>