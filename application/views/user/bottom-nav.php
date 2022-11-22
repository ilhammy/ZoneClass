<div class="tabnav">
	<ul>
		<li class="list active">
			<a href="javascript:loadPage('home')">
				<span class="icon"><ion-icon name="rocket-outline"></ion-icon></span>
				<span class="text">Beranda</span>
			</a>
		</li>
		<li class="list">
			<a href="javascript:loadPage('kelas')">
				<span class="icon"><ion-icon name="logo-electron"></ion-icon></span>
				<span class="text">Akses</span>
			</a>
		</li>
		<li class="list">
			<a href="javascript:loadPage('catatan')">
				<span class="icon"><ion-icon name="newspaper-outline"></ion-icon></span>
				<span class="text">Catatan</span>
			</a>
		</li>
		<li class="list">
			<a href="javascript:loadPage('kelasku')">
				<span class="icon"><ion-icon name="hardware-chip-outline"></ion-icon></span>
				<span class="text">Kelola</span>
			</a>
		</li>
		<div class="indicator"></div>
	</ul>
</div>

<script>
	const list = document.querySelectorAll('.list');
	function activeLink() {
		list.forEach((item) =>
			item.classList.remove('active'));
		this.classList.add('active');
	}
	list.forEach((item) =>
		item.addEventListener('click', activeLink));
</script>