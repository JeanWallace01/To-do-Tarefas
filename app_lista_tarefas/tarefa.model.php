<?php 

class Tarefa {
    //Criando variáveis protegidas
    private $id;
    private $id_status;
    private $tarefa;
    private $data_cadastro;


    //Criando métodos GET e SET publicos para poder acessar as variaveis protegidas
    public function __get($atributo) {
        return $this->$atributo;
    } 

    //Setando os valores no meótodo overloanding do PHP
    public function __set($atributo,$valor) {
        $this->$atributo = $valor;
        return $this;
    }

}

?>