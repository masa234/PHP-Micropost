<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php if (isset($title)): echo $this->escape($title) . ' - ';
        endif; ?>Mini Blog</title>

    <link rel="stylesheet" type="text/css" media="screen" href="/css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="/css/application.css" />
</head>
<body>
    <?php var_dump( $session->get( 'user' ) ); ?>
    <div id="header">
        <h1><a href="<?php echo $base_url; ?>/">Micropost</a></h1>
        <?php 
$email = "bfmt1250081@gmail.com";
$default = "https://www.somewhere.com/homestar.jpg";
$size = 40;

$grav_url = "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?d=" . urlencode( $default ) . "&s=" . $size;
?>
<img src="<?php echo $grav_url; ?>" alt="" />
    </div>


<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <a class="navbar-brand" href="<?php print $base_url; ?>/">Micropost</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <?php if ( $session->isAuthenticated() ): ?>
      <li class="nav-item active">
        <a class="nav-link" href="<?php print $base_url; ?>/">ホーム<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?php print $base_url; ?>">アカウント</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?php print $base_url; ?>/user/edit">ユーザ編集</a>
      </li>
      <?php $current_user = $session->get( 'user' ); ?>
      <li class="nav-item">
        <a class="nav-link" href="<?php print $base_url; ?>/user/show/<?php print( $current_user['id'] ); ?>">マイページ</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?php print $base_url; ?>/user/signout">ログアウト</a>
      </li>
      <?php else: ?>
      <li class="nav-item">
        <a class="nav-link" href="<?php print $base_url; ?>/user/signin">ログイン</a>
      </li>
      <li class="nav-item">
        <a class="nav-link disabled" href="<?php print $base_url; ?>/user/signup">アカウント登録</a>
      </li>
      <?php endif; ?>
    </ul>
  </div>
</nav>

    <div class="container">
        <?php print $_content; ?>
    </div>
</body>
</html>

