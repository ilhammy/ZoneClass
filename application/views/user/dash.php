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
						<div class="days-left" style="margin: 15px 3px; font-size: 12px" onclick="infoKelas(<?= $val->id_kelas ?>, '<?= $val->nama_kelas ?>', '<?= base64_encode(nl2br($val->tentang)) ?>')">
							Info Lengkap
						</div>
						<?php endif; ?>
					</div>
				</div>
				<div class="project-box-content-header">
					<p class="box-content-header">
						<?= $val->nama_kelas ?>
					</p>
					<p class="box-content-subheader">
						<?= $val->tentang ?>
					</p>
				</div>
			</div>
		</div>
		<?php endforeach ?>
	</div>
</div>

<script>
	let simput = document.querySelector(".search-input");
	simput.addEventListener('input', search);

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

	const infoKelas = (id, name, about) => {
		Swal.fire({
			title: name,
			icon: 'info',
			html: atob(about),
			showCancelButton: true,
			focusConfirm: false,
			confirmButtonText: 'Ikut Kelas',
			cancelButtonText: 'Tutup',
		}).then(result => {
			if (result.isConfirmed) enterCode(id, name);
		})
	}

	const enterCode = (kid, name) => {
		Swal.fire({
			title: name,
			input: 'text',
			inputLabel: 'Masukan Kode Undangan',
			showCancelButton: true,
			confirmButtonText: 'Ikut',
			cancelButtonText: 'Batal',
			focusConfirm: false,
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

	const enterCodes = (kid) => {
		Swal.fire({
			title: 'Ikut Kelas',
			type: 'text',
			html: '<input type="text" id="kk" class="swal2-input" placeholder="Kode Kelas">',
			confirmButtonText: 'Ikut',
			focusConfirm: false,
			preConfirm: () => {
				const kode = Swal.getPopup().querySelector('#kk').value
				if (!kode) {
					Swal.showValidationMessage('Masukan kode kelas')
				}
				return {
					kode: kode
				}
			}
		}).then((result) => {
			gabungKelas({
				id: kid,
				kode: result.value.kode
			});
		})
	}

	const gabungKelas = (data) => {
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