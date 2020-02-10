<div class="modal-container">
    <div class="form-group">
        <select class="form-control show-tick" name="code_promo_id">
            <option selected disabled>-- Pilih Kode Promo --</option>
            @foreach ($codepromo as $c => $cd)
                <option value="{{ $cd->id }}">{{ $c+1 }}. {{ $cd->code }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group form-float">
        <div class="form-line">
            <input type="text" class="form-control" name="name">
            <label class="form-label">Nama</label>
        </div>
    </div>

    <div class="form-group form-float ">
        <div class="form-line">
            <textarea type="text" class="form-control" name="desc"></textarea>
            <label class="form-label">Deskripsi</label>
        </div>
    </div>

    <div class="form-group">
        <div class="demo-switch">
            <div class="switch">
                <label>OFF<input type="checkbox" name="active"><span class="lever"></span>ON</label>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="form-label">Gambar Promo </label>
        <div class="input-group">
            <span class="input-group-addon">
                <a href="javascript:open_popup('/plugin/filemanager/dialog.php?type=0&amp;popup=1&amp;field_id=fieldID1')" class="btn btn-primary" type="button">Select</a>
            </span>
            <div class="form-line">
                <input id="fieldID1" type="text" name="image" class="form-control" readonly>
            </div>
        </div>
    </div>

</div>
{{-- End Form Input --}}

<div class="modal-footer">
    <button type="submit" class="btn btn-link waves-effect">SIMPAN</button>
    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">BATAL</button>
</div>
