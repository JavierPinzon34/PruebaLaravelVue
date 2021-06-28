<?php

namespace App\Http\Controllers;

use App\People;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeopleController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    if ($request->document) {
      if ($request->type == '1') {
        return People::where('type', 1)->where('document', $request->document)->paginate(5);
      }
      return People::where('type', 0)->where('document', $request->document)->paginate(5);
    }
    if ($request->type == '1') {
      return People::where('type', 1)->paginate(5);
    }
    return People::where('type', 0)->paginate(5);

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
      $type = $request->type;
      /**
       * validations->valida que el nombre y el e-mail no esten en la base de datos
       */
      $request->validate([
        'document' => 'required',
        'document' => Rule::unique('people')->where(function ($query) use ($type) {
          return $query->where('type', $type);
        })
      ]);

      $data = $request->all();
      $user = People::create($data);
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
    return People::find($id);
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
      $type = $request->type;
      /**
       * validations->valida que el nombre y el e-mail no esten en la base de datos
       */
      $request->validate([
        'document' => 'required',
        'document' => Rule::unique('people')->where(function ($query) use ($type) {
          return $query->where('type', $type);
        })->ignore($id)
      ]);

      $user = People::find($id);
      $user->first_name = $request->first_name;
      $user->second_name = $request->second_name;
      $user->first_surname = $request->first_surname;
      $user->second_surname = $request->second_surname;
      $user->type_document = $request->type_document;
      $user->document = $request->document;
      $user->type = $request->type;
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
      $selectedUser = People::find($id);
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
