// format currency
function formatCurrency(input) {
   // Ambil nilai input, hapus semua karakter selain angka
   let value = input.value.replace(/\D/g, '');
   
   // Ubah ke format Rupiah (Rp)
   let formatted = new Intl.NumberFormat('id-ID', {
      style: 'currency',
      currency: 'IDR',
      minimumFractionDigits: 0
   }).format(value);

   // Hapus simbol 'Rp' bawaan dari formatCurrency agar tidak double
   input.value = formatted.replace("Rp", "").trim();
}

// Modal Edit Stock
function openEditStockModal(stockId, stockValue) {
   document.getElementById("edit-stock-id").value = stockId;
   document.getElementById("edit-stock-input").value = stockValue;
   // Set action langsung di dalam form tanpa ubah via JS
   document.getElementById("edit-stock-form").setAttribute("action", "/products/update-stock/" + stockId);

   var editStockModal = new bootstrap.Modal(document.getElementById("edit-stock-modal"));
   editStockModal.show();
}

// Modal Delete Stock
function openDeleteStockModal(stockId) {
   console.log(stockId);
   // Set action langsung di dalam form tanpa ubah via JS
   document.getElementById("delete-stock-form").setAttribute("action", "/products/delete-stock/" + stockId);

   var deleteStockModal = new bootstrap.Modal(document.getElementById("delete-stock-modal"));
   deleteStockModal.show();
}

// Modal Delete Category
function openDeleteCategoryModal(categoryId, categoryName) {
   // Set action langsung di dalam form tanpa ubah via JS
   document.getElementById("name").innerText = categoryName;
   document.getElementById("delete-form").setAttribute("action", "/categories/destroy/" + categoryId);

   var deleteStockModal = new bootstrap.Modal(document.getElementById("delete-modal"));
   deleteStockModal.show();
}

// phone number input handler
document.addEventListener("DOMContentLoaded", function () {
   const phoneInput = document.getElementById("phone-input");

   // Mencegah input selain angka
   phoneInput.addEventListener("input", function () {
         this.value = this.value.replace(/[^0-9]/g, ""); // Hanya angka yang diperbolehkan
   });

});

// toastr
document.addEventListener("DOMContentLoaded", function () {
    // Fungsi untuk menampilkan toastr berdasarkan tipe pesan
    function showToastr(type, message, title) {
        if (!message) return; // Cegah toastr kosong
        
        toastr[type](message, title, {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-top-right",
            timeOut: 2000, // Durasi notifikasi dalam ms
            extendedTimeOut: 1000,
            showMethod: "fadeIn",
            hideMethod: "fadeOut",
        });

        // Simpan state agar toastr tidak muncul lagi setelah reload
        sessionStorage.setItem("toastr" + type, "shown");
    }

    // Cek apakah toastr success atau error sudah pernah ditampilkan
    if (!sessionStorage.getItem("toastrSuccess") && window.toastrSuccess) {
        showToastr("success", window.toastrSuccess, "Success");
    }

    if (!sessionStorage.getItem("toastrError") && window.toastrError) {
        showToastr("error", window.toastrError, "Error");
    }
});






// public/js/script.js
// $(document).ready(function() {
//     $('#search').on('keyup', function() {
//         let searchQuery = $(this).val();

//         if (searchQuery.length >= 3) { // Menunggu hingga minimal 3 karakter
//             $.ajax({
//                 url: searchUrl,
//                 method: 'GET',
//                 data: { search: searchQuery },
//                 success: function(data) {
//                     $('#product-results').empty();

//                     console.log(data);
                    
//                     if (data.length > 0) {
//                         data.forEach(function(product) {
//                             let productCard = `
//                                 <div class="col-md-4">
//                                     <div class="card mb-4">
//                                         <img src="${product.image_url}" class="card-img-top" alt="${product.name}">
//                                         <div class="card-body">
//                                             <h5 class="card-title">${product.name}</h5>
//                                             <p class="card-text">Kode: ${product.code}</p>
//                                             <p class="card-text">Kategori: ${product.category.name}</p>
//                                             <p class="card-text">Price: $${product.price}</p>
//                                         </div>
//                                     </div>
//                                 </div>
//                             `;
//                             $('#product-results').append(productCard);
//                         });
//                     } else {
//                         $('#product-results').append('<p>No products found</p>');
//                     }
//                 }
//             });
//         }
//     });
// });


