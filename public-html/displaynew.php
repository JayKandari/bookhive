<html>
<title>New Collection</title>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="fontawesome/css/all.min.css">
</head>
<?php include 'homepage.php'; ?>
<body>
<?php
    $k = new book;
    $row = $k->disp_book("yes");
    $c = count($row);
    for ($x = 0; $x < $c; $x++) {
        echo '<div class="card">';
        echo '<img src="' . $row[$x]["path"] . '" alt="Avatar" style="width:100%">';
        echo '<div class="container">';
        echo '<h4><b>' . $row[$x]["title"] . '</b></h4>';
        echo '<h4><b>' . $row[$x]["author"] . '</b></h4>';
        echo '<h4><b>' . $row[$x]["category"] . '</b></h4>';
        if ($row[$x]["available"] == "1") {
            echo '<form method="post">';
            echo '<input type="hidden" name="bid" value="' . $row[$x]["id"] . '"/>';
            echo '<button name="issue">ISSUE BOOK </button>';
            echo '</form>';
        }
        echo '</div>';
        echo '</div>';
    }
    if (isset($_POST["issue"])) {
        $k->issue($_POST["bid"]);
    }

    ?>
</body>

</html>