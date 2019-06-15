@extends('layouts.masterapp')
@section('content')
<div id="container_table_barang" class="container margin-transaksi" style="min-height : 480px;">
    <div class="panel panel-default">
        <div class="panel panel-default panel-body">
            <div class="row ">
                <div class="col-sm-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">
                                    <i class="fas fa-shopping-cart"></i>&nbsp;&nbsp;Penjualan&nbsp;</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Histori Penjualan</li>
                        </ol>
                    </nav>
                    <hr>
                </div>

                <div class="col-sm-12">
                    <div id="table_transaksi">
                        <table id="tabel_histori_penjualan" class="table table-striped table-bordered  zui-table-rounded ">
                            <thead class="bg-info" style="color:#fff;">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Customer</th>
                                    <th scope="col">Invoice</th>
                                    <th scope="col">Tanggal Transaksi</th>
                                    <th scope="col">Grand Total</th>
                                    <th scope="col">Kasir</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('components.modal_hapus_data')
@endsection
