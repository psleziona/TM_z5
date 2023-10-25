<?php declare(strict_types=1);  /* Ta linia musi być pierwsza */ ?>
<!DOCTYPE html>
<html lang="pl">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">  
	<meta name="description" content="Twój Opis">
	<meta name="author" content="Twoje dane">
	<meta name="keywords" content="Twoje słowa kluczowe">
	<title>Śleziona</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/sign-in/">
    <!-- Custom styles for this template -->
    <link href="signin.css" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css">
	<style type="text/css" class="init"></style>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
	<script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"></script>
	<script type="text/javascript" src="twoj_js.js"></script> 
</head>

<body style="display: block; padding-top: 0" onload="myLoadHeader()">
<div id='myHeader'> </div>
    <main class="form-signin">
      <form id="loginForm" action="verify.php" method="post">
        <h1 class="h3 mb-3 fw-normal">Zaloguj się</h1>
        <div class="form-floating">
          <input name="user" class="form-control" id="floatingInput" placeholder="login">
          <label for="floatingInput">Login</label>
        </div>
        <div class="form-floating">
          <input name="pass" type="password" class="form-control" id="floatingPassword" placeholder="Password">
          <label for="floatingPassword">Password</label>
        </div>
        <div class="checkbox mb-3">
          <label>
            <input type="checkbox" value="remember-me"> Remember me
          </label>
        </div>
        <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
          <?php
            if(isset($_GET['login']) && $_GET['login'] == 'false')
                echo '<p class="mt-3" style="color: red">Błędny login lub hasło</p>';
            if(isset($_GET['locked']))
                echo '<p class="mt-3" style="color: red">Konto zablokowane do: '.$_GET['locked'].'</p>';
          ?>

      </form>
    </main>
	<?php require_once 'footer.php'; ?>	
</body>
<script>
    const loginForm = document.querySelector('#loginForm');
    loginForm.addEventListener('submit', e => {
        e.preventDefault();
        const res = screen.width + 'x' + screen.height;
        const browserRes = screen.availWidth + 'x' + screen.availHeight;
        const color = screen.colorDepth;
        const cookies = navigator.cookieEnabled;
        const aplets = navigator.javaEnabled();
        const lang = navigator.language;


        loginForm.action = window.location.origin + `/z5/verify.php?resolution=${res}&browserResolution=${browserRes}&colors=${color}&cookies=${cookies}&aplets=${aplets}&lang=${lang}`;
        loginForm.submit();
    });
</script>
</html>