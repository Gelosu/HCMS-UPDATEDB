<?php
include '../connect.php';  // Database connection

header('Content-Type: application/json');  // Set response to JSON format

$response = array();  // Initialize the response array

// Check if the form was submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Print POST data for debugging
    error_log(print_r($_POST, true));

    // Get the POST data
    $medicationId = $_POST['editMedicationId'] ?? '';  // The medication ID
    $medicationPatientName = $_POST['editMedicationPatientName'] ?? '';  // The patient's name
    $medicines = $_POST['editMedicines'] ?? [];  // Array of medicine IDs from POST
    $amounts = $_POST['editAmount'] ?? [];  // Array of corresponding amounts
    $originalAmounts = $_POST['originalAmount'] ?? [];  // Array of original amounts
    $supplies = $_POST['editSupplies'] ?? [];  // Array of supply IDs from POST
    $supplyAmounts = $_POST['editSupplyAmount'] ?? [];  // Array of corresponding supply amounts
    $originalSupplyAmounts = $_POST['originalSupplyAmount'] ?? [];  // Original supply amounts
    $medicationHealthWorker = $_POST['editMedicationHealthWorker'] ?? ''; // Removed datetime

    // Validate the medication ID
    if (empty($medicationId)) {
        $response['success'] = false;
        $response['error'] = 'Medication ID is missing.';
        echo json_encode($response);
        exit();
    }

    // Initialize an array to store the medicines and supplies details
    $medicationDetails = [];
    $supplyDetails = [];

    // Fetch original medication amounts from `p_medication` table
    $originalMedicationsSql = "SELECT p_medication FROM p_medication WHERE id = ?";
    if ($stmt = $conn->prepare($originalMedicationsSql)) {
        $stmt->bind_param("s", $medicationId);
        $stmt->execute();
        $stmt->bind_result($originalMedicationsJson);
        $stmt->fetch();
        $stmt->close();

        $originalMedications = json_decode($originalMedicationsJson, true);
        $originalAmountsMap = [];
        foreach ($originalMedications as $item) {
            $originalAmountsMap[$item['name']] = $item['amount'];
        }
    } else {
        $response['success'] = false;
        $response['error'] = 'Error fetching original medication data: ' . $conn->error;
        echo json_encode($response);
        exit();
    }

    // Process each medicine entry
    foreach ($medicines as $index => $med_id) {
        // Prepare SQL to fetch medicine name
        $medSql = "SELECT meds_name FROM inv_meds WHERE med_id = ?";
        if ($medStmt = $conn->prepare($medSql)) {
            $medStmt->bind_param("s", $med_id);  // Bind the medicine ID
            $medStmt->execute();
            $medStmt->bind_result($meds_name);
            $medStmt->fetch();
            $medStmt->close();

            // Get the corresponding amount from POST (or default to 0 if not found)
            $amount = isset($amounts[$index]) ? (int)$amounts[$index] : 0;
            $originalAmount = isset($originalAmountsMap[$meds_name]) ? (int)$originalAmountsMap[$meds_name] : 0;

            // Store medicine name and amount in the medication details array
            $medicationDetails[] = [
                'name' => $meds_name,  // Store the fetched medicine name
                'amount' => $amount    // Store the corresponding amount
            ];

            // Determine if the medicine is existing or new
            if ($meds_name) {
                // Existing medicine
                if ($amount > $originalAmount) {
                    // New amount is greater, decrease stock_avail and increase stock_out
                    $stockChange = $amount - $originalAmount;
                    $updateSql = "
                        UPDATE inv_meds 
                        SET 
                            stock_avail = stock_avail - ?, 
                            stock_out = stock_out + ?
                        WHERE med_id = ?
                    ";
                } else {
                    // New amount is less or equal, increase stock_avail and decrease stock_out
                    $stockChange = $originalAmount - $amount;
                    $updateSql = "
                        UPDATE inv_meds 
                        SET 
                            stock_avail = stock_avail + ?, 
                            stock_out = stock_out - ?
                        WHERE med_id = ?
                    ";
                }

                // Prepare and execute the update statement
                if ($updateStmt = $conn->prepare($updateSql)) {
                    $updateStmt->bind_param("iis", $stockChange, $stockChange, $med_id);
                    $updateStmt->execute();
                    $updateStmt->close();
                } else {
                    $response['success'] = false;
                    $response['error'] = 'Error preparing update query for inv_meds: ' . $conn->error;
                    echo json_encode($response);
                    exit();
                }
            } 
        } else {
            // Handle SQL preparation error
            $response['success'] = false;
            $response['error'] = 'Error preparing medication name query: ' . $conn->error;
            echo json_encode($response);
            exit();
        }
    }

    // Process each supply entry (similar logic to medicine)
    foreach ($supplies as $index => $sup_id) {
        // Prepare SQL to fetch supply name
        $supSql = "SELECT prod_name FROM inv_medsup WHERE med_supId = ?";
        if ($supStmt = $conn->prepare($supSql)) {
            $supStmt->bind_param("s", $sup_id);  // Bind the supply ID
            $supStmt->execute();
            $supStmt->bind_result($supply_name);
            $supStmt->fetch();
            $supStmt->close();

            // Get the corresponding amount from POST (or default to 0 if not found)
            $amount = isset($supplyAmounts[$index]) ? (int)$supplyAmounts[$index] : 0;
            $originalAmount = isset($originalSupplyAmounts[$supply_name]) ? (int)$originalSupplyAmounts[$supply_name] : 0;

            // Store supply name and amount in the supply details array
            $supplyDetails[] = [
                'name' => $supply_name,  // Store the fetched supply name
                'amount' => $amount      // Store the corresponding amount
            ];

            // Determine if the supply is existing or new
            if ($supply_name) {
                // Existing supply
                if ($amount > $originalAmount) {
                    // New amount is greater, decrease stock_avail and increase stock_out
                    $stockChange = $amount - $originalAmount;
                    $updateSql = "
                        UPDATE inv_medsup
                        SET 
                            stck_avl = stck_avl + ?, 
                            stck_out = stck_out - ?
                        WHERE med_supId = ?
                    ";
                } else {
                    // New amount is less or equal, increase stock_avail and decrease stock_out
                    $stockChange = $originalAmount - $amount;
                    $updateSql = "
                         UPDATE inv_medsup
                        SET 
                            stck_avl = stck_avl + ?, 
                            stck_out = stck_out - ?
                        WHERE med_supId = ?
                    ";
                }

                // Prepare and execute the update statement
                if ($updateStmt = $conn->prepare($updateSql)) {
                    $updateStmt->bind_param("iis", $stockChange, $stockChange, $sup_id);
                    $updateStmt->execute();
                    $updateStmt->close();
                } else {
                    $response['success'] = false;
                    $response['error'] = 'Error preparing update query for inv_supplies: ' . $conn->error;
                    echo json_encode($response);
                    exit();
                }
            } 
        } else {
            // Handle SQL preparation error
            $response['success'] = false;
            $response['error'] = 'Error preparing supply name query: ' . $conn->error;
            echo json_encode($response);
            exit();
        }
    }

    // Convert the medication and supply details arrays to JSON strings for storage
    $medicationJson = json_encode($medicationDetails);
    $supplyJson = json_encode($supplyDetails);

    // Prepare the SQL query to update the existing medication and supply record
    $sql = "UPDATE p_medication 
            SET p_medpatient = ?, p_medication = ?, datetime = ?, a_healthworker = ? 
            WHERE id = ?";

    // Prepare and execute the statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind the parameters (add supplyJson as well)
        $stmt->bind_param("sssss", $medicationPatientName, $medicationJson, $supplyJson, $medicationHealthWorker, $medicationId);

        // Execute the statement and check if it was successful
        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = 'Patient medication and supplies updated successfully.';

            // Fetch updated data to return
            $fetchSql = "
                 SELECT 
                    id, 
                    p_medpatient AS patient_name, 
                    p_medication, 
                    datetime AS date_time, 
                    a_healthworker AS healthworker
                FROM p_medication
            ";
            $result = $conn->query($fetchSql);
            $medications = [];
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Decode JSON data for p_medication and p_supply
                    $row['p_medication'] = json_decode($row['p_medication'], true);
                    $row['p_supply'] = json_decode($row['p_supply'], true);
                    $medications[] = $row;
                }
            }
            $response['data'] = $medications;  // Include medications in the response
        } else {
            $response['success'] = false;
            $response['error'] = 'Error updating medication and supplies: ' . $stmt->error;
        }

        $stmt->close();
    } else {
        $response['success'] = false;
        $response['error'] = 'Error preparing the statement: ' . $conn->error;
    }
} else {
    $response['success'] = false;
    $response['error'] = 'Invalid request method.';
}

$conn->close();

// Return the response in JSON format
echo json_encode($response);
?>
