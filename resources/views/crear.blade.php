<!-- resources/views/crear.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Producto</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px; }
        .container { max-width: 800px; margin: 0 auto; background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); }
        h1 { text-align: center; margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; }
        label { font-size: 1.2em; display: block; margin-bottom: 8px; }
        input, textarea { width: 100%; padding: 10px; font-size: 1em; border: 1px solid #ccc; border-radius: 4px; }
        button { background-color: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 4px; font-size: 1em; cursor: pointer; }
        button:hover { background-color: #45a049; }
    </style>
</head>
<body>

<a href="/productos" class="btn btn-secondary" style="margin-bottom: 20px;">Regresar</a>

    <div class="container">
        <h1>Crear Producto</h1>
        
        <!-- Mensaje de éxito -->
        @if(session('success'))
            <div style="background-color: #d4edda; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
                {{ session('success') }}
            </div>
        @endif
        
        <!-- Formulario para crear un producto -->
        <form action="/productos" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required>
                @error('name')
                    <div style="color: red;">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="price">Precio</label>
                <input type="number" name="price" id="price" value="{{ old('price') }}" required>
                @error('price')
                    <div style="color: red;">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="stock">Stock</label>
                <input type="number" name="stock" id="stock" value="{{ old('stock') }}" required>
                @error('stock')
                    <div style="color: red;">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="description">Descripción</label>
                <textarea name="description" id="description" rows="4">{{ old('description') }}</textarea>
                @error('description')
                    <div style="color: red;">{{ $message }}</div>
                @enderror
            </div>
            
            <button type="submit">Crear Producto</button>
        </form>
    </div>
</body>
</html>
