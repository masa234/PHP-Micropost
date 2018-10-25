<?php $this->setLayoutVar('title', '新規登録') ?>

<h2>新規登録</h2>

<form action="<?php print $base_url; ?>/user/register" method="post">
    <input type="hidden" name="_token" value="<?php print $this->escape($_token); ?>" />

    <?php if ( isset( $errors ) && count( $errors ) > 0): ?>
    <?php print $this->render( 'errors', array( 'errors' => $errors ) ); ?>
    <?php endif; ?>

    <?php print $this->render( 'user/register_form', array(
        'user_name' => $user_name, 'email' => $email, 'password' => $password
    )); ?>

    <p>
        <input type="submit" class="btn btn-primary"></button>
    </p>
</form>