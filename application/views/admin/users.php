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
						<td onclick="window.location.assign('https://wa.me/<?= $val->whatsapp ?>')">&#x200C;<?= $val->whatsapp ?></td>
						<td class="text-center">
							<span class="badge badge-<?= ($val->isActive) ? 'success' : 'danger' ?>" data-toggle="dropdown">
								<?= ($val->isActive) ? 'Aktif' : 'Pending' ?>
							</span>

							<div class="dropdown-menu">
								<a class="dropdown-item <?= ($val->isActive) ? 'active' : null ?>" href="javascript:changeStatus(<?= $val->user_id ?>, 1)"><i class="fa fa-check"></i> Terima</a>
								<a class="dropdown-item <?= (!$val->isActive) ? 'active' : null ?>" href="javascript:changeStatus(<?= $val->user_id ?>, 0)"><i class="fa fa-power-off"></i> Nonaktifkan</a>
							</div>
						</td>
						<td class="text-center">
							<button class="btn btn-sm btn-danger" onclick="showConfirm(<?= $val->user_id ?>)">
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

	const showConfirm = (id) => {
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
			url: '/admin/users/<?= (isAdmin()) ? 'removeUser' : null ?>',
			method: 'post',
			data: {
				diu: id
			},
			dataType: 'json',
			success: (response) => {
				console.log(response)
				if (response.status !== true) {
					showMsg('info', response.msg);
				} else {
					showMsg('success', 'User telah dihapus!');
					setTimeout(() => {
						location.reload(true)
					}, 2000);
				}
			},
			complete: () => $(".preloader").fadeOut(),
			error: () => showMsg('info', 'Server error!')
		});
	}
	
	const changeStatus = (id, stat) => {
		$(".preloader").fadeIn();
		$.ajax({
			url: '/admin/users/<?= (isAdmin()) ? 'toggleUser' : null ?>',
			method: 'post',
			data: {
				diu: id, 
				tats: stat
			},
			dataType: 'json',
			success: (response) => {
				console.log(response)
				if (!response.status) {
					showMsg('info', response.msg);
				} else {
					let xyz = (stat === 0) ? 'dinonaktifkan!' : 'diaktifkan!'
					showMsg('success', 'User telah ' + xyz);
					setTimeout(() => {
						location.reload(true)
					}, 2500);
				}
			},
			complete: () => $(".preloader").fadeOut(),
			error: () => showMsg('info', 'Server error!')
		});
	}

</script>