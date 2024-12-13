
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poetsen+One&family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>PHICOM Laptop Service Tracking</title>
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Roboto', sans-serif;
        }
        .poetsen-one-regular {
            font-family: 'Poetsen One', sans-serif;
        }
        .tracking-container {
            max-width: 600px;
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            padding: 30px;
            transition: transform 0.3s ease;
        }
        .tracking-container:hover {
            transform: scale(1.02);
        }
        #title {
            color: #2c3e50;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
        }
        .subtitle {
            color: #7f8c8d;
            margin-bottom: 20px;
        }
        .form-control {
            border-radius: 10px 0 0 10px;
        }
        .btn-search {
            border-radius: 0 10px 10px 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .input-group {
            max-width: 500px;
        }
        @media (max-width: 768px) {
            .tracking-container {
                width: 95%;
                padding: 20px;
            }
            #title {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100">
    <div class="tracking-container text-center">
        <div class="mb-4">
            <h1 class="poetsen-one-regular fw-bold" id="title">
                PHICOM LAPTOP SERVICE
            </h1>
            <p class="subtitle">Tracking reparasi laptop, komputer, printer, proyektor</p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                {{ $errors->first() }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('progress') }}" method="POST" class="d-flex justify-content-center">
            @csrf
            <div class="input-group">
                <input 
                    type="text" 
                    class="form-control form-control-lg @error('services-id') is-invalid @enderror" 
                    id="order-search" 
                    name="services-id" 
                    placeholder="Masukkan nomor order service" 
                    required
                >
                <button type="submit" class="btn btn-primary btn-lg btn-search">
                    <i class="bi bi-search me-2"></i> Cari
                </button>
            </div>
        </form>

        <div class="mt-4">
            <small class="text-muted">
                <i class="bi bi-info-circle me-1"></i>
                Gunakan nomor service yang tertera di nota/bukti service
            </small>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
