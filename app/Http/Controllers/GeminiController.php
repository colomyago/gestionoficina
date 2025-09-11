<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GeminiService; //Conecta con el servicio GeminiService (GeminiService.php) creado en la carpeta Services (import local)

class GeminiController extends Controller
{
    protected $gemini;

    public function __construct(GeminiService $gemini)
    {
        $this->gemini = $gemini;
    }

    public function index()
    {
        return view('index'); //Retorna la vista index.blade.php
    }


    public function chat(Request $request)
    {
        try {
            $validated = $request->validate([ //Valida que el campo 'prompt' esté presente, sea una cadena y no exceda los 1000 caracteres
                'prompt' => 'required|string|max:1000'
            ]);

            $respuesta = $this->gemini->prompt($validated['prompt']); //Llama al método prompt del servicio GeminiService con el texto validado

            return response()->json([ //Devuelve una respuesta JSON con el estado y la respuesta de Gemini
                'status' => 'success',
                'respuesta' => $respuesta
            ]);

        } catch (\Exception $e) { //Captura cualquier excepción que ocurra durante el proceso y devuelve un error JSON
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}