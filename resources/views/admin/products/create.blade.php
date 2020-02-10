<div class="modal-container">
    <div class="form-group">
        <select class="form-control show-tick" name="product_category_id">
            <option selected disabled>-- Pilih Kategori Produk --</option>
            @foreach ($category as $c => $p)
                <option value="{{ $p->id }}">{{ $c+1 }}. {{ strtoupper($p->name) }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group form-float">
        <div class="form-line">
            <input type="text" class="form-control" name="name">
            <label class="form-label">Nama Produk</label>
        </div>
    </div>
    <div class="form-group form-float">
        <div class="form-line">
            <textarea type="text" class="form-control no-resize auto-growth" name="desc"></textarea>
            <label class="form-label">Deskripsi</label>
        </div>
    </div>
    <div class="form-group form-float">
        <div class="form-line">
            <input type="text" class="form-control" name="stock">
            <label class="form-label">Stok (isi 0 untuk jenis produk "jasa")</label>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-sm-6">
            <div class="form-group">
                <label class="form-label">Gambar Produk</label>
                <div class="input-group">
                    <div class="form-line">
                        <input id="fieldID1" type="text" name="image" class="form-control" readonly>
                    </div>
                    <span class="input-group-addon">
                        <a href="javascript:open_popup('/plugin/filemanager/dialog.php?type=0&amp;popup=1&amp;field_id=fieldID1')" class="btn btn-primary" type="button">Select</a>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <h2 class="card-inside-title">Jenis Produk</h2>
                <div class="demo-radio-button">
                    <input name="type" id="radio_1" type="radio" class="with-gap radio-col-blue" value="product" required/>
                    <label for="radio_1">Produk</label>
                    <input name="type" id="radio_2" type="radio" class="with-gap radio-col-pink" value="service"/>
                    <label for="radio_2">Jasa</label>
                </div>
            </div>
        </div>
    </div>
    

    <h2 class="card-inside-title">
        Daftar Harga
        <small>Masukkan Harga Berdasarkan Kategori Member</small>
    </h2>
    <div class="row clearfix">
        @foreach ($memberCategories as $p => $category)
        <div class="col-md-4">
            <p>
                <small><b>{{ $category->name }}</b></small>
            </p>
            <div class="input-group">
                <span class="input-group-addon">Rp</span>
                <div class="form-line">
                    <input type="text" class="form-control" placeholder="Masukkan Harga" name="prices[]" {{ ($p == 0 ) ? "required" : ""  }}>
                    <input type="hidden" class="form-control" placeholder="Masukkan Harga" name="id_cat_members[]" value="{{ $category->id }}">
                </div>
            </div>
        </div>
        @endforeach
    </div>

</div>
{{-- End Form Input --}}

<div class="modal-footer">
    <button type="submit" class="btn btn-link waves-effect">SIMPAN</button>
    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">BATAL</button>
</div>