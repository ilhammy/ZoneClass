<div class="row page-titles">
	<div class="col-md-5 align-self-center">
		<h3 class="text-themecolor">Siswa</h3>
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="javascript:void(0)">Home</a>
			</li>
			<li class="breadcrumb-item active">Siswa Saya</li>
		</ol>
	</div>
	<div class="col-md-7 align-self-center">

	</div>
</div>
<!-- End Bread crumb and right sidebar toggle -->


<div class="card card-body mailbox">
	<h5 class="card-title">Daftar Siswa</h5>
	<div class="message-center" style="height: 420px !important">
		<?php
		if (sizeof($data_siswa) == 0) echo '<div class="no-data">Tidak ada siswa</div>';

		foreach ($data_siswa as $val) :
		$kelasnya = json_decode($val->kelas);
		?>
		<!-- Message -->
		<a href="#">
			<img src="<?= $val->foto ?>" class="rounded-circle" width="35" height="35" />
			<div class="mail-contnet">
				<h6 class="text-dark font-medium mb-0"><?= $val->fullname ?></h6>
				<span class="mail-desc">
					<?= sizeof($kelasnya) . ' Kelas'; ?>
				</span>
			</div>
		</a>
		<?php endforeach ?>
	</div>
</div>