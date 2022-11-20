<form class="hide" action="" method="POST" enctype="multipart/form-data" id="form-upload-foto">
	<input type="file" onchange="readURL(this)" name="fileFoto" accept="image/jpeg" id="input-upload" />
	<input type="hidden" name="upload_prof" value="true">
</form>

<div class="profile-box">
	<div class="profile-box-header">
		<img src="<?= profileValue('foto') ?>" class="foto" />
		<h1><?= profileValue('fullname') ?></h1>
		<h2><?= $this->session->userdata('username') ?></h2>
	</div>

	<div class="profile-box-menus">
		<a href="/settings/rekening">
			<ion-icon name="card-outline" class="icon"></ion-icon>
			<span class="name">Rekening</span>
			<ion-icon name="chevron-forward-outline" class="arrow"></ion-icon>
		</a>
		<a href="javascript:pickPhoto()">
			<ion-icon name="camera-outline" class="icon"></ion-icon>
			<span class="name">Ubah Foto Profile</span>
			<ion-icon name="chevron-forward-outline" class="arrow"></ion-icon>
		</a>
		<a href="/settings/profile">
			<ion-icon name="settings-outline" class="icon"></ion-icon>
			<span class="name">Atur Profile</span>
			<ion-icon name="chevron-forward-outline" class="arrow"></ion-icon>
		</a>
		<a href="/settings/set_password">
			<ion-icon name="lock-closed-outline" class="icon"></ion-icon>
			<span class="name">Ubah Kata Sandi</span>
			<ion-icon name="chevron-forward-outline" class="arrow"></ion-icon>
		</a>
		<a href="/logout">
			<ion-icon name="log-out-outline" class="icon"></ion-icon>
			<span class="name">Log Out</span>
			<ion-icon name="chevron-forward-outline" class="arrow"></ion-icon>
		</a>
	</div>
</div>

<script>
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

	/*async function uploadFoto() {
		let formData = new FormData();
		formData.append("file",
			inputAv.files[0]);
		await fetch('ajax/up_prof',
			{
				method: "POST",
				body: formData
			})
		.then(res => res.json())
		.then(data => {
			if (data.ok) {
				showMsg('success', 'Foto profile berhasil diubah');
			} else {
				showMsg('error', data.msg);
			}
		})
		.catch(err => {
			console.log(err);
		});
	}*/

</script>