<?php

namespace App\Controllers;

use CodeIgniter\HTTP\Request;
use \Hermawan\DataTables\DataTable;
use App\Models\M_product_sold;
use Config\Services;


class NeuralNetwork extends BaseController
{
    public $product = [
        [4, 13, 6, 17],
        [2, 12, 4, 18],
        [0, 14, 2, 10],
        [1, 11, 0, 12]
    ];

    public $target = array(
        7, 21, 13, 12
    );
    public function __construct()
    {
        // $this->M_admin = new M_admin();
        // $this->M_seller = new M_seller();
        // $this->M_product = new M_product();
        // $this->M_product_img = new M_product_img();
        $this->M_product_sold = new M_product_sold();
        // $this->M_product_test = new M_product_test();
        // $this->M_cat_product = new M_cat_product();
        helper('url', 'form', 'html');
    }
    public function index()
    {

        $data = [
            'title' => 'Neural Network',
        ];
        return view('admin/analysis/neural_network_view', $data);
    }
    public function getDataMonthRange()
    {
        $csrfName = csrf_token();
        $csrfHash = csrf_hash();
        $request = Services::request();
        $req = $request->getPost('data');
        $start_month = $req[1]['value']; // sesuai dengan method yang dikirim client
        $end_month = $req[2]['value']; // sesuai dengan method yang dikirim client

        // $data = [
        //     'start' => $start_month,
        //     'end' => $end_month
        // ]; // hasil bisnis proses
        $data = $this->getMonthSalesRange($start_month, $end_month);
        // $data['token'] = $csrfHash;
        // return json_encode($data);
        return $this->response->setJSON((array) $data);
    }
    public function learningann()
    {
        $start_month = $this->request->getPost('startMonthRange');
        $end_month = $this->request->getPost('endMonthRange');
        $dateStart = explode("-", $start_month);
        $dateEnd = explode("-", $end_month);
        $yearStart = $dateStart[0];
        $yearEnd = $dateEnd[0];
        $monthStart = $dateStart[1];
        $monthEnd = $dateEnd[1];
        $gapMonth = (($yearEnd - $yearStart) * 12) + ($monthEnd - $monthStart);
        //get semua data product
        $data = $this->getMonthSalesRange($start_month, $end_month);

        list($mem_num) = sscanf($monthEnd, "%[0-9]");
        list($mem_year) = sscanf($yearEnd, "%[0-9]");
        if ($mem_num == '12') {
            $mem_num = '01';
            $mem_year += 1;
        } else {
            $mem_num += 1;
        }
        $monthStartTarget =  str_pad($mem_num, 2, '0', STR_PAD_LEFT);
        $yearStartTarget =  str_pad($mem_year, 2, '0', STR_PAD_LEFT);
        //get data target
        $dataTarget = $this->getMonthSalesRange($end_month, $yearStartTarget . '-' . $monthStartTarget, $data);
        //get epoch and learning rate dan mse
        $numEpoh = intval($this->request->getPost('epooch'));
        $LR = floatval($this->request->getPost('lr'));
        $mseStandard = 0.001;
        //get data and target
        $dataTest = $this->getOnlyData($start_month, $end_month);
        $dataTargetTest = $this->getOnlyData($end_month, $yearStartTarget . '-' . $monthStartTarget, $data);
        // return var_dump($dataTarget);
        //get bobot V dan W
        $randomBobotV = $this->RandomBobot($dataTest);
        $randomBobotW = [];
        for ($i = 0; $i < count($dataTest[0]); $i++) {
            $randomBobotW[$i] = rand(0, 100) / 100;
        }
        //bias
        $randbiasv = [];
        $randbiasw = [];
        for ($i = 0; $i < $gapMonth; $i++) {
            $randbiasv[$i] = rand(0, 100) / 100;
        }
        for ($i = 0; $i < 1; $i++) {
            $randbiasw[$i] = rand(0, 100) / 100;
        }
        // echo '<pre>', var_dump($randomBobotW), '</pre>';

        $data = [
            'title' => 'Learning Ann',
            'startMonth' => $start_month,
            'endMonth' => $end_month,
            // 'product' => $newProduct,
            'datamonthly' => $data,
            'datatarget' => $dataTarget,
            // 'target' => $this->NormalisasiTarget(),
            'mse' => $mseStandard,
            'datatest' => $dataTest,
            'targettest' => $dataTargetTest,
            'dataNormalisasi' => $this->Normalisasi($dataTest),
            'dataTargetNormalisasi' => $this->Normalisasi($dataTargetTest),
            'month' => array_keys($dataTest[0]),
            'numHiddenLayer' => $gapMonth,
            'epoch' => $numEpoh,
            'learningrate' => $LR,
            'bobotv' => $randomBobotV,
            'bobotw' => $randomBobotW,
            'bobotbiasv' => $randbiasv,
            'bobotbiasw' => $randbiasw,

        ];
        // return var_dump($data);
        // return $this->response->setJSON((array) $data);
        return view('admin/analysis/learning', $data);
    }
    public function getMonthSalesRange($start_month, $end_month, $data_range = null)
    {
        $salesData = $this->M_product_sold->getSalesData($start_month, $end_month);
        $dateStart = explode("-", $start_month);
        $dateEnd = explode("-", $end_month);
        $yearStart = $dateStart[0];
        $yearEnd = $dateEnd[0];
        $monthStart = $dateStart[1];
        $monthEnd = $dateEnd[1];
        $gapMonth = (($yearEnd - $yearStart) * 12) + ($monthEnd - $monthStart);
        if ($data_range == null) {
            $getDataGroupId = $this->M_product_sold->getAllProductSales($start_month, $end_month);
        } else {
            $getDataGroupId = $data_range;
        }
        $data = [];
        foreach ($getDataGroupId as $key => $value) {
            $row = [];
            // $row_data = [];
            $row['product_id'] = $value['product_id'];
            $row['name'] = $value['name'];
            $yearStart = $dateStart[0];
            $monthStart = $dateStart[1];
            for ($i = 0; $i < $gapMonth; $i++) {
                $row[$yearStart . '-' . $monthStart] = 0;
                $row_data[$yearStart . '-' . $monthStart] = 0;
                foreach ($salesData as $val) {
                    $date = explode("-", $val['month']);
                    $year = $date[0];
                    $month = $date[1];
                    if ($value['product_id'] == $val['product_id'] && $monthStart == $month && $yearStart == $year) {
                        $row[$val['month']] = $val['qty'];
                        // $row_data[$val['month']] = $val['qty'];
                    }
                }
                list($mem_num) = sscanf($monthStart, "%[0-9]");
                list($mem_year) = sscanf($yearStart, "%[0-9]");
                if ($mem_num == '12') {
                    $mem_num = '01';
                    $mem_year += 1;
                } else {
                    $mem_num += 1;
                }
                $monthStart =  str_pad($mem_num, 2, '0', STR_PAD_LEFT);
                $yearStart =  str_pad($mem_year, 2, '0', STR_PAD_LEFT);
            }
            array_push($data, $row);
            // array_push($this->product, $row_data);
        }
        return $data;
    }

    //random bobot
    public function RandomBobot($data)
    {
        $bobot = [];
        foreach ($data as $key => $value) {
            for ($j = 0; $j < count($data[$key]); $j++) {
                $bobot[$key][$j] = rand(0, 100) / 100;
            }
        }
        return $bobot;
    }
    public function getOnlyData($start_month, $end_month, $data_range = null)
    {
        $salesData = $this->M_product_sold->getSalesData($start_month, $end_month);
        $dateStart = explode("-", $start_month);
        $dateEnd = explode("-", $end_month);
        $yearStart = $dateStart[0];
        $yearEnd = $dateEnd[0];
        $monthStart = $dateStart[1];
        $monthEnd = $dateEnd[1];
        $gapMonth = (($yearEnd - $yearStart) * 12) + ($monthEnd - $monthStart);
        if ($data_range == null) {
            $getDataGroupId = $this->M_product_sold->getAllProductSales($start_month, $end_month);
        } else {
            $getDataGroupId = $data_range;
        }
        $data = [];
        foreach ($getDataGroupId as $key => $value) {
            $row = [];
            $yearStart = $dateStart[0];
            $monthStart = $dateStart[1];
            for ($i = 0; $i < $gapMonth; $i++) {
                $row[$yearStart . '-' . $monthStart] = 0;
                $row_data[$yearStart . '-' . $monthStart] = 0;
                foreach ($salesData as $val) {
                    $date = explode("-", $val['month']);
                    $year = $date[0];
                    $month = $date[1];
                    if ($value['product_id'] == $val['product_id'] && $monthStart == $month && $yearStart == $year) {
                        $row[$val['month']] = $val['qty'];
                    }
                }
                list($mem_num) = sscanf($monthStart, "%[0-9]");
                list($mem_year) = sscanf($yearStart, "%[0-9]");
                if ($mem_num == '12') {
                    $mem_num = '01';
                    $mem_year += 1;
                } else {
                    $mem_num += 1;
                }
                $monthStart =  str_pad($mem_num, 2, '0', STR_PAD_LEFT);
                $yearStart =  str_pad($mem_year, 2, '0', STR_PAD_LEFT);
            }
            array_push($data, $row);
        }
        return $data;
    }

    public function Normalisasi($data)
    {
        $dataRest = [];
        $maxRest = array();
        $minP = [];
        $maxP = [];
        // dd($data);
        foreach ($data as $key => $value) {
            $rest[$key] = [];
            foreach ($value as $i => $val) {

                array_push($rest[$key], intval($val));
            }
            array_push($dataRest, $rest[$key]);
        }
        $dataChangeRowColumn = [];
        foreach ($dataRest as $key => $value) {
            foreach ($value as $i => $val) {
                $dataChangeRowColumn[$i][$key] =  $dataRest[$key][$i];
            }
        }
        //get min and max
        foreach ($dataChangeRowColumn as $key => $value) {
            $minP[$key] = min($dataChangeRowColumn[$key]);
            $maxP[$key] = max($dataChangeRowColumn[$key]);
        }
        //normalisasi 
        $newMin = 0;
        $newMax = 1;
        // dd($maxRest);
        $dataNormalisasi = [];
        foreach ($dataRest as $key => $value) {
            foreach ($value as $i => $val) {
                $dataNormalisasi[$key][$i] = (($dataRest[$key][$i] - $minP[$i]) / ($maxP[$i] - $minP[$i]) * ($newMax - $newMin)) + $newMin;
            }
        }

        return $dataNormalisasi;
    }
}