@extends('layouts.masterapp')
@section('content')
<div id="container_table_combo" class="container margin-transaksi" style="min-height : 480px;">
    <div class="panel panel-default panel-body ">
        <div class="">
            <div class="row ">
                <div class="col-sm-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">
                                    <i class="fas fa-cube"></i>&nbsp;&nbsp;Master&nbsp;</a></li>
                            <li class="breadcrumb-item active" aria-current="page">List Combo</li>

                        </ol>
                    </nav>
                </div>

                <div class="col-sm-12" align="left">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="btn-group " role="group" aria-label="Two group">
                                <button name="btn_tambahCombo" id="btn_tambahCombo" type="button" class="btn btn-info btn-sm tambah-data-combo" data-toggle="modal" data-target="#modal_tambah_combo" data-backdrop="static" data-keyboard="false" onclick="tambahComboForm()">
                                    <i class="fas fa-plus"></i>&nbsp;&nbsp;Paket Combo &nbsp;
                                </button>
                                <a  href="{{ route('combo.export') }}" class="btn btn-success btn-sm" >
                                    <i class="fas fa-file-excel"></i>&nbsp;&nbsp; Export &nbsp;
                                </a>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-sm-12">
                    <hr>
                </div>


                <div class="col-sm-12">
                    <div id="goods_table">

                        <table id="tabel_combo" class="table table-striped table-bordered responsive-table-m zui-table-rounded">
                            <thead class="bg_table_master" style="color:#fff;">
                                <tr>
                                    <th align="center" scope="col">#</th>
                                    <th scope="col">Kode</th>
                                    <th scope="col">Nama Barang</th>
                                    <th scope="col">Stok</th>
                                    <th scope="col">Unit</th>
                                    <th scope="col">Harga (Rp)</th>
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
@include('components.modal_combo')
@include('components.modal_upload')
@include('components.modal_hapus_data')
@include('components.modal_save_table')
@endsection
