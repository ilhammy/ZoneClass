<div class="row page-titles">
	<div class="col-md-5 align-self-center">
		<h3 class="text-themecolor">Hapus Siswa</h3>
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="/dashboard">Dashboard</a>
			</li>
			<li class="breadcrumb-item">
				<a href="/dashboard/siswa">Siswa</a>
			</li>
			<li class="breadcrumb-item active">Hapus Siswa</li>
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

				<?php 
				if (!is_null($this->session->flashdata('alert'))) {
					echo '<div class="alert alert-info alert-rounded">' . $this->session->flashdata('alert');
					echo '</div>';
				} ?>
				
				<div class="media rounded shadow py-2 px-3" style="max-width: 400px">
					<img class="d-flex mr-3" src="<?= $siswa->foto ?>" width="50" height="50" alt="Generic placeholder image" />
					<div class="media-body p-2">
						<h5 class="mt-0 mb-1"><?= $siswa->fullname ?></h5>
						<?php if (isOnlineUser($uid)) : ?>
						<span class="badge badge-primary">Online</span>
						<?php else: ?>
						<span class="badge badge-danger">Offline</span>
						<?php endif ?>
					</div>
				</div>

				<form action="/admin/home/kickSiswa" method="POST" class="mt-4" id="form1">
					<div class="form-group">
						<label>Pilih Kelas</label>
						<select class="custom-select" id="sel1" name="kelas" required>
							<option value=""><== Pilih Kelas ==></option>
								<?php foreach ($semuakelas as $val) : ?>
									<option value="<?= $val->id_kelas ?>"><?= $val->nama_kelas ?></option>
								<?php endforeach ?>
							</select>
						</div>
						<input type="hidden" name="uid" value="<?= $uid ?>" />

					<button type="submit" class="btn btn-info waves-effect waves-light pull-right" id="sb-form1">Submit</button>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- row -->