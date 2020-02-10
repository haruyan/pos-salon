@extends('layouts.template')

{{-- Title --}}
@section('title', 'Laporan Penjualan')

{{-- Plugin --}}
@include('partials.datatable')
@include('partials.form')
@include('partials.sweetalert')

{{-- Content --}}
@section('content')

<div class="row clearfix">
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="info-box-3 bg-light-blue hover-zoom-effect">
            <div class="icon">
                <i class="material-icons">shopping_cart</i>
            </div>
            <div class="content">
                <div class="text">BARANG TERJUAL</div>
                <div class="number" id="infoCount">{{ $count }}</div>
            </div>
        </div>
    </div>
</div>

<!-- Basic DataTable -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <div class="row clearfix">
                    <div class="col-xs-3 col-sm-4 col-md-6">
                        <h2>Laporan Penjualan</h2>
                    </div>
                    <div class="col-xs-9 col-sm-8 col-md-6 align-right">
                        <form id="formFilter" action="/" method="POST">
                            <div class="col-lg-10 col-md-9 col-xs-9">
                                <div class="input-daterange input-group align-right" id="bs_datepicker_range_content" style="margin-bottom: 0 !important">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="start" placeholder="YYYY-MM-DD" required style="text-align:center;" value="{{ date("Y-m-d", strtotime("-1 week +1 day")) }}">
                                    </div>
                                    <span class="input-group-addon">to</span>
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="end" placeholder="YYYY-MM-DD" required style="text-align:center;" value="{{ date('Y-m-d') }}">
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
                <div class="chart m-b-70">
                    <canvas id="line_chart" height="50"></canvas>
                </div>
                
                <div class="table-responsive">
                    <table id="tableFilter" class="table table-bordered table-striped table-hover js-basic-example dataTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Produk</th>
                                <th>Penjualan</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Produk</th>
                                <th>Penjualan</th>
                            </tr>
                        </tfoot>
                        <tbody>
                                @foreach ($products as $p => $product)
                                <tr>
                                    <td>{{ $p+1 }}</td>
                                    <td>{{ $product->name }}</td>
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

<!-- Chart Plugins Js -->
<script src="{{ asset('adminbsb/plugins/chartjs/Chart.bundle.js') }}"></script>

<script type="text/javascript" class="init">



    // draw chart -----------------------------------
    // ----------------------------------------------
    var thisLabels = [];
    var thisData = [];

    var dates = JSON.parse('{!! $dates !!}');
    Object.keys(dates).map(function(key) {
        return (
            thisLabels.push((key)),
            thisData.push(dates[key])
        );
    });


    $(document).ready(function() {
        $('#formFilter').on('submit',function(e){
            e.preventDefault();
            var table = $('#tableFilter').DataTable();
            var formData = $(this).serializeArray();
            var data = {};
            
            // reset chart data
            thisLabels.length = 0;
            thisData.length = 0;

            $.each(formData, function(i, field) {
                data[field.name] = field.value;
            });
            swal({
                title: "Filter Data?",
                type: "warning",
                cancelButtonText: "Batal",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
            }, function () {

                axios.get('/api/v1/sales?start='+data.start+'&end='+data.end)
                    .then(response => {
                        if(response.data.error) {
                            // console.log('succes error');
                            // console.log(response.data);
                        } else {
                            // console.log('success success');
                            // console.log(response.data);
                            table.clear().rows.add(response.data.table).draw();
                            $('#infoCount').text(response.data.count);
                            myChart.destroy();
                            
                            response.data.info.forEach(element => {
                                thisLabels.push(element.date)
                                thisData.push(element.sold)
                            });
                            drawChart(thisLabels, thisData)
                            // console.log([thisLabels, thisData])
                        
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
                        console.log(error);
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
                
            });

        })
        
        drawChart(thisLabels, thisData)
    });


    function drawChart(label, dataset){

        var report = document.getElementById('line_chart').getContext('2d');
        var reportData = {
            type: 'line',
            data: {
                labels: label,
                datasets: [{
                    label: "Barang Terjual",
                    data: dataset,
                    borderColor: 'rgba(0, 188, 212, 0.75)',
                    backgroundColor: 'rgba(0, 188, 212, 0.3)',
                    pointBorderColor: 'rgba(0, 188, 212, 0)',
                    pointBackgroundColor: 'rgba(0, 188, 212, 0.9)',
                    pointBorderWidth: 1
                }]
            },
            options: {
                responsive: true,
                legend: false
            }
        }
        myChart = new Chart(report, reportData);
        myChart;
    }
</script>
@endsection