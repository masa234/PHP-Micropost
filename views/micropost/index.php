<?php $this->setLayoutVar( 'title', 'ホーム' ) ?>

<h2>ホーム</h2>

<form action="<?php print $base_url; ?>/micropost/post" method="post">
    <input type="hidden" name="_token" value="<?php print $this->escape( $_token ); ?>" />

    <?php if ( isset( $errors ) && count( $errors ) > 0): ?>
    <?php print $this->render( 'errors', array( 'errors' => $errors ) ) ?>
    <?php endif; ?>

    <textarea class="form-control" name="content" rows="6"><?php print $this->escape( $content ); ?></textarea>
    <p>
        <button type="submit" class="btn btn-info">Send</button>
    </p>
</form>

<div id="microposts">
    <?php foreach ( $microposts as $micropost ): ?>
    <?php print $this->render( 'micropost/micropost', array( 'micropost' => $micropost ) ); ?>
    <?php endforeach; ?>
</div>
