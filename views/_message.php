<?php if ( $message ): ?>
    <div class="alert alert-dismissible alert-success">
        <h4 class="alert-heading">Complete</h4>
        <p class="mb-0"><?php print $this->escape( $message ); ?></li></p>
    </div>
<?php endif;?>