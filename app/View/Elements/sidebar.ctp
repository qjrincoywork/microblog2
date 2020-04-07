<?php
    $id = $this->Session->read('User')['id'];
?>
<aside class="menu-sidebar d-none d-lg-block border">
    <div class="menu-sidebar__content js-scrollbar1">
        <div class="image microblogLogo">
            <a href="<?= $this->Html->url('/users/dashboard')?>">
                <img src='/img/microbloglogo.png'/>
            </a>
        </div>
        <nav class="navbar-sidebar" id="navbar-sidebar">
            <ul class="list-unstyled navbar__list">
                <li <?= $this->here == '/users/dashboard' ? 'class="active"' : '' ?>>
                    <a href="<?= $this->Html->url('/users/dashboard')?>">
                        <i class="fas fa-home"></i> Home </a>
                </li>
                <li <?= $this->here == "/users/profile/user_id:$id" ? 'class="active"' : '' ?>>
                    <a class="js-arrow" href="<?= $this->Html->url(['controller'=>'users',
                                                                    'action'=>'profile',
                                                                    'user_id'=> $id])?>">
                        <i class="fas fa-address-card"></i> Profile </a>
                        
                    <!-- <ul class="list-unstyled navbar__sub-list js-sub-list">
                        <li {!! $routeName[1] == 'user' ? 'class="active"' : '' !!}>
                            <a href="{{ '/user' }}"> Users</a>
                        </li>
                        <li {!! $routeName[1] == 'schedule' ? 'class="active"' : '' !!}>
                            <a href="{{ '/schedule' }}"> Schedule</a>
                        </li>
                        <li {!! $routeName[1] == 'role' ? 'class="active"' : '' !!}>
                            <a href="{{ '/role' }}">Role</a>
                        </li>
                    </ul> -->
                </li>
            </ul>
        </nav>
    </div>
</aside>