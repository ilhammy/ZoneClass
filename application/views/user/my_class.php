<div class="top-nav">
	<ion-icon class="icon" name="arrow-back-outline" onclick="window.localStorage.setItem('ref', 'profile');window.history.back()"></ion-icon>
	<div class="title" style="font-size: 1.1rem;font-weight: 600; padding: 0 .5rem">
	</div>
</div>

<div class="projects-section">
	<div class="projects-section-header">
		<p>
			Kelas Saya
		</p>
	</div>
	<div class="project-boxes jsListView pelangi">
		<?php
		if ($data_kelas == null) echo '<div class="no-data">Oops! kamu belum ikut kelas manapun nih :)</div>';

		foreach ($data_kelas as $val) : ?>
		<div class="project-box-wrapper">
			<div class="project-box">
				<div class="project-box-header">

					<div class="more-wrapper">
						<div class="days-left" style="margin: 15px 3px; font-size: 12px" onclick="keluarKelas(<?= $val->id_kelas ?>)">
							Keluar
						</div>
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

	function keluarKelas(kid) {
		Swal.fire({
			icon: 'question',
			title: 'Konfirmasi',
			text: 'Apakah kamu akan keluar dari kelas ini?',
			showDenyButton: true,
			confirmButtonText: 'Keluar',
			denyButtonText: 'Batal',
		}).then((result) => {
			if (result.isConfirmed) ajaxKeluarKelas(kid);
		});
	}

	function ajaxKeluarKelas(kid) {
		$.ajax({
			url: baseUrl + 'ajax/leaveClass',
			method: 'post',
			data: {
				classId: kid
			},
			dataType: 'json',
			success: function(response) {
				console.log(response)
				if (response.status != true) {
					showMsg('error', response.msg);
				} else {
					Swal.fire('Berhasil!', '', 'success')
					window.location.reload(true);
				}
			}
		});
	}
</script>