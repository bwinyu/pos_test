<?php
/*
 * Created by: Baldwin Yu
 * Created for: Fresh Focus Media
 *
 * This is the DA class for customers.
 *
 */

class CustomerDA extends DA
{
	/* Function to retrieve all customers sorted by firstname, lastname */
	public function getAll() {
		$sql = 'SELECT *
			FROM customer
			ORDER BY firstname, lastname';

		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();

		$results = $stmt->fetchAll();
		return $results;
	}
}

?>