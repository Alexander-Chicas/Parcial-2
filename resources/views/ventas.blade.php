<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ventas</title>
    <style>
        body { font-family: Arial; background: #f9f9f9; margin: 0; padding: 20px; }
        table { width: 100%; border-collapse: collapse; background: #fff; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background-color: #dcdcdc; }
        h1 { margin-bottom: 20px; }
    </style>
</head>
<body>
<a href="/" class="btn btn-secondary" style="margin-bottom: 20px;">Regresar</a>

    <h1>Lista de Ventas</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>ID Usuario</th>
                <th>Total</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ventas as $venta)
                <tr>
                    <td>{{ $venta->id }}</td>
                    <td>{{ $venta->user_id }}</td>
                    <td>${{ $venta->total_amount }}</td>
                    <td>{{ $venta->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
