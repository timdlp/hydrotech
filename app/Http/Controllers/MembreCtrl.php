<?php

namespace App\Http\Controllers;

use App\Membre;
use Illuminate\Http\Request;
use Illuminate\Http\Response;



class MembreCtrl extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $membres = Membre::all()->where('actif', true);
        foreach ($membres as $membre){
            //$membre['photoProfil'] = urldecode($membre['photoProfil']);
            $membre->photoProfil = urldecode($membre->photoProfil);
            $membre->editions;
        }
        return $membres;
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
        $para = $request->only(['adresseMail', 'nom', 'prenom', 'dateNaissance', 'section', 'description', 'photoProfil']);
        if (!Membre::isValid($para)) {
            return response()->json('Membre non valide', Response::HTTP_BAD_REQUEST);
        }
        $membre = new Membre($para);

        $membre->save();
        return response()->json($membre, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $membre = Membre::find($id);
        $membre->editions;
        if (!Membre::isValid(['id' => $id]) || $membre->actif == false) {
            return response()->json('Membre non valide', Response::HTTP_BAD_REQUEST);
        }
        if (Membre::find($id) == null) {
            return response()->json('Membre introuvable', Response::HTTP_NOT_FOUND);
        }
        return $membre;
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
        $membre = Membre::find($id);
        $para = $request->intersect(['adresseMail', 'nom', 'prenom', 'dateNaissance', 'section', 'description', 'photoProfil']);
        if (!Membre::isValid($para)) {
            return response()->json('Membre non valide', Response::HTTP_BAD_REQUEST);
        }
        if (!Membre::isValid(['id' => $id]) || $membre->actif == false) {
            return response()->json('Membre inexistant', Response::HTTP_NOT_FOUND);
        }
        $membre->update($para);
        return response()->json($membre, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $membre = Membre::find($id);

        if (!Membre::isValid(['id' => $id])) {
            return response()->json('Membre non valide', Response::HTTP_BAD_REQUEST);
        }
        if ($membre == null) {
            return response()->json('Membre introuvable', Response::HTTP_NOT_FOUND);
        }
        if($membre['actif'] == false){
            return response()->json('Membre déjà supprimé', Response::HTTP_NOT_FOUND);
        }
        foreach ($membre->editions as $ed){
            $membre->editions()->updateExistingPivot($ed->id, ['actif' => false]);
        }
        $membre->actif = false;
        $membre->save();
        return response()->json('OK', Response::HTTP_OK);
    }
}
