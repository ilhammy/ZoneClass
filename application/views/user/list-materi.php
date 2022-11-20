<link rel="stylesheet" href="/assets/css/user/page-listmat.css">
<link rel="stylesheet" href="/assets/css/user/action-panel.css?t=<?= time() ?>">

<div class="top-nav">
	<ion-icon class="icon" name="arrow-back-outline" onclick="window.localStorage.setItem('ref', 'kelas');window.open('/', '_self')"></ion-icon>
	<div class="title" style="font-size: 1.1rem;font-weight: 600; padding: 0 .5rem">
		<?= $data_kelas->nama_kelas ?>
	</div>
</div>

<div class="projects-section">
	<ol class="listmat p-0 m-0">
		<?php
		if ($data_materi == null) echo '<div class="no-data">Waduh materinya belum ada 😅</div>';
		foreach ($data_materi as $key => $val) : ?>
		<li onclick="openMat(<?= $key + 1 ?>)" style="--i: <?= $key ?>"><?= $val->judul ?></li>
		<?php endforeach ?>
	</ol>
</div>


<div class="st-actionContainer right-bottom">
	<div class="st-panel">
		<div class="st-panel-contents">
			<?php if ($data_kelas->hasAkses) :
			echo "Kelas ini memiliki Akses Khusus untuk Tools tambahan,
			silahkan klik tombol dibawah ini untuk mendapatkan aksesnya<br /><br />
			<div class=\"text-center\">
				<button onclick=\"openWa()\" class=\"btn btn-primary\">Request Akses</button>
			</div>";
			else :
			echo 'Kelas ini tidak memiliki Akses Khusus apapun, silahkan cek lagi di lain waktu';
			endif; ?>
		</div>
	</div>
	<div class="st-btn-container right-bottom" style="<?= $data_kelas->hasAkses ? 'background: #0288d1' : null ?>">
		<div class="st-button-main">
			<i class="fa fa-paper-plane" aria-hidden="true"></i>
		</div>
	</div>
</div>

<script src="/assets/js/user/action-panel.js?t=<?= time() ?>"></script>

<script>
	document.title = '<?= $data_kelas->nama_kelas ?>'
	const simput = document.querySelector(".search-input");
	$('st-actionContainer').launchBtn( {
		openDuration: 500, closeDuration: 300
	});
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
	
	const openWa = () => {
		const user = '<?= profileValue('fullname') ?>'
		const kelas = '<?= $data_kelas->nama_kelas ?>'
		const kontak = '<?= $data_kelas->kontak ?>'
		const text = `Hallo, nama saya *${user}*, Peserta Kelas *${kelas}*, Saya ingin mengajukan Request Akses Khusus untuk Tools Tambahan, sebagai alat penunjang proses pembelajaran saya. Terimakasih`
		window.location.href = 'https://wa.me/' + kontak + '?text=' + encodeURI(text)
	}
</script>