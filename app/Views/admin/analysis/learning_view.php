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
                <div class="overflow-auto" style="height: 500px; overflow-x: scroll important!; width: 100%;">
                    <div class="card p-4 d-flex overflow-auto" style="overflow-x: scroll important!;">
                        <?php $mseOut = 1;
                        $y_denorm = [];
                        ?>
                        <?php for ($z = 1; $z <= $epoch; $z++) {
                        ?>

                            <?php if ($mseOut > $mse) {
                            ?>
                                <?php
                                $newV = [];
                                for ($h = 0; $h < count($product); $h++) {
                                    for ($j = 0; $j < count($bobotv); $j++) {
                                        $restv = 0;
                                        for ($i = 0; $i < count($product[$i]); $i++) {
                                            $restv = $restv + ($product[$h][$i] * $bobotv[$i][$j]);
                                        }
                                        $restv = $restv + $biasv[$j];
                                        // $data = [
                                        // dd($restv);
                                        // $bobotv];

                                        // dd($data);
                                        for ($k = 0; $k < count($bobotv); $k++) {
                                            $newV[$j][$h] = $restv;
                                        }
                                        // echo $restv . ' ';

                                        // $restv = 0;
                                    }
                                }
                                //hasil hidden layer
                                for ($i = 0; $i < count($newV); $i++) {
                                    for ($j = 0; $j < count($newV[$i]); $j++) {
                                        $f_inkz[$j][$i] = 1 / (1 + exp(-$newV[$i][$j]));
                                    }
                                }
                                
                                
                                $newW = array();
                                for ($i = 0; $i < $numH; $i++) {
                                    $restw = 0;
                                    for ($j = 0; $j < count($f_inkz[$i]); $j++) {
                                        $restw = $restw + ($f_inkz[$j][$i] * $bobotw[$j]);
                                    }
                                    $restw = $restw + $biasw[0];
                                    // echo $restw . ' ';
                                    for ($k = 0; $k < count($f_inkz[$i]); $k++) {
                                        $newW[$k] = $restw;
                                    }
                                }
                                //aktivasi y
                                for ($i = 0; $i < $numH; $i++) {
                                    $f_inky[$i] = 1 / (1 + exp(-$newW[$i]));
                                }
                                
                                $Xmin = [];
                                $Xmax = [];
                                $minRest = array();
                                $maxRest = array();
                                for ($j = 0; $j < count($datamonthly); $j++) {
                                    for ($i = 0; $i < count($datamonthly[$j]); $i++) {
                                        $minRest[$i] = $datamonthly[$j][$i];
                                        $maxRest[$i] = $datamonthly[$j][$i];
                                    }
                                    $Xmin[$j] = min($minRest);
                                    $Xmax[$j] = max($maxRest);
                                }
                                dd($f_inky);
                                //denormalisasi y
                                for ($i=0; $i < $f_inky; $i++) { 
                                    $y_denorm[$i] = $f_inky[$i] * ($Xmax[$i] - $Xmin[$i]) + $Xmin[$i];
                                }
                               
                                $error = array();
                                for ($i = 0; $i < $numH; $i++) {
                                    $error[$i] =   $target[$i] - $f_inky[$i];
                                }
                                $mseRest = 0;
                                for ($i = 0; $i < count($error); $i++) {
                                    $mseRest = $mseRest + pow($error[$i], 2);
                                }
                                $mseOut = $mseRest / count($error);
                                //error output
                                $errorOut = array();
                                for ($i = 0; $i < $numH; $i++) {
                                    $errorOut[$i] = ($target[$i] - $f_inky[$i]) * $f_inky[$i] * (1 - $f_inky[$i]);
                                }
                                //delta error w
                                $errorW = array();
                                for ($i = 0; $i < $numH; $i++) {
                                    $errorW[$i] = $learningrate * $f_inky[$i] * $errorOut[$i];
                                }
                                //delta bias w
                                $errorBiasW;
                                for ($i = 0; $i < count($biasw); $i++) {
                                    $errorBiasW = $learningrate *  $biasw[$i];
                                }

                                $errorHL = array();
                                for ($i = 0; $i < count($errorOut); $i++) {
                                    for ($j = 0; $j < count($bobotw); $j++) {
                                        $errorHL[$i][$j] = $errorOut[$i] * $bobotw[$j];
                                    }
                                }
                                $HslPerkalian = array();
                                for ($i = 0; $i < count($f_inkz); $i++) {
                                    for ($j = 0; $j < count($errorHL); $j++) {
                                        $HslPerkalian[$i][$j] = $errorHL[$i][$j] * $f_inkz[$i][$j] * (1 - $f_inkz[$i][$j]);
                                    }
                                }
                                //delta V
                                $errorV = array();
                                for ($i = 0; $i < count($HslPerkalian); $i++) {
                                    for ($j = 0; $j < count($product[$i]); $j++) {
                                        $errorV[$i][$j] = $learningrate * $HslPerkalian[$i][$j] * $product[$i][$j];
                                    }
                                }
                                // delta bias v
                                $errorBiasV = array();
                                for ($i = 0; $i < count($biasv); $i++) {
                                    $errorBiasV[$i] = $learningrate * $biasv[$i];
                                }

                                //update bobot v 
                                echo '<p class="text-dark">Bobot V ke epoch ' . $z . '</p>';

                                for ($i = 0; $i < count($errorV); $i++) {
                                    for ($j = 0; $j < count($bobotv); $j++) {
                                        $bobotv[$i][$j] = $errorV[$i][$j] + $bobotv[$i][$j];
                                        echo $bobotv[$i][$j] . ' ';
                                    }
                                    echo '</br>';
                                }
                                //update bobot w
                                echo '<p class="text-dark">Bobot W ke epoch ' . $z . '</p>';
                                for ($i = 0; $i < count($errorW); $i++) {
                                    $bobotw[$i] = $errorW[$i] + $bobotw[$i];
                                    echo $bobotw[$i] . '</br>';
                                }
                                // update bias v
                                echo '<p class="text-dark">Bias V ke epoch ' . $z . '</p>';
                                for ($i = 0; $i < count($biasv); $i++) {
                                    $biasv[$i] = $biasv[$i] + $errorBiasV[$i];
                                    echo $biasv[$i] . '</br>';
                                }
                                // update bias w
                                echo '<p class="text-dark">Bias W ke epoch ' . $z . '</p>';
                                for ($i = 0; $i < count($biasw); $i++) {
                                    $biasw[$i] = $biasw[$i] + $errorBiasW;
                                    echo $biasw[$i] . '</br>';
                                }
                                // $data = [
                                //     $newV,
                                //     $bobotv,
                                //     $bobotw,
                                //     $f_inkz,
                                //     $newW,
                                //     $f_inky,
                                //     $errorOut,
                                //     $errorW,
                                // $errorBiasW,
                                // $biasw
                                //     $errorHL,
                                //     $HslPerkalian,
                                //     $errorV,
                                //     $errorBiasV
                                // ];

                                // dd($data);
                                echo '</br>';
                                echo '<p class="text-dark">MSE  : ' . $mseOut . ' </p>';
                                ?>
                            <?php  } else {
                                break;
                            }
                            ?>
                        <?php
                            echo '</br> <hr> </br> ';
                        }
                        ?>
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