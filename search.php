<?php

require_once 'scripts/PriceCheck.php';

function callAPI($url) {
    
    $json_data = file_get_contents($url);
    $response_data = json_decode($json_data, true);

    return $response_data;
}

function search($query) {

    $url = "https://www.thecocktaildb.com/api/json/v1/1/search.php?s=";
    $url .= urlencode($query);

    $json = callAPI($url);
    return $json["drinks"];
}

$vodka = new PriceCheck("vodka");
$vodka->setProductList();
var_dump($vodka->getProductList());

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
    <h1 class="logo text-focus-in mt-5">
        drink2gether<span><i class="bi bi-cup-straw"></i></span>
    </h1>
    </div>
    <div class="container-fluid" id="main-container">
        <div class="row justify-content-center align-items-center">
            <div class="col-sm-6 mb-3">
                
                <?php echo("<h4>".count($search_return_list)." results for ".$_GET['search-query']."</h4>"); ?>
            </div>
        </div>
        <?php
            $index = 0;
            foreach ($search_return_list as $drink){
                $image_url = $drink["strDrinkThumb"];
                $card_html = "
                <div class='row justify-content-center align-items-center'>
                    <div class='col-sm-6 mb-3'>
                    <div class='card'>
                        <div class='row card-body'>
                        <div class='col-2'>
                            <img class='img-responsive w-100 rounded-circle' src='".$image_url."' alt='sans'/>
                        </div>
                        <div class='col-10'>
                            <h5 class='card-title'>".$drink["strDrink"]."</h5>
                            <p class='card-text'><b>Type: </b>".$drink["strAlcoholic"]."</p>
                            <button id='".$index."' type='button' class='btn-grad mt-2' data-bs-toggle='modal' data-bs-target='#drink-modal'>
                             Add
                            </button>
                            <button id='save-".$index."' type='button' class='btn-grad mt-2' data-bs-toggle='modal' data-bs-target='#drink-modal'>
                             Save
                            </button>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                ";
                echo $card_html;
                ++$index;
            }
        ?>
        </div>

        <div class="modal" tabindex="-1" id="drink-modal">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Modal title</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h4>Ingredients</h4>
                    <div class="w-50" id="ingredients">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-grad mt-2" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn-grad mt-2 text-light bg-primary">Add to party</button>
                </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>

    <script>
        let searchReturnList = <?php echo json_encode($search_return_list); ?>;
        let drinkModal = document.getElementById('drink-modal');

        drinkModal.addEventListener('show.bs.modal', function (event) {
            console.log(searchReturnList);
            let id = event.relatedTarget.id;

            let data = searchReturnList[id];
            let modalTitle = drinkModal.querySelector('.modal-title');
            let modalBody = drinkModal.querySelector('.modal-body #ingredients');


            modalTitle.textContent = data['strDrink'];

            let ingredientList = [];

            for (let i = 1; i < 17; i++) {
                if (data['strIngredient'+i]){
                    console.log("Ingredient: "+data['strIngredient'+i]);
                    console.log("Measure: "+data['strMeasure'+i]);
                    ingredientList.push([data['strIngredient'+i], data['strMeasure'+i]]);
                }else {
                    break;
                }
            }
            let ingredientHTML = "";

            console.log(ingredientList);

            ingredientList.forEach((ingredient) => {
                ingredientHTML += "<div class='row'>";
                if(ingredient[1]){
                    ingredientHTML += "<div class='col'>"+ingredient[1]+"</div>";
                }else{
                    ingredientHTML += "<i class='bi bi-record-fill col'></i>";
                }
                ingredientHTML += "<div class='col'>"+ingredient[0]+"</div>";
                ingredientHTML += "</div>";
            })

            modalBody.innerHTML = ingredientHTML;
        })
    </script>
</body>

</html>