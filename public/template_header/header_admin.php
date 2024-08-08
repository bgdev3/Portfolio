                                            <!-- Menu admin -->

<nav class="nav_admin">
    <ul class="nav-header">
      <li class="under_menu"><a href="">Admin : <?php echo $_SESSION['username_admin']; ?></a>
            <ul class="hide_nav" >
                <li><a href="index.php?controller=admin&action=register&token=<?php echo trim($_SESSION['token']); ?>"">Nouvel Ids</a></li>
                <li><a href="index.php?controller=admin&action=logOut&token=<?php echo trim($_SESSION['token']); ?>">Déconnexion</a></li>
            </ul>
        </li>
    </ul>
</nav>