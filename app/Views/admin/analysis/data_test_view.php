<?= $this->extend('template_admin') ?>

<?= $this->section('content') ?>
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Data Testing</h1>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Data Testing</h4>

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
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <?php $request = \Config\Services::request(); ?>
                                <tbody id="<?= $request->uri->getSegment(2); ?>">
                                    <?php $i = 1 ?>
                                    <?php foreach ($test as $tests) : ?>
                                        <tr id="<?php echo $tests['id_product_test']; ?>">
                                            <td>
                                                <?= $i++; ?>
                                            </td>
                                            <td><?= $tests["product_id"] ?></td>
                                            <td><?= $tests["x1"] ?></td>
                                            <td><?= $tests["x2"] ?></td>
                                            <td><?= $tests["x3"] ?></td>
                                            <td><?= $tests["x4"] ?></td>
                                            <td><?= $tests["x5"] ?></td>
                                            <td><?= $tests["x6"] ?></td>
                                            <td>
                                                <form action="/main/analysis/delete/<?= $tests['id_product_test']; ?>" class="d-inline" method="post">
                                                    <?= csrf_field(); ?>
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button type="button" class="btn btn-danger btn-sm rm">Delete</button>
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