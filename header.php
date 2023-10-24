<?php declare(strict_types=1);  
	session_start();
    $isLogged = $_SESSION['loggedin'] ?? false;
    if($isLogged) {
        $user = $_SESSION['user'];
        $avatar = $_SESSION['avatar'];
    }

    $auth = (object)array();
    if(str_contains($_SERVER['HTTP_REFERER'],"login.php")) {
        $auth->path = 'register.php';
        $auth->name = 'Rejestracja';
    } else {
        $auth->path = 'login.php';
        $auth->name = "Logowanie";
    }
?>

<head>
<link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

<style>
  .bd-placeholder-img {
	font-size: 1.125rem;
	text-anchor: middle;
	-webkit-user-select: none;
	-moz-user-select: none;
	user-select: none;
  }

  @media (min-width: 768px) {
	.bd-placeholder-img-lg {
	  font-size: 3.5rem;
	}
  }

  #avatar {
      height: 50px;
      width: 50px;
      margin-right: 5px;
  }
</style>


<!-- Custom styles for this template -->
<link href="navbar-top.css" rel="stylesheet">
</head>
<header>
<nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Portal</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <ul class="navbar-nav me-auto mb-2 mb-md-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.php">Home</a>
        </li>
        <?php
        if($isLogged) 
        echo '<li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Komunikator
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="index1.php">Post</a></li>
            <li><a class="dropdown-item" href="select.php">Plik</a></li>
          </ul>
        </li>';
        ?>


		<?php
		if(!$isLogged)
  			echo '<li class="nav-item">
				  <a class="nav-link" href="'.$auth->path.'">'.$auth->name.'</a>
				</li> 
				  ';
		?>
      </ul>
	  <?php
	  	if($isLogged)
  			echo '
            <img id="avatar" src="avatars/'.$avatar.'">
            <form class="d-flex" action="logout.php">
			  <button class="btn btn-outline-success" type="submit"><i class="fa fa-sign-out"></i></button>
			</form>';
		?>
      	
    </div>
  </div>
</nav>
</header>