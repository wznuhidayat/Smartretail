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
            <h4>Edit Seller</h4>
          </div>
          
          <div class="card-body">
            <form action="/main/seller/update/<?= $seller['id_seller']; ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field(); ?>
              <div class="form-group">
                <label>Name</label>
                <input type="hidden" name="id" value="<?= $seller['id_seller']; ?>">
                <input type="hidden" name="oldimg" value="<?= $seller['img'] ?>">
                <input type="text" class="form-control <?= ($validation->hasError('name')) ? 'is-invalid' : '' ?>" name="name" value="<?= $seller['name']; ?>"">
                <div class="invalid-feedback">
                  <?= $validation->getError('name'); ?>
                </div>
              </div>
              <div class="form-group">
                <div class="form-group">
                  <label>Email</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <div class="input-group-text">
                        <i class="fas fa-at"></i>
                      </div>
                    </div>
                    <input type="text" class="form-control phone-number <?= ($validation->hasError('email')) ? 'is-invalid' : '' ?>" name="email" value="<?= $seller['email']; ?>">
                    <div class="invalid-feedback">
                      <?= $validation->getError('email'); ?>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label>Phone Number (US Format)</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <div class="input-group-text">
                        <i class="fas fa-phone"></i>
                      </div>
                    </div>
                    <input type="text" class="form-control phone-number <?= ($validation->hasError('phone')) ? 'is-invalid' : '' ?>" name="phone" value="<?= $seller['phone']; ?>">
                    <div class="invalid-feedback">
                      <?= $validation->getError('phone'); ?>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="gender">Gender</label>
                  <select name="gender" id="gender" class="form-control" required>
                    <option value="">- select -</option>
                    <option value="male" <?php echo ($seller['gender'] == "male" ? 'selected="selected "' : ''); ?>>Male</option>
                    <option value="female" <?php echo ($seller['gender'] == "female" ? 'selected="selected "' : ''); ?>>Female</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Password</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <div class="input-group-text">
                        <i class="fas fa-lock"></i>
                      </div>
                    </div>
                    <input type="password" class="form-control <?= ($validation->hasError('passconf')) ? 'is-invalid' : '' ?>" name="password">
                    <div class="invalid-feedback">
                      <?= $validation->getError('password'); ?>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label>Password Confirmation</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <div class="input-group-text">
                        <i class="fas fa-lock"></i>
                      </div>
                    </div>
                    <input type="password" class="form-control <?= ($validation->hasError('passconf')) ? 'is-invalid' : '' ?>" name="passconf" >
                    <div class="invalid-feedback">
                      <?= $validation->getError('passconf'); ?>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label>Address</label>
                  <textarea class="form-control" required="" cols="4" data-height="150" style="height: 150px;" name="address"><?= $seller['address']; ?></textarea>
                  <div class="invalid-feedback">
                    <?= $validation->getError('address'); ?>
                  </div>
                </div>
                <div class="form-group form-float">
                  <div class="col-xs-6 col-md-3">
                    <a href="javascript:void(0);" class="thumbnail">
                      <img src="/img/seller/<?= $seller['img']; ?>" class="img-responsive img-preview" alt="" width="100">
                    </a>
                  </div>
                  <div class="form-line <?= ($validation->hasError('image')) ? 'error' : '' ?>">
                    <input type="file" name="image" class="form-control" id="image" onchange="previewImg()">
                    <label class="form-label" for="image"></label>
                    <label id="minmaxlength-error" class="error"><?= $validation->getError('image'); ?></label>
                  </div>
                </div>
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