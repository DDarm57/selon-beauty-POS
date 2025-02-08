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

    <!-- Modal search product -->
    <div class="modal fade" id="exampleModalSearchProduct" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cari Produk</h5>
                </div>
                <div class="modal-body">
                    <div class="template-demo table-responsive">
                        <table class="table table-striped datatable">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>harga</th>
                                    <th>Stok</th>
                                    <th>Kategori</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($products->isEmpty())
                                    <tr>
                                        <td colspan="6" class="text-center">Data Kosong</td>
                                    </tr>
                                @else
                                    @foreach ($products as $item)
                                        <tr>
                                            <td>{{ $item->code }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>Rp.{{ number_format($item->price, 0, ',', '.') }}</td>
                                            <td>{{ $item->stock }}</td>

                                            <td class="w-25">
                                                @foreach ($item->categories as $category)
                                                    <span class="badge bg-secondary">{{ $category->name }}</span>
                                                @endforeach
                                            </td>

                                            <td>
                                                <div class="flex flex-column flex-sm-row gap-2">
                                                    <a href="" data-code="{{ $item->code }}"
                                                        class="addProductToCart">
                                                        <button type="button" class="btn btn-primary btn-icon-text btn-md">
                                                            <i class="bi bi-plus"></i>
                                                        </button>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="closeModalProduct"
                        data-dismiss="modal">Kembali</button>
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
                        <li class="breadcrumb-item"><a href="{{ route('categories') }}">Produk</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <form action="{{ route('transaction.store') }}" method="POST" id="formTransaction">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">
                                <div class="d-flex justify-content-between">
                                    Transaksi
                                    <input type="hidden" name="transaction_code" value="{{ $transaction_code }}">
                                    <p>Kode Transaksi : <span class="bg-success text-light">{{ $transaction_code }}</span>
                                    </p>
                                </div>
                            </h4>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="input-group">
                                        <input type="text" name="code" id="code" class="form-control"
                                            placeholder="Barcode Scan">
                                        <div class="input-group-append">
                                            <button id="scan-button" class="btn btn-secondary"><i class="bi bi-upc-scan">
                                                </i> Scan</button>
                                            <button id="modal-search-product" class="btn btn-primary">Cari</button>
                                        </div>
                                    </div>
                                    <small id="statusResults"></small>
                                    <div id="product-container" class="mt-2">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <img src="{{ asset('/img/products/default.png') }}" alt=""
                                                    id="image" style="width: 100px; height: 100px;">
                                            </div>
                                            <div class="col-sm-9">
                                                <table>
                                                    <tr>
                                                        <th>Nama Produk</th>
                                                        <td class="px-2">:</td>
                                                        <td id="name"></td>
                                                    </tr>
                                                    {{-- <tr>
                                                        <th>Kategori</th>
                                                        <td class="px-2">:</td>
                                                        <td id="category"></td>
                                                    </tr> --}}
                                                    <tr>
                                                        <th>Stok</th>
                                                        <td class="px-2">:</td>
                                                        <td id="stock"></td>
                                                    <tr>
                                                        <th>Harga</th>
                                                        <td class="px-2">:</td>
                                                        <td id="price"></td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="mt-2">
                                                <div class="form-group">
                                                    <input type="number" name="qty" id="qty"
                                                        class="form-control" placeholder="Jumlah Barang" disabled>
                                                    <small id="msgCalculateProduct"></small>
                                                </div>
                                                <div class="mt-2 d-flex justify-content-start">
                                                    <h4><strong>Total</strong></h4>
                                                    <h4 class="px-2">:</h4>
                                                    <h4 id="total" class="ml-2">Rp. 0</h4>
                                                </div>
                                                <div class="mt-2">
                                                    <button type="button" class="btn btn-primary" id="addToCart"
                                                        hidden>Add</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6" id="cart-container" hidden>
                                    <table class="table table-bordered table-responsive">
                                        <thead>
                                            <tr>
                                                <th hidden></th>
                                                <th>No</th>
                                                <th>Produk</th>
                                                <th>Jumlah</th>
                                                <th>Total Harga</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="cart-table">
                                        </tbody>
                                    </table>
                                    <div class="d-flex justify-content-end">
                                        <h4><strong>Total</strong></h4>
                                        <h4 class="px-2">:</h4>
                                        <h4 id="totalPrice">Rp. 0</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-2" id="payment-container" hidden>
                                <hr>
                                <!-- <div class="form-group">
                                                            <label for="customer_name"><strong>Nama Customer</strong></label>
                                                            <input type="text" name="customer_name" id="customer_name" class="form-control" placeholder="Nama Customer" required>
                                                        </div> -->
                                <div class="d-flex justify-content-start mt-2">
                                    <h4><strong>Total Transaksi</strong></h4>
                                    <h4 class="px-2">:</h4>
                                    <h4 id="totalPriceTransaction" class="ml-2">Rp. 0</h4>
                                    <input type="hidden" name="total_price" id="totalPriceTransactionVal"
                                        value="0">
                                </div>
                                <div class="form-group">
                                    <label for="pay"><strong>Pembayaran</strong></label>
                                    <input type="text" name="pay" id="pay" class="form-control"
                                        placeholder="Bayar" oninput="formatCurrency(this)" required>
                                </div>
                                <div class="d-flex justify-content-start mt-2">
                                    <button type="button" class="btn btn-sm btn-success">Bayar Uang Pas</button>
                                    <div class="px-2"><button type="button" class="btn btn-sm btn-secondary">Rp.
                                            20.000</button></div>
                                </div>
                                <div class="d-flex justify-content-start mt-2">
                                    <h4><strong>Kembalian</strong></h4>
                                    <h4 class="px-2">:</h4>
                                    <h4 id="change" class="ml-2">Rp. 0</h4>
                                    <input type="hidden" name="change" id="changeVal">
                                </div>
                                <div class="d-flex-justify-content-between mt-2">
                                    <button type="submit" class="btn btn-primary" id="btnPayment"
                                        disabled>Bayar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- main-panel ends -->

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $("#code").focus();
            $('#modal-search-product').on('click', function() {
                $('#exampleModalSearchProduct').modal('show');
            });

            $("#closeModalProduct").on('click', function() {
                $('#exampleModalSearchProduct').modal('hide');
            });

            $(document).on('click', '.addProductToCart', function(e) {
                e.preventDefault();
                let code = $(this).data('code');
                getProduct(code);
                //  console.log(code);
                $('#exampleModalSearchProduct').modal('hide');
            });

            function getProduct(code) {
                $.ajax({
                    url: "{{ route('getProduct') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        code: code
                    },
                    success: function(response) {
                        if (response.status == 'success') {
                            $('#addToCart').prop('hidden', false);
                            $("#addToCart").val(response.data.id);
                            $('#name').text(response.data.name);
                            $.each(response.categories, function(index, category) {
                                console.log(category.name);
                                $('#category').append(category.name + ' , ');
                            });
                            $('#stock').text(response.data.stock);
                            $('#price').text('Rp. ' + (parseFloat(response.data.price) || 0)
                                .toLocaleString('id-ID'));

                            if (response.data.image == "") {
                                response.data.image = 'default.png';
                            }
                            $('#image').attr('src',
                                `{{ asset('img/products/') }}/${response.data.image}`);

                            $('#statusResults').text('Produk ditemukan').addClass('text-success')
                                .removeClass('text-danger');

                            // Hitung total harga
                            $('#qty').prop('disabled', false);
                            $('#qty').focus();
                            $('#addToCart').prop('disabled', true);

                            $("#qty").on('input', function() {
                                let qty = $(this).val();
                                let stock = response.data.stock; // Stok yang tersedia

                                // Mengecek apakah jumlah yang dimasukkan tidak melebihi stok yang ada
                                if (qty == '') {
                                    $('#msgCalculateProduct').text('Jumlah tidak boleh kosong')
                                        .addClass('text-danger').removeClass('text-success');
                                    $('#addToCart').prop('disabled', true);
                                    return;
                                }

                                if (parseInt(qty) <= stock) {
                                    $('#msgCalculateProduct').text('Stok mencukupi').addClass(
                                        'text-success').removeClass('text-danger');
                                    $('#addToCart').prop('disabled', false);
                                    if (parseInt(qty) <= 0) {
                                        $('#msgCalculateProduct').text('Jumlah tidak boleh 0')
                                            .addClass('text-danger').removeClass(
                                                'text-success');
                                        $('#addToCart').prop('disabled', true);
                                    }
                                } else {
                                    $('#msgCalculateProduct').text('Stok tidak mencukupi')
                                        .addClass('text-danger').removeClass('text-success');
                                    $('#addToCart').prop('disabled', true);
                                }

                                // Menghitung total harga berdasarkan jumlah yang dimasukkan
                                let price = response.data.price;
                                let total = parseInt(qty) * price;

                                // Memformat total harga dengan pemisah ribuan
                                $('#total').text('Rp. ' + total.toLocaleString('id-ID'));
                            });

                            let counter = $('#cart-table tr').length + 1;
                            // Event untuk menambahkan ke keranjang
                            $(document).on('click', '#addToCart', function() {
                                $("#cart-container").prop('hidden', false);
                                $("#payment-container").prop('hidden', false);

                                let qty = $('#qty').val();
                                let stock = response.data.stock;
                                let price = response.data.price;
                                let total = parseInt(qty) * price;

                                // Mengecek apakah jumlah yang dimasukkan valid
                                if (parseInt(qty) <= parseInt(stock)) {
                                    // Cek apakah produk sudah ada di keranjang
                                    let existingProductRow = $('#cart-table tr').filter(
                                        function() {
                                            return parseInt($(this).data('id')) == parseInt(
                                                response.data.id);
                                        });

                                    console.log('Cek apakah produk sudah ada di tabel:',
                                        existingProductRow.length);

                                    if (existingProductRow.length == 0) {
                                        $('#cart-table').append(`
                                        <tr data-id="${response.data.id}">
                                            <td hidden><input type="checkbox" checked name="product_id[]" class="productId" value="${response.data.id}"></td>
                                            <td class="cart-number">${counter}</td>
                                            <td class="product-name" data-stock="${response.data.stock}">
                                            ${response.data.name}<br>Rp. ${(parseFloat(response.data.price) || 0).toLocaleString('id-ID')} <br>
                                            stok tersisa : ${response.data.stock}
                                            <input type="hidden" name="price_product[]" value="${response.data.price}">
                                            </td>
                                            <td class="product-qty">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <button type="button" class="btn btn-danger min-qty">-</button>
                                                    </div>
                                                    <input type="number" readonly name="qty[]" value="${qty}" class="form-control" value="1" style="width: 50px;">
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-success plus-qty">+</button>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="product-total">
                                            <input type="hidden" name="total_product_price[]" value="${total}">
                                            <p class="product-total-text"> Rp. ${total.toLocaleString('id-ID')}</p>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-danger removeRow">Hapus</button>
                                            </td>
                                        </tr>
                                    `);

                                        counter++; // Menambah nomor urut

                                        $("#code").val('');
                                        clearProduct();
                                    } else {
                                        // Jika produk sudah ada, tambahkan jumlahnya
                                        // let currentqty = parseInt(existingProductRow.find('.product-qty').text() || '0'); // Pastikan tidak NaN
                                        // let newqty = currentqty + parseInt(qty);
                                        // existingProductRow.find('.product-qty').text(newqty);
                                        // let updatedTotal = newqty * price;
                                        // existingProductRow.find('.product-total').text('Rp. ' + updatedTotal.toLocaleString('id-ID'));
                                        // console.log('Jumlah produk diperbarui, total harga:', updatedTotal);
                                        // Jika produk belum ada, tambahkan baris baru
                                        // alert('Produk sudah ada di keranjang!');
                                    }
                                    updateCartNumbers();
                                    // Debugging untuk memastikan baris produk ditambahkan ke tabel
                                    // console.log($('#cart-table').html());
                                } else {
                                    // alert('Stok tidak mencukupi!');
                                    // return;
                                }

                                calculateTotalPrice();
                            });

                            $(document).on('click', '.removeRow', function() {
                                // Mengambil baris produk tempat tombol hapus diklik
                                console.log('hapus baris produk'); // Debugging
                                let row = $(this).closest('tr');

                                // Mengambil ID produk dari value input checkbox
                                let productId = row.find('.productId').val();
                                console.log('ID produk yang akan dihapus:',
                                    productId); // Debugging

                                // Menghapus baris produk dari tabel
                                row.remove();

                                updateCartNumbers();

                                // Hitung ulang total harga setelah produk dihapus
                                calculateTotalPrice();
                            });

                        } else {
                            $('#statusResults').text('Produk tidak ditemukan').addClass('text-danger')
                                .removeClass('text-success');
                            clearProduct();
                        }
                    },

                    error: function(xhr, status, error) {
                        console.error("Error: ", error);
                        $resultDiv.text('Error: ' + error);
                    }
                });
            }

            $('#cart-table').on('click', '.plus-qty', function() {
                let row = $(this).closest('tr'); // Ambil baris tabel tempat tombol ditekan
                let stock = parseInt(row.find('.product-name').data('stock'));
                let qtyInput = row.find('input[name="qty[]"]'); // Ambil input jumlah
                let qty = parseInt(qtyInput.val()) || 1;
                let price = parseFloat(row.find('input[name="price_product[]"]').val()) || 0;

                // Tambah jumlah produk
                if (qty >= stock) {
                    Swal.fire({
                        icon: "error",
                        title: "Stok tidak mencukupi",
                        showConfirmButton: false,
                        timer: 1500
                    });
                    return;
                }
                qty += 1;
                qtyInput.val(qty);

                // Perbarui total harga
                updateRowTotal(row, qty, price);
                clearPaymentForm();
            });

            // Event untuk tombol "-" (mengurangi jumlah produk)
            $('#cart-table').on('click', '.min-qty', function() {
                let row = $(this).closest('tr'); // Ambil baris tabel tempat tombol ditekan
                let qtyInput = row.find('input[name="qty[]"]'); // Ambil input jumlah
                let qty = parseInt(qtyInput.val()) || 1;
                let price = parseFloat(row.find('input[name="price_product[]"]').val()) || 0;

                // Kurangi jumlah produk (minimal 1)
                if (qty > 1) {
                    qty -= 1;
                    qtyInput.val(qty);
                    updateRowTotal(row, qty, price);
                    clearPaymentForm();
                }
            });

            // Fungsi untuk memperbarui total harga dalam satu baris tabel
            function updateRowTotal(row, qty, price) {
                let newTotal = qty * price;

                // Perbarui nilai hidden input total harga
                row.find('input[name="total_product_price[]"]').val(newTotal);

                // Tampilkan total harga yang diperbarui
                row.find('.product-total-text').text(`Rp. ${newTotal.toLocaleString('id-ID')}`);

                // Hitung ulang total harga di keranjang
                calculateTotalPrice();
            }

            function calculateTotalPrice() {
                let total = 0;

                // Ambil setiap baris di tabel keranjang
                $('#cart-table tr').each(function() {
                    // Ambil harga total dari setiap baris, yang berada di dalam kolom dengan kelas '.product-total'
                    let rowTotal = $(this).find('.product-total .product-total-text').text();

                    // Menghapus teks 'Rp. ' dan mengubahnya menjadi angka
                    rowTotal = rowTotal.replace('Rp. ', '').replace('.', '');
                    rowTotal = parseInt(rowTotal);

                    // Jumlahkan total harga
                    if (!isNaN(rowTotal)) {
                        total += rowTotal;
                    }
                });

                console.log('<strong>Total harga </strong> : ' + total); // Debugging

                // Tampilkan total harga di elemen #totalPrice
                $('#totalPrice').text('Rp. ' + total.toLocaleString('id-ID'));
                $('#totalPriceTransaction').text('Rp. ' + total.toLocaleString('id-ID'));
                $('#totalPriceTransactionVal').val(total);
            }


            function updateCartNumbers() {
                let itemCount = 0;
                $('#cart-table tr').each(function(index) {
                    $(this).find('.cart-number').text(index + 1);
                    itemCount++;
                });

                if (itemCount > 0) {
                    $('#cart-container').prop('hidden', false);
                    $('#payment-container').prop('hidden', false);
                } else {
                    $('#cart-container').prop('hidden', true);
                    $('#payment-container').prop('hidden', true);
                }

                clearPaymentForm();
            }

            function clearProduct() {
                $("#addToCart").prop('hidden', true);
                $('#name').text('');
                $('#category').text('');
                $('#stock').text('');
                $('#price').text('');
                $('#image').attr('src', '{{ asset('/img/products/default.png') }}');
                $('#qty').prop('disabled', true).val('');
                $('#total').text('Rp. ' + 0);
            }

            function clearPaymentForm() {
                $('#pay').val('');
                $('#change').text('Rp. 0');
                $('#changeVal').val('');
                $("#btnPayment").prop('disabled', true);
            }

            // Event Bayar Transaksi
            $(document).on('input', '#pay', function() {
                let pay = $(this).val().replace('Rp. ', '').replace('.', '').replace('.', '').replace('.',
                    '');
                let totalPrice = $('#totalPrice').text();
                let totalPriceNumber = totalPrice.replace('Rp. ', '').replace('.', '').replace('.', '')
                    .replace('.', '');
                let change = pay - totalPriceNumber;
                if (change < 0 || pay == '') {
                    $("#btnPayment").prop('disabled', true);
                } else {
                    $("#btnPayment").prop('disabled', false);
                }
                $('#change').text('Rp. ' + change.toLocaleString('id-ID'));
                $('#changeVal').val(change);
            })

            $('#formTransaction').submit(function(e) {
                e.preventDefault();

                // let customerName = $('#customer_name').val().trim(); // Ambil dan hapus spasi kosong

                // if (customerName === '') {
                //     Swal.fire({
                //         icon: "error",
                //         title: "Nama customer tidak boleh kosong",
                //         showConfirmButton: false,
                //         timer: 1500
                //     });
                //     return; // Hentikan eksekusi jika kosong
                // }

                let totalPrice = $('#totalPriceTransactionVal').val();

                Swal.fire({
                    title: "Proses Transaksi",
                    text: "Apakah anda yakin ingin memproses transaksi sebesar Rp. " + totalPrice +
                        " ?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, simpan"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#formTransaction')[0]
                            .submit(); // Gunakan submit bawaan untuk mencegah looping
                    }
                });
            });

            let scanning = false;
            const $scanButton = $('#scan-button');
            const $resultDiv = $('#result');
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

                        // Menunggu video dimuat sebelum mulai pemindaian
                        $scannerVideo.onloadedmetadata = function() {
                            console.log("Video metadata loaded. Starting scan...");
                            scanBarcode(stream);
                        };
                    })
                    .catch(function(err) {
                        console.error("Error accessing camera: ", err);
                        $resultDiv.text("Error accessing camera: " + err.message);
                    });
            }

            function scanBarcode(stream) {
                const canvas = document.createElement('canvas');
                const context = canvas.getContext('2d');

                function processFrame() {
                    if (!scanning) return;

                    // Pastikan ukuran video sudah tersedia sebelum diproses
                    canvas.width = $scannerVideo.videoWidth;
                    canvas.height = $scannerVideo.videoHeight;

                    // Cek apakah canvas memiliki ukuran yang valid
                    if (canvas.width === 0 || canvas.height === 0) {
                        console.log("Video width or height is zero. Skipping frame...");
                        requestAnimationFrame(processFrame);
                        return;
                    }

                    context.drawImage($scannerVideo, 0, 0, canvas.width, canvas.height);
                    const imageData = context.getImageData(0, 0, canvas.width, canvas.height);

                    // Menggunakan jsQR untuk memindai gambar
                    const code = jsQR(imageData.data, canvas.width, canvas.height, {
                        inversionAttempts: "dontInvert"
                    });

                    if (code) {
                        $resultDiv.text('Hasil Scan: ' + code.data);
                        console.log("Barcode detected: " + code.data);
                        stopScan(stream);
                    } else {
                        // Jika barcode tidak terdeteksi, teruskan proses frame berikutnya
                        requestAnimationFrame(processFrame);
                    }
                }

                processFrame();
            }

            function stopScan(stream) {
                scanning = false;
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

            // Input manual barcode
            $('#code').on('input', function(e) {
                let code = $(this).val();
                console.log('Manual barcode: ' + code);
                getProduct(code);
            });

        });
    </script>
@endsection
