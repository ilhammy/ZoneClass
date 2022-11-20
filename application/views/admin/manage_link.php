<div class="row page-titles">
	<div class="col-md-5 align-self-center">
		<h3 class="text-themecolor">Kelola Link</h3>
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="javascript:void(0)">Home</a>
			</li>
			<li class="breadcrumb-item active">Kelola Link</li>
		</ol>
	</div>
	<div class="col-md-7 align-self-center">
		<button class="btn
			waves-effect waves-light
			btn btn-info
			pull-right text-white"
			onclick="window.location.assign('/dashboard/manage_link/tambah')">
			<i class="fa fa-plus"></i> Buat Link
		</button>
	</div>
</div>
<!-- End Bread crumb and right sidebar toggle -->

<div class="card">
	<div class="card-body">
		<h4 class="card-title">Semua Link</h4>
		<div class="table-responsive mt-2">
			<table id="myTable" class="table table-bordered table-striped nowrap table-hover">
				<thead>
					<tr>
						<th><i class="fa fa-sort-numeric-asc"></i></th>
						<th>Nama Kelas</th>
						<th>Nama Guru</th>
						<th>Link</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach ($semuakelas as $key => $val) :
					?>
					<tr>
						<td class="text-center"><?= $key + 1 ?></td>
						<td><?= $val->nama_kelas ?></td>
						<td><?= $val->pengurus ?></td>
						<td class="text-center"><a href="<?= $val->tentang ?>" class="btn btn-sm btn-info waves-light waves-effect" target="_blank"><i class="fa fa-eye"></i></a></td>
						<td class="text-center">
							<button class="btn btn-sm btn-primary" onclick="editLink(<?= $val->id_kelas. ', \'' .$val->nama_kelas ?>', '<?= base64_encode($val->tentang) ?>')">
								<i class="fa fa-pencil"></i>
							</button>
							<button class="btn btn-sm btn-danger m-1" type="button" onclick="hapusLink(<?= $val->id_kelas ?>)">
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

<script>
	$(function () {
		$("#myTable").DataTable({
			"lengthChange": false
		});
	});

	const setModal1 = (a) => {
		$('#modal1 .modal-body').html(atob(a))
	}

	const hapusLink = (id) => {
		Swal.fire({
			title: 'konfirmasi',
			text: "Anda ingin menghapus link ini?",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Ya',
			cancelButtonText: 'Tidak'
		}).then((result) => {
			if (result.isConfirmed) {
				$(".preloader").fadeIn();
				ajaxHapusLink(id);
			}
		})
	}

	const ajaxHapusLink = (id) => {
		$.ajax({
			url: atob('<?= base64_encode('/admin/kelasm/hapus_link') ?>'),
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
					showMsg('success', 'Link telah dihapus!')
					setTimeout(() => {
						location.href = '/dashboard/manage_link'
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

	const editLink = (id, name, url) => {
		Swal.fire({
			title: 'Kelas ' + name,
			text: 'Edit link',
			input: 'url',
			inputValue: atob(url),
			inputAttributes: {
				autocapitalize: 'off'
			},
			showCancelButton: true,
			confirmButtonText: 'Simpan',
			showLoaderOnConfirm: true,
			preConfirm: (link) => {
				const headers = new Headers({
					'Content-Type': 'application/x-www-form-urlencoded'
				});
				const urlencoded = new URLSearchParams({
					kelas: id,
					link: link
				});
				const opts = {
					method: 'POST',
					headers: headers,
					body: urlencoded,
				};
				console.info(opts)

				return fetch('/admin/kelasm/editLink', opts)
				.then(response => {
					if (!response.ok) {
						throw new Error(response.msg)
					}
					return response.json()
				})
				.catch(error => {
					Swal.showValidationMessage(
						`Request failed: ${error}`
					)
				})
			},
			allowOutsideClick: () => !Swal.isLoading()
		}).then((result) => {
			if (result.isConfirmed) {
				showMsg(result.value.status ? 'success': 'error', result.value.msg)
				if (result.value.status) {
					setTimeout(() => {
						location.reload(true)
					}, 2000);
				}
			}
		})
	}
</script>