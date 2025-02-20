<style>
    .modal-body {
    max-height: 500px; /* Sesuaikan tinggi maksimal */
    overflow-y: auto;  /* Aktifkan scroll jika melebihi batas */
}
</style>

<div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('category.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div id="category-container">
                        <div class="category-item row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Kategori</label>
                                <input type="text" class="form-control" name="name[]" required>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="button" class="btn btn-danger btn-remove-category" style="display: none;">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary mt-3" id="btnTambahCategory">
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
    const categoryContainer = document.getElementById("category-container"); // Elemen container untuk daftar kategori
    const btnTambahCategory = document.getElementById("btnTambahCategory"); // Tombol untuk menambah kategori

    function addCategoryRow() {
        // membuat elemen div baru untuk kategori tambahan
        let categoryItem = document.createElement("div");
        categoryItem.classList.add("category-item", "row"); // Menambahkan class untuk styling
        
        // menambahkan HTML input baru untuk kategori
        categoryItem.innerHTML = `
            <div class="col-md-6">
                <label class="form-label">Nama Kategori</label>
                <input type="text" class="form-control" name="name[]" required>
            </div>
            <div class="col-md-1 d-flex align-items-center justify-content-end mt-4">
                <button type="button" class="btn btn-danger btn-remove-category">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </div>
        `;

        // menambahkan elemen kategori baru ke dalam container
        categoryContainer.appendChild(categoryItem);

        // menambahkan event listener ke tombol hapus yang baru dibuat
        categoryItem.querySelector(".btn-remove-category").addEventListener("click", function () {
            categoryItem.remove(); // menghapus elemen kategori saat tombol diklik
            toggleRemoveButtons(); // memeriksa apakah tombol hapus perlu ditampilkan
        });

        toggleRemoveButtons(); // memeriksa status tombol hapus setelah menambah kategori
    }

    function toggleRemoveButtons() {
        let categoryItems = categoryContainer.querySelectorAll(".category-item"); // mengambil semua item kategori
        let removeButtons = categoryContainer.querySelectorAll(".btn-remove-category"); // mengambil semua tombol hapus

        // jika terdapat lebih dari satu kategori, tampilkan tombol hapus
        if (categoryItems.length > 1) {
            removeButtons.forEach(button => button.style.display = "inline-block");
        } else {
            removeButtons.forEach(button => button.style.display = "none"); // sembunyikan tombol hapus jika hanya ada satu kategori
        }
    }

    //event listener untuk tombol tambah kategori
    btnTambahCategory.addEventListener("click", addCategoryRow);

    toggleRemoveButtons();
});
</script>