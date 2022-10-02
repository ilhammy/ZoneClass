<!DOCTYPE html>
<html>
<head>

	<meta name="viewport" content="initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<link rel="apple-touch-icon" type="image/png" href="https://cpwebassets.codepen.io/assets/favicon/apple-touch-icon-5ae1a0698dcc2402e9712f7d01ed509a57814f994c660df9f7a952f3060705ee.png" />
	<meta name="apple-mobile-web-app-title" content="CodePen">

	<link rel="shortcut icon" type="image/x-icon" href="https://cpwebassets.codepen.io/assets/favicon/favicon-aec34940fbc1a6e787974dcd360f2c6b63348d4b1f4e06c77743096d55480f33.ico" />
	<link rel="mask-icon" type="image/x-icon" href="https://cpwebassets.codepen.io/assets/favicon/logo-pin-8f3771b1072e3c38bd662872f6b673a722f4b3ca2421637d5596661b4e2132cc.svg" color="#111" />

	<title>ZoneClass</title>

	<script src="//cdn.jsdelivr.net/npm/eruda"></script>
	<script>
		eruda.init();
		const baseUrl = '<?= base_url() ?>';
	</script>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css" />
	<link rel="stylesheet" href="/assets/css/tabbar.css?ses=<?= time() ?>" />
	<link rel="stylesheet" href="/assets/css/user-style.css?ses=<?= time() ?>" />
	<link rel="stylesheet" href="/assets/css/loader.css" />

	<link href="//cdn.jsdelivr.net/npm/@sweetalert2/theme-minimal@4/minimal.css" rel="stylesheet">
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>


	<script src="/assets/js/jquery.js"></script>
</head>

<body>
	<div class="app-container">
		<div class="app-header">
			<div class="app-header-left">
				<p class="app-name">
					ZoneClass
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
				<button class="profile-btn">
					<img src="https://assets.codepen.io/3306515/IMG_2025.jpg" />
					<span><?= profileValue('fullname') ?></span>
				</button>
			</div>
		</div>
		<div class="app-content" id="konten" style="padding-bottom: 80px">