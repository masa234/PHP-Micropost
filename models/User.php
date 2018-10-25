<?php 

class User extends Model
{   

    public function getGravatarUrl( $email, $size = 100 ) 
    {   
        var_dump( $email );
        $default = "https://www.somewhere.com/homestar.jpg";
        $gravatar_url = "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?d=" . urlencode( $default ) . "&s=" . $size;
    
        return $gravatar_url;
    }

    // ユーザ追加
    public function insert( $user_name, $email, $password )
    {
        $password = $this->hashPassword( $password );
        $now = new DateTime();

        $sql = "
            INSERT INTO user( user_name, email ,password, created_at )
                VALUES( :user_name, :email, :password, :created_at )
            ";
        
        $stmt = $this->execute( $sql, array(
            ':user_name'   => $user_name,
            ':email'       => $email,           
            ':password'    => $password,
            ':created_at'  => $now->format( 'Y-m-d H:i:s' ),
        ) );
    }

    public function update(  $current_user_id ,$user_name, $email, $password )
    {   
        $password = $this->hashPassword( $password );

        $sql = " 
            UPDATE user
                SET user_name = :user_name,
                    email = :email,
                    password = :password
                    WHERE id = $current_user_id;
        ";

        $stmt = $this->execute( $sql, array(
            ':user_name'   => $user_name,
            ':email'       => $email,           
            ':password'    => $password,
        ) ); 
    }

    public function hashPassword( $password )
    {
        return password_hash( $password , PASSWORD_DEFAULT );
    }

    // 与えられたIDのユーザのデータを連想配列で返却
    public function fetchByUserById( $user_id )
    {
        $sql = "
            SELECT * FROM user 
                WHERE id = :user_id
            ";

        return $this->fetch( $sql, array( ':user_id' => $user_id ) );
    }

    // 与えられたユーザ名、パスワードのユーザのデータを連想配列で返却
    public function fetchByUserNameAndEmail( $user_name, $email )
    {
        $sql = "
            SELECT * FROM user 
                WHERE user_name = :user_name
                    AND email = :email
            ";

        return $this->fetch( $sql, array( ':user_name' => $user_name, ':email' => $email ) );
    }

    // 入力されたユーザ名が一意であるかを判定する
    public function isUniqueUserName( $user_name )
    {
        $sql = "
            SELECT COUNT( id ) as count FROM user
                WHERE user_name = :user_name
            ";
        
        $row = $this->fetch( $sql, array( ':user_name' => $user_name ) );
        if ( $row['count'] == '0' ) {
            return true;
        }

        return false;
    }
}