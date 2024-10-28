@extends('master')
@section('title', 'Dashboard')
@section('content')
	<div class="row">
		{{-- <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-info">{{ $count_jenis }}</span>
                <div class="info-box-content">
                    <span class="info-box-text">
                        <h4>Jenis Barang</h4>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-warning">{{ $count_pemesanan }}</span>
                <div class="info-box-content">
                    <span class="info-box-text">
                        <h4>Pesanan</h4>
                    </span>
                </div>
            </div>
        </div> --}}
	</div>
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

	<script>
		document.addEventListener("DOMContentLoaded", function() {
			var deleteButtons = document.querySelectorAll('.delete-btn');

			deleteButtons.forEach(function(button) {
				button.addEventListener('click', function(event) {
					event.preventDefault();
					var id = this.getAttribute('data-id');
					var confirmDelete = confirm('Apakah Anda yakin ingin menghapus pegawai ini?');

					if (confirmDelete) {
						document.getElementById('deleteForm' + id).submit();
					}
				});
			});
		});
	</script>
@endsection
