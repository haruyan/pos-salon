@extends('layouts.template')

{{-- Title --}}
@section('title', 'Kelola User')

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
                    Kelola User
                </h2>
                <ul class="header-dropdown">
                    <button type="button" class="btn bg-blue m-r-15 waves-effect" data-toggle="modal" data-target="#defaultModal">
                        <i class="material-icons">add</i>
                        <span>TAMBAH USER</span>
                    </button>
                </ul>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Lengkap</th>
                                <th>Handphone</th>
                                <th>Alamat</th>
                                <th>Foto</th>
                                <th>Role</th>
                                <th>Menu</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Nama Lengkap</th>
                                <th>Handphone</th>
                                <th>Alamat</th>
                                <th>Foto</th>
                                <th>Role</th>
                                <th>Menu</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($users as $u => $user)
                            <tr>
                                <td>{{ $u+1 }}</td>
                                <td>{{ $user->full_name }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>{{ $user->address }}</td>
                                <td><img src="/{{ $user->avatar }}" alt="Foto Profil" class="datatable-img"></td>
                                <td>{{ $user->user_role }}</td>
                                <td>
                                    <form action="{{ route('users.destroy', $user->id)}}" method="post" id="swal-datatable-{{ $user->id }}">
                                        @csrf
                                        @method('DELETE')
                                        {{-- <a href="{{ route('users.edit',$user->id) }}">
                                            <button type="button" class="btn btn-success waves-effect">
                                                <i class="material-icons">create</i>
                                            </button>
                                        </a> --}}
                                        <button type="button" class="btn btn-success waves-effect" data-toggle="modal" onclick="editThis({{$user->id}})">
                                            <i class="material-icons">create</i>
                                        </button>
                                        <button type="submit" class="btn btn-danger waves-effect" onclick="deleteThis({{$user->id}})">
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
                <h4 class="modal-title" id="defaultModalLabel">TAMBAH USER</h4>
            </div>
            <form id="formAdd" action="{{ route('users.store') }}" method="POST">
                @csrf
                @include('admin.user.create')
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
                @include('admin.user.edit')
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

            axios.get('/api/v1/user/'+id)
                .then(response => {
                    if(response.data.error) {
                    } else {
                        input = response.data;
                        var url = '{{ url('') }}'+'/'
                        form.reset();
                        $("#user_role").val(input.user_role).change().prop('selected', true);
                        $('#full_name').val(input.full_name);
                        $('#username').val(input.username);
                        $('#email').val(input.email);
                        $('#phone').val(input.phone);
                        $('#address').val(input.address);
                        $('#fieldID2').val(url+input.avatar);
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

            axios.post('/users/'+id_modal,data)
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
