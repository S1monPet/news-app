<?php
/*
  Enostaven primer controlletja, ki ne uporablja modela.
  Njegova naloga je, da vrača statične HTML strani, kot je stran z napako.
*/

class pages_controller {
  public function error() {
    // Izpiše pogled s sporočilom o napaki
    require_once('views/pages/error.php');
  }
}
?>