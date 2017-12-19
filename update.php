<?php
require_once('./header.php');
require_once('./db_connect.php');

if(isset($_POST['id'])){
	$id=$_POST['id'];
}else{
	$id=$_GET['id'];
}
print '<h3 align="center">'.ucfirst($table).'</h3>';
?>

<div class="container" align="center">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <form method="post" action="update.php?table=<?=$table?>">
                <table class="table table-bordered table-responsive table-hover">

<?php

$sth = $pdo->prepare("SELECT * from $table WHERE id = :id");
$sth->bindValue(':id', $id, PDO::PARAM_STR); // No select e no delete basta um bindValue
$sth->execute();

$reg = $sth->fetch(PDO::FETCH_OBJ);

    $sql = "SELECT * FROM $table";
    $sth = $pdo->query($sql);
    $numfields = $sth->columnCount();
        
    for($x=0;$x<$numfields;$x++){
        $meta = $sth->getColumnMeta($x);
        $field = $meta['name'];
?>
                <tr><td><b><?=ucfirst($field)?></td><td><input type="text" name="<?=$field?>" value="<?=$reg->$field?>"></td></tr>
<?php
}
?>
                <input name="id" type="hidden" value="<?=$id?>">
                <tr><td></td><td><input name="send" class="btn btn-primary" type="submit" value="Update">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input name="send" class="btn btn-warning" type="button" onclick="location='index.php?table=<?=$table?>'" value="Back"></td></tr>
                </table>
            </form>
        </div>
    <div>
</div>
<?php

if(isset($_POST['send'])){
	$set='';
	$sths='';
    $numfields = $sth->columnCount();
        
    for($x=0;$x<$numfields;$x++){
        $meta = $sth->getColumnMeta($x);
        $field = $meta['name'];

	    $$field = $_POST[$field];

		if($x<$numfields-1){
			if($x==0) continue;
			$set .= "$field=:$field,";
		}else{
			if($x==0) continue;
			$set .= "$field=:$field";
		}
	}

    $sql = "UPDATE $table SET $set WHERE id = :id";
    $sth = $pdo->prepare($sql);


    for($x=0;$x<$numfields;$x++){
		$select = $pdo->query("SELECT * FROM $table");
		$meta = $select->getColumnMeta($x);
		$field=$meta['name'];
		$sth->bindParam(":$field", $_POST["$field"], PDO::PARAM_INT);
	}

   if($sth->execute()){
        print "<script>location='index.php?table=$table';</script>";
    }else{
        print "Error on update register!<br><br>";
    }
}
require_once('./footer.php');
?>

