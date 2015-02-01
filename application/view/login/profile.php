<div class="container">
    <h1>User Profile</h1>

    <!-- echo out the system feedback (error and success messages) -->
    <?php $this->renderFeedbackMessages(); ?>

    <div class="box">
        <p>Name: <?php echo $this->user_firstName . " " . $this->user_lastName; ?></p>
        <p>Email: <?php echo $this->user_email; ?></p>
        <p>User Type: <?php echo $this->user_roleName; ?></p>
    </div>
</div>
