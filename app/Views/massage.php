<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success alert-dismissible show fade">
        <div class="alert-body">
            <button class="close" data-dismiss="alert">
                <span>×</span>
            </button>
            <?= session()->getFlashdata('success'); ?>
        </div>
    </div>
<?php endif; ?>
    <div id="del" class="alert alert-danger alert-dismissible show fade">
        <div class="alert-body">
            <button class="close" data-dismiss="alert">
                <span>×</span>
            </button>
            Data deleted!
        </div>
    </div>
<?php if (session()->getFlashdata('edited')) : ?>
    <div class="alert alert-info alert-dismissible show fade">
        <div class="alert-body">
            <button class="close" data-dismiss="alert">
                <span>×</span>
            </button>
            <?= session()->getFlashdata('edited'); ?>
        </div>
    </div>
<?php endif; ?>