<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body class="bg-light">
   <div class="height: 100vh;">
       <div class="row h-100 m-0">
           <div class="card w-25 my-auto mx-auto">
              <div class="card-header bg-white border-0 py-3">
                 <h1 class="text-center">LOG IN</h1>
              </div>
              <div class="card-body">
                <form action="../actions/login.php" method="post">
                    <input type="text" name="username" placeholder="USERNAME" class="form-control mb-2" required autofocus>
                    <input type="password" name="password" placeholder="PASSWORD" class="form-control mb-5">
                    <button type="submit" class="btn btn-primary w-100">Log in</button>
                </form>

                 <p class="text-center mt-3 samll"><a href="register.php">Create Accunt</a></p>

              </div>
           </div>
       </div>
   </div>
    
</body>
</html>