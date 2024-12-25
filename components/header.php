<?php
    include_once __DIR__."/../src/helpers.php";

    checkAuth();
    $user = currentUser();
?>

<header class="header">
    <nav>
        <ul>
            <li><a href="/home.php">
                Home
            </a></li>
            <li><a href="/stuff.php">
                Stuff
            </a></li>
        </ul>
    </nav>
    <div class="header__user">
        <h2 class="profile-name">  <?php echo $user['name'] ?> </h2>

        <a href="<?php echo "/user.php?id={$user['id']}" ?>">
        <img class="avatar" src = "<?php echo $user['avatar'] ?>"  alt="<?php echo $user['name'] ?>" >
        </a>

        <form class="logout" method="post" action="/src/actions/logout.php">
            <button role="button">Выйти</button>
        </form>
    </div>
</header>