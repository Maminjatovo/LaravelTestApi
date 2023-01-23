<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class EtudiantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return response()->json(Etudiant::all());

        $etudiants = Etudiant::all();
        $etudiants->map(function ($etudiant) {     
        $etudiant->image = $this->format($etudiant->image);
                 
        return $etudiant;
        });
       
        return response()->json($etudiants);
    }

    public function format($image_name)
    {
        if(is_null($image_name)){
            $path = public_path().'/images/default-avatar.png';
        }
        else{
            $path = public_path().'/images/'.$image_name;
        }
        
        
/*
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);     
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
*/
        $image = Image::make($path)->resize(50, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $data = (string) $image->encode();
        $base64 = 'data:image/' . $image->mime() . ';base64,' . base64_encode($data);


        return $base64;
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
        $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'adresse' => 'required',
            'telephone' => 'required',
            'sexe' => 'required',
            //'file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',   
            'file' => 'nullable',        
        ]);
      

        if (!$request->hasFile('file') || !$request->file('file')->isValid()) {
            $imageName = null;
        } else {
            $imageName = time() . '_' . $request->image . '.' . $request->file('file')->extension();
            $request->file('file')->move(public_path('images'), $imageName);
        }
    

        //$image = new Image;
        //$image->name = $imageName;
        //$image->save();

        $etudiant = Etudiant::create(
            [
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'adresse' => $request->adresse,
                'telephone' => $request->telephone,
                'sexe' => $request->sexe,
                'image' => $imageName,

            ]
        );

        $etudiant->image = $this->format($etudiant->image);

        return response()->json($etudiant, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $etudiant = Etudiant::findOrFail($id);
        return response()->json($etudiant);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $etudiant = Etudiant::findOrFail($id);
       
        $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'adresse' => 'required',
            'telephone' => 'required',
            'sexe' => 'required',
            //'file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',   
            'file' => 'nullable',        
        ]);
      
        if (!$request->hasFile('file') || !$request->file('file')->isValid()) {
            $etudiant->update(
                [
                    'nom' => $request->nom,
                    'prenom' => $request->prenom,
                    'adresse' => $request->adresse,
                    'telephone' => $request->telephone,
                    'sexe' => $request->sexe,
                    'image' => $etudiant->image,
    
                ]
            );
        } else {
            $imageName = time() . '_' . $request->image . '.' . $request->file('file')->extension();
            $request->file('file')->move(public_path('images'), $imageName);
            if(!is_null($etudiant->image)){
                unlink(public_path('/images/'.$etudiant->image));
            } 
            $etudiant->update(
                [
                    'nom' => $request->nom,
                    'prenom' => $request->prenom,
                    'adresse' => $request->adresse,
                    'telephone' => $request->telephone,
                    'sexe' => $request->sexe,
                    'image' => $imageName,   
                ]
            );
            
        }
        $etudiant->image = $this->format($etudiant->image);
        return response()->json($etudiant);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $etudiant = Etudiant::findOrFail($id);
        if(!is_null($etudiant->image)){
            unlink(public_path('/images/'.$etudiant->image));
        }      
        $etudiant->delete();
        return response()->json(null, 204);
    }
}
