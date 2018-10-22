<?php

    class Sql extends PDO {
        private $conn;
        private $dsn = 'mysql:host=localhost;dbname=dbphp7;charset=utf8';
        private $user = 'root';
        private $password = '';

        /***************************************************************************************************/

        public function __construct() {
            $this->conn = new PDO($this->dsn, $this->user, $this->password);
        }

        /***************************************************************************************************/
        private function setParam($statement, $key, $value) {
            $statement->bindParam($key, $value);
        }

        private function setParams($statement, $parameters = array()) {
            foreach ($parameters as $key => $value) {
                $this->setParam($statement, $key, $value);
            }
        }

        public function query($rawQuery, $params = array()) {
            $stmt = $this->conn->prepare($rawQuery);
            $this->setParams($stmt, $params);
            $stmt->execute();

            return $stmt;
        }

        public function select($rawQuery, $params = array()):array {
            $stmt = $this->query($rawQuery, $params);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }