<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $roles      = Role::all();
      $judul      = 'Hijrah Mandiri - User';
      $page       = 'user';

      return view('user', [  'page'        => $page,
                             'judul'       => $judul,
                             'roles'       => $roles
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
          'username'  => $request['username'],
          'name'      => $request['name'],
          'role_id'   => $request['role_id'],
          'email'     => $request['email'],
          'password'  => Hash::make($request['password'])
        ];

        User::insert($data);

        $user_id = DB::getPdo()->lastInsertId();
        $data = [
          'role_id'     => $request['role_id'],
          'model_id'    => $user_id,
          'model_type'  => 'App\User'
        ];

        DB::table('model_has_roles')->insert($data);
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
      $users = User::with('role')->find($id);
      return $users;
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
      $user = User::find($id);

      $user->username = $request['username'];
      $user->name     = $request['name'];
      $user->email    = $request['email'];
      $user->role_id  = $request['role_id'];

      $user->update();

      DB::table('model_has_roles')->where('model_id', $id)->delete();

      $data = [
        'role_id'     => $request['role_id'],
        'model_id'    => $id,
        'model_type'  => 'App\User'
      ];

      DB::table('model_has_roles')->insert($data);

      return response()->json(['message' => 'Data user berhasil diupdate.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      User::destroy($id);
      return response()->json(['message' => 'Data berhasil dihapus.']);
    }

    public function AllUser()
    {
      $user = User::with('role')->get();
      $datatables = Datatables::of($user)
                    ->addIndexColumn()
                    ->addColumn('action', function($user){
                               return '<a onclick="editUserForm('.$user->id.')" style="color : #FFF;" class="btn btn-sm btn-info"><span class="glyphicon glyphicon-edit"></span> Edit</a>'.' '.
                                      '<a onclick="deleteUserForm('.$user->id.')" style="color : #FFF;" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal_hapus_data" data-backdrop="static" data-keyboard="false"><span class="glyphicon glyphicon-trash"></span> Delete</a>';
                             });
       return $datatables->make(true);
    }



}
