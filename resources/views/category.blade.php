@extends('layouts.masterapp')
@section('content')
  <div id="container_table_kategori" class="container margin-transaksi" style="min-height : 480px;">
    <div class="panel panel-default">
      <div class="panel panel-default panel-body">
         <div class="row ">
           <div class="col-sm-12">
             <nav aria-label="breadcrumb">
               <ol class="breadcrumb" >
                 <li class="breadcrumb-item"><a href="#">
                   <i class="fas fa-cubes"></i>&nbsp;&nbsp;Master&nbsp;</a></li>
                 <li class="breadcrumb-item active" aria-current="page">List Kategori</li>
               </ol>
             </nav>
           </div>

           <div class="col-sm-12">
             <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
               <div class="btn-group btn-group-sm" role="group" aria-label="Two group">
                 <button name="add_kategori" id="add_kategori" type="button" class="btn btn-info tambah_data_kategori" data-toggle="modal" data-target="#modal_tambah_kategori" data-backdrop="static" data-keyboard="false" onclick="tambahCategoryForm()">
                   <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>&nbsp;Tambah
                 </button>
               </div>
             </div>
           </div>
           <div class="col-sm-12">
             <hr>
           </div>



           <div class="col-sm-12">
             <div id="table_kategori">
               <table id="tabel_kategori" class="table table-striped table-bordered responsive-table-m zui-table-rounded ">
                 <thead class="bg-info" style="color:#fff;">
                   <tr>
                     <th width="5%"scope="col">#</th>
                     <th width="75%"scope="col">Kategori</th>
                     <th width="20%"scope="col">Action</th>
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

@include('components.modal_kategori')
@include('components.modal_hapus_data')
@endsection
