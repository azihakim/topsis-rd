<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .card-body {
            margin: 20px;
        }

        h3 {
            margin-top: 20px;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .btn {
            padding: 10px 15px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            margin: 5px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
        }
    </style>
</head>

<body>
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

        <button type="submit" wire:click="cancel" class="btn btn-danger">Batal</button>
        <button type="submit" wire:click="store" class="btn btn-primary">Simpan</button>
    </div>
</body>

</html>
