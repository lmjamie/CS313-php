<form action="php/login_verify.php" method="post" class="col s6 offset-s3">
  <div class="row">
    <div class="input-field col s12">
      <input type="text" id="username" name="un" class="validate" required>
      <label for="username">Username</label>
    </div>
    <div class="input-field col s12">
      <input type="password" id="password" name="pw" class="validate" required>
      <label for="password">Password</label>
    </div>
  </div>
  <div class="row">
    <div class=<?php echo (!$adjust) ? "\"input-field col s4 offset-s1\"" :  "\"input-field col s5\"";?>>
      <button type="submit" class="btn waves-effects waves-purple green darken-1 green-text text-lighten-4">
        Login<i class="material-icons right">send</i>
      </button>
    </div>
    <div class="input-field col s6">
      <a href="create_account.php" class="btn waves-effects waves-red blue darken-1 green-text text-lighten-5">New Account<i class="material-icons right">account_circle</i></a>
    </div>
  </div>
</form>
