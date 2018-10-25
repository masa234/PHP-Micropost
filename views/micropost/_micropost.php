<div class="micropost card text-white border-info">
    <div class="micropost-content card-body">
        <a href="<?php print $base_url; ?>/user/show/<?php print $this->escape( $micropost['user_id'] ); ?>" >
        <?php $user_model = $db_manager->get( 'User' ) ?>
        <?php $gravator_url = $user_model->getGravatarUrl( $micropost['email'] ) ?>
        <img src="<?php print $gravator_url; ?>" class="img-circle" alt="..."> 
        <div class="card-header"><?php print $this->escape( $micropost['user_name'] ); ?></div>
        <?php print $this->escape( $micropost['content'] ); ?>                         
    </div>
    <div>
        <a href="<?php print $base_url; ?>/micropost/show/<?php print $this->escape( $micropost['id'] ); ?>" > 
        <?php print $this->escape( $micropost['created_at'] ); ?>
        <?php $current_user = $session->get( 'user' ) ?>
        <!-- ログインユーザの投稿にだけ、編集ボタン,編集ボタンを追加 -->
        <?php if ( $micropost['user_id'] == $current_user['id']  ): ?>
        <a href="<?php print $base_url; ?>/micropost/edit/<?php print $this->escape( $micropost['id'] ); ?>">
        <div class="btn btn-info">編集</div>
        <a href="<?php print $base_url; ?>/micropost/delete/<?php print $this->escape( $micropost['id'] ); ?>">
        <div class="btn btn-danger" onClick="return check()">削除</div>
        <?php endif; ?> 
    </div>
</div>

