<?= $this->extend('template_admin') ?>

<?= $this->section('content') ?>
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Monthly</h1>

        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Simple</h4>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">ID Product</th>
                                    <th scope="col">Name Product</th>
                                    <th scope="col">Jan</th>
                                    <th scope="col">Feb</th>
                                    <th scope="col">Mar</th>
                                    <th scope="col">Apr</th>
                                    <th scope="col">Mei</th>
                                    <th scope="col">Jun</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1 ?>
                                <?php foreach ($monthly_data as $monthly) : ?>
                                    <tr>
                                        <th scope="row"><?= $i++; ?></th>
                                        <td><?= $monthly['product_id']; ?></td>
                                        <td><?= $monthly['name']; ?></td>
                                        <td><?= $monthly['jan'] == null ? 0 : $monthly['jan'] ?></td>
                                        <td><?= $monthly['feb'] == null ? 0 : $monthly['feb'] ?></td>
                                        <td><?= $monthly['mar'] == null ? 0 : $monthly['mar'] ?></td>
                                        <td><?= $monthly['apr'] == null ? 0 : $monthly['apr'] ?></td>
                                        <td><?= $monthly['mei'] == null ? 0 : $monthly['mei'] ?></td>
                                        <td><?= $monthly['jun'] == null ? 0 : $monthly['jun'] ?></td>
                                      
                                        
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Inisalisasi JST Backpropagation</h4>
                    </div>
                    <div class="card-body">
                        <form action="<?= site_url() ?>/main/MetodeJst" method="post">
                            <div class="form-group">
                                <label>Epooch</label>
                                <input type="number" class="form-control" name="epooch">
                            </div>
                            <div class="form-group">
                                <label>learning Rate</label>
                                <input type="text" class="form-control" name="lr">
                            </div>
                            <div class="form-group">
                                <label>Minimum MSE</label>
                                <input type="text" class="form-control" name="mse">
                            </div>
                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Inisalisasi JST Backpropagation</h4>
                    </div>
                    <div class="card-body">
                        
                       <div class="col-md-4">
                           <h4 class="text-dark">Mse : </h4 class="text-dark">
                       </div>
                       <div class="col-md-4"></div>
                       <div class="col-md-4"></div>
                       <div class="col-md-4"></div>
                    </div>
                </div>
            </div>
        </div> -->
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