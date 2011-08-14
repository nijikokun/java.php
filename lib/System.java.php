<?php
/**
 * The <code>System</code> class contains several useful class fields
 * and methods. It is a static class.
 *
 * @author Nijikokun <nijikokun@shortmail.com>
 * @copyright AOL <http://aol.nexua.org>
 * @package System
 * @version 1.0
 * @since j.p1
 */
class System { }

/**
 * Controls Objects being sent to the PrintStream or Reader (Browser / Terminal).
 *
 * @author Nijikokun <nijikokun@shortmail.com>
 * @copyright AOL <http://aol.nexua.org>
 * @package System
 * @subpackage out
 * @version 1.0
 * @since j.p1
 */
class out extends System {
    /**
     * Prints a String and then terminate the line.
     * We use prnt because PHP has an issue with over-loading / over-riding functions.
     *
     * @param $x The <code>Object</code> to be printed.
     */
    public static function prntln($x = '') {
        return isset($_SERVER['SERVER_PROTOCOL']) ? print $x . "<br />" . PHP_EOL : print $x . PHP_EOL;
    }
    
    /**
     * Prints an Object without line termination.
     * We use prnt because PHP has an issue with over-loading / over-riding functions.
     *
     * @param $x The <code>Object</code> to be printed.
     */
    public static function prnt($x = '') {
        print $x;
    }
}