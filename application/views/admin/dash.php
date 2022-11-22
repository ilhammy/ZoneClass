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
		color: #000;
		border-radius: 15px;
		border: 1px solid rgba(0,0,0,.1);
		padding: .7rem .9rem;
		box-shadow: 0px 2px 7px var(--more-list-shadow);
		display: flex;
		flex-direction: column;
		overflow: hidden;
		margin: .4rem;
		height: 190px;
	}
	.notes .list:hover {
		opacity: .7;
	}
	.notes .list h4 {
		color: var(--light-font);
		font-size: .9rem;
		margin: 0;
		font-weight: 500;
	}

	.notes .list span {
		display: block;
		color: #000;
		opacity: .6;
		font-size: .84rem;
		padding: .5rem 0;
		font-weight: 400;
		overflow: hidden;
		text-overflow: ellipsis;
		max-height: 70px;
	}
	.notes .list .date {
		margin-top: auto;
		color: #000;
		opacity: .5;
		text-align: right;
		font-size: .8rem;
		padding: .3rem .2rem 0 .2rem;
		border-top: 1px solid rgba(0,0,0,.2);
		font-weight: 200;
	}

	.top-notes {
		text-align: center;
		padding: .4rem 0;
		display: flex;
		align-items: center;
	}
	.btn-create {
		outline: none;
		border: none;
		width: 35px;
		height: 35px;
		padding: .4rem;
		font-size: 1rem;
		color: #fff;
		border-radius: 50px;
		display: flex;
		justify-content: center;
		align-items: center;
	}
	.sm-none {
		display: none;
	}

	@media screen and (min-width: 768px) {
		.sm-none {
			display: inline-block;
		}
		mobile {
			display: none;
		}
	}
</style>

<div class="row page-titles">
	<div class="col-md-5 align-self-center">
		<h3 class="text-themecolor">Dashboard</h3>
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="javascript:void(0)">Home</a>
			</li>
			<li class="breadcrumb-item active">Dashboard</li>
		</ol>
	</div>
	<div class="col-md-7 align-self-center">

	</div>
</div>
<!-- End Bread crumb and right sidebar toggle -->

<!-- Info Box -->
<div class="row card-stats">
	<!-- Column -->
	<div class="col-md-4">
		<div class="card animated bounce" style="background: rgba(254, 148, 175, .6)">
			<div class="card-body">
				<div class="p-10">
					<h2 class="m-b-0">
						<?= sizeof($siswaku) ?>
					</h2>
					<h6 class="m-b-0">Total Siswa</h6>
				</div>
			</div>
		</div>
	</div>
	<!-- Column -->
	<!-- Column -->
	<div class="col-md-4">
		<div class="card animated bounce" style="background: rgba(254, 168, 103, .6)">
			<div class="card-body">
				<div class="p-10">
					<h2 class="m-b-0">
						<?= sizeof($this->Kelas_model->getMyClass()) ?>
					</h2>
					<h6 class="m-b-0">Total Kelas</h6>
				</div>
			</div>
		</div>
	</div>
	<!-- Column -->
	<!-- Column -->
	<div class="col-md-4">
		<div class="card animated bounce" style="background: rgba(255, 212, 82, .6)">
			<div class="card-body">
				<div class="p-10">
					<h2 class="m-b-0">
						<?= sizeof($materiku) ?>
					</h2>
					<h6 class="m-b-0">Total Materi</h6>
				</div>
			</div>
		</div>
	</div>
	<!-- Column -->
	<!-- Column -->
	<div class="col-md-4">
		<div class="card animated bounce" style="background: rgba(128, 186, 249, .6)">
			<div class="card-body">
				<div class="p-10">
					<h2 class="m-b-0">
						<?= sizeof(getOnlineSiswa(myUid())) ?>
					</h2>
					<h6 class="m-b-0">Siswa Online</h6>
				</div>
			</div>
		</div>
	</div>
	<!-- Column -->

	<?php if (isAdmin()) : ?>
	<!-- Column -->
	<div class="col-md-4">
		<div class="card animated bounce" style="background: rgba(231, 108, 162, .6)">
			<div class="card-body">
				<div class="p-10">
					<h2 class="m-b-0">
						<?= sizeof(getOnlineUser(1)) ?>
					</h2>
					<h6 class="m-b-0">Guru Online</h6>
				</div>
			</div>
		</div>
	</div>
	<!-- Column -->
	<!-- Column -->
	<div class="col-md-4">
		<div class="card animated bounce" style="background: rgba(187, 145, 231, .6)">
			<div class="card-body">
				<div class="p-10">
					<h2 class="m-b-0">
						<?= sizeof(getOnlineUser(2)) ?>
					</h2>
					<h6 class="m-b-0">All Siswa Online</h6>
				</div>
			</div>
		</div>
	</div>
	<!-- Column -->
	<?php endif ?>
</div>
<!-- End Info Box -->

<!-- Sales Chart and browser state-->
<div class="row">
	<!-- kolom1 -->
	<div class="col-md-6">
		<div class="card card-body mailbox" id="info">
			<h5 class="card-title">Notifikasi</h5>
			<div class="message-center animated fadeInLeft" style="height: auto;max-height: 420px !important">
				<!-- Message -->
				<?php
				$notifs = isAdmin() ? $this->Notif_model->getForAdmin() : $this->Notif_model->getForGuru();
				if (sizeof($notifs) == 0) echo '<div class="alert alert-info">Tidak ada notifikasi</div>';
				foreach ($notifs as $val) :
				if (!($val->user !== myUid() || $val->user !== -1)) continue;
				switch ($val->type) {
					case 'error':
						$bg = 'btn-danger';
						break;
					case 'warning':
						$bg = 'btn-warning';
						break;
					case 'success':
						$bg = 'btn-success';
						break;
					default:
						$bg = 'btn-info';
					}
					?>
					<a href="javascript:readNot(<?= $val->id ?>);viewNotif('<?= $val->title ?>', '<?= $val->content ?>')" id="notif<?= $val->id ?>">
						<div class="btn <?= $bg ?> btn-circle">
							<i class="<?= $val->icon ?>"></i>
						</div>
						<div class="mail-contnet">
							<h6 class="<?= !$val->isRead ? 'text-dark' : 'text-muted' ?> font-medium mb-0"><?= $val->title ?></h6>
							<span class="mail-desc"><?= $val->content ?></span>
							<span class="time"><?= timeago($val->time) ?></span>
						</div>
					</a>
					<?php endforeach ?>
				</div>
			</div>
		</div>
		<!-- kolom1 end -->
		<!-- kolom2 -->
		<div class="col-md-6">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title top-notes">
						Catatan Saya
						<a href="/dashboard/new_note" class="btn-create ml-auto bg-info"><i class="fa fa-plus"></i></a>
					</h5>

					<div class="notes">
						<?php foreach ($mynotes as $val) : ?>
						<div class="list-box">
							<a href="javascript:openNote('<?= base64_encode(json_encode($val)) ?>')" class="list">
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

			</div>
		</div>
	</div>
	<!-- kolom2 end -->

</div>
<!-- row end -->


<!-- modal note -->
<div class="modal bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="modal1" id="modal1" aria-hidden="true" style="display: none">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="modal1-title">
					Large modal
				</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			</div>
			<div class="modal-body" id="modal1-body">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger waves-effect text-left btnDel" data-dismiss="modal">
					<i class="fa fa-trash"></i> Hapus
				</button>
				<button type="button" class="btn btn-warning waves-effect text-left btnCopy">
					<i class="fa fa-copy"></i> Salin
				</button>
				<button type="button" class="btn btn-info waves-effect text-left btnEdit" data-dismiss="modal">
					<i class="fa fa-pencil"></i> Edit
				</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal note -->


<script>
	const viewNotif = (a, b) => Swal.fire(a, b, 'info')
	const readNot = (a) => {
		let cont = document.querySelector('#notif' + a)
		console.info(a.innerHTML)
		cont.querySelector('h6').classList.remove('text-dark')
		cont.querySelector('h6').classList.add('text-muted')
		fetch('/ajax/readNotif/' + a)
		.then((response) => response.text());
	}

	const openNote = a => {
		localStorage.setItem('note_open', a)
		$('#modal1').modal('show')
	}

	$('#modal1').on('show.bs.modal', function (event) {
		let data = JSON.parse(atob(localStorage.getItem('note_open')))
		let modal = $(this)
		modal.find('.modal-title').text(data.title)
		modal.find('.modal-body').html(nl2br(data.text))

		modal.find('.btnDel').on('click', () => {
			delNote(data.id)
		})
		modal.find('.btnCopy').on('click', () => {
			copyText(data.text)
			showMsg('success', 'Tersalin ke clipboard')
		})
		modal.find('.btnEdit').on('click', () => {
			window.open('/dashboard/edit_note/' + btoa_url(data.id), '_self')
		})
	})

	const delNote = (id) => {
		Swal.fire({
			title: 'Konfirmasi',
			icon: 'question',
			text: 'Apakah anda ingin menghapus catatan ini?',
			showDenyButton: true,
			focusConfirm: false,
			confirmButtonText: 'Hapus',
			denyButtonText: 'Batal'
		}).then(result => {
			if (result.isConfirmed) {
				$.ajax({
					url: 'admin/catatan/delNote',
					method: 'post',
					data: {
						note_id: id
					},
					dataType: 'json',
					success: response => {
						if (response.status !== true) {
							showMsg('error', response.msg)
						} else {
							showMsg('success', response.msg);
							window.location.reload(true)
						}
					}
				})
			}
		})
	}
	
</script>