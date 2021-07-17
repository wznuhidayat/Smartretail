<?= $this->extend('template_admin') ?>

<?= $this->section('content') ?>
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Category Product</h1>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Data Category Product</h4>
                        <div class="card-header-action">
                            <a href="<?= base_url() ?>/main/categoryproduct/create" class="btn btn-icon icon-left btn-primary"><i class="fa fa-plus-circle"></i> Add</a>
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
                                        <th>ID Admin</th>
                                        <th>Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <?php $request = \Config\Services::request(); ?>
                                <tbody id="<?= $request->uri->getSegment(2); ?>">
                                    <?php $i=1 ?>
                                    <?php foreach ($cat_product as $category) : ?>
                                        <tr id="<?php echo $category['id_category']; ?>">
                                            <td>
                                                <?= $i++; ?>
                                            </td>
                                            <td><?= $category["id_category"] ?></td>
                                            <td><?= $category["name"] ?></td>
                                            <td>
                                                <a href="/main/categoryproduct/edit/<?= $category['id_category']; ?>" class="btn btn-info btn-sm">Edit</a>
                                                <form action="/main/categoryproduct/delete/<?= $category['id_category']; ?>" class="d-inline" method="post">
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