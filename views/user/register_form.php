
<div class="form-group">
    <label for="NickName">NickName</label>
    <input type="text" class="form-control" name="user_name" value="<?php print $this->escape($user_name); ?>" />
</div>
<div class="form-group">
    <label for="password">Password</label>
    <input type="password" class="form-control" name="password" value="<?php echo $this->escape($password); ?>" />
</div>
