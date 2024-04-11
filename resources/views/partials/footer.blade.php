  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>Academia Maryland 2023</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
      <!-- All the links in the footer should remain intact. -->
      <!-- You can delete the links only if you purchased the pro version. -->
      <!-- Licensing information: https://bootstrapmade.com/license/ -->
      <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
      Designed by <a href="https://cyberstaffstore.com/">cyberstaffstore.com</a>
    </div>
  </footer><!-- End Footer -->
 
 
 <!-- Vendor JS Files -->
 <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
 <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
 <script src="{{ asset('assets/vendor/chart.js/chart.umd.js') }}"></script>
 <script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script>
 <script src="{{ asset('assets/vendor/quill/quill.min.js') }}"></script>
 {{-- <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script> --}}
 <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
 <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>

 {{-- simple data table --}}
 <script src="{{ asset('assets/js/simple-datatables.js') }}"></script>
 
 <!-- Template Main JS File -->
 <script src="{{ asset('assets/js/main.js') }}"></script>
 <script src="{{ asset('assets/js/estudiantes/create.js') }}"></script>
 <script src="{{ asset('assets/js/estudiantes/delete.js') }}"></script>
 <script src="{{ asset('assets/js/estudiantes/editar.js') }}"></script>
 <script src="{{ asset('assets/js/estudiantes/getData.js') }}"></script>
 <script src="{{ asset('assets/js/grupos/getDataGrupo.js') }}"></script>
 <script src="{{ asset('assets/js/representantes/getRepresentante.js') }}"></script>
 {{-- <script src="{{ asset('assets/js/partials/sidebar.js') }}"></script> --}}
 <script src="{{ asset('assets/js/partials/alert.js') }}"></script>

 <script> 
  try {
        const dataTable = new simpleDatatables.DataTable("#datatable", {
            searchable: true,
            fixedHeight: false,
            labels: {
                placeholder: "Buscar...",
                searchTitle: "Buecar",
                pageTitle: "Pagina {page}",
                perPage: "Entradas por página",
                noRows: "No hay resultados",
                info: "Página {start} a {end} de {rows} páginas",
                noResults: "Ningún resultado coincide con su consulta de búsqueda",
            },
        })
  } catch (error) {
        console.log(error)
  }
</script>