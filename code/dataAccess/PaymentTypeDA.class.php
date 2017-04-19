<?php
/*
 * Created by: Baldwin Yu
 * Created for: Fresh Focus Media
 *
 * This is the DA class for payment types.
 *
 */

class PaymentTypeDA extends DA
{
	/* Function that retrieves all payment types sorted by description */
	public function getAll() {
		$sql = 'SELECT *
			FROM payment_type
			ORDER BY description ASC';

		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();

		$results = $stmt->fetchAll();
		return $results;
	}
}

?>