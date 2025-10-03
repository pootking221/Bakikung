<?php
session_start();
// ถ้าไม่มี session ให้ redirect ไป login
if (!isset($_SESSION['user'])) {
    header("Location: \dashboard/miniProject/users/login.php");
    exit;
}
?>


<table class="table table-striped table-bordered  table-hover ">
    <thead>
        <tr>
            <th class="bg-dark text-light" style=" width: 2rem;">Image</th>
            <th class="bg-dark text-light" style=" width: 8rem;">Title</th>
            <th class="bg-dark text-light"" style=" width: 8rem;">Category</th>
            <th class=" bg-dark text-light text-center" style=" width: 3rem;">Status</th>
            <th class="bg-dark text-light text-center"" style=" width: 2rem;">Action</th>



        </tr>
    </thead>
    <tbody>

        <?php
        include "../sql.php";
        $sql = "SELECT * FROM donations";
        $result = $conn->query($sql);




        if ($result->num_rows > 0) {



            while ($row = $result->fetch_assoc()) {

                // เอาเเค่ status 10001 // enabled
                if ($row['status_item'] == 10001) {
                    $sql_status = "SELECT status_name FROM status_request WHERE status_id = {$row['status_item']}";
                    $result_status = $conn->query($sql_status);
                    $row_status = $result_status->fetch_assoc();

                    $sql_category = "SELECT category_name FROM categories WHERE category_id = {$row['category_id']}";
                    $result_category = $conn->query($sql_category);
                    $row_category = $result_category->fetch_assoc();

                    $color_status = "#DBDBDB";
                    $text_color = "";
                    switch ($row['status_item']) {
                        case 10001:
                            $color_status = "#063263";
                            $text_color = "text-light";
                            break;
                    }

                    echo "<tr>
                <td > <img class='rounded mx-auto d-block' src='../datausers/images_donation/" . $row['picture_url'] . "' style='width: 100px; height: 50px;'> </td>
                <td>" . $row['title'] . "</td>
                <td>" . $row_category['category_name'] . "</td>
                <td class='text-center  " . $text_color . " align-middle'> <span class='rounded text-center p-1' style=' background-color:" . $color_status . ";'>" . $row_status['status_name'] . "</span></td>
                <td>" .
                        "<div class='col text-center'>
                        <button type='button' class='btn btn-link' onclick='func_edit(" . $row['donate_id'] . ");'>edit</button>
                    </div>      
                </td>   
            </tr>";
                }
            }
        } else {
            echo "<tr><td colspan='3'>No data found</td></tr>";
        }

        
        ?>

    </tbody>
</table>