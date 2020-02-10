@extends('layouts.template')

@section('content')

<!-- Hover Zoom Effect -->
<div class="block-header">
    <h2>DASHBOARD INFO</h2>
</div>
<div class="row">
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box-3 bg-blue hover-zoom-effect">
            <div class="icon">
                <i class="material-icons">people</i>
            </div>
            <div class="content">
                <div class="text">MEMBER</div>
                <div class="number">{{ App\Member::count() }}</div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box-3 bg-light-blue hover-zoom-effect">
            <div class="icon">
                <i class="material-icons">assignment_turned_in</i>
            </div>
            <div class="content">
                <div class="text">TRANSAKSI</div>
                <div class="number">{{ App\Transactions::count() }}</div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box-3 bg-cyan hover-zoom-effect">
            <div class="icon">
                <i class="material-icons">star</i>
            </div>
            <div class="content">
                <div class="text">PRODUK</div>
                <div class="number">{{ App\Product::count() }}</div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box-3 bg-light-green hover-zoom-effect">
            <div class="icon">
                <i class="material-icons">loyalty</i>
            </div>
            <div class="content">
                <div class="text">PROMO AKTIF</div>
                <div class="number">{{ App\Promo::where('active','1')->count() }}</div>
            </div>
        </div>
    </div>
</div>
<!-- #END# Hover Zoom Effect -->

    
@endsection