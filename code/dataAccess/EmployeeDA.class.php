<?php
/*
 * Created by: Baldwin Yu
 * Created for: Fresh Focus Media
 *
 * This is the DA class for employees.
 */

class EmployeeDA extends DA
{
	/* Retrieves all employees sorted by firstname, lastname */
	public function getAll() {
		$sql = 'SELECT *
			FROM employee
			ORDER BY firstname, lastname ASC';

		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();

		$results = $stmt->fetchAll();
		return $results;
	}

	/* Retrieve employee data based on id */
	public function getById($id) {
		$sql = 'SELECT *
			FROM employee
			WHERE id = :id';

		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(['id' => $id]);

		$results = $stmt->fetch();
		return $results;
	}
}

?>