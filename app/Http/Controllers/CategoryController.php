<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $judul      = 'Hijrah Mandiri - Category';
      $page       = 'master';

      return view('category', [  'page'        => $page,
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

       Category::insert($data);
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
      $category = Category::find($id);
      return $category;
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
      $category = Category::find($id);
      $category->nama  = $request['nama'];
      $category->update();
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
      Category::destroy($id);
      return response()->json(['message' => 'Data berhasil dihapus.']);
    }

    public function AllCategory()
    {
      $category = Category::all();
      $datatables = Datatables::of($category)
                    ->addIndexColumn()
                    ->addColumn('action', function($category){
                               return '<a onclick="editCategoryForm('.$category->id.')" style="color : #FFF;" class="btn btn-sm btn-info"><span class="glyphicon glyphicon-edit"></span> Edit</a>'.' '.
                                      '<a onclick="deleteCategoryForm('.$category->id.')" style="color : #FFF;" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal_hapus_data" data-backdrop="static" data-keyboard="false"><span class="glyphicon glyphicon-trash"></span> Delete</a>';
                             });
       return $datatables->make(true);
    }
}
