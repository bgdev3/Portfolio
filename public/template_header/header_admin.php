                                            <!-- Menu admin -->

<nav class="nav_admin">
    <ul class="nav-header">
      <li class="under_menu"><a href="">Admin : <?php echo $_SESSION['username_admin']; ?></a>
            <ul class="hide_nav" >
                <li><a href="/public/admin/register/<?php echo trim($_SESSION['token']); ?>"">Nouvel Ids</a></li>
                <li><a href="/public/admin/logOut/<?php echo trim($_SESSION['token']); ?>">Déconnexion</a></li>
            </ul>
        </li>
    </ul>
</nav>