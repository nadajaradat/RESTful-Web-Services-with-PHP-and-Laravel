<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRegistraion;
use App\Models\Registraion;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRegistraion $request)
    {
        $registration = Registraion::create($request->validated());
        return response()->json(['message' => "Registration Created Successfully", 'registration' => $registration], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Registraion $registraion)
    {
        $registraion->delete();
        return response()->json(['message' => "Registration Deleted Successfully"], 200);
    }
}
