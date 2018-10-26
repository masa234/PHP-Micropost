<?php

class Relationship extends Model
{   
    // フォロー
    public function insert( $current_user_id, $following_user_id )
    {   
        $sql = "
            INSERT INTO relationship( user_id, following_id )
                VALUES ( :user_id, :follwing_id )
            ";
        
        $stmt = $this->execute( $sql , array( 
            ':user_id'     => $current_user_id,
            ':follwing_id' => $following_user_id,
         ) );
    }

    // ログインユーザが特定のユーザをフォローしているか判定
    public function isFollowing( $current_user_id, $following_user_id )
    {   
        $sql = "
            SELECT COUNT( user_id ) as count 
                FROM relationship
                    WHERE user_id = :current_user_id 
                        AND following_id = :following_user_id
            ";
        
        $row = $this->fetch( $sql, array(
            ':current_user_id'   => $current_user_id,
            ':following_user_id' => $following_user_id,
        ) );
  
        if ( $row['count'] == '1' ) {
            return true;
        }

        return false;
    }
}

