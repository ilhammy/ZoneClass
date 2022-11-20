<?php
$totalKelas = $totalMateri = $totalSiswa = 0;
if ($data_user->role_id == 2) {
	$totalKelas = sizeof(json_decode($data_user->kelas));
} else {
	$totalKelas = sizeof($this->Kelas->getMyClass($uid));
	$totalMateri = sizeof($this->Materi->getByCreator($uid));

	$s = array();
	foreach ($this->Kelas->getMyClass($uid) as $i) {
		foreach ($this->Kelas->getAllSiswaByKelas($i->id_kelas) as $usr) {
			$ud = $this->User_model->getByUid($usr->id_user);
			if (!is_null($ud)) {
				array_push($s, $ud);
			}
		}
	}
	$totalSiswa = sizeof(my_array_unique($s));
}
?>

<div class="row page-titles">
	<div class="col-md-5 align-self-center">
		<h3 class="text-themecolor">Profile</h3>
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="javascript:void(0)">Home</a>
			</li>
			<li class="breadcrumb-item active">Profile</li>
		</ol>
	</div>
	<div class="col-md-7 align-self-center text-right d-none d-md-block">
	</div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->

<!-- Row -->
<div class="row justify-content-center">
	<!-- Column -->
	<div class="col-md-10">
		<div class="card">
			<div class="card-body">
				<center class="m-t-30 d-block">
					<img src="<?= $data_user->foto ?>" class="img-circle" width="150" height="150" />
					<h4 class="card-title m-t-10"><?= $data_user->fullname ?></h4>
					<h6 class="card-subtitle">
						@<?= $data_user->username ?>
						<br />
						<span class="mt-2 badge badge-pill badge-primary px-2 py-1"><?= roleName($data_user->role_id) ?></span>
						<span class="badge badge-pill badge-warning"><?= isOnlineUser($data_user->user_id) ? 'online' : null ?></span>
					</h6>
					<div class="row text-center justify-content-md-center">
						<div class="col-4">
							<a href="javascript:void(0)" class="link"><i class="icon-people"></i>
								<font class="font-medium"><?= $totalKelas ?><br />Kelas</font>
							</a>
						</div>
						<div class="col-4">
							<a href="javascript:void(0)" class="link"><i class="icon-picture"></i>
								<font class="font-medium"><?= $totalMateri ?><br />Materi</font>
							</a>
						</div>
						<div class="col-4">
							<a href="javascript:void(0)" class="link"><i class="icon-picture"></i>
								<font class="font-medium"><?= $totalSiswa ?><br />Siswa</font>
							</a>
						</div>
					</div>
				</center>
			</div>
			<div>
				<hr />
			</div>
			<div class="card-body">
				<small class="text-muted">Email </small>
				<h6><?= $data_user->email ?></h6>
				<small class="text-muted p-t-30 db">WhatsApp</small>
				<h6><?= $data_user->whatsapp ?></h6>
				<small class="text-muted p-t-30 db">Jenis Kelamin</small>
				<h6><?= $data_user->kelamin ?></h6>
				<small class="text-muted p-t-30 db">Tanggal Lahir</small>
				<h6><?= dateIndo($data_user->tgl_lahir) ?></h6>

				<small class="text-muted p-t-30 db">Social Profile</small>
				<br />
				<a href="https://wa.me/<?= $data_user->whatsapp ?>" class="btn btn-circle btn-secondary">
					<i class="fa fa-whatsapp"></i>
				</a>
				<a href="mailto:<?= $data_user->email ?>" class="btn btn-circle btn-secondary">
					<i class="fa fa-envelope-o"></i>
				</a>
			</div>
		</div>
	</div>
	<!-- Column -->
</div>
<!-- Row -->