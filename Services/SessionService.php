<?php

namespace Services;

  class SessionService {
    public function init() : void {
      session_start();
    }

    public function setSessionParam(string $param, string $value) : void {
      $_SESSION[$param] = $value;
    }

    public function getSessionParam(string $param) : string {
      return $_SESSION[$param];
    }

    public function logout(string $paramToUnset) : void {
      session_destroy();
      unset($_SESSION[$paramToUnset]);
    }
  }
