<?php
include "../sql.php";
session_start();
if (isset($_SESSION['user'])) {
    header("location: ../");
    exit;
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: "Kanit", sans-serif;
            font-weight: 300;
            font-style: normal;
        }
    </style>
    <style>
        .cursor-pointer {
            cursor: pointer;

        }


        .cursor-custom {
            cursor: url('assets/cursors/my-pointer.cur'), auto;

        }

        .hover-pointer:hover {
            cursor: pointer;
        }
    </style>

</head>

<body>
    <section class="vh-100" style="background-color: #171927ff;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-xl-10">
                    <div class="card" style="border-radius: 1rem;">
                        <div class="row g-0">
                            <div class="col-md-6 col-lg-5 d-none d-md-block">
                                <img src="../assets/images/login_.png"
                                    alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem; height: 100%;" />
                            </div>
                            <div class="col-md-6 col-lg-7 d-flex align-items-center">
                                <div class="card-body p-4 p-lg-5 text-black">

                                    <form>

                                        <div class="d-flex align-items-center mb-3 pb-1">
                                            <!-- icon logo -->
                                            <span class="h1 fw-bold mb-0">Login</span>
                                        </div>

                                        <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Sign into your account</h5>

                                        <div data-mdb-input-init class="form-outline mb-4">
                                            <input type="username" id="student_id" class="form-control form-control-lg" />
                                            <label class="form-label" for="student_id">Student ID</label>
                                        </div>

                                        <div data-mdb-input-init class="form-outline mb-4">
                                            <input type="password" id="password" class="form-control form-control-lg" />
                                            <label class="form-label" for="password">Password</label>
                                        </div>

                                        <div class="pt-1 mb-4">
                                            <button class="btn btn-primary btn-lg" type="button" onclick="login()">Login</button>
                                        </div>

                                        <div class="small text-muted " href="#!">Don't have an account? <a class="fw-medium cursor-pointer" href="register.php">Register</a>
                                        </div>

                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


</body>

</html>


<script>
    function login() {
        const std_id = document.getElementById("student_id").value;
        const password = document.getElementById("password").value;

        const data = {
            "std_id": std_id,
            "password": password
        }
        fetch("../actions/login.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(data)
            })
            .then(res => res.json())
            .then(data => {
                console.log(data);
                if (data.status === "success") {
                    window.location.href = "../index.php";
                } else {

                }
                console.log(data.status);
            })
            .then(err => console.error(err));
    }
</script>