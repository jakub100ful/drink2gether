<?php

require_once 'scripts/Drink.php';

function callAPI($url) {
    
    $json_data = file_get_contents($url);
    $response_data = json_decode($json_data, true);

    return $response_data;
}

function search($query) {

    $url = "https://www.thecocktaildb.com/api/json/v1/1/search.php?s=";
    $url .= urlencode($query);

    $json = callAPI($url);
    $ingredients = [];
    $drinks = $json["drinks"];

    for($i = 0; $i < count($drinks); $i++){
        for($x = 1; $x < 16; $x++) {
            if($drinks[$i]['strIngredient' . $x]){
                $ingredients[] = [$drinks[$i]['strIngredient' . $x], $drinks[$i]['strMeasure' . $x]];
            }
    
            unset($drinks[$i]['strIngredient' . $x]);
            unset($drinks[$i]['strMeasure' . $x]);
        }
    
        $drinks[$i]['ingredients'] = $ingredients;
    }

    return $drinks;
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
                $drinkObject = new Drink($drink["strDrink"],$drink["ingredients"]);
                $image_url = $drink["strDrinkThumb"];
                $ingredient_html = "";

                foreach ($drinkObject->ingredientsArray as $ingredient){
                    $ingredient_html .= "<li>".$ingredient->name."</li>";
                }

                $card_html = "
                <div class='row justify-content-center align-items-center'>
                    <div class='col-sm-6 mb-3'>
                    <div class='card'>
                        <div class='row card-body'>
                        <div class='col-2'>
                            <img class='img-responsive w-100 rounded-circle' src='".$image_url."' alt='sans'/>
                        </div>
                        <div class='col-4'>
                            <h5 class='card-title m-0'>".$drinkObject->name."</h5>
                            <span class='mt-1 badge rounded-pill bg-light text-secondary'>".$drink["strAlcoholic"]."</span>
                            <p class='card-text mb-1 mt-2'><b>Ingredients: </b></p>
                            <ul>".$ingredient_html."
                            </ul>
                            </div>

                        <div class='col-6 border-start'>
                            <h5>Recipe</h5>
                            <p class='card-text'>".$drink['strInstructions']."</p>

                            <p class='mb-1'><strong>Price per serving: </strong></p><h4><span class='badge border border-light text-light'>??".$drinkObject->price."</span></h4>

                            <div class='row'>
                                    <button id='".$index."' type='button' class='btn-grad mt-2 col-5' data-bs-toggle='modal' data-bs-target='#drink-modal'>
                                    Add
                                    </button>
                                    <h2 class='m-0 ms-1 col-2 d-flex align-items-center justify-content-start'>
                                        <i id='save-".$drink['idDrink']."' class='save-button bi bi-star'></i>
                                    </h2>
                            </div>
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
        let elementsArray = document.querySelectorAll('.save-button');

        elementsArray.forEach(function(elem) {
            elem.addEventListener('click', function() {
                console.log(elem.classList);
                if(elem.classList.contains('bi-star-fill')){
                    elem.classList.add('bi-star');
                    elem.classList.remove('bi-star-fill');
                }else if(elem.classList.contains('bi-star')){
                    elem.classList.add('bi-star-fill');
                    elem.classList.remove('bi-star');
                }
            });
        });

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