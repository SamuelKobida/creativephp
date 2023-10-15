<?php

include_once 'config.php';

class CSVImporter
{
    public function prepareData($csvFilePath)
    {
        $csvFile = fopen($csvFilePath, 'r');

        $headers = fgetcsv($csvFile, 10000, ";");

        $data = [];

        while (($getData = fgetcsv($csvFile, 10000, ";")) !== false) {
            $rowData = [];

            $columnMappings = array_flip($headers);

            if (isset($columnMappings["sku"])) {
                $rowData['sku'] = $getData[$columnMappings["sku"]];
            }
            if (isset($columnMappings["ean"])) {
                $rowData['ean'] = $getData[$columnMappings["ean"]];
            }
            if (isset($columnMappings["name"])) {
                $rowData['name'] = $getData[$columnMappings["name"]];
            }
            if (isset($columnMappings["shortDesc"])) {
                $rowData['shortDesc'] = $getData[$columnMappings["shortDesc"]];
            }
            if (isset($columnMappings["manufacturer"])) {
                $rowData['manufacturer'] = $getData[$columnMappings["manufacturer"]];
            }
            if (isset($columnMappings["price"])) {
                $rowData['price'] = $getData[$columnMappings["price"]];
            }
            if (isset($columnMappings["stock"])) {
                $rowData['stock'] = $getData[$columnMappings["stock"]];
            }

            $data[] = $rowData;
        }

        fclose($csvFile);

        return $data;
    }

    public function importData($data, $con)
    {
        foreach ($data as $rowData) {

            $query = "SELECT id FROM products WHERE sku = '" . $rowData['sku'] . "'";
            $check = mysqli_query($con, $query);

            if ($check->num_rows > 0) {
                mysqli_query($con, "UPDATE products SET stock = '" . $rowData['stock'] . "' WHERE sku = '" . $rowData['sku'] . "'");
            } else {
                mysqli_query($con, "INSERT INTO products (sku, ean, name, shortDesc, manufacturer, price, stock) VALUES ('" . $rowData['sku'] . "', '" . $rowData['ean'] . "', '" . $rowData['name'] . "','" . $rowData['shortDesc'] . "','" . $rowData['manufacturer'] . "','" . $rowData['price'] . "','" . $stock = $rowData['stock'] . "')");
            }
        }
    }
}


if (isset($_POST['submit'])) {
    if (isset($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name'])) {
        $csvImporter = new CSVImporter();
        $csvFilePath = $_FILES['file']['tmp_name'];

        try {
            $data = $csvImporter->prepareData($csvFilePath);
            $csvImporter->importData($data, $con);
            $message = "Data imported successfully.";
        } catch (Exception $e) {
            $message = "Error: " . $e->getMessage();
        }
    } else {
        $message = "No file uploaded";
    }

    // Append the message as a query parameter to the URL
    header("Location: index.php?message=" . urlencode($message));
}


