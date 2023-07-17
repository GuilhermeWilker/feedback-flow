<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="./assets/styles/global.css">
</head>
<body>
    <div class="container">
        <?php require $view; ?>
    </div>
</body>
</html>