<table>
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Jenis</th>
            <th>Jumlah</th>
            <th>Keterangan</th>
            <th>Akun</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($transactions as $t)
            <tr>
                <td>{{ $t->tanggal }}</td>
                <td>{{ ucfirst($t->jenis) }}</td>
                <td>{{ $t->jumlah }}</td>
                <td>{{ $t->keterangan }}</td>
                <td>{{ $t->account->nama_akun}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
