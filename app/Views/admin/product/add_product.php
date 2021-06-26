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
                        <h4>Add Seller</h4>
                    </div>
                    <div class="card-body">
                        <form action="/main/product/save" method="post" enctype="multipart/form-data">
                            <?= csrf_field(); ?>
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control <?= ($validation->hasError('name')) ? 'is-invalid' : '' ?>" name="name" value="<?= old('name'); ?>">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('name'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>QTY</label>
                                <input type="number" class="form-control <?= ($validation->hasError('qty')) ? 'is-invalid' : '' ?>" name="qty" value="<?= old('qty'); ?>">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('qty'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Price</label>
                                <input type="text" class="form-control <?= ($validation->hasError('price')) ? 'is-invalid' : '' ?>" name="price" value="<?= old('price'); ?>">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('price'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Discount</label>
                                <input type="text" class="form-control <?= ($validation->hasError('discount')) ? 'is-invalid' : '' ?>" name="discount" value="<?= old('discount'); ?>">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('discount'); ?>
                                </div>
                            </div>
                           
                            <div class="form-group">
                                <label>Desctiption</label>
                                <textarea class="form-control" required="" cols="4" name="Desctiption"></textarea>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('Desctiption'); ?>
                                </div>
                            </div>
                            <div>
                                <!-- <div class="form-group form-float">
                                    <div class="col-xs-6 col-md-3">
                                        <a href="javascript:void(0);" class="thumbnail">
                                            <img src="/img/seller/default.png" class="img-responsive img-preview" alt="" width="100">
                                        </a>
                                    </div>
                                    <div class="form-line <?= ($validation->hasError('image')) ? 'error' : '' ?>">
                                        <input type="file" name="image" class="form-control" id="image" onchange="previewImg()">
                                        <label class="form-label" for="image"></label>
                                        <label id="minmaxlength-error" class="error"><?= $validation->getError('image'); ?></label>
                                    </div>
                                </div> -->

                                <button class="btn btn-primary" type="submit">Submit</button>
                            </div>
                        </form>
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