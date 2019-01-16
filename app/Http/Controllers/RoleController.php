<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Role;

class RoleController extends Controller
{
    function getAllRoles(Request $request)
    {
        try {
            $roles = Role::where('state', 'ACTIVE')
                ->orderby($request->field, $request->order)
                ->paginate($request->limit);
            return response()->json([
                'pagination' => [
                    'total' => $roles->total(),
                    'current_page' => $roles->currentPage(),
                    'per_page' => $roles->perPage(),
                    'last_page' => $roles->lastPage(),
                    'from' => $roles->firstItem(),
                    'to' => $roles->lastItem()
                ], 'languages' => $roles], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json($e, 405);
        } catch (NotFoundHttpException  $e) {
            return response()->json($e, 405);
        } catch (QueryException $e) {
            return response()->json($e, 409);
        } catch (\PDOException $e) {
            return response()->json($e, 409);
        } catch (Exception $e) {
            return response()->json($e, 500);
        } catch (Error $e) {
            return response()->json($e, 500);
        }
    }

    function showRole($id)
    {
        try {
            $language = Role::findOrFail($id);
            return response()->json(['language' => $language], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json($e, 405);
        } catch (NotFoundHttpException  $e) {
            return response()->json($e, 405);
        } catch (QueryException $e) {
            return response()->json($e, 409);
        } catch (\PDOException $e) {
            return response()->json($e, 409);
        } catch (Exception $e) {
            return response()->json($e, 500);
        } catch (Error $e) {
            return response()->json($e, 500);
        }
    }

    function createRole(Request $request)
    {
        try {
            $data = $request->json()->all();
            $dataRole = $data['role'];
            $role = Role::create([
                'description' => strtoupper($dataRole ['description']),
                'role' => $dataRole ['role'],
            ]);
            return response()->json(['role' => $role], 201);
        } catch (ModelNotFoundException $e) {
            return response()->json($e, 405);
        } catch (NotFoundHttpException  $e) {
            return response()->json($e, 405);
        } catch (QueryException $e) {
            return response()->json($e, 409);
        } catch (\PDOException $e) {
            return response()->json($e, 409);
        } catch (Exception $e) {
            return response()->json($e, 500);
        } catch (Error $e) {
            return response()->json($e, 500);
        }
    }

    function updateRole(Request $request)
    {
        try {
            $data = $request->json()->all();
            $dataRole = $data['role'];
            $role = Role::findOrFail($dataRole['id'])->update([
                'description' => $dataRole ['description'],
                'role' => $dataRole ['role'],
            ]);
            return response()->json($role, 201);
        } catch (ModelNotFoundException $e) {
            return response()->json($e, 405);
        } catch (NotFoundHttpException  $e) {
            return response()->json($e, 405);
        } catch (QueryException $e) {
            return response()->json($e, 409);
        } catch (\PDOException $e) {
            return response()->json($e, 409);
        } catch (Exception $e) {
            return response()->json($e, 500);
        } catch (Error $e) {
            return response()->json($e, 500);
        }
    }

    function deleteRole(Request $request)
    {
        try {
            $role = Role::findOrFail($request->id)->delete();
            return response()->json($role, 201);
        } catch (ModelNotFoundException $e) {
            return response()->json($e, 405);
        } catch (NotFoundHttpException  $e) {
            return response()->json($e, 405);
        } catch (QueryException $e) {
            return response()->json($e, 409);
        } catch (\PDOException $e) {
            return response()->json($e, 409);
        } catch (Exception $e) {
            return response()->json($e, 500);
        } catch (Error $e) {
            return response()->json($e, 500);
        }
    }
}
