<!-- resources/views/livewire/penilaian.blade.php -->
<div>
	<div class="card">
		<div class="card-header">
			<h3 class="card-title">Penilaian</h3>
			<br>
			@if ($step == 1)
				<div class="row">
					<div class="col-sm-3">
						<div class="form-group">
							<label>Periode Penilaian</label>
							<input type="text" class="form-control" wire:model="tgl_penilaian">
							@error('periode')
								<span class="text-danger">{{ $message }}</span>
							@enderror
						</div>
					</div>
				</div>
			@endif
		</div>
		<!-- /.card-header -->
		@if ($step == 1)
			<div class="card-body">
				@foreach ($umkms as $umkm)
					<div class="row">
						<div class="col-sm-3">
							<div class="form-group">
								<label>Nama</label>
								<input disabled type="text" class="form-control" value="{{ $umkm['nama'] }}">
							</div>
						</div>
						<div class="col-sm-3">
							<div class="form-group">
								<label>Divisi</label>
								<input disabled type="text" class="form-control" value="{{ $umkm['jenis_usaha'] }}">
							</div>
						</div>
						<div class="col-sm-2">
							<div class="form-group">
								<label>Cek Detail</label>
								<a href="{{ route('umkm.detail', $umkm['id']) }}" class="btn btn-outline-info btn-block"
									target="_blank">Detail</a>
							</div>
						</div>
					</div>
					<div class="row">
						@foreach ($kriteriaPenilaian as $k)
							<div class="col-sm-2">
								<div class="form-group">
									<label>{{ $k['nama_kriteria'] }} <br> </label>
									<select wire:model="penilaianData.{{ $umkm['id'] }}.{{ $k['id'] }}" class="form-control">
										<option value="">Pilih Nilai</option>
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
										<option value="5">5</option>
									</select>
								</div>
							</div>
						@endforeach


					</div>
					<hr>
				@endforeach
				@if (session('error'))
					<div class="alert alert-error">
						{{ session('error') }}
					</div>
				@endif
				<button wire:click="storeData" class="btn btn-primary">
					Next
				</button>
			</div>
		@elseif($step == 2)
		@endif



		<!-- /.card-body -->
	</div>
</div>

{{-- @if ($step == 1)
	<div class="card-body">
		@foreach ($karyawans as $karyawan)
			<div class="row">
				<div class="col-sm-3">
					<div class="form-group">
						<label>Nama</label>
						<input disabled type="text" class="form-control" wire:model="nama_karyawan.{{ $karyawan->id }}">
					</div>
				</div>
				<div class="col-sm-3">
					<div class="form-group">
						<label>Divisi</label>
						<input disabled type="text" class="form-control" wire:model="divisi_karyawan.{{ $karyawan->id }}">
					</div>
				</div>
			</div>
			<div class="row">
				@foreach ($sub_kriteria as $item)
					<div class="col-sm-2">
						<div class="form-group">
							@if ($item->nama_sub_kriteria == 'Tepat Waktu')
								<label>{{ $item->nama_sub_kriteria }} <br> </label>
								<input required placeholder="Hari" type="number" class="form-control"
									wire:model="bobot.{{ $karyawan->id }}.{{ $item->id }}" min="0" max="{{ $item->bobot }}">
							@elseif ($item->nama_sub_kriteria == 'Total Jam Kerja')
								<label>{{ $item->nama_sub_kriteria }} <br> </label>
								<input required placeholder="Jam" type="number" class="form-control"
									wire:model="bobot.{{ $karyawan->id }}.{{ $item->id }}" min="0" max="{{ $item->bobot }}">
							@elseif ($item->nama_sub_kriteria == 'Izin Kerja')
								<label>{{ $item->nama_sub_kriteria }} <br> </label>
								<input required placeholder="Hari" type="number" class="form-control"
									wire:model="bobot.{{ $karyawan->id }}.{{ $item->id }}" min="0" max="{{ $item->bobot }}">
							@else
								<label>{{ $item->nama_sub_kriteria }} <br></label>
								<input type="number" class="form-control" wire:model="bobot.{{ $karyawan->id }}.{{ $item->id }}"
									min="0" max="{{ $item->bobot }}">
							@endif
							<div>
								@error('bobot.' . $karyawan->id . '.' . $item->id)
									<span class="text-danger">{{ $message }}</span>
								@enderror
							</div>
						</div>
					</div>
				@endforeach


			</div>
			<hr>
		@endforeach
		@if (session('error'))
			<div class="alert alert-error">
				{{ session('error') }}
			</div>
		@endif
		<button type="submit" wire:click="next" class="btn btn-primary">
			Next
		</button>
	</div>
@elseif($step == 2)
	<div class="card-body">
		<h3>Matriks Ternormalisasi (R)</h3>
		<table class="table-bordered table-striped table">
			<thead>
				<tr>
					<th>Nama Karyawan</th>
					@foreach ($data_r[0]['bobot'] as $kriteria => $details)
						<th>{{ $kriteria }}</th>
					@endforeach
				</tr>
			</thead>
			<tbody>
				@foreach ($data_r as $penilaian)
					<tr>
						<td>{{ $penilaian['nama_karyawan'] }}</td>
						@foreach ($penilaian['bobot'] as $details)
							<td>{{ $details['normalized_total'] }}</td>
						@endforeach
					</tr>
				@endforeach
			</tbody>
		</table>

		<hr>
		<br>

		<h3>Matriks Ternormalisasi Terbobot (Y)</h3>
		<table class="table-bordered table-striped table">
			<thead>
				<tr>
					<th>Nama Karyawan</th>
					@foreach ($data_y[0]['bobot'] as $kriteria => $details)
						<th>{{ $kriteria }}</th>
					@endforeach
				</tr>
			</thead>
			<tbody>
				@foreach ($data_y as $penilaian)
					<tr>
						<td>{{ $penilaian['nama_karyawan'] }}</td>
						@foreach ($penilaian['bobot'] as $details)
							<td>{{ $details['normalized_total'] }}</td>
						@endforeach
					</tr>
				@endforeach
			</tbody>
		</table>

		<hr>
		<br>

		<h3>A+</h3>
		<table class="table-bordered table-striped table">
			<thead>
				<tr>
					@foreach ($data_ap as $kriteria => $details)
						<th>{{ $kriteria }}</th>
					@endforeach
				</tr>
			</thead>
			<tbody>
				<tr>
					@foreach ($data_ap as $kriteria => $normalized_total)
						<td>{{ $normalized_total }}</td>
					@endforeach
				</tr>
			</tbody>
		</table>


		<hr>
		<br>

		<h3>A-</h3>
		<table class="table-bordered table-striped table">
			<thead>
				<tr>
					@foreach ($data_am as $kriteria => $details)
						<th>{{ $kriteria }}</th>
					@endforeach
				</tr>
			</thead>
			<tbody>
				<tr>
					@foreach ($data_am as $kriteria => $normalized_total)
						<td>{{ $normalized_total }}</td>
					@endforeach
				</tr>
			</tbody>
		</table>

		<hr>
		<br>

		<h3>D+</h3>
		<table class="table-bordered table-striped table">
			<thead>
				<tr>
					<th>Nama Karyawan</th>
					<th>Total Kuadrat</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($data_dp as $penilaian)
					<tr>
						<td>{{ $penilaian['nama_karyawan'] }}</td>
						<td>{{ $penilaian['total_kuadrat'] }}</td>
					</tr>
				@endforeach
			</tbody>
		</table>

		<hr>
		<br>

		<h3>D-</h3>
		<table class="table-bordered table-striped table">
			<thead>
				<tr>
					<th>Nama Karyawan</th>
					<th>Total Kuadrat</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($data_dm as $penilaian)
					<tr>
						<td>{{ $penilaian['nama_karyawan'] }}</td>
						<td>{{ $penilaian['total_kuadrat'] }}</td>
					</tr>
				@endforeach
			</tbody>
		</table>

		<hr>
		<br>

		<h3>Hasil Akhir</h3>
		<table class="table-bordered table-striped table">
			<thead>
				<tr>
					<th>Rank</th>
					<th>Nama Karyawan</th>
					<th>Value</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($data_final as $data)
					<tr>
						<td>{{ $data['rank'] }}</td>
						<td>{{ $data['nama_karyawan'] }}</td>
						<td>{{ $data['value'] }}</td>
					</tr>
				@endforeach
			</tbody>
		</table>


		<hr>


		<button type="submit" wire:click="cancel" class="btn btn-danger">
			Batal
		</button>
		<button type="submit" wire:click="store" class="btn btn-primary">
			Simpan
		</button>
	</div>
@endif --}}
