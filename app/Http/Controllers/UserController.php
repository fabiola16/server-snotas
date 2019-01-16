<?php

namespace App\Http\Controllers;

use App\Professional;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(Request $request)
    {
        try {
            $data = $request->json()->all();
            $dataUser = $data['user'];
            $user = User::where('user_name', $dataUser['user_name'])
                ->orWhere('email', $dataUser['user_name'])
                ->join("role_user", "role_user.user_id", "=", "users.id")
                ->join("roles", "roles.id", "=", "role_user.role_id")
                ->select('users.id', 'users.name', 'users.avatar', 'users.user_name', 'users.email', 'users.password', 'users.api_token',
                    'roles.role')
                ->first();
            if ($user && Hash::check($dataUser['password'], $user->password)) {
                return response()->json($user, 200);
            } else {
                return response()->json([], 401);
            }
        } catch (NotFoundHttpException  $e) {
            return response()->json('NotFoundHttp', 405);
        } catch (QueryException $e) {
            return response()->json($e, 500);
        } catch (Exception $e) {
            return response()->json('Exception', 500);
        } catch (Error $e) {
            return response()->json('Error', 500);
        }
    }

    function logout(Request $request)
    {
        $data = $request->json()->all();
        $dataUser = $data['user'];
        try {
            User::where('user_name', $dataUser['user_name'])->update(['api_token' => str_random(60),]);
            return response()->json([], 201);
        } catch (ModelNotFoundException $e) {
            return response()->json($e, 405);
        } catch (NotFoundHttpException  $e) {
            return response()->json($e, 405);
        } catch (QueryException  $e) {
            return response()->json($e, 405);
        } catch (Exception $e) {
            return response()->json('Exception', 500);
        } catch (Error $e) {
            return response()->json('Error', 500);
        }

    }

    function getAllUsers(Request $request)
    {
        try {
            $users = User::orderby($request->field, $request->order)->paginate($request->limit);
            return response()->json($users, 200);
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

    function showUser($id)
    {
        try {
            $user = User::findOrFail($id);
            return response()->json(['user' => $user], 200);
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

    function createUser(Request $request)
    {
        try {
            $data = $request->json()->all();
            $dataUser = $data['user'];
            $dataProfessional = $data['professional'];
            DB::beginTransaction();
            $user = User::create([
                'name' => strtoupper($dataUser['name']),
                'user_name' => $dataUser['user_name'],
                'email' => $dataUser['email'],
                'password' => Hash::make($dataUser['password']),
                'api_token' => str_random(60),
            ]);
            $user->professional()->create([
                'identity' => $dataProfessional['identity'],
                'first_name' => strtoupper($dataProfessional['first_name']),
                'last_name' => strtoupper($dataProfessional['last_name']),
                'email' => strtolower($dataProfessional['email']),
                'nationality' => strtoupper($dataProfessional['nationality']),
                'civil_state' => strtoupper($dataProfessional['civil_state']),
                'birthdate' => $dataProfessional['birthdate'],
                'gender' => strtoupper($dataProfessional['gender']),
                'phone' => $dataProfessional['phone'],
                'address' => strtoupper($dataProfessional['address']),
                'about_me' => strtoupper($dataProfessional['about_me']),
            ]);
            $user->roles()->attach(1);
            DB::commit();
            return response()->json(['user' => $user], 201);
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

    function updateUser(Request $request)
    {
        try {
            $data = $request->json()->all();
            $dataUser = $data['user'];
            $user = User::findOrFail($dataUser['id'])->update([
                'name' => strtoupper($dataUser['name']),
                'user_name' => $dataUser['user_name'],
                'email' => strtolower($dataUser['email']),
                'password' => Hash::make($dataUser['password']),
                'api_token' => str_random(60),
            ]);
            return response()->json($user, 201);
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

    function deleteUser(Request $request)
    {
        try {
            $user = User::findOrFail($request->id)->delete();
            return response()->json($user, 201);
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
