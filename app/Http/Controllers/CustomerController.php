<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $judul      = 'Hijrah Mandiri - Customer';
      $page       = 'penjualan';

      return view('customer', [ 'page'        => $page,
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

      Customer::insert($data);

      return response()->json(['message' => 'Data pelanggan berhasil ditambahkan.']);
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
      $customers = Customer::find($id);
      return $customers;
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
      $customer = Customer::find($id);

      $customer->nama  = $request['nama'];
      $customer->alamat  = $request['alamat'];
      $customer->no_telp  = $request['no_telp'];

      $customer->update();
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
      Customer::destroy($id);
      return response()->json(['message' => 'Data berhasil dihapus.']);
    }


    public function AllCustomer()
    {
      $customer = Customer::all();
      $datatables = Datatables::of($customer)
                    ->addIndexColumn()
                    ->addColumn('action', function($customer){
                               return '<a onclick="editCustomerForm('.$customer->id.')" style="color : #FFF;" class="btn btn-sm btn-info"><span class="glyphicon glyphicon-edit"></span> Edit</a>'.' '.
                                      '<a onclick="deleteCustomerForm('.$customer->id.')" style="color : #FFF;" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal_hapus_data" data-backdrop="static" data-keyboard="false"><span class="glyphicon glyphicon-trash"></span> Delete</a>';
                             });
       return $datatables->make(true);
    }













}
