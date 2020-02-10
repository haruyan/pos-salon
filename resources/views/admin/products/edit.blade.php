<div class="modal-container">
    <div class="form-group">
        <p>
            <b>Kategori Produk</b>
        </p>
        <select class="form-control show-tick" name="product_category_id" id="editProductCategory">
            <option selected disabled>Pilih Kategori Produk </option>
            @foreach ($category as $c => $p)
                <option value="{{ $p->id }}">{{ $c+1 }}. {{ strtoupper($p->name) }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group form-float">
        <div class="form-line focused">
            <input type="text" class="form-control" id="editName" name="name">
            <label class="form-label">Nama Produk</label>
        </div>
    </div>
    <div class="form-group form-float">
        <div class="form-line focused">
            <textarea type="text" class="form-control no-resize auto-growth" value="" id="editDesc" name="desc"></textarea>
            <label class="form-label">Deskripsi</label>
        </div>
    </div>
    <div class="form-group form-float">
        <div class="form-line focused">
            <input type="text" class="form-control" id="editStock" name="stock">
            <label class="form-label">Stok</label>
        </div>
    </div>

    <div class="row clearfix">
        <div class="col-sm-6">
            <div class="form-group">
                <label class="form-label">Gambar Produk</label>
                <div class="input-group">
                    <div class="form-line">
                        <input id="fieldID2" type="text" name="image" class="form-control" readonly>
                    </div>
                    <span class="input-group-addon">
                        <a href="javascript:open_popup('/plugin/filemanager/dialog.php?type=0&amp;popup=1&amp;field_id=fieldID2')" class="btn btn-primary" type="button">Select</a>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <h5 class="card-inside-title">Jenis Produk</h5>
                <div class="demo-radio-button">
                    <input name="type2" id="radio_3" type="radio" class="with-gap radio-col-blue" value="product" required/>
                    <label for="radio_3">Produk</label>
                    <input name="type2" id="radio_4" type="radio" class="with-gap radio-col-pink" value="service"/>
                    <label for="radio_4">Jasa</label>
                </div>
            </div>
        </div>
    </div>
    
    <hr>
    <h4 class="card-inside-title">
        Pengaturan Harga
        <small>Masukkan Harga Berdasarkan Kategori Member</small>
    </h4>
    <div class="row clearfix">
        @foreach ($memberCategories as $indexCategory => $category)
        <div class="col-md-4">
            <p>
                <small><b>{{ strtoupper($category->name) }}</b></small>
            </p>
            <div class="input-group">
                <span class="input-group-addon">Rp</span>
                <div class="form-line">
                    <input type="text" class="form-control" placeholder="Masukkan Harga" id="editPrices[{{ $category->id }}]" name="prices[]" {{ ($indexCategory == 0 ) ? "required" : ""  }}>
<!--                     {{-- <input type="text" class="form-control" placeholder="Masukkan Harga" name="prices[]" {{ ($p == 0 ) ? "required" : ""  }}> --}} -->
                    <input type="hidden" class="form-control" name="id_cat_members[]" value="{{ $category->id }}">
                </div>
            </div>
        </div>
        @endforeach
    </div>

</div>
    {{-- End Form Input --}}

    <div class="modal-footer">
        <button type="submit" class="btn btn-link waves-effect" onclick="simpan()">SIMPAN</button>
        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">BATAL</button>
    </div>
