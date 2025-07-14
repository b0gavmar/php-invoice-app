<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Invoice App</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
    <script>
        let itemlist = [];

        function fillSelect(currentElement){
            let options = "";
            itemlist.forEach(element => {
                options += `<option value="${element.id}" data-price="${element.price}">
                                ${element.name}
                            </option>`;
            });
            $(currentElement).html(options);
        }

        $(document).ready(function(){

            $.ajax({
                url: 'load.php',
                method: 'GET',
                success: function(resp) {
                    itemlist = JSON.parse(resp)
                    fillSelect($(".form-select"));
                }
            })

            $("#add_item_btn").click(function(e){
                $("#show_item").append(`
                    <div class="row p-3 append_item">
                        <div class="col-md-3 p-1">
                            <select class="form-select" name="item_id[]" placeholder="Válasszon terméket" required>
                            </select>
                        </div>

                        <div class="col-md-3 p-1">
                            <input class="form-control" type="text" name="item_price" placeholder="Termék ára" disabled>
                        </div>

                        <div class="col-md-3 p-1">
                            <input class="form-control" type="number" name="item_qty[]" placeholder="Item Quantity" required>
                        </div>

                        <div class="col-md-3 p-1">
                            <button class="btn btn-danger w-100 remove_item_btn"  type="button" name="add">Remove</button>
                        </div>
                    </div>
                `);

                fillSelect($(".append_item:last-child select"));
            });

            $(document).on('click', '.remove_item_btn', function(e){
                e.preventDefault();
                $(this).closest('.append_item').remove();
            });

            $("#add_form").submit(function(e){
                e.preventDefault();
                $.ajax({
                    url:'action.php',
                    method:'POST',
                    data: $(this).serialize(),
                    success: function(response){
                        $("#add_btn").val('Add');
                        $('#add_form')[0].reset();
                        $("#show_item").empty();
                        $("#show_item").append(`
                            <div class="row p-3 append_item">
                                <div class="col-md-3 p-1">
                                    <select class="form-select" name="item_id[]" placeholder="Válasszon terméket" required>
                                    </select>
                                </div>

                                <div class="col-md-3 p-1">
                                    <input class="form-control" type="text" name="item_price" placeholder="Termék ára" disabled>
                                </div>

                                <div class="col-md-3 p-1">
                                    <input class="form-control" type="number" name="item_qty[]" placeholder="Item Quantity" required>
                                </div>

                                <div class="col-md-3 p-1">
                                    <button class="btn btn-danger w-100 remove_item_btn"  type="button" name="add">Remove</button>
                                </div>
                            </div>
                        `);

                        fillSelect($(".form-select"));

                        let data = JSON.parse(response);
                        $("#show_alert").html(`<div class="alert alert-success" role="alert">Rendelés sikeresen mentve #${data.order_id}</div>`);

                        window.open(`pdf.php?order_id=${data.order_id}`, "_blank");
                    }
                });
            });

            $(document).on('change','.form-select',function(){
                let price = $(this).find(':selected').data('price');
                $(this).closest(".append_item").find('input[name="item_price"]').val(price + " / db");
            });

        });
    </script>
</head>
<body class="bg-dark">
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">PHP Invoice App</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Rendeléseim</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger bg-dark rounded fw-bold" href="logout.php">Kijelentkezés</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container bg-white my-2 p-2 rounded">
        <div id="show_alert">

        </div>
        <form action="" method="POST" id="add_form">
            <div id="show_item">
                <div class="row p-3 append_item">
                    <div class="col-md-3 p-1">
                        <select class="form-select" name="item_id[]" placeholder="Válasszon terméket" required>
                        </select>
                    </div>

                    <div class="col-md-3 p-1">
                        <input class="form-control" type="text" name="item_price" placeholder="Termék ára" disabled>
                    </div>

                    <div class="col-md-3 p-1">
                        <input class="form-control" type="number" name="item_qty[]" placeholder="Item Quantity" required>
                    </div>

                    <div class="col-md-3 p-1">
                        <button class="btn btn-danger w-100 remove_item_btn"  type="button" name="add">Törlés</button>
                    </div>
                </div>
            </div>
            <div class="row p-3 justify-content-center bg-secondary  m-2 rounded">
                <button class="btn btn-info w-50 m-2 border border-dark border-2" type="submit" id="add_btn" >Mentés</button>
                <button class="btn btn-success w-25 m-2 border border-dark border-2" type="button" id="add_item_btn" name="add" >Több hozzáadása</button>
            </div>
        </form>
    </div>

</body>
</html>