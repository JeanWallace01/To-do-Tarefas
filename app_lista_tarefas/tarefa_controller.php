<?php 

	// Inclui os arquivos necessários para o funcionamento do código:
    // - tarefa.model.php: Define o modelo de dados para tarefas.
    // - tarefa.service.php: Contém a lógica de manipulação de tarefas.
    // - conexao.php: Gerencia a conexão com o banco de dados.

	require "../../app_lista_tarefas/tarefa.model.php";
	require "../../app_lista_tarefas/tarefa.service.php";
	require "../../app_lista_tarefas/conexao.php";

	// Verifica se a ação foi definida via GET, caso contrário, usa o valor padrão de $acao.
	$acao = isset($_GET['acao']) ? $_GET['acao'] : $acao;



	if($acao == 'inserir' ) {

		// Caso a ação seja "inserir", cria um novo objeto Tarefa e define o valor da tarefa a partir do POST.
		$tarefa = new Tarefa();
		$tarefa->__set('tarefa', $_POST['tarefa']);


		// Cria uma conexão com o banco de dados.
		$conexao = new Conexao();


		// Cria um serviço de tarefas para manipular o objeto e insere a tarefa.
		$tarefaService = new TarefaService($conexao, $tarefa);
		$tarefaService->inserir();


		// Redireciona para a página de nova tarefa com um parâmetro de inclusão bem-sucedida.
		header('Location: nova_tarefa.php?inclusao=1');
	
	} else if($acao == 'recuperar') {

		// Caso a ação seja "recuperar", busca todas as tarefas no banco de dados.
		$tarefa = new Tarefa();
		$conexao = new Conexao();

		$tarefaService = new TarefaService($conexao, $tarefa);
		$tarefas = $tarefaService->recuperar();
	
	} else if($acao == 'atualizar') {

		// Caso a ação seja "atualizar", atualiza uma tarefa existente.
		$tarefa = new Tarefa();
		$tarefa->__set('id', $_POST['id'])
			->__set('tarefa', $_POST['tarefa']);

		$conexao = new Conexao();

		$tarefaService = new TarefaService($conexao, $tarefa);

		// Se a atualização for bem-sucedida, redireciona para a página correspondente.
		if($tarefaService->atualizar()) {
			
			if( isset($_GET['pag']) && $_GET['pag'] == 'index') {
				header('location: index.php');	
			} else {
				header('location: todas_tarefas.php');
			}
		}


	} else if($acao == 'remover') {

		// Caso a ação seja "remover", exclui a tarefa com o ID especificado.
		$tarefa = new Tarefa();
		$tarefa->__set('id', $_GET['id']);

		$conexao = new Conexao();

		$tarefaService = new TarefaService($conexao, $tarefa);
		$tarefaService->remover();

		if( isset($_GET['pag']) && $_GET['pag'] == 'index') {
			header('location: index.php');	
		} else {
			header('location: todas_tarefas.php');
		}
	
	} else if($acao == 'marcarRealizada') {

		$tarefa = new Tarefa();
		$tarefa->__set('id', $_GET['id'])->__set('id_status', 2);

		$conexao = new Conexao();

		$tarefaService = new TarefaService($conexao, $tarefa);
		$tarefaService->marcarRealizada();


		// Redireciona para a página correspondente após a remoção.
		if( isset($_GET['pag']) && $_GET['pag'] == 'index') {
			header('location: index.php');	
		} else {
			header('location: todas_tarefas.php');
		}
	
	} else if($acao == 'recuperarTarefasPendentes') {

		// Caso a ação seja "recuperarTarefasPendentes", busca apenas as tarefas com status "pendente".
		$tarefa = new Tarefa();
		$tarefa->__set('id_status', 1);
		
		$conexao = new Conexao();

		$tarefaService = new TarefaService($conexao, $tarefa);
		$tarefas = $tarefaService->recuperarTarefasPendentes();
	}


?>
