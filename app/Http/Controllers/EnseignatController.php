<?php

namespace App\Http\Controllers;

use App\Models\Enseignat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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
/*
    public function store(Request $request)
    {
        
        $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'adress' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',



        ]);
        $image_path = $request->file('image')->store('image', 'public') . '.' . time() . '.' . $request->image->extension();
        $request->image->move(public_path('images'), $image_path);
        $Enseignat = Enseignat::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'adress' => $request->adress,
            'image' => $image_path,
        ]);
        return response()->json($Enseignat, 201);
    }
*/



    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'nom' => 'required',
            'prenom' => 'required',
            'adress' => 'required',
            'image' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ])->validate();
        $image_path = $request->file('image')->store('image', 'public') . '.' . time() . '.' . $request->image->extension();
        $request->image->move(public_path('images'), $image_path);
        /*
        $fileName = time().'.'.$request->file->extension();  
        $request->file->move(public_path('images'), $fileName);
*/
        $Enseignat = Enseignat::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'adress' => $request->adress,
            'image' => $request->image,
            'name_img' => $image_path
        ]);


        return response()->json($Enseignat, 201);
    }

    public function update(Request $request, $id)
    {
        $Enseignat = Enseignat::find($id);
        $Enseignat->nom = $request->nom;
        $Enseignat->prenom = $request->prenom;
        $Enseignat->adress = $request->adress;
        $Enseignat->image = $request->image;
        $Enseignat->save();

        return response()->json($Enseignat);
    }

    public function upload(Request $request)
    {
    }

    public function destroy($id)
    {
        $Enseignat = Enseignat::find($id);
        $Enseignat->delete();

        return response()->json(null, 204);
    }
}
