<?= $this->extend('template_admin') ?>

<?= $this->section('content') ?>
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Seller</h1>
            
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Data Seller</h4>
                        <div class="card-header-action">
                            <a href="<?= base_url() ?>/main/seller/create" class="btn btn-icon icon-left btn-primary"><i class="fa fa-plus-circle"></i> Primary</a>
                        </div>
                    </div>
                    <?= $this->include('massage') ?>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr>
                                        <th class="text-center">
                                            No
                                        </th>
                                        <th>Image</th>
                                        <th>ID Seller</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Gender</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <?php $request = \Config\Services::request(); ?>
                                <tbody id="<?= $request->uri->getSegment(2); ?>">
                                    <?php $i=1 ?>
                                    <?php foreach ($seller as $sales) : ?>
                                        <tr id="<?php echo $sales['id_seller']; ?>">
                                            <td>
                                                <?= $i++; ?>
                                            </td>
                                            <td><img src="/img/seller/<?= $sales['img']; ?>" alt="" width="45"></td>
                                            <td><?= $sales["id_seller"] ?></td>
                                            <td><?= $sales["name"] ?></td>
                                            <td><?= $sales["email"] ?></td>
                                            <td><?= $sales["phone"] ?></td>
                                            <td><?= $sales["gender"] ?></td>
                                            <td>
                                                <a href="/main/seller/edit/<?= $sales['id_seller']; ?>" class="btn btn-info btn-sm">Edit</a>
                                                <form action="/main/seller/delete/<?= $sales['id_seller']; ?>" class="d-inline" method="post">
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