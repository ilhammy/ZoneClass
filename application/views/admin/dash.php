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
<div class="row">
	<!-- Column -->
	<div class="col-md-4">
		<div class="card">
			<div class="card-body">
				<div class="d-flex p-10 no-block">
					<div class="align-self-center display-6 m-r-20">
						<i class="text-success fa fa-users"></i>
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
						<i class="text-success fa fa-graduation-cap"></i>
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
						<i class="text-success fa fa-book"></i>
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
						<i class="text-success fa fa-line-chart"></i>
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
						<i class="text-success fa fa-line-chart"></i>
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
	<?php endif ?>
</div>
<!-- End Info Box -->

<!-- Sales Chart and browser state-->
<div class="row">
	<!-- kolom1 -->
	<div class="col-md-6">
		<div class="card card-body mailbox">
			<h5 class="card-title">Soon</h5>
			<div class="message-center d-none" style="height: 420px !important">
				<!-- Message -->
				<a href="#">
					<div class="btn btn-danger btn-circle">
						<i class="fa fa-link"></i>
					</div>
					<div class="mail-contnet">
						<h6 class="text-dark font-medium mb-0">Luanch Admin</h6>
						<span class="mail-desc">Just see the my new admin!</span>
						<span class="time">9:30 AM</span>
					</div>
				</a>
				<!-- Message -->
				<a href="#">
					<div class="btn btn-success btn-circle">
						<i class="fa fa-calendar-check-o"></i>
					</div>
					<div class="mail-contnet">
						<h6 class="text-dark font-medium mb-0">Event today</h6>
						<span class="mail-desc"
							>Just a reminder that you have event</span
						>
						<span class="time">9:10 AM</span>
					</div>
				</a>
				<!-- Message -->
				<a href="#">
					<div class="btn btn-info btn-circle">
						<i class="fa fa-cog text-white"></i>
					</div>
					<div class="mail-contnet">
						<h6 class="text-dark font-medium mb-0">Settings</h6>
						<span class="mail-desc"
							>You can customize this template as you want</span
						>
						<span class="time">9:08 AM</span>
					</div>
				</a>
				<!-- Message -->
				<a href="#">
					<div class="btn btn-primary btn-circle">
						<i class="fa fa-user"></i>
					</div>
					<div class="mail-contnet">
						<h6 class="text-dark font-medium mb-0">Pavan kumar</h6>
						<span class="mail-desc">Just see the my admin!</span>
						<span class="time">9:02 AM</span>
					</div>
				</a>
				<!-- Message -->
				<a href="#">
					<div class="btn btn-info btn-circle">
						<i class="fa fa-cog text-white"></i>
					</div>
					<div class="mail-contnet">
						<h6 class="text-dark font-medium mb-0">
							Customize Themes
						</h6>
						<span class="mail-desc"
							>You can customize this template as you want</span
						>
						<span class="time">9:08 AM</span>
					</div>
				</a>
				<!-- Message -->
				<a href="#">
					<div class="btn btn-primary btn-circle">
						<i class="fa fa-user"></i>
					</div>
					<div class="mail-contnet">
						<h6 class="text-dark font-medium mb-0">Pavan kumar</h6>
						<span class="mail-desc">Just see the my admin!</span>
						<span class="time">9:02 AM</span>
					</div>
				</a>
			</div>
		</div>
	</div>
	<!-- kolom1 end -->
	<!-- kolom2 -->
	<div class="col-md-6">
		<div class="card">
			<div class="card-body">
				<h5 class="card-title">Soon</h5>
				<ul class="feeds d-none">
					<li>
						<div class="bg-light-info">
							<i class="fa fa-bell-o"></i>
						</div>
						You have 4 pending tasks.
						<span class="text-muted">Just Now</span>
					</li>
					<li>
						<div class="bg-light-success">
							<i class="fa fa-server"></i>
						</div>
						Server #1 overloaded.<span class="text-muted"
							>2 Hours ago</span
						>
					</li>
					<li>
						<div class="bg-light-warning">
							<i class="fa fa-shopping-cart"></i>
						</div>
						New order received.<span class="text-muted">31 May</span>
					</li>
					<li>
						<div class="bg-light-danger">
							<i class="fa fa-user"></i>
						</div>
						New user registered.<span class="text-muted">30 May</span>
					</li>
					<li>
						<div class="bg-light-inverse">
							<i class="fa fa-bell-o"></i>
						</div>
						New Version just arrived.
						<span class="text-muted">27 May</span>
					</li>
					<li>
						<div class="bg-light-info">
							<i class="fa fa-bell-o"></i>
						</div>
						You have 4 pending tasks.
						<span class="text-muted">Just Now</span>
					</li>
					<li>
						<div class="bg-light-danger">
							<i class="fa fa-user"></i>
						</div>
						New user registered.<span class="text-muted">30 May</span>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<!-- kolom2 end -->

</div>
<!-- row end -->