@extends('umkm.master')
@section('content')
	<div class="row">
		<div class="col-sm-12">
			<div class="card">
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

			</div>
		</div>
	</div>
@endsection
