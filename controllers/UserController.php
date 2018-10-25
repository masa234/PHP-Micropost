<?php 

class UserController extends Controller
{   

    public function signup()
    {
        return $this->render( array(
            'user_name' => '',
            'email' => '',
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
        $email  = $this->request->getPost( 'email' );
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

        if ( ! strlen( $email ) ) {
            $errors[] = "メールアドレスを入力してください";
        }

        if ( count( $errors ) === 0 ) {
            $this->db_manager->get( 'User' )->insert( $user_name, $email, $password );
            $this->session->setAuthenticated( true );

            $user = $this->db_manager->get( 'User' )->fetchByUserNameAndEmail( $user_name, $email );
            $this->session->set( 'user', $user );

            return $this->redirect( '/' );
        }

        return $this->render(array(
            'user_name' => $user_name,
            'email'     => $email,
            'password'  => $password,
            'errors'    => $errors,
            '_token'    => $this->generateCsrfToken( 'user/signup' ),
        ), 'signup');
    }

    // public function index()
    // {
    //     $user = $this->session->get( 'user' );

    //     return $this->render( array( 'user' => $user ) );
    // }

    public function signin()
    {
        if ( $this->session->isAuthenticated() ) {
            return $this->redirect( '/user/index' );
        }

        return $this->render( array(
            'user_name' => '',
            'email'     => '',            
            'password'  => '',
            '_token'    => $this->generateCsrfToken( '/user/signin' ),
        ) );
    }

    // ログイン
    public function authenticate()
    {
        if ( ! $this->request->isPost() ) {
            return $this->redirect( '/user/index' );
        }

        $token = $this->request->getPost( '_token' );
        if ( ! $this->checkCsrfToken( '/user/signin', $token ) ) {
            return $this->redirect( '/user/signin' );
        }

        $user_name = $this->request->getPost( 'user_name' );
        $email = $this->request->getPost( 'email' );
        $password  = $this->request->getPost( 'password' );

        $errors = array();

        if ( ! strlen( $user_name ) ) {
            $errors[] = "ユーザ名を入力してください";
        }

        if ( ! strlen( $email ) ) {
            $errors[] = "メールアドレスを入力してください";
        }

        if( ! strlen( $password ) ) {
            $errors[] = "パスワードが未入力です";
        } else if ( strlen( $password ) < 5 
                || strlen( $password ) > 15 ) {
            $errors[] = "パスワードは5文字以上15文字以内でお願いします";        
        }

        if ( count( $errors ) === 0 ) {
            
            $user_repository = $this->db_manager->get( 'User' );
            $user = $user_repository->fetchByUserNameAndEmail( $user_name, $email );

            if ( $user 
                 && ( $user['password'] == password_verify(  $password , $user_repository->hashPassword( $password ) ) )
            ){  
                $this->session->setAuthenticated( true );
                $this->session->set( 'user', $user );

                return $this->redirect( '/user/index' );
            } else {
                $errors[] = "入力が誤っています";
            }
        }

        return $this->render( array(
            'user_name' => $user_name,
            'email'     => $email,
            'password'  => $password,
            'errors'    => $errors,
            '_token'    => $this->generateCsrfToken( 'user/signin' ),
        ), 'signin' );
    }

     // ユーザ詳細ページ
     public function show( $params )
     {  
        $user_model = $this->db_manager->get( 'User' );   
        $user =  $user_model->fetchByUserById( $params['id'] );

        if ( ! $user ) {
            $this->forward404();
        }

        $microposts = $this->db_manager->get( 'Micropost' )
            ->fetchAllMicropostsByUserID( $params['id'] );

         return $this->render ( array(
             'user_name'    => $user['user_name'],
             'microposts'   => $microposts,
             'gravator_url' => $user_model->getGravatarUrl( $user['email'] ),
         ) );
     }   

    // 現在ログイン中のユーザの情報編集
    public function edit()
    {

        $current_user = $this->session->get( 'user' );

        return $this->render ( array(
            'user_name' => $current_user['user_name'],
            'email'     => $current_user['email'],
            'password'  => $current_user['password'],
            '_token'    => $this->generateCsrfToken( 'user/edit' ),
        ) );
    }

    // ユーザデータ更新
    public function update()
    {
        if ( ! $this->request->isPost() ) {
            $this->forward404();
        }

        $token = $this->request->getPost( '_token' );
        if ( ! $this->checkCsrfToken( 'user/edit', $token ) ) {
            return $this->redirect( '/user/edit' );
        }

        $current_user = $this->session->get( 'user' );
        $user_name = $this->request->getPost( 'user_name' );
        $email = $this->request->getPost( 'email' );
        $password = $this->request->getPost( 'password' );

        $errors = array();

        if ( ! $user_name  ) {
            $errors[] = "ユーザ名を入力してください";
        } else if ( ! $this->db_manager->get( 'User' )->isUniqueUserName( $user_name )
                    && $current_user['user_name'] != $user_name ) {
            $errors[] = "ユーザ名は既に登録されています";
        }

        if ( ! $email ) {
            $errors[] = "メールアドレスを入力してください";
        }

        if( ! strlen( $password ) ) {
            $errors[] = "パスワードが未入力です";
        } else if ( strlen( $password ) < 5 
                || strlen( $password ) > 15 ) {
            $errors[] = "パスワードは5文字以上15文字以内でお願いします";        
        }

        if ( count( $errors ) == 0 ) {

            $current_user = $this->session->get( 'user' );
            $this->db_manager->get( 'User' )->update( $current_user['id'], $user_name, $email, $password );

            $user = $this->db_manager->get( 'User' )->fetchByUserNameAndEmail( $user_name, $email );
            $this->session->set( 'user', $user );
        }

        return $this->render( array(
            'user_name' => $user_name,
            'email'     => $email,
            'password'  => $password,
            'errors'    => $errors,
            '_token'    => $this->generateCsrfToken( 'user/edit' ),
        ), 'edit' );    
    }

    // public function follow( $params )
    // {
    //     $following = null;
    //     $current_user = $this->session->get( 'user' ); // ログインユーザのオブジェクトを取得
        
    //     if ( $current_user != $user['id'] ) {
    //         $following = $this->db_manager->get( 'Following' ) 
    //             ->isFollowing( $current_user['id'], $user['id'] );
    //     }

    //     return $this->render ( array(
    //         'following' => $following,
    //         '_token'    => $this->generateCsrfToken( '/user/follow' ),
    //     ) );
    // }
}