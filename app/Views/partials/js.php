<!-- General JS Scripts -->
<!-- <script src="https://code.jquery.com/jquery-3.3.1.min.js"
    integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script> -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src="<?= base_url() ?>/template/stisla/assets/js/stisla.js"></script>

<!-- JS Libraies -->
<script src="<?= base_url() ?>/template/stisla/node_modules/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>/template/stisla/node_modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js">
</script>
<script src="<?= base_url() ?>/template/stisla/node_modules/simpleweather/jquery.simpleWeather.min.js"></script>
<script src="<?= base_url() ?>/template/stisla/node_modules/chart.js/dist/Chart.min.js"></script>
<script src="<?= base_url() ?>/template/stisla/node_modules/jqvmap/dist/jquery.vmap.min.js"></script>
<script src="<?= base_url() ?>/template/stisla/node_modules/jqvmap/dist/maps/jquery.vmap.world.js"></script>
<script src="<?= base_url() ?>/template/stisla/node_modules/summernote/dist/summernote-bs4.js"></script>
<script src="<?= base_url() ?>/template/stisla/node_modules/chocolat/dist/js/jquery.chocolat.min.js"></script>
<script src="<?= base_url() ?>/template/stisla/node_modules/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- <script src="<?= base_url() ?>/template/stisla/node_modules/dropzone/dist/min/dropzone.min.js"></script> -->
<!-- Template JS File -->
<script src="<?= base_url() ?>/template/stisla/assets/js/scripts.js"></script>
<script src="<?= base_url() ?>/template/stisla/assets/js/custom.js"></script>

<!-- Page Specific JS File -->
<script src="<?= base_url() ?>/template/stisla/assets/js/page/modules-datatables.js"></script>
<script src="<?= base_url() ?>/template/stisla/assets/js/page/index-0.js"></script>
<script src="<?= base_url() ?>/template/stisla/node_modules/sweetalert/dist/sweetalert.min.js"></script>
<!-- <script src="<?= base_url() ?>/template/stisla/node_modules/image-uploader/dist/image-uploader.min.js"></script> -->
<!-- <script src="<?= base_url() ?>/template/stisla/assets/js/page/components-multiple-upload.js"></script> -->
<!-- my custome -->
<script src="<?= base_url() ?>/assets/js/mystyle.js"></script>
<script type="text/javascript">
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
</script>
<script>
$(document).ready(function() {
    var table = $('#product-table').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?= site_url('main/listproduct') ?>",
            "type": "POST",
            "data": {
                "csrf_test_name": $('input[name=csrf_test_name]').val()
            },
            "data": function(data) {
                data.csrf_test_name = $('input[name=csrf_test_name]').val()
            },
            'dataSrc': function(response) {
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
            "data": {
                "csrf_test_name": $('input[name=csrf_test_name]').val()
            },
            "data": function(data) {
                data.csrf_test_name = $('input[name=csrf_test_name]').val()
            },
            'dataSrc': function(response) {
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
    $.ajax({
        url: "<?= site_url('main/getSalesData') ?>",
        method: "GET",
        success: function(data) {
            // console.log(data);
            var chartx = ['hari satu'];
            var charty = [19, 20, 21];
            // for (var i in data) {
            //     chartx.push(data[i].month.product_id);
            //     charty.push(data[i].month.qty);
            //     // console.log(data[i])
            // }
            "use strict";
            mydata = [];
            mylabel = [];
            JSON.parse(data).map(function(e) {
                mon = [];
                qty = [];
                e.month.map(function(x) {
                    qty.push(x.qty);
                    if (mon.length != x.length) {
                        mon.push(x.month);
                    }
                })
                var row = {
                    // label: e.product_id,
                    data: qty,
                    borderWidth: 2,
                    // backgroundColor: '#ffffff',
                    borderColor: '#' + (Math.random() * 0xFFFFFF << 0).toString(16)
                        .padStart(6, '0'),
                    borderWidth: 1,
                    // pointBackgroundColor: '#ffffff',
                    pointRadius: 4
                }
                mylabel.push(e.product_id)
                mydata.push(row);
            });
            // var ctx = document.getElementById('salesdata').getContext('2d');
            // var chart = new Chart(ctx, {
            //     type: 'line',
            //     data: {
            //         labels: chartx,
            //         datasets: [{
            //             label: 'Jumlah Peraturan Daerah',
            //             backgroundColor: 'rgb(252, 116, 101)',
            //             borderColor: 'rgb(255, 255, 255)',
            //             data: charty
            //         }]
            //     },
            //     options: {}
            // });
            // var ctx = document.getElementById("sales").getContext('2d');
            // var myChart = new Chart(ctx, {
            //     type: 'line',
            //     data: {
            //         labels: mon,
            //         datasets: mydata
            //     },
            //     options: {
            //         legend: {
            //             display: false
            //         },
            //         // tooltips: {
            //         //     callbacks: {

            //         //     }
            //         // }
            //     }
            // });


        }
    });
});
</script>
</body>

</html>