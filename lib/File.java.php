<?php
/**
 * Soon to be a port of Java's Abstract File Object implementation.
 * 
 * In PHP System directory path prefixes don't matter so we can skip those here.
 *
 * A File will be treated as a file, if given a directory it will treat it as such,
 * unlike java's version, as PHP is more finicky about how the file-system is treated.
 *
 * @author Nijikokun <nijikokun@shortmail.com>
 * @copyright AOL <http://aol.nexua.org>
 * @package File
 * @version 1.0.2
 * @since j.p1
 */
class File {
    /**
     * This abstract pathname's normalized pathname string.
     */
    private $path;
    
    const seperatorChar = '/';
    
    /**
     * Initializes a new File Object from parent and child or just parent.
     */
    public function __construct($parent = "", $child = "") {
        $parent = new String($parent);
        $child = new String($child);
        
        if($parent->isEmpty())
            throw new Exception("File path cannot be empty.");
            
        if($parent->isEmpty() && $child->isEmpty())
            throw new Exception("File path cannot be empty.");

        if($parent->substring(-1) == $this::seperatorChar && !$child->isEmpty())
            $this->path = $parent . $child;
        else if(!$child->isEmpty())
            $this->path = $parent . $this::seperatorChar . $child;
        else
            $this->path = $parent;
	}
    
    /**
     * Returns the current path name.
     *
     * @since 1.0.1
     */
    public function getName() {
        return basename($this->path);
    }
    
    /**
     * Returns the pathname string of this abstract pathname's parent.
     *
     * @return The pathname string of the parent directory or file.
     * @since 1.0.2
     */
    public function getParent() {
        return dirname($this->path);
    }
    
    /**
     * Returns path's parent as a File instead of String.
     *
     * @return File or Null
     * @since 1.0.2
     */
    public function getParentFile() {
        $parent = $this->getParent();
        
        if ($parent == "" || $parent == $this->path) 
            return null;
        
        return new File($parent);
    }
    
    /**
     * Determines if the current path we are using is the Absolute path.
     * @since 1.0.2
     */
    public function isAbsolute() {
        return (realpath($this->path) == $this->path);
    }
    
    /**
     * Returns the absolute form of this abstract pathname. 
     *
     * @return String
     * @since 1.0.2
     */
    public function getAbsolutePath() {
        return realpath($this->path);
    }
    
    /**
     * Returns the absolute form of the path as a File.
     *
     * @return File
     * @since 1.0.2
     */
    public function getAbsoluteFile() {
        return new File($this->getAbsolutePath());
    }
    
    /**
     * Verifies the existance of our current path.
     * Path or Directory, it will verify it either way.
     *
     * @since 1.0.1
     */
    public function exists() {
        return file_exists($this->path);
    }
    
    /**
     * Tells whether the current path is capable of being
     * written to.
     *
     * @since 1.0.1
     * @change Changed from #isWritable to #canWrite
     */
    public function canWrite() {
        return is_writable($this->path);
    }
    
    /**
     * Tells whether we can access our current path data.
     *
     * @since 1.0.1
     * @change Changed from #isReadable to #canRead
     */
    public function canRead() {
        return is_readable($this->path);
    }
    
    /**
     * Tells whether the current path is capable of being
     * executed by php.
     *
     * @since 1.0.1
     */
    public function isExecutable() {
        return is_executable($this->path);
    }
    
    /**
     * Tells whether the current path is a file.
     *
     * @since 1.0.1
     */
    public function isFile() {
        return is_file($this->path);
    }
    
    /**
     * Tells whether the current path is a directory.
     *
     * @since 1.0.1
     */
    public function isDirectory() {
        return is_dir($this->path);
    }
    
    /**
     * Determines if a file is hidden based on the prefix being a period.
     * Windows does hidden files differently, and would require DOS actions
     * to perform correctly so those have been left out.
     *
     * @since 1.0.1
     */
    public function isHidden() {
        return $this->path->startsWith('.');
    }
    
    /**
     * Returns the time that the file denoted by this abstract pathname was
     * last modified.
     *
     * @return  A <code>long</code> value representing the time the file was
     *          last modified, measured in milliseconds since the epoch
     *          (00:00:00 GMT, January 1, 1970), or <code>0L</code> if the
     *          file does not exist or if an I/O error occurs
     * @since 1.0.2
     */
    public function lastModified() {
        if ($this->exists())
            return correctmtime($this->path);
        
        throw new Exception('File ' . $this->getName() . ' does not exist.');
    }
    
    /**
     * Return file size if the file exists.
     * @since 1.0.2
     */
    public function length() {
        if($this->exists())
            return fsize($this->path);
        
        throw new Exception('File ' . $this->getName() . ' does not exist.');
    }
    
    /**
     * Creates file if and only if the file does not already exist.
     *
     * @return true on file creation, false otherwise.
     * @since 1.0.2
     */
    public function createNewFile() {
        $created = null;
        
        if(!$this->exists() && !$this->isDirectory())
            $created = fclose(fopen($this->path, "x"));
            
        if($created != null)
            return true;
            
        return false;
    }
    
    /**
     * Delete the current path. If the current path is a directory
     * only delete if the directory is empty.
     *
     * @return true on deletion, false otherwise.
     * @since 1.0.2
     */
    public function delete() {
        if(!$this->exists())
            return true;
        
        if($this->isDirectory && $this->isEmptyDir())
            unlink($this->path);
        else
            return false;
        
        if($this->isFile)
            unlink($this->path);
        
        return true;
    }

    private function isEmptyDir() { 
        return (($files = @scandir($this->path)) && count($files) <= 2); 
    } 
}