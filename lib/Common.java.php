<?php
/**
 * Commonly needed functions for some Java -> PHP things to function properly.
 *
 * @author Nijikokun <nijikokun@shortmail.com>
 * @copyright AOL <http://aol.nexua.org>
 * @package Common
 * @version 1.0.1
 * @since j.p1
 */

/**
 * Last index of a string / character starting at the rightmost index.
 * Backwards searching, Case-insensitive.
 */
function strbipos($haystack = "", $needle = "", $offset = 0) {
    $len = strlen($haystack);
    $pos = stripos(strrev($haystack), strrev($needle), $len - $offset - 1);
    
    if($pos === false)
        return false;
        
    return $len - strlen($needle) - $pos;
}

/**
 * Last index of a string / character starting at the rightmost index.
 * Backwards searching, Case-sensitive.
 */
function strbpos($haystack = "", $needle = "", $offset = 0) {
    $len = strlen($haystack);
    $pos = strpos(strrev($haystack), strrev($needle), $len - $offset - 1);
    
    if($pos === false)
        return false;
        
    return $len - strlen($needle) - $pos;
}

/**
 * Windows utilizes DST and messes up filemtime. So 
 * we need to correct the time for that adjustment.
 *
 * @return adjusted filemtime
 */
function correctmtime($path) { 
    $time = filemtime($path); 
    $isDST = (date('I', $time) == 1); 
    $systemDST = (date('I') == 1); 
    $adjustment = 0; 

    if($isDST == false && $systemDST == true)
        $adjustment = 3600;
    else if($isDST == true && $systemDST == false)
        $adjustment = -3600;
    else
        $adjustment = 0;

    return ($time + $adjustment); 
} 

/**
 * PHP has issues reading files > 4GB due to 32b INT
 * So we need a function that can correctly read the file
 * size at large sizes. Utilizing in-house PHP functions
 * fsize was made to do this.
 *
 */
function fsize($file) {
  $fmod = filesize($file);
  
  if ($fmod < 0) 
    $fmod += 2.0 * (PHP_INT_MAX + 1);
    
  $i = 0;
  $f = fopen($file, "r");

  while (strlen(fread($f, 1)) === 1) {
    fseek($f, PHP_INT_MAX, SEEK_CUR);
    $i++;
  }

  fclose($f);
  
  if ($i % 2 == 1) 
    $i--;
    
  return ((float)($i) * (PHP_INT_MAX + 1)) + $fmod;
}

/**
 * Format sizes based on bytes.
 *
 * @return human readable size.
 */
function formatBytes($b, $precision = null, $spacer = ' ') {
    $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
    $c = 0;

    if(!$precision && $precision !== 0) {
        foreach($units as $k => $u)
            if(($b / pow(1024, $k)) >= 1) {
                $r["bytes"] = $b / pow(1024, $k);
                $r["units"] = $u;
                $c++;
            }
        
        return number_format($r["bytes"], 2) . $spacer . $r["units"];
    }
    
    return number_format($b / pow(1024,$p)) . $spacer . $units[$p];
}