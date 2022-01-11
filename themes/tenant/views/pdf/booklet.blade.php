<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Booklet</title>

    <style>
        html{
            width: 100%;
            height: 100%;
            padding: 0;
            margin: 0;
        }

        body {
            /* background-image: url('https://miro.medium.com/max/2000/1*7fjKqWmqMrryq0XLkHbjTg.png'); */
            background-size: contain;
            font-family: Arial, Helvetica, sans-serif;
            padding: 60px 10px 66px 50px;
            margin: 0px;
        }

        /* #contents {
            margin: 60px 10px 66px 50px;
        } */

        table {
            font-size: 12px;
            margin-top: 30px;
            break-inside: avoid;
            page-break-inside: avoid;
        }

        table td {
            padding: 2px;
            margin: 0px;
            align-content: center;
            text-align: center;
            vertical-align: middle;
        }

        @page {
            /* margin: 60px 10px 66px 50px; */
        }
    </style>
</head>
<body style="">
    <img src="https://miro.medium.com/max/2000/1*7fjKqWmqMrryq0XLkHbjTg.png" alt="">
    <script type="text/php">
        if ( isset($pdf) ) {
            $font = $fontMetrics->get_font("helvetica");
            $pdf->page_text(525, 816, "Page {PAGE_NUM} of {PAGE_COUNT}", $font, 8, array(0,0,0));
        }
    </script>
    <div id="contents">
        @php
            $generatorPNG = new Picqer\Barcode\BarcodeGeneratorPNG();
        @endphp

        @foreach ($inventories as $inv)
            <table>
                <tr>
                    <td rowspan="6">
                        {{-- <div 
                            style="
                                width: 178px; 
                                height: 134px;
                                margin: 0px;
                                padding: 0px;
                                background-image: url({{ public_path($inv->picture) }}); 
                                background-size: contain;
                                background-repeat: no-repeat;">
                        </div> --}}
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
                    <td>Tipe Alat : </td>
                    <td> {{ $inv->identity->model }}</td>
                </tr>
                <tr>
                    <td>Nomor Seri : </td>
                    <td> {{ $inv->serial }}</td>
                </tr>
                <tr>
                    <td colspan="3">
                        @if (strlen($inv->barcode) < 4)
                            {{ $inv->barcode }}
                        @else
                            <img style="margin: 0px;" src="data:image/png;base64,{{ base64_encode($generatorPNG->getBarcode(substr($inv->barcode, 3), $generatorPNG::TYPE_CODE_128)) }}">
                        @endif
                    </td>
                </tr>
            </table>
        @endforeach
    </div>
</body>
</html>