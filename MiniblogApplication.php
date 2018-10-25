<?php   

class MiniblogApplication extends Application
{
    protected $login_action = array( 'user', 'signin' );

    public function getRootDir()
    {
        return dirname( __FILE__ );
    }

    protected function registerRoutes()
    {
        return array(
            '/'
                => array( 'controller' => 'micropost', 'action' => 'index' ),
            '/user/:action/:id'
                => array( 'controller' => 'user' ),
            '/micropost/:action/:id'
                => array( 'controller' => 'micropost' ),
            '/member/:user_name/microposts/:id'
                => array( 'controller' => 'micropost', 'action' => 'show' ),
            '/user/:action'
                => array( 'controller' => 'user' ),
            '/micropost/post'
                => array( 'controller' => 'micropost', 'action' => 'post' ),
            '/follow'
                => array( 'controller' => 'user', 'action' => 'follow' ),
        );
    }

    protected function configure()
    {
        $this->db_manager->connect( 'master', array(
            'dsn'       => 'mysql:dbname=miniblog;host=localhost',
            'user'      => 'root',
            'password'  => '',
        ) );
    }
}