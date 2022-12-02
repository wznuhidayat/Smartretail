<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title><?php echo ucwords($title) ?></title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <!-- CSS Libraries -->
    <link rel="stylesheet"
        href="<?= base_url() ?>/template/stisla/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet"
        href="<?= base_url() ?>/template/stisla/node_modules/datatables.net-select-bs4/css/select.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/template/stisla/node_modules/jqvmap/dist/jqvmap.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/template/stisla/node_modules/weathericons/css/weather-icons.min.css">
    <link rel="stylesheet"
        href="<?= base_url() ?>/template/stisla/node_modules/weathericons/css/weather-icons-wind.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/template/stisla/node_modules/summernote/dist/summernote-bs4.css">
    <link rel="stylesheet"
        href="<?= base_url() ?>/template/stisla/node_modules/bootstrap-daterangepicker/daterangepicker.css">
    <script>
    // $('.range-date-picker').datepicker({
    //     changeMonth: true,
    //     changeYear: true,
    //     showButtonPanel: true,
    //     dateFormat: 'MM yy',
    //     onClose: function(dateText, inst) {
    //         $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
    //     }
    // });
    </script>
    <!-- <link rel="stylesheet" href="<?= base_url() ?>/template/stisla/node_modules/imag  e-uploader/dist/image-uploader.min.css"> -->
    <!-- <link rel="stylesheet" href="<?= base_url() ?>/template/stisla/node_modules/dropzone/dist/min/dropzone.min.css"> -->
    <!-- Template CSS -->
    <style>
    .ui-datepicker-calendar {
        display: none;
    }
    </style>
    <link rel="stylesheet" href="<?= base_url() ?>/template/stisla/assets/css/style.css">
    <link rel="stylesheet" href="<?= base_url() ?>/template/stisla/assets/css/components.css">
</head>