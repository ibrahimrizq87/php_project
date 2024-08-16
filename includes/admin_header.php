
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <title>Home</title>
</head>
<body class='bg-light'>
    


<header class="shadow">
    <div class="px-3 py-2 text-bg-dark border-bottom ">
      <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
          <a href="/" class="d-flex align-items-center my-2 my-lg-0 me-lg-auto text-white text-decoration-none">
            <image src = 'images/logo.png'class="bi me-2" width="50" height="50" >
            <span class="ms-2 fw-bold h5">Cafeterai</span> 
                
          </a>

          <ul class="nav col-12 col-lg-auto my-2 justify-content-center my-md-0 text-small">
            <li>
              <a href="#" class="nav-link text-white">
                <img src='images/home1.png' class="bi d-block mx-auto mb-1" width="30" height="30">
                Home
              </a>
            </li>
            <li>
              <a href="#" class="nav-link text-white">
              <img src='images/products.png' class="bi d-block mx-auto mb-1" width="30" height="30">
              Products
              </a>
            </li>
            <li>
              <a href="#" class="nav-link text-white">
              <img src='images/users.png' class="bi d-block mx-auto mb-1" width="30" height="30">
              Users
              </a>
            </li>
            <li>
              <a href="#" class="nav-link text-white">
              <img src='images/manual.png' class="bi d-block mx-auto mb-1" width="30" height="30">
              Manual Order
              </a>
            </li>


            <li>
              <a href="#" class="nav-link text-white">
              <img src='images/checks.png' class="bi d-block mx-auto mb-1" width="30" height="30">
              Checks
              </a>
            </li>
          </ul>


        </div>
      </div>
    </div>
    <div class="px-3 py-2 border-bottom mb-3">
      <div class="container d-flex flex-wrap justify-content-center">
      <div class="col-12 col-lg-auto mb-2 mb-lg-0 me-lg-auto d-flex align-items-center">
    <img src=<?php echo $_SESSION["image"]?> alt="User Image" class="rounded-circle" width="40" height="40">
    <span class="ms-2 fw-bold"> <?php echo $_SESSION["user_name"]?></span>  
</div>

        <div class="text-end">
          <button type="button" class="btn btn-light text-dark ">Log out</button>
        </div>
      </div>
    </div>
  </header>
