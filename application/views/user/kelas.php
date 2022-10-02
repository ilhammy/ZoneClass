<div class="projects-section">
	<div class="projects-section-header">
		<p>
			Kelas Yang Tersedia
		</p>
	</div>
	<div class="project-boxes jsListView pelangi">
		<?php 
		if ($data_kelas == null) echo '<div class="no-data">Oops! kelasnya belum ada nih :)</div>';
		
		foreach ($data_kelas as $val) : ?>
		<div class="project-box-wrapper">
			<div class="project-box">
				<div class="project-box-header">
					
					<div class="more-wrapper">
						<div class="days-left" style="margin: 15px 3px; font-size: 12px" onclick="ikutKelas(this, <?= $val->id_kelas ?>)">
							<?= ($this->Kelas_model->cekUserInClass($this->session->userdata('uid'), $val->id_kelas)) ? "Keluar" : "Gabung"; ?>
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
