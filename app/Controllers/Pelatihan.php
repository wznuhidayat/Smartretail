<?php

namespace App\Controllers;

// use CodeIgniter\Controller;
// use App\Models\SiswaModel;
// use App\Models\JurusanModel;
// use App\Models\TahunModel;
// use App\Models\NilaiModel;
// use App\Models\MatapelajaranModel;

class Pelatihan extends BaseController
{
    // public function __construct()
    // {
    //     // $this->SiswaModel = new SiswaModel();
    //     $this->JurusanModel = new JurusanModel();
    //     $this->TahunModel = new TahunModel();
    //     $this->NilaiModel = new NilaiModel();
    //     $this->MatapelajaranModel = new MatapelajaranModel();
    //     $this->SiswaModel = new SiswaModel();
    // }
    // public function index()
    // {
    //     $data = [
    //         'title' => 'Pelatihan',

    //         'isi' => 'admin/pelatihan'
    //     ];
    //     echo view('admin/layout/wrapper', $data);
    // }


    public $numEpoh = 1000;
    public $LR = 0.3;
    public $numHL = 4;
    public $mseStandard = 0.001;
    public $bias = [1, 1, 1, 1];

    public $nilai = [
        [82, 85, 83, 80, 83],
        [89, 90, 87, 84, 87],
        [82, 85, 83, 82, 83],
        [89, 85, 87, 84, 87],
        [80, 85, 82, 82, 82],
    ];

    public $target = array(68, 79, 75, 79.50, 71.50);
    public $bobotv = [
        [-0.53, -0.1, 0.22, 0.83, 0.23],
        [-0.84, 0.76, 0.62, 0.35, 0.45],
        [-0.14, 0.79, 0.57, -0.26, -0.25],
        [0.75, -0.95, 0.33, -0.7, 0.65],
        [-0.14, 0.79, 0.57, -0.26, 0.88]
    ];
    public $bobotw = array(0.5, 0.73, -0.94, 0.47, 0.85);

    public $b1 = array();
    public $b2 = array();

    public $HLIn = array();
    public $HLOut = array();


    public $mseOut = array();


    public $minP = [];
    public $maxP = [];

    public $minT;
    public $maxT;



    public function MetodeJst()
    {

        //set min max per row
        $minRest = array();
        $maxRest = array();

        for ($j = 0; $j < count($this->nilai); $j++) {
            for ($i = 0; $i < count($this->nilai); $i++) {
                // $this->minP[$i] = min($this->nilai[$i][]);
                $minRest[$i] = $this->nilai[$i][$j];
                $maxRest[$i] = $this->nilai[$i][$j];

                // array_push($minRest,$i,)
            }
            $this->minP[$j] = min($minRest);
            $this->maxP[$j] = max($maxRest);
        }

        $this->minT = min($this->target);
        $this->maxT = max($this->target);
        //normalisasi
        $newMin = -1;
        $newMax = 1;

        $newnilai = [];

        for ($j = 0; $j < count($this->nilai); $j++) {
            for ($i = 0; $i < count($this->nilai); $i++) {
                $newnilai[$j][$i] = ($this->nilai[$j][$i] - $this->minP[$i]) / ($this->maxP[$i] - $this->minP[$i]) * ($newMax - $newMin) + $newMin;
            }
        }
        $newTarget = [];
        for ($i = 0; $i < count($this->target); $i++) {
            $newTarget[$i] = ($this->target[$i] - $this->minT) / ($this->maxT - $this->minT) * ($newMax - $newMin) + $newMin;
        }

        for ($z = 0; $z < $this->numEpoh; $z++) {
            if ($this->mseOut > $this->mseStandard) {

                $newV = [];
                for ($h = 0; $h < count($this->bobotv); $h++) {
                    for ($j = 0; $j < count($newnilai); $j++) {
                        $restv = 0;
                        for ($i = 0; $i < count($this->bobotv); $i++) {
                            $restv = $restv + ($newnilai[$j][$i] * $this->bobotv[$i][$h]);
                        }
                        $restv = $restv + $this->bias[$j];
                        for ($k = 0; $k < 4; $k++) {
                            $newV[$h][$j] = $restv;
                        }
                        // echo $restv . ' ';

                        // $restv = 0;
                    }
                }
 

        // input layer ke hiden layer
        $newV = [];
        for ($h = 0; $h < count($this->bobotv); $h++) {
            for ($j = 0; $j < count($newnilai); $j++) {
                $restv = 0;
                for ($i = 0; $i < count($this->bobotv); $i++) {
                    $restv = $restv + ($newnilai[$j][$i] * $this->bobotv[$i][$h]);
                }
                $restv = $restv + 1;
                for ($k = 0; $k < 5; $k++) {
                    $newV[$h][$j] = $restv;
                }
                // echo $restv . ' ';

                // $restv = 0;
            }
        }

        // fungsi aktivasi Hiden Layer
        for ($i = 0; $i < $this->HL; $i++) {
            for ($j = 0; $j < count($newV); $j++) {
                $this->HLIn[$i][$j] = 1 / (1 + exp(-$newV[$i][$j]));
            }
        }

        // public $bobotw = array(0.5, 0.73, -0.94, 0.47);
        $newW = array();
        for ($i = 0; $i < $this->HL; $i++) {
            $restw = 0;
            for ($j = 0; $j < count($this->bobotw); $j++) {
                $restw = $restw + ($this->HLIn[$i][$j] * $this->bobotw[$j]);
            }
            $restw = $restw + 1;
            // echo $restw . ' ';
            for ($k = 0; $k < 5; $k++) {
                $newW[$i] = $restw;
            }
        }

        //ouput setelah di aktivasi
        for ($i = 0; $i < $this->HL; $i++) {
            $this->HLOut[$i] = 1 / (1 + exp(-$newW[$i]));
        }
        // $error = array();
        // for ($i = 0; $i < count($this->HLOut); $i++) {
        //     $error[$i] = $this->HLOut[$i] - $newTarget[$i];
        // }
        // $mseRest = 0;
        // for ($i = 0; $i < count($error); $i++) {
        //     $mseRest = $mseRest + ($error[$i] ^ 2);
        //     // echo $mseRest. ' ';
        // }

        //backpropagation


        //find output error
        $errorOut = array();
        for ($i = 0; $i < count($this->HLOut); $i++) {
            $errorOut[$i] = ($newTarget[$i] - $this->HLOut[$i]) * $this->HLOut[$i] * (1 - $this->HLOut[$i]);
        }

        //koreksi bobot w
        $errorW = array();
        for ($i = 0; $i < count($this->HLIn); $i++) {
            for ($j = 0; $j < count($errorOut); $j++) {
                $errorW[$i][$j] = $this->LR * $this->HLIn[$i][$j] * $errorOut[$i];
            }
        }
        //koreksi bias 2
        $errorBias = array();
        for ($i = 0; $i < count($errorOut); $i++) {
            $errorBias[$i] = $this->LR *  $errorOut[$i] * 1;
        }

        //hitung delta input hidden
        $errorHL = array();
        for ($i = 0; $i < count($errorOut); $i++) {
            for ($j = 0; $j < count($this->bobotw); $j++) {
                $errorHL[$i][$j] = $errorOut[$i] * $this->bobotw[$j];
            }
        }

        //kalikan dengan turunan aktivasi
        $HslPerkalian = array();
        for ($i = 0; $i < count($this->HLIn); $i++) {
            for ($j = 0; $j < count($errorHL); $j++) {
                $HslPerkalian[$i][$j] = $errorHL[$i][$j] * $this->HLIn[$i][$j] * (1 - $this->HLIn[$i][$j]);
            }
        }

        //hitung perubahan bobot
        $PerubahanBobotV = array();
        for ($i = 0; $i < count($HslPerkalian); $i++) {
            for ($j = 0; $j < count($newnilai); $j++) {
                $PerubahanBobotV[$i][$j] = $this->LR * $HslPerkalian[$i][$j] * $newnilai[$i][$j];
            }
        }
        //update bobot
        $updBobotW = array();
        for ($i = 0; $i < count($errorW); $i++) {
            for ($j = 0; $j < count($this->bobotw); $j++) {
                $updBobotW[$i][$j] = $errorW[$i][$j] + $this->bobotw[$j];
            }
        }

        $updBobotV = array();
        for ($i = 0; $i < count($PerubahanBobotV); $i++) {
            for ($j = 0; $j < count($this->bobotv); $j++) {
                $updBobotV[$i][$j] = $PerubahanBobotV[$i][$j] + $this->bobotv[$i][$j];
            }
        }

        for ($i=0; $i < count($this->bias); $i++) {
            $this->bias[$i] = $this->bias[$i] + ($this->LR * $errorBias[$i]);
        }
        // $this->mseOut = $mse;
        }else{
        break;
        }
        echo $this->mseOut. '</br>';

    }


    
        // echo

    }
}
