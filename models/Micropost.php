<?php 

class Micropost extends Model
{
    public function insert( $user_id, $content )
    {
        $now = new DateTime();
        
        $sql = "
            INSERT INTO micropost( user_id, body, created_at ) 
                VALUES( :user_id, :body, :created_at )   
            ";

        $stmt = $this->execute( $sql, array(
            ':user_id'    => $user_id,
            ':body'       => $content,
            ':created_at' => $now->format( 'Y-m-d H:i:s' ),
        ) );
    }

    // 全てのMicropostを取得
    public function fetchAllMicroposts() 
    {
        $sql = "
            SELECT * FROM micropost 
                LEFT JOIN user
                    ON micropost.user_id = user.id
                        ORDER BY micropost.created_at DESC
            ";

        return $this->fetchAll( $sql );
    }

    // 特定のユーザのmicropostを取得
    public function fetchAllMicropostsByUserID( $user_id ) 
    {
        $sql = "
            SELECT * FROM micropost 
                INNER JOIN user
                    ON micropost.user_id = :user_id
                        ORDER BY micropost.created_at DESC
            ";
        
        return $this->fetchAll( $sql, array( ':user_id' => $user_id ) );
    }
    
    public function fetchByIdAndUserName( $id, $user_name )
    {
        $sql = "
            SELECT a.* , u.user_name
                FROM micropost a
                    LEFT JOIN user u ON u.id = a.user_id
                WHERE a.id = :id
                    AND u.user_name = :user_name
        ";

        return $this->fetch( $sql, array(
            ':id'        => $id,
            ':user_name' => $user_name,
        ) );
    }
}