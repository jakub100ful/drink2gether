<?php

function callAPI($url) {
    
    $json_data = file_get_contents($url);
    $response_data = json_decode($json_data, true);

    return $response_data;
}

function search($query) {
    $url = "https://www.thecocktaildb.com/api/json/v1/1/search.php?s=";
    $url .= $query;

    $json = callAPI($url);
    return $json["drinks"];
}

$search_return_list = search($_GET["search-query"]);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Page Title</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./styles.css">
</head>

<body>

    <div class="container-fluid p-0" id="navigation-container">
        <nav class="navbar navbar-light bg-light justify-content-between">
            <a class="navbar-brand">drink2gether</a>
        </nav>
    </div>
    <div class="container-fluid" id="main-container">
        <div class="row">

        <?php
            foreach ($search_return_list as $drink){
                $image_url = $drink["strDrinkThumb"];
                $card_html = "
                    <div class='col-sm-6'>
                    <div class='card'>
                        <div class='row card-body'>
                        <div class='col-4'>
                            <img class='img-responsive w-100' src='".$image_url."' alt='sans'/>
                        </div>
                        <div class='col-8'>
                            <h5 class='card-title'>".$drink["strDrink"]."</h5>
                            <p class='card-text'><b>Type: </b>".$drink["strAlcoholic"]."</p>
                            <a href='#' class='btn btn-primary'>Add</a>
                            <a href='#' class='btn btn-primary'>Save</a>
                            </div>
                        </div>
                    </div>
                </div>
                ";
                echo $card_html;
            }
        ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>

</html>