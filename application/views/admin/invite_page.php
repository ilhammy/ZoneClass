<div class="row page-titles">
	<div class="col-md-5 align-self-center">
		<h3 class="text-themecolor">Kode Undangan</h3>
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="javascript:void(0)">Home</a>
			</li>
			<li class="breadcrumb-item active">Kode Undangan</li>
		</ol>
	</div>
	<div class="col-md-7 align-self-center">

	</div>
</div>
<!-- End Bread crumb and right sidebar toggle -->

<div class="row">
	<div class="col-md-4">

		<div class="card">
			<div class="card-body">
				<h4 class="card-title">Tambah Baru</h4>

				<?php $msg = validation_errors() . $this->session->flashdata('alert');
				if (!is_null($msg) && !empty($msg)) {
					echo '<div class="alert alert-info alert-rounded">' . $msg;
					echo '</div>';
				} ?>

				<form action="/admin/invite/tambahKode" method="POST" class="mt-4" id="form1">
					<div class="form-group">
						<label>Label</label>
						<input
						value="<?= set_value('label') ?>"
						type="text" class="form-control" name="label" autocomplete="off" required />
						<small class="form-text text-muted">
							Sebagai penanda agar mudah dicari
						</small>
					</div>

					<div class="form-group">
						<label>Kode Unik</label>
						<input
						value="<?= set_value('kode') ?>"
						type="text" class="form-control" name="kode" autocomplete="off" required />
						<small class="form-text text-muted">
							<button type="button" onclick="$('[name=kode]').val(randomText(6))" class="btn btn-sm btn-rounded btn-dark pull-right"><i class="fa fa-refresh"></i> Acak</button>
							Minimal 5 karakter dan maks 20 karakter
						</small>
					</div>

					<?php if (isAdmin()) : ?>
					<div class="form-group">
						<input
						type="checkbox" onclick="listenCb1(this)" class="form-check-input" name="forRegist" id="cb1" />
						<label class="form-check-label" for="cb1">Untuk pendaftaran</label>
					</div>
					<?php endif ?>

					<div class="form-group">
						<label>Kelas</label>
						<select class="custom-select" id="sel1" name="kelas" <?= (!isAdmin()) ? 'required' : '' ?>>
							<option value=""><== Pilih Kelas ==></option>
								<?php foreach ($kelasku as $val) {
									echo "<option value=\"$val->id_kelas\">$val->nama_kelas</option>";
								} ?>
							</select>
						</div>

						<div class="form-group">
							<label>Kuota</label>
							<input
							value="<?= (set_value('kuota')) ? set_value('kuota') : 1 ?>"
							type="number" oninput="listenKuota(this)" class="form-control" name="kuota" autocomplete="off" required />
							<small class="form-text text-muted">
								Minimal kuota 1
							</small>
						</div>

						<div class="form-group">
							<label>Kadaluwarsa</label>
							<input type="range" class="form-control-range"
							value="<?= (set_value('exp')) ? set_value('exp') : 1 ?>"
							min="1" name="exp" onInput="$('#rangeval').html($(this).val() + ' Hari')">
							<small class="form-text text-muted font-weight-bold" id="rangeval">1 Hari</small>
						</div>

						<div class="text-center">
							<button type="submit" class="btn btn-info fa fa-check"> Simpan</button>
						</div>
					</form>
				</div>
			</div>

		</div>
		<!-- End Col -->
		<div class="col-md-8">

			<div class="card">
				<div class="card-body">
					<h4 class="card-title">Semua Data</h4>
					<div class="table-responsive mt-2">
						<table
							id="myTable"
							class="table table-bordered table-striped nowrap table-hover">
							<thead>
								<tr>
									<th>#</th>
									<th>Label</th>
									<th>Kode</th>
									<th>Kelas<?= (isAdmin()) ? '/Tipe' : '' ?></th>
									<th>Dipakai</th>
									<th>Kadaluwarsa</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?php
								foreach ($mydata as $in => $val) :
								$kelasnya = null;
								if ($val->id_kelas !== -1) {
									$kelasnya = $this->Kelas->getSingle($val->id_kelas);
								}
								?>
								<tr>
									<td class="text-center"><?= $in + 1 ?></td>
									<td><b><?= $val->label ?></b></td>
									<td class="font-weight-bold"><?= $val->kode ?></td>
									<td class="text-center"><?= (is_null($kelasnya)) ? '<span class="badge badge-info">Register</span>' : $kelasnya->nama_kelas ?></td>
									<td class="text-center font-weight-bold"><?= $val->dipakai. '/' .$val->kuota ?></td>
									<td class="text-center <?= (isKadaluwarsa($val->exp)) ? 'text-danger' : '' ?>"><?= date('d/m/Y H:i', $val->exp) ?></td>

									<td class="text-center">
										<button class="btn btn-sm btn-primary m-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<i class="fa fa-ellipsis-v"></i>
										</button>

										<div class="dropdown-menu">
											<a class="dropdown-item" href="javascript:copyText('<?= $val->kode ?>');showMsg('success', 'Kode tersalin')"><i class="fa fa-clone"></i> Salin</a>
											<a class="dropdown-item" href="javascript:navigator.share({text: '<?= $val->kode ?>'})"><i class="fa fa-share"></i> Share</a>
											<a class="dropdown-item text-warning" href="javascript:resetKode('<?= $val->kode ?>')"><i class="fa fa-refresh"></i> Reset</a>
											<div class="dropdown-divider"></div>
											<a class="dropdown-item text-danger" href="javascript:showConfirm(<?= $val->id ?>)"><i class="fa fa-trash"></i> Hapus</a>
										</div>
									</td>
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>

		</div>
		<!-- End Col -->
	</div>
	<!-- End Row -->


	<!-- This is data table -->
	<script src="/assets/js/admin/jquery.dataTables.min.js"></script>
	<script src="/assets/js/admin/dataTables.responsive.min.js"></script>

	<script>
		$(function () {
			$("#myTable").DataTable({
				"lengthChange": false
			});
		});

		const showConfirm = (id) => {
			Swal.fire({
				title: 'Konfirmasi',
				text: 'Anda yakin akan menghapus item ini?',
				showCancelButton: true,
				confirmButtonText: 'Hapus',
				cancelButtonText: 'Batal',
			}).then((result) => {
				/* Read more about isConfirmed, isDenied below */
				if (result.isConfirmed) {
					Swal.fire('Saved!', '', 'success')
				} else if (result.isDenied) {
					Swal.fire('Changes are not saved', '', 'info')
				}
			})
		}

		const listenCb1 = (e) => {
			const s = document.querySelector('#sel1')
			s.disabled = e.checked
			s.value = ''
		}

		const listenKuota = (e) => {
			if (e.value == '0') e.value = 1
		}

		const resetKode = (a) => {
			Swal.fire({
				title: 'Reset Kode Undangan',
				text: 'Jumlah dipakai akan dikembalikan menjadi 0',
				showCancelButton: true,
				confirmButtonText: 'Reset',
				cancelButtonText: 'Batal',
			}).then((result) => {
				/* Read more about isConfirmed, isDenied below */
				if (result.isConfirmed) {
					resetAjax(a)
				}
			})
		}

		const resetAjax = (a) => {
			$(".preloader").fadeIn();
			$.ajax({
				url: '/admin/invite/aturUlang',
				method: 'post',
				data: {
					kjkl: a
				},
				dataType: 'json',
				success: (response) => {
					console.info(response)
					if (response.status != true) {
						showMsg('info', response.msg);
					} else {
						showMsg('success', 'Kode undangan berhasil direset!');
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