<form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>/notes/add" method="post">
  <h2>Create Note</h2>
      <div>
        <label for="title">Title</label>
        <input type="text" name="title" id="title" required/>
      </div>
      <div>
        <label for="essay">Essay</label>
        <textarea rows="2" cols="80" name="essay" id="essay" required></textarea>
      </div>
    </div>
    <div>
      <button type="submit" name="save" >SAVE</button>
    </div>
</form>