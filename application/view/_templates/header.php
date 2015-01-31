<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Under Codestruction</title>
    <!-- Bootstrap core CSS -->
    <link href="<?php echo Config::get('URL'); ?>css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo Config::get('URL'); ?>css/custom_content.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="<?php echo Config::get('URL'); ?>css/signin.css" rel="stylesheet">    
    <link href="<?php echo Config::get('URL'); ?>css/list.css" rel="stylesheet">
  </head>
  <body>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="navbar-header">
            <img class="navbar-brand" src="<?php echo Config::get('URL'); ?>images/Logo_sm.png">
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">       
            <?php if (Session::userIsLoggedIn()) { ?>
                
                    <li><a href="<?php echo Config::get('URL'); ?>Lesson/index">Lessons</a></li>
                
               <?php
                if (Session::getUserRole() == Config::get('TEACHER')) {
                    ?>
                    <li><a href="<?php echo Config::get('URL'); ?>Class/index">Classes</a></li>
                    <li><a href="<?php echo Config::get('URL'); ?>/Manual.pdf">Manual</a></li>
            <?php }
            
                } else { ?>
                <!-- for not logged in users -->
                <li <?php if (View::checkForActiveControllerAndAction($filename, "login/index")) { echo ' class="active" '; } ?> >
                    <a href="<?php echo Config::get('URL'); ?>login/index">Login</a>
                </li>
                <li <?php if (View::checkForActiveControllerAndAction($filename, "login/register")) { echo ' class="active" '; } ?> >
                    <a href="<?php echo Config::get('URL'); ?>login/register">Register</a>
                </li>
            <?php } ?>
            
			
			<?php if (Session::userIsLoggedIn()) : ?>
            <li class="dropdown"  >
              <a href="<?php echo Config::get('URL'); ?>" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Account<span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
 <li <?php if (View::checkForActiveController($filename, "login")) { echo ' class="active" '; } ?> >
                        <a href="<?php echo Config::get('URL'); ?>login/editUsername">Options</a>
                    </li>                 
                    <li <?php if (View::checkForActiveController($filename, "login")) { echo ' class="active" '; } ?> >
                        <a href="<?php echo Config::get('URL'); ?>login/logout">Logout</a>
                    </li>
              </ul>
            </li>
            <?php endif; ?>
          </ul>
        </div><!--/.nav-collapse -->

    </nav>