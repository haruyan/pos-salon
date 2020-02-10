<div class="modal-container">
    <div class="form-group">
        <select class="form-control show-tick" name="product_id">
            <option selected disabled>-- Pilih ID Produk --</option>
            @foreach ($products as $p)    
                <option value="{{ $p->id }}">{{ $p->id }} : {{ $p->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group form-float">
        <div class="form-line">
            <input type="text" class="form-control" name="amount">
            <label class="form-label">Jumlah</label>
        </div>
    </div>
</div>
{{-- End Form Input --}}

<div class="modal-footer">
    <button type="submit" class="btn btn-link waves-effect">TAMBAH</button>
    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">BATAL</button>
</div>
