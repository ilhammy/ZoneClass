<div class="row page-titles">
	<div class="col-md-5 align-self-center">
		<h3 class="text-themecolor">Materi</h3>
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="javascript:void(0)">Home</a>
			</li>
			<li class="breadcrumb-item active">Materi</li>
		</ol>
	</div>
	<div class="col-md-7 align-self-center">
		<button class="btn
			waves-effect waves-light
			btn btn-info
			pull-right text-white"
			onclick="window.location.assign('/dashboard/materi/tambah')" <?= ($data_kelas == null) ? 'disabled' : '' ?>>
			<i class="fa fa-plus"></i> Posting
		</button>
	</div>
</div>
<!-- End Bread crumb and right sidebar toggle -->

<div class="card card-body">
	<div class="message-center" style="height: auto !important">
		<ul class="nav nav-pills">
			<li class="nav-item">
				<a href="/dashboard/materi" class="nav-link <?= (is_null($kelas_terpilih)) ? 'active' : '' ?>">Semua</a>
			</li>
			<?php
			if ($data_kelas == null) echo '<div class="no-data">Tidak ada kelas</div>';
			foreach ($data_kelas as $key => $val) :
			$cls = ($val->id_kelas == $kelas_terpilih) ? 'active' : '';
			?>
			<li class="nav-item">
				<a href="/dashboard/materi?kelas=<?= $val->id_kelas ?>" class="nav-link <?= $cls ?>"><?= $val->nama_kelas ?></a>
			</li>
			<?php endforeach ?>
		</ul>
	</div>
</div>

<div class="card">
	<div class="card-body">
		<h4 class="card-title">Daftar Materi</h4>
		<div class="table-responsive mt-2">
			<table id="myTable" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>#</th>
						<th>Judul</th>
						<th>Konten</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php
					if (is_null($kelas_terpilih)) {
						$data_materi = $this->Materi->getByCreator(myUid());
					} else if (isAdmin()) {
						$data_materi = $this->Materi->getAll();
					} else {
						$data_materi = $this->Materi->getByClass($kelas_terpilih);
					}
					if (sizeof($data_materi) == 0) echo '<div class="no-data">Tidak ada siswa</div>';

					foreach ($data_materi as $key => $val) :
					?>
					<tr>
						<td><?= $key + 1 ?></td>
						<td><?= $val->judul ?></td>
						<td>
							<button class="btn btn-sm btn-info">
								Lihat
							</button>
						</td>
						<td class="text-center">
							<button class="btn btn-sm btn-danger">
								<i class="fa fa-trash"></i>
							</button>
							<button class="btn btn-sm btn-primary">
								<i class="fa fa-pencil"></i>
							</button>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<!-- This is data table -->
<script src="/assets/js/admin/jquery.dataTables.min.js"></script>
<script src="/assets/js/admin/dataTables.responsive.min.js"></script>

<script>
	$(function () {
		$("#myTable").DataTable();
	});
</script>