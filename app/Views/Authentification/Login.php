<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
	<title>GSB</title>
</head>
<body>

<div class="container d-flex justify-content-center mt-5">
  <div class="border rounded col-lg-5 bg-dark p-5">
    <h1 class="text-center text-light">Connexion</h1>
    <form id="login-form" class="mt-5" method="POST" action="/">

      <label for="login" class="col-form-label text-light">Login</label>
      <input type="text" name="login" id="login" placeholder="Login" class="form-control">

      <label for="password" class="col-form-label text-light">Mot de passe</label>
      <input type="password" name="password" id="password" placeholder="Mot de passe" class="form-control">

      <?=$data_sanitize->generate_csrf_input()?>

      <button class="btn btn-light mt-2">Se connecter</button>
    </form>
  </div>

</div>

</body>
</html>