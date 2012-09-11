<?php
/************************************
 | Class name  : Table.inc.php |
 | Last Modify : Sep 2012           |
 | By          : Narong Rammanee    |
 | E-mail      : ranarong@live.com  |
 ************************************/

// Include Initialize file.
require_once dirname( __FILE__ ) . '/includes/init.inc.php';

// Find the total number of records.
$sql = "SELECT * FROM tbl_demo";

$sth = $pdo->prepare($sql);
$sth->execute();

// Pagination configuration.
$link    = 'index.php?p=';
$records = $sth->rowCount();
$curpage = isset($_REQUEST['p']) ? $_REQUEST['p'] : 1;
$perpage = 10;

// Create new pagination instance
$pager = new Pagination( $link, $records, $curpage, $perpage );

// Pagination HTML
$pagination = $pager->render();

$sql .= ' LIMIT :limit OFFSET :start;';

$sth = $pdo->prepare($sql);

$sth->bindValue(':limit', $perpage, PDO::PARAM_INT);
$sth->bindValue(':start', $pager->offset, PDO::PARAM_INT);
$sth->execute();

// Table attributs string.
$attributes = 'class="table table-bordered table-striped table-hover"  width="100%"';

// Table header array.
$header = array(
    array('scope="col" class="text_center w80"', 'รหัส'),
    array('scope="col" class="text_center"', 'ชื่อ'),
    array('scope="col" class="text_center"', 'นามสกุล'),
    array('scope="col" class="text_center"', 'อีเมล์')
);

// Table data array.
$data = array();
while($row = $sth->fetch(PDO::FETCH_OBJ)) {
    $data[] = array(
        'id'        => array('class="text_center"', $row->id),
        'name'      => $row->name,
        'surname'   => $row->surname,
        'email'     => $row->email, 
    );
}

// Table footer
//     $countHeader = count($header);
//     $footer = array(
//         array('colspan="' . $countHeader . '"', $pagination)
//     );

// Create new table instance
$table = new Table($attributes, $header, $data, $caption, $footer);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Pagination</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link rel="stylesheet" type="text/css" href="libs/bootstrap/css/bootstrap.css" />
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>
  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li class="active"><a href="index.php?p=1">Home</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container">

    <h1>Pagination</h1>
    <?php echo $table->render(), $pager->render(); ?>

    </div> <!-- /container -->

  </body>
</html>