<?php

namespace App\Http\Controllers;

use App\Models\Enseignat;
use Illuminate\Http\Request;

class EnseignatController extends Controller
{
    // Récupérer tous les enregistrements de la table "nom_de_table"
    public function index()
    {
        return response()->json(Enseignat::all()); //Enseignats
    }


    // Récupérer un enregistrement spécifique de la table "nom_de_table" en fonction de son id
    public function show($id)
    {
        $Enseignat = Enseignat::findOrFail($id);
       
        return response()->json($Enseignat);
    }


    // Créer un nouvel enregistrement dans la table "nom_de_table" en utilisant les données reçues dans la requête
    public function store(Request $request)
    {
        $request->validate([
            'nom'=>'required',
            'prenom'=>'required',
            'adress'=>'required',
        ]);
        $Enseignat = Enseignat::create($request->all());
        return response()->json($Enseignat, 201);
    }


    public function update(Request $request, $id)
    {
        $Enseignat = Enseignat::find($id);
        $Enseignat->nom = $request->nom;
        $Enseignat->prenom = $request->prenom;
        $Enseignat->adress = $request->adress;
        $Enseignat->save();

        return response()->json($Enseignat);
    }

    public function destroy($id)
    {
        $Enseignat = Enseignat::find($id);
        $Enseignat->delete();

        return response()->json(null, 204);
    }
}
