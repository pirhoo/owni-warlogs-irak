<?php
   class Mydb {

        // ----------------------------------------
        // PUBLIC
        // ----------------------------------------

       
        public function __construct($host, $database, $user, $password) {
            $this->host = $host;
            $this->database = $database;
            $this->user = $user;
            $this->password = $password;

            return $this->connect();
        }

        public function  __destruct() {
            return $this->close();
        }

        public function connect() {
            $this->connexion = mysql_connect($this->host, $this->user, $this->password);
            mysql_select_db($this->database, $this->connexion);
            mysql_query("SET NAMES 'utf8'");

        }

        public function close() {
            return @mysql_close($this->connexion);
        }

        public function query($query) {
            $this->query = $query;
            return $this->result = mysql_query($query, $this->connexion) or ( $this->err_query = mysql_error($this->connexion) );
        }
	
	public function nr() {
            return mysql_num_rows($this->result);
        }

	public function ds($n) {
            return mysql_data_seek($this->result, $n);
        }

	public function fr() {
            return mysql_fetch_row($this->result);
        }
	
        public function fo() {
            return mysql_fetch_object($this->result);
        }

        public function fa() {
            return mysql_fetch_array($this->result);
        }

        public function affected() {
            return mysql_affected_rows();
        }

        public function getConnexion() {
            return $this->connexion;
        }

        public function setConnexion($connexion) {
            $this->connexion = $connexion;
        }

        public function getHost() {
            return $this->host;
        }

        public function setHost($host) {
            $this->host = $host;
        }

        public function getDatabase() {
            return $this->database;
        }

        public function setDatabase($database) {
            $this->database = $database;
        }

        public function getUser() {
            return $this->user;
        }

        public function setUser($user) {
            $this->user = $user;
        }

        public function getPassword() {
            return $this->password;
        }

        public function setPassword($password) {
            $this->password = $password;
        }

        public function getQuery() {
            return $this->query;
        }

        public function setQuery($query) {
            $this->query = $query;
        }

        public function getResult() {
            return $this->result;
        }

        public function setResult($result) {
            $this->result = $result;
        }

        public function getErr_query() {
            return $this->err_query;
        }

        public function setErr_query($err_query) {
            $this->err_query = $err_query;
        }


        // ----------------------------------------
        // PRIVÉ
        // ----------------------------------------
        
        private $connexion;
        private $host;
        private $database;
        private $user;
        private $password;
        private $query; // dernière requête
        private $result; // dernier jeux d'enregistrements
        private $err_query; // derniere erreur de requête
   }
?>