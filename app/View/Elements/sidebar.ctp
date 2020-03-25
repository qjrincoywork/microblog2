<aside class="menu-sidebar d-none d-lg-block border">
    <div class="menu-sidebar__content js-scrollbar1">
        <div class="profile-sidebar">
            <div class="image">
                <img src='/img/<?= ($this->Session->read('UserProfile')['gender'] == 1) ? "default_avatar_m.svg" : "default_avatar_f.svg" ?>' />
            </div>
        </div>
        <nav class="navbar-sidebar" id="navbar-sidebar">
            <ul class="list-unstyled navbar__list">
                <li <?= $this->here == '/users/dashboard' ? 'class="active"' : '' ?>>
                    <a href="<?= $this->Html->url('/users/dashboard')?>">
                        <i class="fas fa-tachometer-alt"></i> Home </a>
                </li>
                <li <?= $this->here == '/users/profiile' ? 'class="active"' : '' ?>>
                    <a class="js-arrow" href="#">
                        <i class="fas fa-tasks"></i> Profile </a>

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