<?php
/*
 * Created by: Baldwin Yu
 * Created for: Fresh Focus Media
 *
 * This is the DA class for product pricing types.
 *
 */

class ProductPricingDA extends DA
{
	/* Function that retrieves all product pricing types ordered by description */
	public function getAll() {
		$sql = 'SELECT *
			FROM product_pricing
			ORDER BY description ASC';

		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();

		$results = $stmt->fetchAll();
		return $results;
	}
}

?>