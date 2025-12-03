<?php

function required($name, $file, $id = null)
{
  if (is_null($id)) {
    header("Location: ../../$file.php?error=$name wajib diisi!");
    exit();
  } else {
    header("Location: ../../$file.php?id=$id&error=$name wajib diisi!");
    exit();
  }
}
