<!DOCTYPE html>
<html>
    <head>
        <title>Log In - drink2gether</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" />
        <link rel="stylesheet" href="./styles.css" />
    </head>
    <body>
        <div class="container-fluid" id="main-container">
            <div class="row justify-content-center align-items-center h-100" id="search-row">
                <div class="col-sm-3">
                    <h1 class="logo text-focus-in">
                        drink2gether<span><i class="bi bi-cup-straw"></i></span>
                    </h1>
                    <div class="card slide-top">
                        <h5 class="card-header">Register</h5>
                        <div class="card-body">
                            <form action="./scripts/create_new_user.php" method="post">
                                <div class="form-group">
                                    <label for="inputUsername">Username</label>
                                    <input name="username" type="text" class="form-control" id="inputUsername" aria-describedby="usernameHelp" placeholder="Enter username" />
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail">Email address</label>
                                    <input name="email" type="email" class="form-control" id="inputEmail" aria-describedby="emailHelp" placeholder="Enter email" />
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword">Password</label>
                                    <input name="password" type="password" class="form-control" id="inputPassword" placeholder="Password" />
                                </div>
                                <button type="submit" class="btn-grad mt-2">Log In</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script src="./scripts/scripts.js"></script>
    </body>
</html>
