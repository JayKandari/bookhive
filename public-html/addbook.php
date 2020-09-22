<html>

<head>
    <title>BookADD</title>
    <link rel="stylesheet" type="text/css" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="../asset/images/login.css">
</head>
<?php include 'admindash.php'; ?>
<body>
    <div class="container">
        <div class="header">
            <h1>Add Book</h1>
        </div>
        <div class="main">
            <form action="" method="POST">
                <span>
                    <input type="text" placeholder="Book Name" name="bname">
                </span><br>
                <span>
                    <input type="text" placeholder="Book Department" name="bdept">
                </span><br>
                <span>
                    <input type="text" placeholder="Book Author" name="bauthor">
                </span><br>
                <span>
                    <input type="text" placeholder="Book Year" name="byear">
                </span><br>
                <span>
                    <input type="text" placeholder="Book Quantity" name="bquantity">
                </span><br>
                <span>
                    <input type="file" placeholder="Book Coverphoto" name="bcover">
                </span><br>
                <button name="submit">Add Book</button>

            </form>
        </div>
    </div>
</body>

</html>