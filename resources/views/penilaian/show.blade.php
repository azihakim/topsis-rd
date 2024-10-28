@extends('master')
@section('title', 'Penilaian')
@section('content')
	<div class="card">
		<div class="card-header">
			<h3 class="card-title">Data Penilaian</h3>
		</div>
		<!-- /.card-header -->
		<div class="card-body">
			@if (session('success'))
				<div class="alert alert-success">
					{{ session('success') }}
				</div>
			@endif
			@if (session('error'))
				<div class="alert alert-error">
					{{ session('error') }}
				</div>
			@endif
			<table class="table-bordered table-striped table">
				<thead>
					<tr>
						<th>Nama UMKM</th>
						<th>Nilai Preferensi</th>
						<th>Ranking</th>
						<th>Status</th>
						@if (Auth::user()->role == 'Admin' || Auth::user()->role == 'Direktur')
							<th>Aksi</th>
						@endif
					</tr>
				</thead>
				<tbody>
					@foreach ($data['nilaiPreferensiDenganNama'] as $item)
						<tr>
							<td>{{ $item['nama_umkm'] }}</td>
							<td>{{ $item['nilai_preferensi'] }}</td>
							<td>{{ $item['ranking'] }}</td>
							<td>
								@php
									// Mengambil status dari objek UMKM
									$status = $item['umkm']->status ?? 'Data Tidak Ditemukan';

									// Menentukan kelas badge berdasarkan status
									$badgeClasses = [
									    'Cek Administrasi' => 'badge-secondary',
									    'Ditolak' => 'badge-danger',
									    'Diterima' => 'badge-success',
									    'Diproses' => 'badge-warning',
									];
									$badgeClass = $badgeClasses[$status] ?? 'badge-light'; // Kelas default
								@endphp
								<span class="badge {{ $badgeClass }}">{{ $status }}</span>
							</td>
							@if (Auth::user()->role == 'Admin' || Auth::user()->role == 'Direktur')
								<td>
									<div class="btn-group">
										<button type="button" class="btn btn-default dropdown-toggle fas fa-edit" data-toggle="dropdown"
											aria-expanded="false">
											<span class="sr-only">Toggle Dropdown</span>
										</button>
										<div class="dropdown-menu" role="menu">
											<a href="{{ route('umkm.detail', $item['umkm_id']) }}" class="dropdown-item">Detail</a>
											<form action="{{ route('umkm.status', $item['umkm_id']) }}" method="POST" style="display:inline;">
												@csrf
												@method('PUT')
												<input type="hidden" name="status" value="Ditolak">
												<button class="dropdown-item" type="submit">Tolak</button>
											</form>
											<form action="{{ route('umkm.status', $item['umkm_id']) }}" method="POST" style="display:inline;">
												@csrf
												@method('PUT')
												<input type="hidden" name="status" value="Diterima">
												<button class="dropdown-item" type="submit">Terima</button>
											</form>
											<form action="{{ route('umkm.status', $item['umkm_id']) }}" method="POST" style="display:inline;">
												@csrf
												@method('PUT')
												<input type="hidden" name="status" value="Diproses">
												<button class="dropdown-item" type="submit">Proses</button>
											</form>
										</div>
									</div>
								</td>
							@endif
						</tr>
					@endforeach
				</tbody>
			</table>


		</div>
		<!-- /.card-body -->
	</div>
@endsection
