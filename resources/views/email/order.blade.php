<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <table width='700px'>
		<tr><td>&nbsp;</td></tr>
		<tr><td><img src="{{ asset('images/frontend_images/home/logo.png') }}"></td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td>Bonjour {{ $name }},</td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td>Merci pour votre achat. Les détails de votre commande sont détaillés ci dessous: -</td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td>Numéro de commande: {{ $order_id }}</td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td>
			<table width='95%' cellpadding="5" cellspacing="5" bgcolor="#f7f4f4">
				<tr bgcolor="#cccccc">
					<td>Produit</td>
					<td>Code du produit</td>
					<td>Taille</td>
					<td>couleur</td>
					<td>Quantité</td>
					<td>Prix unitaire</td>
				</tr>
				@foreach($productDetails['orders'] as $product)
					<tr>
						<td>{{ $product['product_name'] }}</td>
						<td>{{ $product['product_code'] }}</td>
						<td>{{ $product['product_size'] }}</td>
						<td>{{ $product['product_color'] }}</td>
						<td>{{ $product['product_qty'] }}</td>
						<td>{{ number_format($product['product_price'] , 2, ',', ' ') . ' €' }}</td>
					</tr>
				@endforeach
				<tr>
					<td colspan="5" align="right">Frais de port</td><td>{{ number_format($productDetails['shipping_charges'] , 2, ',', ' ') . ' €' }}</td>
				</tr>
				<tr>
					<td colspan="5" align="right">Coupon</td><td>{{ number_format($productDetails['coupon_amount'] , 2, ',', ' ') . ' €' }}</td>
				</tr>
				<tr>
					<td colspan="5" align="right">Total</td><td>{{ number_format($productDetails['grand_total'] , 2, ',', ' ') . ' €' }}</td>
				</tr>
			</table>
		</td></tr>
		<tr><td>
			<table width="100%">
				<tr>
					<td width="50%">
						<table>
							<tr>
								<td><strong>Adresse de facturation</strong></td>
							</tr>
							<tr>
								<td>{{ $userDetails['name'] }}</td>
							</tr>
							<tr>
								<td>{{ $userDetails['address'] }}</td>
							</tr>
							<tr>
								<td>{{ $userDetails['city'] }}</td>
							</tr>
							<tr>
								<td>{{ $userDetails['state'] }}</td>
							</tr>
							<tr>
								<td>{{ $userDetails['country'] }}</td>
							</tr>
							<tr>
								<td>{{ $userDetails['pincode'] }}</td>
							</tr>
							<tr>
								<td>{{ $userDetails['mobile'] }}</td>
							</tr>
						</table>
					</td>
					<td width="50%">
						<table>
							<tr>
								<td><strong>Adresse de livraison</strong></td>
							</tr>
							<tr>
								<td>{{ $productDetails['name'] }}</td>
							</tr>
							<tr>
								<td>{{ $productDetails['address'] }}</td>
							</tr>
							<tr>
								<td>{{ $productDetails['city'] }}</td>
							</tr>
							<tr>
								<td>{{ $productDetails['state'] }}</td>
							</tr>
							<tr>
								<td>{{ $productDetails['country'] }}</td>
							</tr>
							<tr>
								<td>{{ $productDetails['pincode'] }}</td>
							</tr>
							<tr>
								<td>{{ $productDetails['mobile'] }}</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td>Vous rencontrez un problème? Nous contacter <a href="mailto:info@emaster.com">info@emaster.com</a></td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td>Merci et à bientôt sur notre site Emaster<br> Equipe Emaster</td></tr>
		<tr><td>&nbsp;</td></tr>
	</table>
</body>
</html>