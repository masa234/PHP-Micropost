<?php  $this->setLayoutVar( 'title', 'アカウント' ); ?>

<h2>アカウント</h2>

<p>
    NickName：
    <a href="<?php print $base_url ?>/member/<?php
    print $this->escape( $user['user_name'] ); ?>">
    <?php print $this->escape( $user['user_name'] ); ?>
</p>

<ul>
    <li>
        <a href="<?php print $base_url; ?>/">ホーム画面</a>
    </li>
    <li>    
        <a href="<?php print $base_url; ?>/user/signout">ログアウト</a>
    </li>
</ul>