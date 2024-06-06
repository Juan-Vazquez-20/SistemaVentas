<?php

namespace App\Http\Controllers;

use Exception;

use App\Models\Categoria;
use App\Models\Caracteristica;
use App\Http\Requests\StoreCategoriaRequest;
use App\Http\Requests\UpdateCategoriaRequest;
USE App\Http\Controllers\UpdateCategoriaRequet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class categoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorias = Categoria::with('caracteristica')->latest()->get();
        /**d($categorias);**/
        return view('categoria.index',['categorias' => $categorias]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categoria.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoriaRequest $request)
    {

        try{
            DB::beginTransaction();
            $caracteristica = Caracteristica::create($request->validated());
            $caracteristica->categoria()->create([
                'caracteristica_id' => $caracteristica->id
            ]);
            DB::commit();
        }catch (Exception $e){
            DB::rollBack();
        }

        return redirect()->route('categorias.index')->with('success', 'Categoria creada con éxito');
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
    public function edit(Categoria $categoria)
    {
        /*dd($categoria);*/
        return view('categoria.edit', ['categoria' => $categoria]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoriaRequest $request, Categoria $categoria)
    {
        Caracteristica::where('id', $categoria->caracteristica->id)->update($request->validated());
        return redirect()->route('categorias.index')->with('success', 'Categoria actualizada con éxito');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $meesege = '';
        $categoria = Categoria::find($id);
        if($categoria->caracteristica->estado == 0){
            Caracteristica::where('id', $categoria->caracteristica->id)->update(['estado'=> 1]);
            $meesege = 'Categoria Restaurada con éxito';
        }
        else{
            Caracteristica::where('id', $categoria->caracteristica->id)->update(['estado'=> 0]);
            $meesege = 'Categoria Eliminada con éxito';
        }
        return redirect()->route('categorias.index')->with('success', $meesege);
    }
}
