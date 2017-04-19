<?php
/*
 * Created by: Baldwin Yu
 * Created for: Fresh Focus Media
 *
 * This is the DA class for inventory.
 *
 */

class InventoryDA extends DA
{
	/* Retrieves all inventory data sorted by product name */
	public function getAll() {
		$sql = 'SELECT *
			FROM inventory
			ORDER BY product ASC';

		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();

		$results = $stmt->fetchAll();
		return $results;
	}

	/* Retrieve all products based on category id, part id, and product pricing id
		 sorted by product name */
	public function getProducts($categoryId, $partId, $productPricingId) {
		$sql = 'SELECT *
			FROM inventory
			WHERE category_id = :category_id
				AND part_id = :part_id
				AND product_pricing_id = :product_pricing_id
			ORDER BY product ASC';

		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(['category_id' => $categoryId,
			'part_id' => $partId,
			'product_pricing_id' => $productPricingId]);

		$results = $stmt->fetchAll();
		return $results;
	}

	/* Retrieves all product data based on inventory id */
	public function getPrice($inventoryId) {
		$sql = 'SELECT *
			FROM inventory
			WHERE id = :id';

		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(['id' => $inventoryId]);

		$results = $stmt->fetch();
		return $results;
	}

}

?>