@extends('umkm.master')
@section('content')
	<div class="row">
		<div class="col-sm-12">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>List Usaha</h1>
				</div>
				<div class="col-sm-6">
					<ol class="float-sm-right">
						<a href="{{ route('umkm.addUsaha') }}" type="button" class="btn btn-block btn-outline-primary">Tambah</a>
					</ol>
				</div>
			</div>
			<div class="card card-solid">
				<div class="card-body pb-0">
					<div class="row">
						@foreach ($data as $item)
							<div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
								<div class="card bg-light d-flex flex-fill">
									<div class="card-header text-muted border-bottom-0">

									</div>
									<div class="card-body pt-0">
										<div class="row">
											<div class="col-12">
												<h2 class="lead"><b>{{ $item->nama }}</b></h2>
												<p class="text-muted text-sm"><b>Status: </b>
													@if ($item->status == 'Cek Administrasi')
														<span class="badge badge-info">Cek Administrasi</span>
													@elseif ($item->status == 'Di Tolak')
														<span class="badge badge-danger">Di Tolak</span>
													@elseif ($item->status == 'Di Setujui')
														<span class="badge badge-success">Di Setujui</span>
													@endif
												</p>
												<ul class="ml-4 mb-0 fa-ul text-muted">
													<li class="small"><span class="fa-li"><i class="fas fa-lg fa-cart-plus"></i></span> Produk:
														{{ $item->nama_produk }}
													<li class="small"><span class="fa-li"><i class="fas fa-lg fa-store"></i></span> Alamat:
														{{ $item->alamat }}</li>
													<li class="small"><span class="fa-li"><i class="fas fa-lg fa-edit"></i></span> Jenis/Izin Usaha:
														{{ $item->jenis_usaha }}/{{ $item->perizinan_usaha }}</li>
												</ul>
											</div>
										</div>
									</div>
									<div class="card-footer">
										<div class="text-right">
											{{-- <a href="#" class="btn btn-sm bg-teal">
												Edit
											</a> --}}
											<a href="{{ route('umkm.cetakPendaftaran', $item->id) }}" class="btn btn-sm btn-primary">
												<i class="fas fa-print"></i> Cetak
											</a>
										</div>
									</div>
								</div>
							</div>
						@endforeach
					</div>
				</div>

				<div class="card-footer">
					{{-- <nav aria-label="Contacts Page Navigation">
						<ul class="pagination justify-content-center m-0">
							<li class="page-item active"><a class="page-link" href="#">1</a></li>
							<li class="page-item"><a class="page-link" href="#">2</a></li>
							<li class="page-item"><a class="page-link" href="#">3</a></li>
							<li class="page-item"><a class="page-link" href="#">4</a></li>
							<li class="page-item"><a class="page-link" href="#">5</a></li>
							<li class="page-item"><a class="page-link" href="#">6</a></li>
							<li class="page-item"><a class="page-link" href="#">7</a></li>
							<li class="page-item"><a class="page-link" href="#">8</a></li>
						</ul>
					</nav> --}}
				</div>

			</div>
		</div>
	</div>
@endsection
