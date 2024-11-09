@extends('umkm.master')
@section('content')
	<div class="row">
		<div class="col-sm-12">
			{{-- <div class="card">
				<div class="card-header">
					<h3 class="card-title">List UMKM</h3>
				</div>
				<div class="card-body">
					<table id="example1" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Nama Usaha</th>
								<th>Jenis Usaha</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($data as $u)
								<tr>
									<td>{{ $u->nama }}</td>
									<td>{{ $u->jenis_usaha }}</td>
									<td>
										@if ($u->status == 'Cek Administrasi')
											<span class="badge badge-secondary">{{ $u->status }}</span>
										@elseif ($u->status == 'Ditolak')
											<span class="badge badge-danger">{{ $u->status }}</span>
										@elseif ($u->status == 'Diterima')
											<span class="badge badge-success">{{ $u->status }}</span>
										@elseif ($u->status == 'Diproses')
											<span class="badge badge-warning">{{ $u->status }}</span>
										@endif
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>

			</div> --}}
			<div class="card">
				<div class="card-body">
					<div class="row" style="display: flex; justify-content: center; align-items: center;">
						<img src="{{ asset('vendors/img/logo-provinsi.png') }}" alt="Logo Provinsi">
						<img src="{{ asset('vendors/img/logo-palembang.png') }}" alt="Logo Palembang">
						<img src="{{ asset('vendors/img/logo-sni.png') }}" alt="Logo SNI" style="margin-left: -60px;">
					</div>
					<br>
					<div class="row">
						<div class="col-12" style="display: flex; center-content: center; align-items: center;">
							<p></p>
						</div>
					</div>
					<div class="row">
						<div class="col-6">
							<div style="display: flex; justify-content: center; align-items: center;">
								<h4 style="margin-top: 20px"><strong>Visi</strong></h4>
							</div>
							<br>
							<div style="text-align: justify;">
								<p>“Sumatera Selatan Sejahtera, Unggul dan Terdepan”

								</p>
							</div>
						</div>
						<div class="col-6">
							<div style="display: flex; justify-content: center; align-items: center;">
								<h4 style="margin-top: 20px"><strong>Misi</strong></h4>
							</div>
							<br>
							<div style="text-align: justify">
								<ol>
									<li>Menjadikan Sumatera Selatan sebagai salah satu penggerak pertumbuhan ekonomi regional</li>
									<li>Meningkatkan pemanfaatan potensi sumberdaya alam guna penyediaan sumber energi dan pangan yang berkelanjutan
									</li>
									<li>Mewujudkan kehidupan masyarakat yang berkualitas</li>
									<li>Meningkatkan kapasitas manajemen kepemerintahan</li>
								</ol>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
