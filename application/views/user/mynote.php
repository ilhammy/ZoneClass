<style>
	.notes {
		width: 100%;
		margin: 1rem 0;
	}
	.notes:after {
		content: "";
		display: table;
		clear: both;
	}
	.notes .list-box {
		float: left;
		width: 50%;
	}
	.notes .list {
		color: var(--light-font);
		background: var(--more-list-bg);
		border-radius: 15px;
		border: 1px solid var(--message-box-border);
		padding: .7rem .9rem;
		box-shadow: 0px 2px 7px var(--more-list-shadow);
		display: flex;
		flex-direction: column;
		overflow: hidden;
		margin: .4rem;
		height: 190px;
	}
	.notes .list:hover {
		background: var(--app-container);
	}
	.notes .list h4 {
		color: var(--light-font);
		font-size: .93rem;
		margin: 0;
		font-weight: 500;
	}

	.notes .list span {
		display: block;
		color: var(--light-font);
		opacity: .6;
		font-size: .87rem;
		padding: .5rem 0;
		font-weight: 400;
		min-height: 50px;
		overflow: hidden;
		text-overflow: ellipsis;
	}
	.notes .list .date {
		margin-top: auto;
		color: var(--light-font);
		opacity: .5;
		text-align: right;
		font-size: .8rem;
		padding: .3rem .2rem;
		border-top: 1px solid var(--message-box-border);
		font-weight: 200;
	}

	.top-notes {
		text-align: center;
		padding: .4rem 0;
	}

	.notes > .list-box:nth-child(1n+0) > .list {
		background: rgba(254, 148, 175, .6);
	}
	.notes > .list-box:nth-child(2n+0) > .list {
		background: rgba(254, 168, 103, .6);
	}
	.notes > .list-box:nth-child(3n+0) > .list {
		background: rgba(255, 212, 82, .6);
	}
	.notes > .list-box:nth-child(4n+0) > .list {
		background: rgba(128, 186, 249, .6);
	}
	.notes > .list-box:nth-child(5n+0) > .list {
		background: rgba(231, 108, 162, .6);
	}

	.btn-create {
		outline: none;
		border: none;
		padding: .6rem 1rem;
		font-size: 1rem;
		background: rgba(0, 140, 206, 1);
		color: #fff;
		border-radius: 50px;
		font-weight: 600;
		box-shadow: 0px 2px 10px var(--more-list-shadow);
		width: 60px;
		height: 60px;
		position: fixed;
		bottom: 0;
		margin: 0 1.5rem 6.5rem 0;
		display: flex;
		justify-content: center;
		align-items: center;
		right: 0;
	}
	.btn-create:hover {
		opacity: .7;
	}
	.sm-none {
		display: none;
	}

	@media screen and (min-width: 768px) {
		.btn-create {
			transform: translateX(-50%);
			left: 50%;
			margin: 0 0 9rem 0;
		}
		.sm-none {
			display: inline-block;
		}
		mobile {
			display: none;
		}
		.notes .list-box {
			width: 33.33%;
		}
	}
</style>

<div class="projects-section">
	<div class="projects-section-header">
		<p>
			Catatan Saya
		</p>
	</div>
	<div class="top-notes">
		<button class="btn-create" onclick="window.open('/catatan/baru', '_self')">
			<ion-icon name="pencil" size=large"></ion-icon>
		</button>
	</div>
	<div class="notes">
		<?php foreach ($mynotes as $val) : ?>
		<div class="list-box">
			<a href="/catatan/view/<?= base64url_encode($val->id) ?>" class="list">
				<h4><?= $val->title ?></h4>
				<span><?= substr($val->text, 0, 40) ?></span>
				<div class="date">
					<?= date('d M', $val->time) ?>
				</div>
			</a>
		</div>
		<?php endforeach ?>
	</div>

</div>


<script>
	var simput = document.querySelector(".search-input");
	simput.removeAttribute("disabled")
	function search() {
		const pattern = simput.value.toLowerCase();
		if (simput.length < 1) return;
		let targetId = "";

		let divs = document.querySelectorAll(".notes .list");
		for (let i = 0; i < divs.length; i++) {
			let para = divs[i].querySelector("h4");
			if (para.innerText.toLowerCase().includes(pattern)) {
				//divs[i].classList.remove('hide')
				$(divs[i]).fadeIn()
			} else {
				$(divs[i]).fadeOut()
				//divs[i].classList.add('hide')
			}
		}
	}
	simput.addEventListener('input', search);
</script>