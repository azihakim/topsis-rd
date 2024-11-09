@extends('master')
@section('title', 'UMKM')
@section('content')
	<div class="card">
		<div class="card-header">
			<h3 class="card-title">Data UMKM</h3>
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
			<table id="example3" class="table-bordered table-striped table">
				<thead>
					<tr>
						<th>Nama Usaha</th>
						<th>Pemilik Usaha</th>
						<th>Status</th>
						@if (Auth::user()->role == 'Admin' || Auth::user()->role == 'Kabid')
							<th>Aksi</th>
						@endif
					</tr>
				</thead>
				<tbody>
					@foreach ($data as $item)
						<tr>
							<td>{{ $item->nama }}</td>
							<td>{{ $item->user->name }}</td>
							<td>
								@if ($item->status == 'Cek Administrasi')
									<span class="badge badge-secondary">{{ $item->status }}</span>
								@elseif ($item->status == 'Ditolak')
									<span class="badge badge-danger">{{ $item->status }}</span>
								@elseif ($item->status == 'Diterima')
									<span class="badge badge-success">{{ $item->status }}</span>
								@elseif ($item->status == 'Diproses')
									<span class="badge badge-warning">{{ $item->status }}</span>
								@endif
							</td>
							@if (Auth::user()->role == 'Admin' || Auth::user()->role == 'Kabid')
								<td>
									<div class="btn-group">
										<button type="button" class="btn btn-default dropdown-toggle fas fa-edit" data-toggle="dropdown"
											aria-expanded="false">
											<span class="sr-only">Toggle Dropdown</span>
										</button>
										<div class="dropdown-menu" role="menu">
											<a href="{{ route('umkm.detail', $item->id) }}" class="dropdown-item">Detail</a>
											<form action="{{ route('umkm.status', $item->id) }}" method="POST" style="display:inline;">
												@csrf
												@method('PUT')
												<input type="hidden" name="status" value="Ditolak">
												<button class="dropdown-item" type="submit">Tolak</button>
											</form>
											<form action="{{ route('umkm.status', $item->id) }}" method="POST" style="display:inline;">
												@csrf
												@method('PUT')
												<input type="hidden" name="status" value="Diterima">
												<button class="dropdown-item" type="submit">Terima</button>
											</form>
											<form action="{{ route('umkm.status', $item->id) }}" method="POST" style="display:inline;">
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
