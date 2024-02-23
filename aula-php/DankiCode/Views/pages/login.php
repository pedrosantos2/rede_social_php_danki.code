<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?php echo INCLUDE_PATH_STATIC ?>estilos/style.css">
  <title>Login</title>
</head>
<body>

  <div class="sidebar">

  </div>

  <div class="form-container-login">
    <div class="logo-chamada-login">
      <img src="<?php echo INCLUDE_PATH_STATIC ?>images\logodanki.svg" />
      <p>Conecte-se com seus amigos e expanda seus aprendizados com a rede social Danki Code.</p>
    </div>

    <div class="form-login">
        <form action="" method="post">
          <input type="text" name="email" placeholder="Seu nome">
          <input type="password" name="senha" placeholder="Sua senha" >
          <input type="submit" value="logar" name="acao">
          <input type="hidden" name="login">
        </form>
        <p><a href="<?php echo INCLUDE_PATH ?>registrar">Criar Conta</a></p>
    </div>

  </div>

</body>
</html>