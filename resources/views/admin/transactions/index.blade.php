@extends('layouts.template')

{{-- Title --}}
@section('title', 'Kelola Transaksi')

{{-- Plugin --}}
@include('partials.datatable')
@include('partials.form')
@include('partials.sweetalert')

{{-- Content --}}
@section('content')
<!-- Basic DataTable -->

<div class="row">
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box-3 bg-light-blue hover-zoom-effect">
            <div class="icon">
                <i class="material-icons">shopping_cart</i>
            </div>
            <div class="content">
                <div class="text">TRANSAKSI</div>
                <div class="number" id="infoCount">{{ App\Transactions::count() }}</div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box-3 bg-cyan hover-zoom-effect">
            <div class="icon">
                <i class="material-icons">attach_money</i>
            </div>
            <div class="content">
                <div class="text">PEMASUKAN</div>
                <div class="number" id="infoIncome">{{ 'Rp '. number_format($income) .',-' }}</div>
            </div>
        </div>
    </div>
</div>
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <div class="row clearfix">
                    <div class="col-xs-3 col-sm-4 col-md-6">
                        <h2>Kelola Transaksi</h2>
                    </div>
                    <div class="col-xs-9 col-sm-8 col-md-6 align-right">
                        <form id="formFilter" action="/" method="GET">
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
                                <th>No. Transaksi</th>
                                <th>Kasir</th>
                                <th>Pembeli</th>
                                <th>Total</th>
                                <th>Waktu Transaksi</th>
                                <th>Menu</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>No. Transaksi</th>
                                <th>Kasir</th>
                                <th>Pembeli</th>
                                <th>Total</th>
                                <th>Waktu Transaksi</th>
                                <th>Menu</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($trxs as $t => $trx)
                            <tr>
                                <td>{{ $t+1 }}</td>
                                <td>{{ $trx->trx_number }}</td>
                                <td>{{ $trx->cashierDesc->full_name }}</td>
                                <td>{{ $trx->buyerDesc == null ? "UMUM" : strtoupper($trx->buyerDesc->full_name) }}</td>
                                <td>Rp{{ number_format($trx->total,2,',','.') }}</td>
                                <td>{{ $trx->created_at }}</td>
                                <td>
                                    <form action="{{ route('transactions.destroy', $trx->id)}}" method="post" id="swal-datatable-{{ $trx->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-primary waves-effect" data-toggle="modal" onclick="showThis({{$trx->id}})">
                                            <i class="material-icons">launch</i>
                                        </button>
                                        <button type="submit" class="btn btn-danger waves-effect" onclick="deleteThis({{$trx->id}})">
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

<!-- Show Modal Dialogs -->
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="largeModalLabel">DETAIL TRANSAKSI</h4>
            </div>
            <form id="formEdit" action="/" method="POST">
                @method('PATCH')
                <input type="hidden" id="id-modal" name="id-modal"/>
                @csrf
                @include('admin.transactions.edit')
            </form>
        </div>
    </div>
</div>
<!-- #END# Show Modal Dialogs -->
@endsection

@section('end-scripts-extra')
    <script type="text/javascript">
        function showThis(id) {
            event.preventDefault();
            var form = document.querySelector('#formEdit');

            axios.get('/api/v1/transactions/'+id)
                .then(response => {
                    if(response.data.error) {
                      console.log("err");
                    } else {
                        input = response.data.trx;
                        form.reset();
                        $('#cashier').val(input.cashier_desc.full_name);
                        $('#trx_number').val(input.trx_number);
                       
                        $('#buyer').val(input.buyer == 0 || input.buyer_desc == null ? "UMUM" : input.buyer_desc.full_name);
                        input.promo == null ? $('#promo').val("-") : $('#promo').val(input.promo)
                        $('#total').val("Rp "+input.total);
                        $('#dateTime').val(input.created_at);
                        $('#id-modal').val(id);

                        // item list
                        details = response.data.item;
                        trxItems = response.data.trx.item;
                        
                        var stringHtml = "";
                        var stringHtml1 = "";
                        for(var i = 0; i < details.length; i++){
                            var idx = "<td>"+ (i+1) +"</td>";
                            var nm = "<td>"+ details[i].product +"</td>";
                            var prc1 = "<td>Rp"+ details[i].priceInit +"</td>";
                            var qtt = "<td>x"+ details[i].quantity +"</td>";
                            var prc2 = "<td>Rp"+ details[i].priceSum +"</td>";
                            var ptg = "<td></td>";

                            if(trxItems[i].potongan_persen == 0){
                                ptg = "<td>Rp"+ details[i].potongan +"</td>";
                            }else{
                                ptg = "<td>Disc. "+trxItems[i].potongan_persen+"% (-Rp"+ details[i].potongan +")</td>";
                            }
                            

                            stringHtml1 += "<tr>"+(idx+nm+prc1+qtt+prc2+ptg)+"</tr>";
                        }
                        
                        totalDetails = response.data.total;
                        dataDetails = response.data.trx.details;
                        var stringHtml2 = "";
                            var th_txt = "<td colspan='5' align='right'>Total Harga</td>";
                            var td_txt = "<td colspan='5' align='right'>Total Potongan</td>";
                            var tb_txt = "<td colspan='5' align='right'>Total Bayar</td>";
                            var th_data = "<td>Rp"+totalDetails.harga+"</td>";
                            var td_data = "<td>-</td>";
                            
                            if(dataDetails.persen_discount == 0 ){
                              td_data = "<td>Rp"+totalDetails.diskon+"</td>";
                            }else{
                              td_data = "<td>Disc. "+dataDetails.persen_discount+"% (Rp"+totalDetails.diskon+")</td>";
                            }
                           
                            var tb_data = "<td>Rp"+totalDetails.bayar+"</td>";
                        stringHtml2 += "<tr>"+(th_txt+th_data)+"</tr>"+
                                       "<tr>"+(td_txt+td_data)+"</tr>"+
                                       "<tr>"+(tb_txt+tb_data)+"</tr>";
                      
                        stringHtml= stringHtml1+stringHtml2;
                        $('#itemList').empty().prepend(stringHtml);

                        $('#detailModal').modal('show');
                    }
                })
                .catch(error => {
                    let errors = ""
                    try {
                        errors = Object.values(error.response.data.errors).map(msg => msg[0])
                        errors = errors.join()
                    } catch(e) {
                        error = "Gagal Mengambil Data Transaksi"
                    }
              console.log("err"+error.response.data.errors);
                })

        }

        $(document).ready(function() {
            $('#formFilter').on('submit',function(e){
                e.preventDefault();

                var table = $('#tableFilter').DataTable();
                var formData = $(this).serializeArray();
                var data = {};

                $.each(formData, function(i, field) {
                    data[field.name] = field.value;
                });

                axios.get('/api/v1/trx/filter?start='+data.start+'&end='+data.end+'&csrf={{ csrf_token() }}')
                    .then(response => {
                        if(response.data.error) {
                            // console.log('succes error');
                            // console.log(response.data);
                        } else {
                            // console.log('success success');
                            // console.log(response.data);
                            table.clear().rows.add(response.data.table).draw();
                            $('#infoCount').text(response.data.info.count);
                            $('#infoIncome').text('Rp '+response.data.info.income.toLocaleString()+',-');

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
