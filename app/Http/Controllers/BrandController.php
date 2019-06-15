<?php

namespace App\Http\Controllers;

use App\Brand;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $judul      = 'Hijrah Mandiri - Merek';
      $page       = 'master';

      return view('brand', [  'page'        => $page,
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
          'nama' => $request['nama']
        ];

        Brand::insert($data);
        return response()->json(['message' => 'Data merek berhasil ditambahkan.']);
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
      $brands = Brand::find($id);
      return $brands;
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
      $brand = Brand::find($id);
      $brand->nama  = $request['nama'];
      $brand->update();
      return response()->json(['message' => 'Data merek berhasil diupdate.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      Brand::destroy($id);
      return response()->json(['message' => 'Data berhasil dihapus.']);
    }

    public function AllBrand()
    {
      $brand = Brand::all();
      $datatables = Datatables::of($brand)
                    ->addIndexColumn()
                    ->addColumn('action', function($brand){
                               return '<a onclick="editBrandForm('.$brand->id.')" style="color : #FFF;" class="btn btn-sm btn-info"><span class="glyphicon glyphicon-edit"></span> Edit</a>'.' '.
                                      '<a onclick="deleteBrandForm('.$brand->id.')" style="color : #FFF;" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal_hapus_data" data-backdrop="static" data-keyboard="false"><span class="glyphicon glyphicon-trash"></span> Delete</a>';
                             });
       return $datatables->make(true);
    }
}
