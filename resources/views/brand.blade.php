@extends('layouts.masterapp')
@section('content')
<div id="container_table_merek" class="container margin-transaksi" style="min-height : 480px;">
    <div class="panel panel-default">
        <div class="panel panel-default panel-body">
            <div class="row ">
                <div class="col-sm-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">
                                    <i class="fas fa-cubes"></i>&nbsp;&nbsp;Master&nbsp;</a></li>
                            <li class="breadcrumb-item active" aria-current="page">List Merek</li>
                        </ol>
                    </nav>
                </div>

                <div class="col-sm-12">
                    <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                        <div class="btn-group btn-group-sm" role="group" aria-label="Two group">
                            <button name="add_merek" id="add_merek" type="button" class="btn btn-info tambah_data_merek" data-toggle="modal" data-target="#modal_tambah_merek" data-backdrop="static" data-keyboard="false" onclick="tambahBrandForm()">
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>&nbsp;Tambah
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12">
                    <hr>
                </div>


                <div class="col-sm-12">
                    <div id="table_merek">
                        <table id="tabel_merek" class="table table-striped table-bordered responsive-table-m zui-table-rounded ">
                            <thead class="bg-info" style="color:#fff;">
                                <tr>
                                    <th width="5%" align="center" scope="col">#</th>
                                    <th width="75%" scope="col">Merek</th>
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
</div>

@include('components.modal_merek')
@include('components.modal_hapus_data')
@endsection
