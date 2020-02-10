@extends('layouts.template')

{{-- Title --}}
@section('title', 'Kelola Kode Promo')

{{-- Plugin --}}
@include('partials.datatable')
@include('partials.form')
@include('partials.sweetalert')

{{-- Content --}}
@section('content')
<!-- Basic DataTable -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    Kelola Code Promo
                </h2>
                <ul class="header-dropdown">
                    <button type="button" class="btn bg-blue m-r-15 waves-effect" data-toggle="modal" data-target="#modalAdd" @click="resetForm">
                        <i class="material-icons">add</i>
                        <span>TAMBAH CODE PROMO</span>
                    </button>
                </ul>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Start</th>
                                <th>End</th>
                                <th>Amount</th>
                                <th>Discount</th>
                                <th>Minimum</th>
                                <th>Menu</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Start</th>
                                <th>End</th>
                                <th>Amount</th>
                                <th>Discount</th>
                                <th>Minimum</th>
                                <th>Menu</th>
                            </tr>
                        </tfoot>
                        <tbody>
                                @foreach ($codepromo as $u => $row)
                                <tr>
                                    <td>{{ $u+1 }}</td>
                                    <td>{{ $row->code }}</td>
                                    <td>{{ $row->start }}</td>
                                    <td>{{ $row->end }}</td>
                                    <td>{{ $row->amount }}</td>
                                    <td>{{ $row->discount }}</td>
                                    <td>{{ $row->minimum}}</td>
                                    <td>
                                        <form action="{{ route('codepromo.destroy', $row->id)}}" method="post" id="swal-datatable-{{ $row->id }}">
                                            @csrf
                                            @method('DELETE')
                                            {{-- <a href="{{ route('products.edit',$product->id) }}">
                                                <button type="button" class="btn btn-success waves-effect">
                                                    <i class="material-icons">create</i>
                                                </button>
                                            </a> --}}
                                            <button type="button" class="btn btn-success waves-effect" data-toggle="modal" data-target="#modalAdd" @click="editPromoCode({{$row->id}})">
                                                <i class="material-icons">create</i>
                                            </button>
                                            <button type="submit" class="btn btn-danger waves-effect" onclick="deleteThis({{$row->id}})">
                                                <i class="material-icons">delete</i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- #END# Basic DataTable -->
<!-- Create Modal Dialogs -->
<div class="modal fade p-t-5" id="modalAdd" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalAddLabel">TAMBAH CODE PROMO</h4>
                </div>
                <form v-on:submit.prevent="actionAddPromo">
                    {{-- @include('admin.code_promo.create') --}}

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
                                    <input name="tipe_potongan" value="amount" type="radio" id="radio_1" :checked="discountType == 'amount'"/>
                                    <label for="radio_1">Jumlah Potongan (Rp)</label>
                                    <input name="tipe_potongan" value="percent" type="radio" id="radio_2" :checked="discountType == 'percent'"/>
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
                    
                          <h4>Pengaturan Promo</h4>
                            <div class="form-group">
                                <label class="form-label">Apakah promo berlaku untuk total pembelian atau item ?</label>
                                <div>
                                    <div class="btn-group">
                                        <button type="button" :class="{'btn':true,'btn-primary':totalBeli}" @click="changeTotalBeli(true)">Total</button>
                                        <button type="button" :class="{'btn':true,'btn-primary':!totalBeli}" @click="changeTotalBeli(false)">Item</button>
                                    </div>
                                </div>
                            </div>
                      
                            <h4  :class="{'hide':totalBeli}">Pengaturan Produk</h4>
                            <div :class="{'form-group':true,'hide':totalBeli}" >
                                <label class="form-label">Apakah promo berlaku untuk semua Produk ?</label>
                                <div>
                                    <div class="btn-group">
                                        <button type="button" :class="{'btn':true,'btn-primary':allProduct}" @click="changeSemuaProduk(true)">Semua</button>
                                        <button type="button" :class="{'btn':true,'btn-primary':!allProduct}" @click="changeSemuaProduk(false)">Sebagian</button>
                                    </div>
                                </div>
                            </div>
                    
                            <div :class="{'form-group':true,'hide':(allProduct || totalBeli)}" >
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
                            <div :class="{'hide':(!allProduct && categories.length == 0)}" v-for="(category) in categories">
                                <h5>
                                    Kategori @{{ productCategoriesOnDB[category] }}
                                </h5>
                                <div>
                                    <div class="btn-group">
                                        <button type="button" :class="{'btn btn-sm':true,'bg-purple':categorySetting[category]}" @click="changeCategorySetting(category,true)">Semua</button>
                                        <button type="button" :class="{'btn btn-sm':true,'bg-purple':!categorySetting[category]}" @click="changeCategorySetting(category,false)">Sebagian</button>
                                    </div>
                                </div>
                                <div class="form-group" v-if="productByCategory[category] !=null && productByCategory[category].length > 0">
                                    <br>
                                    <label class="form-control">Pilih Produk</label>
                                    <multiselect 
                                        v-model="selectedProductByCategory[category]" 
                                        :options="productByCategory[category]"
                                        label="name"
                                        :show-labels="true"
                                        :multiple="true" 
                                        :close-on-select="false" 
                                        :clear-on-select="false" 
                                        :preserve-search="true" 
                                        placeholder="Pick some" 
                                        label="name" track-by="name" 
                                        placeholder="Pick a value">
                                            {{-- <template slot="selection" slot-scope="{ values, search, isOpen }"><span class="multiselect__single" v-if="values.length &amp;&amp; !isOpen">@{{ values.length }} options selected</span></template> --}}
                                        </multiselect>
                                    
                                </div>
                                <hr>
                            </div>
                        </div>
                        {{-- End Form Input --}}
                    
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-link waves-effect">SIMPAN</button>
                            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">BATAL</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
    <!-- #END# Create Modal Dialogs -->
    <!-- Edit Modal Dialogs -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="largeModalLabel">EDIT CODE PROMO</h4>
            </div>
            <form id="formEdit" action="/" method="POST">
                @method('PATCH')
                <input type="hidden" id="id-modal" name="id-modal"/>
                @csrf
                {{-- @include('admin.code_promo.edit') --}}
            </form>
        </div>
    </div>
</div>
<!-- #END# Edit Modal Dialogs -->
@endsection

@section('end-scripts-extra')
    <script type="text/javascript">
        function editThis(id) {
            event.preventDefault();
            var form = document.querySelector('#formEdit');

            axios.get('/api/v1/codepromo/'+id)
                .then(response => {
                    if(response.data.error) {
                    } else {
                        input = response.data;
                        form.reset();
                        $('#amount').val(input.amount);
                        $('#start').val(input.start);
                        $('#end').val(input.end);
                        $('#discount').val(input.discount);
                        $('#cashback').val(input.cashback);
                        $('#minimum').val(input.minimum);
                        $('#id-modal').val(id);
                        $('#editModal').modal('show');
                    }
                })
                .catch(error => {
                    let errors = ""
                    try {
                        errors = Object.values(error.response.data.errors).map(msg => msg[0])
                        errors = errors.join()
                    } catch(e) {
                        error = "Gagal Mengambil Data Code Promo"
                    }
                })

        }
        function simpan(){
            event.preventDefault();
            var form = document.querySelector('#formEdit');
            var data = new FormData(form);
            var id_modal= $("#id-modal").val();

            console.log(data);
            console.log(id_modal);

            axios.post('/codepromo/'+id_modal,data)
                .then(response => {
                    if(response.data.error) {
                        console.log('succes error');
                        console.log(response.data);

                    } else {
                        console.log('success success');
                        console.log(response.data);
                        swal({
                            title: 'Success',
                            text:"Berhasil Mengubah Data",
                            type:"success",
                            timer: 1000,
                            showConfirmButton: false
                        }, function() {
                            window.location.reload();
                        });
                        form.reset();
                        $('#editModal').modal('hide')
                    }
                })
                .catch(error => {
                    let errors = ""
                    console.log(error);
                    console.log('errors');
                    try {
                        errors = Object.values(error.response.data.errors).map(msg => msg[0])
                        errors = errors.join()
                        console.log(errors);
                    } catch(e) {
                        error = "Gagal Mengubah Data Product"
                    }
                    swal({
                        title: "Gagal",
                        text:errors,
                        type: 'error'
                    });
                })
        }
    </script>

    <script>
        var app = new Vue({
            el: '#app',
            data: {
                totalBeli:true,
                discountType: "amount",
                allProduct: false,
                productCategoriesOnDB: [],
                categories: [],
                categorySetting: [], // true is all, while false is some
                productByCategory: [], // list of product by chosen category
                selectedProductByCategory: [], // list of product chosen from product by category
                formAddPromoCode: null,
                formAddStartDate: null,
                formAddEndDate: null,
                formAddAmount: 0,
                formAddDiscount: 0,
                formAddMinimum: 0,
                isEditing: false,
                promoId: null,
            },
            mounted() {
                var dataCat = JSON.stringify('{!! json_encode($productCategories->toArray()) !!}');
                // preparing data category from database
                const pc = JSON.parse(dataCat)
                for(category of pc) {
                    this.productCategoriesOnDB[category.id] = category.name
                }

              
                $('input[name="tipe_potongan"]').on('change', this.changeDiscountType )
                $('input[name="flagSemuaProduk"]').on('change', this.changeSemuaProduk )
                $('#categorySelected').on('change', this.changeCategorySelected )
            },
            methods: {
                changeTotalBeli(event){
                  this.totalBeli = event;
                 
                  if(this.totalBeli){
                    this.allProduct = false;
                    this.categories = [];
                    this.categorySetting = [];
                    $('#categorySelected').val(this.categories).trigger('change')
                    console.log(this.categories)
                  }
                  else{
                    this.allProduct=true;
                  }
                  console.log("log:"+event)
                },
                changeDiscountType(event) {
                    this.discountType = event.target.value
                    $('input[name="tipe_potongan"]').filter('[value="'+this.discountType+'"]').attr('checked', true);
                },
                changeSemuaProduk(event) {
                    console.log("apakah semua?", event)
                  this.allProduct = event
                  if(this.allProduct){
                    this.categories = [];
                    this.categorySetting = [];
                    $('#categorySelected').val(this.categories).trigger('change')
                    console.log(this.categories)
                  }
                },
                changeCategorySelected(event) {
                    console.log($('#categorySelected').val())
                    this.categories = $('#categorySelected').val() ? $('#categorySelected').val():[]
                  
                    if(this.categories != null || this.categories.length >0) {
                        for(cat of this.categories) {
                            this.categorySetting[cat] = true
                        }
                    } else {
                        this.categorySetting = [];
                    }
                },
                changeCategorySetting(index, flag, preselectedProduct = []) {
                    console.log("INDEX", index)
                    console.log("FLAG", flag)
                    const vm = this
                    vm.categorySetting[index] = flag
                    if(flag == false) {
                        vm.getProductByCategory(index)
                            .then(response => {
//                                 console.log("fill the preselected product", preselectedProduct)
                                if(preselectedProduct.length > 0) {
                                    preselectedProduct = preselectedProduct.filter(function (el) {return el != null && el != "";});
                                    vm.selectedProductByCategory[index] = preselectedProduct.map(product => {
//                                         console.log('search', product)
                                        return vm.productByCategory[index].filter(p => p.id == product.id)[0]
                                    })
                                    vm.$forceUpdate()
                                }
                            })
                    } else {
                        vm.productByCategory[index] = [];
                        vm.selectedProductByCategory[index] = [];
                    }
                    vm.$forceUpdate()
                },
                getProductByCategory(index) {
                    return axios.get('{{ url("product/getbycategory/") }}/'+index)
                        .then(response => {
                            console.log(response.data)
                            this.productByCategory[index] = response.data
                            this.selectedProductByCategory[index] = []
                            this.$forceUpdate()
                            return response
                        })
                },
                actionAddPromo(event) {
                    event.preventDefault();
                    var data = {
                        totalBeli: this.totalBeli,
                        promoCode: this.formAddPromoCode,
                        discountType: this.discountType,
                        amount: this.formAddAmount,
                        discount: this.formAddDiscount,
                        startDate: this.formAddStartDate,
                        endDate: this.formAddEndDate,
                        minimum: this.formAddMinimum,
                        isAllProduct: this.allProduct,
                        selectedCategories: this.categories,
                        categorySetting: this.categorySetting,
                        productByCategory: this.selectedProductByCategory
                    }

                    // cek start date harus tidak lebih dari end date
                    if(moment(this.formAddStartDate) > moment(this.formAddEndDate)) {
                        $('#formAddStartDate').focus()
                        alert("Tanggal berakhir tidak boleh melebihi tanggal mulai")
                        return false
                    }

                    // check kategori yang berlaku sebagian harus punya produk yang terpilih
                    if(data.selectedCategories.length > 0) {
                        var vm = this
                        data.categorySetting.forEach((catSetting, index) => {
                            if(catSetting != null && !catSetting) {
                                console.log(data.productByCategory[index].length)
                                if(data.productByCategory[index].length == 0) {
                                    alert(`Kategori ${vm.productCategoriesOnDB[index]} berlaku sebagian namun belum dipilih produknya`)
                                    return false
                                }
                            }
                        })
                    }

                    // cek jika tidak all produk harus ada kategori yang terpilih
                    if(!data.isAllProduct && !data.totalBeli) {
                        if(data.selectedCategories.length <= 0) {
                            alert('Pilih kategori terlebih dahulu!')
                            return false
                        }
                    }

                    if(!this.isEditing) {
                        axios.post('{{ url("codepromo") }}', data)
                            .then(response => {
                                alert('Tambah Kode Promo Berhasil')
                                $('#modalAdd').modal('hide');
                                window.location.reload()
                            })
                            .catch(e => {
                                const errors = e.response.data.errors
                                if(errors.promoCode) {
                                    alert(errors.promoCode.join(', '))
                                }
                            })
                        console.log(data);
                    } else {
                        axios.patch('{{ url("codepromo") }}/'+this.promoId, data)
                            .then(response => {
                                alert('Edit Kode Promo Berhasil')
                                $('#modalAdd').modal('hide');
                                window.location.reload()
                            })
                            .catch(e => {
                                const errors = e.response.data.errors
                                if(errors.promoCode) {
                                    alert(errors.promoCode.join(', '))
                                }
                            })
                    }
                    
                },
                generateCode() {
                    this.formAddPromoCode = this.randomString(6)
                },
                randomString(length) {
                    const chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'
                    var result = '';
                    for (var i = length; i > 0; --i) result += chars[Math.floor(Math.random() * chars.length)];
                    return result;
                },
                editPromoCode(idPromo) {
                    const vm = this
                    axios.get('codepromo/'+idPromo)
                        .then(response => {
                            data = response.data
                            vm.isEditing = true
                            vm.formAddPromoCode = data.code
                            vm.formAddStartDate = data.start
                            vm.formAddEndDate = data.end
                            vm.promoId = data.id

                            // Rule
                            const rule = data.rule != null ? JSON.parse(data.rule) : null
                            vm.totalBeli = rule.totalBeli !=null ? rule.totalBeli : this.totalBeli
                            vm.discountType = rule.discountType
                            vm.formAddAmount = parseInt(data.amount)
                            vm.formAddDiscount = parseInt(data.discount)
                            vm.formAddMinimum = parseInt(data.minimum)
                            vm.allProduct = rule.allProduct

                            if(!vm.allProduct && !vm.totalBeli) {
                                // category selected
                                this.categories = rule.categorySetting.map((catSetting => {
                                    return catSetting.catId
                                }))
                                $('#categorySelected').val(this.categories).trigger('change')

                                // category setting
                                rule.categorySetting.forEach(catSetting => {
                                    vm.categorySetting[catSetting.catId] = catSetting.isAllProduct
                                    if(!catSetting.isAllProduct) {
                                        this.changeCategorySetting(catSetting.catId,false,catSetting.productIds)
                                    }
                                })
                            }

                        })
                        .catch(e => {
                            console.log(e)
                            alert('ada error')
                        })
                },
                resetForm() {
                    this.totalBeli = true
                    this.formAddAmount = 0
                    this.formAddDiscount = 0
                    this.formAddStartDate = null
                    this.formAddEndDate = null
                    this.formAddMinimum = 0
                    this.formAddPromoCode = null
                    this.allProduct = false
//                     this.productCategoriesOnDB = []
                    $('#categorySelected').val([]).trigger('change')
                    this.categories = []
                    this.categorySetting = [] // true is all, while false is some
                    this.productByCategory = [] // list of product by chosen category
                    this.selectedProductByCategory = []
                    this.isEditing = false
                    this.promoId = null
                },
                changeProductCategorySelected(index, product) {
                    console.log("index",index)
                    const vm = this
                    product.forEach(p => {
                        console.log(vm.selectedProductByCategory)
                        vm.selectedProductByCategory[p.product_category_id].push(p)
                    })
                }
            },
        })
    </script>
@endsection
