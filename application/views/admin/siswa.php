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

<div class="card">
	<div class="card-body">
		<h4 class="card-title">Daftar Siswa</h4>
		<div class="table-responsive mt-2">
			<table
				id="myTable"
				class="table table-bordered table-striped nowrap table-hover">
				<thead>
					<tr>
						<th><i class="fa fa-user"></i></th>
						<th>Nama</th>
						<th>Email</th>
						<th>WhatsApp</th>
						<?= (isAdmin()) ? '<th>Kelas</th>' : '' ?>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php
					if (sizeof($data_siswa) == 0) echo '<div class="no-data">Tidak ada siswa</div>';

					foreach ($data_siswa as $val) :
					$kelasnya = json_decode($val->kelas);
					?>
					<tr>
						<td>
							<img src="<?= $val->foto ?>" class="rounded-circle" width="35" height="35" />
						</td>
						<td><?= $val->fullname ?></td>
						<td><?= $val->email ?></td>
						<td onclick="window.location.assign('https://wa.me/<?= $val->whatsapp ?>')"><?= $val->whatsapp ?></td>
						<?= (isAdmin()) ? '<td>'.sizeof($kelasnya). ' kelas</td>' : '' ?>
						<td class="text-center">
							<button class="m-1 btn btn-sm btn-primary"
								onclick="location.href='/dashboard/profile/<?= base64url_encode($val->user_id) ?>'">
								<i class="fa fa-user"></i>
							</button>
							<button class="btn btn-sm btn-danger" onclick="window.open('/dashboard/siswa/hapus/<?= $val->user_id ?>', '_self');//showConfirm(<?= $val->user_id ?>)">
								<i class="fa fa-trash"></i>
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
<!-- start - This is for export functionality only --
<script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
<!-- end - This is for export functionality only -->


<script>
	$(function () {
		$("#myTable").DataTable({
			"lengthChange": false
		});
	});

	const showConfirm = (a) => {
		Swal.fire({
			title: 'Hapus Siswa',
			text: 'Tindakan ini akan menghapus siswa ini dari seluruh kelas anda',
			showCancelButton: true,
			confirmButtonText: 'Hapus',
			cancelButtonText: 'Batal',
		}).then((result) => {
			/* Read more about isConfirmed, isDenied below */
			if (result.isConfirmed) {
				kickAjax({
					uid: a
				})
			}
		})
	}

	const kickAjax = (data) => {
		$(".preloader").fadeIn();
		$.ajax({
			url: '/admin/home/kickSiswa',
			method: 'post',
			data: data,
			dataType: 'json',
			success: (response) => {
				console.log(response)
				if (response.status != true) {
					showMsg('info', response.msg);
				} else {
					showMsg('success', 'Siswa telah dihapus!');
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