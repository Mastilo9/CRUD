<?php

namespace Services;

  class SessionService
  {

    function __construct() {

    }

    public function init() {
      session_start();
    }

    public function destroy() {
      session_destroy();
    }

    public function unsetParam(string $param) {
      unset($_SESSION[$param]);
    }

    public function setSessionParam(string $param, string $value) {
      $_SESSION[$param] = $value;
    }

    public function getSessionParam(string $param) : string {
      return $_SESSION[$param];
    }

  }
