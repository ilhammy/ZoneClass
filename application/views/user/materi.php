<div class="top-nav">
	<ion-icon class="icon" name="arrow-back-outline" onclick="window.localStorage.setItem('ref', 'kelas');window.history.back()"></ion-icon>
	<div class="title" style="font-size: 1.1rem;font-weight: 600; padding: 0 .5rem">
		<?= $data_kelas->nama_kelas ?>
	</div>
</div>

<div class="projects-section">
	<div class="project-boxes jsListView" style="flex-direction: column">
		<?php
		if ($data_materi == null) echo '<div class="no-data">Waduh materinya belum ada 😅</div>';
		foreach ($data_materi as $val) : ?>
		<div class="project-box-wrapper">
			<div class="project-box list-materi" id="<?= $val->waktu ?>">
				<div class="list-materi-header">
					<p class="list-materi-judul">
						<?= $val->judul ?>
					</p>
				</div>
				<?php
				if (!is_null($val->foto)) {
					echo "<center><img onclick=\"openImage('{$val->foto}')\" title=\"{$val->judul}\" src=\"{$val->foto}\" class=\"thumb\" /></center>";
				} else if (!is_null($val->youtube)) {
					echo "<center><iframe type=\"text/html\" src=\"https://www.youtube.com/embed/{$val->youtube}\" frameborder=\"0\" allowFullScreen></iframe></center>";
				} else if (!is_null($val->link)) {
					$links = json_decode($val->link);
					echo '<div class="list-materi-links">';
					foreach ($links as $d) {
						echo "<a href=\"{$d->url}\" target=\"_blank\" title=\"{$d->name}\">{$d->name}</a>";
					}
					echo '</div>';
				} else if (!is_null($val->teks)) {
					echo "<div class=\"list-materi-caption\">". nl2br($val->teks, true). "</div>";
				} ?>
			</div>
		</div>
		<?php endforeach ?>
	</div>
	<br />
	<br />
	<br />
</div>

<script>
	document.title = '<?= $data_kelas->nama_kelas ?>'
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

	const openImage = (url) => {
		let lightbox = new FsLightbox();
		lightbox.props.sources = [url];
		lightbox.open();
	}
</script>