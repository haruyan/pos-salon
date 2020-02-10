
@extends('layouts.template')

{{-- Title --}}
@section('title', 'Kelola Product')

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
                    Kelola Product
                </h2>
                <ul class="header-dropdown">
                    <div class="btn-group m-r-15">
                        <button type="button" class="btn btn-info btn-lg dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            KATEGORI <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            @foreach ($category as $c)
                                <li><a href="{{ route('product.categorized', $c->id) }}" class=" waves-effect waves-block">{{ $c->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="button" class="btn bg-blue m-r-15 waves-effect" data-toggle="modal" data-target="#defaultModal">
                        <i class="material-icons">add</i>
                        <span>TAMBAH PRODUCT</span>
                    </button>
                </ul>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Image</th>
                                <th>Deskripsi</th>
                                <th>Stok</th>
                                <th>Harga</th>
                                <th>Menu</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Image</th>
                                <th>Deskripsi</th>
                                <th>Stok</th>
                                <th>Harga</th>
                                <th>Menu</th>
                            </tr>
                        </tfoot>
                        <tbody>
                                @foreach ($datareturnMerge as $u => $product)
                                <tr>
                                    <td>{{ $u+1 }}</td>
                                    <td>{{ $product->data->name }}</td>
                                    <td><img src="/{{ $product->data->image }}" alt="Foto Profil" class="datatable-img"></td>
                                    <td>{{ $product->data->desc }}</td>
                                    <td>{{ $product->data->stock }}</td>
                                    <td>
                                        <table class="table">
                                            <tr>
                                                    @foreach ($product->merge_prices as $price)
                                                        <tr>
                                                     
                                                           <td>{{ $membersCat[$price->cat_member_id] }} </td>
                                                           <td>Rp{{ number_format($price->price,2,',','.') }}</td> 
                                                        </tr>
                                                    @endforeach
                                            </tr>
                                        </table>
                                    </td>

                                    <td>
                                        <form action="{{ route('products.destroy', $product->data->id)}}" method="post" id="swal-datatable-{{ $product->data->id }}">
                                            @csrf
                                            @method('DELETE')
                                            {{-- <a href="{{ route('products.edit',$product->data->id) }}">
                                                <button type="button" class="btn btn-success waves-effect">
                                                    <i class="material-icons">create</i>
                                                </button>
                                            </a> --}}
                                            <button type="button" class="btn btn-success waves-effect" data-toggle="modal" onclick="editThis({{$product->data->id}})">
                                                <i class="material-icons">create</i>
                                            </button>
                                            <button type="submit" class="btn btn-danger waves-effect" onclick="deleteThis({{$product->data->id}})">
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
<div class="card">
    <div class="body">
        <div class="modal fade p-t-5" id="defaultModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="defaultModalLabel">TAMBAH PRODUCT</h4>
                    </div>
                    <form id="formAdd" action="{{ route('products.store') }}" method="POST">
                        @csrf
                        @include('admin.products.create')
                    </form>
                </div>
            </div>
        </div>
    </div>{{--  close body --}}
</div>{{--  close card --}}
<!-- #END# Create Modal Dialogs -->
<!-- Edit Modal Dialogs -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="largeModalLabel">Edit Produk</h4>
            </div>
            <form id="formEdit" action="/" method="POST">
                @method('PATCH')
                <input type="hidden" id="id-modal" name="id-modal"/>
                @csrf
                @include('admin.products.edit')
            </form>
        </div>
    </div>
</div>
<!-- #END# Edit Modal Dialogs -->
@endsection

@section('end-scripts-extra')
    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>

    <script type="text/javascript">

        function open_popup(url)
        {
            var w = 880;
            var h = 570;
            var l = Math.floor((screen.width-w)/2);
            var t = Math.floor((screen.height-h)/2);
            var win = window.open(url, 'ResponsiveFilemanager', "scrollbars=1,width=" + w + ",height=" + h + ",top=" + t + ",left=" + l);
        }

        function editThis(id) {
            event.preventDefault();
            var form = document.querySelector('#formEdit');

            axios.get('/api/v1/products/'+id)
                .then(response => {
                    if(response.data.error) {
                    } else {
                        input = response.data;
                        var url = '{{ url('') }}'+'/'
                        form.reset();
                        $('#editName').val(input.name);
                        $('#editProductCategory').val(input.product_category_id).change().prop('selected', true);
                        $('[name="type2"][value="' + input.type + '"]').prop('checked', true);
                        $('#fieldID2').val(url+input.image);
                        $('#editDesc').val(input.desc);
                        $('#editStock').val(input.stock);
                        $('#id-modal').val(id);
                        $('#editModal').modal('show');

                        const prices = JSON.parse(input.prices);
//                         console.log("Prices",prices);
                        for(priceObject of prices) {
                            console.log(`input[name='editPrices[${priceObject.cat_member_id}]']`);
                            $(`input[id='editPrices[${priceObject.cat_member_id}]']`).val(priceObject.price)
                        }
                    }
                })
                .catch(error => {
                    let errors = ""
                    try {
                        errors = Object.values(error.response.data.errors).map(msg => msg[0])
                        errors = errors.join()
                    } catch(e) {
                        error = "Gagal Mengambil Data Product"
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

            axios.post('/products/'+id_modal,data)
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
@endsection
