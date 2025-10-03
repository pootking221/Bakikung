<?php
include "../menu.php";



?>

<body>
    <div class="d-flex">

        <!-- Main Content -->
        <main class="p-4 flex-grow-1" style="margin-left: 250px; padding: 20px; overflow-y: auto;">

            <h1>donation List</h1>


            <nav class="navbar bg-body-tertiary">
                <div class="container-fluid">
                    <form class="d-flex" role="search">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" />
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                </div>
            </nav>



            <div class="bg-dark w-100 rounded-2 p-4" style="height: 83vh; overflow-y: auto;">
                <!-- card -->
                <div id="cards_data" class="row">


                </div>
            </div>

            <div id="detail_card">
                <!-- Modal -->
                <div class="modal fade" id="detail_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog" id="body_detail"></div>
                </div>
            </div>


        </main>
    </div>




</body>

</html>

<script>
    const dataselect = {
        command: "select",
        id: "",
        title: "",
        description: "",
        location: "",
        category_id: "",
        available_until: ""

    }

    function datacard() {
        fetch('../api/Donations.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(dataselect)
            })
            .then(res => res.json())
            .then(data => {

                if (data.status === "1") {

                    const container = document.getElementById('cards_data');
                    container.innerHTML = "";


                    data.data.forEach(item => {

                        if (item.status_name === "enabled") {





                            container.innerHTML += `
                                
                                <div id="cards_data" class="card m-2 col-2" style="width: 18rem; ">
                                <div class="text-center">
                                        <img src="../datausers/images_donation/${item.picture_url}" class="card-img-top" style="width:100%; height:150px;" alt=""> 
                                    </div>
                                        <div class="card-body">
                                            <h5 class="card-title">${item.title}</h5>
                                            <h6 class="card-title"> ${item.category_name}</h6>
                                     
                                            <p class="card-text">${item.description}</p>
                                            
                                        </div>
                                        <button type="button" class="btn btn-primary mb-2"
                                            data-bs-toggle="modal" data-bs-target="#detail_modal"
                                            onclick='detail({
                                                user_id: "${item.user_id}",
                                                name: "${item.firstname} ${item.lastname}",
                                                tel: "${item.tel}",
                                                description: "${item.description}",
                                                category: "${item.category_name}",
                                                title: "${item.title}",
                                                donate_id:"${item.donate_id}",
                                                picture_name: "${item.picture_url}",
                                                location:"${item.location}"
                                            })'>
                                            Request
                                        </button>

                       `;
                        }






                    });
                }




            })
            .catch(error => {
                console.error(error);
            })
    }
    datacard();


    function detail(data = {}) {

        const body_detail = document.getElementById('body_detail');
        body_detail.innerHTML = "";

        body_detail.innerHTML = `

                         
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel"> Request </h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body" >
                                <div class='col'>
                                 
                                  

                                <div class='row'>
                                    <div class='col-6'>
                                        <img src="../datausers/images_donation/${data.picture_name}" class="card-img-top" style="width:100%; height:150px;" alt="">
                                    </div>
                                   
                                    <div class='col'>
                                        <div><h8 class='fw-bold'>Title</h8>
                                        <span>${data.title}</span></div>

                                        <div><h8 class='fw-bold'>ประเภท</h8>
                                        <span>${data.category}</span></div>

                                        <div><h8 class='fw-bold'>ผู้บริจาค</h8>
                                        <span>${data.name}</span></div>

                                        <div><h8 class='fw-bold'>Tel</h8>
                                        <span>${data.tel}</span></div>
                                        
                                        <div><h8 class='fw-bold'>Location</h8>
                                        <div>${data.location}</div></div>

                                        
                                    </div> 
                                </div>
                            </div>


                            <div class='mt-4'>
                                <h6 class='fw-bold'>Description</h6>
                                <div class='rounded bg-dark text-light p-2 pb-4'>
                                    <p>${data.description}</p>
                                </div>
                            </div>
                            <br>
                            <div>
                                <div class="mb-3">
                                    <h6 for="available_until " class="form-label fw-bold">ระบุเหตุผล ทำไมจึงขอ</h6>
                                    <input type="text" id="message" name="message" class="form-control">
                                    
                                </div>
                            </div>    
                            
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick='request(${data.donate_id},${data.user_id});'>Send Reuest</button>
                            </div>
                        </div>
        `;
    }


    function request(donate_Id, user_id) {

        const message = document.getElementById('message'); //get message

        data = {
            command: 'insert',
            donate_id: donate_Id,
            requester_id: user_id, //คนที่รับสิ่งของ
            status_request: 10002,
            message: message.value,
            decision_by: '',
            decision_note: ''
        }

    


        fetch('../api/request.php', {
                method: 'POST',
                header: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            }).then(res => res.json())
            .then(data => {
                console.log(data);
            })
            .catch(error => {
                console.error(error);
            })

        btn_request(donate_Id);

    }


    function btn_request(donate_id) {

        // update only donation
        const update_status = {
            command: "update_status",
            donate_id: donate_id,
            status: "10002"
        }

        fetch('../api/Donations.php', {
                method: 'POST',
                header: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(update_status)
            })
            .then(res => res.json())
            .then(data => {
                console.log(data);

                datacard();


            }).catch(error => {
                console.error(error);
            })
    }
</script>