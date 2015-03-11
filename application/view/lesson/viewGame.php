<div id="contentArea">
    <div class="contentDivision gameContent"> 

        <h4><br>Game for Lesson <?php echo Request::get('id'); ?></h4>
  
        <div id="gameDiv">
            Loading...
        </div>
        
        <canvas id="canvas" width="750" height="500" style="border:1px solid #000000;">
                HTML Canvas isn't supported by your browser.
        </canvas>

        <a href="<?php echo Config::get('URL','gen'); ?>lesson/viewLesson/?id=<?php echo Request::get('id'); ?>"><- Back to lesson page</a>
    </div>
</div>

<script type="text/javascript" charset="utf-8" src="<?php echo Config::get('URL', 'gen'); ?>js/gameHandler.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Config::get('URL', 'gen'); ?>js/chippy.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo Config::get('URL', 'gen'); ?>js/alice/alice.js"></script>
<script>
    var gameID = <?php echo Request::get('id'); ?>;
    var pageID = 0;
    var loadGamePageURL = "<?php echo Config::get('URL', 'gen'); ?>game/getGamePage_action";
    
    $(document).ready(function() {
        getNextGamePage();
    });
</script>

<!-- echo out the system feedback (error and success messages) -->
<?php $this->renderFeedbackMessages(); ?>