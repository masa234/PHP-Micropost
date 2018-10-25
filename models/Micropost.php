<?php 

class Micropost extends Model
{
    public function insert( $user_id, $content )
    {
        $now = new DateTime();
        
        $sql = "
            INSERT INTO micropost( user_id, content, created_at ) 
                VALUES( :user_id, :content, :created_at )   
            ";

        $stmt = $this->execute( $sql, array(
            ':user_id'    => $user_id,
            ':content'       => $content,
            ':created_at' => $now->format( 'Y-m-d H:i:s' ),
        ) );
    }

    // 全てのMicropostを取得
    public function fetchAllMicroposts() 
    {
        $sql = "
            SELECT  
                micropost.id,
                micropost.user_id, 
                micropost.content, 
                micropost.created_at,
                user.user_name,
                user.email
            FROM 
                micropost LEFT JOIN user
            ON 
                micropost.user_id = user.id
                    ORDER BY micropost.created_at DESC
            ";

        return $this->fetchAll( $sql );
    }

    // 特定のユーザのmicropostを取得
    public function fetchAllMicropostsByUserID( $user_id ) 
    {   
        $sql = "
            SELECT  
                micropost.id,
                micropost.user_id, 
                micropost.content, 
                micropost.created_at,
                user.user_name,
                user.email
            FROM 
                micropost LEFT JOIN user
            ON 
                micropost.user_id = user.id
            WHERE 
                micropost.user_id = :user_id
                    ORDER BY micropost.created_at DESC
            ";

        return $this->fetchAll( $sql, array( ':user_id' => $user_id ) );
    }

    public function fetchMicropostById( $micropost_id )
    {
        $sql = "
            SELECT  
                micropost.id,
                micropost.user_id, 
                micropost.content, 
                micropost.created_at,
                user.user_name,
                user.email
            FROM 
                micropost LEFT JOIN user
            ON 
                micropost.user_id = user.id
            WHERE 
                micropost.id = :micropost_id
                    ORDER BY micropost.created_at DESC
            ";

        return $this->fetch( $sql, array( ':micropost_id' => $micropost_id ) );
    }   
    
    // ログインユーザの投稿かどうかを判定
    public function isCurrentuserMicropost( $current_user_id, $micropost_id )
    {       
        $sql = "
            SELECT COUNT( id )  as count FROM micropost 
                WHERE user_id = :user_id
                    AND id = :micropost_id
            ";

        $row = $this->fetch( $sql, array( ':user_id' => $current_user_id, ':micropost_id' => $micropost_id ) );

        if ( $row['count'] == '1' ) {
            return true;
        }

        return false;
    }

    public function update( $current_user_id, $micropost_id, $content )
    {
        $sql = "
            UPDATE micropost 
                SET content = :content
                WHERE id = :micropost_id
                    AND user_id = :current_user_id
            ";

        $stmt = $this->execute( $sql, array(
            ':content'        => $content,
            ':micropost_id'   => $micropost_id,
            ':current_user_id'=> $current_user_id,
        ) );
    }

    public function delete( $current_user_id, $micropost_id )
    {   
        $sql = "
            DELETE FROM micropost 
                WHERE id = :micropost_id 
                AND
                user_id  = :current_user_id  
            ";

        $stmt = $this->execute( $sql, array(
            ':micropost_id'    => $micropost_id,
            ':current_user_id'=> $current_user_id,
        ) );
    }
}