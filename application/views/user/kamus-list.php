<style>
	.kamus {}
	.kamus .list {
		background: var(--more-list-bg);
		border-radius: 12px;
		overflow: hidden;
		border: 1px solid var(--message-box-border);
		box-shadow: 0px 2px 7px var(--more-list-shadow);
		min-height: 80px;
	}
	.kamus .list + .list {
		margin-top: .85rem;
	}
	.kamus .head {
		padding: .5rem .9rem;
		background: #e9e7fd;
	}
	.kamus .head h4 {
		color: var(--light-font);
		font-size: .93rem;
		margin: 0;
		font-weight: 500;
	}
	.dark .kamus .head {
		background: var(--app-container);
	}
	.dark .kamus .head h4 {
		color: #fee4cb;
	}
	
	.kamus .body {
		padding: .5rem .8rem;
		color: var(--light-font);
		opacity: 1;
		font-size: .9rem;
		padding-top: .5rem;
		font-weight: 300;
		display: flex;
	}
	.kamus .body ion-icon {
		margin-left: auto;
		padding: .3rem;
	}
</style>

<div class="top-nav">
	<ion-icon class="icon" name="arrow-back-outline" onclick="window.localStorage.setItem('ref', 'kamus');window.open('/', '_self')"></ion-icon>
	<div class="title" style="font-size: 1.1rem;font-weight: 600; padding: 0 .5rem">
		Programing Asoy
	</div>
</div>

<div class="projects-section">
	<div class="kamus">
		<?php for ($i = 0; $i < 10; $i++) : ?>
		<div class="list">
			<div class="head">
				<h4>Ini judulnya</h4>
			</div>
			<div class="body">
				ini isinya trus kalian mau apa???
				<ion-icon name="copy" style="font-size: 20px;"></ion-icon>
			</div>
		</div>
		<?php endfor ?>
	</div>
	
</div>

<script>
	document.title = 'Programing Asjoy'
</script>