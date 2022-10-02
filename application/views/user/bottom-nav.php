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
			<a href="javascript:loadPage('notif')">
				<span class="icon"><ion-icon name="chatbox-ellipses-outline"></ion-icon></span>
				<span class="text">Chat</span>
			</a>
		</li>
		<li class="list">
			<a href="javascript:loadPage('profile')">
				<span class="icon"><ion-icon name="hardware-chip-outline"></ion-icon></span>
				<span class="text">Akun</span>
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