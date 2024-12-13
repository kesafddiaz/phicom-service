<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <div class="d-flex flex-column vh-100 justify-content-center align-items-center">
            <div class="h-25">
                <section class="h2 text-dark" id="greet">
                    Halo, {{ $name }}
                </section>
            </div>
            <div class="w-100" id="progress">
                <section class="text-center">Status reparasi laptop Anda saat ini:</section>
                <div class="d-flex justify-content-between text-muted mb-1">
                    <span>MENUNGGU</span>
                    <span>SEDANG DIKERJAKAN</span>
                    <span>SELESAI</span>
                </div>
                @if ($status === 'MENUNGGU')
                <div class="progress" role="progressbar" aria-label="Animated striped example" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 1%"></div>
                </div>
                @elseif ($status === 'SEDANG_DIKERJAKAN')
                <div class="progress" role="progressbar" aria-label="Animated striped example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 50%"></div>
                </div>
                @elseif ($status === 'SELESAI')
                <div class="progress" role="progressbar" aria-label="Animated striped example" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 100%"></div>
                </div>
                @elseif ($status === 'DIAMBIL')
                <section>
                    <p>Perangkat anda sudah diambil. Terima kasih telah menggunakan jasa kami.</p>
                </section>
                @endif
            </div>
        </div>
    </div>
</body>
</html>