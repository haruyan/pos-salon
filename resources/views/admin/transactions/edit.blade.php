<div class="modal-container">
    <div class="row clearfix">
        <div class="col-md-6">
            <div class="form-group">
                <div class="form-line autofocus">
                    <label class="form-label">No. Transaksi</label>
                    <input type="text" class="form-control" name="trx_number" id="trx_number" value=" " disabled>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <div class="form-line autofocus">
                    <label class="form-label">Waktu Transaksi</label>
                    <input type="text" class="form-control" name="dateTime" id="dateTime" value=" " disabled>
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-md-6">
            <div class="form-group">
                <div class="form-line autofocus">
                    <label class="form-label">Pembeli</label>
                    <input type="text" class="form-control" name="buyer" id="buyer" value=" " disabled>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <div class="form-line autofocus">
                    <label class="form-label">Kasir</label>
                    <input type="text" class="form-control" name="cashier" id="cashier" value=" " disabled>
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-md-6">
            <div class="form-group">
                <div class="form-line autofocus">
                    <label class="form-label">Promo</label>
                    <input type="text" class="form-control" name="promo" id="promo" value=" " disabled>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <div class="form-line autofocus">
                    <label class="form-label">Total Pembayaran</label>
                    <input type="text" class="form-control" name="total" id="total" value=" " disabled>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="form-label">List Item</label>
        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Item</th>
                        <th>Harga Satuan</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                        <th>Potongan</th>
                    </tr>
                </thead>
                <tbody id="itemList">
                    {{-- item list --}}
                </tbody>
            </table>
        </div>
        {{-- Table Responsive End --}}
    </div>
</div>
{{-- End Form Input --}}

<div class="modal-footer">
    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">TUTUP</button>
</div>
