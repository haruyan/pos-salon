<div class="modal-container">
    <div class="form-group form-float">
        <div class="form-line">
            <input type="text" class="form-control" value="#" id="name" name="name">
            <label class="form-label">Nama Kategori</label>
        </div>
    </div>

    <div class="form-group form-float">
        <div class="form-line">
            <input type="text" class="form-control"  id="desc" name="desc" value="#">
            <label class="form-label">Deskripsi</label>
        </div> 
    </div>
    <div class="form-group">
        <label class="form-label">Gambar Kategori Produk</label>
        <div class="input-group">
            <span class="input-group-addon">
                <a href="javascript:open_popup('/plugin/filemanager/dialog.php?type=0&amp;popup=1&amp;field_id=fieldID2')" class="btn btn-primary" type="button">Select</a>
            </span>
            <div class="form-line">
                <input id="fieldID2" type="text" name="image" class="form-control" readonly>
            </div>
        </div>
    </div>

</div>
{{-- End Form Input --}}

<div class="modal-footer">
    <button type="button" class="btn btn-link waves-effect" onclick="simpan()">SIMPAN</button>
    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">BATAL</button>
</div>
