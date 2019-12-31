<form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>/notes/edit?edit=<?php echo $content[0] ?>" method="post">
  <div>
    <h2>Update Note</h2>
    <div>
      <label>Title(this is for search)</label>
      <input type="text" name="title" required/>
    </div>
    <div>
      <label>Essay(this will be edited)</label>
      <textarea rows="2" cols="80" name="essay" required></textarea>
    </div>
  </div>
  <button type="submit" name="edit" >EDIT</button>
</form>