<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CodeIgniter Crud</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script></head>
<body class="my-5">
    <div class="container">
        
    <?php
    if(session()->getFlashdata('status') != '') {
        echo '<div class="alert alert-info">'.session()->getFlashdata('status').'</div>';
    }
    ?>
        <?= $this->renderSection('content') ?>
    </div>
</body>
</html>