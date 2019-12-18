<?php

namespace Services;

class DatabaseService
{
  private $host;
  private $user;
  private $password;
  private $database;

  public function getHost(): string
  {
    return $this->host;
  }

  public function setHost(string $host)
  {
    $this->host = $host;
  }

  public function getUser(): string
  {
    return $this->user;
  }

  public function setUser(string $user)
  {
    $this->user = $user;
  }

  public function getPassword(): string
  {
    return $this->password;
  }

  public function setPassword(string $password)
  {
    $this->password = $password;
  }

  public function getDatabase(): string
  {
    return $this->database;
  }

  public function setDatabase(string $database)
  {
    $this->database = $database;
  }

  public function __construct(string $host, string $user, string $password, string $database) {
    $this->host = $host;
    $this->user = $user;
    $this->password  = $password;
    $this->database = $database;
  }

  public function connect() {
    $connection = mysqli_connect($this->host, $this->user, $this->password, $this->database) or die("could not connect to database");
    return $connection;
  }

  public function executeQuery( $conn, string $query) {
    return mysqli_query($conn, $query);
  }
}
