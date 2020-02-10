<div class="table-responsive">
    <table id="tableProduct" class="table table-bordered table-striped table-hover js-basic-example dataTable">
        <thead>
            <tr>
                <th>No</th>
                <th>Produk</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($results as $r => $result)
            <tr>
                <td>{{ $r+1 }}</td>
                <td>{{ $result->nama_barang }}</td>
                <td>{{ $result->sum }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>