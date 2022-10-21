<link rel="stylesheet" href="/assets/css/admin/dropify.min.css" />

<style>
	.dropify-wrapper .dropify-message p {
		font-size: 14px;
	}
</style>

<div class="row page-titles">
	<div class="col-md-5 align-self-center">
		<h3 class="text-themecolor">Buat Materi</h3>
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="/dashboard">Dashboard</a>
			</li>
			<li class="breadcrumb-item">
				<a href="/dashboard/materi">Materi</a>
			</li>
			<li class="breadcrumb-item active">Buat Materi</li>
		</ol>
	</div>
	<div class="col-md-7 align-self-center">
	</div>
</div>
<!-- End Bread crumb and right sidebar toggle -->


<!-- row -->
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">

				<h4 class="card-title">Tipe Postingan</h4>

				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" data-toggle="tab" href="#teks" role="tab"><span class="hidden-sm-up"><i class="fa fa-align-left"></i></span>
							<span class="hidden-xs-down">Teks</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link" data-toggle="tab" href="#tautan" role="tab"><span class="hidden-sm-up"><i class="fa fa-link"></i></span>
							<span class="hidden-xs-down">Tautan</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link" data-toggle="tab" href="#youtube" role="tab"><span class="hidden-sm-up"><i class="fa fa-youtube"></i></span>
							<span class="hidden-xs-down">Embed Youtube</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link" data-toggle="tab" href="#foto" role="tab"><span class="hidden-sm-up"><i class="fa fa-file-image-o"></i></span>
							<span class="hidden-xs-down">Foto</span></a>
					</li>
				</ul>


				<!-- Tab panes -->
				<div class="tab-content tabcontent-border">
					<div class="form-group mt-3">
						<label>Kelas</label>
						<select class="form-control" id="inputKelas">
							<?php foreach ($data_kelas as $val) {
								echo "<option value=\"$val->id_kelas\">$val->nama_kelas</option>";
							} ?>
						</select>
						<small class="form-text text-muted">
							*Wajib
						</small>
					</div>
					<div class="form-group mt-3">
						<label>Judul</label>
						<input
						type="text" class="form-control" id="inputJudul" autocomplete="off" required />
						<small class="form-text text-muted">
							*Wajib
						</small>
					</div>

					<div class="tab-pane active" id="teks" role="tabpanel">
						<div class="form-group">
							<label>Teks</label>
							<textarea class="form-control" name="teks" rows="5" required></textarea>
							<small class="form-text text-muted">
								*Wajib
							</small>
						</div>
						<button class="btn waves-effect waves-light btn-info pull-right text-white"
							onclick="postText(1, document.querySelector('[name=teks]'))">
							<i class="fa fa-paper-plane-o"></i> Posting
						</button>
					</div>
					<div class="tab-pane" id="tautan" role="tabpanel">
						<button class="btn waves-effect waves-light btn-info d-block mx-auto text-white"
							onclick="postText(2, null)">
							<i class="fa fa-paper-plane-o"></i> Posting
						</button>
						<div class="form-group mt-3">
							<label>Link 1</label>
							<input
							type="text" class="form-control form-control-sm" name="urlNames[]" autocomplete="off" placeholder="Teks Link (opsional)" />
							<input
							type="url" class="form-control form-control-sm" name="urls[]" autocomplete="off" placeholder="Url" />
							<small class="form-text text-muted">
								*Wajib
							</small>
						</div>
						<button onclick="tambahInputLink()" class="btn btn-sm btn-warning">Tambah Link</button>
					</div>
					<div class="tab-pane" id="youtube" role="tabpanel">
						<div class="form-group mt-3">
							<label>Url Video</label>
							<input
							type="url" oninput="isYoutube(this.value, document.querySelector('#msg-ytb'))" class="form-control" name="url_youtube" autocomplete="off" required />
							<small class="form-text text-muted" id="msg-ytb"></small>
						</div>
						<button class="btn waves-effect waves-light btn-info pull-right text-white"
							onclick="postText(3, document.querySelector('[name=url_youtube]'))">
							<i class="fa fa-paper-plane-o"></i> Posting
						</button>
					</div>
					<div class="tab-pane pt-2" style="font-size: .9rem" id="foto" role="tabpanel">
						<form id="uploadForm" method="post" enctype="multipart/form-data">
							<input type="hidden" id="uploadForm-kelas" name="idkel" />
							<input type="hidden" id="uploadForm-title" name="title" />
							<input type="hidden" value="4" name="type" />
							<label for="input-file-now">Gambar</label>
							<input type="file" id="input-gambar" name="image" class="dropify" data-max-file-size="3M" data-allowed-file-extensions="jpg jpeg png gif" />
							<button onclick="isiHiddenFormUpload()" type="submit" class="btn waves-effect waves-light btn-info pull-right mt-2 text-white">
								<i class="fa fa-paper-plane-o"></i> Posting
							</button>
						</form>
					</div>
				</div>


			</div>
		</div>
	</div>
</div>
<!-- row -->

<!-- jQuery file upload -->
<script src="/assets/js/admin/dropify.min.js"></script>
<script>
	const inputJudul = document.querySelector('#inputJudul');
	const inputIdKel = document.querySelector('#inputKelas');
	const maxInputLink = 10;
	var inputLinkCount = 1;

	function tambahInputLink() {
		if (inputLinkCount < maxInputLink) {
			inputLinkCount++;
			let index = inputLinkCount;
			let form = '<div class="form-group mt-3" id="inputLink' +index+ '">' +
			'<label>Link' +index+ '</label>' +
			'<input type="text" class="form-control form-control-sm" name="urlNames[]" autocomplete="off" placeholder="Teks Link (opsional)" />' +
			'<input type="url" class="form-control form-control-sm" name="urls[]" autocomplete="off" placeholder="Url"/>' +
			'<div class="">' +
			'<button class="pull-right mt-1 btn btn-sm btn-danger" onclick="deleteInput(inputLink' +index+ ')"><i class="fa fa-times"></i></button>' +
			'</div></div>';
			$('#tautan').append(form);
		} else {
			showMsg('info', 'Maksimal 10 link');
		}
	}
	function deleteInput(e) {
		e.remove();
		inputLinkCount--;
	}

	function isYoutube(url, err) {
		let regex = /^(?:https?:\/\/)?(?:m\.|www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;
		if (url.match(regex)) {
			err.innerText = '';
		} else {
			err.innerText = 'Url tidak valid';
		}
	}

	$(function() {
		$('.dropify').dropify({
			messages: {
				'default': 'Drag and drop a file here or click',
				'replace': 'Drag and drop or click to replace',
				'remove': 'Hapus',
				'error': 'Ooops, something wrong happended.'
			}
		});

		$('#uploadForm').submit((e) => {
			e.preventDefault();
			console.log('up')
			let data = new FormData(document.querySelector('#uploadForm'));
			uploadAjax(data);
		});

	});

	const isiHiddenFormUpload = () => {
		$('#uploadForm-kelas').val(inputKelas.value.trim());
		$('#uploadForm-title').val(inputJudul.value.trim());
	}

	const postText = (a, b) => {
		let forms = {
			idkel: inputKelas.value.trim(),
			title: inputJudul.value.trim(),
			type: a
		};
		if (a == 1) forms.text = b.value.trim();
		if (a == 2) forms.link = getLinks();
		if (a == 3) forms.ytb = b.value.trim();
		if (a == 4) {
			b.preventDefault();
			console.log('up')
			uploadAjax(new FormData(b));
			return;
		}
		postAjax(forms);
	}

	const postAjax = (data) => {
		$(".preloader").fadeIn();
		$.ajax({
			url: '/admin/materi/tambah_materi',
			method: 'post',
			data: data,
			dataType: 'json',
			success: (response) => {
				console.log(response)
				if (response.status != true) {
					showMsg('info', response.msg);
				} else {
					showMsg('success', 'Materi telah diposting!');
					setTimeout(() => {
						location.reload(true)
					}, 3000);
				}
			},
			complete: () => $(".preloader").fadeOut(),
			error: () => showMsg('info', 'Server error!')
		});
	}

	const uploadAjax = (data) => {
		$(".preloader").fadeIn();
		$.ajax({
			url: '/admin/materi/tambah_materi',
			type: 'post',
			data: data,
			processData: false,
			contentType: false,
			cache: false,
			success: (response) => {
				console.log(response)
				try {
					response = JSON.parse(response);
					if (response.status != true) {
						showMsg('info', response.msg);
					} else {
						showMsg('success', 'Materi telah diposting!');
						setTimeout(() => {
							location.reload(true)
						}, 3000);
					}
				} catch (e) {
					showMsg('info', 'Keslahan sistem!');
				}
			},
			complete: () => $(".preloader").fadeOut(),
			error: () => showMsg('info', 'Server error!')
		});
	}

	const getLinks = () => {
		let names = $('input[name^="urlNames"]');
		let links = $('input[name^="urls"]');
		let out = new Array();

		Array.from(links).forEach((val, i) => {
			const obj = {
				name: (names[i].value.trim().length == 0) ? val.value.trim(): names[i].value.trim(),
				url: val.value.trim()
			};
			if (validURL(val.value)) out.push(obj);
		});
		return JSON.stringify(out);
	}


</script>