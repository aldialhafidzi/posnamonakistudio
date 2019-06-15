<?php

namespace App\Http\Controllers;

use App\Unit;
use App\Detail_Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        'nama'      => $request['input_unit']
      ];

      Unit::insert($data);
      $last_insert_id = DB::getPdo()->lastInsertId();

      return response()->json(['message' => 'Unit baru berhasil ditambahkan.', 'id' => $last_insert_id]);
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function AllUnit(Request $request)
    {
      echo json_encode(Unit::all());
    }

    public function StoreDetailUnit(Request $request)
    {
      // dd($request->all());

      foreach ($request['cu_good_id'] as $key => $value) {

        DB::table('detail_units')->where('good_id', $request['cu_good_id'][$key])->delete();

        foreach ($request['dcu_unit_id'][$key] as $j => $value) {
          $data = [
            'good_id'   => $request['cu_good_id'][$key],
            'qty'       => $request['dcu_qty'][$key][$j],
            'unit_id'   => $request['dcu_unit_id'][$key][$j]
          ];

          Detail_Unit::insert($data);
        }


      }

      return response()->json(['message' => 'Pengaturan unit berhasil diubah.']);

    }





}
