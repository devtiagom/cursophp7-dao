<?php

    class Usuario {
        private $idusuario;
        private $deslogin;
        private $dessenha;
        private $dtcadastro;

        /***************************************************************************************************/

        public function __toString():string {
            return json_encode(array(
                'idusuario' => $this->getIdusuario(),
                'deslogin' => $this->getDeslogin(),
                'dessenha' => $this->getDessenha(),
                'dtcadastro' => $this->getDtcadastro()->format('d/m/y H:i:s')
            ));
        }

        /***************************************************************************************************/

        public function getIdusuario() {
            return $this->idusuario;
        }

        public function setIdusuario($idusuario) {
            $this->idusuario = $idusuario;
        }

        public function getDeslogin() {
            return $this->deslogin;
        }

        public function setDeslogin($deslogin) {
            $this->deslogin = $deslogin;
        }

        public function getDessenha() {
            return $this->dessenha;
        }

        public function setDessenha($dessenha) {
            $this->dessenha = $dessenha;
        }

        public function getDtcadastro() {
            return $this->dtcadastro;
        }

        public function setDtcadastro($dtcadastro) {
            $this->dtcadastro = $dtcadastro;
        }

        /***************************************************************************************************/

        public function loadById($id) {
            $sql = new Sql();
            $query = 'SELECT * FROM tb_usuarios WHERE idusuario = :ID';
            $results = $sql->select($query, array(':ID' => $id));

            if (count($results) > 0) {
                $row = $results[0];

                $this->setIdusuario($row['idusuario']);
                $this->setDeslogin($row['deslogin']);
                $this->setDessenha($row['dessenha']);
                $this->setDtcadastro(new DateTime($row['dtcadastro']));
            }
        }

        public static function getList():array {
            $sql = new Sql();
            $query = 'SELECT * FROM tb_usuarios ORDER BY deslogin';
            $results = $sql->select($query);

            return $results;
        }

        public static function searchByLogin($login):array {
            $sql = new Sql();
            $query = 'SELECT * FROM tb_usuarios WHERE deslogin LIKE :LOGIN ORDER BY deslogin';
            $results = $sql->select($query, array(':LOGIN' => '%' . $login . '%'));

            return $results;
        }

        public function login($login, $password) {
            $sql = new Sql();
            $query = 'SELECT * FROM tb_usuarios WHERE deslogin = :LOGIN AND dessenha = :PASSWORD';
            $results = $sql->select($query, array(
                ':LOGIN' => $login,
                ':PASSWORD' => $password
            ));

            if (count($results) > 0) {
                $row = $results[0];

                $this->setIdusuario($row['idusuario']);
                $this->setDeslogin($row['deslogin']);
                $this->setDessenha($row['dessenha']);
                $this->setDtcadastro(new DateTime($row['dtcadastro']));
            } else {
                throw new Exception('Login e/ou senha inválidos!');
            }
        }
    }