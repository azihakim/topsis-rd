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
											<span class="badge badge-info">Cek Administrasi</span>
										@elseif ($u->status == 'Di Tolak')
											<span class="badge badge-danger">Di Tolak</span>
										@elseif ($u->status == 'Di Setujui')
											<span class="badge badge-success">Di Setujui</span>
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
