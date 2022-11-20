<div class="projects-section">
	<div class="projects-section-header">
		<p>
			Kelas Yang Tersedia
		</p>
	</div>
	<div class="project-boxes jsListView pelangi">
		<?php
		if ($data_kelas == null) echo '<div class="no-data">Oops! kelasnya belum ada nih :)</div>';

		$dk = array();
		foreach ($data_kelas as $v) {
			if (!$this->Kelas_model->cekUserInClass(myUid(), $v->id_kelas)) {
				array_push($dk, $v);
			}
		}

		if (empty($dk) && !is_null($data_kelas)) echo '<div class="no-data">Oops! kamu sudah ikut di semua kelas yang tersedia :)</div>';

		foreach ($dk as $val) : ?>
		<div class="project-box-wrapper">
			<div class="project-box">
				<div class="project-box-header">

					<div class="more-wrapper">
						<?php if (!$this->Kelas_model->cekUserInClass($this->session->userdata('uid'), $val->id_kelas)) : ?>
						<!-- div class="days-left" style="margin: 15px 3px; font-size: 12px" onclick="ikutKelas(this, <?= $val->id_kelas ?>)" -->
						<div class="days-left" style="margin: 10px 5px; font-size: 12px; background: transparent;" onclick="infoKelas(<?= $val->id_kelas ?>, '<?= $val->nama_kelas ?>', '<?= $val->tentang ?>')">
							<ion-icon name="eye" style="font-size: 24px;color: #6772e5"></ion-icon>
						</div>
						<?php endif; ?>
					</div>
				</div>
				<div class="project-box-content-header">
					<p class="box-content-header" style="font-size: 14px; padding-bottom: 7px">
						<?= $val->nama_kelas ?>
					</p>
					<p class="box-content-subheader">
						<ion-icon name="person"></ion-icon> <?= $val->pengurus ?>
					</p>
				</div>
			</div>
		</div>
		<?php endforeach ?>
	</div>
</div>

<script>
	var simput = document.querySelector(".search-input");
	function search() {
		const pattern = simput.value.toLowerCase();
		if (simput.length < 1) return;
		let targetId = "";

		let divs = document.querySelectorAll(".project-box");
		for (let i = 0; i < divs.length; i++) {
			let para = divs[i].querySelector(".box-content-header");
			let index = para.innerText.toLowerCase().indexOf(pattern);
			if (index !== -1) {
				targetId = divs[i].parentNode.id;
				divs[i].scrollIntoView();
				break;
			}
		}
	}
	simput.addEventListener('input', search);

	var infoKelas = (id, name, url) => {
		if (url == '' || url.length < 1 || !url.includes('http')) url = null
		Swal.fire({
			title: 'Kelas ' +name,
			html: 'Silahkan pilih tindakan',
			showDenyButton: true,
			focusConfirm: false,
			confirmButtonText: 'Info Lengkap',
			denyButtonText: 'Masuk',
			customClass: {
				popup: 'radius-8r'
			},
		}).then(result => {
			if (result.isConfirmed) {
				if (url == null) {
					showMsg('warning', 'Tidak ada info lengkap tentang kelas ini')
				} else {
					window.open(url, '_blank').focus()
				}
			} else if (result.isDenied) {
				enterCode(id, name);
			}
		})
	}

	var enterCode = (kid, name) => {
		Swal.fire({
			title: name,
			input: 'text',
			inputLabel: 'Masukan Kode Undangan',
			showCancelButton: true,
			confirmButtonText: 'Ikut',
			cancelButtonText: 'Batal',
			focusConfirm: false,
			customClass: {
				popup: 'radius-8r'
			},
			preConfirm: (val) => {
				if (!val) {
					Swal.showValidationMessage('Masukan kode undangan!')
				}
				return {
					kode: val
				}
			}
		}).then((result) => {
			//alert(result.value.kode);
			gabungKelas({
				id: kid,
				kode: result.value.kode
			});
		})
	}

	var gabungKelas = (data) => {
		$.ajax({
			url: baseUrl + 'ajax/joinClass',
			method: 'post',
			data: {
				classId: data.id,
				code: data.kode
			},
			dataType: 'json',
			success: function(response) {
				console.log(response)
				if (response.status !== true) {
					showMsg('error', response.msg);
				} else {
					Swal.fire('Berhasil!', '', 'success')
					loadPage('kelas');
				}
			}
		});
	}
</script>