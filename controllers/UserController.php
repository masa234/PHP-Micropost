<?php 

class UserController extends Controller
{   
    protected $auth_action  = array( 'index', 'signout' );

    public function signup()
    {
        return $this->render( array(
            'user_name' => '',
            'password' => '',
            '_token'    => $this->generateCsrfToken( 'user/signup' ),
        ) );
    }

    public function signout()
    {
        $this->session->clear();
        $this->session->setAuthenticated( false );

        return $this->redirect( '/user/signin' );
    }

    public function register()
    {   
        if ( ! $this->request->isPost() ) {
            $this->forward404();
        }

        $token = $this->request->getPost( '_token' );
        if ( ! $this->checkCsrfToken( 'user/signup', $token ) ) {
            return $this->redirect( '/user/signup' );
        }

        $user_name = $this->request->getPost( 'user_name' );
        $password  = $this->request->getPost( 'password' );

        $errors = array();

        if ( ! strlen ( $user_name ) ) {
            $errors[] = "ユーザ名を入力してください";
        } else if ( ! $this->db_manager->get( 'User' )->isUniqueUserName( $user_name ) ) {
            $errors[] = "ユーザ名は既に登録されています";
        }

        if( ! strlen( $password ) ) {
            $errors[] = "パスワードが未入力です";
        } else if ( strlen( $password ) < 5 
                || strlen( $password ) > 15 ) {
            $errors[] = "パスワードは5文字以上15文字以内でお願いします";        
        }

        if ( count( $errors ) === 0 ) {
            $this->db_manager->get( 'User' )->insert( $user_name, $password );
            $this->session->setAuthenticated( true );

            $user = $this->db_manager->get( 'User' )->fetchByUserName( $user_name );
            $this->session->set( 'user', $user );

            return $this->redirect( '/' );
        }

        return $this->render(array(
            'user_name' => $user_name,
            'password'  => $password,
            'errors'    => $errors,
            '_token'    => $this->generateCsrfToken( 'user/signup' ),
        ), 'signup');
    }

    public function index()
    {
        $user = $this->session->get( 'user' );

        return $this->render( array( 'user' => $user ) );
    }

    public function signin()
    {
        if ( $this->session->isAuthenticated() ) {
            return $this->redirect( '/user/index' );
        }

        return $this->render( array(
            'user_name' => '',
            'password'  => '',
            '_token'    => $this->generateCsrfToken( 'user/signin' ),
        ) );
    }

    public function authenticate()
    {
        if ( ! $this->request->isPost ) {
            return $this->redirect( '/user/index' );
        }

        $token = $this->request->getPost( '_token' );
        if ( ! $this->checkCsrfToken( 'user/signin', $token ) ) {
            return $this->redirect( 'user/signin' );
        }

        $user_name = $this->request->getPost( 'user_name' );
        $password  = $this->request->getPost( 'password' );

        $errors = array();

        if ( ! strlen( $user_name ) ) {
            $errors[] = "ユーザ名を入力してください";
        }

        if ( ! strlen( $password ) ) {
            $errors[] = "パスワードを入力してください";
        }

        if ( count( $errors ) > 0 ) {
            
            $user_repository = $this->db_manager->get( 'User' );
            $user = $user_repository->fetchByUserName( $user_name );

            if ( ! $user 
                || ( $user['password'] !== $user_repository->hashPassword( $password ) )
            ){
                $errors[] = "ユーザIDかパスワードが不正です";
            } else {
                $this->session->setAuthenticated( true );
                $this->session->set( 'user', $user );

                return $this->redirect( '/' );
            }
        }

        return $this->render( array(
            'user_name' => $user_name,
            'password'  => $password,
            'errors'    => $errors,
            '_token'    => $this->generateCsrfToken( 'user/signin' ),
        ), 'signin' );
    }
}