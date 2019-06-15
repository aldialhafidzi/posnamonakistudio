@extends('layouts.masterapp')
@section('content')
<div id="container_table_pelanggan" class="container margin-transaksi" style="min-height : 480px;">
    <div class="panel panel-default">
        <div class="panel panel-default panel-body">
            <div class="row ">
                <div class="col-sm-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">
                                    <i class="fas fa-shopping-cart"></i>&nbsp;&nbsp;Pembelian&nbsp;</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Data Supplier</li>
                        </ol>
                    </nav>
                </div>

                <div class="col-sm-12">
                    <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                        <div class="btn-group btn-group-sm " role="group" aria-label="Two group">
                            <button type="button" class="btn btn-info" onclick="tambahSupplierForm()" data-toggle="modal" data-target="#modal_supplier">
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>&nbsp;Tambah
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12">
                    <hr>
                </div>

                <div class="col-sm-12">

                        <table id="table_supplier" class="table table-striped table-bordered  zui-table-rounded ">
                            <thead class="bg-info" style="color:#fff;">
                                <tr>
                                    <th width="5%" scope="col">#</th>
                                    <th width="15%" scope="col">Nama</th>
                                    <th width="45%" scope="col">Alamat</th>
                                    <th width="15%" scope="col">Kontak</th>
                                    <th width="20%" scope="col">Action</th>
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

@include('components.modal_supplier')
@include('components.modal_hapus_data')
@endsection
