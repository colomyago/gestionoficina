<?php

namespace App\Services;

use Illuminate\Support\Facades\Http; //Necesario para hacer peticiones HTTP

class GeminiService
{
    protected $apiKey; //Variable local temporal, parecido a var en GM

    public function __construct()
    {
        $this->apiKey = env('GEMINI_API_KEY'); // Accedo a la api key del propio objeto, la flecha -> se usa para acceder a las propiedades y métodos de un objeto. La funcion env() obtiene el valor de una variable de entorno definida en el archivo .env
    }

    public function prompt(string $texto): string
    {
        $response = Http::post( //Envia una solicitud HTTP POST a la URL de gemini con el modelo indicado y la clave API.
            "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=" . $this->apiKey,
            [
                'contents' => [[
                    'parts' => [['text' => $texto]] //El texto que se envía a la API de Gemini
                ]]
            ]
        );

        $data = $response->json();  //Convierte la respuesta JSON en un array asociativo de PHP

        return $data['candidates'][0]['content']['parts'][0]['text'] ?? 'Sin respuesta'; //Devuelve el texto generado por Gemini o 'Sin respuesta' si no hay datos
    }
}