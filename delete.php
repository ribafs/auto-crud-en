<?php 
require_once('./header.php');
require_once('./db_connect.php');

$id=$_GET['id'];

print '<h3 align="center">'.ucfirst($table).'</h3>';
?>

<div class="container">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <h3>Really delete this register?</h3>
            <br>

<?php

$sth = $pdo->prepare("SELECT * from $table WHERE id = :id");
$sth->bindValue(':id', $id, PDO::PARAM_STR);
$sth->execute();

$reg = $sth->fetch(PDO::FETCH_OBJ);

    $sql = "SELECT * FROM $table";
    $sth = $pdo->query($sql);
    $numfields = $sth->columnCount();
        
    for($x=0;$x<$numfields;$x++){
        $meta = $sth->getColumnMeta($x);
        $field = $meta['name'];
?>

            <b><?=ucfirst($field)?>:</b> <?=$reg->$field?><br>
<?php
    }
?>
            <br>
            <form method="post" action="">
            <input name="id" type="hidden" value="<?=$id?>">
            <input name="enviar" class="btn btn-danger" type="submit" value="Delete!">&nbsp;&nbsp;&nbsp;
            <input name="enviar" class="btn btn-warning" type="button" onclick="location='index.php?table=<?=$table?>'" value="Back">
            </form>
        </div>
    <div>
</div>
<?php

if(isset($_POST['enviar'])){
    $id = $_POST['id'];
    $sql = "DELETE FROM  $table WHERE id = :id";
    $sth = $pdo->prepare($sql);
    $sth->bindParam(':id', $id, PDO::PARAM_INT);   
    if( $sth->execute()){
        print "<script>location='index.php?table=$table';</script>";
    }else{
        print "Error on delete register!<br><br>";
    }
}
require_once('./footer.php');
?>
