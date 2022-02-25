<?php
function thread($func,$variables=[]) {
    if(!function_exists('shell_exec')) return null;
    if(!is_array($variables)) $variables = [];
    $refl = new \ReflectionFunction($func); $rp = [];
    $code = explode("\n", file_get_contents($refl->getFileName()));
    $code = implode("\n",array_slice($code, ($begin = $refl->getStartLine()-1), (($refl->getEndLine())-($begin))));
    $code = str_replace((explode('{',$code.'{')[0] ?? '').'{','',$code);
    $code = str_replace('}'.(($lc = explode('}','}'.$code))[count($lc)-1] ?? ''),'',$code);
    $trgg = "nohup setsid ".PHP_BINDIR."/php ".(($inipath = php_ini_loaded_file()) ? "-c $inipath " : "");
    if(!empty($params = $refl->getParameters()) && is_array($dfvars = get_defined_vars()))
      foreach($params as $k => $v)
        if(!empty($k = ($v->name ?? null)) && !isset($variables[$k])) 
          $variables[$k] = ($dfvars[$k] ?? ($_REQUEST[$k] ?? ($_SERVER[$k] ?? null)));
    shell_exec($bash = ($trgg."-r \"@parse_str(urldecode('".urlencode(http_build_query($variables))."')); eval(urldecode('".urlencode($code)."'));\" > /dev/null 2>&1 &"));
    return $bash;
}
?>
