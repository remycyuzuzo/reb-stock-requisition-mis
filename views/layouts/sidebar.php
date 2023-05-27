<!-- Main Sidebar Container -->
<?php global $permissions; ?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="<?= STATIC_FOLDER_URL . "/images/logo/REB_Logo.png" ?>" alt="Rwanda Basic Education Logo" class="brand-image p-1 rounded bg-light" style="opacity: .8">
        <span class="brand-text font-weight-light">REB SIMS</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="/" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <?php if (check_permission($permissions['CAN_MAKE_REQUISITION'])) : ?>
                    <li class="nav-item">
                        <a href="<?= url_path('/stock') ?>" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Stock
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= url_path('/stock') ?>" class="nav-link">
                                    <i class="fas fa-list nav-icon"></i>
                                    <p>Stock</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= url_path('/stock/new-stock') ?>" class="nav-link">
                                    <i class="fas fa-list nav-icon"></i>
                                    <p>New stock</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= url_path('/stock/transactions') ?>" class="nav-link">
                                    <i class="fas fa-list nav-icon"></i>
                                    <p>Transactions</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif ?>
                <?php if (check_permission($permissions['CAN_MAKE_REQUISITION']) || check_permission($permissions['CAN_APPROVE_REQUISITION']) || check_permission($permissions['CAN_AUTHORIZE_REQUISITION'])) : ?>
                    <li class="nav-item">
                        <a href="<?= url_path('/requisitions/my-requisitions') ?>" class="nav-link">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                                Requisitions
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <?php if (check_permission($permissions['CAN_MAKE_REQUISITION'])) : ?>
                                <li class="nav-item">
                                    <a href="<?= url_path('/requisitions/my-requisitions') ?>" class="nav-link">
                                        <i class="fas fa-list nav-icon"></i>
                                        <p>
                                            My requisitions
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= url_path('/requisitions/new') ?>" class="nav-link">
                                        <i class="fas fa-list nav-icon"></i>
                                        <p>
                                            New requisition
                                        </p>
                                    </a>
                                </li>
                            <?php endif ?>
                            <?php if (check_permission($permissions['CAN_APPROVE_REQUISITION'])) : ?>
                                <li class="nav-item">
                                    <a href="<?= url_path('/requisitions/a/pending-requisitions') ?>" class="nav-link">
                                        <i class="fas fa-list nav-icon"></i>
                                        <p>
                                            Approve requisitions
                                        </p>
                                    </a>
                                </li>
                            <?php endif ?>
                            <?php if (check_permission($permissions['CAN_AUTHORIZE_REQUISITION'])) : ?>
                                <li class="nav-item">
                                    <a href="<?= url_path('/requisitions/auth/pending-requisitions') ?>" class="nav-link">
                                        <i class="fas fa-list nav-icon"></i>
                                        <p>
                                            Authorize requisitions
                                        </p>
                                    </a>
                                </li>
                            <?php endif ?>
                        </ul>
                    </li>
                <?php endif ?>
                <?php if (check_permission($permissions['CAN_MANAGE_STOCK'])) : ?>
                    <li class="nav-item">
                        <a href="/items" class="nav-link">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                                Items
                            </p>
                        </a>

                    </li>
                <?php endif ?>
                <?php if (check_permission($permissions['CAN_MANAGE_USERS'])) : ?>
                    <li class="nav-item">
                        <a href="<?= url_path('/users') ?>" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Users
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= url_path('/users') ?>" class="nav-link">
                                    <i class="fas fa-list nav-icon"></i>
                                    <p>Users list</p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= url_path('/users/new-user') ?>" class="nav-link">
                                    <i class="fas fa-plus-circle nav-icon"></i>
                                    <p>New user</p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= url_path('/users/roles') ?>" class="nav-link">
                                    <i class="fas fa-code-branch nav-icon"></i>
                                    <p>User roles</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif ?>
                <?php if (check_permission($permissions['CAN_CHANGE_SYSTEM_PARAMS'])) : ?>
                    <li class="nav-item">
                        <a href="<?= url_path('/departments') ?>" class="nav-link">
                            <i class="nav-icon fas fa-pager"></i>
                            <p>
                                Others
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= url_path('/departments') ?>" class="nav-link">
                                    <i class="fas fa-list nav-icon"></i>
                                    <p>Departments</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= url_path('/units') ?>" class="nav-link">
                                    <i class="fas fa-plus-circle nav-icon"></i>
                                    <p>Units</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif ?>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>