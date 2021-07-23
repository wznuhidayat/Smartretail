<?= $this->extend('template_admin') ?>

<?= $this->section('content') ?>

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Product</h1>

        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Detail Product</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                        <div class="col-12 col-md-6">
                                <div id="carouselExampleIndicators3" class="carousel slide" data-ride="carousel">
                                    <ol class="carousel-indicators">
                                       
                                        <?php foreach($img as $key => $images){
                                                $active = ($key ==0) ? 'active' : '';
                                                echo '<li data-target="#carouselExampleIndicators3" data-slide-to="'.$key.'" class="'.$active.'"></li>';
                                        } ?>
                                    </ol>
                                    <div class="carousel-inner">
                                        
                                        <?php foreach($img as $key => $images){
                                             $active = ($key == 0) ? 'active' : '';
                                             echo '<div class="carousel-item '.$active.'">
                                             <img id="productimg" class="d-block w-100 h-100" src="'.base_url().'/img/product/'.$images['img'].'">
                                         </div>';
                                        } ?>
                                    </div>
                                    <a class="carousel-control-prev" href="#carouselExampleIndicators3" role="button" data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#carouselExampleIndicators3" role="button" data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                
                                <h4><?= $product['product_name']; ?></h4>
                                <h5>Rp <?= number_format($product['price'],0,',','.'); ?></h5>
                                <p class="mt-4 mb-4">Paragraph — Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
                                <div class="text-dark mb-2"><b>QTY : </b> 12</div>
                                <div class="text-secondary mt-3"><b>Created : </b><?= $product['product_created_at']; ?></div>
                                <div class="text-secondary "><b>Updated : </b> <?= $product['updated_at']; ?></div>

                            </div>
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