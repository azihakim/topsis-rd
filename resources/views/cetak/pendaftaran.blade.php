<!DOCTYPE html>
<html lang="id">

<head>
	<meta charset="UTF-8">
	<title>Seleksi Tenant</title>
	<style>
		body {
			font-family: Arial, sans-serif;
			margin: 0;
			padding: 20px;
		}

		.header {
			display: flex;
			justify-content: space-between;
			align-items: center;
			margin-bottom: 20px;
		}

		.header img {
			width: auto;
			height: 60px;
			/* Adjusted the logo size */
		}

		h1 {
			text-align: center;
			color: #000;
			margin-top: 0;
		}

		table {
			width: 100%;
			border-collapse: collapse;
			margin-top: 20px;
		}

		th {
			text-align: left;
			width: 25%;
			/* Adjusted to balance column width */
			padding: 8px;
			vertical-align: top;
		}

		td {
			padding: 8px;
		}

		.signature {
			margin-top: 40px;
			text-align: right;
		}
	</style>
</head>

<body>

	<div class="header">
		<img src="{{ public_path('vendors/img/logo-provinsi.png') }}" alt="Logo Provinsi">
		<img src="{{ public_path('vendors/img/logo-palembang.png') }}" alt="Logo Palembang">
		<img src="{{ public_path('vendors/img/logo-sni.png') }}" alt="Logo SNI" style="margin-left: 310;">
	</div>

	<h1>Seleksi Tenant</h1>
	<p>Saya yang bertanda tangan dibawah ini:</p>
	<table>
		<tr>
			<th>Nama</th>
			<td>: {{ $data->user->name }}</td>
		</tr>
		<tr>
			<th>Domisili</th>
			<td>: {{ $data->user->domisili }}</td>
		</tr>
		<tr>
			<th>Nomor Hp</th>
			<td>: {{ $data->user->no_hp }}</td>
		</tr>
		<tr>
			<th>Email</th>
			<td>: {{ $data->user->username }}</td>
		</tr>
	</table>

	<p>Mengajukan permintaan untuk diseleksi sebagai tenant pada Inkubator Bisnis Sriwijaya Bisnis Center dengan informasi
		sebagai berikut:</p>

	<table>
		<tr>
			<th>Nama Usaha</th>
			<td>: {{ $data->nama }}</td>
		</tr>
		<tr>
			<th>Alamat Usaha</th>
			<td>: {{ $data->alamat }}</td>
		</tr>
		<tr>
			<th>Telepon</th>
			<td>: {{ $data->telepon }}</td>
		</tr>
		<tr>
			<th>Email</th>
			<td>: {{ $data->email }}</td>
		</tr>
		<tr>
			<th>Jenis Usaha</th>
			<td>: {{ $data->jenis_usaha }}</td>
		</tr>
		<tr>
			<th>Bentuk Legalitas</th>
			<td>
				<ul>
					@foreach (json_decode($data->legalitas, true) as $legalitas)
						<li>{{ $legalitas }}</li>
					@endforeach
				</ul>
			</td>
		</tr>

	</table>

	<div class="signature">
		<p>Palembang, {{ \Carbon\Carbon::parse($data->created_at)->locale('id')->translatedFormat('d F Y') }}</p>
		<p>Tenant</p>
	</div>

</body>

</html>
