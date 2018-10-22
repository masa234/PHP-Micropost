<?php $this->setLayoutVar( 'title', 'ホーム' ) ?>

<h2>ホーム</h2>

<form action="<?php print $base_url; ?>/microposts/post" method="post">
    <input type="hidden" name="_token" value="<?php print $this->escape( $_token ); ?>" />

    <?php if ( isset( $errors ) && count( $errors ) > 0): ?>
    <?php print $this->render( 'errors', array( 'errors' => $errors ) ) ?>
    <?php endif; ?>

    <textarea name="content" rows="2" cols="60"><?php print $this->escape( $content ); ?></textarea>
    <p>
        <button type="submit" class="btn btn-success">Talk</button>
    </p>
</form>

<div id="microposts">
    <?php foreach ( $microposts as $micropost ): ?>
    <?php print $this->render( 'microposts/micropost', array( 'micropost' => $micropost ) ); ?>
    <?php endforeach; ?>
</div>

<?php 
$email = "someone@somewhere.com";
$default = "https://www.somewhere.com/homestar.jpg";
$size = 40;

$grav_url = "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?d=" . urlencode( $default ) . "&s=" . $size;
?>
<img src="<?php echo $grav_url; ?>" alt="" />