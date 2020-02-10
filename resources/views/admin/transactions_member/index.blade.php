@extends('layouts.template')

{{-- Title --}}
@section('title', 'Kelola Member')

{{-- Plugin --}}
@include('partials.datatable')

{{-- Content --}}
@section('content')
<!-- Basic DataTable -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    Transaksi Member
                </h2>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Kode Member</th>
                                <th>Kategori</th>
                                <th>Menu</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Kode Member</th>
                                <th>Kategori</th>
                                <th>Menu</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($members as $m => $member)
                            <tr>
                                <td>{{ $m+1 }}</td>
                                <td>{{ $member->full_name }}</td>
                                <td>{{ $member->barcode }}</td>
                                <td>{{ $member->membcat != null ? $member->membcat->name : 'Tidak Masuk Kategori'}}</td>
                                <td>
                                    <a href="{{ route('transactions.memberShow', $member->id) }}">
                                        <button type="button" class="btn btn-primary waves-effect" data-toggle="modal">
                                            <i class="material-icons">launch</i>
                                        </button>
                                    </a>
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
@endsection