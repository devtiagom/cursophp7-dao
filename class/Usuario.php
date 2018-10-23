<?php

    class Usuario {
        private $idusuario;
        private $deslogin;
        private $dessenha;
        private $dtcadastro;

        /***************************************************************************************************/

        public function __construct($login = '', $password = ''){
            $this->setDeslogin($login);
            $this->setDessenha($password);
        }

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

        public function setData($data) {
            $this->setIdusuario($data['idusuario']);
            $this->setDeslogin($data['deslogin']);
            $this->setDessenha($data['dessenha']);
            $this->setDtcadastro(new DateTime($data['dtcadastro']));
        }
        
        public function loadById($id) {
            $sql = new Sql();
            $query = 'SELECT * FROM tb_usuarios WHERE idusuario = :ID';
            $results = $sql->select($query, array(':ID' => $id));

            if (count($results) > 0) {
                $this->setData($results[0]);                
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
                $this->setData($results[0]);
            } else {
                throw new Exception('Login e/ou senha inválidos!');
            }
        }

        public function insert() {
            $sql = new Sql();
            $query = 'CALL sp_usuarios_insert(:LOGIN, :PASSWORD)';
            $results = $sql->select($query, array(
                ':LOGIN' => $this->getDeslogin(),
                ':PASSWORD' => $this->getDessenha()
            ));

            if (count($results) > 0) {
                $this->setData($results[0]);
            }
        }

        public function update($login, $password) {
            $this->setDeslogin($login);
            $this->setDessenha($password);

            $sql = new Sql();
            $query = 'UPDATE tb_usuarios SET deslogin = :LOGIN, dessenha = :PASSWORD WHERE idusuario = :ID';
            $sql->query($query, array(
                ':LOGIN' => $this->getDeslogin(),
                ':PASSWORD' => $this->getDessenha(),
                ':ID' => $this->getIdusuario()
            ));
        }
    }