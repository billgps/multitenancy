<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
<style>

*{
    box-sizing: border-box;
}

img{
    width: 250px;
    height: 200px;
}
body{
    vertical-align: middle;
}

.row {
  display: flex;
  border-bottom:1pt solid black;
  margin-bottom: 10px;
}

.row:last-child{
    border:none;
    margin: none;
}

.column {
  width: 50%;
}

table {
  border-collapse: collapse;
  border-spacing: 0;
  width: 100%   
}

th, td {
  font-size:13px;
  padding: 10px;
}

.center {
    margin-left: auto;
    margin-right: auto;
}

</style>
</head>
<body onload="window.print()">
    {{-- <script type="text/php">
        if ( isset($pdf) ) {
            $font = $fontMetrics->get_font("helvetica");
            $pdf->page_text(525, 816, "Page {PAGE_NUM} * 2 of {PAGE_COUNT}", $font, 8, array(0,0,0));
        }
    </script> --}}
    @foreach ($complains as $comp)
    <div class="row">
            <div class= "column center">
            <table>
                <header>
                    <div style="margin-left:5%;">
                    <span>
                        {{ 'Ticket ID '.$comp->id }}
                        <div style="font-size: 11px;">
                            {{ __('Created at : '.$comp->created_at) }}
                        </div>
                    </span>
                    </div>
                </header>
                <tr>
                    <td>      
                        
                        {{-- <img src="{{ url($comp->comPic) }}" onerror="this.src = '/images/no_image.jpg';"> --}}
                        <?php
                            $imgCom=isset($comp->comPic) ? url($comp->comPic):'/images/no_image.jpg';
                        ?>
                        <img src="{{$imgCom}}">  
                    </td>
                </tr>
                <tr>
                    <td>Barcode: {{ $comp->Barcode}} </td>
                </tr>
                <tr>
                    <td>Keterangan : {{ $comp->description}}</td>
                </tr>
                <tr>
                    <td>Unit : {{ $comp->room->unit}}</td>
                </tr>
                <tr>
                    <td>Ruangan : {{ $comp->room->room_name }}</td>
                </tr>
                <tr>
                    <td>Tanggal Tiket : {{ $comp->date_time }}</td>
                </tr>
            </table>
            </div>
            <div class="column center">
                <header> 
                    <div style="margin-left:5%;">
                    <span>
                        {{ 'Response ID '.$comp->response->id }}
                        <div style="font-size: 11px;">
                            {{ __('Created at : '.$comp->response->created_at) }}
                        </div>
                    </span>
                    </div>
                    </header>       
                <table>
                    <tr>
                        <td>
                            {{-- <img src="{{ url($comp->response->resPic) }}" onerror="this.src = '/images/no_image.jpg';">  --}}
                            <?php
                                $imgRes=isset($comp->response->resPic) ? url($comp->response->resPic):'/images/no_image.jpg';
                            ?>
                            <img src="{{$imgRes}}">
                        </td>
                    </tr>
                    <tr>   
                        <td>Barcode: {{$comp->response->barcode}}</td>
                    </tr>
                    <tr> 
                        <td>Keterangan : {{ $comp->response->description}}</td>
                    </tr>
                    <tr>
                        <td>Status : {{ $comp->response->status}}</td>
                    </tr>
                    <tr>
                        <td>Status Respon : {{ $comp->response->progress_status}}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Respon : {{ $comp->response->created_at}}</td>  
                    </tr>
                {{-- <tr>
                    <td style="text-align: left;";"></td>
                    <td>Nomor Seri : </td>
                    <td> {{ $inv->serial }}</td>
                </tr>
                <tr>
                    <td style="text-align: left;";"></td>
                    <td colspan="2">
                        @if (strlen($inv->barcode) < 4)
                            {{ $inv->barcode }}
                        @else
                            <img style="margin: 0px;" src="data:image/png;base64,{{ base64_encode($generatorPNG->getBarcode(substr($inv->barcode, 3), $generatorPNG::TYPE_CODE_128)) }}">
                        @endif
                    </td>
                </tr> --}}
            </table>
            </div>
        </div>
    @endforeach
</body>
</html>