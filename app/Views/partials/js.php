<!-- General JS Scripts -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src="<?= base_url() ?>/template/assets/js/stisla.js"></script>

<!-- JS Libraies -->
<script src="<?= base_url() ?>/template/node_modules/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>/template/node_modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>/template/node_modules/simpleweather/jquery.simpleWeather.min.js"></script>
<script src="<?= base_url() ?>/template/node_modules/chart.js/dist/Chart.min.js"></script>
<script src="<?= base_url() ?>/template/node_modules/jqvmap/dist/jquery.vmap.min.js"></script>
<script src="<?= base_url() ?>/template/node_modules/jqvmap/dist/maps/jquery.vmap.world.js"></script>
<script src="<?= base_url() ?>/template/node_modules/summernote/dist/summernote-bs4.js"></script>
<script src="<?= base_url() ?>/template/node_modules/chocolat/dist/js/jquery.chocolat.min.js"></script>
<!-- <script src="<?= base_url() ?>/template/node_modules/dropzone/dist/min/dropzone.min.js"></script> -->
<!-- Template JS File -->
<script src="<?= base_url() ?>/template/assets/js/scripts.js"></script>
<script src="<?= base_url() ?>/template/assets/js/custom.js"></script>

<!-- Page Specific JS File -->
<script src="<?= base_url() ?>/template/assets/js/page/modules-datatables.js"></script>
<script src="<?= base_url() ?>/template/assets/js/page/index-0.js"></script>
<script src="<?= base_url() ?>/template/node_modules/sweetalert/dist/sweetalert.min.js"></script>
<!-- <script src="<?= base_url() ?>/template/node_modules/image-uploader/dist/image-uploader.min.js"></script> -->
<!-- <script src="<?= base_url() ?>/template/assets/js/page/components-multiple-upload.js"></script> -->
<!-- my custome -->
<script src="<?= base_url() ?>/assets/js/mystyle.js"></script>
<script>
  $(document).ready(function() {
    var table = $('#product-table').DataTable({
      "processing": true,
      "serverSide": true,
      "order": [],
      "ajax": {
        "url": "<?= site_url('main/listproduct') ?>",
        "type": "POST",
        "data": {"csrf_test_name" :  $('input[name=csrf_test_name]').val()},
        "data": function(data){
          data.csrf_test_name = $('input[name=csrf_test_name]').val()
        },
        'dataSrc' :function(response){
         $('input[name=csrf_test_name]').val(response.csrf_test_name)
         return response.data;
        }
      },
      "columnDefs": [{
        "targets": [],
        "orderable": false,
      }, ],
    });
  });
  $(document).ready(function() {
    var table = $('#sales-table').DataTable({
      "processing": true,
      "serverSide": true,
      "order": [],
      "ajax": {
        "url": "<?= site_url('main/listsales') ?>",
        "type": "POST",
        "data": {"csrf_test_name" :  $('input[name=csrf_test_name]').val()},
        "data": function(data){
          data.csrf_test_name = $('input[name=csrf_test_name]').val()
        },
        'dataSrc' :function(response){
         $('input[name=csrf_test_name]').val(response.csrf_test_name)
         return response.data;
        }
      },
      "columnDefs": [{
        "targets": [],
        "orderable": false,
      }, ],
    });
  });
</script>
</body>

</html>