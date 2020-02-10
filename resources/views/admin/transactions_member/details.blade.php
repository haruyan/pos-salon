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
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>Detail Member</h2>
            </div>
            <div class="body">
                <div class="row clearfix">
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-group form-float mb-0">
                            <div class="">
                                <label class="form-label">Nama</label>
                                <input type="text" value="{{ $member->full_name }}" class="form-control" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-group form-float mb-0">
                            <div class="">
                                <label class="form-label">Kategori</label>
                                <input type="text" value="{{ $member->membcat != null ? $member->membcat->name : 'Tidak Masuk Kategori' }}" class="form-control" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-group form-float mb-0">
                            <div class="">
                                <label class="form-label">Barcode</label>
                                <input type="text" value="# {{ $member->barcode }}" class="form-control" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-group form-float mb-0">
                            <div class="">
                                <label class="form-label">Nomor Hp</label>
                                <input type="text" value="{{ $member->phone }}" class="form-control" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-group form-float mb-0">
                            <div class="">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="text" value="{{ $member->date_of_birth }}" class="form-control" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-group form-float mb-0">
                            <div class="">
                                <label class="form-label">Gender</label>
                                <input type="text" value="{{ strtoupper($member->gender) }}" class="form-control" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-group form-float mb-0">
                            <div class="">
                                <label class="form-label">Email</label>
                                <input type="text" value="{{ $member->email }}" class="form-control" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-group form-float mb-0">
                            <div class="">
                                <label class="form-label">Berlaku Sampai</label>
                                <input type="text" value="{{ $member->expired }}" class="form-control" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xs-12">
                        <div class="form-group form-float mb-0">
                            <div class="">
                                <label class="form-label">Alamat</label>
                                <input type="text" value="{{ $member->address }}" class="form-control" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>Riwayat Pembelian</h2>
            </div>
            <div class="body">
                    <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#home_with_icon_title" data-toggle="tab">
                            <i class="material-icons">shopping_basket</i> TRANSAKSI
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#profile_with_icon_title" data-toggle="tab">
                            <i class="material-icons">shop</i> DETAIL PRODUK
                        </a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade in active" id="home_with_icon_title">
                        @include('admin.transactions_member.partials-trx')
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="profile_with_icon_title">
                        @include('admin.transactions_member.partials-product')
                    </div>
                </div>
                <!-- End Nav tabs -->
            </div>
        </div>
    </div>
</div>
<!-- #END# Basic DataTable -->
@endsection