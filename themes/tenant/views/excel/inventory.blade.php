<table>
    <thead>
        <tr>
            <th colspan="16" style="text-align: center;font-weight: 300;font-size: 24pt;">
               <h3>Detail Inventory</h3> 
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="16" style="text-align: center;">
                <p>{{ $inventory->barcode }}</p>
            </td>
        </tr>
    </tbody>
</table>

<table>
    <tbody>
        <tr>
            <td></td>
            <td colspan="2">Nama Alat :</td>
            <td colspan="2" style="background-color: yellow">{{ $inventory->device->standard_name }}</td>
        </tr>
        <tr>
            <td></td>
            <td colspan="2">Merk :</td>
            <td colspan="2" style="background-color: yellow">{{ $inventory->identity->brand->brand }}</td>
        </tr>
        <tr>
            <td></td>
            <td colspan="2">Ruangan :</td>
            <td colspan="2" style="background-color: yellow">{{ $inventory->room->room_name}}</td>
        </tr>
        <tr>
            <td></td>
            <td colspan="2">Tahun Pembelian :</td>
            @isset($inventory->asset->year_pirchased)
                <td colspan="2" style="background-color: yellow">{{ $inventory->asset->year_pirchased }}</td>
            @endisset
            @empty($inventory->asset->year_pirchased)
                <td style="background-color: yellow">-</td>
            @endempty
        </tr>
        <tr>
            <td></td>
            <td colspan="2">Tipe Alat :</td>
            @isset($inventory->asset->price)
                <td colspan="2" style="background-color: yellow">{{ $inventory->asset->price }}</td>
            @endisset
            @empty($inventory->asset->price)
                <td style="background-color: yellow">-</td>
            @endempty
        </tr>
        <tr>
            <td></td>
            <td colspan="2">Ruangan :</td>
            <td colspan="2" style="background-color: yellow">{{ $inventory->identity->model}}</td>
        </tr>
        <tr>
            <td></td>
            <td colspan="2">Serial Number :</td>
            <td colspan="2" style="background-color: yellow">{{ $inventory->serial}}</td>
        </tr>
        <tr>
            <td></td>
        </tr>
        <tr>
            <td></td>
        </tr>
        <tr>
            <td></td>
        </tr>
    </tbody>
</table>

<table>
    <thead>
        <tr>
            <th colspan="9" style="text-align: center;font-size: 16pt;">
               <h3>Riwayat Kalibrasi</h3> 
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td></td>
            <td style="text-align: center;background-color: yellow">ID</td>
            <td style="text-align: center;background-color: yellow">Nomor PO</td>
            <td style="text-align: center;background-color: yellow">Tanggal Kalibrasi</td>
            <td style="text-align: center;background-color: yellow">Nomor Label</td>
            <td style="text-align: center;background-color: yellow">Status Kalibrasi</td>
            <td style="text-align: center;background-color: yellow">Hasil Kalibrasi</td>
        </tr>
        @foreach ($records as $rec)
            <tr>
                <td></td>
                <td style="text-align: center;">{{ $rec->id }}</td>
                <td style="text-align: center;">{{ $rec->activity->order_no }}</td>
                <td style="text-align: center;">{{ $rec->cal_date }}</td>
                <td style="text-align: center;">{{ $rec->label }}</td>
                <td style="text-align: center;">{{ $rec->calibration_status }}</td>
                <td style="text-align: center;">{{ $rec->result }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<table>
    <thead>
        <tr>
            <th colspan="8" style="text-align: center;font-size: 16pt;">
               <h3>Riwayat Kondisi Alat</h3> 
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td></td>
            <td style="text-align: center;background-color: yellow">ID</td>
            <td style="text-align: center;background-color: yellow">Tanggal Kejadian</td>
            <td colspan="3" style="text-align: center;background-color: yellow">Keterangan</td>
            <td style="text-align: center;background-color: yellow">Status</td>
        </tr>
        @foreach ($conditions as $cond)
            <tr>
                <td></td>
                <td style="text-align: center;">{{ $cond->id }}</td>
                <td style="text-align: center;">{{ $cond->event_date }}</td>
                <td colspan="3" style="text-align: left;">{{ $cond->event }}</td>
                <td style="text-align: center;">{{ $cond->status }}</td>
            </tr>
        @endforeach
    </tbody>
</table>