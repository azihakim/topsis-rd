@extends('umkm.master')
@section('content')
	<style>
		/* Efek glowing dan pulse */
		@keyframes pulse {
			0% {
				transform: scale(1);
				box-shadow: 0 0 5px rgba(0, 255, 0, 0.8), 0 0 10px rgba(0, 255, 0, 0.6), 0 0 15px rgba(0, 255, 0, 0.4);
			}

			50% {
				transform: scale(1.05);
				box-shadow: 0 0 10px rgba(0, 255, 0, 1), 0 0 15px rgba(0, 255, 0, 0.8), 0 0 20px rgba(0, 255, 0, 0.6);
			}

			100% {
				transform: scale(1);
				box-shadow: 0 0 5px rgba(0, 255, 0, 0.8), 0 0 10px rgba(0, 255, 0, 0.6), 0 0 15px rgba(0, 255, 0, 0.4);
			}
		}

		.glowing-card {
			animation: pulse 2s infinite;
			/* Efek pulse terus menerus */
			border: 2px solid green;
			/* Garis hijau */
		}
	</style>
	<div class="row">
		<div class="col-sm-12">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>List Usaha</h1>
				</div>
				<div class="col-sm-6">
					<ol class="float-sm-right">
						<a href="{{ route('umkm.addUsaha') }}" type="button" class="btn btn-block btn-outline-primary">Tambah</a>
					</ol>
				</div>
			</div>
			<div class="card card-solid">
				<div class="card-body pb-0">
					<div class="row">
						@foreach ($data as $item)
							<div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
								<div class="card bg-light d-flex flex-fill card-item" id="card-{{ $item->id }}">
									<div class="card-header text-muted border-bottom-0"></div>
									<div class="card-body pt-0 original-content">
										<div class="row">
											<div class="col-12">
												<h2 class="lead"><b>{{ $item->nama }}</b></h2>
												<p class="text-muted text-sm"><b>Status: </b>
													<span
														class="badge {{ $item->status == 'Cek Administrasi' ? 'badge-secondary' : ($item->status == 'Ditolak' ? 'badge-danger' : ($item->status == 'Diterima' ? 'badge-success' : 'badge-warning')) }}">
														{{ $item->status }}
													</span>
												</p>
												<ul class="ml-4 mb-0 fa-ul text-muted">
													<li class="small"><span class="fa-li"><i class="fas fa-lg fa-store"></i></span> Alamat:
														{{ $item->alamat }}</li>
													<li class="small"><span class="fa-li"><i class="fas fa-lg fa-edit"></i></span> Jenis/Izin Usaha:
														{{ $item->jenis_usaha }}/{{ $item->perizinan_usaha }}</li>
												</ul>
											</div>
										</div>
									</div>
									<div class="card-footer text-right">
										<a href="#" class="btn btn-sm bg-teal proses-btn" data-id="{{ $item->id }}"
											data-status="{{ $item->status }}">Proses Seleksi</a>
										<a href="{{ route('umkm.cetakPendaftaran', $item->id) }}" class="btn btn-sm btn-primary">
											<i class="fas fa-print"></i> Cetak
										</a>
									</div>
								</div>
							</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>

	<script>
		document.addEventListener('DOMContentLoaded', function() {
			document.querySelectorAll('.proses-btn').forEach(function(button) {
				button.addEventListener('click', function(event) {
					event.preventDefault();

					// Get the card ID and elements
					const cardId = this.getAttribute('data-id');
					const cardElement = document.getElementById(`card-${cardId}`);
					const originalContent = cardElement.querySelector('.original-content');
					const footer = cardElement.querySelector('.card-footer');
					const status = this.getAttribute('data-status');

					// Check if the card is displaying the timeline
					if (cardElement.classList.contains('timeline-view')) {
						// Restore original content
						cardElement.classList.remove('timeline-view');
						originalContent.style.display = 'block';
						this.textContent = 'Proses Seleksi';

						// Remove the timeline
						const timelineDiv = cardElement.querySelector('.timeline');
						timelineDiv.remove();

						// Remove glowing effect if status is "Diterima"
						if (status === 'Diterima') {
							cardElement.classList.remove('glowing-card');
						}
					} else {
						// Hide the original content and add timeline view
						cardElement.classList.add('timeline-view');
						originalContent.style.display = 'none';
						this.textContent = 'Kembali';

						// Timeline content based on status
						let timelineHTML = '';

						// Create timeline based on status
						if (status === 'Cek Administrasi') {
							timelineHTML = `
                        <div class="timeline">
                            <div class="time-label">
                                <span class="bg-primary">Mulai Proses</span>
                            </div>
                            <div>
                                <i class="fas fa-check-circle bg-blue"></i>
                                <div class="timeline-item">
                                    <h3 class="timeline-header">Cek Dokumen dan Penilaian</h3>
                                </div>
                            </div>
                            <div>
                                <i class="fas fa-edit bg-grey"></i>
                                <div class="timeline-item">
                                    <h3 class="timeline-header">Proses Penilaian</h3>
                                </div>
                            </div>
                            <div>
                                <i class="fas fa-trophy bg-grey"></i>
                                <div class="timeline-item">
                                    <h3 class="timeline-header">Hasil</h3>
                                </div>
                            </div>
                        </div>
                    `;
						} else if (status === 'Diproses') {
							timelineHTML = `
                        <div class="timeline">
                            <div class="time-label">
                                <span class="bg-primary">Mulai Proses</span>
                            </div>
                            <div>
                                <i class="fas fa-check-circle bg-blue"></i>
                                <div class="timeline-item">
                                    <h3 class="timeline-header">Cek Dokumen dan Penilaian</h3>
                                </div>
                            </div>
                            <div>
                                <i class="fas fa-edit bg-green"></i>
                                <div class="timeline-item">
                                    <h3 class="timeline-header">Proses Penilaian</h3>
                                </div>
                            </div>
                            <div>
                                <i class="fas fa-trophy bg-grey"></i>
                                <div class="timeline-item">
                                    <h3 class="timeline-header">Hasil</h3>
                                </div>
                            </div>
                        </div>
                    `;
						} else if (status === 'Ditolak') {
							timelineHTML = `
                        <div class="timeline">
                            <div class="time-label">
                                <span class="bg-primary">Mulai Proses</span>
                            </div>
                            <div>
                                <i class="fas fa-check-circle bg-blue"></i>
                                <div class="timeline-item">
                                    <h3 class="timeline-header">Cek Dokumen dan Penilaian</h3>
                                </div>
                            </div>
                            <div>
                                <i class="fas fa-times bg-red"></i>
                                <div class="timeline-item">
                                    <h3 class="timeline-header">Ditolak</h3>
                                </div>
                            </div>
                        </div>
                    `;
						} else if (status === 'Diterima') {
							timelineHTML = `
                        <div class="timeline">
                            <div class="time-label">
                                <span class="bg-primary">Mulai Proses</span>
                            </div>
                            <div>
                                <i class="fas fa-check-circle bg-blue"></i>
                                <div class="timeline-item">
                                    <h3 class="timeline-header">Cek Dokumen dan Penilaian</h3>
                                </div>
                            </div>
                            <div>
                                <i class="fas fa-edit bg-green"></i>
                                <div class="timeline-item">
                                    <h3 class="timeline-header">Proses Penilaian</h3>
                                </div>
                            </div>
                            <div>
                                <i class="fas fa-trophy bg-purple"></i>
                                <div class="timeline-item">
                                    <h3 class="timeline-header">Diterima</h3>
                                </div>
                            </div>
                        </div>
                    `;

							// Apply glowing effect to card when status is 'Diterima'
							cardElement.classList.add('glowing-card');
						}

						// Inject timeline HTML based on the status
						originalContent.insertAdjacentHTML('afterend', timelineHTML);
					}
				});
			});
		});
	</script>
@endsection
