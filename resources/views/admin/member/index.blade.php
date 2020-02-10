@extends('layouts.template')

{{-- Title --}}
@section('title', 'Kelola Member')

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
                    Kelola Member
                </h2>
                <ul class="header-dropdown">
                    <button type="button" class="btn bg-blue m-r-15 waves-effect" data-toggle="modal" data-target="#defaultModal">
                        <i class="material-icons">add</i>
                        <span>TAMBAH MEMBER</span>
                    </button>
                </ul>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Nomor HP</th>
                                <th>Alamat</th>
                                <th>Kategori</th>
                                <th>Berlaku Sampai</th>
                                <th>Menu</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Nomor HP</th>
                                <th>Alamat</th>
                                <th>Kategori</th>
                                <th>Berlaku Sampai</th>
                                <th>Menu</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($members as $m => $member)
                            <tr>
                                <td>{{ $m+1 }}</td>
                                <td>{{ $member->full_name }}</td>
                                <td>{{ $member->phone }}</td>
                                <td>{{ $member->address }}</td>
                                <td>{{ $member->membcat != null ? $member->membcat->name : 'Tidak Masuk Kategori' }}</td>
                                <td>{{ $member->expired }}</td>
                                <td>
                                    <form action="{{ route('members.destroy', $member->id)}}" method="post" id="swal-datatable-{{ $member->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-success waves-effect" data-toggle="modal" onclick="editThis({{$member->id}})">
                                            <i class="material-icons">create</i>
                                        </button>
                                        <button type="button" class="btn btn-primary waves-effect" data-toggle="modal" onclick="cardThis({{$member->id}})">
                                            <i class="material-icons">visibility</i>
                                        </button>
                                        <button type="submit" class="btn btn-danger waves-effect" onclick="deleteThis({{$member->id}})">
                                            <i class="material-icons">delete</i>
                                        </button>
                                        <a href="{{ route('transactions.memberShow', $member->id) }}">
                                            <button type="button" class="btn bg-cyan waves-effect">
                                                <i class="material-icons">shopping_cart</i>
                                            </button>
                                        </a>
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
                <h4 class="modal-title" id="defaultModalLabel">TAMBAH MEMBER</h4>
            </div>
            <form id="formAdd" action="{{ route('members.store') }}" method="POST">
                @csrf
                @include('admin.member.create')
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
                <h4 class="modal-title" id="largeModalLabel">Edit Member</h4>
            </div>
            <form id="formEdit" action="/" method="POST">
                @method('PATCH')
                @csrf
                <input type="hidden" id="id-modal" name="id-modal"/>
                @include('admin.member.edit')
            </form>
        </div>
    </div>
</div>
<!-- #END# Edit Modal Dialogs -->

<!-- Card Modal Dialogs -->
<div class="modal fade" id="cardModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            @include('admin.member.card')
        </div>
    </div>
</div>
<!-- #END# Card Modal Dialogs -->
@endsection

@section('end-scripts-extra')

    <!-- Custom Qr -->
    <script src="{{ asset('js/qr.js') }}"></script>


    <script type="text/javascript">
        // new QRCode(document.getElementById("card-qr"), "http://jindo.dev.naver.com/collie");
        // var qrcode = new QRCode("qrcode");

        // new QRCode(document.getElementById("card-qr"), "http://jindo.dev.naver.com/collie");
    </script>

    <script type="text/javascript">
        function editThis(id) {
            event.preventDefault();
            var form = document.querySelector('#formEdit');

            axios.get('/api/v1/member/'+id)
                .then(response => {
                    if(response.data.error) {
                    } else {
                        input = response.data;
                        form.reset();
                        $('#date_of_birth').datepicker({ dateFormat: 'yyyy-mm-dd' }).datepicker('setDate', input.date_of_birth);
                        $('[name="gender2"][value="' + input.gender + '"]').prop('checked', true);
                        $('#full_name').val(input.full_name);
                        $("#member_category_id").val(input.member_category_id).change().prop('selected', true);
                        $('#phone').val(input.phone);
                        $('#address').val(input.address);
                        $('#email').val(input.email);
                        $('#barcode').val(input.barcode);
                        $('#expired').val(input.expired);
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

        function cardThis(id) {
            $('#card-qr').html(null);

            axios.get('/api/v1/member/'+id)
                .then(response => {
                    if(response.data.error) {
                    } else {
                        input = response.data;
                        $('#card-name').text(input.full_name);
                        $('#card-category').text(input.membcat.name.toUpperCase());
                        dateSince = moment(input.created_at).format('mm/YYYY');
                        $('#card-since').text(dateSince);
                        $('#card-code').text(input.barcode);
                        $('#card-id-modal').val(id);

                        // qrcode.clear();
                        var qrcode = new QRCode(document.getElementById("card-qr"), {
                            text: input.barcode,
                            width: 64,
                            height: 64,
                            colorDark : "#000000",
                            colorLight : "#ffffff",
                            correctLevel : QRCode.CorrectLevel.H
                        });

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

            $('#cardModal').modal('show');
        }

        function downloadCard() {
            htmlToImage.toJpeg(document.getElementById('printFront'))
                .then(function (dataUrl) {
                    console.log(dataUrl)
                    var link = document.createElement('a');
                    link.download = 'frontCard.jpeg';
                    link.href = dataUrl;
                    link.setAttribute("type", "hidden"); 
                    document.body.appendChild(link);
                    link.click();
                    console.log(dataUrl);

                })
                .then(() => {
                    htmlToImage.toJpeg(document.getElementById('printBack'))
                        .then(function (dataUrl) {
                            var link = document.createElement('a');
                            link.download = 'backCard.jpeg';
                            link.href = dataUrl;
                            link.setAttribute("type", "hidden"); 
                            document.body.appendChild(link);
                            link.click();
                        });
                });
        }

        function simpan(){
            event.preventDefault();
            var form = document.querySelector('#formEdit');
            var data = new FormData(form);
            var id_modal= $("#id-modal").val();

            console.log(data);
            console.log(id_modal);

            axios.post('/members/'+id_modal,data)
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
