<div class="row page-titles">
	<div class="col-md-5 align-self-center">
		<h3 class="text-themecolor">Kelas</h3>
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="javascript:void(0)">Home</a>
			</li>
			<li class="breadcrumb-item active">Kelas Saya</li>
		</ol>
	</div>
	<div class="col-md-7 align-self-center">
		<button class="btn
			waves-effect waves-light
			btn btn-info
			pull-right text-white"
			onclick="window.location.assign('/dashboard/kelas/tambah')">
			<i class="fa fa-plus"></i> Buat Kelas
		</button>
	</div>
</div>
<!-- End Bread crumb and right sidebar toggle -->

<div class="row">
	<div class="col-md-6">
		<div class="card card-body mailbox">
			<h5 class="card-title">Menunggu Persetujuan</h5>
			<div class="message-center" style="height: auto!important">
				<?php
				if ($data_kelas == null) echo '<div class="no-data">Tidak ada kelas</div>';

				foreach ($data_kelas as $val) : ?>
				<!-- Message -->
				<a href="/dashboard/kelas/<?= $val->id_kelas ?>">
					<div class="btn btn-success btn-circle">
						<i class="fa fa-graduation-cap"></i>
					</div>
					<div class="mail-contnet">
						<h6 class="text-dark font-medium mb-0"><?= $val->nama_kelas ?></h6>
						<span class="mail-desc">
							<?= timeago($val->dibuat) ?>
						</span>
					</div>
					<div class="btn p-1" style="position: absolute">
						<i class="fa fa-caret-square-o-down"></i>
					</div>
				</a>
				<?php endforeach ?>
			</div>
		</div>
	</div>
	<!-- End Kiri -->
	<div class="col-md-6">
		<div class="card card-body mailbox">
			<h5 class="card-title">Daftar Kelas</h5>
			<div class="message-center" style="height: auto !important">
				<?php
				if ($data_kelas == null) echo '<div class="no-data">Tidak ada kelas</div>';

				foreach ($data_kelas as $val) :
				$siswanya = $this->Kelas_model->getAllSiswa($val->id_kelas);
				?>
				<!-- Message -->
				<a href="/dashboard/kelas/<?= $val->id_kelas ?>">
					<div class="btn btn-success btn-circle">
						<i class="fa fa-graduation-cap"></i>
					</div>
					<div class="mail-contnet">
						<h6 class="text-dark font-medium mb-0"><?= $val->nama_kelas ?></h6>
						<span class="mail-desc">
							<?= sizeof($siswanya) ?> Siswa
						</span>
					</div>
					<div class="btn p-1" style="position: absolute">
						<i class="fa fa-caret-square-o-down"></i>
					</div>
				</a>
				<?php endforeach ?>
			</div>
		</div>
	</div>
	<!-- End Kanan -->
</div>
<!-- End Row -->