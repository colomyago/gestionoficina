<!DOCTYPE html>
<html>
<head>
    <title>Usuarios</title>
</head>
<body>
    <h1>Lista de Usuarios</h1>

    @if(count($users) > 0)
        <ul>
            @foreach($users as $user)
                <li>
                    {{ $user->name }} - {{ $user->email }}
                </li>
            @endforeach
        </ul>
    @else
        <p>No hay usuarios para mostrar.</p>
    @endif

</body>
</html>