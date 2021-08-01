<?php
session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <title>drink2gether | home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./styles.css">
</head>

<body>

    <div class="container-fluid" id="main-container">
        <div class="row justify-content-center align-items-center h-10" id="search-row">
            <?php
                if (isset($_SESSION['user'])) {
                    echo("<p>Logged in as ".$_SESSION['user']."</p>");
                }else{
                    echo("<a class='text-white' href='login.php'>Log in</a>");
                }
            ?>
        </div>
        <div class="row justify-content-center align-items-center h-100" id="search-row">
        <div class="col-sm-3">
        <h1 class="logo text-focus-in">
            drink2gether<span><i class="bi bi-cup-straw"></i></span>
        </h1>
        <div class="row align-items-center h-100" id="search-row">
            <div class="col-lg">
                <form method="get" action="./scripts/search.php">
                    <div class="input-group rounded">
                        <input name="search-query" type="search" class="form-control rounded"
                            placeholder="lookup cocktails" aria-label="Search" aria-describedby="search-addon" />
                        <span class="input-group-text border-0" id="search-addon">
                            <button type="submit" class="btn btn-default">
                                <i class="bi bi-search"></i>
                            </button>
                        </span>
                    </div>
                </form>
            </div>
            
        </div>
    </div>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>

    <script src="./scripts/scripts.js"></script>
</body>

</html>