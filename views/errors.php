<div class="alert alert-dismissible alert-warning">
    <h4 class="alert-heading">Warning!</h4>
    <?php foreach ( $errors as $error ): ?>
    <p class="mb-0"><?php print $this->escape( $error ); ?></li></p>
    <?php endforeach; ?>
</div>