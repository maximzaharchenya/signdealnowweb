<!doctype html>
<html lang="ru">
<head>
    <?php ($assets_value = 10); ?>

    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">


    <title>Сервис SignDealNow</title>

    <!-- Styles -->
    <link rel="stylesheet" href="/css/app.css?v=<?php echo e($assets_value); ?>">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500&display=swap" rel="stylesheet">

    <?php if(app()->environment('local')): ?>
        <meta name="environment" content="local">
    <?php endif; ?>

</head>
<body>

    <main id="app">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <!-- Scripts -->

    <script src="/js/<?php echo $__env->yieldContent('js'); ?>?v=<?php echo e($assets_value); ?>"></script>

</body>
</html>
<?php /**PATH C:\Users\aren9\OneDrive\Desktop\signdealnowweb\resources\views/layouts/app.blade.php ENDPATH**/ ?>