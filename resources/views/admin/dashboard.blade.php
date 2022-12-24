@extends('layouts.index')

@section('title')
    Dashboard -
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0">Dashboard</h4>
        </div>
        <div class="d-flex align-items-center flex-wrap text-nowrap"></div>
    </div>
    <div id="kategori_info"></div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <form action="{{ route('admin') }}" method="get">
                        <div class="row">
                            <div class="col-md-5">
                                <x-form-group caption="Tanggal Awal">
                                    <x-input name="tanggal_awal" class="datepicker" :value="format_date($tanggal_awal)" />
                                </x-form-group>
                            </div>
                            <div class="col-md-4">
                                <x-form-group caption="Tanggal Akhir">
                                    <x-input name="tanggal_akhir" class="datepicker" :value="format_date($tanggal_akhir)" />
                                </x-form-group>
                            </div>
                            <div class="col-md-2">
                                <label for="">&nbsp;</label>
                                <button type="submit" class="btn btn-primary btn-block">Cari</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <h4>Grafik Neraca</h4>
                    <div id="chartdiv" style="width: 100%; height: 500px; background-color: #FFFFFF;" ></div>
                </div>
                <div class="col-md-4">
                    <h4>Grafik Jenis Simpanan</h4>
                    <div id="chartdiv2" style="width: 100%; height: 500px; background-color: #FFFFFF;" ></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript" src="https://www.amcharts.com/lib/3/amcharts.js"></script>
    <script type="text/javascript" src="https://www.amcharts.com/lib/3/serial.js"></script>
    <script type="text/javascript" src="https://www.amcharts.com/lib/3/pie.js"></script>
    <script>
        init_form_element();

        AmCharts.makeChart("chartdiv",
            {
                "type": "serial",
                "categoryField": "category",
                "startDuration": 1,
                "categoryAxis": {
                    "gridPosition": "start",
                    "labelRotation": -90,
                },
                "trendLines": [],
                "graphs": [
                    {
                        "colorField": "color",
                        "fillAlphas": 1,
                        "id": "AmGraph-1",
                        "lineColorField": "color",
                        "title": "graph 1",
                        "type": "column",
                        "valueField": "value"
                    }
                ],
                "guides": [],
                "valueAxes": [
                    {
                        "id": "ValueAxis-1",
                    }
                ],
                "allLabels": [],
                "balloon": {},
                "dataProvider": [
                    {
                        "category": "Simpanan",
                        "value": parseFloat('{{ $simpanan->sum('total_nominal') }}'),
                        "color": "#FF6600"
                    },
                    {
                        "category": "Pinjaman",
                        "value": parseFloat('{{ $pinjaman->sum('total_nominal') }}'),
                        "color": "#FCD202"
                    },
                    {
                        "category": "Pembayaran Pinjaman",
                        "value": parseFloat('{{ $pembayaran->sum('total_nominal') }}'),
                        "color": "#B0DE09"
                    },
                    {
                        "category": "Laba Penjualan Produk",
                        "value": parseFloat('{{ $laba_transaksi->sum('total_nominal') }}'),
                        "color": "#0D8ECF"
                    },
                    {
                        "category": "Diskon Penjualan Produk",
                        "value": parseFloat('{{ $diskon_transaksi->sum('total_nominal') }}'),
                        "color": "#2A0CD0"
                    },
                ]
            }
        );

        AmCharts.makeChart("chartdiv2",
            {
                "type": "pie",
                "balloonText": "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>",
                "titleField": "category",
                "valueField": "value",
                "allLabels": [],
                "balloon": {},
                "titles": [],
                "labelsEnabled": false,
                "dataProvider": JSON.parse('@json($result)')
            }
        );
    </script>
@endpush
