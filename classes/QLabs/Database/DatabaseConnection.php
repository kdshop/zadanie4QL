<?php
namespace QLabs\Database;

use QLabs\Interfaces\DB;

class DatabaseConnection implements DB
{
    private $files;

    public function __construct($files) {
        foreach ($files as $file) {
            $this->files[] = __DIR__ . '/../../../database/' .$file;
        }
    }

    public function readFromDB(): array{

        foreach ($this->files as $file) {

            if (file_exists($file)) {

                $thisfile = fopen($file, 'r');
                $size = filesize($file);

                if (flock($thisfile, LOCK_EX)) {

                    if ($size != 0) {
                        $filecont = fread(fopen($file, 'r'), $size);
                    } else {
                        $filecont = '';
                    }

                } else {
                    throw new Exception('Error locking database files! Please try again later.');
                }

                fwrite($thisfile, $filecont);
                flock($thisfile, LOCK_UN);
                fclose($thisfile);

            } else {
                fopen($file, 'w+');
                fclose($file);
            }

            $resources[] = json_decode($filecont, true);

        }

        return $resources;

    }

    public function saveToDB(array $json){

    }



//$people = fopen("peopleDB.json","w+");
//$skills = fopen("skillsDB.json", "w+");
//
//if (flock($people,LOCK_EX) && flock($skills, LOCK_EX)) {
//
//
//flock($people,LOCK_UN);
//}
//else {
//    throw new Exception('Error locking database files! Please try again later.');
//}
//
//fclose($file);

}