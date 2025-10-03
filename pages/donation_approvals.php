<?php
include "../menu.php";
    
?>

<body>
    <main class="p-4 flex-grow-1" style="margin-left: 250px; padding: 20px; overflow-y: auto;">
        <h1>Approval Table</h1>
        

    </main>

</body>

</html>


<script>


    fetch('../api/request.php', {
        method: 'POST',
        headers:{'Content-Type':'application/json'},
        body: JSON.stringify({'command':'select'})
    }).then(res => res.json())
    .then(data => {
        console.log(data);
    })
    .catch(error =>{
        console.error(error);
    })
</script>