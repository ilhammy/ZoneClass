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
			Buat Kelas
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
				$alert= $this->session->flashdata('alert');
				if (!is_null($alert)) echo "<div class=\"alert alert-info mb-2\">$alert</div>";
				
				if ($data_kelas_pending == null) echo '<div class="no-data">Tidak ada data</div>';

				foreach ($data_kelas_pending as $val) :
				$ikon = ($val->status == 0) ? 'fa-clock-o text-primary' : 'fa-times-circle text-danger';
				?>
				<!-- Message -->
				<a id_kelas="<?= $val->id_kelas ?>" onclick="<?= (!isAdmin()) ? 'window.location.assign(\'/dashboard/kelas/'.$val->id_kelas.'\')' : 'aksi1(this)' ?>">
					<div class="btn <?= ($val->status == 0) ? 'btn-primary' : 'btn-danger' ?> btn-circle">
						<i class="fa fa-graduation-cap"></i>
					</div>
					<div class="mail-contnet">
						<h6 class="text-dark font-medium mb-0"><?= $val->nama_kelas ?></h6>
						<span class="mail-desc <?= ($val->status == 2) ? 'text-danger' : '' ?>">
							<?php
							if (isAdmin()) {
								echo timeago($val->dibuat);
							} else {
								echo ($val->status == 0) ? 'Menunggu persetujuan..' : 'Ditolak!';
							}
							?>
						</span>
					</div>
					<div class="btn p-1" style="position: absolute">
						<i class="fa <?= $ikon ?>"></i>
					</div>
				</a>
				<?php endforeach ?>
			</div>
		</div>
	</div>
	<!-- End Kiri -->
	<div class="col-md-6">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title">Kelas Saya</h4>
				<div class="table-responsive mt-2">
					<table id="myTable" class="table table-bordered table-striped nowrap table-hover">
						<thead>
							<tr>
								<th>#</th>
								<th>Nama Kelas</th>
								<th>Akses Khusus</th>
								<th>Total Siswa</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php
							foreach ($data_kelas as $key => $val) :
							$siswanya = $this->Kelas_model->getAllSiswaByKelas($val->id_kelas);
							?>
							<tr>
								<td><?= $key + 1 ?></td>
								<td><?= $val->nama_kelas ?></td>
								<td class="text-center"><?= $val->hasAkses ? 'Ya' : 'Tidak' ?></td>
								<td class="text-center"><?= sizeof($siswanya) ?></td>
								<td class="text-center">
									<button class="btn btn-sm btn-primary" onclick="window.location.href='/dashboard/kelas/<?= $val->id_kelas ?>'">
										<i class="fa fa-pencil"></i>
									</button>
									<button class="btn btn-sm btn-danger m-1" type="button" onclick="hapusKelas(<?= $val->id_kelas ?>)">
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


	</div>
	<!-- End Kanan -->
</div>
<!-- End Row -->

<form action="" method="post" class="d-none" id="form1">
	<input type="hidden" name="kelid" id="form-kelid" />
	<input type="hidden" name="status" id="form-status" />
</form>

<!-- sample modal content -->
<div id="modal1" class="modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">
					Tentang Kelas
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
	$(function () {
		$("#myTable").DataTable({
			"lengthChange": false
		});
	});
	
	const setModal1 = (a) => {
		$('#modal1 .modal-body').html(atob(a))
	}

	const aksi1 = (e) => {
		//console.log(e.getAttribute('id_kelas'))
		Swal.fire({
			title: 'Pilih Tindakan',
			showDenyButton: true,
			showCancelButton: true,
			confirmButtonText: 'Setujui',
			denyButtonText: `Tolak`,
			cancelButtonText: `Batal`,
		}).then((result) => {
			/* Read more about isConfirmed, isDenied below */
			if (result.isConfirmed) {
				fillForm(e.getAttribute('id_kelas'), 1);
			} else if (result.isDenied) {
				fillForm(e.getAttribute('id_kelas'), 2);
			}
		})
	}

	const fillForm = (a, b) => {
		document.querySelector('#form-kelid').value = a;
		document.querySelector('#form-status').value = b;
		document.querySelector('#form1').submit();
	}
	
	const hapusKelas = (id) => {
		Swal.fire({
			title: 'konfirmasi',
			text: "Anda ingin menghapus kelas ini?",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Ya',
			cancelButtonText: 'Tidak'
		}).then((result) => {
			if (result.isConfirmed) {
				$(".preloader").fadeIn();
				ajaxHapusKelas(id);
			}
		})
	}

	const ajaxHapusKelas = (id) => {
		$.ajax({
			url: atob('<?= base64_encode('/admin/home/hapus_kelas') ?>'),
			method: 'post',
			data: {
				kid: id
			},
			dataType: 'json',
			success: (response) => {
				console.log(response)
				if (response.status != true) {
					showMsg('error', response.msg)
				} else {
					showMsg('success', 'Kelas telah dihapus!')
					setTimeout(() => {
						location.href = '/dashboard/kelas'
					}, 2000);
				}
			},
			complete: () => {
				$(".preloader").fadeOut();
			},
			error: () => {
				showMsg('error', 'Terjadi kesalahan sistem!')
			}
		});
	}
</script>