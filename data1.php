<?php
require_once "data.php";
$db = new Data("localhost", "root", "","new");

$name = null;
$age = null; 
$btn_name = "insert";
$btn_value = "Save User";

if (isset($_GET['edit']) && !empty($_GET['edit'])) {
    $query = "SELECT name, age FROM newtable WHERE id=" .$_GET['edit'];
    $user = $db->selectOne($query); 
    $name = $user['name'];
    $age = $user['age']; 
    $btn_name = "update";
    $btn_value = "Update post";
}

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    if (isset($_POST['insert'])) { 
    $name=$_POST['name'];
    $age=$_POST['age'];
   $tb = $db->insert("INSERT INTO newtable(name,age) VAlUES(:name, :age)",[ 
      ':name' => $name,
     ':age' => $age,
     ]); 
   }
   if (isset($_POST['update'])) {

    $name = $_POST['name'];
    $email = $_POST['age']; 

    $isSuccess = $db->update("UPDATE newtable SET name=:name, age=:age WHERE id=".$_GET['edit'], [
        ":name" => $name,
        ":age" => $age,
        ]); 

    if ($isSuccess) {
    header("Location:http://data.test/data1.php?message=update");
   }
 }
}


if (isset($_GET['delete']) && !empty($_GET['delete'])) {
    $query = "DELETE FROM newtable WHERE id=" . $_GET['delete'];
    $delete = $db->delete($query);
    if ($delete) {
        $message = '<div class="alert alert-success" role="alert">
                            User Deleted Successfully
                        </div>';
    }
}
// if(isset($_GET['edit']) && !empty($_GET['edit'])){
//     $query = "SELECT name, age FROM newtable WHERE id=" . $_GET['edit'];
//     $connect=$db->selectone($query);
//     $name = $connect['name'];
//     $age = $connect['age'];
//     // $password = $user['password'];
//     $btn_name = "update";
//     $btn_value = "Update connect";
//     // Var_dump($connect);
// }


// if (isset($_POST['update'])) {

//     $name = $_POST['name'];
//     $age = $_POST['age'];
//     // $password = $_POST['password'];

//     $isSuccess = $db->update("UPDATE newtable SET name=:name, age=:age, WHERE id=" . $_GET['edit'], [
//         ":name" => $name,
//         ":age" => $age,
//         // ":password" => $password,
//     ]);
    // var_dump($isSuccess);


  
    $data = $db->select("SELECT * FROM newtable");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <form  method="post">
    <input type="text" name="name" value="<?php echo $name; ?>"/>
    <input type="number" name="age" value="<?php echo $age; ?>"/>
    <button class="btn btn-primary" name="<?php echo $btn_name; ?>">
                        <?php echo $btn_value; ?>
                    </button>
    </form>

<br>
<br>
<table>
<tr>
<th>id</th>
<th>name</th>
<th>age</th>
<th>delete</th>
</tr>
<tr>
<?php
foreach($data as $newtable){
?>
<td><?php echo $newtable['id'];?></td>
<td><?php echo $newtable['name']; ?></td>
<td><?php echo $newtable['age']; ?></td>
<td>
<a href="?edit=<?php echo  $newtable['id']; ?>" class="btn btn-warning">Edit</a>
<a href="?delete=<?php echo  $newtable['id']; ?>" class="btn btn-danger">Delete</a>
   </td>
</tr>
<?php
}
?>
</table>
</body>
</html>