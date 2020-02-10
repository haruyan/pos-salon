@extends('layouts.template')

{{-- Title --}}
@section('title', 'Kelola Kategori Member')

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
                    Kelola Kategori Member
                </h2>
                <ul class="header-dropdown">
                    <button type="button" class="btn bg-blue m-r-15 waves-effect" data-toggle="modal" data-target="#defaultModal">
                        <i class="material-icons">add</i>
                        <span>TAMBAH KATEGORI</span>
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
                                <th>Menu</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Nama Kategori</th>
                                <th>Menu</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($memberCat as $m => $category)
                            <tr>
                                <td>{{ $m+1 }}</td>
                                <td>{{ $category->name }}</td>
                                <td>
                                    <form action="{{ route('memberCat.destroy', $category->id)}}" method="post" id="swal-datatable-{{ $category->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-success waves-effect" data-toggle="modal" onclick="editThis({{$category->id}})">
                                            <i class="material-icons">create</i>
                                        </button>
                                        <button type="submit" class="btn btn-danger waves-effect" onclick="deleteThis({{$category->id}})">
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
<div class="modal fade p-t-5" id="defaultModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">TAMBAH KATGORI</h4>
            </div>
            <form id="formAdd" action="{{ route('memberCat.store') }}" method="POST">
                @csrf
                @include('admin.member_cat.create')
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
                <h4 class="modal-title" id="largeModalLabel">Edit Kategori</h4>
            </div>
            <form id="formEdit" action="/" method="POST">
                @method('PATCH')
                @csrf
                <input type="hidden" id="id-modal" name="id-modal"/>
                @include('admin.member_cat.edit')
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

            axios.get('/api/v1/memberCat/'+id)
                .then(response => {
                    if(response.data.error) {
                    } else {
                        input = response.data;
                        form.reset();
                        $('#name').val(input.name);
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
                        error = "Gagal Mengambil Data User"
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

            axios.post('/memberCat/'+id_modal,data)
                .then(response => {
                    if(response.data.error) {
                        console.log('succes error');
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
                        error = "Gagal Mengubah Data User"
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
