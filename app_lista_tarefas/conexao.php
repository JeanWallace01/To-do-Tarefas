<?php 

    class conexao {

        //Definindo as config da conexão
        private $host = 'localhost';
        private $dbname = 'lista_tarefa';
        private $user = 'root'; 
        private $pass = '';


        //Metódo que irá executar a conexão
        public function conectar() {

            try {

                //Criando a instancia do PDO, tendo que passar 3 parametros
                $conexao = new PDO(

                    "mysql:host=$this->host;dbname=$this->dbname", // Serio dsn, passando o drive de banco de dados usado(nome do BD)
                    "$this->user", // THIS faz recuperar atributos
                    "$this->pass"

                );

                return $conexao;

            } catch(PDOException $e) {
                echo '<p>' . $e->getMessege(). '</p>';
            }

        }

    }




?>