<?= $this->extend('template_admin') ?>

<?= $this->section('content') ?>
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Dashboard</h1>
        </div>
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
                            <a href="#" class="text-warning"><?= number_format($products['price'],0,',','.') ?></a>
                        </div>
                        <div class="article-title">
                            <h2><a href="#"><?= $products['name']; ?></a></h2>
                        </div>
                        <div class="mt-4">
                            <a href="#" class="btn btn-icon icon-left btn-info"><i class="fas fa-info-circle"></i> Detail</a>
                            <a href="#" class="btn btn-icon icon-left btn-success"><i class="far fa-edit"></i> Add Sold</a>
                        </div>
                    </div>
                </article>
            </div>
        <?php endforeach ?>
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