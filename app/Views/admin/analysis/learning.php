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

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button type="button" class="btn btn-primary float-right " id="btn-learning"
                                        onclick="learnNow()"><i class="fa fa-chart-line"></i>
                                        Learning</button>
                                </div>
                            </div>
                            <div class="row">
                                <img alt="image" src="<?= base_url() ?>/img/loader.svg" class="d-none"
                                    id="animateLoader" style=" display: block;
  margin-left: auto;
  margin-right: auto;
  width: 30%;">
                                <div id="accordion">

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="card-header">
                                        <h4>Hasil Learning</h4>
                                    </div>

                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Select Epoch</label>
                                            <select class="form-control" id="list-epoch">
                                                <option value="">-- Pilih Epooch --</option>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="card-body " id="allEpoch" style="height: 600px; overflow:scroll;">

                                        <div class="accordion">

                                        </div>
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
var dataMonthly = JSON.parse('<?php echo json_encode($datamonthly) ?>');
var dataNormalisasi = JSON.parse('<?php echo json_encode($dataNormalisasi) ?>');
var dataTargetNormalisasi = JSON.parse('<?php echo json_encode($dataTargetNormalisasi) ?>');
var bobotW = JSON.parse('<?php echo json_encode($bobotw) ?>');
var bobotV = JSON.parse('<?php echo json_encode($bobotv) ?>');
var biasV = JSON.parse('<?php echo json_encode($bobotbiasv) ?>');
var biasW = JSON.parse('<?php echo json_encode($bobotbiasw) ?>');
var learningRate = JSON.parse('<?php echo json_encode($learningrate) ?>');
var epoch = JSON.parse('<?php echo json_encode($epoch) ?>');
var standar_mse = JSON.parse('<?php echo json_encode($mse) ?>');
$("#btn-learning").click(function() {});
bobotV.forEach(function(item, index) {
    for (var i = 0; i < item.length; i++) {
        bobotV[index][i] = parseFloat(bobotV[index][i]);
    }
});




function learnNow(params) {
    $('#animateLoader').removeClass('d-none');
    learn();
    $('#animateLoader').addClass('d-none');
}

function learn() {
    var data = [];
    // var mse = 1;
    // bobotV = bobotV.map(Number);
    loop1:
        for (let e = 1; e <= epoch; e++) {
            mse = 1;
            $('#allEpoch').append(
                `<div class="row accordion d-none" id="epoch_${e}" ></div>`);
            // if (parseFloat(mse) > parseFloat(standar_mse)) {
            var data_per_item = [];
            loop2:
                for (const key in dataNormalisasi) {
                    var mse_rest = 0;
                    var dataHidden = [];
                    var dataHiddenActive = [];
                    for (let i = 0; i < biasV.length; i++) {

                        // hitung data ke hidden per input
                        dataHidden.push(hitungZin(dataNormalisasi[key], bobotV[i], biasV[i]));
                        // aktivasi data yang telah dihitung input ke hidden pernodenya
                        dataHiddenActive.push(sigmoid(hitungZin(dataNormalisasi[key], bobotV[i], biasV[i])));
                    }

                    //hitung data ke Y
                    dataForward = hitungZin(dataHiddenActive, bobotW, biasW);
                    //aktivasi data output Y
                    dataForwardActive = sigmoid(hitungZin(dataHiddenActive, bobotW, biasW));
                    //hitung mse output
                    er = dataTargetNormalisasi[key] - dataForwardActive;
                    mse_rest += parseFloat(er * er);
                    console.log(mse)
                    //backpropagation
                    //hitung galat error
                    galError = (dataTargetNormalisasi[key] - dataForwardActive) * dataForwardActive * (1 -
                        dataForwardActive);
                    // koreksi bobot / delta bobot w
                    correctBobotW = [];
                    for (let i = 0; i < dataHiddenActive.length; i++) {
                        correctBobotW[i] = learningRate * galError * dataHiddenActive[i];
                    }

                    // koreksi bias / delta bias w
                    correctBiasW = learningRate * galError;
                    // gal Error faktor
                    galBobotW = [];
                    for (let index = 0; index < bobotW.length; index++) {
                        galBobotW[index] = galError * bobotW[index];

                    }

                    //error hidden  error faktor
                    galErrorHidden = [];
                    for (let i = 0; i < galBobotW.length; i++) {
                        galErrorHidden[i] = galBobotW[i] * dataHiddenActive[i] * (1 - dataHiddenActive[i]);

                    }
                    // console.log(bobotV);
                    //Delta v
                    correctBobotV = [];
                    for (let i = 0; i < galErrorHidden.length; i++) {
                        var rest = [];
                        for (let index = 0; index < bobotV.length; index++) {
                            // correctBobotV[i][index] = learningRate * galErrorHidden[i] * bobotV[i][index];
                            rest.push(learningRate * galErrorHidden[i] * bobotV[i][index]);
                        }
                        correctBobotV.push(rest);
                    }

                    //Delta Bias V
                    correctBiasV = [];
                    for (let i = 0; i < galErrorHidden.length; i++) {
                        correctBiasV[i] = learningRate * galErrorHidden[i];
                    }

                    //Update bobot 
                    bobotW = updateBobot(bobotW, correctBobotW);
                    // console.log(bobotV);
                    for (const i in bobotV) {
                        bobotV[i] = updateBobot(bobotV[i], correctBobotV);
                    }
                    // bobotV = updateBobot(bobotV, correctBobotV);
                    biasV = updateBobot(biasV, correctBiasV);
                    biasW[0] = biasW[0] + correctBiasW;

                    rest_data = {
                        product_id: dataMonthly[key].product_id,
                        name_product: dataMonthly[key].name,
                        data_hidden: dataHidden,
                        data_hidden_active: dataHiddenActive,
                        data_forward: dataForward,
                        data_forward_active: dataForwardActive,
                        mse: mse_rest,
                        gal_error: galError,
                        delta_bobot_w: correctBobotW,
                        delta_bias_w: correctBiasW,
                        gal_bobot_w: galBobotW,
                        gal_error_hidden: galErrorHidden,
                        delta_bobot_v: correctBobotV,
                        delta_bias_v: correctBiasV,
                        new_bobot_w: bobotW,
                        new_bobot_v: bobotV,
                        new_bias_v: biasV,
                        new_bias_w: biasW[0]
                    };
                    // console.log(rest_data);
                    data_per_item.push(rest_data);

                    $(`#epoch_${e}`).append(`<div class="accordion">
                                            <div class="accordion-header" role="button" data-toggle="collapse"
                                                data-target="#epoch${e}data${key}" aria-expanded="true">
                                                <h4> ${dataMonthly[key].product_id} - ${dataMonthly[key].name}</h4>
                                            </div>
                                            <div class="accordion-body collapse" id="epoch${e}data${key}"
                                                data-parent="#accordion" style="">
                                                <div class="row">
                                                <div class="col-4">
                                                <strong>Product ID</strong>
                                                <p>${dataMonthly[key].product_id}</p>
                                                <strong>Nama</strong>
                                                <p>${dataMonthly[key].name}</p>
                                                <strong>Target</strong>
                                                <p>${dataTargetNormalisasi[key]}</p>
                                                <strong>MSE</strong>
                                                <p>${mse_rest}</p>
                                                <p><strong>Epoch Ke ${e}</strong></p>
                                                </div>
                                                <div class="col-8">
                                                <strong>Data Input (X)</strong>
                                                <p>${eachString(dataNormalisasi[key])}</p>
                                                <strong>Data Hidden Layer (Z)</strong>
                                                <p>${eachString(dataHiddenActive)}</p>
                                                <strong>Data Output (Y)</strong>
                                                <p><em>${dataForwardActive}</em></p>
                                                <strong>New Bobot (V)</strong>
                                               
                                                <strong>New Bias (V)</strong>
                                                <p>${eachString(biasV)}</p>
                                                <strong>New Bobot (W)</strong>
                                                <p>${eachString(bobotW)}</p>
                                                <strong>New Bias (W)</strong>
                                                <p>${eachString(biasW)}</p>
                                                </div>
                                                </div>
                                            </div>
                                        </div>`);
                    // if (mse < standar_mse) {
                    //     break loop1;
                    // }

                }
            mse = (1 / dataNormalisasi.length) * (mse_rest);
            console.log(mse, mse_rest);
            data.push(data_per_item);
            $('#list-epoch').append(`<option value="epoch_${e}">Number Epoch ${e}</option>`);
            // }
        }
    // console.log(data);
}
$('#list-epoch').on('change', function() {
    var withoutNone = $("#" + this.value).siblings().not('.d-none');
    withoutNone.addClass("d-none");
    $("#" + this.value).removeClass("d-none");
});

function eachString(data) {
    str = ' ';
    data.forEach(el => {
        str += `<em class="mr-4"> ${el} </em> `;
    });
    return str;
}

function updateBobot(oldBobot, newBobot) {
    element = [];
    for (let i = 0; i < oldBobot.length; i++) {
        element[i] = parseFloat(oldBobot[i]) + parseFloat(newBobot[i]);
    }
    return element;
}

function hitungZin(data, bobotV, biasHidden) {
    var z = 1 * biasHidden;
    for (let i = 0; i < data.length; i++) {
        z += data[i] * parseFloat(bobotV[i]);
    }
    return z;
}
//fungsi aktivasi
function sigmoid(data) {
    return 1 / (1 + Math.exp(-data));;
}
</script>
<?= $this->endSection() ?>