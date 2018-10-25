<?php $this->setLayoutVar( 'title', 'ユーザ情報編集' ); ?>

<h2>ユーザ情報編集</h2>

<form action="<?php print $base_url; ?>/user/update" method="post">
    <input type="hidden" name="_token" value="<?php print $this->escape( $_token ); ?>" />

    <?php if ( isset( $errors ) && count( $errors ) > 0 ): ?>
    <?php print $this->render( '_errors', array( 'errors' => $errors ) ); ?>
    <?php endif; ?>

    <?php if ( isset( $message ) ): ?>
    <?php print $this->render( '_message', array( 'message' => $message ) ); ?> 
    <?php endif; ?>

    <?php echo $this->render( 'user/_register_form', array(
        'user_name' => $user_name, 'email' => $email, 'password' => ''
    )); ?> 

    <p>
        <input type="submit" class="btn btn-info" value="ユーザ情報編集">
    </p>
</form>