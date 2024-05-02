<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <title><?= $title ?></title>
  <meta name="description" content="Website of KaiserStuhl Escape">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="style/style.css" rel="stylesheet"><?= $style ?>
  <link rel="icon" href="img/favicon.ico" type="image/x-icon">
</head>

<body>
  <header>

    <?= $menu ?>

  </header>
  <main>
    <h1 class="page_title"><?= $titre ?></h1>
    <?= $contenu ?>
  </main>
  <footer>
    <?= $footer ?>
  </footer>
  
  <script src="js/header.js"></script>
<?= $script ?>
</body>

</html>