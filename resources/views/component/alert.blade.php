<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })
</script>

@if(session('success'))
<script>
    Toast.fire({
        icon: 'success',
        title: "{{ session('success') }}"
    })
</script>
@endif

@if(session('error'))
<script>
    Toast.fire({
        icon: 'error',
        title: "{{ session('error') }}"
    })
</script>
@endif

@if(session('warning'))
<script>
    Toast.fire({
        icon: 'warning',
        title: "{{ session('warning') }}"
    })
</script>
@endif