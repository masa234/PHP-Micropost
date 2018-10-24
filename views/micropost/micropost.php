<div class="micropost">
    <div class="micropost-content">
        <a href="<?php print $base_url; ?>/member/<?php print $this->escape( $micropost['user_name'] ); ?>" > 
        <?php print $this->escape( $micropost['user_name'] ); ?>
        <?php print $this->escape( $micropost['body'] ); ?>
    </div>
    <div>
        <a href="<?php print $base_url; ?>/member/<?php print $this->escape( $micropost['user_name'] ); 
        ?>/microposts/<?php print $this->escape( $micropost['id'] ); ?>" > 
        <?php print $this->escape( $micropost['created_at'] ); ?>
    </div>
</div>
<hr>
