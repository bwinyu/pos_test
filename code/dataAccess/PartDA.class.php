<?php
/*
 * Created by: Baldwin Yu
 * Created for: Fresh Focus Media
 *
 * This is the DA class for parts.
 *
 */

class PartDA extends DA
{
	/* Function that retreieves all parts sorted by description */
	public function getAll() {
		$sql = 'SELECT *
			FROM part
			ORDER BY description ASC';

		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();

		$results = $stmt->fetchAll();
		return $results;
	}

	/* Function that retreieves all parts based on category id, sorted by description */
	public function getByCategoryId($categoryId) {
		$sql = 'SELECT *
			FROM part
			WHERE category_id = :category_id
			ORDER BY description ASC';

		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(['category_id' => $categoryId]);

		$results = $stmt->fetchAll();
		return $results;
	}
}

?>