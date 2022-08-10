<script>
    $('body').on('click', '.btn-display-password', function() {
        $(this).parent().children('span').toggleClass('d-none')
        $(this).children('i').toggleClass('la-eye-slash la-eye text-danger')
    })
</script>