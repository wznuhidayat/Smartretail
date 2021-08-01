<?= $this->extend('template_admin') ?>

<?= $this->section('content') ?>
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Product</h1>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit Product</h4>
                    </div>

                    <div class="card-body">
                        <form action="/main/product/update/<?= $product['id_product']; ?>" method="post" enctype="multipart/form-data">
                            <?= csrf_field(); ?>
                            <div class="form-group">
                                <label>Name</label>
                                <input type="hidden" name="id" value="<?= $product['id_product']; ?>">
                                <input type="text" class="form-control <?= ($validation->hasError('name')) ? 'is-invalid' : '' ?>" name="name" value="<?= $product['name']; ?>">
                                <div class=" invalid-feedback">
                                    <?= $validation->getError('name'); ?>
                                </div>
                            </div>
                            <div class="form-group form-float">
                                <label for="">Category</label>
                                <?= form_dropdown('id_category', $category, $selected, ['class' => 'form-control show-tick', 'required' => 'required']) ?>

                            </div>
                            <div class="form-group">
                                <label>QTY</label>
                                <input type="number" class="form-control <?= ($validation->hasError('qty')) ? 'is-invalid' : '' ?>" name="qty" value="<?= $product['qty']; ?>">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('qty'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Price</label>
                                <input type="text" class="form-control <?= ($validation->hasError('price')) ? 'is-invalid' : '' ?>" name="price" value="<?= $product['price']; ?>">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('price'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Discount</label>
                                <input type="text" class="form-control <?= ($validation->hasError('discount')) ? 'is-invalid' : '' ?>" name="discount" value="<?= $product['discount']; ?>">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('discount'); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>description</label>
                                <textarea class="form-control" required="" cols="4" data-height="150" style="height: 150px;" name="description"><?= $product['description']; ?></textarea>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('description'); ?>
                                </div>
                            </div>
                            <div>
                                <div>
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