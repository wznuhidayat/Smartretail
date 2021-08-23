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
                        <div class="card-header-action">
                            <a href="<?= base_url() ?>/main/admin/create" class="btn btn-icon icon-left btn-primary"><i class="fa fa-chart-line"></i> Prediction</a>
                        </div>
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
                                        <th>Name</th>
                                        <th>Jan</th>
                                        <th>Feb</th>
                                        <th>Mar</th>
                                        <th>Apr</th>
                                        <th>Mei</th>
                                        <th>Jun</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1 ?>
                                    <?php foreach ($monthly_data as $monthly) : ?>
                                        <tr>
                                            <th scope="row"><?= $i++; ?></th>
                                            <td><?= $monthly['product_id']; ?></td>
                                            <td><?= $monthly['name']; ?></td>
                                            <td><?= $monthly['jan'] == null ? 0 : $monthly['jan'] ?></td>
                                            <td><?= $monthly['feb'] == null ? 0 : $monthly['feb'] ?></td>
                                            <td><?= $monthly['mar'] == null ? 0 : $monthly['mar'] ?></td>
                                            <td><?= $monthly['apr'] == null ? 0 : $monthly['apr'] ?></td>
                                            <td><?= $monthly['mei'] == null ? 0 : $monthly['mei'] ?></td>
                                            <td><?= $monthly['jun'] == null ? 0 : $monthly['jun'] ?></td>
                                            <td>
                                                <!-- <a href="#" class="btn btn-info btn-sm">Add Target</a> -->
                                                <form action="/main/monthly/target" class="d-inline" method="post">
                                                <?= csrf_field(); ?>
                                                    <input type="hidden" name="product_id" value="<?= $monthly['product_id']; ?>">
                                                    <input type="hidden" name="x1" value="<?= $monthly['jan'] == null ? 0 : $monthly['jan'] ?>">
                                                    <input type="hidden" name="x2" value="<?= $monthly['feb'] == null ? 0 : $monthly['feb'] ?>">
                                                    <input type="hidden" name="x3" value="<?= $monthly['mar'] == null ? 0 : $monthly['mar'] ?>">
                                                    <input type="hidden" name="x4" value="<?= $monthly['apr'] == null ? 0 : $monthly['apr'] ?>">
                                                    <input type="hidden" name="x5" value="<?= $monthly['mei'] == null ? 0 : $monthly['mei'] ?>">
                                                    <input type="hidden" name="x6" value="<?= $monthly['jun'] == null ? 0 : $monthly['jun'] ?>">
                                                    <button type="submit" class="btn btn-info btn-sm">Add Test</button>
                                                </form>
                                            </td>

                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Inisalisasi JST Backpropagation</h4>
                    </div>
                    <div class="card-body">
                        
                       <div class="col-md-4">
                           <h4 class="text-dark">Mse : </h4 class="text-dark">
                       </div>
                       <div class="col-md-4"></div>
                       <div class="col-md-4"></div>
                       <div class="col-md-4"></div>
                    </div>
                </div>
            </div>
        </div> -->
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