<?= $this->extend('template_admin') ?>
<?= $this->section('content') ?>
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Neural Network</h1>

        </div>
        <div class="section-body">
            <h2 class="section-title">Normalisasi</h2>
            <!-- <p class="section-lead">
                We use 'DataTables' made by @SpryMedia. You can check the full documentation <a
                    href="https://datatables.net/">here</a>.
            </p> -->

            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <!-- <div class="card-header">
                            <h4>Normalisasi</h4>
                        </div> -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="card-header">
                                        <h4>Init Neural Network</h4>
                                    </div>
                                    <div class="card-body">
                                        <form class=".form-save-month-range" id="form-save-month-range">
                                            <input type="hidden" class="txt_csrfname" name="<?= csrf_token() ?>"
                                                value="<?= csrf_hash() ?>" />
                                            <div class="form-group">
                                                <label>Select Month Range</label>
                                                <div class="form-group">
                                                    <input type="month" name="startMonth" id="startMonth"
                                                        value="<?= $startMonth ?>" class="form-control  mb-3" disabled>
                                                    <input type="month" name="endMonth" value="<?= $endMonth ?>"
                                                        id="endMonth" class="form-control " disabled>
                                                </div>

                                            </div>
                                        </form>

                                        <!-- <form action="/main/analysis/resultann" method="post"> -->
                                        <form action="/NeuralNetwork/learningann" method="post">
                                            <?= csrf_field(); ?>
                                            <input type="hidden" id="startMonthRange" name="startMonthRange">
                                            <input type="hidden" id="endMonthRange" name="endMonthRange">
                                            <div class="form-group">
                                                <label>Epooch</label>
                                                <input type="number" class="form-control" name="epooch"
                                                    value="<?= $epoch ?>" disabled>
                                            </div>
                                            <div class="form-group">
                                                <label>learning Rate</label>
                                                <input type="text" class="form-control" name="lr"
                                                    value="<?= $learningrate ?>" disabled>
                                            </div>
                                            <div class="form-group">
                                                <label>Minimum MSE</label>
                                                <input type="text" class="form-control" name="mse" value="<?= $mse ?>"
                                                    disabled>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                                <div class="col-lg-9">
                                    <div class="card-header">
                                        <h4>Data After Normalisasi</h4>
                                    </div>
                                    <div class="card-body">
                                        <!-- <form class=".form-month-range" id="form-month-range">
                                            <input type="hidden" class="txt_csrfname" name="<?= csrf_token() ?>"
                                                value="<?= csrf_hash() ?>" />
                                            <input type="hidden" name="startMonth" id="startMonth"
                                                class="form-control range-date-picker">
                                            <input type="hidden" name="endMonth" id="endMonth">
                                        </form> -->
                                        <div class="table-responsive" style="height: 400px;">
                                            <table class="table table-striped" id="table-1">
                                                <thead>
                                                    <tr>
                                                        <?php foreach ($month as $mon) { ?>
                                                        <th><?= $mon; ?></th>
                                                        <?php } ?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($dataNormalisasi as $key => $data) { ?>
                                                    <tr>
                                                        <?php foreach ($month as $i => $mon) { ?>
                                                        <td><input type="hidden" name="<?= $mon ?>[]"
                                                                value="<?= $data[$i] ?>">
                                                            <?= $data[$i]; ?></td>
                                                        <?php } ?>
                                                    </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-10">
                                    <div class="card-header">
                                        Bobot V
                                    </div>
                                    <div class="card-body">

                                        <div class="table-responsive" style="height: 400px;">
                                            <table class="table table-striped" id="table-1">
                                                <thead>
                                                    <tr>
                                                        <th>V</th>
                                                        <?php for ($i = 1; $i <= count($month); $i++) { ?>
                                                        <th>z<?= $i; ?></th>
                                                        <?php } ?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($bobotv as $key => $bobot) { ?>
                                                    <tr>
                                                        <td>x<?= $key + 1; ?></td>
                                                        <?php foreach ($bobot as $i => $data) { ?>
                                                        <td><input type="hidden" name="<?= $i ?>[]"
                                                                value="<?= $data ?>">
                                                            <?= $data; ?></td>
                                                        <?php } ?>
                                                    </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="card-header">Bobot W</div>
                                    <div class="card-body">
                                        <!-- <div class="table-responsive" style="height: 400px;">
                                            <table class="table table-striped" id="table-1">
                                                <thead>
                                                    <tr>
                                                        <th>W</th>
                                                        <th>Y</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($bobotw as $key => $bobot) { ?>
                                                    <tr>

                                                        <td><input type="hidden" name="z"
                                                                value="<?= $bobotw[$key][0] ?>">
                                                            <?= $bobotw[$key][0]; ?></td>
                                                    </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>
<footer class="main-footer">
    <div class="footer-left">
        Copyright &copy; 2021 <div class="bullet"></div> Design By <a href="#">Muhammad Wisnu Hidayat</a>
    </div>
    <div class="footer-right">
        1.0.0
    </div>
</footer>
</div>
</div>
<?= $this->endSection() ?>
<?= $this->section('js') ?>
<script>
var dataNormalisasi = JSON.parse('<?php echo json_encode($dataNormalisasi) ?>');
var bobotV = JSON.parse('<?php echo json_encode($bobotv) ?>');
var bobotW = JSON.parse('<?php echo json_encode($bobotw) ?>');
var biasV = JSON.parse('<?php echo json_encode($bobotbiasv) ?>');
var biasW = JSON.parse('<?php echo json_encode($bobotbiasw) ?>');


var dataHidden = [];
var dataHiddenActive = [];
//ambil data yang telah di normalisasi kemudian lakukan perhitungan ke hidden
for (const key in dataNormalisasi) {
    restHidden = [];
    restActive = [];
    for (let i = 0; i < biasV.length; i++) {
        // hitung data ke hidden per input
        restHidden.push(hitungZin(dataNormalisasi[key], bobotV[key], biasV[i]));
        // aktivasi data yang telah dihitung input ke hidden pernodenya
        restActive.push(hitungZin(dataNormalisasi[key], bobotV[key], biasV[i]));
    }
    dataHidden.push(restHidden);
    dataHiddenActive.push(restActive);
}
var dataForward = [];
var dataForwardActive = [];
for (let i = 0; i < dataHiddenActive.length; i++) {
    // console.log(dataHiddenActive[i]);
    // console.log(bobotW[i]);
    dataForward.push(hitungZin(dataForwardActive[i], bobotW, biasW));

}
console.log(bobotW);

function hitungZin(data, bobotV, biasHidden) {
    var z = 1 * biasHidden;
    for (let i = 0; i < data.length; i++) {
        z += data[i] * bobotV[i];
    }
    return z;
}
//fungsi aktivasi
function sigmoid(data) {
    return 1 / (1 + Math.exp(-data));;
}
</script>
<?= $this->endSection() ?>