@extends('layouts.template')

{{-- Title --}}
@section('title', 'Kelola Harga')

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
                    Kelola Data Harga
                </h2>
                <ul class="header-dropdown">
                    <button type="button" class="btn bg-blue m-r-15 waves-effect" data-toggle="modal" data-target="#defaultModal">
                        <i class="material-icons">add</i>
                        <span>TAMBAH DATA HARGA</span>
                    </button>
                </ul>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Produk</th>
                                <th>Jumlah</th>
                                <th width="20%">Menu</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Nama Produk</th>
                                <th>Jumlah</th>
                                <th width="20%">Menu</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($prices as $p => $price)
                            <tr>
                                <td>{{ $p+1 }}</td>
                                <td>{{ $price->product->name }}</td>
                                <td>Rp.{{ $price->amount }},00</td>
                                <td>
                                    <form action="{{ route('prices.destroy', $price->id)}}" method="post" id="swal-datatable-{{ $price->id }}">
                                        @csrf
                                        @method('DELETE')
                                        {{-- <a href="{{ route('prices.edit',$price->id) }}">
                                            <button type="button" class="btn btn-success waves-effect">
                                                <i class="material-icons">create</i>
                                            </button>
                                        </a> --}}
                                        <button type="button" class="btn btn-success waves-effect" data-toggle="modal" onclick="editThis({{$price->id}})">
                                            <i class="material-icons">create</i>
                                        </button>
                                        <button type="submit" class="btn btn-danger waves-effect" onclick="deleteThis({{$price->id}})">
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
                <h4 class="modal-title" id="defaultModalLabel">TAMBAH DATA HARGA</h4>
            </div>
            <form id="formAdd" action="{{ route('prices.store') }}" method="POST">
                @csrf
                @include('admin.price.create')
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
                <h4 class="modal-title" id="largeModalLabel">UBAH HARGA</h4>
            </div>
            <form id="formEdit" action="/" method="POST">
                @method('PATCH')
                <input type="hidden" id="id-modal" name="id-modal"/>
                @csrf
                @include('admin.price.edit')
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

            axios.get('/api/v1/price/'+id)
                .then(response => {
                    if(response.data.error) {
                    } else {
                        input = response.data;
                        form.reset();
                        $('#product_id').val(input.product_id).change().prop('selected', true);
                        $('#amount').val(input.amount);
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
                        error = "Gagal Mengambil Data Harga"
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

            axios.post('/prices/'+id_modal,data)
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
