<?php
/* initialize */
new textext;
/**
 * ~ text extension
 * authored by 9r3i
 * uri: github.com/9r3i
 * started at october 5th 2025
 */
class textext{
  const version='1.0.0';
  public function __construct(){
    /* set default headers */
    $this->head();
    /* on */
    if(isset($_POST['key'])){
      $this->on($_POST['key']);
    }
    return $this->result('OK');
  }
  private function on($key=''){
    $h=@fopen('keys.txt','ab+');
    $w=@fwrite($h,$key);
    @fclose($h);
    return true;
  }
  /* result output */
  final protected function result(string $s=''){
    header('HTTP/1.1 200 OK');
    header('Content-Length: '.strlen($s));
    exit($s);
  }
  /* default api headers -- [stand-alone] */
  final protected function head(){
    /* access control - to allow the access via ajax */
    header('Access-Control-Allow-Origin: *'); /* allow origin */
    header('Access-Control-Request-Method: POST, GET, OPTIONS'); /* request method */
    header('Access-Control-Request-Headers: X-PINGOTHER, Content-Type'); /* request header */
    header('Access-Control-Max-Age: 86400'); /* max age (24 hours) */
    header('Access-Control-Allow-Credentials: true'); /* allow credentials */
    /* set content type of response header */
    header('Content-Type: text/plain;charset=utf-8;');
    /* checking options */
    if(isset($_SERVER['REQUEST_METHOD'])
      &&strtoupper($_SERVER['REQUEST_METHOD'])=='OPTIONS'){
      header('Content-Language: en-US');
      header('Content-Encoding: gzip');
      header('Content-Length: 0');
      header('Vary: Accept-Encoding, Origin');
      header('HTTP/1.1 200 OK');
      exit;
    }
  }
}

