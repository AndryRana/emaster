<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<div class="container">
	<div class="row">
		<div class="col-xs-12">
			<div class="invoice-title">
				<h2>Facture</h2>
				<h3 class="pull-right">Commande # {{ $orderDetails->id }} <span class="pull-right">{!!
						DNS1D::getBarcodeHTML($orderDetails->id, 'C39')!!} </span> </h3>
			</div>
			<hr>
			<div class="row">
				<div class="col-xs-6">
					<address>
						<strong>Facturé à:</strong><br>
						{{ $userDetails->name }} <br>
						{{ $userDetails->address }} <br>
						{{ $userDetails->city }} <br>
						{{ $userDetails->state }} <br>
						{{ $userDetails->country }} <br>
						{{ $userDetails->pincode }} <br>
						{{ $userDetails->mobile }} <br>
					</address>
				</div>
				<div class="col-xs-6 text-right">
					<address>
						<strong>Livré à:</strong><br>
						{{ $orderDetails->name }} <br>
						{{ $orderDetails->address }} <br>
						{{ $orderDetails->city }} <br>
						{{ $orderDetails->state }} <br>
						{{ $orderDetails->country }} <br>
						{{ $orderDetails->pincode }} <br>
						{{ $orderDetails->mobile }}
					</address>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-6">
					<address>
						<strong>Mode de paiement:</strong><br>
						{{ $orderDetails->payment_method }}
					</address>
				</div>
				<div class="col-xs-6 text-right">
					<address>
						<strong>Date de la commande:</strong><br>
						{{ $orderDetails->created_at->format('d-m-Y H:i:s')  }}<br><br>
					</address>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong>Résumé de la commande</strong></h3>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-condensed">
							<thead>
								<tr>
									<td style="width:18%"><strong>Code du produit</strong></td>
									<td style="width:18%" class="text-center"><strong>Taille</strong></td>
									<td style="width:18%" class="text-center"><strong>Couleur</strong></td>
									<td style="width:18%" class="text-center"><strong>Prix</strong></td>
									<td style="width:18%" class="text-center"><strong>Quantité</strong></td>
									<td style="width:18%" class="text-right"><strong>Total</strong></td>
								</tr>
							</thead>
							<tbody>
								<!-- foreach ($order->lineItems as $line) or some such thing here -->
								<?php $Subtotal = 0; ?>
								@foreach($orderDetails->orders as $pro)
								<tr>

									<td class="text-left">{{ $pro->product_code }} {!!
										DNS2D::getBarcodeHTML($pro->product_code, 'QRCODE')!!} </td>
									<td class="text-center">{{ $pro->product_size }}</td>
									<td class="text-center">{{ $pro->product_color }}</td>
									<td class="text-center">
										{{ number_format($pro->product_price, 2, ',', ' ') . ' €'  }}</td>
									<td class="text-center">{{ $pro->product_qty }}</td>
									<td class="text-right">
										{{ number_format($pro->product_price * $pro->product_qty, 2, ',', ' ') . ' €'  }}
									</td>
								</tr>
								<?php $Subtotal = $Subtotal + ($pro->product_price * $pro->product_qty); ?>
								@endforeach
								<tr>
									<td class="no-line"></td>
									<td class="no-line"></td>
									<td class="no-line"></td>
									<td class="no-line"></td>
									<td class="no-line text-center"><strong>Frais de port (+)</strong></td>
									<td class="no-line text-right">
										{{ number_format($orderDetails->shipping_charges , 2, ',', ' ') . ' €'  }}</td>
								</tr>
								<tr>
									<td class="thick-line"></td>
									<td class="thick-line"></td>
									<td class="thick-line"></td>
									<td class="thick-line"></td>
									<td class="thick-line text-center"><strong>Sous-total</strong></td>
									<td class="thick-line text-right">
										{{ number_format($Subtotal+$orderDetails->shipping_charges , 2, ',', ' ') . ' €'  }}
									</td>
								</tr>
								<tr>
									<td class="no-line"></td>
									<td class="no-line"></td>
									<td class="no-line"></td>
									<td class="no-line"></td>
									<td class="no-line text-center"><strong>Coupon de Réduction (-)</strong></td>
									<td class="no-line text-right">
										{{ number_format($orderDetails->coupon_amount , 2, ',', ' ') . ' €'  }}</td>
								</tr>
								<tr>
									<td class="no-line"></td>
									<td class="no-line"></td>
									<td class="no-line"></td>
									<td class="no-line"></td>
									<td class="no-line text-center"><strong>TVA(inclus)</strong></td>
									<td class="no-line text-right">
										{{ number_format($orderDetails->grand_total*0.2  , 2, ',', ' ') . ' €'  }}</td>
								</tr>
								<tr>
									<td class="no-line"></td>
									<td class="no-line"></td>
									<td class="no-line"></td>
									<td class="no-line"></td>
									<td class="no-line text-center"><strong>Total</strong></td>
									<td class="no-line text-right">
										{{ number_format($orderDetails->grand_total  , 2, ',', ' ') . ' €'  }}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>