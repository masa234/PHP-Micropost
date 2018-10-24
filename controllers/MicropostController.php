<?php 

class MicropostController extends Controller
{

    public function index()
    {      
        $user = $this->session->get( 'user' );
        $microposts = $this->db_manager->get( 'Micropost' )
            ->fetchAllMicroposts();
        
        return $this->render( array(
            'microposts'    => $microposts,
            'content'       => '',
            '_token'        => $this->generateCsrfToken( 'microposts/post' ),
        ) );
    }

    public function post()
    {
        if ( ! $this->request->isPost() ) {
            $this->forward404();
        }

        $token = $this->request->getPost( '_token' );
        if ( ! $this->checkCsrfToken( 'microposts/post', $token ) ) {
            return $this->redirect( '/' );
        }

        $content = $this->request->getPost( 'content' );

        $errors = array();

        if ( ! strlen( $content ) ) {
            $errors[] = '本文を入力してください'; 
        } else if ( strlen( $content ) > 200 ) {
            $errors[] = '本文は200文字以内で入力してください';
        }

        if ( count( $errors ) === 0 ) {
            $user = $this->session->get( 'user' );
            $this->db_manager->get( 'Micropost' )->insert( $user['id'], $content );

            return $this->redirect( '/' );
        }

        $user = $this->session->get( 'user' );
        $microposts = $this->db_manager->get( 'Micropost' )
            ->fetchAllMicroposts( $user['id'] );

        return $this->render( array(
            'errors'    => $errors,
            'content'   => $content,
            'microposts'=> $microposts,
            '_token'    => $this->generateCsrfToken( 'microposts/post' ),
        ) , 'index' );
    }

    public function member( $params )
    {
        $user = $this->db_manager->get( 'User' )
            ->fetchByUserName( $params['user_name'] );

        if ( ! $user ) {
            $this->forward404();
        }

        $microposts = $this->db_manager->get( 'Micropost' )
            ->fetchAllMicropostsByUserID( $user['id'] );
        
        return $this->render( array(
            'user'          => $user,
            'microposts'    => $microposts
        ) );
    }

    public function show( $params )
    {
        $micropost = $this->db_manager->get( 'Micropost' )
            ->fetchByIdAndUserName( $params['id'], $params['user_name'] );
        
        if ( ! $micropost ) {
            $this->forward404();
        }

        return $this->render( array( 'micropost' => $micropost ) );
    }
}