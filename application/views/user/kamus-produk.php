<style>
	.kamus-produk {}
	.kamus-produk .list {
		color: var(--light-font);
		background: var(--more-list-bg);
		border-radius: 15px;
		display: flex;
		align-items: center;
		border: 1px solid var(--message-box-border);
		padding: .7rem .9rem;
		box-shadow: 0px 2px 7px var(--more-list-shadow);
	}
	.kamus-produk .list:hover {
		background: var(--app-container);
	}
	.kamus-produk .image {
		width: 42px;
		height: 42px;
		border-radius: 100%;
		margin-right: .9rem;
	}
	.kamus-produk .body h4 {
		color: var(--light-font);
		font-size: .95rem;
		margin: 0;
		font-weight: 500;
	}
	
	.kamus-produk .body span {
		color: var(--light-font);
		opacity: .6;
		font-size: .85rem;
		padding-top: .3rem;
		font-weight: 300;
	}
</style>

<div class="projects-section">
	<div class="projects-section-header">
		<p>
			Kamus Produk
		</p>
	</div>
	<div class="kamus-produk hide">
		<a href="/kamus/list/<?= base64url_encode('1') ?>" class="list">
			<img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/488320/profile/profile-80.jpg" class="image">
			<div class="body">
				<h4>Programing Asoy</h4>
				<span>24 Items</span>
			</div>
			<ion-icon name="eye" style="font-size: 24px;color: #6772e5;margin-left:auto"></ion-icon>
		</a>
	</div>
	
</div>