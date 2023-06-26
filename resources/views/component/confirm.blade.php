<script>
    $("body").on("click", ".c-delete", function() {
        let form = $(this).closest('form');

        Swal.fire({
            html: '<div class="mt-3"><lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon><div class="mt-4 pt-2 fs-15 mx-5"><h4>Ingin Menghapus ?</h4><p class="text-muted mx-4 mb-0">Data yang telah dihapus tidak dapat dipulihkan kembali</p></div></div>',
            showCancelButton: !0,
            confirmButtonClass: "btn btn-primary w-xs me-2 mb-1",
            confirmButtonText: "Ya, Hapus!",
            cancelButtonClass: "btn btn-danger w-xs mb-1",
            cancelButtonText: "Batal",
            buttonsStyling: !1,
            showCloseButton: !0,
        }).then((res) => {
            if (res.isConfirmed) {
                form.submit()
            }
        })
    });

    $("body").on("click", ".c-payment", function(e) {
        e.preventDefault()

        let form = $(this).closest('form');

        Swal.fire({
            title: 'Total Transaksi Sudah Benar?',
            text: "Harap cek kembali sebelum menuju pembayaran",
            icon: 'question',
            showCancelButton: !0,
            confirmButtonClass: "btn btn-primary w-xs me-2 mb-1",
            confirmButtonText: "Benar! Lanjutkan",
            cancelButtonClass: "btn btn-outline-danger w-xs mb-1",
            cancelButtonText: "Sebentar! Saya Cek Lagi",
            buttonsStyling: !1,
            showCloseButton: !0,
        }).then((res) => {
            if (res.isConfirmed) {
                form.submit()
            }
        })
    });
</script>
