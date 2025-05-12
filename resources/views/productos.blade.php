<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Productos</title>
    <style>
        body { font-family: Arial; background: #f4f4f4; margin: 0; padding: 20px; }
        table { width: 100%; border-collapse: collapse; background: #fff; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background-color: #eaeaea; }
        h1 { margin-bottom: 20px; }
    </style>
</head>
<body>
<a href="/" class="btn btn-secondary" style="margin-bottom: 20px;">Regresar</a>

    <h1>Lista de Productos</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Descripción</th> <!-- Columna para la Descripción -->
                <th>Fecha de creación</th>
                <th>Acciones</th> <!-- Columna para las acciones -->
            </tr>
        </thead>
        <tbody>
            @foreach ($productos as $producto)
                <tr>
                    <td>{{ $producto->id }}</td>
                    <td>{{ $producto->name }}</td>
                    <td>${{ $producto->price }}</td>
                    <td>{{ $producto->stock }}</td>
                    <td>{{ $producto->description }}</td> <!-- Mostrar la Descripción -->
                    <td>{{ $producto->created_at }}</td>
                    <td>
                        <!-- Botón Editar -->
                        <a href="/productos/{{ $producto->id }}/editar" class="btn btn-warning btn-sm">Editar</a>

                        <!-- Formulario para Eliminar -->
                        <form action="/productos/{{ $producto->id }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de eliminar este producto?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="/productos/crear">Crear Producto</a>
</body>
</html>
