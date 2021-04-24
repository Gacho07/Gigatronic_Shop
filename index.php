<?php
session_start();
require_once "config/connection.php";

require "models/functions.php";
require "models/users/functions.php";
require "models/products/functions.php";
require "models/polls/functions.php";

include "views/fixed/head.php";
include "views/fixed/header.php";

if (isset($_GET['page'])) {
    $page = isset($_GET['page']) ? $_GET['page'] : null;
    switch ($page) {
        case "home":
            include "views/pages/home.php";
            break;
        case "products":
            include "views/pages/products.php";
            break;
        case "contact":
            include "views/pages/contact.php";
            break;
        case "cart":
            if (isset($_SESSION['user']) && $_SESSION['user']->roleName == 'user') {
                include "views/pages/cart.php";
            }
            break;
        case "poll":
            if (isset($_SESSION['user']) && $_SESSION['user']->roleName == 'user') {
                include "views/pages/poll.php";
            }
            break;
        case "adminUsers":
            if (isset($_SESSION['user']) && $_SESSION['user']->roleName == 'admin') {
                include "views/pages/admin/adminUsers.php";
            }
            break;
        case "adminInsertProduct":
            if (isset($_SESSION['user']) && $_SESSION['user']->roleName == 'admin') {
                include "views/pages/admin/adminInsertProdcut.php";
            }
            break;   
        case "adminProducts":
            if (isset($_SESSION['user']) && $_SESSION['user']->roleName == 'admin') {
                include "views/pages/admin/adminProducts.php";
            } 
            break;
        case "adminPoll":
            if (isset($_SESSION['user']) && $_SESSION['user']->roleName == 'admin') {
                include "views/pages/admin/adminPoll.php";
            }
            break;
    }
} else {
    include "views/pages/home.php";
}

include "views/fixed/modals.php";
include "views/fixed/footer.php";