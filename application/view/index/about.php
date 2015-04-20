<div id="contentArea">
    <div class="contentDivision"> 
        <h1>About Us</h1><br />
        <div class="container">

            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                About Under Codestruction
                            </a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                        <div class="panel-body">
                            <center><img src="<?php echo Config::get('URL', 'gen'); ?>images/Logo_1pxBlackOutline.png"></center><br>

                            <p>This is an interactive website that was created to teach computer science principles to high school students.
                                We are approaching this task by having students solve everyday problems from a computer science prospective.
                                The lessons consist of an animation to introduce the ideas, game play to reinforce the principles,
                                and an assessment to challenge the students.
                                The teachers are able to view the feedback that results from the students interaction with the game play
                                and assessment to check the progress of the student as they work through each lesson.</p>

                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingTwo">
                        <h4 class="panel-title">
                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                About the team
                            </a>
                        </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                        <div class="panel-body">


                            <div class="container">

                                <div class="bs-example" data-example-id="thumbnails-with-custom-content">
                                    <div class="row">

                                        <div class="row">
                                            <div class="col-sm-3 col-md-3 col-sm-offset-1">
                                                <div class="thumbnail">

                                                    <img src="<?php echo Config::get('URL', 'gen'); ?>images/team/seals.png" alt="..." class="img-circle" style="display: block;">
                                                    <div class="caption">
                                                        <h4 id="thumbnail-label">Dr. Cheryl D. Seals <a class="anchorjs-link" href="#thumbnail-label"><span class="anchorjs-icon"></span></a></h3>
                                                            <p>Associate Professor at Auburn University. Project Sponsor.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-3 col-md-3">
                                                <div class="thumbnail">

                                                    <img src="<?php echo Config::get('URL', 'gen'); ?>images/team/angela.png" alt="..." class="img-circle">
                                                    <div class="caption">
                                                        <h4 id="thumbnail-label">Angela Stewart<a class="anchorjs-link" href="#thumbnail-label"><span class="anchorjs-icon"></span></a></h3>
                                                            <p>Software Engineer</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3 col-md-3">
                                                <div class="thumbnail">

                                                    <img src="<?php echo Config::get('URL', 'gen'); ?>images/team/ethan.png" alt="..." class="img-circle">
                                                    <div class="caption">
                                                        <h4 id="thumbnail-label">Ethan Mata<a class="anchorjs-link" href="#thumbnail-label"><span class="anchorjs-icon"></span></a></h3>
                                                            <p>Software Engineer</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- end of nested row -->
                                        <div class="row">
                                            <div class="col-sm-3 col-md-3 col-sm-offset-1">
                                                <div class="thumbnail">

                                                    <img src="<?php echo Config::get('URL', 'gen'); ?>images/team/ryan.png" alt="..." class="img-circle" style="display: block;">
                                                    <div class="caption">
                                                        <h4 id="thumbnail-label">Ryan Lewis<a class="anchorjs-link" href="#thumbnail-label"><span class="anchorjs-icon"></span></a></h3>
                                                            <p>Software Engineer</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-3 col-md-3">
                                                <div class="thumbnail">

                                                    <img src="<?php echo Config::get('URL', 'gen'); ?>images/team/victoria.png" alt="..." class="img-circle" style="display: block;">
                                                    <div class="caption">
                                                        <h4 id="thumbnail-label">Victoria Richardson <a class="anchorjs-link" href="#thumbnail-label"><span class="anchorjs-icon"></span></a></h3>
                                                            <p>Software Engineer</p>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-sm-3 col-md-3">
                                                <div class="thumbnail">

                                                    <img src="<?php echo Config::get('URL', 'gen'); ?>images/team/walter.png" alt="..." class="img-circle" style="display: block;">
                                                    <div class="caption">
                                                        <h4 id="thumbnail-label">Walter Conway <a class="anchorjs-link" href="#thumbnail-label"><span class="anchorjs-icon"></span></a></h3>
                                                            <p>Wireless Software Engineer</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- end of nested row -->
                                    </div><!--end of initial row -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- echo out the system feedback (error and success messages) -->
    <?php $this->renderFeedbackMessages(); ?>
</div>