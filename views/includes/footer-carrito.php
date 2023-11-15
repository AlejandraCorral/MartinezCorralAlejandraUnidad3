</main>


    <footer class="site-footer">
        <div class="container">
            <div class="row">

                <div class="col-lg-6 col-md-6 col-12 mb-4 mb-md-0 mb-lg-0">
                    <h6 class="site-footer-title mb-3">Contact</h6>

                    <p class="mb-2"><strong class="d-inline me-2">Phone:</strong> 962012271</p>

                    <p>
                        <strong class="d-inline me-2">Email:</strong>
                        <a href="#">ana.info1999@gmail.com</a>
                    </p>
                </div>

                <div class="col-lg-6 col-md-6 col-12">
                    <h6 class="site-footer-title mb-3">Social</h6>

                    <ul class="social-icon">
                        <li class="social-icon-item">
                            <a href="#" class="social-icon-link bi-instagram"></a>
                        </li>

                        <li class="social-icon-item">
                            <a href="#" class="social-icon-link bi-twitter"></a>
                        </li>

                        <li class="social-icon-item">
                            <a href="#" class="social-icon-link bi-whatsapp"></a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </footer>


    <!-- JAVASCRIPT FILES -->
    <script src="<?php echo RUTA . 'assets/'; ?>index/js/jquery.min.js"></script>
    <script src="<?php echo RUTA . 'assets/'; ?>index/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo RUTA . 'assets/'; ?>index/js/owl.carousel.min.js"></script>
    <script src="<?php echo RUTA . 'assets/'; ?>index/slick/slick/slick.js"></script>

    <script src="<?php echo RUTA . 'assets/'; ?>js/snackbar.min.js"></script>
    <script src="<?php echo RUTA . 'assets/'; ?>js/axios.min.js"></script>

    <script type="text/javascript" src="<?php echo RUTA . 'assets/'; ?>vendor/all.min.js"></script>

    <script>
        const ruta = '<?php echo RUTA; ?>';

        function message(tipo, mensaje) {
            Snackbar.show({
                text: mensaje,
                pos: 'top-right',
                backgroundColor: tipo == 'success' ? '#079F00' : '#FF0303',
                actionText: 'Cerrar'
            });
        }
    </script>

    <script src="<?php echo RUTA . 'assets/'; ?>index/js/custom.js"></script>

</body>

</html>