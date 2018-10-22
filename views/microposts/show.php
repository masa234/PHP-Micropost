<?php $this->setLayoutVar( 'title', $micropost['user_name'] ) ?>

<?php print $this->render( 'microposts/micropost', array( 'micropost' => $micropost ) ); ?>