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
            $("#add_item_btn").click(function(e){
                e.preventDefault();
                $("#show_item").prepend(`<div class="row p-3">
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
                    <button class="btn btn-danger w-100" id="remove_item_btn" name="remove" >Remove</button>

                    </div>
                </div>`);
            });

            $(document).on('click','#remove_item_btn',function(e){
                e.preventDefault();
                let row_item = $(this).parent().parent();
                $(row_item).remove();
            });
        });
    </script>
</head>
<body class="bg-dark">
    <div class="container bg-white my-2 p-2 rounded">
        <form action="" method="POST">
            <div id="show_item">
                <div class="row p-3">
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
                    <button class="btn btn-success w-100" id="add_item_btn" name="add" >Add More</button>

                    </div>
                </div>
            </div>
            <div class="row p-3">
                <button class="btn btn-primary w-25 m-2" type="submit">Add</button>
                <button class="btn btn-danger w-25 m-2" type="" name="pdfbutton">PDF</button>
            </div>
        </form>
    </div>

</body>
</html>