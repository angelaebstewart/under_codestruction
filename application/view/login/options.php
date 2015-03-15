<div id="contentArea">
    <div class="contentDivision"> 
        <h1>Account Options</h1>

    <div class="create-class">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form action="#">
                        <button id="changePswdBtn" class="btn btn-lg btn-primary btn-block" type="submit">Change Password</button>
                        <button id="changeEmailBtn" class="btn btn-lg btn-primary btn-block" type="submit">Change Email</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- echo out the system feedback (error and success messages) -->
        <?php $this->renderFeedbackMessages(); ?>
    </div>
</div>
