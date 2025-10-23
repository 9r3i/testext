<?php
/* initialize */
new testext;
/**
 * ~ testing extension for firefox
 * authored by 9r3i
 * uri: github.com/9r3i
 * started at october 23rd 2025
 */
class testext{
  const version='1.0.0';
  protected $prefixKey='tx';
  protected $methods=[
    'save',
    'test',
    'on',
  ];
  public function __construct(){
    /* set default headers */
    $this->head();
    /* check access token (dynamic key) */
    if(!isset($_POST['token'])
      ||!$this->isValidDynamicKey($_POST['token'])){
      return $this->error('Invalid access token.');
    }
    /* check request method as registered method */
    if(!isset($_POST['method'])
      ||!in_array($_POST['method'],$this->methods)
      ||!method_exists($this,$_POST['method'])){
      return $this->error('Invalid request.');
    }
    /* prepare argument decode from json array */
    $args=isset($_POST['args'])?@json_decode($_POST['args'],true):[];
    $args=is_array($args)?array_values($args):[];
    /* execute method */
    $out=@\call_user_func_array([$this,$_POST['method']],$args);
    /* return output to the result */
    return is_string($out)?$this->result($out)
      :$this->error('Request method "'.$_POST['method'].'" failed.');
  }
  private function on(){
    return json_encode(1);
  }
  private function test(){
    return json_encode(func_get_args());
  }
  /* save or write info of content */
  private function save($file='',$content=''){
    $line=str_repeat('=',20);
    $date=date('Y-m-d H:i:s');
    $boundary="\n\n\n\n{$line} {$file} | {$date} {$line}\n\n";
    $o=@fopen('save.txt','ab+');
    $w=@fwrite($o,$boundary.$content);
    @fclose($o);
    return 'OK';
  }
  /* check a valid dynamic key */
  final protected function isValidDynamicKey(string $key=''){
    /* check prefix key */
    if(strpos($key,$this->prefixKey)!==0){return false;}
    /* get raw key */
    $rkey=substr($key,strlen($this->prefixKey));
    /* convert key to time */
    $skey=base_convert($rkey,36,10);
    /* return as bool */
    return $skey>time()?true:false;
  }
  /* error output --> method: result */
  final protected function error(string $s=''){
    $s=$s?$s:'Unknown error.';
    return $this->result('Error: '.$s);
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

