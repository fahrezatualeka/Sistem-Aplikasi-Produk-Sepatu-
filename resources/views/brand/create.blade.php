<style>
    .modal-body {
        max-height: 500px; /* sesuaikan tinggi maksimal modal */
        overflow-y: auto;  /* aktifk scroll jika konten melebihi batas */
    }
</style>

<div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Merek</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            
            <!-- form untuk menyimpan data merek -->
            <form action="{{ route('brand.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div id="brand-container">
                        <!-- item pertama tanpa tombol hapus -->
                        <div class="brand-item row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Merek</label>
                                <input type="text" class="form-control" name="name[]" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Gambar</label>
                                <input type="file" class="form-control" name="image[]" accept="image/*">
                            </div>
                        </div>
                    </div>
                    
                    <!-- tombol untuk menambah merek lebihdari 1 -->
                    <button type="button" class="btn btn-primary mt-3" id="btnTambahBrand">
                        <i class="fa-solid fa-plus"></i> Tambah
                    </button>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                        <i class="fa-solid fa-xmark"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const brandContainer = document.getElementById("brand-container");
        const btnTambahBrand = document.getElementById("btnTambahBrand");
    
        // fungsi untuk menambah input merek baru
        function addBrandRow() {
            let brandItem = document.createElement("div");
            brandItem.classList.add("brand-item", "row", "align-items-center", "mb-2");
            brandItem.innerHTML = `
                <div class="col-md-6">
                    <label class="form-label">Nama Merek</label>
                    <input type="text" class="form-control" name="name[]" required>
                </div>
                <div class="col-md-5">
                    <label class="form-label">Gambar</label>
                    <input type="file" class="form-control" name="image[]" accept="image/*">
                </div>
                <div class="col-md-1 d-flex align-items-center justify-content-end mt-4">
                    <button type="button" class="btn btn-danger btn-remove-brand">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </div>
            `;
            
            brandContainer.appendChild(brandItem);
    
            // event listener untuk menghapus merek yang ditambahkan
            brandItem.querySelector(".btn-remove-brand").addEventListener("click", function () {
                brandItem.remove();
                toggleRemoveButton();
            });
    
            toggleRemoveButton();
        }
    
        // fungsi untuk mengontrol visibilitass tombol hapus
        function toggleRemoveButton() {
            let brandItems = brandContainer.querySelectorAll(".brand-item");
            let removeButtons = brandContainer.querySelectorAll(".btn-remove-brand");
    
            // Sembunyikan tombol hapus jika hanya ada satu input merek
            if (brandItems.length === 1) {
                removeButtons.forEach(button => button.style.display = "none");
            } else {
                removeButtons.forEach(button => button.style.display = "inline-block");
            }
        }
    
        // event listener untuk menambah merek baru saat tombol diklik
        btnTambahBrand.addEventListener("click", addBrandRow);
        
        // pastikan tombol hapus tidak muncul jika hanya ada satu input merek
        toggleRemoveButton();
    });
</script>