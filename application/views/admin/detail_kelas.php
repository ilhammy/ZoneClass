<div class="row page-titles">
	<div class="col-md-5 align-self-center">
		<h3 class="text-themecolor"><?= $data_kelas->nama_kelas ?></h3>
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="javascript:void(0)">Home</a>
			</li>
			<li class="breadcrumb-item">
				<a href="/dashboard">Dashboard</a>
			</li>
			<li class="breadcrumb-item">
				<a href="/dashboard/kelas">Kelas</a>
			</li>
			<li class="breadcrumb-item active"><?= $data_kelas->nama_kelas ?></li>
		</ol>
	</div>
	<div class="col-md-7 align-self-center">
		<button onclick="askDelete()" class="waves-effect waves-light pull-right btn btn-sm btn-danger"><i class="fa fa-trash"></i> Hapus</button>
	</div>
</div>
<!-- End Bread crumb and right sidebar toggle -->

<div class="row">
	<div class="col-md-6">
		<div class="card card-body mailbox">
			<h5 class="card-title">Detail Kelas</h5>

			<div class="alert alert-info <?= ($data_kelas->creator_id !== myUid() || isAdmin()) ? '' : 'd-none' ?>">
				Kelas ini bukan milik anda.
			</div>

			<?php $msg = validation_errors() . $this->session->flashdata('alert');
			if (!is_null($msg) && !empty($msg)) {
				echo '<div class="alert alert-info alert-rounded">' . $msg;
				echo '</div>';
			} ?>

			<form action="" method="POST" class="mt-4" id="form1">
				<div class="form-group">
					<label>Dibuat Pada : <?= date('d F Y', $data_kelas->dibuat) ?></label>
				</div>

				<div class="form-group">
					<label>Nama Kelas</label>
					<input
					value="<?= $data_kelas->nama_kelas ?>"
					type="text" class="form-control" id="input-nama" name="nama_kelas" autocomplete="off" required />
				</div>

				<div class="form-group">
					<label>Keterangan Singkat</label>
					<textarea class="form-control" name="des" rows="5" id="input-des" required><?= $data_kelas->tentang ?></textarea>
				</div>
				<button type="submit" class="waves-effect waves-light btn btn-info text-white" id="sb-form1" disabled="true"><i class="fa fa-check"></i> Update</button>
			</form>

		</div>
	</div>
	<!-- End Kiri -->
	<div class="col-md-6">
		<div class="card card-body mailbox">
			<h5 class="card-title">Daftar Siswa</h5>
			<div class="message-center" style="height: auto!important">
				<?php
				if (sizeof($data_siswa) == 0) echo '<div class="no-data">Tidak ada siswa</div>';

				foreach ($data_siswa as $d) :
				$val = $this->User_model->getByUid($d->id_user);
				?>
				<!-- Message -->
				<a href="#">
					<img src="<?= $val->foto ?>" class="rounded-circle" width="35" height="35" />
					<div class="mail-contnet">
						<h6 class="text-dark font-medium mb-0"><?= $val->fullname ?></h6>
						<span class="mail-desc">
							<?= timeago($d->bergabung) ?>
						</span>
					</div>
				</a>
				<?php endforeach ?>
			</div>
		</div>

	</div>
	<!-- End Kanan -->
</div>
<!-- End Row -->

<script>
	const idKelas = '<?= $data_kelas->id_kelas ?>';
	const dataOld = {
		'nama': '<?= $data_kelas->nama_kelas ?>',
		'des': '<?= $data_kelas->tentang ?>'
	}

	document.querySelector('#input-nama').oninput = (e) => {
		cekPerubahan(e.value);
	}
	document.querySelector('#input-des').oninput = (e) => {
		cekPerubahan(e.value);
	}

	const cekPerubahan = (newData) => {
		const btnSub = document.querySelector('#sb-form1');
		if (newData == dataOld.nama || newData == dataOld.des) {
			btnSub.disabled = true;
		} else {
			btnSub.disabled = false;
		}
	}

	const askDelete = () => {
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
				ajaxHapusKelas();
			}
		})
	}

	const ajaxHapusKelas = () => {
		$.ajax({
			url: atob('<?= base64_encode('/admin/home/hapus_kelas') ?>'),
			method: 'post',
			data: {
				kid: idKelas
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
					}, 3000);
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