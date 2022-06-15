<script>
    function printDiv(divName) {
        $("#footer_signature_area").show();
        $("div").removeClass("dataTables_length, table-responsive");
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        $("body, table thead tr th, table thead, table tr th, table tbody tr th").css("font-weight", "bold");
        $("body, table thead tr th, table thead, table tr th, table tbody tr th, table tbody tr td, table tfoot tr td").css("color", "black");
        $(".no-print, .dataTables_filter, #multi-filter-select_length, #multi-filter-select_info, #multi-filter-select_paginate").css("display", "none");
         window.print();
         document.body.innerHTML = originalContents;
    }
</script>
