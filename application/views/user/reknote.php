<?php
$rek = profileValue('rekening');
?>

<div class="top-nav">
	<ion-icon class="icon" name="arrow-back-outline" onclick="window.localStorage.setItem('ref', 'profile');window.open('/', '_self')"></ion-icon>
	<div class="title" style="font-size: 1.1rem;font-weight: 600; padding: 0 .5rem">
		Rekening Saya
	</div>
</div>

<div class="projects-section">
	<div class="project-boxes">

		<?= $this->session->flashdata('alert') ?>

		<form id="form1" action="/settings/saveRekening" method="post">
			<div class="input-wrapper">
				<textarea class="myinput" rows="7" name="text" id="rek" autocomplete="off" placeholder="Rekening kosong" readonly="true"><?= $rek ?></textarea>
			</div>

			<div style="display: flex;justify-content: flex-end; padding: 10px">
				<button type="button" class="btn btn-info" id="btnEdit">
					<ion-icon name="pencil"></ion-icon>
				</button>
				<button type="button" class="btn btn-info hide" id="btnSave">
					<ion-icon name="checkmark-sharp"></ion-icon>
				</button>
				<button type="button" class="btn btn-danger" style="margin-left: .7rem" id="btnCopy">
					<ion-icon name="copy"></ion-icon>
				</button>
			</div>
		</form>

	</div>
</div>

<script>
	document.title = 'Rekening';
	const rek = $('#rek')
	const btnEdit = $('#btnEdit')
	const btnSave = $('#btnSave')
	const btnCopy = $('#btnCopy')

	$(function() {
		btnEdit.click(function() {
			rek.prop('readonly', false)
			rek.focus()
			btnEdit.toggleClass('hide')
			btnSave.toggleClass('hide')
		});

		btnSave.click(function() {
			btnEdit.toggleClass('hide')
			btnSave.toggleClass('hide')
			document.querySelector('#form1').submit()
			rek.prop('readonly', true)
		});

		btnCopy.click(function() {
			if (rek.val().length > 1) copyText(rek.val())
		});
	});

	const copyText = (text) => {
		if (!navigator.clipboard) {
			fallbackCopyTextToClipboard(text);
			return;
		}
		navigator.clipboard.writeText(text).then(function() {
			showMsg('success', 'Tersalin ke clipboard')
			console.log('Async: Copying to clipboard was successful!');
		}, function(err) {
			showMsg('error', 'Tidak dapat meynyalin ke clipboard')
			console.error('Async: Could not copy text: ', err);
		});
	}

	const showMsg = (tipe, msg) => {
		const Toast = Swal.mixin({
			toast: true,
			position: 'top-end',
			showConfirmButton: false,
			timer: 3000,
			timerProgressBar: true,
			didOpen: (toast) => {
				toast.addEventListener('mouseenter', Swal.stopTimer)
				toast.addEventListener('mouseleave', Swal.resumeTimer)
			}
		})
		
		Toast.fire({
			icon: tipe,
			title: msg
		})
	}
</script>