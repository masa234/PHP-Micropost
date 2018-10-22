<?php $this->setLayoutVar('title', 'アカウント登録') ?>

<h2>アカウント登録</h2>

<form action="<?php echo $base_url; ?>/user/register" method="post">
    <input type="hidden" name="_token" value="<?php echo $this->escape($_token); ?>" />

    <?php if ( isset( $errors ) && count( $errors ) > 0): ?>
    <?php echo $this->render( 'errors', array( 'errors' => $errors ) ); ?>
    <?php endif; ?>

    <?php echo $this->render( 'user/register_form', array(
        'user_name' => $user_name, 'password' => $password,
    )); ?>

    <p>
        <input type="submit" class="btn btn-primary"></button>
    </p>
</form>
<?php 
$email = "someone@somewhere.com";
$default = "https://www.somewhere.com/homestar.jpg";
$size = 40;

$grav_url = "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?d=" . urlencode( $default ) . "&s=" . $size;
?>
<img src="<?php echo $grav_url; ?>" alt="" />