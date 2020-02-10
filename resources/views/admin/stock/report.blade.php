@extends('layouts.template')

{{-- Title --}}
@section('title', 'Laporan Stok')

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
                <div class="row clearfix">
                    <div class="col-xs-3 col-sm-4 col-md-6">
                        <h2>Laporan Stok</h2>
                    </div>
                    <div class="col-xs-9 col-sm-8 col-md-6 align-right">
                        <form id="formFilter" action="/" method="POST">
                            <div class="col-lg-10 col-md-9 col-xs-9">
                                <div class="input-daterange input-group align-right" id="bs_datepicker_range_content" style="margin-bottom: 0 !important">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="start" placeholder="YYYY-MM-DD" required style="text-align:center;">
                                    </div>
                                    <span class="input-group-addon">to</span>
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="end" placeholder="YYYY-MM-DD" required style="text-align:center;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-3 col-xs-3">
                                <button type="submit" class="btn btn-primary btn-lg waves-effect">FILTER</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table id="tableFilter" class="table table-bordered table-striped table-hover js-basic-example dataTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Produk</th>
                                <th>Stok Awal</th>
                                <th>Penambahan</th>
                                <th>Pengurangan</th>
                                <th>Sisa</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Produk</th>
                                <th>Stok Awal</th>
                                <th>Penambahan</th>
                                <th>Pengurangan</th>
                                <th>Sisa</th>
                            </tr>
                        </tfoot>
                        <tbody>
                                @foreach ($products as $p => $product)
                                <tr>
                                    <td>{{ $p+1 }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->stock }}</td>
                                    <td>{{ $product->add }}</td>
                                    <td>{{ $product->min }}</td>
                                    <td>{{ $product->total }}</td>
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
@endsection

@section('end-scripts-extra')
<script type="text/javascript" class="init">
    $(document).ready(function() {
        $('#formFilter').on('submit',function(e){
            e.preventDefault();

            var table = $('#tableFilter').DataTable();
            var formData = $(this).serializeArray();
            var data = {};

            $.each(formData, function(i, field) {
                data[field.name] = field.value;
            });

            axios.get('/api/v1/report?start='+data.start+'&end='+data.end)
                .then(response => {
                    if(response.data.error) {
                        // console.log('succes error');
                        // console.log(response.data);
                    } else {
                        // console.log('success success');
                        // console.log(response.data);
						table.clear().rows.add(response.data).draw();
                        swal({
                            title: 'Success',
                            text:"Pencarian Berhasil",
                            type:"success",
                            timer: 1000,
                            showConfirmButton: true
                        });
                    }
                })
                .catch(error => {
                    let errors = ""
                    // console.log(error);
                    // console.log('errorx');
                    try {
                        errors = Object.values(error.response.data.errors).map(msg => msg[0])
                        errors = errors.join()
                        console.log(errors);
                    } catch(e) {
                        error = "Pencarian Gagal"
                    }
                    swal({
                        title: "Gagal",
                        text:errors,
                        type: 'error',
                        timer: 1000
                    });
                })
        })
    });
</script>
@endsection