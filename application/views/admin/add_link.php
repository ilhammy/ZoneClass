<div class="row page-titles">
	<div class="col-md-5 align-self-center">
		<h3 class="text-themecolor">Tambah Link</h3>
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="/dashboard">Dashboard</a>
			</li>
			<li class="breadcrumb-item">
				<a href="/dashboard/manage_link">Kelola Link</a>
			</li>
			<li class="breadcrumb-item active">Tambah Link</li>
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

				<?php 
				if (!is_null($this->session->flashdata('alert'))) {
					echo '<div class="alert alert-info alert-rounded">' . $this->session->flashdata('alert');
					echo '</div>';
				} ?>

				<form action="" method="POST" class="mt-4" id="form1">
					<div class="form-group">
						<label>Pilih Kelas</label>
						<select class="custom-select" id="sel1" name="kelas" required>
							<option value=""><== Pilih Kelas ==></option>
								<?php foreach ($semuakelas as $val) {
									echo "<option value=\"$val->id_kelas\">$val->nama_kelas</option>";
								} ?>
							</select>
						</div>

						<div class="form-group">
							<label>Link</label>
							<input
							placeholder="https://...."
							type="url" class="form-control" name="link" required />
					</div>

					<button type="submit" class="btn btn-info waves-effect waves-light pull-right" id="sb-form1">Simpan</button>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- row -->