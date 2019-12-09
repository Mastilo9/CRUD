<?php

namespace Controller;

use Service\DatabaseService;
use Service\RenderService;

class NoteController
{
  public function __construct(DatabaseService $db, RenderService $renderer)
  {
  }

  public function edit()
  {
    $id = $_GET['id'];
    $note = $this->db->execute('SELECT * FROM notes ...');

    $this->renderer->render('templateName.php', ['note' => $note]);
  }
}