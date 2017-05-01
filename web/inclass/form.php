<form action="results.php" method="post">
  Name<input type="text" name="name"><br>
  Email<input type="text" name="email"><br>
  Major<br><input type="radio" name="major" value="CS"> Computer Science<br>
  <input type="radio" name="major" value="WDD">Web Design and Development<br>
  <input type="radio" name="major" value="CIT"> Computer Information Technology<br>
  <input type="radio" name="major" value="CE"> Computer Engineering<br>
  Places Visited<br><input type="checkbox" name="visited[]" value="NA"> North America <br>
  <input type="checkbox" name="visited[]" value="SA"> South America <br>
  <input type="checkbox" name="visited[]" value="EU"> Europe<br>
  <input type="checkbox" name="visited[]" value="AS"> Asia<br>
  <input type="checkbox" name="visited[]" value="AU"> Australia<br>
  <input type="checkbox" name="visited[]" value="AG"> Africa<br>
  <input type="checkbox" name="visited[]" value="AN"> Antarctica<br>
  Comments<br><textarea id="" cols="30" rows="10" name="comments"></textarea><br>
  <input type="submit">
</form>
