<?php

session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cart Page</title>
</head>
<body>
  <div>
    <h4>Cart Items</h4>
    <?php
      if(isset($_SESSION["cart"])){
        $item_total = 0;
        $total_quantity = 0;
    ?>
      <table>
        <thead>
          <tr>
            <th>Product Name</th>
            <th class="text-right">Price #</th>
          </tr>
        <thead>
        <tbody>
          <?php
            foreach ($_SESSION["cart"] as $item){
          ?>
          <tr>
            <td><?php echo $item["name"]; ?></td>
            <td>$<?php echo $item["price"]; ?></td>
          </tr>
          <?php
              $item_total += ($item["price"]);
              // $total_quantity += $item["quantity"];
            }
          ?>
          <tr style="">
            <td><?php echo "Total"; ?></td>
            <td>$<?php echo $item_total; ?></td>
          </tr>
        </tbody>
      </table>
      <?php }?>
  </div>
</body>
<<<<<<< HEAD
</html>
=======
</html>
>>>>>>> 59364cbeb1e0eddf4a11e28596eecc2f7ae671e1
