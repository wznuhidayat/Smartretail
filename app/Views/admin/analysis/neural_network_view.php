<?= $this->extend('template_admin') ?>

<?= $this->section('content') ?>
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1 id="title">Monthly</h1>

        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h4>Configure Neural Network</h4>
                    </div>

                    <div class="card-body">
                        <form class=".form-save-month-range" id="form-save-month-range">
                            <input type="hidden" class="txt_csrfname" name="<?= csrf_token() ?>"
                                value="<?= csrf_hash() ?>" />
                            <div class="form-group">
                                <label>Select Month Range</label>
                                <div class="row">
                                    <div class="col-6">
                                        <input type="month" name="startMonth" class="form-control range-date-picker">
                                    </div>
                                    <div class="col-6"><input type="month" name="endMonth"
                                            class="form-control range-date-picker"></div>
                                </div>
                            </div>
                            <div class="text-right">
                                <button type="button" class="btn btn-icon icon-left btn-info btn-rounded"
                                    id="find">Find</button>
                            </div>
                        </form>

                        <form action="/main/analysis/resultann" method="post">
                            <?= csrf_field(); ?>
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
            <div class="col-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Data Monthly</h4>
                        <div class="card-header-action">
                            <a href="<?= base_url() ?>/main/admin/create" class="btn btn-icon icon-left btn-primary"><i
                                    class="fa fa-chart-line"></i> Prediction</a>
                        </div>
                    </div>
                    <?= $this->include('massage') ?>
                    <div id="delete"></div>
                    <div class="card-body">
                        <div class="table-responsive" id="table-month-wrapper">
                            <table class="table table-striped" id="select-month-range">

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
<script>

</script>
<?= $this->endSection() ?>