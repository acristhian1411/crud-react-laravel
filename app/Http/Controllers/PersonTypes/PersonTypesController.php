<?php

namespace App\Http\Controllers\PersonTypes;

use App\Models\PersonTypes;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class PersonTypesController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $t = PersonTypes::query()->first();
            $query = PersonTypes::query();
            $query = $this->filterData($query, $t);
            $datos = $query->get();
            return $this->showAll($datos, 200);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage(),'mesage'=>'No se pudo obtener los datos']);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $rules=[
                'p_type_desc' => 'required|string|max:255',
            ];
            $request->validate($rules);
            $personType = PersonTypes::create($request->all());
            return $this->showOne($personType, 201);
        }catch(\Exception $e){
            return response()->json(['error'=> $e->getMessage(),'mesage'=>'No se pudo obtener los datos']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PersonTypes  $personTypes
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $personType = PersonTypes::find($id);
            return $this->showOne($personType,200);
        } catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage(),'mesage'=>'No se pudo obtener los datos']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        try{
            $validatedData = $request->validate([
                'p_type_desc' => 'required|string|max:255',
            ]);

            // Update the till type
            $personTypes = PersonTypes::findOrFail($id);
            $personTypes->update($validatedData);
            // Return a success response
            return $this->showOne($personTypes, 200);
        } catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage(),'mesage'=>'No se pudo actualizar los datos']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PersonTypes  $personTypes
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $personTypes = PersonTypes::findOrFail($id);
            $personTypes->delete();
            return response()->json('Eliminado con exito');
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage(),'mesage'=>'No se pudo eliminar los datos']);
        }
    }
}
