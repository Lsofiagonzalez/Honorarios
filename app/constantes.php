<?php
  define('SERVIDOR', (isset($_SERVER['HTTP_HOST'])) ? (strpos($_SERVER['HTTP_HOST'], '192.168.2.242') !== false) ? 'http://192.168.2.58:8080/documental/' : 'http://apig.hiu.org.co:8080/documental/' : 'http://192.168.2.58:8080/documental/');
?>