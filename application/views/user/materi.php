<div class="projects-section">
	<div class="projects-section-header">
		<p>
			<?= $data_kelas->nama_kelas ?>
		</p>
	</div>
	<div class="project-boxes jsListView pelangi">
		<?php 
		if ($data_materi == null) echo '<div class="no-data">Waduh materinya belum ada 😅</div>';
		foreach ($data_materi as $val) : ?>
		<div class="project-box-wrapper">
			<div class="project-box">
				<div class="project-box-header">
					
					<div class="more-wrapper">
						<div class="days-left" style="margin: 15px 3px; font-size: 12px">
							Unduh
						</div>
					</div>
				</div>
				<div class="project-box-content-header">
					<p class="box-content-header">
						<?= $val->judul ?>
					</p>
					<p class="box-content-subheader">
						<?= $val->teks ?>
					</p>
				</div>
			</div>
		</div>
		<?php endforeach ?>
	</div>
</div>
