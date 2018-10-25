<?php $this->setLayoutVar( 'title', 'ホーム' ) ?>

<<<<<<< HEAD
<h2><?php print $this->escape( $micropost['user_name'] ); ?>が<?php print $this->escape( $micropost['created_at'] ); ?>に投稿したMicropostです</h2>

<form action="<?php print $base_url; ?>/micropost/update/<?php print $micropost['id']; ?>" method="post">
=======
<h2>投稿編集画面</h2>

<form action="<?php print $base_url; ?>/micropost/update/<?php print params['id']; ?>" method="post">
>>>>>>> 2ccd99e5fbdc06e6007a2de694fad0e8e9fc195d
    <input type="hidden" name="_token" value="<?php print $this->escape( $_token ); ?>" />

    <?php if ( isset( $errors ) && count( $errors ) > 0): ?>
    <?php print $this->render( '_errors', array( 'errors' => $errors ) ) ?>
    <?php endif; ?>

    <?php if ( isset( $message ) ): ?>
    <?php print $this->render( '_message', array( 'message' => $message ) ); ?> 
    <?php endif; ?>

<<<<<<< HEAD
    <textarea class="form-control" name="content" rows="6"><?php print $this->escape( $micropost['content'] ); ?></textarea>
=======
    <textarea class="form-control" name="content" rows="6"><?php print $this->escape( $content ); ?></textarea>
>>>>>>> 2ccd99e5fbdc06e6007a2de694fad0e8e9fc195d
    <p>
        <button type="submit" class="btn btn-info">Send</button>
    </p>
</form>