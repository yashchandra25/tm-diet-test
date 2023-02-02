<?php
  $keyword = $_GET["keyword"];
  $conn = mysqli_connect("database-1.cnwsglcee9xn.ap-south-1.rds.amazonaws.com", "admin", "test1234", "tmdiet");
  $result = mysqli_query($conn, "SELECT * FROM dishes WHERE name LIKE '%$keyword%'");
  
  $recipes = array();
  while ($row = mysqli_fetch_assoc($result)) {
    $recipe = array();
    $recipe["id"] = $row["id"];
    $recipe["name"] = $row["name"];
    $recipe["group_name"] = $row["group_name"];

    $recipe["ingredients"] = array();
    $ingredient_result = mysqli_query($conn, "SELECT * FROM ingredients WHERE dish_id = " . $recipe["id"]);
    while ($ingredient_row = mysqli_fetch_assoc($ingredient_result)) {
      array_push($recipe["ingredients"], $ingredient_row["name"]);
    }

    $recipe["instructions"] = array();
    $instruction_result = mysqli_query($conn, "SELECT * FROM instructions WHERE dish_id = " . $recipe["id"]);
    while ($instruction_row = mysqli_fetch_assoc($instruction_result)) {
      array_push($recipe["instructions"], array("step_number" => $instruction_row["step_number"], "instruction" => $instruction_row["instruction"]));
    }

    array_push($recipes, $recipe);
  }

  echo json_encode($recipes);
?>
