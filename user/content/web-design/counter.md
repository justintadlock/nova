---
title : "PHP Hit Counter"
---

This is a basic site hit counter. What it does is take a few lines of code that open up a file called (`countlog.txt`) and changes a simple number in it.

First off, what you need to do is make a new (`.php`) file in your text editor and place this code in it.  The only thing you may need to change is the parts of the code that says (`/path/to/countlog.txt`).

```
<?php

// Add correct path to your countlog.txt file.
$path = '/path/to/countlog.txt';

// Opens countlog.txt to read the number of hits.
$file  = fopen( $path, 'r' );
$count = fgets( $file, 1000 );
fclose( $file );

// Update the count.
$count = abs( intval( $count ) ) + 1;

// Output the updated count.
echo "{$count} hits\n";

// Opens countlog.txt to change new hit number.
$file = fopen( $path, 'w' );
fwrite( $file, $count );
fclose( $file );
```

Save the file as (`counter.php`). Now, on to the next part.  Simply make a file named (`countlog.txt`) and put a (`0`) in it. Then save. Or, you could put whatever number you want to in the file. This is where you counter will start counting from. If your last hit counter was already at 22,000 hits, why start over? Just type in (`22000`) in the (`countlog.txt`) file!

To include the file in any page in your site all you have to do is include it. Here's the code.

```
<?php include( '/path/to/counter.php' ); ?>
```

Of course, you may have to change the path on that as well, depending on what directory you put your file in. Or, you could just put the (`counter.php`) code inside of any page you want. It will work just the same.
