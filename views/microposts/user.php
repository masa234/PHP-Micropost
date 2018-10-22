<?php $this->setLayoutVar( 'title', $user['user_name'] ) ?>

<h2><?php print $this->escape( $user['user_name'] ); ?></h2>

<div id="microposts">
    <?php foreach ( $microposts as $micropost ): ?>
    <?php print  $this->render( 'microposts/micropost', array( 'microposts' => $microposts ) ); ?>
    <?php endforeach; ?>
</div>

