<div class="modal-container">
    <div class="form-group">
        <select class="form-control show-tick" name="member_category_id" required>
            <option selected disabled>-- Pilih Kategori Member --</option>
            @foreach ($memberCat as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group form-float">
        <div class="form-line">
            <input type="text" class="form-control" name="full_name" required>
            <label class="form-label">Nama Lengkap</label>
        </div>
    </div>

    <div class="form-group form-float">
        <div class="form-line">
            <input type="text" class="form-control" name="phone" required>
            <label class="form-label">Nomor Handphone</label>
        </div>
    </div>

    <div class="form-group form-float">
        <div class="form-line">
            <input type="email" class="form-control" name="email" required>
            <label class="form-label">Email</label>
        </div>
    </div>

    <div class="form-group form-float">
        <div class="form-line">
            <textarea rows="1" name="address" class="form-control no-resize auto-growth" required></textarea>
            <label class="form-label">Alamat</label>
        </div>
    </div>

    <div class="input-group date" id="bs_datepicker_component_container">
        <div class="form-line">
            <input type="text" class="form-control" name="date_of_birth" id="date_of_birth" placeholder="Tanggal Lahir" required>
            {{-- <label for="date_of_birth" class="form-label">Tanggal Lahir</label> --}}
        </div>
        <span class="input-group-addon">Tanggal Lahir</span>
    </div>

    <div class="form-group">
        <div class="demo-radio-button">
            <input name="gender" type="radio" id="radio_1" class="with-gap radio-col-blue" value="pria" required/>
            <label for="radio_1">Pria</label>
            <input name="gender" type="radio" id="radio_2" class="with-gap radio-col-pink" value="wanita"/>
            <label for="radio_2">Wanita</label>
        </div>
    </div>

</div>
{{-- End Form Input --}}

<div class="modal-footer">
    <button type="submit" class="btn btn-link waves-effect">SIMPAN</button>
    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">BATAL</button>
</div>
