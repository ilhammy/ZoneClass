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
							<button onclick="setModal1('<?= base64_encode(json_encode($val)) ?>')" class="btn btn-sm btn-info text-white" data-toggle="modal" data-target="#modal1">
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

<!-- sample modal content -->
<div id="modal1" class="modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">
					Preview
				</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					×
				</button>
			</div>
			<div class="modal-body"></div>
			<div class="modal-footer">
				<button class="btn btn-info waves-effect" data-dismiss="modal">
					Tutup
				</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- This is data table -->
<script src="/assets/js/admin/jquery.dataTables.min.js"></script>
<script src="/assets/js/admin/dataTables.responsive.min.js"></script>

<script>
	function setModal1(data) {
		const cont = $('#modal1 .modal-body');
		data = JSON.parse(atob(data))
		let teks = (data.teks !== null)? `<p>${data.teks}</p>`: '';
		let link = (data.link !== null)? toAcordion(JSON.parse(data.link)): '';
		let foto = (data.foto !== null)? `<img src="${data.foto}" width="100%" />`: '';
		let youtube = (data.youtube !== null)? `<iframe src="https://www.youtube.com/embed/${data.youtube}" class="d-block mx-auto" frameborder="0" allowFullScreen></iframe>`: '';

		let html = teks + link + foto + youtube;
		cont.html(html)
	}

	function toAcordion(links) {
		let out = ''
		links.forEach(function (v, i) {
			out += '<div class="card"><div class="card-header"><h2 class="mb-0">' +
			`<button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#coll${i}" aria-expanded="true" aria-controls="collapseOne">` +
			v.name + '</button></h2></div>' +
			`<div id="coll${i}" class="collapse show" aria-labelledby="headingOne" data-parent="#accorlink"><div class="card-body">${v.url}</div></div>`;
		});
		return `<div class="accordion" id="accorlink">${out}</div>`;
	}

	$(function () {
		$("#myTable").DataTable();
	});
</script>