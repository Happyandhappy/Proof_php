<div class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapibleMenu">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="?page=posting" class="navbar-brand">POC</a>
        </div>
        <div class="collapse navbar-collapse" id="collapibleMenu">
            <ul class="nav navbar-nav navbar-right">
                <li
                    class="<?php if (!isset($_GET['page']) || isset($_GET['page']) && $_GET['page'] != 'listing') {
    echo 'active';
}
?>">
                    <a href="?page=posting">Home</a>
                </li>
                <li class="<?php if (isset($_GET['page']) and $_GET['page'] == 'listing') {
    echo 'active';
}
?>">
                    <a href="?page=listing">Listing</a>
                </li>
                <li>
                    <a href="api.php">Api</a>
                </li>
                <li>
                    <a href="logout.php">
                        <strong>
                            <?php echo ucfirst($_SESSION['username']); ?>
                        </strong>
                        Log Out</a>
                </li>
            </ul>
        </div>
    </div>
</div>