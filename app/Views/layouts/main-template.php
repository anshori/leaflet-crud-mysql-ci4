<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="https://unsorry.net/assets-date/images/favicon.png" type="image/x-icon">
  <title><?= $title ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css" integrity="sha512-oAvZuuYVzkcTc2dH5z1ZJup5OmSQ000qlfRvuoTTiyTBjwX1faoyearj8KdMq0LgsBTHMrRuMek7s+CxF8yE+w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <?= $this->renderSection('css') ?>
</head>

<body>
  <?= $this->include('components/navbar') ?>

  <?= $this->renderSection('content') ?>
  
  <?= $this->include('components/modal') ?>
  
  <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  <?= $this->include('components/toast'); ?>
  <?= $this->renderSection('js') ?>
</body>

</html>