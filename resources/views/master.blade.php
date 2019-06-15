@extends('layouts.masterapp')
@section('content')
<div id="container_table_barang" class="container margin-transaksi" style="min-height : 480px;">
    <div class="panel panel-default panel-body ">
        <div class="">
            <div class="row ">
                <div class="col-sm-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">
                                    <i class="fas fa-cubes"></i>&nbsp;&nbsp;Master&nbsp;</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Semua Barang</li>
                        </ol>
                    </nav>
                </div>

                <div class="col-sm-12">
                    <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                        <div class="btn-group " role="group" aria-label="Two group" style="padding:5px;">
                            <button name="btn-tambah-barang" id="btn-tambah-barang" type="button" class="btn btn-info btn-sm tambah-data-barang" data-toggle="modal" data-target="#modal_tambah_barang" data-backdrop="static" data-keyboard="false" onclick="tambahBarangForm()">
                                <i class="fas fa-plus"></i>&nbsp;&nbsp;Tambah
                            </button>

                            <a class="btn btn-danger btn-sm" href="combo">
                                <i class="fas fa-box"></i>&nbsp;&nbsp;Combo
                            </a>

                            <button type="button" name="btn_conversi_unit" id="btn_conversi_unit" type="button" class="btn btn-sm btn-dark convert_units" data-toggle="modal" data-target="#modal_konversi_unit" data-backdrop="static" data-keyboard="false" >
                                <i class="fas fa-compress"></i>&nbsp;&nbsp;Konversi Unit
                            </button>
                            <a href="{{ route('good.export') }}" class="btn btn-success btn-sm" >
                                 <i class="fas fa-file-excel"></i>&nbsp;&nbsp; Export
                            </a>
                            <button type="button" name="btn_uploadBarang" id="btn_uploadBarang" type="button" class="btn btn-sm btn-warning tambah_data_barang" data-toggle="modal" data-target="#modal_upload">
                                <i class="fas fa-upload"></i>&nbsp;&nbsp;Import
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12">
                    <hr>
                </div>

                <div class="col-sm-12">

                    <table id="master-table" class="table table-striped table-bordered responsive-table-m zui-table-rounded ">
                        <thead class="bg_table_master" style="color:#fff;">
                            <tr>
                                <th width="5%" align="center" scope="col">No</th>
                                <th width="15%" align="center" scope="col">Kode</th>
                                <th width="30%" scope="col">Nama Barang</th>
                                <th width="5%" align="center" scope="col">Stok</th>
                                <th width="5%" align="center" scope="col">Unit</th>
                                <th width="15%" align="center" scope="col">Harga (Rp)</th>
                                <th width="15%" align="center" scope="col">Action</th>
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

@include('components.modal_master')
@include('components.modal_upload')
@include('components.modal_save_table')
@include('components.modal_hapus_data')
@include('components.modal_konversi_unit')
@endsection
