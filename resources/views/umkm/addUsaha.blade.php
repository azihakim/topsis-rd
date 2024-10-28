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

							<!-- Input File Upload Proposal -->
							<div class="col-sm-3">
								<div class="form-group">
									<label>Proposal Usaha (PDF)</label>
									<input name="proposal" type="file" class="form-control-file" accept=".pdf">
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group">
									<label>Legalitas</label>
									<div class="row">
										<div class="col-sm-4">
											<div class="custom-control custom-radio">
												<input class="custom-control-input" type="radio" id="customRadio1" name="nama_legalitas" value="NIB">
												<label for="customRadio1" class="custom-control-label">NIB</label>
											</div>
										</div>
										<div class="col-sm-4">
											<div class="custom-control custom-radio">
												<input class="custom-control-input" type="radio" id="customRadio2" name="nama_legalitas"
													value="Sertifikat Halal">
												<label for="customRadio2" class="custom-control-label">Sertifikat Halal</label>
											</div>
										</div>
										<div class="col-sm-4">
											<div class="custom-control custom-radio">
												<input class="custom-control-input" type="radio" id="customRadio3" name="nama_legalitas" value="HKI/Merk">
												<label for="customRadio3" class="custom-control-label">HKI/Merk</label>
											</div>
										</div>
										<div class="col-sm-4">
											<div class="custom-control custom-radio">
												<input class="custom-control-input" type="radio" id="customRadio4" name="nama_legalitas" value="PIRT">
												<label for="customRadio4" class="custom-control-label">PIRT</label>
											</div>
										</div>
										<div class="col-sm-4">
											<div class="custom-control custom-radio">
												<input class="custom-control-input" type="radio" id="customRadio5" name="nama_legalitas" value="BPOM">
												<label for="customRadio5" class="custom-control-label">BPOM</label>
											</div>
										</div>
										<div class="col-sm-4">
											<div class="custom-control custom-radio">
												<input class="custom-control-input" type="radio" id="customRadio6" name="nama_legalitas" value="SNI">
												<label for="customRadio6" class="custom-control-label">SNI</label>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-3">
								<div class="form-group">
									<label>Nomor Legalitas</label>
									<input name="legalitas" type="text" class="form-control">
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
