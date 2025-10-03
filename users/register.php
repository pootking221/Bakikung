<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: "Kanit", sans-serif;
            font-weight: 300;
            font-style: normal;
        }
    </style>
</head>

<body style="background-color: #1d1f2eff;">




    <section class="">

        <div class="px-4 py-5 px-md-5 text-center text-lg-start" style="background-color: #1e2027ff">
            <div class="container">
                <div class="row gx-lg-5 align-items-center">
                    <div class="col-lg-6 mb-5 mb-lg-0">
                        <h1 class="my-5 display-3 fw-bold text-light">
                            <spqn class="text-warning">Register</spqn> Web <br />
                            <span class="text-primary">Step <span class="text-light">By</spqn> Step Phee.</span>
                        </h1>

                    </div>

                    <div class="col-lg-6 mb-5 mb-lg-0">
                        <div class="card">
                            <div class="card-body py-5 px-md-5">
                                <form>
                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <div data-mdb-input-init class="form-outline">
                                                <input type="text" id="firstname" class="form-control" />
                                                <label class="form-label" for="firstname">First name</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <div data-mdb-input-init class="form-outline">
                                                <input type="text" id="lastname" class="form-control" />
                                                <label class="form-label" for="lastname">Last name</label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Email input -->
                                    <div data-mdb-input-init class="form-outline mb-4">
                                        <input type="email" id="email" class="form-control" />
                                        <label class="form-label" for="email">Email address</label>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <!-- student id input -->
                                            <div data-mdb-input-init class="form-outline mb-4">
                                                <input type="text" id="student_id" class="form-control" />
                                                <label class="form-label" for="student">Student ID</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <!-- tel id input -->
                                            <div data-mdb-input-init class="form-outline mb-4">
                                                <input type="text" id="tel" class="form-control" />
                                                <label class="form-label" for="tel">Phone number</label>
                                            </div>
                                        </div>

                                    </div>

                                    <!-- Password input -->
                                    <div data-mdb-input-init class="form-outline mb-4">
                                        <input type="password" id="password" class="form-control" />
                                        <label class="form-label" for="password">Password</label>
                                    </div>

                                    <!-- Password input -->
                                    <div data-mdb-input-init class="form-outline mb-4">
                                        <input type="password" id="password_confirm" class="form-control" />
                                        <label class="form-label" for="password_confirm">Password Confirm</label>
                                    </div>




                                    <!-- Submit button -->
                                    <button type="button" onclick="click_insert()" class="btn btn-primary btn-block mb-4">
                                        Sign up
                                    </button>


                                    <div class="small text-muted " href="#!">Go back to <a class="fw-medium cursor-pointer" href="login.php">Login</a>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Jumbotron -->
    </section>
    <!-- Section: Design Block -->
</body>

</html>

<script>
    function click_insert() {
        const std_id = document.getElementById("student_id").value;
        const fname = document.getElementById("firstname").value;
        const lname = document.getElementById("lastname").value;
        const email = document.getElementById("email").value;
        const tel = document.getElementById("tel").value;
        const pass = document.getElementById("password").value;
        const pass_confirm = document.getElementById("password_confirm").value;

        console.log(JSON.stringify({
            student_id: std_id,
            firstname: fname,
            lastname: lname,
            email: email,
            password: pass,
            tel: tel
        }))

        // if(pass == pass_confirm){

        fetch("../actions/insert_signup.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    student_id: std_id,
                    firstname: fname,
                    lastname: lname,
                    email: email,
                    password: pass,
                    tel: tel
                })
            })
            .then(res => res.json())
            .then(data =>{
                console.log(data);
                if(data.status === '1'){
                    window.location.href= 'login.php';
                }else{
                    
                }
            })
            .catch(error =>{
                console.error(error);
            })
       
        // }else{
        //     document.getElementById("status").innerHTML = "please enter password again";
        // }

    }
</script>