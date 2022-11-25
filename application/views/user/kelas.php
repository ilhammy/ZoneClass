<style>
	.project-boxes.jsGridView .project-box-wrapper {
		width: 50%;
	}
</style>

<div class="projects-section">
	<div class="projects-section-header">
		<p>
			Kelas Saya
		</p>
		<p class="time">
			<?= date('F, d') ?>
		</p>
	</div>
	<div class="projects-section-line">
		<div class="projects-status"></div>
		<div class="view-actions">
			<button class="view-btn list-view" title="List View">
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-list">
					<line x1="8" y1="6" x2="21" y2="6" />
					<line x1="8" y1="12" x2="21" y2="12" />
					<line x1="8" y1="18" x2="21" y2="18" />
					<line x1="3" y1="6" x2="3.01" y2="6" />
					<line x1="3" y1="12" x2="3.01" y2="12" />
					<line x1="3" y1="18" x2="3.01" y2="18" /></svg>
			</button>
			<button class="view-btn grid-view active" title="Grid View">
				<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-grid">
					<rect x="3" y="3" width="7" height="7" />
					<rect x="14" y="3" width="7" height="7" />
					<rect x="14" y="14" width="7" height="7" />
					<rect x="3" y="14" width="7" height="7" /></svg>
			</button>
		</div>
	</div>
	<div class="project-boxes jsGridView pelangi">

		<?php 
		if ($data_kelas == null) echo '<div class="no-data" onclick="document.querySelectorAll(\'.tabnav li a\')[1].click()">Oops! ikut kelas dulu yuk :)</div>';
		
		foreach ($data_kelas as $val) : ?>
			<div class="project-box-wrapper">
				<div class="project-box">
					<div class="project-box-header hide">
						<span><?= date('d F', $val->dibuat) ?></span>
					</div>
					<div class="project-box-content-header">
						<p class="box-content-header" style="font-size: 14px; padding-bottom: 7px">
							<?= $val->nama_kelas ?> Asb Bakilin
						</p>
						<p class="box-content-subheader">
							<b>Pemateri:</b> <?= $val->pengurus ?>
						</p>
					</div>
					<div class="project-box-footer" style="display: flex; justify-content: center;margin-left:auto; padding-right:0">
						<a href="/materi/<?= base64url_encode($val->id_kelas) ?>">
							<div class="days-left" style="font-size: 12px; padding-left: .7rem; padding-right: .7rem">
								Akses Materi
							</div>
						</a>
					</div>
				</div>
			</div>
			<?php endforeach ?>


	</div>
</div>


<script>
	var listView = document.querySelector('.list-view');
	var gridView = document.querySelector('.grid-view');
	var projectsList = document.querySelector('.project-boxes');
	
	var simput = document.querySelector(".search-input");
	simput.removeAttribute("disabled")
	function search() {
		const pattern = simput.value.toLowerCase();
		if (simput.length < 1) return;
		let targetId = "";

		let divs = document.querySelectorAll(".project-box");
		for (let i = 0; i < divs.length; i++) {
			let para = divs[i].querySelector(".box-content-header");
			if (para.innerText.toLowerCase().includes(pattern)) {
				//divs[i].classList.remove('hide')
				$(divs[i]).fadeIn()
			} else {
				$(divs[i]).fadeOut()
				//divs[i].classList.add('hide')
			}
		}
	}
	simput.addEventListener('input', search);

	listView.addEventListener('click', function () {
		gridView.classList.remove('active');
		listView.classList.add('active');
		projectsList.classList.remove('jsGridView');
		projectsList.classList.add('jsListView');
	});

	gridView.addEventListener('click', function () {
		gridView.classList.add('active');
		listView.classList.remove('active');
		projectsList.classList.remove('jsListView');
		projectsList.classList.add('jsGridView');
	});
</script>
