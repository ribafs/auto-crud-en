<?php require_once('./header.php');?>
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <a href="insert.php" class="btn btn-default">Novo Registro</a>
        </div>
        <div class="col-md-9">
            <form action="search.php" method="get" >
            <div class="pull-right"style="padding-left: 0;"  >
              <span class="pull-right">  
                <label class="col-lg-12 control-label" for="keyword" style="padding-right: 0;">
                  <input type="text" value="<?=$_GET["keyword"]?>" placeholder="Nome ou parte" class="form-control" name="keyword">
                </label>
                </span>
              <button class="btn btn-info">busca</button>
            </div>
            </form>
        </div>
    </div>
</div>
<br>

<?php
// Connect to database.
include './db_connect.php';
 
// Include our pagination class / library.
include './libs/ps_pagination.php';
 
// Query all data anyway you want
$sql = "select * from $table order by id";
 
/*
    Now, we are going to use our pagination class.
    This is a significant part of our pagination.
 
    I will explain the PS_Pagination parameters:
 
    > $pdo is a variable from our config_open_db.php
    > $sql is our sql statement above
    > 3 is the number of records retrieved per page
    > 4 is the number of page numbers rendered below
    > null - We used null because we don't have any other parameters to pass
 
    (i.e. param1=valu1&param2=value2)
    You can use this if you are going to use this class for search results.
    The last parameter is useful because you will have to pass the search keywords.
*/
// PS_Pagination($pdoection, $sql, $rows_per_page = 10, $links_per_page = 15, $append = "")
$pager = new PS_Pagination($pdo, $sql, 15, 23);
 
// Our pagination class will render new recordset.
// Search results now are limited for pagination.
$rs = $pager->paginate();

// Count how many rows of data were returned.
$num = $rs->rowCount();
 
if($num >= 0 ){

    // Create our table header
	print '<div class="container" align="center">';
    echo '<table class="table table-hover">';
    echo "<tr>";
        $sth = $pdo->query($sql);
        $numfields = $sth->columnCount();
        
        for($x=0;$x<$numfields;$x++){
            $meta = $sth->getColumnMeta($x);
            $field = $meta['name'];
	?>
	  <th><?=ucfirst($field)?></th>
	<?php
        }
		  print '<th colspan="2">Action</th>';
    echo "</tr>";
 
    // Loop through the records retrieved
    while ($row = $rs->fetch(PDO::FETCH_ASSOC)){
        echo "<tr>";
            for($x=0;$x<$numfields;$x++){
                $meta = $sth->getColumnMeta($x);
                $field = $meta['name'];
            ?>
            <td><?=$row[$field]?></td>
            <?php
            }
?>
            <td><a href="update.php?id=<?=$row['id']?>"><i class="glyphicon glyphicon-edit" title="Update"></a></td>
            <td><a href="delete.php?id=<?=$row['id']?>"><i class="glyphicon glyphicon-remove-circle" title="Delete"></a></td></tr>
<?php
        echo "</tr>";
    }
 
    echo "</table>";
}else{
    // If no records found
    echo "None register found!";
}
 
// 'page-nav' CSS class is used to control the appearance of our page number navigation
echo "<div class='page-nav' align='center'>";
    // Display our page number navigation
    echo $pager->renderFullNav();
echo "</div>";
?>
</div>
<?php require_once('./footer.php'); ?> 
