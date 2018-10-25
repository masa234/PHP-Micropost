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