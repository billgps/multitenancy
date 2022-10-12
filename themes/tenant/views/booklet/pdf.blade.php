<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="ISO-8859-1">
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
            background-size: contain;
            font-family: Arial, Helvetica, sans-serif;
            padding: 60px 10px 66px 60px;
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
            align-content: center;
            vertical-align: middle;
        }

        .chip {
            padding: 8px 10px;
            border-radius: 25px;
            /* font-weight: 600;
            font-size: 12px; */
            box-shadow: 0 2px 5px rgba(0,0,0,.25);
            margin: 0 10px;
            text-align: center;            
        }

        .chip.primary {
            background: rgba(167, 243, 208, 1);
            color: rgba(5, 150, 105, 1);
        }

        .chip.secondary {
            background-color: rgba(254,226,226, 1);
            color: rgba(185,28,28, 1);
        }

        @page {
            /* margin: 60px 10px 66px 50px; */
        }
    </style>
</head>
<body background="{{ public_path('/booklet_template.jpg') }}" style="background-size: contain;">
    {{-- <script type="text/php">
        if ( isset($pdf) ) {
            $font = $fontMetrics->get_font("helvetica");
            $pdf->page_text(525, 816, "Page {PAGE_NUM} * 2 of {PAGE_COUNT}", $font, 8, array(0,0,0));
        }
    </script> --}}
    <div id="contents">
        @php
            $generatorPNG = new Picqer\Barcode\BarcodeGeneratorPNG();
        @endphp

        @foreach ($inventories as $inv)
            <table>
                <tr>
                    <td rowspan="6" style="text-align: center;">
                        <div 
                            style="
                                width: 178px; 
                                height: 134px;
                                margin: 0px;
                                padding: 0px;
                                background-image: url({{ public_path($inv->picture) }}); 
                                background-size: contain;
                                background-repeat: no-repeat;">
                        </div>
                    </td>
                    <td style="width: 50px;"></td>
                    <td>Nama Alat : </td>
                    <td colspan="3"> {{ $inv->device->standard_name }}</td>
                    <td rowspan="6" style="text-align: center;">
                        <div>
                            @php
                            $barcode = trim(str_replace("‘","",$inv->barcode));
                            @endphp
                            @if (strlen($barcode) < 4)
                                {{$barcode}}
                                @else
                                @php
                                $qrcode = QrCode::size(100)
                                    ->format('svg')
                                    ->generate(substr($barcode, 3, strlen($barcode)));
                                @endphp
                                <img width="100" src="data:image/png;base64,{{ base64_encode($qrcode) }}">
                            @endif
                            </div>
                    </td>
                    <td style="width: 50px;"></td>
                </tr>
                <tr>
                    <td style="width: 50px;"></td>
                    <td>Merk : </td>
                    <td> {{ $inv->identity->brand->brand }}</td>
                </tr>
                <tr>
                    <td style="width: 50px;"></td>
                    <td>Ruangan : </td>
                    <td> {{ $inv->room->room_name }}</td>
                    <td>
                        @if ($inv->latest_record->result == "Laik")
                            <div class="chip primary">
                                Laik
                            </div>
                        @else
                            <div class="chip secondary">
                                Tidak Laik
                            </div>   
                        @endif
                    </td>
                </tr>
                <tr>
                    <td style="width: 50px;"></td>
                    <td>Tipe Alat : </td>
                    <td> {{ $inv->identity->model }}</td>
                </tr>
                <tr>
                    <td style="width: 50px;"></td>
                    <td>Nomor Seri : </td>
                    <td> {{ $inv->serial }}</td>
                </tr>
                <tr>
                    <td rowspan="2"></td>
                    <td>Tanggal Kalibrasi : </td>
                    <td>{{ date('d-m-Y', strtotime($inv->latest_record->cal_date)) }}</td>
                </tr>
                <tr>
                    <td rowspan="2"></td>
                    <td>Tanggal Expired : </td>
                    <td>{{ date('d-m-Y', strtotime('+1 year',strtotime($inv->latest_record->cal_date))) }}</td>
                </tr>
            </table>
        @endforeach
    </div>
</body>
</html>