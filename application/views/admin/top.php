<?php
cekLogin();
if (!isAdminGuru()) redirect(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<!-- Tell the browser to be responsive to screen width -->
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="robots" content="noindex,nofollow" />
	<title>Dashboard</title>

	<script src="//cdn.jsdelivr.net/npm/eruda"></script>
	<script>
		<?= ($web_devmode) ? 'eruda.init();' : '' ?>
		const baseUrl = '<?= base_url() ?>';
	</script>
	<script src="/assets/js/jquery.js"></script>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

	<!-- Favicon icon -->
	<link rel="icon" type="image/png" sizes="16x16"
	href="<?= $web_favicon ?>" />
	<!-- Bootstrap Core CSS -->
	<link href="/assets/css/admin/bootstrap.min.css" rel="stylesheet" />
	<link href="/assets/css/admin/perfect-scrollbar.css" rel="stylesheet" />
	<link rel="stylesheet" href="/assets/css/admin/dataTables.bootstrap4.css" />
	<link rel="stylesheet" href="/assets/css/admin/responsive.dataTables.min.css" />


	<!-- chartist CSS -->
	<link href="/assets/css/admin/morris.css" rel="stylesheet" />
	<!--c3 CSS -->
	<link href="/assets/css/admin/c3.min.css" rel="stylesheet" />
	<!-- Custom CSS -->
	<link href="/assets/css/admin/style.css<?= ($web_devmode) ? '?time=' . time() : '' ?>" rel="stylesheet" />

	<!-- You can change the theme colors from here -->
	<link href="/assets/css/admin/default-color.css" id="theme" rel="stylesheet" />
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
				      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
				      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
				    <![endif]-->
</head>

<body class="fix-header fix-sidebar card-no-border">
	<!-- ============================================================== -->
	<!-- Preloader - style you can find in spinners.css -->
	<!-- ============================================================== -->
	<div class="preloader">
		<div class="loader">
			<div class="loader__figure"></div>
			<p class="loader__label">
				<?= $web_name ?>
			</p>
		</div>
	</div>
	<!-- ============================================================== -->
	<!-- Main wrapper - style you can find in pages.scss -->
	<!-- ============================================================== -->
	<div id="main-wrapper">
		<!-- ============================================================== -->
		<!-- Topbar header - style you can find in pages.scss -->
		<!-- ============================================================== -->
		<header class="topbar">
			<nav class="navbar top-navbar navbar-expand-md navbar-light">
				<!-- ============================================================== -->
				<!-- Logo -->
				<!-- ============================================================== -->
				<div class="navbar-header">
					<a class="navbar-brand" href="/dashboard">
						<!-- Logo icon --><b>
							<!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
							<!-- Dark Logo icon -->
							<img
							src="/assets/img/logo-icon.png"
							alt="homepage"
							class="dark-logo"
							/>
							<!-- Light Logo icon -->
							<img
							src="/assets/img/logo-light-icon.png"
							alt="homepage"
							class="light-logo"
							/>
						</b>
						<!--End Logo icon -->
						<!-- Logo text --><span>
							<!-- dark Logo text -->
							<img
							src="/assets/img/logo-text.png"
							alt="homepage"
							class="dark-logo" />
							<!-- Light Logo text -->
							<img
							src="/assets/img/logo-light-text.png"
							class="light-logo"
							alt="homepage"
							/></span>
					</a>
				</div>
				<!-- ============================================================== -->
				<!-- End Logo -->
				<!-- ============================================================== -->
				<div class="navbar-collapse">
					<!-- ============================================================== -->
					<!-- toggle and nav items -->
					<!-- ============================================================== -->
					<ul class="navbar-nav mr-auto">
						<li class="nav-item">
							<a class="nav-link nav-toggler hidden-md-up waves-effect waves-dark" href="javascript:void(0)"><i class="fa fa-bars"></i></a>
						</li>
						<!-- ============================================================== -->
						<!-- Search -->
						<!-- ============================================================== -->
						<li class="nav-item hidden-xs-down search-box d-none">
							<a
								class="nav-link hidden-sm-down waves-effect waves-dark"
								href="javascript:void(0)"
								><i class="fa fa-search"></i
								></a>
							<form class="app-search">
								<input
								type="text"
								class="form-control"
								placeholder="Search & enter"
								/>
								<a class="srh-btn"><i class="fa fa-times"></i></a>
							</form>
						</li>
					</ul>
					<!-- ============================================================== -->
					<!-- User profile and search -->
					<!-- ============================================================== -->
					<ul class="navbar-nav my-lg-0">
						<!-- ============================================================== -->
						<!-- Profile -->
						<!-- ============================================================== -->
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle waves-effect waves-dark profile-pic"
								href="#" id="navbarDropdown" data-toggle="dropdown"
								aria-haspopup="true" aria-expanded="false">
								<img src="<?= profileValue('foto') ?>"
								alt="" />
								<span class="hidden-md-down"><?= profileValue('fullname') ?> &nbsp;</span>
							</a>
							<div class="dropdown-menu dropdown-menu-end animated flipInY">
								<ul class="dropdown-user">
									<li>
										<div class="dw-user-box">
											<div class="u-img">
												<img src="<?= profileValue('foto') ?>" alt="user" />
											</div>
											<div class="u-text">
												<h4><?= profileValue('fullname') ?></h4>
												<p class="text-muted">
													<?= dataUserValue('email') ?>
												</p>
												<a href="/dashboard/profile" class="btn btn-rounded btn-danger btn-sm">View Profile</a>
											</div>
										</div>
									</li>
									<li role="separator" class="divider"></li>
									<li>
										<a href="/dashboard/settings"><i class="fa fa-cog"></i> Pengaturan</a>
									</li>
									<li role="separator" class="divider"></li>
									<li>
										<a href="/logout"><i class="fa fa-power-off"></i> Logout</a>
									</li>
								</ul>
							</div>
						</li>
					</ul>
				</div>
			</nav>
		</header>

		<aside class="left-sidebar">
			<!-- Sidebar scroll-->
			<div class="scroll-sidebar">
				<!-- Sidebar navigation-->
				<nav class="sidebar-nav">
					<ul id="sidebarnav">
						<?php foreach ($sb_menu as $val) : ?>
						<li>
							<a class="waves-effect waves-dark"
								href="<?= $val->href ?>"
								aria-expanded="false">
								<i class="<?= $val->icon ?>"></i>
								<span class="hide-menu"><?= $val->title ?></span>
							</a>
						</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</nav>
			<!-- End Sidebar navigation -->
		</div>
		<!-- End Sidebar scroll-->
	</aside>

	<div class="page-wrapper">
		<!-- ============================================================== -->
		<!-- Container fluid  -->
		<!-- ============================================================== -->
		<div class="container-fluid">