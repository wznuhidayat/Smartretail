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
                        <h4>Data Product</h4>
                        <div class="card-header-action">
                            <a href="<?= base_url() ?>/main/product/create"
                                class="btn btn-icon icon-left btn-primary"><i class="fa fa-plus-circle"></i> Add</a>
                        </div>
                    </div>
                    <?= $this->include('massage') ?>
                    <div class="card-body">
                        <div class="table-responsive">
                            <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                            <table class="table table-striped" id="product-table">
                                <?= csrf_field() ?>
                                <thead>
                                    <tr>
                                        <th class="text-center">
                                            No
                                        </th>
                                        <th>ID Product</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Qty</th>
                                        <th>Price</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <?php $request = \Config\Services::request(); ?>
                                <?php //dd($request->uri->getSegment(2)) 
                                ?>
                                <tbody id="<?= $request->uri->getSegment(2); ?>">

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