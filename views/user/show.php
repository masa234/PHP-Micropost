<?php $this->setLayoutVar( 'title', 'ユーザ情報編集' ); ?>
<h2><?php print $this->escape( $user_name ) ?></h2>

<div class="card">
    <div class="card-body">
        <img src="<?php print $gravator_url; ?>" class="img-circle" alt="...">
        <strong>
            ユーザ名:<?php print $this->escape( $user_name ) ?>
        </strong>
    </div>
</div>

<div id="microposts">
    <?php if ( $microposts ): ?>
    <?php foreach ( $microposts as $micropost ): ?>
    <?php print $this->render( 'micropost/_micropost', array( 'micropost' => $micropost, 'gravator_url' => $micropost['email'] ) ); ?>
    <?php endforeach; ?>
    <?php else: ?>
    <strong><?php print 'まだ投稿がありません' ?></strong>
    <?php endif; ?>
</div>