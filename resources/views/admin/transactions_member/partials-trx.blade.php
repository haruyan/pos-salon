<div class="table-responsive">
    <table id="tableTrx" class="table table-bordered table-striped table-hover js-basic-example dataTable">
        <thead>
            <tr>
                <th>No</th>
                <th>No. Transaksi</th>
                <th>Kasir</th>
                <th>Total</th>
                <th>Waktu Transaksi</th>
                <th>Lihat</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>No</th>
                <th>No. Transaksi</th>
                <th>Kasir</th>
                <th>Total</th>
                <th>Waktu Transaksi</th>
                <th>Lihat</th>
            </tr>
        </tfoot>
        <tbody>
            @foreach ($trxs as $t => $trx)
            <tr>
                <td>{{ $t+1 }}</td>
                <td>{{ $trx->trx_number }}</td>
                <td>{{ $trx->cashierDesc->full_name }}</td>
                <td>Rp{{ number_format($trx->total,2,',','.') }}</td>
                <td>{{ $trx->created_at }}</td>
                <td>
                    <button type="button" class="btn btn-primary waves-effect" data-toggle="modal" onclick="showThis({{$trx->id}})">
                        <i class="material-icons">launch</i>
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

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


@push('end-scripts')
    <script>
        function showThis(id) {
            event.preventDefault();
            var form = document.querySelector('#formEdit');

            axios.get('/api/v1/transactions/'+id)
                .then(response => {
                    if(response.data.error) {
                    } else {
                        input = response.data.trx;
                        form.reset();
                        $('#cashier').val(input.cashier_desc.full_name);
                        $('#trx_number').val(input.trx_number);
                        input.buyer == 0 ? $('#buyer').val("UMUM") : $('#buyer').val(input.buyer_desc.full_name);
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
                            var prc2 = "<td>Rp "+ details[i].priceSum +"</td>";
                            var ptg =  "<td></td>";
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
                            var th_data = "<td>Rp "+totalDetails.harga+"</td>";
                            var td_data = "<td>-</td>";
                            
                            if(dataDetails.persen_discount == 0 ){
                              td_data = "<td>Rp"+totalDetails.diskon+"</td>";
                            }else{
                              td_data = "<td>Disc. "+dataDetails.persen_discount+"% (Rp"+totalDetails.diskon+")</td>";
                            }
                            var tb_data = "<td>Rp "+totalDetails.bayar+"</td>";
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
                })

        }
    </script>
@endpush