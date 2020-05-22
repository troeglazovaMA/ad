<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Table</title>
  </head>
  <body>
  	<table class="table table-bordered">
  		<thead class="thead-dark">
  			<tr>
  			<?php
	           foreach($values_lables as $label)
	               print('<th scope="col">'.$label.'</th>');
	          ?>
	    	</tr>
		</thead>
		<tbody>
			<?php 
			foreach ($values as $key => $value){
			    print('<tr>');
			    foreach ($value as $atr)
			    print('<td>'.$atr.'</td>');
			    print('<td> 
                <form action="admin.php" method="POST">
                <button class="btn btn-primary" value="'.$key.'" name="todelete" type="submit">Удалить</button>
                </form> 
                </td>');
			    print('</tr>');
			}
			?>
		</tbody>
  	</table>
  </body>
</html>
