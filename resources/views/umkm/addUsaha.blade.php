@extends('umkm.master')
@section('content')
	<div class="row">
		<div class="col-sm-12">
			<div class="card card-info">
				<div class="card-header">
					<h3 class="card-title">Form Registrasi UMKM</h3>
				</div>

				<!-- Update form to allow file upload -->
				<form action="{{ route('umkm.storeUsaha') }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
					@csrf <!-- Token CSRF untuk keamanan -->
					<div class="card-body">
						<h4>Identitas Usaha</h4>
						<div class="row">
							<div class="col-sm-3">
								<div class="form-group">
									<label>Nama Usaha</label>
									<input name="nama" type="text" class="form-control">
								</div>
							</div>
							<div class="col-sm-3">
								<div class="form-group">
									<label>Alamat Usaha</label>
									<input name="alamat" type="text" class="form-control">
								</div>
							</div>
							<div class="col-sm-3">
								<div class="form-group">
									<label>Telepon Usaha</label>
									<input name="telepon" type="text" class="form-control">
								</div>
							</div>
							<div class="col-sm-3">
								<div class="form-group">
									<label>Email</label>
									<input name="email" type="email" class="form-control">
								</div>
							</div>
							<div class="col-sm-3">
								<div class="form-group">
									<label>Bentuk Legalitas</label>
									<input name="legalitas" type="text" class="form-control">
								</div>
							</div>
							<div class="col-sm-3">
								<div class="form-group">
									<label>Nama Merek Produk</label>
									<input name="nama_produk" type="text" class="form-control">
								</div>
							</div>
							<div class="col-sm-3">
								<div class="form-group">
									<label>Jenis Usaha</label>
									<input name="jenis_usaha" type="text" class="form-control">
								</div>
							</div>
							<div class="col-sm-3">
								<div class="form-group">
									<label>Perizinan Usaha</label>
									<input name="perizinan_usaha" type="text" class="form-control">
								</div>
							</div>

							<!-- Input File Upload Proposal -->
							<div class="col-sm-3">
								<div class="form-group">
									<label>Proposal Usaha (PDF)</label>
									<input name="proposal" type="file" class="form-control-file" accept=".pdf">
								</div>
							</div>

							<!-- Input File Upload Legalitas Usaha -->
							<div class="col-sm-3">
								<div class="form-group">
									<label>Dokumen Legalitas (PDF)</label>
									<input name="legalitas" type="file" class="form-control-file" accept=".pdf">
								</div>
							</div>
						</div>
					</div>

					<div class="card-footer">
						<button type="submit" class="btn btn-info float-right">Daftar</button>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection
