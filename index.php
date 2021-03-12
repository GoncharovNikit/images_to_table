<?php
session_start();
if(!isset($_SESSION["current_config"])){
    $_SESSION["current_config"] = "configs/conf1.txt";
}
error_reporting(0);
if(!empty($_POST)){
    move_uploaded_file($_FILES['img_path']['tmp_name'], 'configs/img/'.$_FILES['img_path']['name']);
    
    if(isset($_POST['table_change'])){
        $_SESSION['current_config'] = "configs/conf".$_POST['table_change'].".txt";
    }
    if(isset($_POST['title']) && isset($_POST['description']) && isset($_POST["adding"]) && $_POST["adding"] == "add"){
        if(!empty($_POST["title"]) && !empty($_POST["description"])){
            file_put_contents($_SESSION['current_config'], $_POST['title']."|".$_FILES['img_path']['name'].'|'.$_POST['description']."#", FILE_APPEND);
        }
    }
    if(isset($_POST["adding"])){
        if($_POST["adding"] == "clear"){
            unlink($_SESSION['current_config']);
            //array_map('unlink', glob("configs/img/*"));   #удалить все фотки при чистке таблицы
        }
    }
    header("Location: ".$_SERVER["PHP_SELF"]);
    exit;
}


if(file_exists($_SESSION['current_config'])){
    $arr_data = explode("#", (file_get_contents($_SESSION['current_config'])));
    array_pop($arr_data);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>

    body{
        margin: 0;
        padding: 0;
        background-color: darkgrey;
        padding-top: 7px;
    }
    form{
        border: 2px double black;
        width: 97%;
        height: 40px;
        display:flex;
        flex-direction:row;
        justify-content: space-around;
        margin-left: 4px;
        margin-top:7px;
        margin-bottom: 10px;
        padding: 5px;
    }
    form div{
        text-align:center;
    }
    img{
        width: 150px;
        
    }
    .obj{
        border: 6px double purple;
        width: 150px;
        height: 230px;
        display:flex;
        flex-direction:column;
        justify-content:space-around;
        margin: 4px;
        margin-bottom: 15.5px;
        text-align:center;
        border-radius: 9px;
    }
    .obj:hover{
        border-color: red;
    }
    #objects{
        display:flex;
        flex-wrap:wrap;
        justify-content:space-between;
    }
    #hide_{
        position:absolute;
        top: 0;
        left:0;
        width: 5px;
        height: 10px;
        background-color: darkred;
        border:0;
    }
    .title{
        font-size: 18pt;
        font-family:Arial;
    }
    .but{
        display: inline-block;
        color: black;
        font-weight: 700;
        text-decoration: none;
        user-select: none;
        padding: .5em 2em;
        outline: none;
        border: 2px solid;
        border-radius: 1px;
        transition: 0.2s;
        width: 100px;
        height: 40px;
        margin-left: 8px;
    }
    .but:hover{
        background: rgba(255,255,255,.2);
    }
    .but:active{
        background: white;
    }


    .tab {
        font-weight: 700;
        color: white;
        text-decoration: none;
        padding: .8em 1em calc(.8em + 3px);
        border-radius: 3px;
        background: rgb(64,199,129);
        box-shadow: 0 -3px rgb(53,167,110) inset;
        transition: 0.2s;
        width: 80px;
    } 
    .tab:hover { background: rgb(53, 167, 110); }
    .tab:active {
        background: rgb(33,147,90);
        box-shadow: 0 3px rgb(33,147,90) inset;
    }

    #tables{
        display:flex;
        flex-direction:row;
        justify-content: space-around;
        width: 44%;
        margin-left: 10px;
        padding-left: 40px;
    }
    #num{
        font-size: 30pt; line-height: 37px; margin-right: 30px; margin-left:20px; font-weight: 900; color:purple;
    }
    </style>
</head>
<body>
    <button id="hide_"></button>
    <form id="form_S" method="POST" enctype="multipart/form-data">
        <div>Image: <input type="file" name="img_path" id="" accept=".jpg, .jpeg, .png"></div>
        <div>Title: <input type="text" name="title" id=""></div>
        <div>Description: <input type="text" name="description" id=""></div>
        <button type="submit" name="adding" value="add" class="but">Add</button><br>
        <button type="submit" name="adding" value="clear" class="but">Clear</button><br>
        <div id="tables">
            <button class="tab" name="table_change" value="1">Table 1</button>  
            <button class="tab" name="table_change" value="2">Table 2</button>  
            <button class="tab" name="table_change" value="3">Table 3</button>  
            <button class="tab" name="table_change" value="4">Table 4</button>  
            <button class="tab" name="table_change" value="5">Table 5</button>  
            <button class="tab" name="table_change" value="6">Table 6</button>  
            <button class="tab" name="table_change" value="7">Table 7</button>  

        </div>
        <div id="num">
        <?= substr($_SESSION['current_config'], -5, 1);?>
        </div>
    </form>
    <div id="objects">

    <?php foreach($arr_data as $item): $arr = explode("|", $item); ?>
    <div class="obj">
    <div class="title"><?=$arr[0]; ?></div>
    <div class="image"><img src="configs/img/<?=$arr[1]; ?>" alt="<?=$arr[1]; ?>"></div>
    <div class="desc"><?=$arr[2]; ?></div>
    </div>
    </td>
    <?php endforeach; ?>
    </div>
    
    <script>
    document.querySelector("#hide_").addEventListener("click", function(){
        if(document.querySelector("#form_S").style.display == "none")document.querySelector("#form_S").style.display = "flex";
        else document.querySelector("#form_S").style.display = "none";

    });
    </script>
</body>
</html>