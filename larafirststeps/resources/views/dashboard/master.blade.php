<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Formulario - Dashboard</title>
    
    <!-- Bootstrap (opcional pero recomendado) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            display: flex;
            min-height: 100vh;
        }
        aside {
            width: 250px;
            background-color: #343a40;
            color: white;
            padding: 20px;
        }
        aside a {
            color: white;
            text-decoration: none;
            display: block;
            margin: 10px 0;
        }
        aside a:hover {
            color: #0d6efd;
        }
        main {
            flex: 1;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .active {
            background-color: #0d6efd;
            padding: 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>

    <aside>
        <h4>📧 Formulario</h4>
        <p>Usuario</p>
        <a href="{{ url('/dashboard/post') }}" class="active">🏠 Post</a>
        <a href="{{ url('/dashboard/category') }}">📄 Categoria</a>
        <a href="{{ url('/') }}" style="color: #dc3545;">⛔ Salir</a>
    </aside>

    <main>
        @if (session('status'))
            <div class="alert alert-info">
                {{ session('status') }}
            </div>
        @endif

        @yield('content')
    </main>

</body>
</html>
