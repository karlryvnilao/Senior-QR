<?php
include '../server/server.php';

if (isset($_GET['purok_id'])) {
    $purok_id = $_GET['purok_id'];

    $query = "SELECT 
                CONCAT(firstname, ' ', middlename, ' ', lastname) AS full_name,
                age,
                gender,
                address 
              FROM tblresident 
              WHERE purok = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $purok_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $output = '';
    if ($result->num_rows > 0) {
        $no = 1;
        while ($row = $result->fetch_assoc()) {
            $output .= '<tr>
                            <td>' . $no . '</td>
                            <td>' . htmlspecialchars($row['full_name'], ENT_QUOTES, 'UTF-8') . '</td>
                            <td>' . htmlspecialchars($row['age'], ENT_QUOTES, 'UTF-8') . '</td>
                            <td>' . htmlspecialchars($row['gender'], ENT_QUOTES, 'UTF-8') . '</td>
                            <td>' . htmlspecialchars($row['address'], ENT_QUOTES, 'UTF-8') . '</td>
                        </tr>';
            $no++;
        }
    } else {
        $output .= '<tr>
                        <td colspan="5" class="text-center">No residents found in this Baranggay.</td>
                    </tr>';
    }

    echo $output;
}
?>
