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
						@if (Auth::user()->role == 'Admin' || Auth::user()->role == 'Direktur')
							<th>Aksi</th>
						@endif
					</tr>
				</thead>
				<tbody>
					@foreach ($data as $item)
						<tr>
							<td>{{ $item->nama }}</td>
							<td>{{ $item->user->name }}</td>
							@if (Auth::user()->role == 'Admin' || Auth::user()->role == 'Direktur')
								<td>
									<div class="btn-group">
										<button type="button" class="btn btn-default dropdown-toggle fas fa-edit" data-toggle="dropdown"
											aria-expanded="false">
											<span class="sr-only">Toggle Dropdown</span>
										</button>
										<div class="dropdown-menu" role="menu">
											<a href="${editUrl}" class="dropdown-item">Cek Administrasi</a>
											<form action="${deleteUrl}" method="POST" style="display:inline;">
												@csrf
												@method('DELETE')
												<button class="dropdown-item" type="submit">Tolak</button>
											</form>
											<a href="${detailUrl}" class="dropdown-item">Terima</a>
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
