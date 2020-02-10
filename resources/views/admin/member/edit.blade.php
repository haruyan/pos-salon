<div class="modal-container">
        <div class="form-group">
            <select class="form-control show-tick" name="member_category_id" id="member_category_id" required>
                <option selected disabled>-- Pilih Kategori Member --</option>
                @foreach ($memberCat as $category)
                    <option value="{{ $category->id }}">{{ strtoupper($category->name) }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group form-float">
            <div class="form-line">
                <input type="text" value="#" class="form-control" name="full_name" id="full_name" required>
                <label class="form-label">Nama Lengkap</label>
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-sm-6">
                <div class="form-group form-float">
                    <div class="form-line">
                        <input type="text" value="#" class="form-control" name="phone" id="phone" required>
                        <label class="form-label">Nomor Handphone</label>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group form-float">
                    <div class="form-line">
                        <input type="email" value="#" class="form-control" name="email" id="email" required>
                        <label class="form-label">Email</label>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="form-group form-float">
            <div class="form-line">
                <textarea rows="1" name="address" id="address" class="form-control no-resize auto-growth" required>#</textarea>
                <label class="form-label">Alamat</label>
            </div>
        </div>

        <div class="input-group date" id="bs_datepicker_container">
            <div class="form-line">
                <input type="text" value="2019-07-18" class="form-control" name="date_of_birth" id="date_of_birth" required>
            </div>
            <span class="input-group-addon">Tanggal Lahir</span>
        </div>

        <div class="form-group">
            <div class="demo-radio-button">
                <input name="gender2" id="radio_3" type="radio" class="with-gap radio-col-blue" value="pria" required/>
                <label for="radio_3">Pria</label>
                <input name="gender2" id="radio_4" type="radio" class="with-gap radio-col-pink" value="wanita"/>
                <label for="radio_4">Wanita</label>
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-sm-6">
                <div class="form-group form-float">
                    <div class="form-line">
                        <input type="text" value="#" class="form-control" name="barcode" id="barcode" disabled>
                        <label class="form-label">Barcode</label>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <div class="form-line">
                        <label class="form-label">Masa Berlaku</label>
                        <input type="date" value="#" class="form-control" name="expired" id="expired">
                    </div>
                </div>
            </div>
        </div>

    </div>
    {{-- End Form Input --}}

<div class="modal-footer">
    <button type="submit" class="btn btn-link waves-effect" onclick="simpan()">SIMPAN</button>
    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">BATAL</button>
</div>
