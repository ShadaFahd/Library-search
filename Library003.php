<!DOCTYPE html>
<html lang="en">

<head>
    <title>Library</title>

    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
    </script>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">


    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        nav {
            background-color: #6babd7;
            border-radius: 0px 0px 15px 15px;
            padding: 10px;
        }

        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;

        }

        li {
            float: left;
            color: #c9dff0;
            border-right: 1px solid #bbb;
        }

        li:last-child {
            border-right: none;
        }

        li a {
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        li a:hover:not(.active) {
            background-color: #555;
        }

        .active {
            background-color: #04AA6D;
        }

        button {
            color: black;
            background-color: #6babd7;
            border: 1px solid #6babd7;
            border-radius: 5px;
            padding: 10px 15px 10px 15px;
        }

        button:hover {
            background-color: #158ed5;
            border: 1px solid #158ed5;
        }



        /* Style the header */
        .header {
            padding: 30px;
            text-align: center;
            font-size: 35px;
        }

        /* Create three equal columns that floats next to each other */
        .column {
            float: left;
            width: 58%;
            padding: 10px;
        }

        .column2 {
            float: left;
            width: 37%;
            padding: 10px;
        }

        .column3 {
            float: left;
            width: 5%;
            padding: 10px;
        }

        /* Clear floats after the columns */
        .row:after {
            content: "";
            display: table;
            clear: both;
            margin: auto;
            padding: 10px;
        }

        /* Style the footer */
        .footer {
            background-color: #f1f1f1;
            padding: 10px;
            text-align: center;
        }

        /* Responsive layout - makes the three columns stack on top of each other instead of next to each other */
        @media (max-width: 600px) {
            .column {
                width: 100%;
            }
        }

        #keywords {
            margin: 0 auto;
            font-size: 18px;
            margin-bottom: 20px;

        }

        #keywords thead {
            cursor: pointer;
            background: #c9dff0;
        }

        #keywords thead tr th {
            padding: 5px 10px;
            padding-left: 42px;

        }

        #keywords thead tr th span {
            padding-right: 20px;
            background-repeat: no-repeat;
            background-position: 100% 100%;

        }

        #keywords thead tr th.headerSortUp,
        #keywords thead tr th.headerSortDown {
            background: #acc8dd;
        }

        #keywords tbody tr {
            color: #555;
        }

        #keywords tbody tr td {
            text-align: center;
            padding: 15px 10px;
        }

        #keywords tbody tr td.lalign {
            text-align: left;
        }
    </style>
</head>

<body>

    <nav>
        <ul>
            <li><a>Home</a></li>
            <li><a>About</a></li>
        </ul>
    </nav>
    <div class="header">
        <img src="DatabaseLogo003.png" alt="Library" style="width:400px;height:280px;" class="center">
    </div>


    <!-- column 0 -->
    <div class="column3"></div>

    <!-- column 1 -->
    <div class="row">
        <div class="column">
            <h5>Book List</h5>
            <?php
            $con = new mysqli("localhost", "root", "", "library");
            if (!$con) {
                die("Error: Failed to connect to database");
            }
            $stmt = $con->prepare("SELECT book.ISBN,book.TITLE,category_library.CategoryName,auther.AutherName, book.STATUS FROM book INNER JOIN category_library ON book.IDCategory = category_library.IDCategory INNER JOIN auther ON book.IDAuther = auther.IDAuther;");
            $stmt->execute();

            $result = $stmt->get_result();
            echo "<table id='keywords' cellspacing='0' cellpadding='0'>";
            echo "    <thead>
        <tr>
          <th><span>ISBN</span></th>
          <th><span>TITLE</span></th>
          <th><span>Category</span></th>
          <th><span>Author</span></th>
          <th><span>Status</span></th>
        </tr>
      </thead>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row['ISBN'] . "</td><td>" . $row['TITLE'] . "</td><td>" . $row['CategoryName'] . "</td><td>" . $row['AutherName'] . "</td><td>" . $row['STATUS'] . "</td>";
            }
            echo "</table>"
            ?>
        </div>

        <!-- column 2 -->
        <div class="column3"></div>

        <!-- column 3 -->
        <div class="column2">
            <div class="col-md-10">
                <br />
                <br />
                <form class="form-inline" method="POST" action="Library003.php">
                    <div class="input-group col-md-12">
                        <input type="text" class="form-control" placeholder="Search for Book here..." name="keyword" required="required" value="<?php echo isset($_POST['keyword']) ? $_POST['keyword'] : '' ?>" />
                        <span class="input-group-btn">
                            <button name="search"><span class="glyphicon glyphicon-search">Search</span></button>
                        </span>
                    </div>
                </form>
                <br />
                <!-- Search php -->
                <?php
                if (isset($_POST['search'])) {
                    $keyword = $_POST['keyword'];
                ?>
                    <div>
                        <h5>Result</h5>
                        <hr style="border-top:2px dotted #ccc;" />
                        <?php
                        $query = mysqli_query($con, "SELECT * FROM `book` WHERE `TITLE` LIKE '%$keyword%' ORDER BY `TITLE`") or die(mysqli_error());
                        while ($fetch = mysqli_fetch_array($query)) {
                        ?>
                            <div style="word-wrap:break-word;">
                                <?php echo $fetch['STATUS'] ?>
                                <?php echo $fetch['ISBN'] ?>
                                <h4><?php echo $fetch['TITLE'] ?></h4>
                                <p><?php echo substr($fetch['NOTE'], 0, 100) ?>...</p>
                            </div>
                            <hr style="border-bottom:1px solid #ccc;" />
                        <?php
                        }
                        ?>
                    </div>
                <?php
                }
                ?>

                <!-- end of search-->
            </div>
        </div>
    </div>
    <!-- end of row-->



    <!-- column 0 -->
    <div class="column3"></div>
    <!-- column 1 -->
    <div class="row">
        <div class="row">
            <div class="column">
                <h5>Thesis List</h5>
                <?php
                $query2 = mysqli_query($con, "SELECT thesis.IDThesis,thesis.TITLE,category_library.CategoryName,auther.AutherName FROM thesis INNER JOIN category_library ON thesis.IDCategory = category_library.IDCategory INNER JOIN auther ON thesis.IDAuther = auther.IDAuther;") or die(mysqli_error());

                echo "<table id='keywords' cellspacing='0' cellpadding='0'>";
                echo "    <thead>
                    <tr>
                    <th><span>ID</span></th>
                    <th><span>TITLE</span></th>
                    <th><span>Category</span></th>
                    <th><span>Author</span></th>
                    </tr>
                </thead>";
                while ($row2 = mysqli_fetch_array($query2)) {
                    echo "<tr><td>" . $row2['IDThesis'] . "</td><td>" . $row2['TITLE'] . "</td><td>" . $row2['CategoryName'] . "</td><td>" . $row2['AutherName'] . "</td>";
                }
                echo "</table>"
                ?>
            </div>
        </div>
        <!-- end of row-->

</body>

</html>