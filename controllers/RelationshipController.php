<?php 

class RelationshipController extends Controller
{
    public function insert()
    {   

        if (!$this->request->isPost()) {
            $this->forward404();
        }

        // フォローしたいユーザのIDをhiddenパラメータで受け取る
        $following_user_id = $this->request->getPost( 'following_user_id' );

        if ( ! $following_user_id ) {
            $this->forward404();
        }

        $token = $this->request->getPost( '_token' );
        if ( ! $this->checkCsrfToken( 'micropost/post', $token ) ) {
            return $this->redirect( '/' );
        }

        // フォローしたいユーザが存在するか確認
        $follow_user = $this->db_manager->get('User')
            ->fetchByUserById( $following_user_id  );

        if ( ! $follow_user ) {
            $this->forward404();
        }

        $current_user = $this->session->get('user');

        $relationship_model = $this->db_manager->get( 'Relationship' );
        if ( $current_user['id'] != $following_user_id  
            && ! $relationship_model->isFollowing( $current_user['id'], $following_user_id )
        
        ) {
            $relationship_model->insert( $current_user['id'], $following_user_id );
        } 
        
        return $this->redirect( '/' );
    }
}