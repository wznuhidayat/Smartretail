<?= $this->extend('template_admin') ?>
<?= $this->section('content') ?>
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Monthly</h1>

        </div>
        <div class="row">

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Data Monthly</h4>

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
                                        <th>Jan</th>
                                        <th>Feb</th>
                                        <th>Mar</th>
                                        <th>Apr</th>
                                        <th>Mei</th>
                                        <th>Jun</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1 ?>
                                    <?php foreach ($product as $products) : ?>
                                        <tr>
                                            <th scope="row"><?= $i++; ?></th>
                                            <td><?= $products[0]; ?></td>
                                            <td><?= $products[1] == null ? 0 : $products[1] ?></td>
                                            <td><?= $products[2] == null ? 0 : $products[2] ?></td>
                                            <td><?= $products[3] == null ? 0 : $products[3] ?></td>
                                            <td><?= $products[4] == null ? 0 : $products[4] ?></td>
                                            <td><?= $products[5] == null ? 0 : $products[5] ?></td>
                                            <td><?= $products[6] == null ? 0 : $products[6] ?></td>


                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Bobot V</h4>

                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">v1</th>
                                    <th scope="col">v2</th>
                                    <th scope="col">v3</th>
                                    <th scope="col">v4</th>
                                    <th scope="col">v5</th>
                                    <th scope="col">v6</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php for ($j = 0; $j < count($bobotv); $j++) { ?>
                                    <tr>
                                            <?php for ($i = 0; $i < count($bobotv[$j]); $i++) { ?>
                                            <td><?= $bobotv[$j][$i]; ?></td>


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

            <div class="col-4">
                <div class="card">
                    <div class="card-header">
                        <h4>Bobot W</h4>

                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Bobot w</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php for ($i = 0; $i < count($bobotw); $i++) { ?>
                                    <tr>
                                        <td><?= $bobotw[$i]; ?></td>
                                    </tr>
                                <?php  }  ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card">
                    <div class="card-header">
                        <h4>Bias V</h4>

                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Bias V</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php for ($i = 0; $i < count($bobotbiasv); $i++) { ?>
                                    <tr>
                                        <td><?= $bobotbiasv[$i]; ?></td>
                                    </tr>
                                <?php  }  ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card">
                    <div class="card-header">
                        <h4>Bias W</h4>

                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Bias W</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php for ($i = 0; $i < count($bobotbiasw); $i++) { ?>
                                    <tr>
                                        <td><?= $bobotbiasw[$i]; ?></td>
                                    </tr>
                                <?php  }  ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-12">
                <div class="card pb-4">
                    <p class="text-center mt-4">Lakukan refresh pada browser untuk mendapatkan bobot v dan bobot w yang baru</p>
                    <div class="mx-auto">
                        <form action="/main/analysis/learning" method="post">
                            <?= csrf_field(); ?>
                            
                            <?php for ($i = 0; $i < count($bobotw); $i++) { ?>
                                <input type="hidden" name="bobotw[]" value="<?= $bobotw[$i] ?>">
                            <?php } ?>
                            <?php for ($i = 0; $i < count($bobotbiasv); $i++) { ?>
                                <input type="hidden" name="bobotbiasv[]" value="<?= $bobotbiasv[$i] ?>">
                            <?php } ?>
                            <?php for ($i = 0; $i < count($bobotbiasw); $i++) { ?>
                                <input type="hidden" name="bobotbiasw[]" value="<?= $bobotbiasw[$i] ?>">
                            <?php } ?>
                            <?php for ($i = 0; $i < count($bobotv); $i++) { ?>
                                <?php for ($j = 0; $j < count($bobotv); $j++) { ?>
                                    <input type="hidden" name="bobotv[<?= $i ?>][]" value="<?= $bobotv[$i][$j] ?>">
                                <?php } ?>
                            <?php } ?>
                            <input type="hidden" name="mse" value="<?= $mse ?>">
                            <input type="hidden" name="epoch" value="<?= $epoch ?>">
                            <input type="hidden" name="lr" value="<?= $learningrate ?>">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-chart-line"></i> Learning</button>
                        </form>
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