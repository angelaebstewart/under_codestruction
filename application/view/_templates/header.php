<!DOCTYPE html>
<html  lang="en">
    <head>
        <title>Under Codestruction</title>
        <!-- Bootstrap core CSS -->
        <link href="<?php echo Config::get('URL', 'gen'); ?>css/bootstrap.min.css" rel="stylesheet">
        <!-- Pretty Photo css for the video stuff -->
        <link rel="stylesheet" href="<?php echo Config::get('URL', 'gen'); ?>css/prettyPhoto.css" type="text/css" media="screen" title="prettyPhoto main stylesheet" charset="utf-8" />
        <!-- Auburn's Styling -->
        <link rel="stylesheet" href="<?php echo Config::get('URL', 'gen'); ?>css/stretch.css" media="screen" type="text/css" />
        <!-- Custom styling -->
        <link rel="stylesheet" href="<?php echo Config::get('URL', 'gen'); ?>css/signin.css"  type="text/css">
        <link rel="stylesheet" href="<?php echo Config::get('URL', 'gen'); ?>css/register.css" type="text/css">
        <link rel="stylesheet" href="<?php echo Config::get('URL', 'gen'); ?>css/list.css" type="text/css">
        <link rel="stylesheet" href="<?php echo Config::get('URL', 'gen'); ?>css/createclass.css" type="text/css">
        <link rel="stylesheet" href="<?php echo Config::get('URL', 'gen'); ?>css/request.css" type="text/css">
        <link rel="stylesheet" href="<?php echo Config::get('URL', 'gen'); ?>css/table.css" type="text/css">
        <!-- javascripts that will be used on every page-->
        <script type="text/javascript" charset="utf-8" src="<?php echo Config::get('URL', 'gen'); ?>js/jquery.min.js"></script>
        <script type="text/javascript" charset="utf-8" src="<?php echo Config::get('URL', 'gen'); ?>js/bootstrap.min.js"></script>
        <script type="text/javascript" charset="utf-8" src="<?php echo Config::get('URL', 'gen'); ?>js/jquery.prettyPhoto.js"></script>

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
                <table class="nav">
                    <tr>
                        <?php if (Session::userIsLoggedIn()) { ?>
                            <td><a href="<?php echo Config::get('URL', 'gen'); ?>Lesson/index">Lessons</a></td>
                            <?php
                            if (Session::getUserRole() == Config::get('ROLE_TEACHER', 'gen')) {
                                ?>
                                <td><a href="<?php echo Config::get('URL', 'gen'); ?>Class/index">Classes</a></td>
                                <td><a href="<?php echo Config::get('URL', 'gen'); ?>UnderCodestruction_UserManual.pdf" target="_blank">Manual</a></dt>
                                    <?php
                                }
                            } else {
                                ?>
                                <!-- for not logged in users -->
                            <td <?php
                            if (View::checkForActiveControllerAndAction($filename, "login/index")) {
                                echo ' class="active" ';
                            }
                            ?> >
                                <a href="<?php echo Config::get('URL', 'gen'); ?>login/index">Login</a>
                            </td>
                            <td <?php
                            if (View::checkForActiveControllerAndAction($filename, "login/register")) {
                                echo ' class="active" ';
                            }
                            ?> >
                                <a href="<?php echo Config::get('URL', 'gen'); ?>login/register">Register</a>
                            </td>
                        <?php } ?>


                        <?php if (Session::userIsLoggedIn()) { ?>

                            <td <?php
                            if (View::checkForActiveController($filename, "login")) {
                                echo ' class="active" ';
                            }
                            ?> >
                                <a href="<?php echo Config::get('URL', 'gen'); ?>login/editUsername">Options</a>
                            </td>                 
                            <td <?php
                            if (View::checkForActiveController($filename, "login")) {
                                echo ' class="active" ';
                            }
                            ?> >
                                <a href="<?php echo Config::get('URL', 'gen'); ?>login/logout">Logout</a>
                            </td>

                        <?php } ?>
                    </tr>
                </table>
            </div>