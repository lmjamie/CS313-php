<form action="php/create_verify.php" method="post" class="col s10 offset-s1">
  <div class="row">
    <div class="input-field col s10 offset-s1">
      <input type="text" id="new username" name="un" class="validate" required>
      <label for="username">New Username</label>
    </div>
    <div class="input-field col s10 offset-s1">
      <input type="password" id="password" name="pw" class="validate" required>
      <label for="password">Password</label>
    </div>
    <div class="input-field col s10 offset-s1">
      <input type="password" id="passwordc" name="pwc" class="validate" required>
      <label for="passwordc" data-error="Passwords Do Not Match" data-success="Passwords Match">Confirm Password</label>
    </div>
    <div class="input-field col s5 offset-s1">
      <input type="text" id="fname" name="fn" class="validate" required>
      <label for="fname">First Name</label>
    </div>
    <div class="input-field col s5">
      <input type="text" id="lname" name="ln" class="validate" required>
      <label for="lname">Last Name</label>
    </div>
  </div>
  <div class="row">
    <div class="input-field col s4 offset-s2">
      <button type="submit" class="btn waves-effects waves-purple green darken-1 green-text text-lighten-4">
        Create Account<i class="material-icons right">done</i>
      </button>
    </div>
    <div class="input-field col s4">
      <a href="login.php" class="btn waves-effects red green-text text-lighten-5">Cancel<i class="material-icons right">cancel</i></a>
    </div>
  </div>
</form>
