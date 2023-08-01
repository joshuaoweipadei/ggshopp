<?php
session_start();

include ("./data/products.php");

function isProductInCart($product_id) {
	if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
		foreach ($_SESSION['cart'] as $item) {
			if ($item['id'] == $product_id) {
				return true;
			}
		}
	}
	return false;
}

// Check if a product is added to the cart
if (isset($_POST['product_id'])) {
	$product_id = $_POST['product_id'];
	if (isset($products[$product_id])) {
		if (!isProductInCart($product_id)) {
			$product = $products[$product_id];
			$_SESSION['cart'][] = $product;
		} else {
			// If product already exists, you may update quantity or show a message
			// In this example, we will simply show an alert message
			echo "Item already exist";
		}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>GGSHOP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #ADD8E6;
            color: #fff;
            padding: 10px;
            text-align: center;
						display: flex;
  					justify-content: space-between;
						align-items: center;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .description {
            font-size: 16px;
            margin-bottom: 20px;
        }

        .button {
            background-color: #ADD8E6;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 10px 0;
            cursor: pointer;
            border-radius: 4px;
        }

        .button:hover {
            background-color: #00008B;
        }

    </style>
    <link rel="stylesheet" href="css/product-card.css">
</head>
<body>
    <header>
        <h1>Welcome to GGSHOP Style</h1>
				<div>
					<a href="cart.php" class="cart">
						<?php
							if(isset($_SESSION['cart'])) {
								$total = count($_SESSION['cart']);
								echo "<p>Cart: $total</p>";
							} else {
								echo "<p>Cart: 0</p>";
							}
						?>
					</a>
				</div>
    </header>

    <div class="container">
			<div class="description">
				<h2>Who We Are</h2>
				<p>Discover your style with our chic and user-friendly ecommerce website for clothes. Browse a diverse collection of fashion-forward apparel for men, women, and kids. Enjoy high-quality imagery, detailed product descriptions, and easy size guides for a seamless shopping experience. With secure checkout, swift delivery, and excellent customer support, revamp your wardrobe hassle-free. Don't miss exclusive offers and discounts to elevate your fashion game. Shop now and embrace your unique style effortlessly!</p>
			</div>
			<a href="#" class="button">Shop Now</a>
    </div>

    <div>
			<h4>Products</h4>
			<!-- -->
			<div>
				<div class="product_wrapper">
					<?php foreach ($products as $product): ?>
						<div class="product_card">
							<img src="<?php echo $product['image']; ?>" alt="">
							<form method="post" action="index.php">
								<h6><?php echo $product['name']; ?></h6>
								<p><strong>$<?php echo $product['price']; ?></strong></p>
								<input type="text" name="product_id" value="<?php echo $product['id']; ?>" />
								<input type="submit" name="add_to_cart" class="add_to_cart_btn" value="Add to Cart" />
							</form>
						</div>
						<?php endforeach; ?>
				</div>
			</div>
    </div>
</body>
</html>

<?php //unset($_SESSION['cart']); ?>
