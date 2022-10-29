<?php
$ttl = profileValue('tgl_lahir');
$ttl = date('Y-m-d', $ttl);
if ($ttl == 0) $ttl = null;
?>

<div class="row page-titles">
	<div class="col-md-5 align-self-center">
		<h3 class="text-themecolor">Pengaturan</h3>
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="/dashboard">Dashboard</a>
			</li>
			<li class="breadcrumb-item active">Pengaturan</li>
		</ol>
	</div>
	<div class="col-md-7 align-self-center">
	</div>
</div>
<!-- End Bread crumb and right sidebar toggle -->

<div class="card">

	<ul class="nav nav-tabs profile-tab" role="tablist">
		<li class="nav-item">
			<a class="nav-link active" data-toggle="tab" href="#profile" role="tab">Profile</a>
		</li>
		<?php if (isAdmin()) : ?>
		<li class="nav-item">
			<a class="nav-link" data-toggle="tab" href="#website" role="tab">Website</a>
		</li>
		<?php endif ?>
	</ul>

	<?= ($this->session->flashdata('alert')) ? '<div class="alert alert-success m-2">' .$this->session->flashdata('alert'). '</div>' : null ?>

	<!-- Tab panes -->
	<div class="tab-content tabcontent-border">
		<div class="tab-pane active" id="profile" role="tabpanel">
			<div class="card-body">

				<div class="row">
					<div class="col-md-6">
						<div class="form-group text-center">
							<img src="<?= profileValue('foto') ?>" id="imgProf" onclick="pickPhoto()" class="rounded-circle shadow-sm" width="150" height="150" />
						</div>

						<form action="" method="post" class="form-horizontal form-material">
							<div class="form-group">
								<label>Nama Lengkap</label>
								<input
								type="text" value="<?= profileValue('fullname') ?>" name="fname" class="form-control form-control-line" autocomplete="off" required />
							</div>
							<div class="form-group">
								<label>Nomor WhatsApp</label>
								<input
								type="number" value="<?= profileValue('whatsapp') ?>" name="whatsapp" class="form-control form-control-line" autocomplete="off" required />
							</div>
							<div class="form-group">
								<label>Jenis Kelamin</label>
								<select name="kel" class="form-control form-control-line" required>
									<option value="Pria" <?= (profileValue('kelamin') === 'Pria')? 'selected' : '' ?>>Pria</option>
									<option value="Wanita" <?= (profileValue('kelamin') !== 'Pria')? 'selected' : '' ?>>Wanita</option>
								</select>
							</div>
							<div class="form-group">
								<label>Tanggal Lahir</label>
								<input
								type="date" value="<?= $ttl ?>" name="ttl" class="form-control-line form-control" style="border-bottom: 1px solid #f6f9ff;" autocomplete="off" required />
								<hr></hr>
						</div>

						<div class="form-group text-center">
							<button type="submit" class="btn btn-sm waves-effect waves-light btn-info">
								<i class="fa fa-check"></i> Update Profile
							</button>
						</div>
						<input type="hidden" name="profile" value="ok" />
					</form>
				</div>
				<!-- End Col -->

				<div class="col-md-6">
					<h4 class="card-title">Email Akun</h4>
					<form action="" method="post" class="form-horizontal form-material" id="form-email">
						<div class="form-group">
							<label>Email</label>
							<input
							type="email" value="<?= dataUserValue('email') ?>" oninput="hasEmail(this)" name="email" class="form-control form-control-line" autocomplete="off" required />
							<small class="form-text text-muted"></small>
						</div>

						<div class="form-group text-center">
							<button type="submit" class="btn btn-sm waves-effect waves-light btn-success" id="btn-sub-mail" disabled>
								<i class="fa fa-check"></i> Update Email
							</button>
						</div>
						<input type="hidden" name="profile-email" value="ok" />
					</form>


					<h4 class="card-title">Password Akun</h4>
					<form action="" method="post" class="form-horizontal form-material">
						<div class="form-group">
							<label>Password Lama</label>
							<input
							type="password" name="pass1" class="form-control form-control-line" autocomplete="off" required />
						</div>
						<div class="form-group">
							<label>Password Baru</label>
							<input
							type="text" name="pass2" class="form-control form-control-line" autocomplete="off" required />
						</div>

						<div class="form-group text-center">
							<button type="submit" class="btn btn-sm waves-effect waves-light btn-primary">
								<i class="fa fa-check"></i> Update Password
							</button>
						</div>
						<input type="hidden" name="profile-password" value="ok" />
					</form>
				</div>
				<!-- End Col -->
			</div>
			<!-- End Row -->


		</div>
	</div>

	<?php if (isAdmin()) : ?>
	<div class="tab-pane" id="website" role="tabpanel">
		<div class="card-body">
			<form action="" method="post" class="form-horizontal form-material">
				<div class="form-group">
					<label>Config Website</label>
					<textarea rows="15" class="form-control form-control-line" name="web_set"><?= $webCnf ?></textarea>
					<small class="form-text text-muted">
						* Tipe data <b>true</b> atau <b>false</b> tidak perlu tanda petik<br />
						* Jangan ada <b>Enter</b> di dalam tanda petik dan yang lainnya<br />
						* Simbol <b>;</b> (titik koma) jangan sampai terhapus
					</small>
				</div>
				<div class="form-group text-center">
					<button type="submit" class="btn btn-sm waves-effect waves-light btn-primary">
						<i class="fa fa-check"></i> Update
					</button>
				</div>
				<input type="hidden" name="web" value="ok" />
			</form>
		</div>
	</div>
	<?php endif ?>

</div>

<!-- Foto Form -->
<form class="hide" action="/admin/settings/uploadFoto" method="POST" enctype="multipart/form-data" id="form-upload-foto">
	<input type="file" onchange="readURL(this)" name="fileFoto" accept="image/jpeg" id="input-upload" />
	<input type="hidden" name="upload_prof" value="true">
</form>

<script>
	const postAjax = (data) => {
		$(".preloader").fadeIn();
		$.ajax({
			url: '/admin/materi/tambah_materi',
			method: 'post',
			data: data,
			dataType: 'json',
			success: (response) => {
				console.log(response)
				if (response.status != true) {
					showMsg('info', response.msg);
				} else {
					showMsg('success', 'Materi telah diposting!');
					setTimeout(() => {
						location.reload(true)
					}, 3000);
				}
			},
			complete: () => $(".preloader").fadeOut(),
			error: () => showMsg('info', 'Server error!')
		});
	}

	const pickPhoto = () => {
		document.querySelector('#input-upload').click();
	}

	const readURL = (input) => {
		let url = input.value;
		let ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();

		if (!(ext.includes("jpeg") || ext.includes("jpg"))) {
			showMsg('warning', 'Hanya mendukung ekstensi jpg');
			return;
		}
		if (input.files && input.files[0]) {
			let reader = new FileReader();
			reader.onload = function (e) {
				previewAvatar(e.target.result);
			}
			reader.readAsDataURL(input.files[0]);
		}
	}

	const previewAvatar = (img) => {
		Swal.fire({
			title: 'Preview',
			imageUrl: img,
			imageHeight: 300,
			imageWidth: 300,
			imageAlt: 'Preview Foto Profil',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Simpan',
			cancelButtonText: 'Batal',
			timerProgressBar: true,
		}).then((result) => {
			if (result.isConfirmed) {
				document.querySelector('#form-upload-foto').submit();
			}
		})
	}

	const hasEmail = async (e) => {
		const btn = document.querySelector('#btn-sub-mail');
		const disp = document.querySelector('#form-email small');
		if (!ValidateEmail(e.value)) {
			btn.disabled = true
			disp.innerHTML = '<font class="text-danger">Format email salah!</font>'
			return;
		}
		let response = await fetch(atob('<?= base64_encode('/ajax/cekEmail?mail=') ?>') + btoa(e.value));

		if (response.ok) {
			let rs = await response.text();
			if (rs === 'true') {
				btn.disabled = false
				disp.innerHTML = '<font class="text-success">Email tersedia!</font>'
			} else {
				btn.disabled = true
				disp.innerHTML = '<font class="text-danger">Email tidak tersedia!</font>'
			}
		} else {
			showMsg('error', "HTTP-Error: " + response.status);
		}
	}

	const ValidateEmail = (input) => {
		let validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
		return (input.match(validRegex)) ? true: false
	}

</script>