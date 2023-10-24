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
    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/checkout/">
        <!-- Custom styles for this template -->
    <link href="form-validation.css" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css">
	<style type="text/css" class="init"></style>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
	<script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"></script>
	<script type="text/javascript" src="twoj_js.js"></script>
</head>

<body class="bg-light" style="display: block; padding-top: 0" onload="myLoadHeader()">
<div id='myHeader'> </div>	
    
<div class="container">
  <main>
    <div class="py-5 text-center">
      <h2>Zarejestruj się</h2>
    </div>
    <div class="row g-5">
      <div class="col-md-12 col-lg-12">
        <h4 class="mb-3">Dane użytkownika</h4>
        <form class="needs-validation" novalidate action="reg.php" method="post" enctype="multipart/form-data">
          <div class="row g-3">
            <div class="col-sm-12">
              <label for="firstName" class="form-label">Nazwa użytkownika</label>
              <input name="user" type="text" class="form-control" id="firstName" placeholder="" value="" required>
              <div class="invalid-feedback">
                Valid first name is required.
              </div>
            </div>

            <div class="col-12">
              <label for="username" class="form-label">Hasło</label>
              <div class="input-group has-validation">
                <input name="pass" type="password" class="form-control" id="username" required>
                <div class="invalid-feedback">
                  Your username is required.
                </div>
              </div>
            </div>

            
            <div class="col-12">
              <label for="username" class="form-label">Powtórz hasło</label>
              <div class="input-group has-validation">
                <input name="pass2" type="password" class="form-control" id="username" required>
                <div class="invalid-feedback">
                  Your username is required.
                </div>
              </div>
            </div>

              <div class="mb-3">
                  <label for="formFile" class="form-label">Załaduj avatar</label>
                  <input class="form-control" type="file" id="formFile" name="avatar" accept=".jpg,.jpeg,.png">
              </div>

            
          <hr class="my-4">

          <button class="w-100 btn btn-primary btn-lg" type="submit">Zarejestruj się</button>
        </form>
      </div>
    </div>
  </main>
</div>
<?php require_once 'footer.php'; ?>	
<script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
<script src="form-validation.js"></script>
</body>
</html>