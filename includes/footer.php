<!-- Offcanvas Toggler -->
<button class="d2c_offcanvas_toggle position-fixed top-50 start-0 translate-middle-y d-block d-lg-none" type="button"
    data-bs-toggle="offcanvas" data-bs-target="#d2c_sidebar">
    <i class="far fa-hand-point-right"></i>
</button>
<!-- End:Offcanvas Toggler -->


<!-- Initial  Javascript -->
<script src="lib/jQuery/jquery-3.5.1.min.js"></script>
<script src="lib/bootstrap_5/bootstrap.bundle.min.js"></script>
<script src="assets/alert/sweetalert2.all.min.js"></script>

<!-- Chart Config -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="./assets/js/apexchart/script.js"></script>


<!-- custom js -->
<script src="assets/js/main.js"></script>


<script>
    $("#alert15").click(function () {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: 'success',
            title: 'Signed in successfully'
        })
    });
</script>



</body>

</html>