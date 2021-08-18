<?= $this->extend('template_admin') ?>

<?= $this->section('content') ?>
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Monthly</h1>

        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h4>Configure Neural Network</h4>
                    </div>
                    <div class="card-body">
                        <form action="/main/analysis/resultann" method="post">
                        <?= csrf_field(); ?>
                                <div class="form-group">
                                    <label>Epooch</label>
                                    <input type="number" class="form-control" name="epooch">
                                </div>
                                <div class="form-group">
                                    <label>learning Rate</label>
                                    <input type="text" class="form-control" name="lr">
                                </div>
                                <div class="form-group">
                                    <label>Minimum MSE</label>
                                    <input type="text" class="form-control" name="mse">
                                </div>
                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        
                    </div>
                </div>
            </div>
            <div class="col-8">
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
                                    <?php foreach ($monthly_data as $monthly) : ?>
                                        <tr>
                                            <th scope="row"><?= $i++; ?></th>
                                            <td><?= $monthly['product_id']; ?></td>
                                            <td><?= $monthly['jan'] == null ? 0 : $monthly['jan'] ?></td>
                                            <td><?= $monthly['feb'] == null ? 0 : $monthly['feb'] ?></td>
                                            <td><?= $monthly['mar'] == null ? 0 : $monthly['mar'] ?></td>
                                            <td><?= $monthly['apr'] == null ? 0 : $monthly['apr'] ?></td>
                                            <td><?= $monthly['mei'] == null ? 0 : $monthly['mei'] ?></td>
                                            <td><?= $monthly['jun'] == null ? 0 : $monthly['jun'] ?></td>


                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
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