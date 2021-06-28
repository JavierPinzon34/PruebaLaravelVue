<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash as FacadesHash;

class UserController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return User::paginate(5);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    try {
      DB::beginTransaction();
      /**
       * validations->valida que el nombre y el e-mail no esten en la base de datos
       */
      $request->validate([
        'email' => 'required|max:130|unique:users,email'
      ]);
      $data = $request->all();
      $data['password'] = FacadesHash::make($request->password);
      $user = User::create($data);
      DB::commit();

      /**
       * Respuesta de la transacción
       */
      if ($user) {
        return response()->json([
          'type' => 'success',
          'message' => 'Successfully Created',
          'data' => $user
        ], 201);
      } else {
        return response()->json([
          'type' => 'error',
          'message' => 'Save failed',
          'data' => []
        ], 204);
      }
    } catch (Exception $e) {
      return response()->json([
        'type' => 'error',
        'message' => 'Save failed',
        'data' => []
      ], 204);
      DB::rollBack();
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    return User::find($id);
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
    try {
      DB::beginTransaction();
      /**
       * validations->valida que el nombre y el e-mail no esten en la base de datos
       */
      $request->validate([
        'email' => 'required|max:130|unique:users,email,' . $id
      ]);

      $user = User::find($id);
      $user->name = $request->name;
      $user->email = $request->email;
      if ($request->password != 'null') {
        $user->password = FacadesHash::make($request->password);
      }
      $user->save();
      DB::commit();

      /**
       * Respuesta de la transacción
       */
      if ($user) {
        return response()->json([
          'type' => 'success',
          'message' => 'Successfully Updated',
          'data' => $user
        ], 202);
      } else {
        return response()->json([
          'type' => 'error',
          'message' => 'Update Failed',
          'data' => []
        ], 204);
      }
    } catch (Exception $e) {
      return response()->json([
        'type' => 'error',
        'message' => 'Update Failed',
        'data' => []
      ], 204);
      DB::rollBack();
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    try {
      DB::beginTransaction();
      $selectedUser = User::find($id);
      $selectedUser->delete();
      DB::commit();

      /**
       * Respuesta de la transacción
       */
      if ($selectedUser) {
        return response()->json([
          'type' => 'success',
          'message' => 'Record Removed Successfully',
          'data' => $selectedUser
        ], 202);
      } else {
        return response()->json([
          'type' => 'error',
          'message' => 'Error Deleting',
          'data' => []
        ], 204);
      }
    } catch (Exception $e) {
      return response()->json([
        'type' => 'error',
        'message' => 'Error Deleting',
        'data' => []
      ], 204);
      DB::rollBack();
    }
  }
}
