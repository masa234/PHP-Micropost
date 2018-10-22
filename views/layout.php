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

    <div id="nav">
        <p>
            <?php if ( $session->isAuthenticated() ): ?>
                <a href="<?php echo $base_url; ?>/">ホーム</a>
                <a href="<?php echo $base_url; ?>/user/index">アカウント</a>
                <a href="<?php echo $base_url; ?>/user/signout">ログアウト</a>
            <?php else: ?>
                <a href="<?php echo $base_url; ?>/user/signin">ログイン</a>
                <a href="<?php echo $base_url; ?>/user/signup">アカウント登録</a>
            <?php endif; ?>
        </p>
    </div>

    <div id="main">
        <?php echo $_content; ?>
    </div>
</body>
</html>

