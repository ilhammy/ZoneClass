<div class="row page-titles">
	<div class="col-md-5 align-self-center">
		<h3 class="text-themecolor">Buat Kelas</h3>
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="/dashboard">Dashboard</a>
			</li>
			<li class="breadcrumb-item">
				<a href="/dashboard/kelas">Kelas</a>
			</li>
			<li class="breadcrumb-item active">Buat Kelas</li>
		</ol>
	</div>
	<div class="col-md-7 align-self-center">
		<button class="btn
			waves-effect waves-light
			btn btn-info
			pull-right text-white"
			onclick="document.querySelector('#sb-form1').click()">
			<i class="fa fa-plus"></i> Simpan
		</button>
	</div>
</div>
<!-- End Bread crumb and right sidebar toggle -->


<!-- row -->
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">

				<h4 class="card-title">Tipe Postingan</h4>

				<?php $msg = validation_errors() . $this->session->flashdata('newclass');
				if (!is_null($msg) && !empty($msg)) {
					echo '<div class="alert alert-info alert-rounded">' . $msg;
					echo '</div>';
				} ?>

				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" data-bs-toggle="tab" href="#teks" role="tab"><span class="hidden-sm-up"><i class="fa fa-align-left"></i></span>
							<span class="hidden-xs-down">Teks</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link" data-bs-toggle="tab" href="#tautan" role="tab"><span class="hidden-sm-up"><i class="fa fa-link"></i></span>
							<span class="hidden-xs-down">Tautan</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link" data-bs-toggle="tab" href="#youtube" role="tab"><span class="hidden-sm-up"><i class="fa fa-youtube"></i></span>
							<span class="hidden-xs-down">Embed Youtube</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link" data-bs-toggle="tab" href="#foto" role="tab"><span class="hidden-sm-up"><i class="fa fa-file-image-o"></i></span>
							<span class="hidden-xs-down">Foto</span></a>
					</li>
				</ul>


				<!-- Tab panes -->
				<div class="tab-content tabcontent-border">
					<div class="form-group mt-3">
						<label>Judul</label>
						<input
						value="<?= set_value('nama_kelas') ?>"
						type="text" class="form-control" name="nama_kelas" autocomplete="off" required />
						<small class="form-text text-muted">
							*Wajib
						</small>
					</div>
					<div class="tab-pane active" id="teks" role="tabpanel">
						<div class="form-group">
							<label>Teks</label>
							<textarea class="form-control" name="teks" rows="5" required><?= set_value('des') ?></textarea>
							<small class="form-text text-muted">
								*Wajib
							</small>
						</div>
					</div>
					<div class="tab-pane p-20" id="tautan" role="tabpanel">
						2
					</div>
					<div class="tab-pane p-20" id="youtube" role="tabpanel">
						3
					</div>
					<div class="tab-pane p-20" id="foto" role="tabpanel">
						4
					</div>
				</div>

				<!-- form action="" method="POST" class="mt-4" id="form1">
																	<div class="form-group">
																		<label>Nama Kelas</label>
																		<input
																		value="<?= set_value('nama_kelas') ?>"
																		type="text" class="form-control" name="nama_kelas" autocomplete="off" required />
																		<small class="form-text text-muted">
																			*Wajib
																		</small>
																	</div>

																	<div class="form-group">
																		<label>Keterangan Singkat</label>
																		<textarea class="form-control" name="des" rows="5" required><?= set_value('des') ?></textarea>
																		<small class="form-text text-muted">
																			*Wajib
																		</small>
																	</div>
																	<input type="submit" class="d-none" id="sb-form1" />
																</form -->
			</div>
		</div>
	</div>
</div>
<!-- row -->