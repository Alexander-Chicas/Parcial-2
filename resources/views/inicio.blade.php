<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestor de Microempresa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            
            background: linear-gradient(to right,rgb(86, 134, 181),rgb(66, 78, 90));
        }
        .card {
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }
        .icon-lg {
            font-size: 2.5rem;
        }
    </style>
</head>
<body>
    

<div class="container py-5">
    <h1 class="mb-5 text-center fw-bold">📊 Gestor de Microempresa</h1>
    
    <div class="row row-cols-1 row-cols-md-2 g-4">

        <div class="col">
            <a href="/usuarios" class="text-decoration-none">
                <div class="card text-white bg-primary h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-people icon-lg mb-2"></i>
                        <h5 class="card-title">Usuarios</h5>
                        <p class="card-text">Ver y administrar usuarios del sistema.</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col">
            <a href="/productos" class="text-decoration-none">
                <div class="card text-white bg-success h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-box-seam icon-lg mb-2"></i>
                        <h5 class="card-title">Productos</h5>
                        <p class="card-text">Gestionar productos disponibles.</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col">
            <a href="/ventas" class="text-decoration-none">
                <div class="card text-white bg-warning h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-cash-coin icon-lg mb-2"></i>
                        <h5 class="card-title">Ventas</h5>
                        <p class="card-text">Revisar historial de ventas realizadas.</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col">
            <a href="/alertas" class="text-decoration-none">
                <div class="card text-white bg-danger h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-exclamation-triangle icon-lg mb-2"></i>
                        <h5 class="card-title">Alertas</h5>
                        <p class="card-text">Visualizar alertas del sistema.</p>
                    </div>
                </div>
            </a>
        </div>

    </div>
</div>

</body>
</html>

