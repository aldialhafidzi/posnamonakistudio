<?php

namespace App\Http\Controllers;

use Excel;
use App\Good;
use App\Combo;
use App\Unit;
use App\Brand;
use App\Category;
use App\Detail_Unit;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Imports\CombosImport;
use App\Exports\CombosExport;

class ComboController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $units      = Unit::all();
      $brands     = Brand::all();
      $Categoryes = Category::all();
      $c_combo   = '';
      $judul      = 'Hijrah Mandiri - Combo';
      $page       = 'master';

      if ($request->cookie('cookie_combo') != NULL){
        $c_combo = json_decode($request->cookie('cookie_combo'));
      }

      return view('combo', [ 'units'       => $units,
                              'brands'      => $brands,
                              'categories'  => $Categoryes,
                              'page'        => $page,
                              'judul'       => $judul,
                              'cooc_barang' => $c_combo
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

        foreach ($request['c_kode'] as $key => $value) {

          // Store to table Goods
          $data = [
            'kategori_id' => '3',
            'merek_id'    => '3',
            'cbo'         => 'Y',
            'kode'        => $request['c_kode'][$key],
            'nama'        => $request['c_nama'][$key],
            'stok_unit'   => '0',
            'unit_awal'   => $request['c_unit_jual'][$key],
            'min_qty'     => $request['c_min_qty'][$key],
            'unit_jual'   => $request['c_unit_jual'][$key],
            'h_jual'      => $request['c_h_jual'][$key]
          ];

          Good::insert($data);


          // Store to table Detail Unit
          $last_insert_id = DB::getPdo()->lastInsertId();

          $data = [
            'good_id' => $last_insert_id,
            'qty'     => '1',
            'unit_id' => $request['c_unit_jual'][$key]
          ];

          Detail_Unit::insert($data);


          $stok_cbo = 0;
          $s_stok = 9999999999;

          for ($i=0; $i < count($request['dc_good_id'][$key]) ; $i++) {
            // Store to table Combos
            $data = [
              'combos_id' => $last_insert_id,
              'good_id'   => $request['dc_good_id'][$key][$i],
              'qty'       => $request['dc_qty'][$key][$i],
              'unit_id'   => $request['dc_unit'][$key][$i]
            ];

            Combo::insert($data);

            $unit_id = $request['dc_unit'][$key][$i];
            $good_id = $request['dc_good_id'][$key][$i];

            $good = Good::find($good_id);

            $que = $good->with(['detail_unit' => function ($query) use($unit_id, $good_id) {
               $query->where('detail_units.unit_id', '=', $unit_id )
                     ->where('detail_units.good_id', '=', $good_id);
             }])->where('id', $good_id)->first();

            $data_good = json_decode($que);
            $stok_cbo = (int)((int)$good->stok_unit / (int)$data_good->detail_unit[0]->qty) / (int)$request['dc_qty'][$key][$i];

            if($stok_cbo < $s_stok){
              $s_stok = (int)$stok_cbo;
            }

          }

          // Update stok combo
          DB::table('goods')->where('id', $last_insert_id)->update(['stok_unit' => $s_stok]);

        }

        return response()->json(['message' => 'Combo berhasil ditambahkan.']);

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
      $combo = Good::with(['combo' => function($query) use($id){
        $query->with(['comboToGood' => function($query){
          $query->with(['detail_unit' => function($query){
            $query->with('unit');
          }]);
        }])->where('combos_id', $id);
      }])->where('goods.id', $id)->get();

      return $combo;

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
        // dd($request->all());

        foreach ($request['c_kode'] as $key => $value) {

          // Store to table Goods
          $good = Good::find($id);

          $good->kategori_id  = '3';
          $good->merek_id     = '3';
          $good->cbo       = 'Y';
          $good->kode         = $request['c_kode'][$key];
          $good->nama         = $request['c_nama'][$key];
          $good->unit_awal    = $request['c_unit_jual'][$key];
          $good->min_qty      = $request['c_min_qty'][$key];
          $good->unit_jual    = $request['c_unit_jual'][$key];
          $good->h_jual       = $request['c_h_jual'][$key];

          $good->update();


          $stok_cbo = 0;
          $s_stok = 9999999999;

          // Delete And Restore Detail Combos
          DB::table('combos')->where('combos_id', $id)->delete();

          for ($i=0; $i < count($request['dc_good_id'][$key]) ; $i++) {


            $data = [
              'combos_id' => $id,
              'good_id'   => $request['dc_good_id'][$key][$i],
              'qty'       => $request['dc_qty'][$key][$i],
              'unit_id'   => $request['dc_unit'][$key][$i]
            ];

            Combo::insert($data);


            $unit_id = $request['dc_unit'][$key][$i];
            $good_id = $request['dc_good_id'][$key][$i];

            $good = Good::find($good_id);

            $que = $good->with(['detail_unit' => function ($query) use($unit_id, $good_id) {
               $query->where('detail_units.unit_id', '=', $unit_id )
                     ->where('detail_units.good_id', '=', $good_id);
             }])->where('id', $good_id)->first();

            $data_good = json_decode($que);

            $stok_cbo = (int)((int)$good->stok_unit / (int)$data_good->detail_unit[0]->qty) / (int)$request['dc_qty'][$key][$i];

            if($stok_cbo < $s_stok){
              $s_stok = (int)$stok_cbo;
            }

          }

          // Update stok combo
          DB::table('goods')->where('id', $id)->update(['stok_unit' => $s_stok]);

        }

        return response()->json(['message' => 'Combo berhasil diedit.']);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      DB::table('detail_units')->where('good_id', $id)->delete();
      DB::table('combos')->where('combos_id', $id)->delete();
      Good::destroy($id);

      return response()->json(['message' => 'Data berhasil dihapus.']);
    }



    public function AllCombo(Request $request)
    {
      $combo = Good::with(['combo', 'merek','kategori','unit'])->where('goods.cbo', "Y")->get();
      $datatables = Datatables::of($combo)
                    ->addIndexColumn()
                    ->addColumn('action', function($combo){
                               return '<a onclick="editComboForm('.$combo->id.')" style="color : #FFF;" class="btn btn-sm btn-info"><span class="glyphicon glyphicon-edit"></span> Edit</a>'.' '.
                                      '<a onclick="deleteComboForm('.$combo->id.')" style="color : #FFF;" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal_hapus_data" data-backdrop="static" data-keyboard="false"><span class="glyphicon glyphicon-trash"></span> Delete</a>';
                             });
       return $datatables->make(true);
    }

    public function ExportCombo()
    {
      return Excel::download(new CombosExport, 'Master Combo Data.xlsx');
    }


}
