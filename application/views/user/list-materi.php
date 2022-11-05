<link rel="stylesheet" href="/assets/css/user/page-listmat.css?t=<?= time() ?>">

<div class="top-nav">
	<ion-icon class="icon" name="arrow-back-outline" onclick="window.localStorage.setItem('ref', 'kelas');window.history.back()"></ion-icon>
	<div class="title" style="font-size: 1.1rem;font-weight: 600; padding: 0 .5rem">
		<?= $data_kelas->nama_kelas ?>
	</div>
</div>

<div class="projects-section">
	<ol class="listmat">
		<?php
		if ($data_materi == null) echo '<div class="no-data">Waduh materinya belum ada 😅</div>';
		foreach ($data_materi as $key => $val) : ?>
		<li onclick="openMat(<?= $val->id ?>)" style="--i: <?= $key ?>"><?= $val->judul ?></li>
		<?php endforeach ?>
	</ol>
</div>

<script>
	document.title = '<?= $data_kelas->nama_kelas ?>'
	const simput = document.querySelector(".search-input");
	simput.addEventListener('input', search);

	function search() {
		const pattern = simput.value.toLowerCase();
		if (simput.length < 1) return;
		let targetId = "";

		let divs = document.querySelectorAll(".listmat li");
		for (let i = 0; i < divs.length; i++) {
			let para = divs[i].innerText;
			let index = para.toLowerCase().indexOf(pattern);
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
	
	const openMat = (id) => {
		let crr = window.location.href
		window.location.href = crr + '/' + id
	}
</script>