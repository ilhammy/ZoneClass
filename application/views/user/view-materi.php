<?php
$currPage = $this->uri->segment('3');
$totalMat = sizeof($allmateri);
$urlKelas = substr(current_url(),0 , strlen(current_url()) - 1);
?>

<style>
	.materi-view {
		background-color: var(--projects-section);
		border-radius: 10px;
		padding: 32px;
		overflow: hidden;
	}
	.materi-view .image {
		width: 100%;
		max-width: 400px;
		border-radius: 10px;
	}

	.materi-view iframe {
		width: 100%;
		max-width: 400px;
		height: 250px;
		border-radius: 10px;
	}

	.materi-view > .links {
		opacity: .8;
		font-size: .95em;
		display: flex;
		flex-direction: column;
		align-items: flex-start;
	}
	.materi-view > .links a {
		border-radius: 50px;
		margin: 0 0 .7rem 0;
		background: var(--more-list-shadow);
		color: var(--link-color);
		padding: .6rem 1rem;
		animation: .5s ease-out 0s 1 slideInFromLeft;
	}
	.materi-view > .links a:hover {
		opacity: .7;
		margin-left: .7rem;
	}
	.materi-view > .caption {
		color: var(--light-font);
		font-size: .95em;
	}
	
	.navigator {
		width: 100%;
		bottom: 0;
		position: fixed;
		z-index: 3;
		transform: translateX(-50%);
		left: 50%;
		padding: 10px 20px;
		display: flex;
		justify-content: space-between;
	}
	
	.navigator a {
		background: rgba(0,0,0,.3);
		color: #fff;
		width: 43px;
		height: 43px;
		display: flex;
		justify-content: center;
		align-items: center;
		border-radius: 100%;
		opacity: 1;
	}
	.navigator a:hover {
		background: rgba(255,255,255, .3);
		outline: none;
	}

	@keyframes slideInFromLeft {
		0% {
			opacity: 0;
			transform: translateX(100%);
		}
		100% {
			opacity: 1;
			transform: translateX(0);
		}
	}
	
	@media screen and (min-width: 768px) {
		.navigator .navigator-content {
			width: 300px;
		}
	}
</style>

<div class="top-nav">
	<ion-icon class="icon" name="arrow-back-outline" onclick="window.open('/materi/<?= $this->uri->segment('2') ?>', '_self')"></ion-icon>
	<div class="title" style="font-size: 1.1rem;font-weight: 600; padding: 0 .5rem">
		<?= $materi->judul ?>
	</div>
</div>

<div class="materi-view">
	<?php
	if (!is_null($materi->foto)) {
		echo "<div class=\"text-center\"><img onclick=\"openImage('{$materi->foto}')\" title=\"{$materi->judul}\" src=\"{$materi->foto}\" class=\"image\" /></div>";
	} else if (!is_null($materi->youtube)) {
		echo "<div class=\"text-center\"><iframe type=\"text/html\" src=\"https://www.youtube.com/embed/{$materi->youtube}\" frameborder=\"0\" allowFullScreen></iframe></div>";
	} else if (!is_null($materi->link)) {
		$links = json_decode($materi->link);
		echo '<div class="links">';
		foreach ($links as $i => $d) {
			$i = $i +1;
			echo "<a href=\"{$d->url}\" target=\"_blank\" title=\"{$d->name}\">{$i}. {$d->name}</a>";
		}
		echo '</div>';
	} else if (!is_null($materi->teks)) {
		echo "<div class=\"caption\">". nl2br($materi->teks, true). "</div>";
	} else {
		echo "Tidak ada konten apapun";
	}
	?>

</div>
	
<div class="navigator">
	<a href="javascript:openLink('<?= $urlKelas . ($currPage - 1) ?>')" class="<?= $currPage <= 1 ? 'disabled' : '' ?>"><ion-icon name="chevron-back" style="font-size: 20px"></ion-icon></a>
	<a href="javascript:openLink('<?= $urlKelas . ($currPage + 1) ?>')" class="<?= $currPage >= $totalMat ? 'disabled' : '' ?>"><ion-icon class="icon-right" name="chevron-forward" style="font-size: 20px"></ion-icon></a>
</div>

<script>
	document.title = '<?= $materi->judul ?>'

	const openImage = (url) => {
		let lightbox = new FsLightbox();
		lightbox.props.sources = [url];
		lightbox.open();
	}
	
	const openLink = (b) => {
		history.replaceState({page: <?= $currPage ?>}, 'a', b)
		window.location.reload(true)
	}
</script>