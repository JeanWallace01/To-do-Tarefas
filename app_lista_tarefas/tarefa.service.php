<?php


// Classe TarefaService, responsável por realizar operações CRUD (Create, Read, Update, Delete) na tabela de tarefas
class TarefaService {


	private $conexao; // Objeto de conexão com o banco de dados
	private $tarefa; // Objeto tarefa, que contém os dados da tarefa


	 // Construtor da classe, que recebe objetos de conexão e tarefa
	public function __construct(Conexao $conexao, Tarefa $tarefa) {
		$this->conexao = $conexao->conectar(); // Estabelece a conexão com o banco de dados
		$this->tarefa = $tarefa; // Inicializa o objeto tarefa
	}

	public function inserir() { //create
		$query = 'insert into tb_tarefas(tarefa)values(:tarefa)'; // Query de inserção
		$stmt = $this->conexao->prepare($query);  // Prepara a query para execução
		$stmt->bindValue(':tarefa', $this->tarefa->__get('tarefa')); // Associa o valor da tarefa
		$stmt->execute(); // Executa a query
	}

	public function recuperar() { //read  para recuperar todas as tarefas
		
		// Query para recuperar as tarefas com seu status
		$query = '
			select 
				t.id, s.status, t.tarefa 
			from 
				tb_tarefas as t
				left join tb_status as s on (t.id_status = s.id)
		';
		$stmt = $this->conexao->prepare($query); // Prepara a query para execução
		$stmt->execute(); // Executa a query
		return $stmt->fetchAll(PDO::FETCH_OBJ); // Retorna os resultados como objetos
	}

	public function atualizar() { //update

		$query = "update tb_tarefas set tarefa = ? where id = ?"; // Query de atualização

		$stmt = $this->conexao->prepare($query); // Prepara a query para execução
		$stmt->bindValue(1, $this->tarefa->__get('tarefa')); // Associa o valor da tarefa
		$stmt->bindValue(2, $this->tarefa->__get('id')); // Associa o valor do ID
		return $stmt->execute();  // Executa a query e retorna o sucesso ou falha
	}

	public function remover() { //delete

		$query = 'delete from tb_tarefas where id = :id';
		$stmt = $this->conexao->prepare($query);
		$stmt->bindValue(':id', $this->tarefa->__get('id'));
		$stmt->execute();
	}

	public function marcarRealizada() { //update

		$query = "update tb_tarefas set id_status = ? where id = ?"; // Query de atualização
		$stmt = $this->conexao->prepare($query); // Prepara a query para execução
		$stmt->bindValue(1, $this->tarefa->__get('id_status')); // Associa o valor do ID_STATUS
		$stmt->bindValue(2, $this->tarefa->__get('id')); // Associa o valor do ID
		return $stmt->execute();  // Executa a query
	}

	public function recuperarTarefasPendentes() {
		
		// Query para recuperar tarefas pendentes com base no status
		$query = '
			select 
				t.id, s.status, t.tarefa 
			from 
				tb_tarefas as t
				left join tb_status as s on (t.id_status = s.id)
			where
				t.id_status = :id_status
		';
		$stmt = $this->conexao->prepare($query); // Prepara a query para execução
		$stmt->bindValue(':id_status', $this->tarefa->__get('id_status'));  // Associa o valor do status
		$stmt->execute(); // Executa a query
		return $stmt->fetchAll(PDO::FETCH_OBJ); // Retorna as tarefas como objetos
	}
}

?>


































}



?>