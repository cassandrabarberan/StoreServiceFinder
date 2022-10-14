<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>


  </head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">

<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
  <span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="navbarNavDropdown">
  <ul class="navbar-nav">
    <li class="nav-item <?php echo (currentpage() == 'index.php') ? "active" : True; ?> ">
      <a class="nav-link" href="<?php echo web_root; ?>admin/">
        <i class="fa fa-dashboard"></i> <span>Dashboard</span> </a>
    </li>
    <?php if ($singleuser->Role == "Administrator") { ?>
      <li class="nav-item <?php echo (currentpage() == 'store') ? "active" : false; ?>">
        <a class="nav-link" href="<?php echo web_root; ?>admin/store/">
          <i class="fa fa-building"></i> <span>Store</span>
        </a>
      </li> <?php } ?>

    <li class=" nav-item <?php echo (currentpage() == 'products') ? "active" : false; ?>">
      <a class="nav-link" href="<?php echo web_root; ?>admin/products/">
        <i class="fa fa-suitcase"></i> <span>Products</span>
      </a>
    </li>
    <li class="nav-item <?php echo (currentpage() == 'stockin') ? "active" : false; ?>">
      <a class="nav-link" href="<?php echo web_root; ?>admin/stockin/">
        <i class="fa fa-th"></i> <span>Stock-in</span>
      </a>
    </li>

    <li class=" nav-item <?php echo (currentpage() == 'inventory') ? "active" : false; ?>">
      <a class="nav-link" href="<?php echo web_root; ?>admin/inventory/">
        <i class="fa fa-list-alt"></i> <span>Inventory</span> </a>
    </li>
    <li class=" nav-item <?php echo (currentpage() == 'category') ? "active" : false; ?>">
      <a class="nav-link" href="<?php echo web_root; ?>admin/category/">
        <i class="fa fa-list"></i> <span>Category</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="#">Pricing</a>
    </li>
    <li class="nav-item dropdown <?php echo (currentpage() == 'inventoryreport' || currentpage() == 'salesreport') ? "active" : false; ?>">
      <a class="nav-link dropdown-toggle fa fa-bar-chart" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Reports
      </a>
      <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
        <a class="dropdown-item <?php echo (currentpage() == 'inventoryreport') ? "active" : false; ?>"  href="<?php echo web_root; ?>admin/inventoryreport/"> Inventory</a>
        <a class="dropdown-item <?php echo (currentpage() == 'inventoryreport') ? "active" : false; ?>" href="<?php echo web_root; ?>admin/salesreport/"> Sales</a>
        
      </div>
    </li>

    <?php if ($_SESSION['ADMIN_ROLE'] == 'Administrator') { ?>
      <!--         <li class="<?php echo (currentpage() == 'autonumber') ? "active" : false; ?>" >
<a href="<?php echo web_root; ?>admin/autonumber/">
<i class="fa fa-suitcase"></i> <span>Autonumber</span> 
</a>
</li>  -->
      <li class="<?php echo (currentpage() == 'user') ? "active" : false; ?>">
        <a href="<?php echo web_root; ?>admin/user/">
          <i class="fa fa-user"></i> <span>Manage Users</span> </a>
      </li>
    <?php } ?>

    
  </ul>
</div>
</nav>


</body>
</html>