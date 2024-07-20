

<?php
    if (! isset($_SESSION['USER'])) {
        require_once INCLUDES . 'start.body.php';
        require_once INCLUDES . 'header.php';
        echo '<main class="w-full h-fit min-h-dvh">';
        require_once VIEWS . 'addUserTemplate.view.php';
        echo '</main>';
        require_once INCLUDES . 'elements.php';
        require_once INCLUDES . 'errors.php';
        require_once INCLUDES . 'footer.php';
        require_once INCLUDES . 'end.body.php';
    }
    elseif(isset($_SESSION['USER']) && $_SESSION['USER']['role'] == 'admin') {
        require_once INCLUDES . 'start.body.php';
        echo '<main class="w-full h-fit min-h-dvh">';
        echo '<div class="w-full min-h-dvh grid grid-rows-10 grid-cols-12">';
        require_once INCLUDES . 'sideBar.php';
        require_once INCLUDES . 'navbar.php';
        echo '<section class="row-span-9 col-span-10 max-2xl:col-span-12">';
        require_once VIEWS . 'addUserTemplate.view.php';
        echo '</section>';
        echo '</div>';
        echo '</main>';
        require_once INCLUDES . 'elements.php';
        require_once INCLUDES . 'errors.php';
        require_once INCLUDES . 'end.body.php';
    }
?>