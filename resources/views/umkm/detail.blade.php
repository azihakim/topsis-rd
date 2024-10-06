@extends('master')

@section('css')
	<style>
		.timeline-header {
			cursor: pointer;
			transition: background-color 0.3s ease;
		}

		.timeline-header:hover {
			background-color: #f5f5f5;
		}

		.timeline-body {
			display: none;
			overflow: hidden;
			transition: max-height 0.3s ease-out;
		}

		.timeline-body.open {
			display: block;
			max-height: 500px;
		}
	</style>
	<style>
		#timeline-content {
			overflow: hidden;
			max-height: 0;
			transition: max-height 0.2s ease-out;
			background: #f9f9f9;
		}

		#timeline-content.show {
			max-height: 100%;
		}
	</style>
@endsection

@section('content_header')
	<h1>Detail Penilaian</h1>
@stop

@section('content')
	<div class="card">
		<div class="card-header">
			<h3 class="card-title">Penilaian</h3>
			<div class="card-tools">
				<a type="button" class="btn btn-tool" href="#">
					<i class="fas fa-times"></i>
				</a>
			</div>
		</div>
		<div class="card-body">
			<div class="row">
				<div class="col-12 col-md-12 col-lg-7 order-1 order-md-1">
					<div class="row">
						<div class="col-12">
							<h2><strong>Nama</strong> - Jabatan</h2>
							<div class="post clearfix">
								<p>Status Penilaian: <span class="right badge badge-danger">Belum Selesai</span>&nbsp;
									<a href="#" id="ubah-status-link" class="link-black text-sm">
										<i class="fas fa-edit mr-1"></i> Ubah status
									</a>
									<br>
									Tanggal Mulai Penilaian: 01 Januari 2023
									<br>
									Tanggal Berakhir Penilaian: 31 Desember 2023
								</p>
							</div>
						</div>
					</div>
					<h4>Hasil Penilaian</h4>
					<div class="row">
						<div class="col-12 col-sm-3">
							<div class="info-box bg-light">
								<div class="info-box-content">
									<span class="info-box-text text-center text-muted">TOTAL</span>
									<span class="badge badge-danger">Cukup</span>
									<span class="info-box-number text-center text-muted mb-0">1.00</span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-12 col-md-12 col-lg-5 order-2 order-md-2">
					<div class="text-muted">
						<p class="text-sm">Sudah Melakukan Penilaian
						<div class="text-sm row" style="margin-top: -15px">
							<div class="d-block col-sm-6">
								<strong>Nama Penilai</strong> - Jabatan Penilai
							</div>
						</div>
						</p>
						<p class="text-sm">Belum Melakukan Penilaian
						<div class="text-sm row" style="margin-top: -15px">
							<div class="d-block col-sm-6">
								<span class="right badge badge-warning">Tidak ada data</span>
							</div>
						</div>
						</p>
					</div>
					<div class="col-sm-12">
						<div class="btn-group">
							<a class="btn btn-sm btn-outline-success" id="detail-penilaian-btn"><i class="fas fa-edit"></i> Hasil
								Penilaian</a>
							<a target="_blank" href="#" class="btn btn-sm btn-outline-primary"><i class="fas fa-link"></i> Generate
								Link</a>
							<a target="_blank" href="#" class="btn btn-sm btn-outline-danger"><i class="fas fa-print"></i> Rekap Semua
								Penilaian</a>
							<a target="_blank" class="btn btn-sm btn-outline-info" data-toggle="modal" data-target="#modal-default"><i
									class="fas fa-exclamation-triangle"></i> Cara Penilaian</a>
							<div class="modal fade" id="modal-default">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title">Informasi Penilaian</h4>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>
										<div class="modal-body">
											<p>Bobot Penilaian:</p>
											<ul>
												<li>Cukup: 1 Poin</li>
												<li>Baik: 2 Poin</li>
												<li>Memuaskan: 3 Poin</li>
											</ul>
											<p>Keterangan:</p>
											<p style="text-align: justify">Dijumlahkan poin yang didapatkan per formulir penilaian kemudian dibagi dengan
												jumlah soal pada formulir tersebut. Kemudian untuk mendapatkan nilai per divisi, dilakukan penjumlahan skor
												akhir yang didapatkan di divisi yang sama tersebut kemudian dibagi dengan jumlah divisi tersebut. Skor akhir
												penilaian didapatkan dengan menjumlahkan seluruh skor akhir tiap divisi kemudian dibagi banyak divisi</p>
										</div>
										<div class="modal-footer justify-content-between">
											<button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div id="timeline-content" class="timeline" style="display: none;">
				<div class="time-label">
					<span class="bg-info">01 Januari 2023, 12:00</span>
					<form action="#" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');"
						style="display: inline;">
						<button type="submit" class="btn btn-outline-danger btn-sm">
							<i class="fa fa-trash"></i>
						</button>
					</form>
					<a href="#" class="btn btn-outline-warning btn-sm" target="_blank">
						<i class="fa fa-print"></i>
					</a>
				</div>
				<div>
					<i class="fas fa-user bg-blue"></i>
					<div class="timeline-item">
						<div class="timeline-header"><strong>Nama Penilai</strong> - Jabatan Penilai</div>
						<div class="timeline-body">
							<div class="table-responsive p-0">
								<table class="table table-head-fixed text-nowrap table-bordered">
									<thead style="text-align: center">
										<tr>
											<th rowspan="2" style="vertical-align: middle; width:5%">No</th>
											<th rowspan="2" style="vertical-align: middle; width:30%">Pertanyaan</th>
											<th colspan="3">Jawaban</th>
											<th rowspan="2" style="vertical-align: middle;">Keterangan</th>
										</tr>
										<tr>
											<th style="width: 5%">Cukup</th>
											<th style="width: 5%">Baik</th>
											<th style="width: 5%">Memuaskan</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td style="text-align: center">1</td>
											<td>Pertanyaan 1</td>
											<td style="text-align: center"><i class="nav-icon fas fa-check"></i></td>
											<td style="text-align: center"></td>
											<td style="text-align: center"></td>
											<td>Keterangan 1</td>
										</tr>
									</tbody>
									<tfoot>
										<tr>
											<td colspan="2" style="text-align: center;"><strong>Total</strong></td>
											<td style="text-align: center;"><strong>1</strong></td>
											<td style="text-align: center;"><strong>0</strong></td>
											<td style="text-align: center;"><strong>0</strong></td>
											<td></td>
										</tr>
									</tfoot>
								</table>
							</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label>Komentar Tambahan</label>
										<textarea readonly class="form-control" rows="3" placeholder="Tidak ada komentar tambahan."></textarea>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('js')
	<script>
		$(document).ready(function() {
			$(document).on('click', '.delete-button', function(event) {
				event.preventDefault();
				Swal.fire({
					title: 'Konfirmasi Penghapusan',
					text: "Apakah Anda yakin ingin menghapus data ini?",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Hapus'
				}).then((result) => {
					if (result.isConfirmed) {
						Swal.fire(
							'Terhapus!',
							'Data berhasil dihapus.',
							'success'
						).then(function() {
							location.reload();
						});
					}
				});
			});
		});
	</script>

	<script>
		document.addEventListener('DOMContentLoaded', function() {
			const timelineItems = document.querySelectorAll('.timeline-item');
			timelineItems.forEach(function(item) {
				const header = item.querySelector('.timeline-header');
				const body = item.querySelector('.timeline-body');
				body.style.maxHeight = '0';
				header.addEventListener('click', function() {
					if (body.classList.contains('open')) {
						body.classList.remove('open');
						body.style.maxHeight = '0';
					} else {
						body.classList.add('open');
						body.style.maxHeight = body.scrollHeight + 'px';
					}
				});
			});
		});
	</script>

	<script>
		document.addEventListener('DOMContentLoaded', function() {
			$('#ubah-status-link').on('click', function(event) {
				event.preventDefault();
				Swal.fire({
					title: 'Pilih Status',
					text: "Silakan pilih status baru.",
					icon: 'question',
					input: 'radio',
					inputOptions: {
						'1': 'Selesai',
						'0': 'Belum Selesai'
					},
					inputValidator: (value) => {
						if (!value) {
							return 'Anda harus memilih salah satu!';
						}
					},
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Ubah'
				}).then((result) => {
					var selectedStatus = result.value;
					Swal.fire(
						'Disimpan!',
						'Status berhasil diubah.',
						'success'
					).then(function() {
						location.reload();
					});
				});
			});
		});
	</script>

	<script>
		document.addEventListener('DOMContentLoaded', function() {
			var btn = document.getElementById('detail-penilaian-btn');
			var content = document.getElementById('timeline-content');
			btn.addEventListener('click', function() {
				if (content.classList.contains('show')) {
					content.classList.remove('show');
					setTimeout(function() {
						content.style.display = 'none';
					}, 500);
				} else {
					content.style.display = 'block';
					setTimeout(function() {
						content.classList.add('show');
					}, 10);
				}
			});
		});
	</script>

	@if (session('success'))
		<script>
			Swal.fire(
				'Berhasil!',
				'{{ session('success') }}',
				'success'
			);
		</script>
	@endif
@endsection
