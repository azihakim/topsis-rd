@extends('umkm.master')
@section('content')
	<div class="row">
		<div class="col-sm-12">
			<div class="card card-info">
				<div class="card-header">
					<h3 class="card-title">Form Registrasi UMKM</h3>
				</div>

				<form action="{{ route('umkm.storeRegist') }}" class="form-horizontal">
					<div class="card-body">
						<h4>Identitas Pendaftar</h4>
						<div class="row">
							<div class="col-sm-3">
								<div class="form-group">
									<label>Nama</label>
									<input name="name" type="text" class="form-control">
								</div>
							</div>
							<div class="col-sm-3">
								<div class="form-group">
									<label>Domisili</label>
									<input name="domisili" type="text" class="form-control">
								</div>
							</div>
							<div class="col-sm-3">
								<div class="form-group">
									<label>Nomor HP</label>
									<input name="no_hp" type="text" class="form-control">
								</div>
							</div>
							<div class="col-sm-3">
								<div class="form-group">
									<label>Email</label>
									<input name="email" type="email" class="form-control">
								</div>
							</div>
						</div>
						<hr>
						{{-- <h4>Identitas Usaha</h4>
						<div class="row">
							<div class="col-sm-3">
								<div class="form-group">
									<label>Nama Usaha</label>
									<input type="text" class="form-control">
								</div>
							</div>
							<div class="col-sm-3">
								<div class="form-group">
									<label>Alamat Usaha</label>
									<input type="text" class="form-control">
								</div>
							</div>
							<div class="col-sm-3">
								<div class="form-group">
									<label>Telepon Usaha</label>
									<input type="text" class="form-control">
								</div>
							</div>
							<div class="col-sm-3">
								<div class="form-group">
									<label>Email</label>
									<input type="email" class="form-control">
								</div>
							</div>
							<div class="col-sm-3">
								<div class="form-group">
									<label>Bentuk Legalitas</label>
									<input type="text" class="form-control">
								</div>
							</div>
							<div class="col-sm-3">
								<div class="form-group">
									<label>Nama Merek Produk</label>
									<input type="text" class="form-control">
								</div>
							</div>
							<div class="col-sm-3">
								<div class="form-group">
									<label>Jenis Usaha</label>
									<input type="text" class="form-control">
								</div>
							</div>
							<div class="col-sm-3">
								<div class="form-group">
									<label>Perizinan Usaha</label>
									<input type="text" class="form-control">
								</div>
							</div>
						</div> --}}
					</div>

					<div class="card-footer">
						<button type="submit" class="btn btn-info float-right">Sign in</button>
					</div>

				</form>
			</div>
		</div>
	</div>
@endsection
