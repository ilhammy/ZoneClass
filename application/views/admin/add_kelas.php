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
		<button class="d-none btn
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

				<?php $msg = validation_errors() . $this->session->flashdata('newclass');
				if (!is_null($msg) && !empty($msg)) {
					$alertType = strpos($msg, "Berhasil");
					echo '<div class="alert alert-' .$alertType. ' alert-rounded">' . $msg;
					echo '</div>';
				} ?>

				<form action="" method="POST" class="mt-4" id="form1">
					<div class="form-group">
						<label>Nama Kelas</label>
						<input value="<?= set_value('nama_kelas') ?>" type="text" class="form-control" name="nama_kelas" autocomplete="off" required />
					<small class="form-text text-muted">*Wajib</small>
				</div>

				<div class="form-group">
					<label>Nama Pengurus</label>
					<input value="<?= profileValue('fullname') ?>" type="text" class="form-control" disabled />
			</div>

			<div class="form-group">
				<label>Apakah memiliki akses khusus?</label>
				<div class="custom-control custom-radio">
					<input type="radio" id="customRadio1" name="hasAkses" value="ya" class="custom-control-input" />
				<label class="custom-control-label" for="customRadio1">Ya</label>
			</div>
			<div class="custom-control custom-radio">
				<input type="radio" id="customRadio2" name="hasAkses" value="tidak" class="custom-control-input" checked />
			<label class="custom-control-label" for="customRadio2">Tidak</label>
		</div>
	</div>

	<button type="submit" class="btn btn-info waves-effect waves-light pull-right" id="sb-form1">Simpan</button>
</form>
</div>
</div>


</div>
</div>
<!-- row -->