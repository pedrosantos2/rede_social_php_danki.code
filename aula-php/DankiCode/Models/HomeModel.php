<?php
namespace DankiCode\Models;

class HomeModel
{
  public static function postFeed($post)
  {
    $pdo = \DankiCode\Mysql::connect();
    $post = strip_tags($post);

    if (preg_match('/\[imagem/', $post)) {
      $post = preg_replace("/(.*?)\[imagem=(.*?)\]/", "<p>$1</p><img src='$2' />", $post);

    } else {
      $post = '<p>' . $post . '</p>';
    }


    $postFeed = $pdo->prepare("INSERT INTO `posts` VALUES (null,?,?,?)");
    $postFeed->execute(array($_SESSION['id'], $post, date('Y-m-d H:i:s', time())));

    $atualizaUsuario = $pdo->prepare("UPDATE usuarios SET ultimo_post = ? WHERE id = ?");
    $atualizaUsuario->execute(array(date('Y-m-d H:i:s', time()), $_SESSION['id']));
  }

  public static function retrieveFriendsPosts(){

    $pdo = \DankiCode\MySql::connect();

    $amizades = $pdo->prepare("SELECT * FROM amizades WHERE (enviou = ? AND status = 1) OR (recebeu = ? AND status = 1)");
    $amizades->execute(array($_SESSION['id'],$_SESSION['id']));

    $amizades = $amizades->fetchAll();
    $amigosConfirmados = array();
    foreach ($amizades as $key => $value) {
      if($value['enviou'] == $_SESSION['id']){
        $amigosConfirmados[] = $value['recebeu'];
      }else{
        $amigosConfirmados[] = $value['enviou'];
      }
    }

    $listaAmigos = array();

    foreach ($amigosConfirmados as $key => $value) {
      $listaAmigos[$key]['id'] = \DankiCode\Models\UsuariosModels::getUsuarioById($value)['id'];
      $listaAmigos[$key]['nome'] = \DankiCode\Models\UsuariosModels::getUsuarioById($value)['nome'];
      $listaAmigos[$key]['email'] = \DankiCode\Models\UsuariosModels::getUsuarioById($value)['email'];
      $listaAmigos[$key]['img'] = \DankiCode\Models\UsuariosModels::getUsuarioById($value)['img'];
      $listaAmigos[$key]['ultimo_post'] = \DankiCode\Models\UsuariosModels::getUsuarioById($value)['ultimo_post'];
    }

    usort($listaAmigos,function($a,$b){
      if(strtotime($a['ultimo_post']) >  strtotime($b['ultimo_post'])){
        return -1;
      }else{
        return +1;
      }
    });
    $posts = [];

    foreach ($listaAmigos as $key => $value) {

      $ultimoPost = $pdo->prepare("SELECT * FROM posts WHERE usuario_id = ? ORDER BY data DESC");
      $ultimoPost->execute(array($value['id']));
      if($ultimoPost->rowCount() >= 1){
        $ultimoPost = $ultimoPost->fetch();
        $posts[$key]['usuario'] = $value['nome'];
        $posts[$key]['img'] = $value['img'];
        $posts[$key]['data'] = $ultimoPost['data'];
        $posts[$key]['conteudo'] = $ultimoPost['post'];

        
      }
    }
    
    $me = $pdo->prepare("SELECT * FROM usuarios WHERE id = $_SESSION[id]");

    $me->execute();

    $me = $me->fetch();

    if(isset($posts[0])){
      if(strtotime($me['ultimo_post']) > strtotime($posts[0]['data'])  ){
        $ultimoPost = $pdo->prepare("SELECT * FROM posts WHERE usuario_id = $_SESSION[id] ORDER BY data DESC");
        $ultimoPost->execute();
        $ultimoPost = $ultimoPost->fetchAll()[0];
        array_unshift($posts, array('data'=>$ultimoPost['data'],'conteudo'=>$ultimoPost['post'],'me'=>true  ));
      }
    }



    return $posts;


  }

}
?>