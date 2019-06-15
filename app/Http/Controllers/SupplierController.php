<?php

namespace App\Http\Controllers;

use App\Supplier;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $judul      = 'Hijrah Mandiri - Supplier';
      $page       = 'pembelian';

      return view('supplier', [ 'page'        => $page,
                                'judul'       => $judul
                            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $data = [
        'nama'    => $request['nama'],
        'alamat'  => $request['alamat'],
        'no_telp' => $request['no_telp']
      ];

      Supplier::insert($data);
      return response()->json(['message' => 'Data berhasil ditambahkan.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $suppliers = Supplier::find($id);
      return $suppliers;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $supplier = Supplier::find($id);

      $supplier->nama  = $request['nama'];
      $supplier->alamat  = $request['alamat'];
      $supplier->no_telp  = $request['no_telp'];

      $supplier->update();
      return response()->json(['message' => 'Data kategori berhasil diupdate.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      Supplier::destroy($id);
      return response()->json(['message' => 'Data berhasil dihapus.']);
    }

    public function AllSupplier()
    {
      $supplier = Supplier::all();
      $datatables = Datatables::of($supplier)
                    ->addIndexColumn()
                    ->addColumn('action', function($supplier){
                               return '<a onclick="editSupplierForm('.$supplier->id.')" style="color : #FFF;" class="btn btn-sm btn-info"><span class="glyphicon glyphicon-edit"></span> Edit</a>'.' '.
                                      '<a onclick="deleteSupplierForm('.$supplier->id.')" style="color : #FFF;" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal_hapus_data" data-backdrop="static" data-keyboard="false"><span class="glyphicon glyphicon-trash"></span> Delete</a>';
                             });
       return $datatables->make(true);
    }








}
