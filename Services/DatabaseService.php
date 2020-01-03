<?php

namespace Services;

class DatabaseService
{
  private $host;
  private $user;
  private $password;
  private $database;
  private $connection;

  public function getDatabase(): string
  {
    return $this->database;
  }

  public function getConnection() {
    return $this->connection;
  }

  public function __construct(string $host, string $user, string $password, string $database) {
    $this->host = $host;
    $this->user = $user;
    $this->password  = $password;
    $this->database = $database;
  }

  public function connect() {
    $this->connection = mysqli_connect($this->host, $this->user, $this->password, $this->database);

    if(!$this->connection) {
      throw new \Exception("Connection not established!");
    }
  }

  public function executeQuery(string $query) {
    if(!($results = mysqli_query($this->connection, $query))) {
      throw new \Exception('No data in database!');
    }
    return mysqli_fetch_all($results,MYSQLI_ASSOC);
  }
}
