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
                        <?php foreach ($img as $imgs => $images) : ?>
                            <?php if ($images['product_id'] == $products['id_product']) { ?>
                                <div class="article-header">
                                    <div class="article-image" data-background="<?= base_url() ?>/img/product/<?= $images['img'] ?>" style="background-image: url(&quot;<?= base_url() ?>/template/assets/img/news/img13.jpg&quot;);">
                                    </div>
                                </div>
                                <?php break; ?>
                            <?php } else { ?>
                                <div class="article-header">
                                    <div class="article-image" data-background="<?= base_url() ?>/template/assets/img/news/img13.jpg" style="background-image: url(&quot;<?= base_url() ?>/template/assets/img/news/img13.jpg&quot;);">
                                    </div>
                                </div>
                                <?php break; ?>
                            <?php } ?>

                        <?php endforeach ?>
                        <div class="article-details">
                            <div class="article-category"><a href="#" class="text-warning">Rp</a>
                                <a href="#" class="text-warning"><?= number_format($products['price'], 0, ',', '.') ?></a>
                            </div>
                            <div class="article-title">
                                <h2><a href="#"><?= $products['name']; ?></a></h2>
                            </div>
                            <div class="mt-4">
                                <a href="/seller/productlist/detail/<?= $products['id_product']; ?>" class="btn btn-icon icon-left btn-info"><i class="fas fa-info-circle"></i> Detail</a>
                                <a id="detail" href="" class="btn btn-icon icon-left btn-success" data-toggle="modal" data-target="#exampleModal" data-img="<?= $images['img'] ?>" data-id="<?= $products['id_product']; ?>" data-name="<?= $products['name']; ?>" data-price="<?= $products['price']; ?>"><i class="far fa-edit"></i> Add Sold</a>
                            </div>
                        </div>
                    </article>
                </div>
            <?php endforeach ?>

        </div>
        <div class="row d-inline">
            <div class="col-12">
                <div class="mx-auto"><?= $pager->links('product', 'product_pagination'); ?></div>
            </div>
        </div>
    </section>
</div>
<form action="/seller/productlist/save" method="post">
<?= csrf_field(); ?>
    <div class="modal fade" tabindex="-1" role="dialog" id="exampleModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Product Sold</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <img src="" alt="" width="130" height="120" id="show_img">
                        <div class="text ml-4">
                            <input type="hidden" id="id_product" name="id_product" >
                            <input type="hidden" id="id_seller" name="id_seller" value="<?= session()->get('id_seller')?>">
                            <a href="" class="text-md-left font-weight-bold d-block mb-2" id="name_product"></a>
                            <a href="" class="text-warning " id="price"></a>
                            <div class="form-group row mt-3">
                                <!-- <label for="" class="form-label">QTY :</label> -->
                                <label for="inputEmail3" class="col-sm-2 col-form-label">QTY</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" name="qty">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label">Note</label>
                        <textarea class="form-control" placeholder="Type your message" data-height="150" style="height: 150px;" name="note"></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save </button>
                </div>
            </div>
        </div>
    </div>
</form>
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