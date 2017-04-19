<?php
/*
 * Created by: Baldwin Yu
 * Created for: Fresh Focus Media
 *
 * This is the DA class for categories.
 *
 */

class CategoryDA extends DA
{
	/* Function to retrieve all categories sorted by description */
	public function getAll() {
		$sql = 'SELECT *
			FROM category
			ORDER BY description ASC';

		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();

		$results = $stmt->fetchAll();
		return $results;
	}
}

?>