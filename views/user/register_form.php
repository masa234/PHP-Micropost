
<div class="card">
    <div class="card-body">
        <div class="form-group">
            <label for="user_name">ユーザ名</label>
            <input type="text" class="form-control" name="user_name" value="<?php print $this->escape( $user_name ); ?>" />
        </div>
        <div class="form-group">
            <label for="email">メールアドレス</label>
            <input type="email" class="form-control" name="email" value="<?php print $this->escape( $email ); ?>" />
        </div>
        <div class="form-group">
            <label for="password">パスワード</label>
            <input type="password" class="form-control" name="password" value="<?php print $this->escape( $password ); ?>" />
        </div>
    </div>
</div>