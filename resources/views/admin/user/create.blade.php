<div class="modal-container">
    <div class="form-group">
        <select class="form-control show-tick" name="user_role">
            <option selected disabled>-- Pilih Role --</option>
            <option value="admin">ADMIN</option>
            <option value="kasir">KASIR</option>
        </select>
    </div>

    <div class="form-group form-float">
        <div class="form-line">
            <input type="text" class="form-control" name="full_name">
            <label class="form-label">Nama Lengkap</label>
        </div>
    </div>

    <div class="form-group form-float">
        <div class="form-line">
            <input type="text" class="form-control" name="username">
            <label class="form-label">Username</label>
        </div>
    </div>

    <div class="form-group form-float">
        <div class="form-line">
            <input type="email" class="form-control" name="email">
            <label class="form-label">Email</label>
        </div>
    </div>

    <div class="form-group form-float">
        <div class="form-line">
            <input type="text" class="form-control" name="phone">
            <label class="form-label">Nomor HP</label>
        </div>
    </div>

    <div class="form-group form-float">
        <div class="form-line">
            <textarea rows="1" name="address" class="form-control no-resize auto-growth"></textarea>
            <label class="form-label">Alamat</label>
        </div>
    </div>

    <div class="form-group form-float">
        <div class="form-line">
            <input type="password" class="form-control" name="password">
            <label class="form-label">Password</label>
        </div>
    </div>

    <div class="form-group form-float">
        <div class="form-line">
            <input type="password" class="form-control" name="password_confirmation">
            <label class="form-label">Re-Type Password</label>
        </div>
    </div>

    <div class="form-group">
        <label class="form-label">Avatar</label>
        <div class="input-group">
            <span class="input-group-addon">
                <a href="javascript:open_popup('/plugin/filemanager/dialog.php?type=0&amp;popup=1&amp;field_id=fieldID1')" class="btn btn-primary" type="button">Select</a>
            </span>
            <div class="form-line">
                <input id="fieldID1" type="text" name="avatar" class="form-control" readonly>
            </div>
        </div>
    </div>

</div>
{{-- End Form Input --}}

<div class="modal-footer">
    <button type="submit" class="btn btn-link waves-effect">SIMPAN</button>
    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">BATAL</button>
</div>
