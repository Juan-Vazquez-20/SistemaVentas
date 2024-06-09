<?php

namespace App\Http\Controllers;

use Exception;

use App\Models\Marca;
use App\Models\Caracteristica;
use App\Http\Requests\StoreMarcaRequest;
use App\Http\Requests\UpdateMarcaRequest;
USE App\Http\Controllers\UpdateMarcaRequet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class marcaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $marcas = Marca::with('caracteristica')->latest()->get();
        /**d($Marcas);**/
        return view('marca.index',['Marcas' => $marcas]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('marca.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMarcaRequest $request)
    {

        try{
            DB::beginTransaction();
            $caracteristica = Caracteristica::create($request->validated());
            $caracteristica->marca()->create([
                'caracteristica_id' => $caracteristica->id
            ]);
            DB::commit();
        }catch (Exception $e){
            DB::rollBack();
        }

        return redirect()->route('marcas.index')->with('success', 'Marca creada con éxito');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Marca $marca)
    {
        return view('marca.edit', ['marca' => $marca]);
    }
   
    public function update(UpdateMarcaRequest $request, Marca $marca)
    {
        Caracteristica::where('id', $marca->caracteristica->id)->update($request->validated());
        return redirect()->route('marcas.index')->with('success', 'Marca actualizada con éxito');
    }

    public function destroy(string $id)
    {
        $meesege = '';
        $marca = Marca::find($id);
        if($marca->caracteristica->estado == 0){
            Caracteristica::where('id', $marca->caracteristica->id)->update(['estado'=> 1]);
            $meesege = 'Marca Restaurada con éxito';
        }
        else{
            Caracteristica::where('id', $marca->caracteristica->id)->update(['estado'=> 0]);
            $meesege = 'Marca Eliminada con éxito';
        }
        return redirect()->route('marcas.index')->with('success', $meesege);
    }
}
