<!DOCTYPE html>
<html>
<head>

	<meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<link rel="apple-touch-icon" type="image/png" href="<?= $web_favicon ?>" />
	<meta name="apple-mobile-web-app-title" content="<?= $web_name ?>">

	<link rel="shortcut icon" type="image/png" href="<?= $web_shortcut_icon ?>" />
	<link rel="favicon" type="image/png" href="<?= $web_favicon ?>" color="#111" />

	<title><?= $web_name ?></title>

	<script src="//cdn.jsdelivr.net/npm/eruda"></script>
	<script>
		<?= ($web_devmode) ? 'eruda.init();' : '' ?>
		const baseUrl = '<?= base_url() ?>';
	</script>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css" />
	<link rel="stylesheet" href="/assets/css/tabbar.css<?= ($web_devmode) ? '?time=' . time() : '' ?>" />
	<link rel="stylesheet" href="/assets/css/user-style.css<?= ($web_devmode) ? '?time=' . time() : '' ?>" />
	<link rel="stylesheet" href="/assets/css/loader.css" />

	<link href="//cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4/bootstrap-4.css" rel="stylesheet">
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>


	<script src="/assets/js/jquery.js"></script>
</head>

<body>
	<div class="app-container">
		<div class="app-header">
			<div class="app-header-left">
				<p class="app-name">
					<?= $web_name ?>
				</p>
				<div class="search-wrapper">
					<input class="search-input" type="text" placeholder="Search">
					<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="feather feather-search" viewBox="0 0 24 24">
						<defs></defs>
						<circle cx="11" cy="11" r="8"></circle>
						<path d="M21 21l-4.35-4.35"></path>
					</svg>
				</div>
			</div>
			<div class="app-header-right">
				<button class="mode-switch" title="Switch Theme">
					<svg class="moon" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" width="24" height="24" viewBox="0 0 24 24">
						<defs></defs>
						<path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"></path>
					</svg>
				</button>
				<button class="profile-btn" onclick="window.location.href='<?= base_url() ?>'">
					<img src="<?= profileValue('foto') ?>" />
					<span><?= profileValue('fullname') ?></span>
				</button>
			</div>
		</div>
		<div class="app-content" id="konten" style="<?= (!isset($nonav)) ? 'padding-bottom: 80px' : null ?>">