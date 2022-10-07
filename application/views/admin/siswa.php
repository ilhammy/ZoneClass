<div class="team">
	<h1>Siswa Saya</h1>
	<div class="team__setting">
		<button class="btn btn--primary">
			<span class="btn__icon">
				<svg width="14" height="16" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M6.667 8a4 4 0 100-8 4 4 0 000 8zM6.667 9.333C2.167 9.333 0 12.141 0 13.777v.89A1.333 1.333 0 001.333 16H12a1.333 1.333 0 001.333-1.333v-.89c0-1.636-2.166-4.444-6.666-4.444z" fill="#fff" />
				</svg>
			</span>
			Tambah Siswa
		</button>

		<div class="team__icon">
			<svg width="16" height="16" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M16 2.665h-5.333v2.667H16V2.665zM9.334 3.998a3.99 3.99 0 00-7.755-1.333H0v2.667h1.579a3.99 3.99 0 007.755-1.334zm-4 1.334a1.333 1.333 0 110-2.667 1.333 1.333 0 010 2.667zM5.333 10.665H0v2.667h5.333v-2.667zM10.667 7.998a4 4 0 103.755 5.334H16v-2.667h-1.578a4 4 0 00-3.755-2.667zm0 5.334a1.334 1.334 0 110-2.667 1.334 1.334 0 010 2.667z" fill="#A4A8BD" />
			</svg>
		</div>
	</div>
</div>
<div class="cards">

	<?php
	if ($data_siswa == null) echo '<div class="no-data">Tidak ada siswa</div>';

	foreach ($data_siswa as $val) : ?>
	<div class="card">
		<header class="card__header">
			<div class="card__img">
				<img src="<?= $val->foto ?>" alt="avatar" />
			</div>
			<div class="card__name">
				<h6><?= $val->fullname ?></h6>
				<span class="card__role">@<?= $val->username ?></span>
			</div>
		</header>
		<div class="card__body">
			<div class="stats">
				<div class="score">
					<h3>60</h3>
					<small class="title">CEO</small>
				</div>
				<div class="score">
					<h3>71</h3>
					<small class="title">Marketing</small>
				</div>
				<div class="score">
					<h3>10</h3>
					<small class="title">Analytics</small>
				</div>
			</div>
		</div>
	</div>
	<?php endforeach ?>

</div>