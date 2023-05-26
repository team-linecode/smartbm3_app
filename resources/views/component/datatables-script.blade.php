<!-- DataTables Js -->
<script src="/vendor/manage/assets/libs/datatables/DataTables-1.12.1/js/jquery.dataTables.min.js"></script>
<script src="/vendor/manage/assets/libs/datatables/DataTables-1.12.1/js/dataTables.bootstrap5.min.js"></script>
<script src="/vendor/manage/assets/libs/datatables/Buttons-2.2.3/js/dataTables.buttons.min.js"></script>
<script src="/vendor/manage/assets/libs/datatables/Buttons-2.2.3/js/buttons.print.min.js"></script>
<script src="/vendor/manage/assets/libs/datatables/Buttons-2.2.3/js/buttons.html5.min.js"></script>
<script src="/vendor/manage/assets/libs/datatables/Buttons-2.2.3/js/buttons.bootstrap5.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        new DataTable(".datatables");
    })

    document.addEventListener("DOMContentLoaded", function() {
        new DataTable(".buttons-datatables", {
            dom: "Bfrtip",
            buttons: ["copy", "csv", "excel", "print"],
        });
    })
</script>
