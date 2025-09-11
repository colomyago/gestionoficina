<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Chat con Gemini</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss/dist/tailwind.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

    <div class="bg-white shadow-lg rounded-2xl p-6 w-full max-w-lg">
        <h1 class="text-2xl font-bold mb-4">Chat con gemini</h1>

        <div class="flex gap-2 mb-4">
            <input type="text" id="prompt" placeholder="Escribe tu prompt..."
                   class="flex-1 border rounded-lg p-2" required>
            <button onclick="sendPrompt()" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Enviar</button>
        </div>

        <div id="chat-container">
            <!-- Las respuestas aparecerán aquí -->
        </div>
    </div>

    <script>
        function sendPrompt() {
            const prompt = document.getElementById('prompt').value;
            if (!prompt) return;

            // Agregar el mensaje del usuario
            addMessage('Tú', prompt, 'bg-gray-100');

            fetch('/api/gemini', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ prompt: prompt })
            })
            .then(response => response.json())
            .then(data => {
                // Agregar la respuesta de Gemini
                addMessage('Gemini', data.respuesta, 'bg-green-100');
                document.getElementById('prompt').value = ''; // Limpiar el input
            })
            .catch(error => {
                console.error('Error:', error);
                addMessage('Error', 'Hubo un error al procesar tu solicitud', 'bg-red-100');
            });
        }

        function addMessage(sender, message, bgClass) {
            const container = document.getElementById('chat-container');
            const messageDiv = document.createElement('div');
            messageDiv.className = 'mb-4';
            messageDiv.innerHTML = `
                <p class="font-semibold">${sender}:</p>
                <p class="${bgClass} p-2 rounded">${message}</p>
            `;
            container.appendChild(messageDiv);
            container.scrollTop = container.scrollHeight;
        }

        // Permitir enviar con Enter
        document.getElementById('prompt').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                sendPrompt();
            }
        });
    </script>

</body>
</html>