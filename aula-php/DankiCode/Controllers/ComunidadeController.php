<?php
  namespace DankiCode\Controllers;

  class ComunidadeController{
    public function index(){
      if(isset($_SESSION['login'])){

        if(isset($_GET['solicitarAmizade'])){
          $idPara = (int) $_GET['solicitarAmizade'];
          if(\DankiCode\Models\UsuariosModels::solicitarAmizade($idPara)){
            \DankiCode\Utilidades::alerta('Amizade Enviada com Sucesso!');
            \DankiCode\Utilidades::redirect(INCLUDE_PATH.'comunidade');
          }else{
            \DankiCode\Utilidades::alerta('Ocorreu um erro');
            \DankiCode\Utilidades::redirect(INCLUDE_PATH.'comunidade');

          }
        }

        \DankiCode\Views\MainView::render("comunidade");
      }else{
        \DankiCode\Utilidades::redirect(INCLUDE_PATH);
      }
      
    }
  }

?>