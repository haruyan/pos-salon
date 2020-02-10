<div class="modal-container">
    <div class="form-group">
        <select class="form-control show-tick" name="product_id">
            <option selected disabled>-- Pilih Produk --</option>
            @foreach ($products as $p)
                <option value="{{ $p->id }}">{{ strtoupper($p->name) }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <div class="demo-radio-button">
            <input name="status" type="radio" id="radio_1" class="with-gap radio-col-blue" value="in" checked/>
            <label for="radio_1">Masuk</label>
            <input name="status" type="radio" id="radio_2" class="with-gap radio-col-pink" value="out"/>
            <label for="radio_2">Keluar</label>
        </div>
    </div>
    <div class="form-group form-float">
        <div class="form-line">
            <input type="text" class="form-control" name="amount">
            <label class="form-label">Jumlah</label>
        </div>
    </div>
    <div class="form-group form-float">
        <div class="form-line">
            <textarea type="text" class="form-control no-resize auto-growth" name="desc"></textarea>
            <label class="form-label">Keterangan</label>
        </div>
    </div>
</div>
{{-- End Form Input --}}

<div class="modal-footer">
    <button type="submit" class="btn btn-link waves-effect">SIMPAN</button>
    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">BATAL</button>
</div>
