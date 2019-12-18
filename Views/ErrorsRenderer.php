<?php if(count($content) > 0) : ?>
  <div>
    <?php foreach ($content as $error) : ?>
      <p><?php echo $error; ?></p>
    <?php endforeach; ?>
  </div>
<?php endif ?>

