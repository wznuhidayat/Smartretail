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
                            <a href="<?= base_url() ?>/main/admin/create" class="btn btn-icon icon-left btn-primary"><i class="fa fa-plus-circle"></i> Primary</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr>
                                        <th class="text-center">
                                            No
                                        </th>
                                        <th>Image</th>
                                        <th>ID Admin</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Gender</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=1 ?>
                                    <?php foreach ($admin as $adm) : ?>
                                        <tr>
                                            <td>
                                                <?= $i++; ?>
                                            </td>
                                            <td><img src="/img/admin/<?= $adm['img']; ?>" alt="" width="45"></td>
                                            <td><?= $adm["id_admin"] ?></td>
                                            <td><?= $adm["name"] ?></td>
                                            <td><?= $adm["email"] ?></td>
                                            <td><?= $adm["phone"] ?></td>
                                            <td><?= $adm["gender"] ?></td>
                                            <td>
                                                <a href="/main/admin/edit/<?= $adm['id_admin']; ?>" class="btn btn-info btn-sm">Edit</a>
                                                <form action="/main/admin/delete/<?= $adm['id_admin']; ?>" class="d-inline" method="post">
                                                    <?= csrf_field(); ?>
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
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
        Copyright &copy; 2018 <div class="bullet"></div> Design By <a href="https://nauval.in/">Muhamad Nauval Azhar</a>
    </div>
    <div class="footer-right">
        2.3.0
    </div>
</footer>
</div>
</div>
<?= $this->endSection() ?>