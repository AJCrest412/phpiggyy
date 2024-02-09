<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo e($title); ?></title>
</head>

<body>
  <!-- Start Main Content Area -->
  <section class="container mx-auto mt-12 p-4 bg-white shadow-md border border-gray-200 rounded">
    <!-- Page Title -->
    <h3>About Page</h3>

    <hr />

    <!-- Escaping Data -->
    <p>Escaping Data:<?php echo e($dangerousData); ?> </p>
  </section>
  <!-- End Main Content Area -->

</body>

</html>