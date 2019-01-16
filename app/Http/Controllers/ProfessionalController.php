<?php

namespace App\Http\Controllers;

use App\Company;
use App\Professional;
use App\AcademicFormation;
use App\Ability;
use App\Language;
use App\Course;
use App\ProfessionalExperience;
use App\ProfessionalReference;
use Illuminate\Support\Facades\DB;
use App\Offer;
use Illuminate\Http\Request;
Use Exception;
Use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
Use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProfessionalController extends Controller
{
    function getAllProfessionals()
    {
        $offers = Offer::where('state', 'ACTIVE')
            ->get();
        return response()->json(['offers' => $offers], 200);

    }

    function showProfessional($id)
    {
        try {
            $professional = Professional::where('user_id', $id)->first();
            return response()->json(['professional' => $professional], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json($e, 405);
        } catch (NotFoundHttpException  $e) {
            return response()->json($e, 405);
        } catch (QueryException  $e) {
            return response()->json($e, 405);
        } catch (Exception $e) {
            return response()->json($e, 500);
        } catch (Error $e) {
            return response()->json($e, 500);
        }
    }

    function updateProfessional(Request $request)
    {
        try {
            $data = $request->json()->all();
            $dataProfessional = $data['professional'];
            $professional = Professional::findOrFail($dataProfessional['id'])->update([
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
            return response()->json($professional, 201);
        } catch (ModelNotFoundException $e) {
            return response()->json('ModelNotFound', 405);
        } catch (NotFoundHttpException  $e) {
            return response()->json('NotFoundHttp', 405);
        } catch (QueryException $e) {
            return response()->json($e, 500);
        } catch (Exception $e) {
            return response()->json($e, 500);
        } catch (Error $e) {
            return response()->json($e, 500);
        }
    }

    function deleteProfessional(Request $request)
    {
        try {
            $professional = Professional::findOrFail($request->id)->delete();
            return response()->json($professional, 201);
        } catch (ModelNotFoundException $e) {
            return response()->json('ModelNotFound', 405);
        } catch (NotFoundHttpException  $e) {
            return response()->json('NotFoundHttp', 405);
        } catch (Exception $e) {
            return response()->json('Exception', 500);
        } catch (Error $e) {
            return response()->json('Error', 500);
        }
    }
}
