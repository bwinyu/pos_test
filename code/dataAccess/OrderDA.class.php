<?php
/*
 * Created by: Baldwin Yu
 * Created for: Fresh Focus Media
 *
 * This is the DA class for orders. A submitted 
 *
 */

class OrderDA extends DA
{
	/* Function that retrieves all orders */
	public function getAll() {
		$sql = 'SELECT *
			FROM `order`';

		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();

		$results = $stmt->fetchAll();
		return $results;
	}

	/* Function that retrieves a single order by id */
	public function getById($id) {
		$sql = 'SELECT *
			FROM `order`
			WHERE id = :id';

		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(['id' => $id]);

		$results = $stmt->fetch();
		return $results;
	}

	/* Function that inserts an order based on the input entered into the
		 point of sale web application */
	public function insertOrder($details) {
		$sql = 'INSERT INTO `order` (order_date,
				customer_id,
				subtotal,
				discount_type,
				discount_value,
				tax,
				total,
				payment_type_id,
				comments,
				employee_id,
				ship_date)
			VALUES (:order_date,
				:customer_id, :subtotal,
				:discount_type, :discount_value,
				:tax,
				:total,
				:payment_type_id,
				:comments,
				:employee_id,
				:ship_date)';
		
		$stmt = $this->pdo->prepare($sql);

		// Bind parameters
		$stmt->bindParam(':order_date', $details['orderDate']);
		$stmt->bindParam(':customer_id', $details['customerId']);
		$stmt->bindParam(':subtotal', $details['subtotal']);
		$stmt->bindParam(':discount_type', $details['discountType']);
		$stmt->bindParam(':discount_value', $details['discountValue']);
		$stmt->bindParam(':tax', $details['tax']);
		$stmt->bindParam(':total', $details['total']);
		$stmt->bindParam(':payment_type_id', $details['paymentTypeId']);
		$stmt->bindParam(':comments', $details['comments']);
		$stmt->bindParam(':employee_id', $details['employeeId']);
		$stmt->bindParam(':ship_date', $details['shipDate']);

		$stmt->execute();

		return $this->pdo->lastInsertId();
	}
}

?>