<?php
/*
 * Created by: Baldwin Yu
 * Created for: Fresh Focus Media
 *
 * This is the request page so the application can request data using AJAX
 * and encode into JSON to run the web application responsively.
 *
 */

header("Content-Type:application/json", true);
header("Access-Control-Allow-Origin: *");

include('dataAccess/DA.class.php');
include('dataAccess/CustomerDA.class.php');
include('dataAccess/ProductPricingDA.class.php');
include('dataAccess/CategoryDA.class.php');
include('dataAccess/PartDA.class.php');
include('dataAccess/InventoryDA.class.php');
include('dataAccess/OrderDA.class.php');

/* Runs the correct requests based on what action is posted from the web application */
if (isset($_POST['action']) && !empty($_POST['action'])) {
	$action = $_POST['action'];

	switch ($action) {
		case 'category':
			getCategories();
			break;

		case 'part':
			getParts();
			break;

		case 'product':
			getProducts();
			break;

		case 'price':
			getPrice();
			break;

		case 'submit':
			insertOrder();
			break;
	}
}

/* Function to get categories all categories and encodes to JSON */
function getCategories() {
	$categoryDA = new CategoryDA();

	$categories = $categoryDA->getAll();

	echo json_encode($categories);
}

/* Function that gets all parts based on category id and encodes to JSON */
function getParts() {
	$partDA = new PartDA();

	if (isset($_POST['categoryId']) && !empty($_POST['categoryId'])) {
		$categoryId = $_POST['categoryId'];

		$parts = $partDA->getByCategoryId($categoryId);

		echo json_encode($parts);
	}
}

/* Function that gets all products based on category id, product pricing id, and part id and encods to JSON */
function getProducts() {
	$inventoryDA = new InventoryDA();

	if (isset($_POST['productPricingId']) && !empty($_POST['productPricingId']) &&
		isset($_POST['categoryId']) && !empty($_POST['categoryId']) &&
		isset($_POST['partId']) && !empty($_POST['partId'])) {
		$productPricingId = $_POST['productPricingId'];
		$categoryId = $_POST['categoryId'];
		$partId = $_POST['partId'];

		$products = $inventoryDA->getProducts($categoryId, $partId, $productPricingId);

		echo json_encode($products);
	}
}

/* Function that gets the price of a product based on the inventory id and encodes to JSON */
function getPrice() {
	$inventoryDA = new InventoryDA();

	if (isset($_POST['inventoryId']) && !empty($_POST['inventoryId'])) {
		$inventoryId = $_POST['inventoryId'];

		$price = $inventoryDA->getPrice($inventoryId);

		echo json_encode($price);
	}
}

function insertOrder() {
	$details = [];

	// Order date
	if (isset($_POST['orderDate']) && !empty($_POST['orderDate'])) {
		$details['orderDate'] = $_POST['orderDate'];
	}

	// Customer id
	if (isset($_POST['customerId']) && !empty($_POST['customerId'])) {
		$details['customerId'] = $_POST['customerId'];
	}

	// Subtotal
	if (isset($_POST['subtotal']) && !empty($_POST['subtotal'])) {
		$details['subtotal'] = $_POST['subtotal'];
	}

	// Discount type
	if (isset($_POST['discountType']) && !empty($_POST['discountType'])) {
		$details['discountType'] = $_POST['discountType'];
	} else {
		$details['discountType'] = '';
	}

	// Discount value
	if (isset($_POST['discountValue']) && !empty($_POST['discountValue'])) {
		$details['discountValue'] = $_POST['discountValue'];
	} else {
		$details['discountValue'] = 0;
	}

	// Tax
	if (isset($_POST['tax']) && !empty($_POST['tax'])) {
		$details['tax'] = $_POST['tax'];
	} else {
		$details['tax'] = 0;
	}

	// Total
	if (isset($_POST['total']) && !empty($_POST['total'])) {
		$details['total'] = $_POST['total'];
	}

	// Payment type id
	if (isset($_POST['paymentTypeId']) && !empty($_POST['paymentTypeId'])) {
		$details['paymentTypeId'] = $_POST['paymentTypeId'];
	}

	// Comments
	if (isset($_POST['comments']) && !empty($_POST['comments'])) {
		$details['comments'] = $_POST['comments'];
	} else {
		$details['comments'] = '';
	}

	// Employee id
	if (isset($_POST['employeeId']) && !empty($_POST['employeeId'])) {
		$details['employeeId'] = $_POST['employeeId'];
	}

	// Ship date
	if (isset($_POST['shipDate']) && !empty($_POST['shipDate'])) {
		$details['shipDate'] = $_POST['shipDate'];
	}

	$orderDA = new OrderDA();

	$orderId = $orderDA->insertOrder($details);
	$order = $orderDA->getById($orderId);

	echo json_encode($order);
}

?>