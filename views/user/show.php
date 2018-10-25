<?php $this->setLayoutVar( 'title', 'ユーザ情報編集' ); ?>

<h2>ユーザ詳細画面</h2>

<div class="card">
    <div class="card-body">
        <strong>
            ユーザ名:<?php print $this->escape( $user_name ) ?>
        </strong>
    </div>
</div>
	
<img src="<?php echo $gravator_url; ?>" alt="" />

<div id="microposts">
    <?php if ( $microposts ): ?>
    <?php foreach ( $microposts as $micropost ): ?>
    <?php print $this->render( 'micropost/micropost', array( 'micropost' => $micropost ) ); ?>
    <?php endforeach; ?>
    <?php else: ?>
    <strong><?php print 'まだ投稿がありません' ?></strong>
    <?php endif; ?>
</div>