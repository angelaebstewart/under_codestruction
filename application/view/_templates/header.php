<!DOCTYPE html>
<html  lang="en">
    <head>
        <title>Under Codestruction</title>
        <!-- Bootstrap core CSS -->
        <link href="<?php echo Config::get('URL', 'gen'); ?>css/bootstrap.min.css" rel="stylesheet">
        <!-- Pretty Photo css for the video stuff -->
        <link rel="stylesheet" href="<?php echo Config::get('URL', 'gen'); ?>css/prettyPhoto.css" type="text/css" media="screen" title="prettyPhoto main stylesheet" charset="utf-8" />

        <!-- Custom styling -->
        <link rel="stylesheet" href="<?php echo Config::get('URL', 'gen'); ?>css/signin.css"  type="text/css">
        <link rel="stylesheet" href="<?php echo Config::get('URL', 'gen'); ?>css/register.css" type="text/css">
        <link rel="stylesheet" href="<?php echo Config::get('URL', 'gen'); ?>css/list.css" type="text/css">
        <link rel="stylesheet" href="<?php echo Config::get('URL', 'gen'); ?>css/createclass.css" type="text/css">
        <link rel="stylesheet" href="<?php echo Config::get('URL', 'gen'); ?>css/request.css" type="text/css">
        <link rel="stylesheet" href="<?php echo Config::get('URL', 'gen'); ?>css/table.css" type="text/css">
        <link rel="stylesheet" href="<?php echo Config::get('URL', 'gen'); ?>css/navmenu.css" type="text/css">
        <!-- Auburn's Styling -->
        <link rel="stylesheet" href="<?php echo Config::get('URL', 'gen'); ?>css/stretch.css" media="screen" type="text/css" />
        <link rel="stylesheet" href="<?php echo Config::get('URL', 'gen'); ?>css/game.css"  type="text/css">
        <!-- javascripts that will be used on every page-->
        <script type="text/javascript" charset="utf-8" src="<?php echo Config::get('URL', 'gen'); ?>js/jquery.min.js"></script>
        <script type="text/javascript" charset="utf-8" src="<?php echo Config::get('URL', 'gen'); ?>js/bootstrap.min.js"></script>
        <script type="text/javascript" charset="utf-8" src="<?php echo Config::get('URL', 'gen'); ?>js/jquery.prettyPhoto.js"></script>
        
        <?php
        if (Session::userIsLoggedIn()) { ?>
            <script type="text/javascript" charset="utf-8">var logoutURL = "<?php echo Config::get('URL', 'gen'); ?>login/logout";</script>
            <script type="text/javascript" charset="utf-8" src="<?php echo Config::get('URL', 'gen'); ?>js/autoLogout.js"></script>
        <?php
        }
        ?>
    </head>
    <body>
        <div id="pageWrap"> 
            <div id="headerWrap">
                <div id="header">
                    <div id="logo">
                        <a href="http://www.auburn.edu"><img src="<?php echo Config::get('URL', 'gen'); ?>images/headerLogo.png" alt="Auburn University Homepage" /></a>
                    </div>
                    <div id="headerTitle">

                        <div class="titleArea">
                            <span class="mainHeading"><img src="<?php echo Config::get('URL', 'gen'); ?>images/mockup9.png"></span>
                            <span class="subHeading"></span>
                        </div>
                    </div>
                </div>
                <nav id="ucnav">
                    <ul>
                        <?php
                        if (Session::userIsLoggedIn()) {
                            ?>
                            <!-- Will be seen by a student and a teacher -->
                            <li<?php
                            if (View::checkForActiveControllerAndAction($filename, "lesson/index")) {
                                echo ' class="activeMenuItem" ';
                            }
                            ?>><a href="<?php echo Config::get('URL', 'gen'); ?>Lesson/index">Lessons</a></li>
                                <?php
                                if (Session::get('user_role') == Config::get('ROLE_TEACHER', 'gen')) {
                                    ?>
                                <!-- Will be seen by only a teacher -->
                                <li<?php
                                if (View::checkForActiveControllerAndAction($filename, "class/index")) {
                                    echo ' class="activeMenuItem" ';
                                }
                                ?>><a href="<?php echo Config::get('URL', 'gen'); ?>Class/index">Classes</a></li>
                                <?php
                            }
                        } else {
                            ?>
                            <!-- Will only be seen by a visitor -->
                            <li<?php
                            if (View::checkForActiveControllerAndAction($filename, "login/index")) {
                                echo ' class="activeMenuItem" ';
                            }
                            ?>><a href="<?php echo Config::get('URL', 'gen'); ?>login/index">Login</a></li>
                            <li<?php
                            if (View::checkForActiveControllerAndAction($filename, "account/register")) {
                                echo ' class="activeMenuItem" ';
                            }
                            ?>><a href="<?php echo Config::get('URL', 'gen'); ?>account/register">Register</a></li>
                                <?php
                            }
                            ?>
                        <!-- Will be seen regardless-->
                        <li<?php
                        if (View::checkForActiveControllerAndAction($filename, "index/faq")) {
                            echo ' class="activeMenuItem" ';
                        }
                        ?>><a href="<?php echo Config::get('URL', 'gen'); ?>index/faq">FAQ</a></li>
                        <li<?php
                        if (View::checkForActiveControllerAndAction($filename, "index/about")) {
                            echo ' class="activeMenuItem" ';
                        }
                        ?>><a href="<?php echo Config::get('URL', 'gen'); ?>index/about">About</a></li>
                        
                        <?php
                            if (Session::userIsLoggedIn()) {
                                ?>                       
                            <!-- Will only be seen by an actual user -->
                            <li><a href="#">Account <span class="caret"></span></a>
                                <ul>
                                    <li><a href="<?php echo Config::get('URL', 'gen'); ?>account/options">Options</a></li>
                                    <li><a href="<?php echo Config::get('URL', 'gen'); ?>login/logout">Logout</a></li>
                                </ul>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </nav>
            </div>