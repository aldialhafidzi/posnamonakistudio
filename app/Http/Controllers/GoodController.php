<?php

namespace App\Http\Controllers;

use Excel;
use App\Good;
use App\Combo;
use App\Unit;
use App\Brand;
use App\Category;
use App\Detail_Unit;
use App\Imports\GoodsImport;
use App\Exports\GoodsExport;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class GoodController extends Controller
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
      $categories = Category::all();
      $c_barang   = '';
      $judul      = 'Hijrah Mandiri - Master';
      $page       = 'master';

      if ($request->cookie('cookie_barang') != NULL){
        $c_barang = json_decode($request->cookie('cookie_barang'));
      }

      return view('master', [ 'units'       => $units,
                              'brands'      => $brands,
                              'categories'  => $categories,
                              'page'        => $page,
                              'judul'       => $judul,
                              'cooc_barang' => $c_barang
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

      foreach ($request['g_kode'] as $key => $value) {
        $data = [
          'kategori_id' => $request['g_kategori'][$key],
          'merek_id'    => $request['g_merek'][$key],
          'cbo'         => 'N',
          'kode'        => $request['g_kode'][$key],
          'nama'        => $request['g_nama'][$key],
          'stok_unit'   => $request['g_stok_unit'][$key],
          'unit_awal'   => $request['g_unit_awal'][$key],
          'min_qty'     => $request['g_min_qty'][$key],
          'unit_beli'   => $request['g_unit_beli'][$key],
          'unit_jual'   => $request['g_unit_jual'][$key],
          'h_beli'      => $request['g_h_beli'][$key],
          'h_jual'      => $request['g_h_jual'][$key]
        ];

        Good::insert($data);


        // Store Detail Unit
        $last_insert_id = DB::getPdo()->lastInsertId();

        $data = [
          'good_id' => $last_insert_id,
          'qty'     => '1',
          'unit_id' => $request['g_unit_awal'][$key]
        ];
        Detail_Unit::insert($data);

        // Store Detail Unit Jual
        if ($request['g_unit_awal'][$key] != $request['g_unit_jual'][$key]){
          $data = [
            'good_id' => $last_insert_id,
            'qty'     => $request['g_du_qty'][$key],
            'unit_id' => $request['g_unit_jual'][$key]
          ];
          Detail_Unit::insert($data);
        }


      }

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
       $good = Good::find($id);
       $que = $good->with(['detail_unit' => function ($query) use($good) {
          $query->where('detail_units.unit_id', '=', $good->unit_jual );
        }])->where("id", $id)->first();

       return $que;
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
        $good = Good::find($id);

        // Update Goods
        $good->kategori_id  = $request['g_kategori'][0];
        $good->merek_id     = $request['g_merek'][0];
        $good->kode         = $request['g_kode'][0];
        $good->nama         = $request['g_nama'][0];
        $good->stok_unit    = $request['g_stok_unit'][0];
        $good->unit_awal    = $request['g_unit_awal'][0];
        $good->min_qty      = $request['g_min_qty'][0];
        $good->unit_beli    = $request['g_unit_beli'][0];
        $good->unit_jual    = $request['g_unit_jual'][0];
        $good->h_jual       = $request['g_h_jual'][0];
        $good->h_beli       = $request['g_h_beli'][0];

        $good->update();

        // Update Qty Unit Jual
        DB::table('detail_units')->where('good_id', $id)->update(['qty' => $request['g_du_qty'][0]]);

        return response()->json(['message' => 'Data berhasil diupdate.']);
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

        if(Combo::where('combos_id',$id)->count() > 0){
            DB::table('combos')->where('combos_id', $id)->delete();
        }

        Good::destroy($id);
        return response()->json(['message' => 'Data berhasil dihapus.']);
    }

    public function AllGood(Request $request)
    {

     $good = Good::with(['merek','kategori','unit']);
     $datatables = Datatables::of($good)
                   ->addIndexColumn()
                   ->addColumn('action', function($good){
                              return '<a onclick="editBarangForm('.$good->id.')" style="color : #FFF;" class="btn btn-sm btn-info"><span class="glyphicon glyphicon-edit"></span> Edit</a>'.' '.
                                     '<a onclick="deleteBarangForm('.$good->id.')" style="color : #FFF;" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal_hapus_data" data-backdrop="static" data-keyboard="false"><span class="glyphicon glyphicon-trash"></span> Delete</a>';
                            });
      return $datatables->make(true);

    }

    public function AllGoodDetail(Request $request)
    {
      $term = trim($request->q);
      $goods = [];
      if(empty($request['temp'])){
        $goods = Good::with(['detail_unit' => function($query){
          $query->with('unit');
        }])
          ->with(['unit'])
          ->where( function($query) use($term){
            $query->where('kode', 'LIKE', '%'.$term.'%')
                  ->orWhere('nama', 'LIKE', '%'.$term.'%');
          })

          ->limit(10)->get();
      }
      else {
        $pencarian = $request['temp'];
        $goods = Good::with(['detail_unit' => function($query){
          $query->with('unit');
        }])
          ->with(['unit'])
          ->where( function($query) use($term){
            $query->where('kode', 'LIKE', '%'.$term.'%')
                  ->orWhere('nama', 'LIKE', '%'.$term.'%');
          })

          ->where( function($query) use($pencarian){
            for ( $i=0; $i < count($pencarian); $i++ ) {
              $cari = $pencarian[$i];
              $query->where('goods.id', '!=', $cari);
            }
          })
          ->limit(10)->get();
      }

      $formated_goods = [];

      foreach ($goods as $good) {
          $formated_goods[] = ['id'           => $good->kode,
                               'text'         => $good->nama,
                               'stok_unit'    => $good->stok_unit,
                               'good_id'      => $good->id,
                               'min_qty'      => $good->min_qty,
                               'h_jual'       => $good->h_jual,
                               'detail_unit'  => $good->detail_unit,
                               'unit'         => $good->unit];
      }
      return \Response::json($formated_goods);
    }


    public function AllGoodNoCombo(Request $request)
    {
      $term = trim($request->q);
      $goods = [];
      if(empty($request['temp'])){
        $goods = Good::with(['detail_unit' => function($query){
          $query->with('unit');
        }])
          ->where('cbo', '!=', 'Y')
          ->where( function($query) use($term){
            $query->where('kode', 'LIKE', '%'.$term.'%')
                  ->orWhere('nama', 'LIKE', '%'.$term.'%');
          })

          ->limit(10)->get();
      }
      else {
        $pencarian = $request['temp'];
        $goods = Good::with(['detail_unit' => function($query){
          $query->with('unit');
        }])

          ->where('cbo', '!=', 'Y')
          ->where( function($query) use($term){
            $query->where('kode', 'LIKE', '%'.$term.'%')
                  ->orWhere('nama', 'LIKE', '%'.$term.'%');
          })

          ->where( function($query) use($pencarian){
            for ( $i=0; $i < count($pencarian); $i++ ) {
              $cari = $pencarian[$i];
              $query->where('goods.id', '!=', $cari);
            }
          })
          ->limit(10)->get();
      }


      $formated_goods = [];

      foreach ($goods as $good) {
          $formated_goods[] = ['id'           => $good->kode,
                               'text'         => $good->nama,
                               'stok_unit'    => $good->stok_unit,
                               'good_id'      => $good->id,
                               'min_qty'      => $good->min_qty,
                               'h_jual'       => $good->h_jual,
                               'detail_unit'  => $good->detail_unit,
                               'unit'         => $good->unit];
      }

      return \Response::json($formated_goods);

    }


    public function ImportGood(Request $request)
    {

      if ($request->hasFile('file')) {
        $array_ = Excel::toArray(new GoodsImport, request()->file('file'), \Maatwebsite\Excel\Excel::XLSX);

        foreach ($array_[0] as $key => $value) {

          if ($array_[0][$key]['code'] != null) {
            $unit = DB::table('units')->select('id')->where('nama', $array_[0][$key]['unit'])->first();

            if($unit->id == ""){
              $data = [
                'nama' => $array_[0][$key]['unit']
              ];
              Unit::insert($data);
            }

            $good = DB::table('goods')->where('kode', $array_[0][$key]['code'])->count();

            $data = [
              'cbo'         => $array_[0][$key]['combo'],
              'kode'        => $array_[0][$key]['code'],
              'nama'        => $array_[0][$key]['deskripsi'],
              'stok_unit'   => $array_[0][$key]['stock_awal'],
              'unit_awal'   => $unit->id,
              'min_qty'     => $array_[0][$key]['min_qty'],
              'unit_jual'   => $unit->id,
              'h_beli'      => $array_[0][$key]['harga_beli'],
              'h_jual'      => $array_[0][$key]['harga_jual']
            ];

            if($good > 0){
              DB::table('goods')->where('kode', $array_[0][$key]['code'])->update($data);

            } else {
              Good::insert($data);

              $last_insert_id = DB::getPdo()->lastInsertId();

              $data = [
                'good_id' => $last_insert_id,
                'qty'     => $array_[0][$key]['stock_awal'],
                'unit_id' => $unit->id
              ];

              Detail_Unit::insert($data);
            }
          }
        }
      }

      return redirect('good')->with('message', 'All good!');

    }

    public function saveTableBarang(Request $request)
    {
      $data_form = $request->except('_token', '_method');
      $cookie_barang  = cookie('cookie_barang', json_encode($data_form), 180);
      echo json_encode('200OK');
      return response('Form berhasil disimpan.')->cookie($cookie_barang);
    }

    public function ExportGood()
    {
      return Excel::download(new GoodsExport, 'Master Data.xlsx');
    }

    public function hapusCookie()
    {
      $response = new Response('200OK');
      $response->withCookie(cookie()->forget('cookie_barang'));
      return $response;
    }

    public function checkKode(Request $request)
    {
      echo json_encode(Good::where('kode', '=', $request['kode'])->count());
    }

    public function CheckDetailUnit(Request $request){
      echo json_encode(Detail_Unit::with('unit')->where('good_id', $request->id)->get());
    }


}
