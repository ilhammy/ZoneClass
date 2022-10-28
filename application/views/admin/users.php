<div class="row page-titles">
	<div class="col-md-5 align-self-center">
		<h3 class="text-themecolor">Users</h3>
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="javascript:void(0)">Home</a>
			</li>
			<li class="breadcrumb-item active">Users</li>
		</ol>
	</div>
	<div class="col-md-7 align-self-center">
	</div>
</div>
<!-- End Bread crumb and right sidebar toggle -->

<div class="card card-body">
	<div class="message-center" style="height: auto !important">
		<ul class="nav nav-pills">
			<li class="nav-item">
				<a href="/dashboard/users" class="nav-link <?= (is_null($pilter)) ? 'active' : '' ?>">Semua</a>
			</li>
			<li class="nav-item">
				<a href="/dashboard/users/guru" class="nav-link <?= ($pilter === 1) ? 'active' : '' ?>">Guru</a>
			</li>
			<li class="nav-item">
				<a href="/dashboard/users/siswa" class="nav-link <?= ($pilter === 2) ? 'active' : '' ?>">Siswa</a>
			</li>
			<li class="nav-item">
				<a href="/dashboard/users/admin" class="nav-link <?= ($pilter === 0) ? 'active' : '' ?>">Admin</a>
			</li>
			<li class="nav-item">
				<a href="/dashboard/users/pending" class="nav-link <?= ($pilter === 3) ? 'active' : '' ?>">Pending</a>
			</li>
		</ul>
	</div>
</div>

<div class="card">
	<div class="card-body">
		<h4 class="card-title">Daftar Pengguna</h4>
		<div class="table-responsive mt-2">
			<table id="myTable" class="table table-bordered table-striped nowrap">
				<thead>
					<tr>
						<th>#</th>
						<th>Nama</th>
						<th>Email</th>
						<th>WhatsApp</th>
						<th>Status Akun</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php
					if (sizeof($users) == 0) echo '<div class="no-data">Tidak ada users</div>';

					foreach ($users as $val) :
					?>
					<tr>
						<td>
							<img src="<?= $val->foto ?>" class="rounded-circle" width="35" height="35" />
						</td>
						<td><?= $val->fullname ?></td>
						<td><?= $val->email ?></td>
						<td><?= $val->whatsapp ?></td>
						<td class="text-center">
							<span class="badge badge-<?= ($val->isActive) ? 'success' : 'danger' ?>">
								<?= ($val->isActive) ? 'Aktif' : 'Pending' ?>
							</span>
						</td>
						<td class="text-center">
							<button class="btn btn-sm btn-danger" onclick="showConfirm()">
								<i class="fa fa-trash"></i>
							</button>
							<button class="m-1 btn btn-sm btn-primary"
								onclick="location.href='/dashboard/profile/<?= base64url_encode($val->user_id) ?>'">
								<i class="fa fa-user"></i>
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

<!-- start - This is for export functionality only -->
<script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
<!-- end - This is for export functionality only -->

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
		const exportName = "Data Users<?= ' '.$this->uri->segment(3) ?>"

		$("#myTable").DataTable({
			"lengthChange": false,
			dom: "Bfrtip",
			buttons: [{
				extend: 'csvHtml5',
				title: exportName.trim(),
				exportOptions: {
					columns: [1, 2, 3]
				}
			},
				{
					extend: 'excelHtml5',
					title: exportName.trim(),
					exportOptions: {
						columns: [1, 2, 3],
					}
				}]
		});
		$(".buttons-csv, .buttons-excel").addClass("btn btn-primary mr-1");
	});

	const hapusMateri = (id) => {
		Swal.fire({
			title: 'Konfirmasi',
			text: 'Anda ingi menghapus user ini?',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Hapus',
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
		return str.replace(/(?:\r\n|\r|\n)/g,
			'<br />');
	}
</script>