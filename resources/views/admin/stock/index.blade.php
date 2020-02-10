@extends('layouts.template')

{{-- Title --}}
@section('title', 'Kelola Stok')

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
                    Kelola Stok
                </h2>
                <ul class="header-dropdown">
                    <button type="button" class="btn bg-blue m-r-15 waves-effect" data-toggle="modal" data-target="#defaultModal">
                        <i class="material-icons">add</i>
                        <span>TAMBAH/AMBIL STOK</span>
                    </button>
                </ul>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Produk</th>
                                <th>Transaksi</th>
                                <th>Penambahan</th>
                                <th>Pengurangan</th>
                                <th>Sisa</th>
                                <th>Status</th>
                                <th>Deskripsi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Produk</th>
                                <th>Transaksi</th>
                                <th>Penambahan</th>
                                <th>Pengurangan</th>
                                <th>Sisa</th>
                                <th>Status</th>
                                <th>Deskripsi</th>
                            </tr>
                        </tfoot>
                        <tbody>
                                @foreach ($stocks as $s => $stock)
                                <tr>
                                    <td>{{ $s+1 }}</td>
                                    <td>{{ $stock->details->name }}</td>
                                    <td>{{ $stock->trx_id }}</td>
                                    <td>{{ $stock->increase }}</td>
                                    <td>{{ $stock->decrease }}</td>
                                    <td>{{ $stock->remain }}</td>
                                    <td>{{ $stock->status }}</td>
                                    <td>{{ $stock->desc }}</td>
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
                        <h4 class="modal-title" id="defaultModalLabel">TAMBAH/AMBIL STOK</h4>
                    </div>
                    <form id="formAdd" action="{{ route('stocks.store') }}" method="POST">
                        @csrf
                        @include('admin.stock.create')
                    </form>
                </div>
            </div>
        </div>
    </div>{{--  close body --}}
</div>{{--  close card --}}
<!-- #END# Create Modal Dialogs -->
@endsection