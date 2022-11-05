<div class="row page-titles">
	<div class="col-md-5 align-self-center">
		<h3 class="text-themecolor">Dashboard</h3>
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="javascript:void(0)">Home</a>
			</li>
			<li class="breadcrumb-item active">Dashboard</li>
		</ol>
	</div>
	<div class="col-md-7 align-self-center">

	</div>
</div>
<!-- End Bread crumb and right sidebar toggle -->

<!-- Info Box -->
<div class="row card-stats">
	<!-- Column -->
	<div class="col-md-4">
		<div class="card">
			<div class="card-body">
				<div class="d-flex p-10 no-block">
					<div class="align-self-center display-6 m-r-20">
						<i class="text-info fa fa-users"></i>
					</div>
					<div class="align-slef-center">
						<h2 class="m-b-0">
							<?= sizeof($siswaku) ?>
							<small><i class="ti-angle-down text-danger"></i></small>
						</h2>
						<h6 class="text-muted m-b-0">Total Siswa</h6>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Column -->
	<!-- Column -->
	<div class="col-md-4">
		<div class="card">
			<div class="card-body">
				<div class="d-flex p-10 no-block">
					<div class="align-self-center display-6 m-r-20">
						<i class="text-info fa fa-graduation-cap"></i>
					</div>
					<div class="align-slef-center">
						<h2 class="m-b-0">
							<?= sizeof($this->Kelas_model->getMyClass()) ?>
							<small><i class="ti-angle-down text-danger"></i></small>
						</h2>
						<h6 class="text-muted m-b-0">Total Kelas</h6>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Column -->
	<!-- Column -->
	<div class="col-md-4">
		<div class="card">
			<div class="card-body">
				<div class="d-flex p-10 no-block">
					<div class="align-self-center display-6 m-r-20">
						<i class="text-info fa fa-book"></i>
					</div>
					<div class="align-slef-center">
						<h2 class="m-b-0">
							<?= sizeof($materiku) ?>
							<small><i class="ti-angle-down text-danger"></i></small>
						</h2>
						<h6 class="text-muted m-b-0">Total Materi</h6>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Column -->
	<!-- Column -->
	<div class="col-md-4">
		<div class="card">
			<div class="card-body">
				<div class="d-flex p-10 no-block">
					<div class="align-self-center display-6 m-r-20">
						<i class="text-primary fa fa-line-chart"></i>
					</div>
					<div class="align-slef-center">
						<h2 class="m-b-0">
							<?= sizeof(getOnlineSiswa(myUid())) ?>
							<small><i class="ti-angle-down text-danger"></i></small>
						</h2>
						<h6 class="text-muted m-b-0">Siswa Online</h6>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Column -->

	<?php if (isAdmin()) : ?>
	<!-- Column -->
	<div class="col-md-4">
		<div class="card">
			<div class="card-body">
				<div class="d-flex p-10 no-block">
					<div class="align-self-center display-6 m-r-20">
						<i class="text-primary fa fa-line-chart"></i>
					</div>
					<div class="align-slef-center">
						<h2 class="m-b-0">
							<?= sizeof(getOnlineUser(1)) ?>
							<small><i class="ti-angle-down text-danger"></i></small>
						</h2>
						<h6 class="text-muted m-b-0">Guru Online</h6>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Column -->
	<!-- Column -->
	<div class="col-md-4">
		<div class="card">
			<div class="card-body">
				<div class="d-flex p-10 no-block">
					<div class="align-self-center display-6 m-r-20">
						<i class="text-primary fa fa-line-chart"></i>
					</div>
					<div class="align-slef-center">
						<h2 class="m-b-0">
							<?= sizeof(getOnlineUser(2)) ?>
							<small><i class="ti-angle-down text-danger"></i></small>
						</h2>
						<h6 class="text-muted m-b-0">All Siswa Online</h6>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Column -->
	<?php endif ?>
</div>
<!-- End Info Box -->

<!-- Sales Chart and browser state-->
<div class="row">
	<!-- kolom1 -->
	<div class="col-md-6">
		<div class="card card-body mailbox" id="info">
			<h5 class="card-title">Notifikasi</h5>
			<div class="message-center" style="height: auto;max-height: 420px !important">
				<!-- Message -->
				<?php
				$notifs = isAdmin() ? $this->Notif_model->getForAdmin() : $this->Notif_model->getForGuru();
				if (sizeof($notifs) == 0) echo '<div class="alert alert-info">Tidak ada notifikasi</div>';
				foreach ($notifs as $val) :
				if (!($val->user !== myUid() || $val->user !== -1)) continue;
				switch ($val->type) {
					case 'error':
						$bg = 'btn-danger';
						break;
					case 'warning':
						$bg = 'btn-warning';
						break;
					case 'success':
						$bg = 'btn-success';
						break;
					default:
						$bg = 'btn-info';
					}
					?>
					<a href="javascript:readNot(<?= $val->id ?>);viewNotif('<?= $val->title ?>', '<?= $val->content ?>')" id="notif<?= $val->id ?>">
						<div class="btn <?= $bg ?> btn-circle">
							<i class="<?= $val->icon ?>"></i>
						</div>
						<div class="mail-contnet">
							<h6 class="<?= !$val->isRead ? 'text-dark' : 'text-muted' ?> font-medium mb-0"><?= $val->title ?></h6>
							<span class="mail-desc"><?= $val->content ?></span>
							<span class="time"><?= timeago($val->time) ?></span>
						</div>
					</a>
					<?php endforeach ?>
				</div>
			</div>
		</div>
		<!-- kolom1 end -->
		<!-- kolom2 -->
		<div class="col-md-6">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Soon</h5>
				</div>
			</div>
		</div>
	</div>
	<!-- kolom2 end -->

</div>
<!-- row end -->


<script>
	const viewNotif = (a, b) => Swal.fire(a, b, 'info')
	const readNot = (a) => {
		let cont = document.querySelector('#notif' + a)
		console.info(a.innerHTML)
		cont.querySelector('h6').classList.remove('text-dark')
		cont.querySelector('h6').classList.add('text-muted')
		fetch('/ajax/readNotif/' + a)
		.then((response) => response.text());
	}
</script>