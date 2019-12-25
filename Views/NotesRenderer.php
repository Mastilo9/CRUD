<div>
  <h2>Your diary</h2>
  <?php foreach ($content as $row) { ?>
      <div>
        <label>Title</label>
        <label> <?php echo $row['title']; ?>
        </label>    Essay</label><label> <?php echo $row['essay']; ?></label>
        <a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>/notes/delete?del=<?php echo $row['id'] ?>">delete</a>
        <a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>/notes/edit?edit=<?php echo $row['id'] ?>">edit</a>
      </div>
    <?php }; ?>
  <a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>/notes/add">Create new one</a>
</div>