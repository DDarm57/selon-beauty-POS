@extends('layout.app')

@section('content')
    <style>
        #scanner-container {
            width: 100%;
            height: 300px;
            position: relative;
            background-color: #f0f0f0;
        }

        #scanner {
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
        }

        #result {
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
        }
    </style>

    <!-- Modal -->
    <div class="modal fade" id="exampleModalScanQr" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Scan Barcode</h5>
                </div>
                <div class="modal-body">
                    <div id="scanner-container" class="mt-2">
                        <video id="scanner" autoplay></video>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="closeCamera" data-dismiss="modal">Kembali</button>
                </div>
            </div>
        </div>
    </div>

    <div class="main-panel">
        <div class="content-wrapper">
            <div class="page-header">
                <h3 class="page-title"> {{ $title }} </h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('products') }}">Produk</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                    </ol>
                </nav>
            </div>
            <div class="row">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <form class="forms-sample mt-4" enctype="multipart/form-data"
                                action="{{ route('products.store') }}" method="POST">
                                @csrf
                                <div class="row mb-3">
                                    <label for="name-input" class="col-sm-2 col-form-label">Nama Produk</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="name" value="{{ old('name') }}"
                                            class="form-control" id="name-input" required autofocus autocomplete="off">
                                        @if ($errors->has('name'))
                                            <small class="text-danger">{{ $errors->first('name') }}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="code-input" class="col-sm-2 col-form-label">Kode</label>
                                    <div class="d-flex justify-content-between col-sm-10">
                                        <input type="text" name="code" value="{{ old('code') }}"
                                            class="form-control" id="code-input" required autofocus autocomplete="off">
                                        @if ($errors->has('code'))
                                            <small class="text-danger">{{ $errors->first('code') }}</small>
                                        @endif
                                        <button class="btn btn-primary w-25" id="scan-button">
                                            <i class="bi bi-upc-scan"> </i> Scan
                                        </button>
                                        {{-- <button type="button" class="btn btn-secondary w-25" id="generateBarcode">
                                            <i class="bi bi-upc-scan"> </i> Generate
                                        </button> --}}
                                    </div>

                                </div>

                                {{-- <div class="row mb-3">
                                    <label for="barcode" class="col-sm-2 col-form-label"></label>
                                    <div class="col-sm-10">
                                        <div id="barcode-container" hidden>
                                            <svg id="barcode"></svg>
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="row mb-3">
                                    <label for="price-input" class="col-sm-2 col-form-label">Harga</label>
                                    <div class="col-sm-10">
                                        <div class="input-group">
                                            <span class="input-group-text" id="rp">Rp.</span>
                                            <input type="text" id="price-input" class="form-control" name="price"
                                                aria-label="rp" aria-describedby="rp" value="{{ old('price') }}"
                                                class="form-control" id="price-input" required autocomplete="off"
                                                oninput="formatCurrency(this)">
                                            @if ($errors->has('price'))
                                                <small class="text-danger">{{ $errors->first('price') }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="agent_price-input" class="col-sm-2 col-form-label">Harga Agen</label>
                                    <div class="col-sm-10">
                                        <div class="input-group">
                                            <span class="input-group-text" id="rp">Rp.</span>
                                            <input type="text" id="agent_price-input" class="form-control"
                                                name="agent_price" aria-label="rp" aria-describedby="rp"
                                                value="{{ old('agent_price') }}" class="form-control"
                                                id="agent_price-input" required autocomplete="off"
                                                oninput="formatCurrency(this)">
                                            @if ($errors->has('agent_price'))
                                                <small class="text-danger">{{ $errors->first('agent_price') }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="discount-input" class="col-sm-2 col-form-label">Diskon</label>
                                    <div class="col-sm-10">
                                        <div class="input-group">
                                            <span class="input-group-text" id="rp">Rp.</span>
                                            <input type="text" id="discount-input" class="form-control"
                                                name="discount" aria-label="rp" aria-describedby="rp"
                                                value="{{ old('discount') }}" class="form-control" id="discount-input"
                                                required autocomplete="off" oninput="formatCurrency(this)">
                                            @if ($errors->has('discount'))
                                                <small class="text-danger">{{ $errors->first('discount') }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="price-input" class="col-sm-2 col-form-label">Kategori</label>
                                    <div class="col-sm-10">
                                        <div class="row row-cols-2 row-cols-md-4 g-2">
                                            @foreach ($category as $item)
                                                <!-- Checkbox items -->
                                                <div class="col">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="cat{{ $item->id }}" name="categories[]"
                                                            value="{{ $item->id }}">
                                                        <label class="form-check-label"
                                                            for="cat{{ $item->id }}">{{ $item->name }}</label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        @if ($errors->has('categories'))
                                            <small class="text-danger">{{ $errors->first('categories') }}</small>
                                        @endif
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="stock" class="col-sm-2 col-form-label">Stock</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="stock" value="{{ old('stock') }}"
                                            class="form-control" id="stock" required autocomplete="off"
                                            oninput="formatCurrency(this)">
                                    </div>
                                    @if ($errors->has('stock'))
                                        <small class="text-danger">{{ $errors->first('stock') }}</small>
                                    @endif
                                </div>

                                <div class="row mb-3">
                                    <label for="image-input" class="col-sm-2 col-form-label">File Upload</label>
                                    <div class="col-sm-10">
                                        <input name="image" class="form-control" type="file" id="image-input">
                                    </div>
                                    @if ($errors->has('image'))
                                        <small class="text-danger">{{ $errors->first('image') }}</small>
                                    @endif
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Simpan</button>

                                    <a href="{{ route('products') }}">
                                        <button type="button" class="btn btn-secondary">Kembali</button>
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- main-panel ends -->
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            let scanning = false;
            const $scanButton = $('#scan-button');
            const $resultDiv = $('#code-input');
            const $scannerVideo = $('#scanner')[0];

            $scanButton.on('click', function(e) {
                e.preventDefault();
                $('#exampleModalScanQr').modal('show');
                if (!scanning) {
                    startScan();
                }
            });

            function startScan() {
                scanning = true;
                navigator.mediaDevices.getUserMedia({
                        video: {
                            facingMode: 'environment'
                        }
                    })
                    .then(function(stream) {
                        $scannerVideo.srcObject = stream;

                        // Tunggu hingga video siap sebelum mulai pemindaian
                        $scannerVideo.onloadedmetadata = function() {
                            console.log("📹 Video siap, mulai scanning...");
                            scanBarcode(stream);
                        };
                    })
                    .catch(function(err) {
                        console.error("❌ Error mengakses kamera:", err);
                        alert("Error mengakses kamera: " + err.message);
                    });
            }

            function scanBarcode(stream) {
                const canvas = document.createElement('canvas');
                const context = canvas.getContext('2d');

                function processFrame() {
                    if (!scanning) return;

                    // Pastikan video memiliki ukuran yang valid sebelum diproses
                    canvas.width = $scannerVideo.videoWidth;
                    canvas.height = $scannerVideo.videoHeight;

                    if (canvas.width === 0 || canvas.height === 0) {
                        console.warn("⚠️ Video belum siap, menunggu...");
                        requestAnimationFrame(processFrame);
                        return;
                    }

                    context.drawImage($scannerVideo, 0, 0, canvas.width, canvas.height);
                    const imageData = context.getImageData(0, 0, canvas.width, canvas.height);

                    // Coba memindai barcode dengan berbagai metode inversi warna
                    const code = jsQR(imageData.data, canvas.width, canvas.height, {
                        inversionAttempts: "attemptBoth"
                    });

                    if (code) {
                        console.log("✅ Barcode terdeteksi!");
                        console.log("🔢 Data Barcode:", code.data);

                        if (code.data) {
                            // Pastikan elemen input ada sebelum memperbarui nilainya
                            if ($resultDiv.length > 0) {
                                $resultDiv.val(code.data); // Jika elemen input
                            } else {
                                console.error("⚠️ Elemen #code-input tidak ditemukan!");
                            }
                            stopScan(stream);
                        } else {
                            console.warn("⚠️ Barcode terdeteksi, tetapi tidak ada data!");
                        }
                    } else {
                        console.log("⏳ Tidak ada barcode yang terdeteksi, lanjutkan...");
                        requestAnimationFrame(processFrame);
                    }
                }

                processFrame();
            }

            function stopScan(stream) {
                scanning = false;
                console.log("🛑 Scanning dihentikan.");
                let tracks = stream.getTracks();
                tracks.forEach(track => track.stop());
            }

            $('#closeCamera').on('click', function() {
                scanning = false;
                let stream = $scannerVideo.srcObject;
                let tracks = stream.getTracks();
                tracks.forEach(track => track.stop());

                $("#exampleModalScanQr").modal('hide');
            });

            $("#generateBarcode").click(function() {
                console.log("test");
                var inputVal = $("#code-input").val();

                if (inputVal !== "") {
                    $("#barcode-container").prop("hidden", false);
                    JsBarcode("#barcode", inputVal, {
                        format: "CODE128",
                        displayValue: true,
                        fontSize: 16
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Masukan kode teks terlebih dahulu",
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            });
        });
    </script>
@endsection
