<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="<?= $web_description ?>" />
	<link rel="icon" type="image/png" sizes="16x16" href="<?= $web_favicon ?>" />

	<!-- ===== CSS ===== -->
	<link rel="stylesheet" href="/assets/css/auth/styles.css<?= ($web_devmode) ? '?time=' . time() : '' ?>">

	<!-- ===== BOX ICONS ===== -->
	<link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>
	<script src="//cdn.jsdelivr.net/npm/eruda"></script>
	<script>
		eruda.init();
		const baseUrl = '<?= base_url() ?>';
	</script>
	<link href="//cdn.jsdelivr.net/npm/@sweetalert2/theme-minimal@4/minimal.css" rel="stylesheet">
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>


	<style>
		.login_msg {
			padding: .2rem .7rem;
			background: #bd0432;
			color: #fff;
			border-radius: 10px;
			line-height: 1.2;
			font-size: .8rem;
			display: inline-block;
		}
	</style>

	<title><?= $web_name ?></title>

	<!-- Open Graph / Facebook -->
	<meta property="og:type" content="website">
	<meta property="og:url" content="<?= base_url() ?>">
	<meta property="og:title" content="<?= $web_name ?>">
	<meta property="og:description" content="<?= $web_description ?>">
	<meta property="og:image" content="/assets/img/img-login.svg">

</head>
<body>