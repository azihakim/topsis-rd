@extends('umkm.master')
@section('content')
	<div class="row">
		<div class="col-sm-12">
			<div class="card card-info">
				<div class="card-header">
					<h3 class="card-title">Form Registrasi UMKM</h3>
				</div>

				<form action="{{ route('umkm.storeUsaha') }}" class="form-horizontal">
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
