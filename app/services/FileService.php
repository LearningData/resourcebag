<?php
class FileService {
    public static function listFiles($dir) {
        $files = array();

        if(file_exists($dir)) {
            if($handle = opendir($dir)) {
                while (false !== ($file = readdir($handle))) {
                    if(is_file($dir . $file) && substr($file, 0) != ".") {
                        $files []= $file;
                    }
                }
                closedir($handle);
            }
        }

        return $files;
    }

}
?>