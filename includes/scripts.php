<?php
if (strpos($_SERVER['REQUEST_URI'], '/user/') !== false || strpos($_SERVER['REQUEST_URI'], '/admin/') !== false) {
    $linkTg = "../";
} else {
    $linkTg = "";
}
?>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
    integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
    crossorigin="anonymous"></script>
<?php if (strpos($_SERVER['REQUEST_URI'], '/admin/') !== false) { ?>
    <!-- DataTable -->
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
    <!-- ApexCharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<?php } ?>
<!-- Font Awesome -->
<script src="https://kit.fontawesome.com/26afe9fd6c.js" crossorigin="anonymous"></script>
<?php if (strpos($_SERVER['REQUEST_URI'], '/admin/') !== false) { ?>
    <script src="../assets/js/admin/updateSystemAppearance.js"></script>
    <script>
        $(document).ready(function () {
            var currentPath = window.location.pathname.split('/').pop();

            $('.nav-link').each(function () {
                var linkPath = $(this).attr('href');

                if (currentPath === linkPath) {
                    $(this).addClass('active fw-bold');
                }
            });

            $('.dropdown-item').each(function () {
                var dropdownLinkPath = $(this).attr('href');

                if (currentPath === dropdownLinkPath) {
                    $(this).addClass('active');
                    $(this).closest('.dropdown').find('.nav-link').addClass('active fw-bold');
                }
            });
        });
    </script>
<?php } ?>