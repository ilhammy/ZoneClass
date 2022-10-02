<meta name="viewport" content="initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">


<p>
	<?= $this->session->flashdata('auth_msg') ?>
</p>
<?= validation_errors(); ?>

<form action="/auth/login" method="post">
	<input type="text" name="username" /> <br />
	<input type="password" name="password" /> <br />
	<input type="submit" name="login" value="MASUK" /> <br />
</form>

<form action="/auth/register" method="post">
	<input type="text" name="username" /> <br />
	<input type="email" name="email" /> <br />
	<input type="text" name="password" /> <br />
	<input type="submit" name="login" value="DAFTAR" /> <br />
</form>