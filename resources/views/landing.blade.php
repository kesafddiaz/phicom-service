<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poetsen+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <div class="d-flex flex-column vh-100 justify-content-center align-items-center">
            <div class="h-25">
                <section class="h1 poetsen-one-regular fw-bold text-dark" id="title">
                    PHICOM LAPTOP SERVICE
                </section>
                <section class="text-center">Tracking reparasi laptop, komputer, printer, proyektor</section>
            </div>
            <label for="order-search">Masukkan nomor order:</label>
            <form class="input-group d-flex justify-content-center align-items-center" action="{{ route('progress') }}" method="POST">
                @csrf
                <input type="text" class="form-control form-control-lg" id="order-search" name="services-id">
                <button type="submit" class="btn btn-primary btn-lg" >Search</button>
            </form>
        </div>
    </div>
</body>
</html>
