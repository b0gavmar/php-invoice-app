<?php
$items = [
    ['id' => 1, 'name' => 'Alma', 'price' => 12],
    ['id' => 2, 'name' => 'Körte', 'price' => 23],
    ['id' => 3, 'name' => 'Ananász', 'price' => 34],
    ['id' => 4, 'name' => 'Ananász2', 'price' => 45],
];
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
        $(document).ready(function(){
            //console.log($);
            $("#add_item_btn").click(function(e){
                $("#show_item").append(`<div class="row p-3 append_item">
                    <div class="col-md-3 p-1">
                    <input class="form-control" type="text" name="item_name[]" placeholder="Item Name" required>

                    </div>
                    <div class="col-md-3 p-1">
                    <input class="form-control" type="number" name="item_price[]" placeholder="Item Price" required>

                    </div>
                    <div class="col-md-3 p-1">
                    <input class="form-control" type="number" name="item_qty[]" placeholder="Item Quantity" required>

                    </div>
                    <div class="col-md-3 p-1">
                    <button class="btn btn-danger w-100 remove_item_btn" type="button" name="remove" >Remove</button>

                    </div>
                </div>`);
            });

            $(document).on('click', '.remove_item_btn', function(e){
                e.preventDefault();
                $(this).closest('.append_item').remove();
                console.log("del");
            });

            $("#add_form").submit(function(e){
                e.preventDefault();
                $("#add_btn").val('Adding...');
                $.ajax({
                    url:'action.php',
                    method:'post',
                    data: $(this).serialize(),
                    success: function(response){
                        $("#add_btn").val('Add');
                        $('#add_form')[0].reset();
                        $("#show_item").empty();
                        $("#show_item").append(`
                            <div class="row p-3 append_item">
                                <div class="col-md-3 p-1">
                                    <input class="form-control" type="text" name="item_name[]" placeholder="Item Name" required>
                                </div>
                                <div class="col-md-3 p-1">
                                    <input class="form-control" type="number" name="item_price[]" placeholder="Item Price" required>
                                </div>
                                <div class="col-md-3 p-1">
                                    <input class="form-control" type="number" name="item_qty[]" placeholder="Item Quantity" required>
                                </div>
                                <div class="col-md-3 p-1">
                                    <button class="btn btn-danger w-100 remove_item_btn" type="button">Remove</button>
                                </div>
                            </div>
                        `);
                        $("#show_alert").html(`<div class="alert alert-success" role="alert">${response}</div>`);
                    }
                });
            });

            $(document).on('change','.form-select',function(){
                let price = $(this).find(':selected').data('price'); //sima jsben dataset.price
                $(this).closest(".append_item").find('input[name="item_price"]').val(price + " / db");
            });

        });
    </script>
</head>
<body class="bg-dark">
    <div class="container bg-white my-2 p-2 rounded">
        <div id="show_alert">

        </div>
        <form action="" method="POST" id="add_form">
            <div id="show_item">
                <div class="row p-3 append_item">
                    <div class="col-md-3 p-1">
                        <select class="form-select" name="item_id[]" placeholder="Válasszon terméket" required>
                            <?php foreach($items as $item): ?>
                                <option 
                                    value="<?= $item['id'] ?>"
                                    data-price="<?= $item['price'] ?>">
                                    
                                    <?php echo htmlspecialchars($item['name']) ?> 
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <!-- "?=" === "php echo" -->
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
            </div>
            <div class="row p-3 justify-content-center">
                <button class="btn btn-primary w-25 m-2" type="submit" id="add_btn" >Add</button>
                <a class="btn btn-danger w-25 m-2" type="button" href="pdf.php" id="pdfbutton" target="_blank">PDF</a>
                <button class="btn btn-success w-25 m-2" type="button" id="add_item_btn" name="add" >Add More</button>
            </div>
        </form>
    </div>

</body>
</html>