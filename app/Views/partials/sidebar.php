<?php $request = \Config\Services::request(); ?>
<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html"><span class="font-weight-bold">SMART</span>RETAIL</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">St</a>
        </div>
        <ul class="sidebar-menu">
            <?php if (session()->get('role') == 'admin') { ?>
            <li class="<?= $title == 'Dashboard' ? 'active' : '' ?>">
                <a class="nav-link" href="<?= base_url() ?>/main"><i class="fas fa-fire"></i> <span>Dashboard</span></a>
            </li>
            <?php } ?>
            <?php if (session()->get('role') == 'seller') { ?>
            <li class="<?= $title == 'Dashboard' ? 'active' : '' ?>">
                <a class="nav-link" href="<?= base_url() ?>/seller"><i class="fas fa-fire"></i>
                    <span>Dashboard</span></a>
            </li>
            <?php } ?>
            <li class="menu-header">Product</li>
            <?php if (session()->get('role') == 'admin') { ?>
            <li class="<?= $request->uri->getSegment(2) == 'product' ? 'active' : '' ?>">
                <a class="nav-link" href="<?= base_url() ?>/main/product"><i class="fas fa-box"></i>
                    <span>Product</span></a>
            </li>
            <li class="<?= $request->uri->getSegment(2) == 'sales' ? 'active' : '' ?>">
                <a class="nav-link" href="<?= base_url() ?>/main/sales"><i class="fas fa-clipboard-list"></i>
                    <span>Sales data</span></a>
            </li>
            <li class="<?= $request->uri->getSegment(2) == 'categoryproduct' ? 'active' : '' ?>">
                <a class="nav-link" href="<?= base_url() ?>/main/categoryproduct"><i class="fas fa-list-alt"></i>
                    <span>Category Product</span></a>
            </li>
            <li class="<?= $request->uri->getSegment(2) == 'monthly' ? 'active' : '' ?>">
                <a class="nav-link" href="<?= base_url() ?>/main/monthly"><i class="fas fa-clipboard-list"></i>
                    <span>Monthly Data</span></a>
            </li>
            <li class="nav-item dropdown <?= $request->uri->getSegment(2) == 'analysis' ? 'active' : '' ?>">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-chart-line"></i>
                    <span>Analysis</span></a>
                <ul class="dropdown-menu">
                    <li
                        class="<?= $request->uri->getTotalSegments() >= 2 && $request->uri->getSegment(3) == 'ann' ? 'active' : '' ?>">
                        <a class="nav-link" href="<?= base_url() ?>/main/analysis/ann">Neural Network</a>
                    </li>
                    <li
                        class="<?= $request->uri->getTotalSegments() >= 2 && $request->uri->getSegment(3) == 'datatest' ? 'active' : '' ?>">
                        <a class="nav-link" href="<?= base_url() ?>/main/analysis/datatest">Data Testing</a>
                    </li>
                </ul>
            </li>
            <?php } ?>
            <?php if (session()->get('role') == 'admin') { ?>
            <li class="<?= $title == 'salesdata' ? 'active' : '' ?>">
                <a class="nav-link" href="<?= base_url() ?>/main/salesdata"><i class="fas fa-chart-bar"></i>
                    <span>Sales
                        data</span></a>
            </li>
            <?php } ?>
            <?php if (session()->get('role') == 'seller') { ?>
            <li class="<?= $request->uri->getSegment(2) == 'productlist' ? 'active' : '' ?>">
                <a class="nav-link" href="<?= base_url() ?>/seller/productlist"><i class="fas fa-box"></i> <span>List
                        Product</span></a>
            </li>
            <li class="<?= $request->uri->getSegment(2) == 'sold' ? 'active' : '' ?>">
                <a class="nav-link" href="<?= base_url() ?>/seller/sold/<?= session()->get('id_seller') ?>"><i
                        class="fas fa-exchange-alt"></i> <span>Products Sold</span></a>
            </li>
            <?php } ?>
            <?php if (session()->get('role') == 'admin') { ?>
            <li class="menu-header">Member</li>
            <li class="<?= $request->uri->getSegment(2) == 'seller' ? 'active' : '' ?>">
                <a class="nav-link" href="<?= base_url() ?>/main/seller"><i class="fas fa-user"></i>
                    <span>Seller</span></a>
            </li>
            <li class="<?= $request->uri->getSegment(2) == 'admin' ? 'active' : '' ?>">
                <a class="nav-link" href="<?= base_url() ?>/main/admin"><i class="fas fa-user"></i>
                    <span>Admin</span></a>
            </li>
            <?php } ?>

    </aside>
</div>