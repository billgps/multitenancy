<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Booklet</title>

        <style>
            body {
                font-family: Arial, Helvetica, sans-serif;
            }

            table {
                font-size: 12px;
            }
        </style>
    </head>
    <body>
        @php
            $generatorPNG = new Picqer\Barcode\BarcodeGeneratorPNG();
        @endphp
  
        <table>
            @foreach ($inventories as $inv)
                <tr>
                    <td rowspan="8">
                        <img src="{{ public_path($inv->picture) }}" width="210" height="191">
                    </td>
                    <td>Nama Alat : </td>
                    <td> {{ $inv->device->standard_name }}</td>
                </tr>
                <tr>
                    <td>Merk : </td>
                    <td> {{ $inv->identity->brand->brand }}</td>
                </tr>
                <tr>
                    <td>Ruangan : </td>
                    <td> {{ $inv->room->room_name }}</td>
                </tr>
                <tr>
                    <td>Tahun Pembelian : </td>
                    <td> {{ $inv->asset->year_purchased }}</td>
                </tr>
                <tr>
                    <td>Harga : </td>
                    <td> {{ $inv->asset->price }}</td>
                </tr>
                <tr>
                    <td>Tipe Alat : </td>
                    <td> {{ $inv->identity->model }}</td>
                </tr>
                <tr>
                    <td>Nomor Seri : </td>
                    <td> {{ $inv->serial }}</td>
                </tr>
                <tr>
                    <td colspan="3">
                        <img src="data:image/png;base64,{{ base64_encode($generatorPNG->getBarcode(substr($inv->barcode, 3), $generatorPNG::TYPE_CODE_128)) }}">
                    </td>
                </tr>
            @endforeach
        </table>
    </body>
</html>