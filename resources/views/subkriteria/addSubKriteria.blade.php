@extends('master')
@section('title', 'Tambah Sub Kriteria')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Form Tambah Sub Kriteria</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('subkriteria.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Kriteria</label>
                                    <select required class="form-control" name="kriteria_id">
                                        <option value="">Pilih</option>
                                        @foreach ($data as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama_kriteria }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Sub Kriteria</label>
                                    <input required name="nama_sub_kriteria" type="text" class="form-control"
                                        placeholder="Masukkan Sub Kriteria">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Bobot</label>
                                    <input min="0" required name="bobot" type="number" class="form-control"
                                        placeholder="Masukkan Bobot">
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.getElementById('foto').addEventListener('change', function() {
            var fileInput = this;
            var maxSize = 500 * 1024; // 500KB dalam bytes
            var files = fileInput.files;

            if (files.length > 0) {
                var fileSize = files[0].size; // Mendapatkan ukuran file pertama yang dipilih
                if (fileSize > maxSize) {
                    alert('Ukuran file melebihi batas maksimum (500KB). Silakan pilih file lain.');
                    fileInput.value = ''; // Menghapus file yang sudah dipilih
                }
            }
        });
    </script>
@endsection
