<?php
	
	namespace DankiCode\Controllers;

	class HomeController{


		public function index(){

			if(isset($_GET['logout'])){
				session_unset();
				session_destroy();

				\DankiCode\Utilidades::redirect(INCLUDE_PATH);
			}


			if(isset($_SESSION['login'])){
				//Renderiza a home do usuário.

        if(isset($_GET['recusarAmizade'])){
          $idEnviou = (int) $_GET['recusarAmizade'];
          \DankiCode\Models\UsuariosModels::atualizarPedidoAmizade($idEnviou,0);
          \DankiCode\Utilidades::alerta('Amizade recusada...');
          \DankiCode\Utilidades::redirect(INCLUDE_PATH);
        }else if(isset($_GET['aceitarAmizade'])){
          $idEnviou = (int) $_GET['aceitarAmizade'];
          if(\DankiCode\Models\UsuariosModels::atualizarPedidoAmizade($idEnviou,1)){
            \DankiCode\Utilidades::alerta('Amizade Aceita...');
            \DankiCode\Utilidades::redirect(INCLUDE_PATH);
          }else{
            \DankiCode\Utilidades::alerta('Ops deu ruim...');
            \DankiCode\Utilidades::redirect(INCLUDE_PATH);
          }
        }

				if(isset($_POST['post_feed'])) {

					if($_POST['post_content'] == ''){
						\DankiCode\Utilidades::alerta('Não permitimos posts vázios!');
						\DankiCode\Utilidades::redirect(INCLUDE_PATH);
					}else{
						\DankiCode\Models\HomeModel::postFeed($_POST['post_content']);
						\DankiCode\Utilidades::alerta('Post feito com sucesso!!');
          	\DankiCode\Utilidades::redirect(INCLUDE_PATH);
					}
					
				}


				\DankiCode\Views\MainView::render('home');
			}else{
				//Renderizar para criar conta.

				if(isset($_POST['login'])){
					$login = $_POST['email'];
					$senha = $_POST['senha'];

					

					//Verificar no banco de dados.

					$verifica = \DankiCode\MySql::connect()->prepare("SELECT * FROM usuarios WHERE email = ?");
					$verifica->execute(array($login));



					
					if($verifica->rowCount() == 0){
						//Não existe o usuário!
						\DankiCode\Utilidades::alerta('Não existe nenhum usuário com este e-mail...');
						\DankiCode\Utilidades::redirect(INCLUDE_PATH);
					}else{
						$dados = $verifica->fetch();
						$senhaBanco = $dados['senha'];
						if(\DankiCode\Bcrypt::check($senha,$senhaBanco)){
							//Usuário logado com sucesso
							$_SESSION['login'] = $dados['email'];
              $_SESSION['id'] = $dados['id'];
							$_SESSION['nome'] = explode(' ',$dados['nome'])[0];
							$_SESSION['img'] = $dados['img'];
							\DankiCode\Utilidades::alerta('Logado com sucesso!');
							\DankiCode\Utilidades::redirect(INCLUDE_PATH);
						}else{
							\DankiCode\Utilidades::alerta('Senha incorreta....');
							\DankiCode\Utilidades::redirect(INCLUDE_PATH);
						}
					}
					

				}

				\DankiCode\Views\MainView::render('login');
			}

		}

	}

?>