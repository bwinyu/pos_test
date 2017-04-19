<?php
/*
 * Created by: Baldwin Yu
 * Created for: Fresh Focus Media
 *
 * This is a point of sale web application requested by Fresh Focus Media as a
 * code revision test.
 *
 */

include('includes/index.inc.php');

?>

<html>
<head>

	<title>Point of Sale Application</title>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="css/styles.css">
	<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
	<script src="js/index.js"></script>

</head>

<body>

	<div class="container">
		<form>

			<!-- Order date -->
			<div class="row top-buffer">
				<label class="col-md-2 text-right">Order Date</label>
				<div class="col-md-10">
					<input type="text" id="orderDate" name="orderDate" value="<?php echo date('Y-m-d') ?>" disabled="true">
				</div>
			</div>

			<!-- Customer -->
			<div class="row top-buffer">
				<label class="col-md-2 text-right required">Customer</label>
				<div class="col-md-10">
					<select class="col-md-10" id="customers" name="customers">
						<option value="">Choose Customer...</option>
						<?php
							foreach($customers as $row) {
								printf('<option value="%s">%s %s</option>',
									$row['id'],
									$row['firstname'],
									$row['lastname']);
							}
						?>
					</select>
				</div>
			</div>

			<!-- Product pricing -->
			<div class="row top-buffer">
				<label class="col-md-2 text-right required">Product Pricing</label>
				<div class="col-md-10">
					<select class="col-md-10" id="productPricing" name="productPricing">
						<option value="">Please Select</option>
						<?php
							foreach($productPricing as $row) {
								printf('<option value="%s">%s</option>',
									$row['id'],
									$row['description']);
							}
						?>
					</select>
				</div>
			</div>

			<!-- Inventory labels -->
			<div class="row top-buffer">
				<label class="col-md-2 text-center">Category</label>
				<label class="col-md-2 text-center">Part #</label>
				<label class="col-md-2 text-center">Product</label>
				<label class="col-md-2 text-center">Price</label>
				<label class="col-md-2 text-center">Quantity</label>
			</div>

			<!-- Inventory -->
			<div class="row top-buffer">
				<div class="col-md-2">
					<select id="category" name="category" disabled="true">
						<option value="">Choose Category...</option>
					</select>
				</div>
				<div class="col-md-2">
					<select id="part" name="part" disabled="true">
						<option value="">Choose a Part #...</option>
					</select>
				</div>
				<div class="col-md-2">
					<select id="product" name="product" disabled="true">
						<option value="">Choose a Product...</option>
					</select>
				</div>
				<div class="col-md-2">
					<input type="number" id="price" name="price" value="0" disabled="true">
				</div>
				<div class="col-md-2">
					<input type="number" id="quantity" name="quantity" value="0" disabled="true">
				</div>
			</div>

			<!-- Add product button -->
			<div class="row top-buffer">
				<div class="col-md-2">
					<input type="button" id="addProduct" value="Add">
				</div>
			</div>

			<!-- List of added products -->
			<div id="addedProducts" class="row top-buffer"></div>

			<!-- Subtotal -->
			<div class="row top-buffer">
				<label class="col-md-2 text-right required">Sub-Total</label>
				<div class="col-md-10">
					<input class="col-md-10" type="number" id="subtotal" name="subtotal" value="0" disabled="true">
				</div>
			</div>

			<!-- Discount type -->
			<div class="row top-buffer">
				<label class="col-md-2 text-right">Discount Type</label>
				<div class="col-md-1">
					<input type="radio" name="discountType" value="1"> %
				</div>
				<div class="col-md-1">
					<input type="radio" name="discountType" value="2"> $
				</div>
			</div>

			<!-- Discount value -->
			<div class="row top-buffer">
				<label class="col-md-2 text-right">Discount Value</label>
				<div class="col-md-10">
					<input class="col-md-10" type="number" id="discountValue" name="discountValue" value="0" disabled="true">
				</div>
			</div>

			<!-- Total after discount -->
			<div class="row top-buffer">
				<label class="col-md-2 text-right">Total After Discount</label>
				<div class="col-md-10">
					<input class="col-md-10" type="number" id="totalAfterDiscount" name="totalAfterDiscount" value="0" disabled="true">
				</div>
			</div>

			<!-- Total before tax -->
			<div class="row top-buffer">
				<label class="col-md-2 text-right">Total Before Tax</label>
				<div class="col-md-10">
					<input class="col-md-10" type="number" id="totalBeforeTax" name="totalBeforeTax" value="0" disabled="true">
				</div>
			</div>

			<!-- GST -->
			<div class="row top-buffer">
				<label class="col-md-2 text-right">GST (%)</label>
				<div class="col-md-10">
					<input class="col-md-10" type="number" id="gst" name="gst" value="0">
				</div>
			</div>

			<!-- Tax price -->
			<div class="row top-buffer">
				<label class="col-md-2 text-right">Tax Price ($)</label>
				<div class="col-md-10">
					<input class="col-md-10" type="number" id="taxPrice" name="taxPrice" value="0" disabled="true">
				</div>
			</div>

			<!-- Total price -->
			<div class="row top-buffer">
				<label class="col-md-2 text-right required">Total Price</label>
				<div class="col-md-10">
					<input class="col-md-10" type="number" id="totalPrice" name="totalPrice" value="0" disabled="true">
				</div>
			</div>

			<!-- Payment type -->
			<div class="row top-buffer">
				<label class="col-md-2 text-right required">Payment Type</label>
				<div class="col-md-10">
					<select class="col-md-10" id="paymentType" name="paymentType">
						<option value="">Choose a Type...</option>
						<?php
							foreach($paymentTypes as $row) {
								printf('<option value="%s">%s</option>',
									$row['id'],
									$row['description']);
							}
						?>
					</select>
				</div>
			</div>

			<!-- Comments -->
			<div class="row top-buffer">
				<label class="col-md-2 text-right">Comments</label>
				<div class="col-md-10">
					<textarea class="col-md-10" id="comments" name="comments"></textarea>
				</div>
			</div>

			<!-- Employee -->
			<div class="row top-buffer">
				<label class="col-md-2 text-right">Created/Sold By</label>
				<div class="col-md-10">
					<input type="hidden" id="employeeId" value="<?php echo $employee['id']?>">
					<input type="text" id="employee" class="col-md-10" name="employee" value="<?php echo $employee['firstname'] . ' ' . $employee['lastname'] ?>" disabled="true">
				</div>
			</div>

			<!-- Ship date -->
			<div class="row top-buffer">
				<label class="col-md-2 text-right">Ship Date</label>
				<div class="col-md-10">
					<input type="text" id="shipDate" name="shipDate" value="<?php echo date('Y-m-d') ?>" disabled="true">
				</div>
			</div>

			<!-- Required fields -->
			<div class="row top-buffer">
				<p class="col-md-2 text-right"><em>Required Fields *</em></p>
			</div>

			<!-- Submit button -->
			<div class="row top-buffer">
				<div class="col-md-2 text-right">
					<input type="button" id="submit" value="Submit">
				</div>
			</div>

		</form>
	</div>

</body>
</html>