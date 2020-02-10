@extends('layouts.template')

{{-- Title --}}
@section('title', 'Kelola Product Categories')

{{-- Plugin --}}
@include('partials.datatable')
@include('partials.form')
@include('partials.sweetalert')

{{-- Content --}}
@section('content')
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    Kelola Kategori Produk
                </h2>
                <ul class="header-dropdown">
                    <button type="button" class="btn bg-blue m-r-15 waves-effect" data-toggle="modal" data-target="#defaultModal">
                        <i class="material-icons">add</i>
                        <span>TAMBAH KATEGORI PRODUK</span>
                    </button>
                </ul>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Kategori</th>
                                <th>Deskripsi</th>
                                <th>Foto</th>
                                <th>Menu</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Nama Kategori</th>
                                <th>Deskripsi</th>
                                <th>Foto</th>
                                <th>Menu</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($product_categories as $u => $product_category)
                            <tr>
                                <td>{{ $u+1 }}</td>
                                <td>{{ $product_category->name }}</td>
                                <td>{{ $product_category->desc }}</td>
                                <td><img src="/{{ $product_category->image }}" alt="Foto" class="datatable-img"></td>
                                <td>
                                    <form action="{{ route('product_categories.destroy', $product_category->id)}}" method="post" id="swal-datatable-{{ $product_category->id }}">
                                        @csrf
                                        @method('DELETE')
                                        {{-- <a href="{{ route('users.edit',$user->id) }}">
                                            <button type="button" class="btn btn-success waves-effect">
                                                <i class="material-icons">create</i>
                                            </button>
                                        </a> --}}
                                        <button type="button" class="btn btn-success waves-effect" data-toggle="modal" onclick="editThis({{ $product_category->id }})">
                                            <i class="material-icons">create</i>
                                        </button>
                                        <button type="submit" class="btn btn-danger waves-effect" onclick="deleteThis({{ $product_category->id }})">
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

<!-- Creat Modal Dialogs -->
<div class="modal fade p-t-5" id="defaultModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">TAMBAH KATEGORI PRODUK</h4>
            </div>
            <form id="formAdd" action="{{ route('product_categories.store') }}" method="POST">
                @csrf
                @include('admin.product_categories.create')
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
                <h4 class="modal-title" id="largeModalLabel">Modal title</h4>
            </div>
            <form id="formEdit" action="/" method="POST">
                @method('PATCH')
                <input type="hidden" id="id-modal" name="id-modal"/>
                @csrf
                @include('admin.product_categories.edit')
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

            axios.get('/api/v1/product_categories/'+id)
                .then(response => {
                    if(response.data.error) {
                    } else {
                        input = response.data;
                        var url = '{{ url('') }}'+'/'
                        form.reset();
                        $('#name').val(input.name);
                        $('#desc').val(input.desc);
                        $('#fieldID2').val(url+input.image);
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
                        error = "Gagal Mengambil Data Kategori Produk"
                    }
                });
        }
          function simpan(){
            event.preventDefault();
            var form = document.querySelector('#formEdit');
            var data = new FormData(form);
            var id_modal= $("#id-modal").val();

            console.log(data);
            console.log(id_modal);

            axios.post('/product_categories/'+id_modal,data)
                .then(response => {
                    if(response.data.error) {
                        console.log('success error');
                        console.log(response.data);

                    } else {
                        console.log('success success');
                        console.log(response.data);
                        swal({
                            title: 'Success',
                            text:"Berhasil Menambahkan Data",
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
                    console.log('errorx');
                    try {
                        errors = Object.values(error.response.data.errors).map(msg => msg[0])
                        errors = errors.join()
                        console.log(errors);
                    } catch(e) {
                        error = "Gagal Mengubah Data Kategori Produk"
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
