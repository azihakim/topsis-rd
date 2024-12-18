@extends('master')
@section('title', 'Penilaian')
@section('content')
	<div class="card">
		<div class="card-header">
			<h3 class="card-title">Data Penilaian</h3>
			@if (Auth::user()->role != 'Karyawan' && Auth::user()->role != 'Kabid')
				<a href="{{ route('penilaian.create') }}" class="btn btn-primary float-right">Tambah Penilaian</a>
			@endif
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
						<th>Periode</th>
						<th>Cek Penilaian</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($penilaian as $item)
						<tr>
							<td>
								{{ $item->periode }}
							</td>
							<td>
								<a href="{{ route('penilaian.show', $item->id) }}" class="btn btn-block btn-outline-info">Cek</a>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		<!-- /.card-body -->
	</div>
@endsection
