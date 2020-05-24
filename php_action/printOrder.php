<?php

require_once 'core.php';

$orderId = $_POST['orderId'];

$sql = "SELECT order_id, order_date, client_name, client_contact, sub_total, vat, total_amount, discount, grand_total, paid, due FROM orders WHERE order_id = $orderId";

$orderResult = $connect->query($sql);
$orderData = $orderResult->fetch_array();

$orderId = $orderData[0];
$orderDate = $orderData[1];
$clientName = $orderData[2];
$clientContact = $orderData[3];
//Montant HT
$subTotal = $orderData[4];
//TVA
$vat = $orderData[5];
//Montant Total
$totalAmount = $orderData[6];
//Remise
$discount = $orderData[7];
//Somme finale
$grandTotal = $orderData[8];
//Montant Payé
$paid = $orderData[9];
//Montant Du
$due = $orderData[10];


$orderItemSql = "SELECT order_item.product_id, order_item.rate, order_item.quantity, order_item.total,
product.product_name FROM order_item
	INNER JOIN product ON order_item.product_id = product.product_id
 WHERE order_item.order_id = $orderId";
$orderItemResult = $connect->query($orderItemSql);

 $table = '
 <img src="assests/images/logo.jpg" style="width:150px; height:150px;">

 <div style="width: 35%; height:15px; float:right;">
	<h6>NIF: 14396712 - Patente: 51350483 - R.C./13789</h6>
 </div>
 </br>
 <div style="float: right; padding-right: 200px; float:right;">
 	<p> <u>Signature :</u> </p>
 </div>

 </br>
 </br>
 </br>

 <h1 align="center"> FACTURE & GARANTIE N° '.$orderId.' </h1>
 <table border="1" cellspacing="0" cellpadding="20" width="100%">
	<thead>
		<tr >
			<th colspan="5">
			<center>
				<u>Date de commande :</u> '.$orderDate.'
				<center><u>Nom du client :</u> '.$clientName.'</center>
				<u>Contact :</u> '.$clientContact.'
			</center>
			</th>

		</tr>
	</thead>
</table>
<table border="0" width="100%;" cellpadding="5" style="border:1px solid black; border-top-style:1px solid black;border-bottom-style:1px solid black;">

	<tbody>
		<tr>
			<th style="border-right: 1px solid black;">Désignation</th>
			<th style="border-right: 1px solid black;">PU.H.T</th>
			<th style="border-right: 1px solid black;">Quantité</th>
			<th>Total.H.T</th>
		</tr>';

		$x = 1;
		while($row = $orderItemResult->fetch_array()) {

			$table .= '<tr>
				<th style="border-right: 1px solid black;">'.$row[4].'</th>
				<th style="border-right: 1px solid black;">'.$row[1].'</th>
				<th style="border-right: 1px solid black;">'.$row[2].'</th>
				<th>'.$row[3].'</th>
			</tr>
			';
		$x++;
		} // /while

		$table .= '<tr>
			<th></th>
		</tr>

		<tr>
			<th></th>
		</tr>

		<tr>
			<th></th>
			<th></th>
			<th style="border:  solid black;">Montant Total</th>
			<th style="border: solid black;">'.$subTotal.' DH</th>
		</tr>
	</tbody>
</table>


<body>
<footer style="position: fixed;
    left: 0;
    bottom: 0;
    width: 100%;
    text-align: center;">
  4 Rue 3.Av Mohamed V, Kaissariat Andalouss N°11 - Tétouan </br>
	Vente App, Eléctriques (SAMSUNG - LG - Whirlpool- BICO + Brandt - Candy...)
</footer>
 ';


$connect->close();

echo $table;
