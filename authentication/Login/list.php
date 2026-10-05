<?php
// look inside a folder, and inside every folder in it, for the home pages
function findFiles($folder) {

    $items = scandir($folder);

    foreach ($items as $item) {

        // skip the "." and ".." entries
        if ($item == "." || $item == "..") {
            continue;
        }

        $path = $folder . "/" . $item;

        if (is_dir($path)) {
            // it's a folder, so search inside it too
            findFiles($path);
        } else {
            // it's a file, check the name (lowercase so capitals don't matter)
            $name = strtolower($item);

            if ($name == "admin_home.php" || $name == "student_home.php") {
                echo $path . "<br>";
            }
        }
    }
}

// start searching from the checkmate folder (two folders up from here)
findFiles(__DIR__ . "/../..");
?>