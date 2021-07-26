<?= $this->extend('template_admin') ?>
<?= $this->section('content') ?>
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>List Product</h1>
        </div>
        <?= form_open(); ?>
        <div class="input-group mb-3">
            <input type="text" name="keyword" class="form-control" placeholder="Search" aria-label="">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">Button</button>
            </div>
        </div>
        <?= form_close(); ?>
        <div class="row">
            <?php foreach ($product as $products) : ?>
                        <div class="col-12 col-md-3 col-lg-3">
                        <article class="article article-style-c">
                            <div class="article-header">
                                <div class="article-image" data-background="<?= base_url() ?>/template/assets/img/news/img13.jpg" style="background-image: url(&quot;<?= base_url() ?>/template/assets/img/news/img13.jpg&quot;);">
                                </div>
                            </div>
                            <div class="article-details">
                                <div class="article-category"><a href="#" class="text-warning">Rp</a>
                                    <a href="#" class="text-warning"><?= number_format($products['price'], 0, ',', '.') ?></a>
                                </div>
                                <div class="article-title">
                                    <h2><a href="#"><?= $products['name']; ?></a></h2>
                                </div>
                                <div class="mt-4">
                                    <a href="/seller/productlist/detail/<?= $products['id_product']; ?>" class="btn btn-icon icon-left btn-info"><i class="fas fa-info-circle"></i> Detail</a>
                                    <a href="" class="btn btn-icon icon-left btn-success" data-toggle="modal" data-target="#exampleModal"><i class="far fa-edit"></i> Add Sold</a>
                                </div>
                            </div>
                        </article>
                    </div>
            <?php endforeach ?>

        </div>
        <div class="row d-inline">
            <div class="col-12"></div>
            <?= $pager->links('product', 'product_pagination'); ?>
        </div>
    </section>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="exampleModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Modal body text goes here.</p>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
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