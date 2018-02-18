<?php

namespace QLabs\Controllers;

use QLabs\Database\DatabaseConnection;

class People
{
    private $args;
    private $db;

    public function __construct(array $arguments, DatabaseConnection $connection) {
        $this->db = $connection;
        $this->args =  $arguments;
    }

    public function showList() {
        $list = $this->db->search();

        foreach ($list as $value) {
            print($value.PHP_EOL);
        }

    }

    public function findPerson() {
        if (isset($this->args[2])) {

            $list = $this->db->search($this->args[2]);

            foreach ($list as $value) {
                print($value . PHP_EOL);
            }
        } else {
            throw new \Exception(PHP_EOL.PHP_EOL.'The search command needs the string you are looking for!'.PHP_EOL.PHP_EOL);
        }
    }

    public function addCoder() {

    }

    public function removeCoder() {
        $dbresponse = $this->db->readFromDB();

        if (array_key_exists($this->args[2], $dbresponse[0]) !== false) {
            unset($dbresponse[0][$this->args[2]]);
        } else {
            throw new \Exception(PHP_EOL.PHP_EOL.'ID not found!'.PHP_EOL.PHP_EOL);
        }

        $this->db->saveToDB($dbresponse);
    }

    public function test() {
        print_r($this->db->saveToDB($this->db->readFromDB()));
    }
}