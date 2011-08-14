<?php
/**
 * The <code>String</code> class represents strings in a semantic way like in Java. All
 * string methods are given the correct namespace and use a single method of naming.
 *
 * PHP is fond for it's inability to follow a single internal function/method naming scheme.
 * This is to help reduce the clutter.
 *
 * @author Nijikokun <nijikokun@shortmail.com>
 * @copyright AOL <http://aol.nexua.org>
 * @package String
 * @version 1.0.5
 * @since j.p1
 */
class String {
    private $str;
    private $length;
    
    public function __construct($str = "") {
        $this->str = $str;
        $this->length = strlen($str);
    }

    /**
     * Verifies the emptiness of our current String.
     */
    public function isEmpty() {
        return $this->length == 0 || $this->str == "" || $this->str == null;
    }
    
    /**
     * Returns our current String length
     */
    public function length() {
        return $this->length;
    }
    
    /**
     * Converts an indice to the given character at the point.
     *
     * @todo Create Char Object.
     * @return Char
     */
    public function charAt($index) {
        if (($index < 0) || ($index >= $this->length))
            throw new Exception("Index out of bounds.");
            
        return $this->str[$index];
    }
    
    /**
     * Converts all characters in the current String
     * to their ord counterparts and returns in array form.
     *
     * @return Array
     */
    public function getBytes() {
        $bytes = array();
        
        for($i = 0; $i < $this->length; $i++){
             $bytes[] = ord($this->str[$i]);
        }
        
        return $bytes;
    }
    
    /**
     * Tells whether the sequence of characters in our current String
     * matches the sequence in another.
     *
     * @param $another String to be checked upon.
     * @return Boolean
     */
    public function equals($another) {
        if ($this->str == $another)
            return true;

        if ($this->length == strlen($another)) {
            for($i = 0; $i < strlen($this->str); $i++)
                if ($this->str[$i] != $another[$i])
                    return false;
                    
            return true;
        }
        
        return false;
    }
    
    /**
     * Tells whether the sequence of characters in our current String
     * matches the sequence in another without case sensitivity.
     *
     * @param $another String to be checked upon.
     * @return Boolean
     */
    public function equalsIgnoreCase($another) {
        if ($this->equals($another))
            return true;
            
        if ($this->toLowerCase() == strtolower($another))
            return true;
            
        if ($this->length == strlen($another)) {
            for($i = 0; $i < strlen($this->str); $i++)
                if (strtolower($this->str[$i]) != strtolower($another[$i]))
                    return false;
                    
            return true;
        }
        
        return false;
    }
    
    /**
     * Lexigraphically compares two strings and returns the numeric value.
     * This is UTF-8/16 Based. Beware of usage.
     *
     * @todo Create Integer Object
     * @param $another String to be checked upon.
     * @return Integer
     */
    public function compareTo($another) {
        $l1 = mb_strlen($this->str);
        $l2 = mb_strlen($another);
        
        $i = 0;
        while ($i < $l1 && $i < $l2) {
            $c1 = mb_convert_encoding(mb_substr($this->str, $i, 1),'utf-16le');
            $c1 = ord($c1[0]) + (ord($c1[1]) << 8);
            $c2 = mb_convert_encoding(mb_substr($another, $i, 1),'utf-16le');
            $c2 = ord($c2[0]) + (ord($c2[1]) << 8);
            $res = $c1 - $c2;
            
            if ($res != 0)
                return $res;
                
            $i++;
        }
        
        return $l1 - $l2;
    }
    
    /**
     * Converts all characters in the current String to lowercase.
     *
     * @return string
     */
    public function toLowerCase() {
        return strtolower($this->str);
    }
    
    /**
     * Converts all characters in the current String to uppercase.
     *
     * @since 1.0.1
     * @return string
     */
    public function toUpperCase() {
        return strtoupper($this->str);
    }
    
    /**
     * Returns a new String containing the character array
     * from the given indices.
     *
     * @param $a Beginning index
     * @param $b Ending index
     * @return string
     * @version 0.2
     */
    public function substring($a = "", $b = "") {
        if($a == "" && $b == "")
            throw new Exception("Invalid start and end.");
            
        if(!is_int($a) && !is_int($b))
            throw new Exception("Start and end must be numeric.");
        
        if(is_int($a))
            return substr($this->str, $a);
            
        if(is_int($a) && is_int($b))
            return substr($this->str, $a, $b);
            
        throw new Exception("Invalid start and end.");
    }
    
    /**
     * Tells whether or not the current String contains 
     * a given needle.
     *
     * @version 0.3
     */
    public function contains($needle) {
        return strpos($this->str, $needle) !== false;
    }
    
    /**
     * Tells whether or not the current String begins
     * with the string given.
     *
     * @param $needle String to be compared to.
     * @param $case Boolean that toggles case sensitivity.
     * @return Boolean
     */
    public function startsWith($needle, $case = true) {
        if($case)
            return (strcmp(substr($this->str, 0, strlen($needle)), $needle) === 0);
            
        return (strcasecmp(substr($this->str, 0, strlen($needle)), $needle) === 0);
    }
    
    /**
     * Tells whether or not the current String begins
     * with the string given.
     *
     * @param $needle String to be compared to.
     * @param $case Boolean that toggles case sensitivity.
     * @return Boolean
     */
    public function endsWith($needle, $case = true) {
        if($case)
            return (strcmp(substr($this->str, strlen($this->str) - strlen($needle)), $needle) === 0);
        
        return (strcasecmp(substr($this->str, strlen($this->str) - strlen($needle)), $needle) === 0);
    }
    
    /**
     * Returns the index within this string of the first occurrence of the
     * specified substring, starting at the specified index. If the substring
     * is not found, false is returned.
     * 
     * @since 1.0.5
     * @param $needle Substring to be searched for.
     * @param $starting Starting index, default 0.
     * @return False or Position
     */
    public function indexOf($needle, $starting = 0, $case = true) {
        if($starting != 0)
            $pos = ($case) ? strpos($this->str, $needle, $starting) : stripos($this->str, $needle, $starting);
        else
            $pos = ($case) ? strpos($this->str, $needle) : stripos($this->str, $needle);
            
        if($pos === false)
            return false;

        return $pos;
    }
    
    /**
     * Returns the index within this string of the last occurrence of the
     * specified substring, starting rightmost at the specified index. 
     * If the substring is not found, false is returned.
     *
     * @since 1.0.5
     * @param $needle Substring to be searched for.
     * @param $starting Starting index, default 0.
     * @return False or Position
     */
    public function lastIndexOf($needle, $starting = 0, $case = true) {
        if($starting != 0)
            $pos = ($case) ? strrpos($this->str, $needle, $starting) : strripos($this->str, $needle, $starting);
        else
            $pos = ($case) ? strrpos($this->str, $needle) : strripos($this->str, $needle);
            
        if($pos === false)
            return false;

        return $pos;
    }
    
    /**
     * Concatenates the specified string to the end of this string.
     *
     * @since 1.0.5
     * @param $str the <code>String</code> that is concatenated to the end of this <code>String</code>.
     * @return String with the new section concatenated.
     */
    public function concat($str) {
        return new String($this->str + $str);
    }
    
    /**
     * Replaces one string with another in the current String.
     *
     * @since 1.0.5
     * @param $old Old character array (String).
     * @param $new New character array (String).
     */
    public function replace($old, $new) {
        return str_replace($this->str, $old, $new);
    }
    
    /**
     * Converts a string based on the string delimiter into an array of strings, each a substring of the string.
     *
     * @since 1.0.5
     * @param $needle String delimiter
     */
    public function split($needle) {
        return explode($this->str, $needle);
    }
    
    /**
     * To keep with Java's internal coding, we issue our own toString().
     *
     * You can use ->toString() or (string)$variable;
     * Either works fine.
     *
     * @return string
     */
    public function toString() {
        return $this->str;
    }
    
    /**
     * Magic internals to return string upon casting.
     *
     * @return string
     */
    public function __toString() {
        return $this->str;
    }
}