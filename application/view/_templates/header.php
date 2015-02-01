<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Under Codestruction</title>
    <!-- Bootstrap core CSS -->
    <link href="<?php echo Config::get('URL','gen'); ?>css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo Config::get('URL','gen'); ?>css/custom_content.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="<?php echo Config::get('URL','gen'); ?>css/signin.css" rel="stylesheet">    
    <link href="<?php echo Config::get('URL','gen'); ?>css/list.css" rel="stylesheet">   
    <link href="<?php echo Config::get('URL','gen'); ?>css/register.css" rel="stylesheet">
  </head>
  <body>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="navbar-header">
            <img class="navbar-brand" src="<?php echo Config::get('URL','gen'); ?>images/Logo_sm.png">
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">       
            <?php if (Session::userIsLoggedIn()) { ?>
                
                    <li><a href="<?php echo Config::get('URL','gen'); ?>Lesson/index">Lessons</a></li>
                
               <?php
                if (Session::getUserRole() == Config::get('TEACHER','gen')) {
                    ?>
                    <li><a href="<?php echo Config::get('URL','gen'); ?>Class/index">Classes</a></li>
                    <li><a href="<?php echo Config::get('URL','gen'); ?>/Manual.pdf">Manual</a></li>
            <?php }
            
                } else { ?>
                <!-- for not logged in users -->
                <li <?php if (View::checkForActiveControllerAndAction($filename, "login/index")) { echo ' class="active" '; } ?> >
                    <a href="<?php echo Config::get('URL','gen'); ?>login/index">Login</a>
                </li>
                <li <?php if (View::checkForActiveControllerAndAction($filename, "login/register")) { echo ' class="active" '; } ?> >
                    <a href="<?php echo Config::get('URL','gen'); ?>login/register">Register</a>
                </li>
            <?php } ?>
            
			
			<?php if (Session::userIsLoggedIn()) : ?>
            <li class="dropdown"  >
              <a href="<?php echo Config::get('URL','gen'); ?>" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Account<span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
 <li <?php if (View::checkForActiveController($filename, "login")) { echo ' class="active" '; } ?> >
                        <a href="<?php echo Config::get('URL','gen'); ?>login/editUsername">Options</a>
                    </li>                 
                    <li <?php if (View::checkForActiveController($filename, "login")) { echo ' class="active" '; } ?> >
                        <a href="<?php echo Config::get('URL','gen'); ?>login/logout">Logout</a>
                    </li>
              </ul>
            </li>
            <?php endif; ?>
          </ul>
        </div><!--/.nav-collapse -->

    </nav>