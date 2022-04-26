
        <div class="footer">
            <div class="pull-right">
                <strong>Villahermosa Tabasco</strong>
            </div>
            <div>
                <strong>Copyright</strong> Servicios Marinos y Terrestres S.A. de C.V.&copy; 2016-2017
            </div>
        </div>
        </div>
    </div>




    <script src="../js/graficas/amcharts/amcharts.js" type="text/javascript"></script>
    <script src="../js/graficas/amcharts/serial.js" type="text/javascript"></script>
    <script src="../js/graficas/amcharts/funnel.js" type="text/javascript"></script>
    <script src="../js/graficas/amcharts/pie.js" type="text/javascript"></script>


    <!-- Mainly scripts -->
    <script src="../js/jquery-2.1.1.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="../js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Flot -->
    <script src="../js/plugins/flot/jquery.flot.js"></script>
    <script src="../js/plugins/flot/jquery.flot.tooltip.min.js"></script>
    <script src="../js/plugins/flot/jquery.flot.spline.js"></script>
    <script src="../js/plugins/flot/jquery.flot.resize.js"></script>
    <script src="../js/plugins/flot/jquery.flot.pie.js"></script>
    <script src="../js/plugins/flot/jquery.flot.symbol.js"></script>
    <script src="../js/plugins/flot/jquery.flot.time.js"></script>

    <!-- Peity -->
    <script src="../js/plugins/peity/jquery.peity.min.js"></script>
    <script src="../js/demo/peity-demo.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="../js/inspinia.js"></script>
    <script src="../js/plugins/pace/pace.min.js"></script>

    <!-- jQuery UI -->
    <script src="../js/plugins/jquery-ui/jquery-ui.min.js"></script>

    <!-- Jvectormap -->
    <script src="../js/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>
    <script src="../js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>

    <!-- EayPIE -->
    <script src="../js/plugins/easypiechart/jquery.easypiechart.js"></script>

    <!-- Sparkline -->
    <script src="../js/plugins/sparkline/jquery.sparkline.min.js"></script>

    <!-- Sparkline demo data  -->
    <script src="../js/demo/sparkline-demo.js"></script>
  <!-- FooTable -->
    <script src="../js/plugins/footable/footable.all.min.js"></script>
    <script src="../js/plugins/datapicker/bootstrap-datepicker.js"></script>

   <!-- iCheck -->
    <script src="../js/plugins/iCheck/icheck.min.js"></script>

    <!-- slick carousel-->
    <script src="../js/plugins/slick/slick.min.js"></script>
    
     <style>
        .slick_demo_2 .ibox-content {
            margin: 0 10px;
        }
    </style>
    <!-- Page-Level Scripts -->
    <script>
        $(document).ready(function() {

            $('.footable').footable();
            $('.footable2').footable();

             $('.i-checks').iCheck({
                    checkboxClass: 'icheckbox_square-green',
                    radioClass: 'iradio_square-green',
                });

        });

        $(".fecha").datepicker({
          changeYear: true,
          changeMonth: true,
          yearRange: "2016:2017",
          dateFormat:"yyyy-mm-dd",
          monthNamesShort:["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
          dayNamesMin:["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"]
        });

    </script>

     <script>
        $(document).ready(function(){


            $('.slick_demo_1').slick({
                dots: true
            });

            $('.slick_demo_2').slick({
                infinite: true,
                slidesToShow: 3,
                slidesToScroll: 1,
                centerMode: true,
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 3,
                            infinite: true,
                            dots: true
                        }
                    },
                    {
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }
                ]
            });

            $('.slick_demo_3').slick({
                infinite: true,
                speed: 500,
                fade: true,
                cssEase: 'linear',
                adaptiveHeight: true
            });
        });

    </script>

</body>
</html>
