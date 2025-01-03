<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laptop Repair Status</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #f4f6f9;
        }
        .status-label {
            font-size: 0.9rem;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="d-flex flex-column vh-100 justify-content-center align-items-center">
            <div class="text-center mb-4">
                <h1 class="h2 text-dark" id="greet">
                    Halo, {{ $services->name }}
                </h1>
            </div>
            
            <div class="w-100 px-3" id="progress">
                <section class="text-center mb-3">
                    <h2 class="h5">Status Reparasi Laptop Anda</h2>
                </section>

                @switch($services->status)
                    @case('MENUNGGU')
                      <div class="d-flex justify-content-between status-label mb-2">
                        <span>Menunggu</span>
                        <span>Sedang Dikerjakan</span>
                        <span>Selesai</span>
                      </div>
                        <div class="progress" style="height: 30px;">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" style="width: 1%">
                                
                            </div>
                        </div>
                        @break

                    @case('SEDANG_DIKERJAKAN')
                     <div class="d-flex justify-content-between status-label mb-2">
                        <span>Menunggu</span>
                        <span>Sedang Dikerjakan</span>
                        <span>Selesai</span>
                      </div>
                        <div class="progress" style="height: 30px;">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-info" style="width: 50%">
                              
                            </div>
                        </div>
                        @break

                    @case('SELESAI')
                    <div class="d-flex justify-content-between status-label mb-2">
                        <span>Menunggu</span>
                        <span>Sedang Dikerjakan</span>
                        <span>Selesai</span>
                    </div>
                        <div class="progress" style="height: 30px;">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" style="width: 100%">
                             
                            </div>
                        </div>
                        @break

                    @case('DIAMBIL')
                        <div class="alert alert-success text-center" role="alert">
                            <h4 class="alert-heading">Servis Telah Selesai</h4>
                            <p>Perangkat Anda sudah diambil. Terima kasih telah menggunakan jasa kami.</p>
                        </div>
                        @break
                @endswitch
            </div>

            <div>
                <br>
                <br>
                <a href="{{ route('landing') }}" class="btn btn-primary mt-3 bg-secondary">Kembali</a>
            </div>
        </div>
    </div>
</body>
</html>