<!-- DOCTYPE html->
<html>
<body>
	<div>
		<div -->

		</div>
	</div>
	
	<?= (!isset($nonav)) ? $this->load->view('user/bottom-nav', '', true) : ''; ?>

	<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
	<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

	<script>
		var modeSwitch = document.querySelector('.mode-switch');
		darkMode(localStorage.getItem('dark'));

		modeSwitch.addEventListener('click', function () {
			let dark = (localStorage.getItem('dark') == 'true') ? 'false': 'true';
			localStorage.setItem('dark', dark);
			darkMode(dark);
		});

		function darkMode(yes) {
			if (yes == 'true') {
				document.documentElement.classList.add('dark');
				modeSwitch.classList.add('active');
			} else {
				document.documentElement.classList.remove('dark');
				modeSwitch.classList.remove('active');
			}
		}
	</script>



</body>

</html>