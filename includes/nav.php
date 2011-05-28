<ul id="nav">
    <li><a href="/admin/">CMS Home</a></li>
    <li><a href="/admin/users.php">Users</a></li>
    <li><a href="/pagebuilder/">Content</a></li>
    <li><a href="/blogadmin/">Blog</a></li>
    <?php
        if(file_exists('modules/news/news.class.php')) {
            require_once('modules/news/news.class.php');
            if(class_exists('news')) {
                echo '<li><a href="/admin/news.php">News</a></li>';
            }
        }
    ?>
    <?php
        if(file_exists('modules/random_members/random_members.class.php')) {
            require_once('modules/random_members/random_members.class.php');
            if(class_exists('Random_Members')) {
                echo '<li><a href="/admin/members.php">Members</a></li>';
            }
        }
    ?>
    <li><a href="/admin/login.php?do=logout">Logout</a></li>
</ul>