<link rel="stylesheet" href="/assets/css/admin/dropify.min.css" />
<style>
	.dropify-wrapper .dropify-message p {
		font-size: 14px;
	}
</style>

<div class="row page-titles">
	<div class="col-md-5 align-self-center">
		<h3 class="text-themecolor">Sunting Materi</h3>
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="/dashboard">Dashboard</a>
			</li>
			<li class="breadcrumb-item">
				<a href="/dashboard/materi">Materi</a>
			</li>
			<li class="breadcrumb-item active">Sunting Materi</li>
		</ol>
	</div>
	<div class="col-md-7 align-self-center">
	</div>
</div>
<!-- End Bread crumb and right sidebar toggle -->


<!-- row -->
<div class="row justify-content-center">
	<div class="col-md-8">
		<div class="card">
			<div class="card-body">

				<h4 class="card-title">Sunting Materi</h4>


				<!-- Tab panes -->
				<?php
				$alert = $this->session->flashdata('alert');
				if (!is_null($alert)) {
					echo "<div class=\" alert alert-danger\">$alert</div>";
				} ?>

				<form action="" method="post" id="form1" enctype="multipart/form-data">
					<input type="hidden" name="idMateri" value="<?= $idmat ?>" />
					<input type="hidden" name="type" value="<?= $tipePost ?>" />
					<div class="form-group mt-3">
						<label>Judul</label>
						<input type="text" class="form-control" value="<?= $mtri->judul ?>" name="title" autocomplete="off" required />
						<small class="form-text text-muted">
							*Wajib
						</small>
					</div>

					<?php
					$teks = "<div class=\"form-group\"><label>Teks </label> <textarea class=\"form-control\" name=\"text\" rows=\"5\" required>$mtri->teks</textarea> <small class=\"form-text text-muted\">
					*Wajib </small> </div>";

					$htmlLink = '';
					$link1 = new stdClass();
					$link1->name = '';
					$link1->url = '';

					$jsonLinks = json_decode($mtri->link);
					
					if (!empty($mtri->link) && sizeof($jsonLinks) > 1) {
						foreach ($jsonLinks as $idx => $val) {
							if ($idx == 0) {
								$link1 = $val;
								continue;
							}
							$key = $idx + 1;
							
							$htmlLink .= "<div class=\"form-group mt-3\" id=\"inputLink$key\">
							<label>Link $key</label>
							<input type=\"text\" value=\"$val->name\" class=\"form-control form-control-sm\" name=\"urlNames[]\" autocomplete=\"off\" placeholder=\"Teks Link (opsional)\" />
							<input type=\"url\" value=\"$val->url\" class=\"form-control form-control-sm\" name=\"urls[]\" autocomplete=\"off\" placeholder=\"Url\"/>
							<div><button class=\"pull-right mt-1 btn btn-sm btn-danger\" onclick=\"deleteInput(inputLink$key)\"><i class=\"fa fa-times\"></i></button>
							</div></div>
							";
						}
					}

					$tautan = "<input type=\"hidden\" name=\"link\" id=\"jsnInput\" />
					<div class=\"form-group mt-3\" id=\"tautan\"><label>Link 1</label> <input
					type=\"text\" value=\"$link1->name\" class=\"form-control form-control-sm\" name=\"urlNames[]\" autocomplete=\"off\" placeholder=\"Teks Link (opsional)\" /> <input
					type=\"url\" value=\"$link1->url\" class=\"form-control form-control-sm\" name=\"urls[]\" autocomplete=\"off\" placeholder=\"Url\" /> <small class=\"form-text text-muted\">
					*Wajib </small> <button type=\"button\" onclick=\"tambahInputLink()\" class=\"btn btn-sm btn-warning\"> Tambah Link </button> $htmlLink</div>";

					$yt = "<div class=\"form-group mt-3\">
						<label>Url Video</label>
						<input
						type=\"url\" oninput=\"isYoutube(this.value, document.querySelector('#msg-ytb'))\" value=\"https://youtu.be/$mtri->youtube\" class=\"form-control\" name=\"youtube\" autocomplete=\"off\" required />
						<small class=\"form-text text-muted\" id=\"msg-ytb\"></small>
						<iframe class=\"d-block mt-4\" frameborder=\"0\" src=\"https://www.youtube.com/embed/$mtri->youtube\"></iframe>
					</div>";

					$file = "<label for=\"input-file-now\">Gambar</label>
					<input type=\"file\" id=\"input-gambar\" name=\"image\" class=\"dropify\" data-default-file=\"$mtri->foto\" data-max-file-size=\"3M\" data-allowed-file-extensions=\"jpg jpeg png gif\" />";

					switch ($tipePost) {
						case 2:
							echo $tautan;
							break;
						case 3:
							echo $yt;
							break;
						case 4:
							echo $file;
							break;
						default:
							echo $teks;
						} ?>

						<div class="py-2">
						</div>
						<button class="btn
							waves-effect waves-light
							btn-info
							pull-right mt-3 text-white"
							type="submit">
							<i class="fa fa-upload"></i> Update
						</button>
					</form>


				</div>
			</div>
		</div>
	</div>
	<!-- row -->

	<!-- jQuery file upload -->
	<script src="/assets/js/admin/dropify.min.js"></script>
	<script>
		const maxInputLink = 10;
		var inputLinkCount = <?= (!is_null($jsonLinks)) ? sizeof($jsonLinks) : 1 ?>;

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
				err.innerText = '* Wajib';
			} else {
				err.innerHTML = '<font class="text-danger">Url tidak valid</font>';
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

			$('#form1').submit((e) => {
				//e.preventDefault();
				if (<?= $tipePost ?> == 2) {
					$('#jsnInput').val(getLinks)
				}
			});

		});

		const getLinks = () => {
			let names = $('input[name^="urlNames"]');
			let links = $('input[name^="urls"]');
			let out = new Array();

			Array.from(links).forEach((val,
				i) => {
				const obj = {
					name: (names[i].value.trim().length == 0) ? val.value.trim(): names[i].value.trim(),
					url: val.value.trim()
				};
				if (validURL(val.value)) out.push(obj);
			});
			return JSON.stringify(out);
		}

	</script>