<?php
require_once('./header.php');
require_once('./db_connect.php');

print '<h3 align="center">'.ucfirst($table).'</h3>';
?>
<div class="container">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
        <table class="table table-bordered table-responsive">    
            <form method="post" action="add.php?table=<?=$table?>"> 

<?php
    $sql = "SELECT * FROM $table";
    $sth = $pdo->query($sql);
    $numfields = $sth->columnCount();

    $tb = "index.php?table=$table";
        
    for($x=0;$x<$numfields;$x++){
        $meta = $sth->getColumnMeta($x);
        $field = $meta['name'];
        if($x>0){
?>
        <tr><td><b><?=ucfirst($field)?></td><td><input type="text" name="<?=$field?>"></td></tr>

<?php
        }
    }
?>
            <input name="table" type="hidden" value="<?=$table?>">
            <tr><td></td><td><input class="btn btn-primary" name="send" type="submit" value="Insert">&nbsp;&nbsp;&nbsp;
            <input class="btn btn-warning" name="send" type="button" onclick="location='<?=$tb?>'" value="Back"></td></tr>
            </form>
        </table>
        </div>
    </div>
</div>

<?php

if(isset($_POST['send'])){

	$set='';
	$sths='';
    $numfields = $sth->columnCount();
        
    for($x=0;$x<$numfields;$x++){
        $meta = $sth->getColumnMeta($x);
        $field = $meta['name'];     

        if($x==0) continue;

		if($x<$numfields-1){
            $fields .= "$field,";
            $values .= ":$field, ";
		}else{
            $fields .= "$field";
            $values .= ":$field";
		}
	}
    $sql = "INSERT INTO $table ($fields) VALUES ($values)";
    $sth = $pdo->prepare($sql);    

    for($x=1;$x<$numfields;$x++){
		$select = $pdo->query("SELECT * FROM $table");
		$meta = $select->getColumnMeta($x);
		$field=$meta['name'];

		$sth->bindParam(":$field", $_POST["$field"], PDO::PARAM_INT);
	}
    $executa = $sth->execute();

    if($executa){
         print "<script>location='$tb';</script>";
    }else{
        echo 'Error on insert register';
    }
}
require_once('./footer.php');
?>

