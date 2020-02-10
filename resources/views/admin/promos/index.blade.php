@extends('layouts.template')

{{-- Title --}}
@section('title', 'Kelola Promo')

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
                    Kelola Promo
                </h2>
                <ul class="header-dropdown">
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
                                <th>Kode</th>
                                <th>Status</th>
                                <th>Image</th>
                                <th>Menu</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Status</th>
                                    <th>Image</th>
                                    <th>Menu</th>
                            </tr>
                        </tfoot>
                        <tbody>
                                @foreach ($promos as $u => $pro)
                                <tr>
                                    <td>{{ $u+1 }}</td>
                                    <td>{{ $pro->codePromo !=null ? $pro->codePromo->code : '-'}}</td>
                                    <td><span class="badge bg-{{ $pro->active == 1 ? "green" : "red" }}">{{ $pro->active == 1 ? "AKTIF" : "TIDAK AKTIF" }}</span></td>
                                    <td><img src="/{{ $pro->image }}" alt="Foto Profil" class="datatable-img"></td>

                                    <td>
                                            <form action="{{ route('promos.destroy', $pro->id)}}" method="post" id="swal-datatable-{{ $pro->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    {{-- <a href="{{ route('products.edit',$product->id) }}">
                                                        <button type="button" class="btn btn-success waves-effect">
                                                            <i class="material-icons">create</i>
                                                        </button>
                                                    </a> --}}
                                                    <button type="button" class="btn btn-success waves-effect" data-toggle="modal" onclick="editThis({{$pro->id}})">
                                                        <i class="material-icons">create</i>
                                                    </button>
                                                    <button type="submit" class="btn btn-danger waves-effect" onclick="deleteThis({{$pro->id}})">
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
                    <h4 class="modal-title" id="defaultModalLabel">TAMBAH PROMO</h4>
                </div>
                <form id="formAdd" action="{{ route('promos.store') }}" method="POST">
                    @csrf
                    @include('admin.promos.create')
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
                    <h4 class="modal-title" id="largeModalLabel">Edit Promo</h4>
                </div>
                <form id="formEdit" action="/" method="POST">
                    @method('PATCH')
                    <input type="hidden" id="id-modal" name="id-modal"/>
                    @csrf
                    @include('admin.promos.edit')
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

                axios.get('/api/v1/promos/'+id)
                    .then(response => {
                        if(response.data.error) {
                        } else {
                            input = response.data;
                            var url = '{{ url('') }}'+'/'
                            form.reset();
                            $('#name').val(input.name);
                            $('#desc').val(input.desc);
                            $('#code_promo_id').val(input.code_promo_id).change().prop('selected', true);
                            $('#active').val(input.active).val() == 1 ? $('#active').prop('checked', true) : $('#active').prop('checked', false);
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
                            error = "Gagal Mengambil Data Promos"
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

                axios.post('/promos/'+id_modal,data)
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
                            error = "Gagal Mengubah Data Promos"
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
