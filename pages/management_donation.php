<?php
include "../menu.php";

// ดึงข้อมูล user ออกมาใช้
$user = $_SESSION['user'];
?>

<?php  ?>

<body style="background-color: #ffffffff;">
    <div class="d-flex">

        <!-- Main Content -->
        <main class="p-4 flex-grow-1" style="margin-left: 250px; padding: 20px;">

            <h2 class="" style="margin-bottom:3%;">Give Donation Table</h2>

            <div class="modal fade modal-lg" id="modal_add" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">ADD Donation</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="form_add">
                                <div class="row mb-4">

                                    <div class="col">

                                        <div style="width: 250; height:200px;">
                                            <img id="previewImage" src="" alt="Preview" style="width: 250px; height:200px; display: none; border: 1px solid #e7e7e7ff; padding: 5px;">

                                        </div>

                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="title" class="form-label">Title</label>
                                            <input type="text" class="form-control" id="title" placeholder="ชื่อสิ่งของ เช่น “หนังสือฟิสิกส์”, “ชุดนักศึกษา”">
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <input class="form-control" type="file" id="fileimage" accept=".png,.jpg,.jpeg">
                                            <label for="fileimage" class="form-label text-danger">please choose only .png .jpg</label>

                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <input type="datetime-local" id="available_until" name="available_until" class="form-control">
                                            <label for="available_until" class="form-label text-danger">สิ้นสุดวันที่ บริจาค</label>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <select class="form-select" id="category_id">
                                            <option selected disabled>Category menu</option>
                                            <?php

                                            include "../sql.php";

                                            $sql = "SELECT * FROM categories";
                                            $result = $conn->query($sql);

                                            if ($result->num_rows > 0) {

                                                while ($row = $result->fetch_assoc()) {
                                                    echo "<option value=" . $row['category_id'] . ">" . $row['category_name'] . "</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>



                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3 ">
                                            <label for="location" class="form-label">Location</label>
                                            <input type="text" class="form-control " id="location" placeholder="ฉะเชิงเทรา 24120 อ.พนมสารคาม 111/11 หมู่100">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label for="description" class="form-label">Description</label>
                                            <input type="text" class="form-control" id="description" placeholder="รายละเอียดของสิ่งของ เช่น สภาพการใช้งาน, ขนาด">
                                        </div>
                                    </div>

                                </div>



                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="click_insert();">Add</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <button type="button" class="btn btn-primary m-2" data-bs-toggle="modal" data-bs-target="#modal_add">
                        Add Donation
                    </button>
                </div>

                <div class="col">
                    <nav class="navbar bg-body-tertiary">
                        <div class="container-fluid justify-content-end">
                            <form class="d-flex" role="search">
                                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" />
                                <button class="btn btn-outline-success" type="submit">Search</button>
                            </form>
                        </div>
                    </nav>
                </div>
            </div>
            <!-- table magement donation-->
            <div class="" style="overflow-y: auto; height:80vh; ">
                <div id="tableContainer"></div>
            </div>



        </main>
    </div>
</body>

</html>

<script>
    function click_insert() {


        const form = document.getElementById("form_add");
        const title = document.getElementById('title').value;
        const available_until = document.getElementById('available_until').value;
        const category_id = document.getElementById('category_id').value;
        const location = document.getElementById('location').value;
        const description = document.getElementById('description').value;
        const user_id = <?php echo $user['user_id']; ?>


        //upload image
        const formFile = document.getElementById('fileimage');
        const file = formFile.files[0];
        const newFileName = "file_image_" + <?php echo $user['user_id'] ?> + "_" + Date.now() + ".png";
        const newFile = new File([file], newFileName, {
            type: file.type
        });

        const formData = new FormData();
        formData.append("file_img", newFile);

        fetch("../actions/upload_image.php", {
                method: "POST",
                body: formData
            })
            .then(res => res.text())
            .then(data => {
                    form.reset();
                    formFile.value = "";
                    document.getElementById("previewImage").src = "";
                }

            )
            .catch(err => console.error(err));


        console.log(JSON.stringify({
            title: title,
            available_until: available_until,
            category_id: category_id,
            location: location,
            picture_url: newFileName,
            description: description,
            user_id: user_id
        }));


        fetch("../actions/add_donation.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    title: title,
                    available_until: available_until,
                    category_id: category_id,
                    location: location,
                    picture_url: newFileName,
                    description: description,
                    user_id: user_id
                })
            })
            .then(res => res.text())
            .then(data => {
                loadTable();
            })
            .then(err => console.error(err));
    }



    const formFile = document.getElementById('fileimage');
    const previewImage = document.getElementById('previewImage');


    formFile.addEventListener('change', function() {
        const file = this.files[0];

        if (file) {
            // ตรวจสอบชนิดไฟล์
            const allowedTypes = ['image/png', 'image/jpeg'];
            if (!allowedTypes.includes(file.type)) {
                alert('Please select only .png or .jpg files');
                this.value = ''; // ล้าง input
                previewImage.style.display = 'none';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewImage.style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {

            previewImage.style.display = 'none';
        }
    });




    //fuction Edit button

    function func_edit(id) {
        
        console.log("Edit ID:", id);
       
    }

    // Reload table
    function loadTable() {
        fetch('../actions/table_donation.php')
            .then(res => res.text())
            .then(html => {
                document.getElementById('tableContainer').innerHTML = html;
            });
    }
    loadTable();
</script>