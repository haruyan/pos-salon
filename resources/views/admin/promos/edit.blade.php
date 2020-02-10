<div class="modal-container">
    <div class="form-group">
        <select class="form-control show-tick" name="code_promo_id" id="code_promo_id">
            <option selected disabled>-- Pilih Kode Promo --</option>
            @foreach ($codepromo as $c => $cd)
                <option value="{{ $cd->id }}">{{ $c+1 }}. {{ $cd->code }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group form-float">
        <div class="form-line">
            <input type="text" class="form-control" name="name" id="name" value="#">
            <label class="form-label">Name</label>
        </div>
    </div>
    <div class="form-group form-float">
        <div class="form-line">
            <input type="text" class="form-control" name="desc" id="desc" value="#">
            <label class="form-label">Deskripsi</label>
        </div>
    </div>
    <div class="form-group form-float">
        <div class="demo-switch">
            <div class="switch">
                <label>OFF<input type="checkbox" name="active" id="active" checked><span class="lever"></span>ON</label>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="form-label">Gambar Promo </label><small> (pilih file jika ingin mengganti gambar promo)</small>
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
    <button type="submit" class="btn btn-link waves-effect" onclick="simpan()">SIMPAN</button>
    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">BATAL</button>
</div>
