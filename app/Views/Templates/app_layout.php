<?= $this->include('Templates/dependencies') ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
	<?= $this->renderSection('header') ?>
  <title>Manajemen Kebun BCN</title>
  <meta name="description" content="Portal manajemen PT BCN">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" type="image/png" href="<?php echo base_url('public/assets/leaf.ico');?>"/>
</head>
<body class="antialiased" onLoad="defaultLoad();">
  <?= $this->renderSection('content') ?>
  <?= $this->renderSection('scripts') ?>
</body>
</html>
