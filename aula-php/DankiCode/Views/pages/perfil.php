<!DOCTYPE html>
<html>

<head>
  <!--ALTERAR TITULO-->
  <title>Bem-vindo,
    <?php echo $_SESSION['nome']; ?>
  </title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
    integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
  <link href="<?php echo INCLUDE_PATH_STATIC ?>estilos/feed.css" rel="stylesheet">


</head>

<body>
  <section class="main-feed">
    <?php
    include('includes/sidebar.php');
    ?>
    <div class="feed">
      <div class="editar-perfil">
          <h2>Editando Perfil: </h2>
          <?php 
            if(isset($_SESSION['img']) && $_SESSION['img'] == ''){
              echo '<img style="max-width:400px;width=100%;" src="'.INCLUDE_PATH_STATIC.'images/avatar.jpg". />';
            }else{
              echo '<img style="max-width:400px;width=100%;" src="'.INCLUDE_PATH.'uploads/'.$_SESSION['img'].'" />';
            }
          ?>
          <form method="POST" enctype="multipart/form-data">
            <input type="text" name="nome" value="<?php echo $_SESSION['nome'] ?>" />
            <input type="password" name="senha" placeholder="Sua nova senha...">
            <input type="file" name="file">
            <input type="hidden" value="atualizar" name="atualizar">
            <input type="submit" value="Salvar" name="acao">
          </form>
        </div>
    </div>
  </section>


</body>


</html>