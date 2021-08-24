    <?= $this->extend('template_admin') ?>

    <?= $this->section('content') ?>
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Learning Result</h1>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="overflow-auto" style="height: 200px; overflow-x: scroll important!; width: 100%;">
                        <div class="card p-4 d-flex overflow-auto" style="overflow-x: scroll important!;">
                            <?php
                            $mseOut = 100;
                            for ($z = 1; $z <= $epoch; $z++) {
                                if ($mseOut > $mse) {
                                    $newV = [];
                                    $error = array();
                                    $mseRest = 0;
                                    for ($h = 0; $h < count($product); $h++) {
                                        for ($j = 0; $j < count($bobotv); $j++) {
                                            $restv = 1 * $bobotbiasv[$j];
                                            for ($i = 0; $i < count($product[$h]); $i++) {
                                                $restv = $restv + ($product[$h][$i] * $bobotv[$i][$j]);
                                            }

                                            $newV[$j] = $restv;
                                        }
                                        //hasil nilai hidden setelah aktivasi
                                        $f_inkz = array();
                                        for ($j = 0; $j < count($newV); $j++) {
                                            $f_inkz[$j] = 1 / (1 + exp(-$newV[$j]));
                                        }
                                        $newW = array();
                                        $restw = 1 * $bobotbiasw[0];
                                        for ($j = 0; $j < $numH; $j++) {
                                            $restw = $restw + ($f_inkz[$j] * $bobotw[$j]);
                                        }
                                        $newW[0] = $restw;
                                        //aktivasi output
                                        $f_inky = array();
                                        $f_inky[0] = 1 / (1 + exp(-$newW[0]));


                                        // $error = array();
                                        // $error[0] =   $target[0] - $f_inky[0];

                                        //error output
                                        $errorOut = array();
                                        $errorOut[0] = ($target[$h] - $f_inky[0]) * $f_inky[0] * (1 - $f_inky[0]);
                                        //delta w
                                        $errorW = array();
                                        for ($i = 0; $i < count($bobotw); $i++) {
                                            $errorW[$i] = $learningrate * $errorOut[0] * $f_inkz[$i];
                                        }
                                        // delta bias w
                                        $errorBiasW = $learningrate * $errorOut[0] * $bobotbiasw[0];

                                        // hitung error hidden
                                        $errorHL = array();
                                        for ($j = 0; $j < count($bobotw); $j++) {
                                            $errorHL[$j] = $errorOut[0] * $bobotw[$j];
                                        }
                                        // error hidden bias
                                        $errorHbias = $errorOut[0] * $bobotbiasw[0];
                                        //hitung perkalian aktivasi
                                        $HslPerkalian = array();
                                        for ($j = 0; $j < count($errorHL); $j++) {
                                            $HslPerkalian[$j] = $errorHL[$j] * $f_inkz[$j] * (1 - $f_inkz[$j]);
                                        }
                                        //
                                        // $hasilPerkalianBias = $errorHbias * 1 * (1 - 1);
                                        //delta v
                                        $errorV = array();
                                        for ($i = 0; $i < count($HslPerkalian); $i++) {
                                            for ($j = 0; $j < count($HslPerkalian); $j++) {
                                                $errorV[$i][$j] = $learningrate * $HslPerkalian[$j] * $product[$h][$i];
                                            }
                                        }
                                        // delta bias v
                                        $errorBiasV = array();
                                        for ($i = 0; $i < $numH; $i++) {
                                            $errorBiasV[$i] = $learningrate * $HslPerkalian[$i] * 1;
                                        }
                                        // update bobot v
                                        for ($i = 0; $i < count($errorV); $i++) {
                                            for ($j = 0; $j < count(($bobotv)); $j++) {
                                                $bobotv[$i][$j] = $errorV[$i][$j] + $bobotv[$i][$j];
                                            }
                                        }
                                        // update bobot bias v
                                        for ($i = 0; $i < count($errorBiasV); $i++) {
                                            $bobotbiasv[$i] =  $errorBiasV[$i] + $bobotbiasv[$i];
                                        }
                                        // update bobot w
                                        for ($i = 0; $i < count($errorW); $i++) {
                                            $bobotw[$i] = $errorW[$i] + $bobotw[$i];
                                        }
                                        // update bias w
                                        $bobotbiasw[0] = $errorBiasW + $bobotbiasw[0];

                                        // get mse
                                        $error[$h] =   $target[$h] - $f_inky[0];
                                        // $mseRest = $mseRest + pow($error[$h], 2);
                                        // echo $error[$h] . ' </br>'; 
                                        // $data = [
                                        //     $product,
                                            // $bobotw,
                                            // $bobotbiasv,
                                            // $newV,
                                            // $f_inkz,
                                            // $newW,
                                            // $f_inky,
                                        //     $errorOut,
                                        //     $errorHL,
                                        //     $target,
                                        //     $errorW,
                                        //     $HslPerkalian,
                                        //     $errorV,
                                        //     $errorBiasV,
                                        // ];
                                        // dd($data);
                                    }
                                    $mseRest = 0;
                                    for ($i = 0; $i < count($error); $i++) {
                                        $mseRest = $mseRest + pow($error[$i], 2);
                                    }
                                    $mseOut = $mseRest / count($error);
                                    echo '<p class="text-dark">Epooch ke -' .$z.'  MSE : '. $mseOut . '</p></br></hr>';
                                }
                            }
                            ?>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Result Prediction</h4>
                        </div>
                        <?= $this->include('massage') ?>
                        <div id="delete"></div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th class="text-center">
                                                No
                                            </th>
                                            <th>ID Product</th>
                                            <th>Target</th>
                                            <th>JST</th>
                                            <th>Error</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1;
                                        $AvgPresentasiError = 0;
                                        ?>

                                        <?php for ($h = 0; $h < count($datatest); $h++) { ?>
                                            <tr>
                                                <th><?= $h + 1; ?></th>
                                                <td><?= $test[$h]['product_id']; ?></td>
                                                <td><?= $test[$h]['target']; ?></td>

                                                <?php
                                                for ($j = 0; $j < count($bobotv); $j++) {
                                                    $restv = 1 * $bobotbiasv[$j];
                                                    for ($i = 0; $i < count($datatest[$h]); $i++) {
                                                        $restv = $restv + ($datatest[$h][$i] * $bobotv[$i][$j]);
                                                    }

                                                    $newV[$j] = $restv;
                                                }
                                                //hasil nilai hidden setelah aktivasi
                                                $f_inkz = array();
                                                for ($j = 0; $j < count($newV); $j++) {
                                                    $f_inkz[$j] = 1 / (1 + exp(-$newV[$j]));
                                                }
                                                $newW = array();
                                                $restw = 1 * $bobotbiasw[0];
                                                for ($j = 0; $j < $numH; $j++) {
                                                    $restw = $restw + ($f_inkz[$j] * $bobotw[$j]);
                                                }
                                                $newW[0] = $restw;
                                                //aktivasi output
                                                $f_inky = array();
                                                $f_inky[0] = 1 / (1 + exp(-$newW[0]));

                                                //denormalisasi
                                                $outdenorm = $f_inky[0] * max($datatarget) - $f_inky[0] * min($datatarget) + min($datatarget);
                                                echo "<td>" . round($outdenorm) . "</td>";
                                                // $error = array();
                                                // $error[0] =   $target[0] - $f_inky[0];
                                                $selisih;
                                                $presentaseError;
                                                // dd($datatargettest);
                                                if (round($outdenorm) > $datatargettest[$h]) {
                                                    $selisih = round($outdenorm) - $datatargettest[$h];
                                                    if ($selisih == 0) {
                                                        $presentaseError = round($outdenorm) / 1 * 100;
                                                    } else {
                                                        $presentaseError = round($outdenorm) / $selisih * 100;
                                                    }
                                                } else {
                                                    $selisih = $datatargettest[$h] - round($outdenorm);
                                                    if ($selisih == 0) {
                                                        $presentaseError = round($outdenorm) / 1 * 100;
                                                    } else {
                                                        $presentaseError = round($outdenorm) / $selisih * 100;
                                                    }
                                                }
                                                echo "<td>" . round($presentaseError, 2) . " %</td>";
                                                //error output
                                                $errorOut = array();
                                                $errorOut[0] = ($targettest[$h] - $f_inky[0]) * $f_inky[0] * (1 - $f_inky[0]);
                                                //delta w
                                                $errorW = array();
                                                for ($i = 0; $i < count($bobotw); $i++) {
                                                    $errorW[$i] = $learningrate * $errorOut[0] * $f_inkz[$i];
                                                }
                                                // delta bias w
                                                $errorBiasW = $learningrate * $errorOut[0] * $bobotbiasw[0];

                                                // hitung error hidden
                                                $errorHL = array();
                                                for ($j = 0; $j < count($bobotw); $j++) {
                                                    $errorHL[$j] = $errorOut[0] * $bobotw[$j];
                                                }
                                                // error hidden bias
                                                $errorHbias = $errorOut[0] * $bobotbiasw[0];
                                                //hitung perkalian aktivasi
                                                $HslPerkalian = array();
                                                for ($j = 0; $j < count($errorHL); $j++) {
                                                    $HslPerkalian[$j] = $errorHL[$j] * $f_inkz[$j] * (1 - $f_inkz[$j]);
                                                }
                                                //
                                                // $hasilPerkalianBias = $errorHbias * 1 * (1 - 1);
                                                //delta v
                                                $errorV = array();
                                                for ($i = 0; $i < count($HslPerkalian); $i++) {
                                                    for ($j = 0; $j < count($HslPerkalian); $j++) {
                                                        $errorV[$i][$j] = $learningrate * $HslPerkalian[$j] * $product[$h][$i];
                                                    }
                                                }
                                                // delta bias v
                                                $errorBiasV = array();
                                                for ($i = 0; $i < $numH; $i++) {
                                                    $errorBiasV[$i] = $learningrate * $HslPerkalian[$i] * 1;
                                                }
                                                // update bobot v
                                                for ($i = 0; $i < count($errorV); $i++) {
                                                    for ($j = 0; $j < count(($bobotv)); $j++) {
                                                        $bobotv[$i][$j] = $errorV[$i][$j] + $bobotv[$i][$j];
                                                    }
                                                }
                                                // update bobot bias v
                                                for ($i = 0; $i < count($errorBiasV); $i++) {
                                                    $bobotbiasv[$i] =  $errorBiasV[$i] + $bobotbiasv[$i];
                                                }
                                                // update bobot w
                                                for ($i = 0; $i < count($errorW); $i++) {
                                                    $bobotw[$i] = $errorW[$i] + $bobotw[$i];
                                                }
                                                // update bias w
                                                $bobotbiasw[0] = $errorBiasW + $bobotbiasw[0];

                                                // get mse
                                                $error[$h] =   $targettest[$h] - $f_inky[0];
                                                //Rata-rata
                                                $AvgPresentasiError =  $AvgPresentasiError + round($presentaseError, 2);

                                                ?>
                                            </tr>
                                        <?php } ?>







                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php
                        $mseRest = 0;
                        for ($i = 0; $i < count($error); $i++) {
                            $mseRest = $mseRest + pow($error[$i], 2);
                        }
                        $mseOut = $mseRest / count($error);
                        $hasilrata2 = $AvgPresentasiError / count($datatest);

                        ?>
                        <p class="text-center mt-4">Setelah Dilakukan Proses Learning Menggunakan Jaringan Syaraf Tiruan Backpropagation maka MSE data uji adalah sebagai berikut <?= $mseOut; ?> dan akurasi prediksi yang didapatkan adalah <?= $hasilrata2; ?></p>


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