<?php 
include_once ('ligaBD.php');
include_once ('function.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src="../js/bootstrap.min.js"></script>
	  <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
    <title>Recuperar Password</title>
</head>
<body>
    <header>
        <nav>
          <a class="logo" href="pagP.php">SolveNow</a>
          <ul class="nav-list">
            <li><a href="pagP.php">Início</a></li>
          </ul>
        </nav>
      </header>
        <main>
              <form class="recupera1" method="POST" action="">
                  <h2>Alteração de password</h2>
                  <div class="col-lg-9 col-md-9 col-sm-18">
                    <label for="password">Insira a nova password</label>
                <input type="password" class="form-control"  aria-label="Password" id="password" name="Password" required>
                </div>
    <br>
              <div class="row">
                <div class="col" >
                    <input type="submit" value="Alterar" class="btn btn-primary" id="btn">
                    <input type="hidden" name="env" value="upd">
                </div>
            </div>
              </form> <br>
              <?php echo verifica_rash($liga);?>
        </main>
</body>
</html>