<?php $this->setLayoutVar( 'title', 'ホーム' ) ?>

<h2>投稿編集画面</h2>

<form action="<?php print $base_url; ?>/micropost/update/<?php print params['id']; ?>" method="post">
    <input type="hidden" name="_token" value="<?php print $this->escape( $_token ); ?>" />

    <?php if ( isset( $errors ) && count( $errors ) > 0): ?>
    <?php print $this->render( '_errors', array( 'errors' => $errors ) ) ?>
    <?php endif; ?>

    <?php if ( isset( $message ) ): ?>
    <?php print $this->render( '_message', array( 'message' => $message ) ); ?> 
    <?php endif; ?>

    <textarea class="form-control" name="content" rows="6"><?php print $this->escape( $content ); ?></textarea>
    <p>
        <button type="submit" class="btn btn-info">Send</button>
    </p>
</form>