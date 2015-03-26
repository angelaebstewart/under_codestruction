<div id="contentArea">
    <div class="contentDivision gameContent"> 

        <h4><br>Game for Lesson <?php echo Request::get('id'); ?></h4>
        
        <div id="backgroundImages"></div>
        
        <div id="gameDiv">
            Loading...
        </div>
        
        <div id="chippyHolder">
            
        </div>
        
    </div>
    
    <a href="<?php echo Config::get('URL','gen'); ?>lesson/viewLesson/?id=<?php echo Request::get('id'); ?>"><- Back to lesson page</a>
</div>

<script>
    var imgFolder = "<?php echo Config::get('URL', 'gen'); ?>images/";
</script>
<script type="text/javascript" charset="utf-8" src="<?php echo Config::get('URL', 'gen'); ?>js/chippy.js"></script>

<script type="text/javascript" charset="utf-8" src="<?php echo Config::get('URL', 'gen'); ?>js/gameHandler.js"></script>
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