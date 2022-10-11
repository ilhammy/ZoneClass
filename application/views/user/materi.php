<div class="projects-section">
	<div class="projects-section-header">
		<p>
			<?= $data_kelas->nama_kelas ?>
		</p>
	</div>
	<div class="project-boxes jsGridView">
		<?php
		if ($data_materi == null) echo '<div class="no-data">Waduh materinya belum ada 😅</div>';
		foreach ($data_materi as $val) : ?>
		<div class="project-box-wrapper">
			<div class="project-box list-materi" id="<?= $val->waktu ?>">
				<?php if (!(is_null($val->foto) && is_null($val->youtube))) : ?>
				<img title="<?= $val->judul ?>" src="<?= (is_null($val->foto)) ? 'https://i.ytimg.com/vi/' . $val->youtube . '/mqdefault.jpg' : $val->foto ?>" class="thumb" />
				<?php
				endif;
				if (!is_null($val->link)) :
				$links = json_decode($val->link);
				echo '<div class="list-materi-links">';
				foreach ($links as $d) : ?>
				<a href="<?= $d->url ?>" target="_blank" title="<?= $d->name ?>"><?= $d->name ?></a>
				<?php
				endforeach;
				echo '</div>';
				endif ?>
				<div class="list-materi-caption" style="<?= (is_null($val->foto) && is_null($val->youtube)) ? 'margin-top: .5rem' : null ?>">
					<?= $val->teks ?>
				</div>
				<div class="list-materi-footer">
					<p class="list-materi-judul">
						<?= $val->judul ?>
					</p>
				</div>
			</div>
		</div>
		<?php endforeach ?>
	</div>
</div>

<script>
	const simput = document.querySelector(".search-input");
	simput.addEventListener('input', search);
	
	function search() {
		const pattern = simput.value.toLowerCase();
		if (simput.length < 1) return;
		let targetId = "";

		let divs = document.querySelectorAll(".list-materi");
		for (let i = 0; i < divs.length; i++) {
			let para = divs[i].querySelector(".list-materi-judul");
			let index = para.innerText.toLowerCase().indexOf(pattern);
			if (index !== -1) {
				targetId = divs[i].parentNode.id;
			console.log(index + ' => ' + targetId)
				//document.getElementById(targetId).scrollIntoView();
				divs[i].scrollIntoView();
				break;
			}
		}
	}
</script>