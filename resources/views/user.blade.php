@extends('layouts.masterapp')
@section('content')
<div id="container_table_list_user" class="container margin-transaksi" style="min-height : 480px;">
    <div class="panel panel-default">
        <div class="panel panel-default panel-body">
            <div class="row ">
                <div class="col-sm-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <i class="fas fa-users"></i>&nbsp;&nbsp;List User&nbsp;</li>
                        </ol>
                    </nav>
                </div>

                <div class="col-sm-12">
                    <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                        <div class="btn-group btn-group-sm " role="group" aria-label="Two group">
                            <button onclick="tambahUserForm()" type="button" class="btn btn-info">
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>&nbsp;Tambah
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12">
                    <hr>
                </div>



                <div class="col-sm-12">
                    <div id="employees_table">
                        <table id="tabel_user" class="table table-striped table-bordered responsive-table-m zui-table-rounded">
                            <thead class="bg-info" style="color:#fff;">

                                <tr>
                                    <th width="5%" scope="col">#</th>
                                    <th width="20%" scope="col">Username</th>
                                    <th width="10%" scope="col">Role</th>
                                    <th width="25%" scope="col">Nama Lengkap</th>
                                    <th width="20%" scope="col">Email</th>
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

@include('components.modal_user')
@include('components.modal_hapus_data')
@endsection
