/*
 * Created by: Baldwin Yu
 * Created for: Fresh Focus Media
 *
 * This is the JS code-behind page for the web application. It handles all the
 * events for each input and requests data using AJAX.
 *
 */

$(document).ready (function() {

	/* Product Pricing on-change event fetches category data */
	$('#productPricing').on('change', function() {
		if ($('#productPricing').val()) {
			var data = {
				'action': 'category'
			};
			jsonRequest('category', data);
		} else {
			$('#category').prop('disabled', true);
		}

		resetPriceQuantity();
	});

	/* Category on-change event fetches parts data by category id */
	$('#category').on('change', function() {
		if ($('#category').val()) {
			var data = {
				'action': 'part',
				'categoryId': $('#category').val()
			};
			jsonRequest('part', data);
		} else {
			$('#part').prop('disabled', true);
		}

		resetPriceQuantity();
	});

	/* Parts on-change event fetches product data by category id, part id, and product pricing id */
	$('#part').on('change', function() {
		if ($('#part').val()) {
			var data = {
				'action': 'product',
				'categoryId': $('#category').val(),
				'partId': $('#part').val(),
				'productPricingId': $('#productPricing').val()
			};
			jsonRequest('product', data);
		} else {
			$('#product').prop('disabled', true);
		}

		resetPriceQuantity();
	});

	/* Product on-change event fetches the price of a product by inventory id */
	$('#product').on('change', function() {
		if ($('#product').val()) {
			var data = {
				'action': 'price',
				'inventoryId': $('#product').val()
			};
			jsonRequest('price', data);
		} else {
			$('#price').prop('value', 0);
		}
	});

	/* Product add button on-click event adds a row and updates order details */
	$('#addProduct').on('click', function() {
		if ($('#quantity').val() > 0) {
			updateSubtotal();
			updateOrderDetails();
			$('#addedProducts').append(productRow());
		} else {
			alert ('Quantity must be greater than 0.')
		}
	});

	/* Discount type on-checked event enables the discount value input and updates order details */
	$('input[name="discountType"]').on('change', function () {
		if ($('input[name=discountType]:checked').val()) {
			$('#discountValue').prop('disabled', false);
			updateOrderDetails();
		}
	});

	/* Discount value on-change event updates the order details */
	$('#discountValue').on('change', function() {
		updateOrderDetails();
	});

	/* GST on-change event updates the order details */
	$('#gst').on('change', function() {
		updateOrderDetails();
	});

	/* Submit on-click event checks if required data is there and submits order */
	$('#submit').on('click', function() {
		if (verifyRequiredFields()) {
			submitOrder();
		}
	});

});

/* Function that uses AJAX to request JSON based on parameters
	 action and data. The action parameter specifies which case to
	 use and the data parameter specifies the parameters to pass into
	 the AJAX request. */
function jsonRequest(action, data) {
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: 'request.php',
		data: data,
		success: function(data) {
			switch(action) {
				case 'category':
					$('#category')
						.html(categoryDropDown(data))
						.prop('disabled', false);
					break;

				case 'part':
					$('#part')
						.html(partDropDown(data))
						.prop('disabled', false);
					break;

				case 'product':
					$('#product')
						.html(productDropDown(data))
						.prop('disabled', false);
					break;

				case 'price':
					$('#price').prop('value', data['price']);
					$('#quantity').prop('disabled', false);
					break;

				case 'submit':
					alert ('Invoice created (Order #' + data['id'] + ').');
					break;
			}
		},
		error: function (xhr, ajaxOptions, thrownError) {
    	alert(xhr.status);
    	alert(thrownError);
    }
	});
}

/* Function that creates a dropdown for the categories */
function categoryDropDown(data) {
	var html = '<option value="">Choose Category...</option>';
	for (var i = 0; i < data.length; i++) {
		var row = data[i];
		html += '<option value="';
		html += row['id'];
		html += '">';
		html += row['description'];
		html += '</option>';
	}
	return html;
}

/* Function that creates a dropdown for the parts */
function partDropDown(data) {
	var html = '<option value="">Choose a Part #...</option>';
	for (var i = 0; i < data.length; i++) {
		var row = data[i];
		html += '<option value="';
		html += row['id'];
		html += '">';
		html += row['description'];
		html += '</option>';
	}
	return html;
}

/* Function that creates a dropdown for the products */
function productDropDown(data) {
	var html = '<option value="">Choose a Product...</option>';
	for (var i = 0; i < data.length; i++) {
		var row = data[i];
		html += '<option value="';
		html += row['id'];
		html += '">';
		html += row['product'];
		html += '</option>';
	}
	return html;
}

/* Function that creates a new row for an added product */
function productRow() {
	var html = '<div class="col-md-4 col-md-offset-2">' + $('#product option:selected').text() + '</div>';
	html += '<div class="col-md-6">$' + $('#price').val() + ' x ' + $('#quantity').val() + '</div>';
	return html;
}

/* Function that resets price and quantity back to 0 and disables the input */
function resetPriceQuantity() {
	$('#price').prop('value', 0);
	$('#quantity')
		.prop('disabled', true)
		.prop('value', 0);
}

/* Function that submits order and inserts into database */
function submitOrder() {
	var data = {
		'action': 'submit',
		'orderDate': $('#orderDate').val(),
		'customerId': $('#customers').val(),
		'subtotal': $('#subtotal').val(),
		'discountType': $('input[name=discountType]:checked').val(),
		'discountValue': $('#discountValue').val(),
		'tax': $('#taxPrice').val(),
		'total': $('#totalPrice').val(),
		'paymentTypeId': $('#paymentType').val(),
		'comments': $('#comments').val(),
		'employeeId': $('#employeeId').val(),
		'shipDate': $('#shipDate').val()
	}

	jsonRequest('submit', data);
}

/* Function that updates all the details of the order */
function updateOrderDetails() {
	// Discount totals
	if ($('input[name=discountType]:checked').val() == '1') {
		$discountTotal = parseFloat($('#subtotal').val()) * parseFloat($('#discountValue').val()) / 100;
	} else if ($('input[name=discountType]:checked').val() == '2') {
		$discountTotal = parseFloat($('#discountValue').val());
	} else {
		$discountTotal = 0;
	}
	$('#totalAfterDiscount').val(parseFloat($('#subtotal').val()) - $discountTotal);

	// Total before tax
	$('#totalBeforeTax').val(parseFloat($('#totalAfterDiscount').val()));

	// Tax price
	$('#taxPrice').val(parseFloat($('#totalBeforeTax').val()) * parseFloat($('#gst').val()) / 100);

	// Total price
	$('#totalPrice').val(parseFloat($('#totalBeforeTax').val()) + parseFloat($('#taxPrice').val()))

	// Set values to 2 decimal places
	$('#totalAfterDiscount').val(parseFloat($('#totalAfterDiscount').val()).toFixed(2));
	$('#totalBeforeTax').val(parseFloat($('#totalBeforeTax').val()).toFixed(2));
	$('#taxPrice').val(parseFloat($('#taxPrice').val()).toFixed(2));
	$('#totalPrice').val(parseFloat($('#totalPrice').val()).toFixed(2));
}

/* Function that updates the subtotal after a product is added */
function updateSubtotal() {
	$productTotal = parseFloat($('#price').val()) * parseFloat($('#quantity').val());
	$('#subtotal').val(parseFloat($('#subtotal').val()) + $productTotal);

	// Set values to 2 decimal places
	$('#subtotal').val(parseFloat($('#subtotal').val()).toFixed(2));
}

function verifyRequiredFields() {
	var $alertText = '';

	// Check customer
	if (!$('#customers').val()) {
		$alertText += 'Please choose a customer.' + "\n";
	}

	// Check subtotal
	if ($('#subtotal').val() == 0) {
		$alertText += 'Must have at least one product.' + "\n";
	}

	// Check total price
	if ($('#total').val() < 0) {
		$alertText += 'Total must be greater than zero.' + "\n";
	}

	// Check payment type
	if (!$('#paymentType').val()) {
		$alertText += 'Please choose payment type.' + "\n";
	}

	// If alert text is not empty, return false and alert
	if ($alertText == '') {
		return true;
	} else {
		alert ($alertText);
		return false;
	}
}