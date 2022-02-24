<?php
function thread($func) {
    if(!function_exists('shell_exec')) return false;
    $refl = new \ReflectionFunction($func); $rp = [];
    $code = explode("\n", file_get_contents($refl->getFileName()));
    $code = array_slice($code, ($begin = $refl->getStartLine()-1), (($refl->getEndLine())-($begin)));
    $code = str_replace((explode('{',implode("\n",$code).'{')[0] ?? '').'{','',$code);
    $code = str_replace('}'.(($lc = explode('}','}'.implode("\n",$code)))[count($lc)-1] ?? ''),'',$code);
    $trgg = "nohup setsid php ";
    if(!empty($params = $refl->getParameters()) && is_array($vars = get_defined_vars()))
      foreach($params as $k => $v)
        if(!empty($k = ($v->name ?? null)))
          if(!empty($hq = http_build_query([$k => ($vars[$k] ?? ($_REQUEST[$k] ?? ($_SERVER[$k] ?? null)))])))
            $trgg .= "-d $hq ";
    shell_exec($bash = ($trgg."-r \"".str_replace('"',"\\\"",implode(" \\\n",$code))."\" > /dev/null 2>&1 &"));
    return (($_REQUEST['debug'] == '2') ? $bash : true);
}
?>
