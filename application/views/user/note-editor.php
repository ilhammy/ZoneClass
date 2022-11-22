<?php
$isEdit = isset($editMode);
$judul = $isEdit ? $catatan->title : null;
$isi = $isEdit ? $catatan->text : null;
?>

<link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>
	#editor, #toolbar {
		color: var(--light-font);
		border-radius: 10px;
		font-size: .9rem;
		margin-top: .5rem;
		box-shadow: 0px 2px 7px var(--more-list-shadow);
	}
	#editor {
		border: 1px solid var(--message-box-border);
	}
	.dark #toolbar {
		background: rgba(255, 212, 82, .6);
	}
	
</style>

<div class="top-nav">
	<ion-icon id="btnBack" class="icon" name="arrow-back-outline" onclick="window.localStorage.setItem('ref', 'catatan');window.open('/', '_self')"></ion-icon>
	<div class="title" style="font-size: 1.1rem;font-weight: 600; padding: 0 .5rem">
		<?= $isEdit ? null : 'Buat Catatan' ?>
	</div>
</div>

<div class="projects-section">

	<form id="form1">
		<div class="input-wrapper">
			<label class="label">Judul</label>
			<input class="myinput" value="<?= $isEdit ? $judul : null ?>" name="title" id="title" type="text" autocomplete="off" required>
		</div>
		<div class="input-wrapper" id="ed">
			<div id="toolbar">
				<span class="ql-formats">
					<select class="ql-font"></select>
					<select class="ql-size"></select>
				</span>
				<span class="ql-formats">
					<button class="ql-bold"></button>
					<button class="ql-italic"></button>
					<button class="ql-underline"></button>
					<button class="ql-strike"></button>
				</span>
				<span class="ql-formats">
					<button class="ql-header" value="1"></button>
					<button class="ql-header" value="2"></button>
					<button class="ql-blockquote"></button>
				</span>
				<span class="ql-formats">
					<button class="ql-list" value="ordered"></button>
					<button class="ql-list" value="bullet"></button>
					<button class="ql-indent" value="-1"></button>
					<button class="ql-indent" value="+1"></button>
				</span>
				<span class="ql-formats">
					<button class="ql-link"></button>
					<button class="ql-clean"></button>
				</span>
			</div>
			<div id="editor" style="height: 300px"></div>
		</div>
		<textarea name="text" id="teks" class="hide"></textarea>

		<div class="text-center" style="margin:3rem 0">
			<?php if ($isEdit) : ?>
			<button type="button" class="btn btn-danger" style="margin-right: .7rem" onclick="showDel(<?= $catatan->id ?>)">Hapus</button>
			<?php endif ?>
			<button type="button" class="btn btn-info" onclick="validate()"><?= $isEdit ? 'Update' : 'Simpan' ?></button>
		</div>
	</form>

</div>

<script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script>
	document.title = '<?= $isEdit ? $judul : 'Buat Catatan' ?>';
	$('.search-input').prop("disabled", true)
	var titleInput = document.querySelector('#title')
	var txtInput = document.querySelector('#teks')

	var container = document.getElementById('editor');
	var editor = new Quill(container, {
		modules: {
			toolbar: '#toolbar'
		},
		placeholder: 'Tulis disini...',
		readOnly: false,
		bounds: document.getElementById('ed'),
		theme: 'snow'
	});
	editor.setText(atob('<?= $isEdit ? base64_encode($isi) : null ?>'))
	editor.on('text-change', function(delta, oldDelta, source) {
		$('#teks').val(editor.getText())
	});

	const validate = () => {
		//console.info(titleInput.value)
		let a = titleInput.value.replace(/ /g, '')
		let b = editor.getText().replace(/ /g, '')
		if (a.length == 0) {
			showMsg('warning', 'Judul catatan kosong!')
			return
		} else if (b.length == 0) {
			showMsg('warning', 'Isi catatan kosong!')
			return
		}
		
		postNote({
			<?= $isEdit ? 'note_id:'. $catatan->id. ',' : null ?>
			title: titleInput.value,
			text: editor.getText(),
		})
	}

	const postNote = data => {
		$.ajax({
			method: 'post',
			data: data,
			dataType: 'json',
			success: function(response) {
				//console.log(response)
				if (response.status != true) {
					showMsg('error', response.msg);
				} else {
					showMsg('success', response.msg)
					setInterval(() => {
						document.querySelector('#btnBack').click()
					}, 2000);
				}
			}
		});
	}
	
	const showDel = id => {
		Swal.fire({
			icon: 'question',
			title: 'Konfirmasi',
			text: 'Apakah kamu akan menghapus catatan ini?',
			showDenyButton: true,
			confirmButtonText: 'Ya',
			denyButtonText: 'Batal',
			customClass: {
				popup: 'radius-8r'
			},
		}).then((result) => {
			if (result.isConfirmed) delNote(id)
		});
	}
	
	const delNote = id => {
		$.ajax({
			url: '/catatan/delNote',
			method: 'post',
			data: {
				note_id: id
			},
			dataType: 'json',
			success: function(response) {
				//console.log(response)
				if (response.status != true) {
					showMsg('error', response.msg);
				} else {
					showMsg('success', response.msg)
					setInterval(() => {
						document.querySelector('#btnBack').click()
					}, 2000);
				}
			}
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