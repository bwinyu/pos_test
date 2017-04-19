<?php
/*
 * Created by: Baldwin Yu
 * Created for: Fresh Focus Media
 *
 * This is the includes page to fetch any data that needs to be initialized.
 *
 */

include('dataAccess/DA.class.php');
include('dataAccess/CustomerDA.class.php');
include('dataAccess/ProductPricingDA.class.php');
include('dataAccess/PaymentTypeDA.class.php');
include('dataAccess/EmployeeDA.class.php');

// Fetch customer data
$customerDA = new CustomerDA();
$customers = $customerDA->getAll();

// Fetch product pricing data
$productPricingDA = new ProductPricingDA();
$productPricing = $productPricingDA->getAll();

// Fetch payment type data
$paymentTypeDA = new PaymentTypeDA();
$paymentTypes = $paymentTypeDA->getAll();

// Fetch employee ID, hard-coded for testing purposes
$employeeDA = new EmployeeDA();
$employee = $employeeDA->getById('1');

?>