<?php
include("connection.php"); // Include database connection file

if (isset($_POST['submitRegistration'])) {
    $registrationType = $_POST['registrationType'];
    $fullName = $_POST['fullName'];
    $dateOfEvent = $_POST['dateOfEvent'];
    $placeOfEvent = $_POST['placeOfEvent'];
    $fatherName = $_POST['fatherName'];
    $motherName = $_POST['motherName'];
    $gender = $_POST['gender'];
    $nationality = $_POST['nationality'];
    $address = $_POST['address'];
    $contactNumber = $_POST['contactNumber'];
    $registrationStatus = "Pending";
    
    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO civil_registrations (civil_registration_type, civil_registration_full_name, civil_registration_date_of_event, civil_registration_place_of_event, civil_registration_father_name, civil_registration_mother_name, civil_registration_gender, civil_registration_nationality, civil_registration_address, civil_registration_contact_number, civil_registration_status)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssss", $registrationType, $fullName, $dateOfEvent, $placeOfEvent, $fatherName, $motherName, $gender, $nationality, $address, $contactNumber, $registrationStatus);

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        header("location: civil_registration.php?success=Registration submitted successfully. We will process your registration and contact you soon.");
    } else {
        header("location: civil_registration.php?error=Failed to submit registration. Please try again or contact support.");
    }
}