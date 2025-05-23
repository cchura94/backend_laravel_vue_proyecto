<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $categorias = Categoria::orderBy('id', 'desc')
                                    // ->where('estado', true)
                                    ->get();

            return response()->json($categorias, 200);

        } catch (\Exception $e) {
            return response()->json(["message" => "Error al obtener los datos", "error" => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "nombre" => "required"
        ]);

         try {
            $categoria = new Categoria();
            $categoria->nombre = $request->nombre;
            $categoria->detalle = $request->detalle;
            // $categoria->estado = $request->estado;
            $categoria->save();
            return response()->json(["message" => "Categoria Registrada"], 201);

        } catch (\Exception $e) {
            return response()->json(["message" => "Error al registrar los datos", "error" => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
         try {
            $categoria = Categoria::findOrFail($id);

             return response()->json($categoria, 200);

        } catch (\Exception $e) {
            return response()->json(["message" => "Error al obtener los datos", "error" => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "nombre" => "required"
        ]);
    
        try {
                $categoria = Categoria::findOrFail($id);
                $categoria->nombre = $request->nombre;
                $categoria->detalle = $request->detalle;
                $categoria->estado = $request->estado;
                $categoria->update();
                return response()->json(["message" => "Categoria Actualizada"], 200);

        } catch (\Exception $e) {
            return response()->json(["message" => "Error al obtener los datos", "error" => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $categoria = Categoria::findOrFail($id);
            $categoria->estado = !$categoria->estado;
            $categoria->update();
            
            return response()->json(["message" => "Categoria Actualizada"], 201);

        } catch (\Exception $e) {
            return response()->json(["message" => "Error al eliminar los datos", "error" => $e->getMessage()], 500);
        }
    }
}
