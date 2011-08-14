<?php
// Include our sources
include('lib/Common.java.php');
include('lib/System.java.php');
include('lib/String.java.php');
include('lib/File.java.php');

// Initialize a String
$hello = new String("World");

// Show it lowercase
out::prntln("Lowercase of '{$hello->toString()}': " . $hello->toLowerCase());

// Show the string's equality without case
out::prntln("EqualsIgnoreCase test against 'world': " . (($hello->equalsIgnoreCase("world")) ? 'true' : 'false'));

// Show the string's containment for "e"
out::prntln("Contains 'e'? " . (($hello->contains("e")) ? 'true' : 'false'));

// Show the last index of o
out::prntln("Last index of 'o': " . ((!$hello->lastIndexOf("o")) ? 'false' :  $hello->lastIndexOf("o")));

// New Section
out::prntln();

// Initialize a File
$self = new File("Examples.java.php");

// Check validation.
out::prntln("Does it exist? " . (($self->exists()) ? 'true' : 'false'));