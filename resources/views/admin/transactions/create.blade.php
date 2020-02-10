<div class="modal-container">
    <div class="form-group">
        <select class="form-control show-tick" name="cashier">
            <option selected disabled>-- Pilih Kasir --</option>
            @foreach ($user as $t)    
                <option value="{{ $t->id }}">{{ $t->id }} : {{ $t->full_name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group form-float">
        <div class="form-line">
            <input type="text" class="form-control" name="trx_number" autocomplete="off">
            <label class="form-label">No. Transaksi</label>
        </div>
    </div>
    <div class="form-group form-float">
        <div class="form-line">
            <input type="number" class="form-control" name="buyer" autocomplete="off">
            <label class="form-label">Pembeli</label>
        </div>
    </div>
    <div class="form-group form-float">
        <div class="form-line">
            <input type="text" class="form-control" name="promo" autocomplete="off">
            <label class="form-label">Promo</label>
        </div>
    </div>
    <div class="form-group form-float">
        <div class="form-line">
            <input type="text" class="form-control" name="item" autocomplete="off">
            <label class="form-label">Item</label>
        </div>
    </div>
    <div class="form-group form-float">
        <div class="form-line">
            <input type="number" class="form-control" name="totel" autocomplete="off">
            <label class="form-label">Total</label>
        </div>
    </div>
</div>
{{-- End Form Input --}}

<div class="modal-footer">
    <button type="submit" class="btn btn-link waves-effect">TAMBAH</button>
    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">BATAL</button>
</div>
