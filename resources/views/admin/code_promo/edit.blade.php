<div class="modal-container">

        <div class="input-group form-float">
            <label class="form-label">Promo Code</label>
            <div class="form-line">
                <input type="text" class="form-control" v-model="formAddPromoCode" placeholder="Promo Code" name="kode" required>
            </div>
            <span class="input-group-addon">
                <Button type="button" class="btn btn-primary" @click="generateCode">Generate</Button>
            </span>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group form-float">
                    <label class="form-label">Start Date</label>
                    <div class="form-line">
                        <input type="date" class="form-control" id="formAddStartDate" v-model="formAddStartDate" name="start" required>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group form-float">
                    <label class="form-label">End Date</label>
                    <div class="form-line">
                        <input type="date" class="form-control" v-model="formAddEndDate" name="end" required>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Discount Type</label>
            <div class="demo-radio-button">
                <input name="tipe_potongan" value="amount" type="radio" id="radio_1" checked />
                <label for="radio_1">Jumlah Potongan (Rp)</label>
                <input name="tipe_potongan" value="percent" type="radio" id="radio_2" />
                <label for="radio_2">Persentase Diskon (%)</label>
            </div>
        </div>


        <div class="form-group form-float" v-if="discountType == 'amount'">
            <div class="form-line">
                <input type="text" class="form-control" v-model="formAddAmount" name="amount" required>
                <label class="form-label">Amount</label>
            </div>
        </div>

        <div class="form-group form-float" v-if="discountType == 'percent'">
            <div class="form-line">
                <input type="number" class="form-control" max="100" min="0" v-model="formAddDiscount" name="discount" required>
                <label class="form-label">Discount</label>
            </div>
        </div>
        <div class="form-group form-float">
            <div class="form-line">
                <input type="number" class="form-control" v-model="formAddMinimum" name="minimum">
                <label class="form-label">Minimum</label>
            </div>
        </div>

        <h4>Pengaturan Produk</h4>
        <div class="form-group">
            <label class="form-label">Apakah promo berlaku untuk semua Produk ?</label>
            <div>
                <div class="btn-group">
                    <button type="button" :class="{'btn':true,'btn-primary':allProduct}" @click="allProduct=true">Semua</button>
                    <button type="button" :class="{'btn':true,'btn-primary':!allProduct}" @click="allProduct=false">Sebagian</button>
                </div>
            </div>
        </div>

        <div :class="{'form-group':true,'hide':allProduct}" >
            <label class="form-label">Pilih Kategori untuk menyertakan produk dalam kategori</label>
            <select class="form-control show-tick" id="categorySelected" data-live-search="true" multiple>
                <option value="" disabled>Pilih Kategori</option>
                @foreach ($productCategories as $category)
                    <option value="{{$category->id}}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <hr>
        <h4 v-if="!allProduct && categories.length > 0">Pengaturan Kategori Produk</h4>
        <div :class="{'hide':(allProduct && categories.length == 0)}" v-for="(category) in categories">
            <h5>
                Kategori @{{ productCategoriesOnDB[category] }}
            </h5>
            <div>
                <div class="btn-group">
                    <button type="button" :class="{'btn btn-sm':true,'bg-purple':categorySetting[category]}" @click="changeCategorySetting(category,true)">Semua</button>
                    <button type="button" :class="{'btn btn-sm':true,'bg-purple':!categorySetting[category]}" @click="changeCategorySetting(category,false)">Sebagian</button>
                </div>
            </div>
            <div class="form-group" v-if="productByCategory[category] && productByCategory[category].length > 0">
                <br>
                <label class="form-control">Pilih Produk</label>
                <v-select :options="productByCategory[category]" 
                        required 
                        v-model="selectedProductByCategory[category]" 
                        :reduce="category => category.id"
                        label="name" multiple></v-select>
            </div>
            <hr>
        </div>
    </div>
    {{-- End Form Input --}}

    <div class="modal-footer">
        <button type="submit" class="btn btn-link waves-effect">SIMPAN</button>
        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">BATAL</button>
    </div>