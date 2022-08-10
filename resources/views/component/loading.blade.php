<script>
    function showLoading() {
        Swal.fire({
            title: 'Loading...',
            html: 'Sedang mendapatkan data.',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading()
            },
        })
    }

    function stopLoading() {
        swal.close()
    }
</script>