<form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>/notes/add" method="post">
  <h2>Create Note</h2>
      <div>
        <label>Title</label>
        <input type="text" name="title" required/>
      </div>
      <div>
        <label>Essay</label>
        <textarea rows="2" cols="80" name="essay" required></textarea>
      </div>
    </div>
    <div>
      <button type="submit" name="save" >SAVE</button>
    </div>
</form>