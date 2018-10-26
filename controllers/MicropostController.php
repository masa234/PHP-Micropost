<?php 

class MicropostController extends Controller
{

    public function index()
    {      

        $microposts = $this->db_manager->get( 'Micropost' )
            ->fetchAllMicroposts();
        
        return $this->render( array(
            'microposts'    => $microposts,
            'content'       => '',
            '_token'        => $this->generateCsrfToken( 'micropost/post' ),
        ) );
    }

    public function post()
    {
        if ( ! $this->request->isPost() ) {
            $this->forward404();
        }

        $token = $this->request->getPost( '_token' );
        if ( ! $this->checkCsrfToken( 'micropost/post', $token ) ) {
            return $this->redirect( '/' );
        }

        $content = $this->request->getPost( 'content' );

        $errors = array();

        if ( ! strlen( $content ) ) {
            $errors[] = '本文を入力してください'; 
        } else if ( strlen( $content ) > 140 ) {
            $errors[] = '本文は140文字以内で入力してください';
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

    public function edit( $params )
    {   
        
        $current_user = $this->session->get( 'user' );

        // 編集しようとした投稿がログインユーザのものか判定
        $micropost = $this->db_manager->get( 'Micropost' )
            ->isCurrentuserMicropost( $current_user['id'], $params['id'] );

        if ( ! $micropost ) {
            $this->forward404();
        }

        $micropost = $this->db_manager->get( 'Micropost' )
            ->fetchMicropostById( $params['id'] );

        return $this->render ( array(
            'micropost' => $micropost,
            '_token'    => $this->generateCsrfToken( 'micropost/edit' ),
        ) );  
    }

    public function update( $params )
    {
        if ( ! $this->request->isPost() ) {
            $this->forward404();
        }

        $token = $this->request->getPost( '_token' );
        if ( ! $this->checkCsrfToken( 'micropost/edit', $token ) ) {
            return $this->redirect( '/' );
        }

        $content = $this->request->getPost( 'content' );

        $errors = array();

        if ( ! strlen( $content ) )  {
            $errors[] = "本文を入力してください"; 
        } else if ( strlen( $content ) > 140 ) {
            $errors[] = "本文は140文字以内で入力してください";         
        }

        $micropost_model = $this->db_manager->get( 'Micropost' );
        $current_user = $this->session->get( 'user' );

        if ( count( $errors ) === 0 
            && $micropost_model->isCurrentuserMicropost( $current_user['id'], $params['id'] ) ) {
            // 入力チェックを通過しかつログインユーザの投稿だった場合、投稿の更新処理を行う
            $this->db_manager->get( 'Micropost' )
                ->update( $current_user['id'], $params['id'], $content );
            $message = '投稿の更新に成功しました';
        } else {
            $message = '';
        }
            
        $micropost = $micropost_model->fetchMicropostById( $params['id'] );
        
        // 投稿失敗時、編集画面を表示
        return $this->render( array (   
            'micropost' => $micropost,
            'errors'    => $errors,
            'message'   => $message,
            '_token'    => $this->generateCsrfToken( 'micropost/edit' ),
        ), 'edit' );
    }

    public function delete( $params )
    {   
        
        $current_user = $this->session->get( 'user' );

        $micropost_model = $this->db_manager->get( 'Micropost' );
        // 削除しようとした投稿がログインユーザのものか判定
        $micropost = $micropost_model->isCurrentuserMicropost( $current_user['id'], $params['id'] );
 
        if ( ! $micropost ) {
            $this->forward404();
        }

        $micropost_model->delete( $current_user['id'], $params['id'] ); 
        $message = '削除が完了しました';

        return $this->render( array (
            'microposts' => $micropost_model->fetchAllMicroposts(), 
            'content'       => '',
            'message' => $message, 
        ), 'index' );
    }
}