<?php 

require_once('./header.php');

include './db_connect.php';
// Busca
if(isset($_GET['keyword'])){
    $keyword=$_GET['keyword'];
    $sql = "select * from $table";
    $sth = $pdo->prepare($sql);
    $sth->execute();

    $meta = $sth->getColumnMeta(1);
    $field = $meta['name'];

    $sql = "select * from $table WHERE $field LIKE :keyword order by id";

    $sth = $pdo->prepare($sql);
    $sth->bindValue(":keyword", $keyword."%");
    $sth->execute();

    $rows =$sth->fetchAll(PDO::FETCH_ASSOC);
}
print '<div class="container" align="center">';
print '<h4>Registro(s) encontrado(s)</h4>';

	print '<div class="container" align="center">';
    echo '<table class="table table-hover">';
    echo "<tr>";

//        $sth = $pdo->query($sql);
        $numfields = $sth->columnCount();
        
        for($x=0;$x<$numfields;$x++){
            $meta = $sth->getColumnMeta($x);
            $field = $meta['name'];
	?>
	  <th><?=ucfirst($field)?></th>
	<?php
        }
		  print '<th colspan="2">Ação</th>';
    echo "</tr>";
 
    // Loop through the records retrieved
    foreach ($rows as $row){
        echo "<tr>";
            for($x=0;$x<$numfields;$x++){
                $meta = $sth->getColumnMeta($x);
                $field = $meta['name'];
            ?>
            <td><?=$row[$field]?></td>
            <?php
            }
?>
            <td><a href="update.php?id=<?=$row['id']?>"><i class="glyphicon glyphicon-edit" title="Editar"></a></td>
            <td><a href="delete.php?id=<?=$row['id']?>"><i class="glyphicon glyphicon-remove-circle" title="Excluir"></a></td></tr>
<?php
        echo "</tr>";
    }
 
    echo "</table>";
?>

<input name="enviar" class="btn btn-warning" type="button" onclick="location='index.php?table=<?=$table?>'" value="Voltar">
</div>
<?php 
require_once('./header.php');
?>
