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
			<table id="myTable" class="table table-bordered table-striped nowrap table-hover">
				<thead>
					<tr>
						<th><i class="fa fa-sort-numeric-asc"></i></th>
						<th>Judul</th>
						<th>Konten</th>
						<?= (is_null($kelas_terpilih)) ? '<th>Kelas</th>' : '' ?>
						<th>Views</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php
					if (is_null($kelas_terpilih)) {
						$data_materi = $this->Materi->getByCreator(myUid());
					} else {
						$data_materi = $this->Materi->getByClass($kelas_terpilih);
					}
					if (sizeof($data_materi) == 0) echo '<div class="no-data">Tidak ada siswa</div>';

					foreach ($data_materi as $key => $val) :
					?>
					<tr>
						<td class="text-center"><?= $key + 1 ?></td>
						<td><?= $val->judul ?></td>
						<td>
							<button onclick="setModal1('<?= base64_encode(json_encode($val)) ?>')" class="btn btn-sm btn-info text-white" data-toggle="modal" data-target="#modal1">
								Lihat
							</button>
						</td>
						<?php
						if (is_null($kelas_terpilih)) {
							$kls = $this->Kelas->getSingle($val->id_kelas);
							echo "<td>$kls->nama_kelas</td>";
						} ?>
						<td class="text-center">
							<?= $val->views ?>
						</td>
						<td class="text-center">
							<button class="btn btn-sm btn-danger" type="button" onclick="hapusMateri(<?= $val->id ?>)">
								<i class="fa fa-trash"></i>
							</button>
							<button class="btn btn-sm btn-primary" onclick="window.location.assign('/dashboard/materi/edit/<?= base64url_encode($val->id) ?>')">
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
	let confirmed = false;
	const setModal1 = (data) => {
		const cont = $('#modal1 .modal-body');
		data = JSON.parse(atob(data))
		let teks = (data.teks !== null)? `<p>${nl2br(data.teks)}</p>`: '';
		let link = (data.link !== null)? toAcordion(JSON.parse(data.link)): '';
		let foto = (data.foto !== null)? `<img src="${data.foto}" width="100%" />`: '';
		let youtube = (data.youtube !== null)? `<iframe src="https://www.youtube.com/embed/${data.youtube}" class="d-block mx-auto" frameborder="0" allowFullScreen></iframe>`: '';

		let html = teks + link + foto + youtube;
		cont.html(html)
	}

	const toAcordion = (links) => {
		let out = ''
		links.forEach(function (v, i) {
			out += '<tr><td>' + v.name + '</td>' +
			'<td>' + v.url + '</td></tr>'
		});
		return '<table class="table table-responsive table-striped"><tr><th>Judul Link</th><th>Url</th></tr>' + out + '</table>';
	}

	$(function () {
		$("#myTable").DataTable({
			"lengthChange": false
		});
	});

	const hapusMateri = (id) => {
		Swal.fire({
			title: 'Konfirmasi',
			text: 'Anda ingi menghapus materi ini?',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Oke',
			cancelButtonText: 'Batal'
		}).then((result) => {
			if (result.isConfirmed) {
				ajaxHapus(id)
			}
		})
	}

	const ajaxHapus = (id) => {
		$(".preloader").fadeIn();
		$.ajax({
			url: '/admin/materi/hapus',
			method: 'post',
			data: {
				id: id
			},
			dataType: 'json',
			success: (response) => {
				console.log(response)
				if (response.status != true) {
					showMsg('info', response.msg);
				} else {
					showMsg('success', 'Materi telah dihapus!');
					setTimeout(() => {
						location.reload(true)
					}, 2000);
				}
			},
			complete: () => $(".preloader").fadeOut(),
			error: () => showMsg('info', 'Server error!')
		});
	}
	
	const nl2br = (str) => {
		return str.replace(/(?:\r\n|\r|\n)/g, '<br />');
	}
</script>