<script src="/assets/js/user/main.js<?= ($web_devmode) ? '?time=' . time() : '' ?>"></script>

<div id="loader">
	<div class="lds-ring">
		<div></div>
		<div></div>
		<div></div>
		<div></div>
	</div>
</div>

<script><?= (is_null($this->session->flashdata('alert'))) ? '' : $this->session->flashdata('alert') ?></script>
