<?php /*
Theme Name: Indpush
Description: A brief description of your theme.
*/
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.tooplate.com/templates/2135_mini_finance/css/bootstrap.min.css">

<link rel="stylesheet" href="https://www.tooplate.com/templates/2135_mini_finance/css/bootstrap-icons.css">

<link rel="stylesheet" href="https://www.tooplate.com/templates/2135_mini_finance/css/apexcharts.css">

<link rel="stylesheet" href="https://www.tooplate.com/templates/2135_mini_finance/css/tooplate-mini-finance.css">

  <style>
  /* Update the path to the local copy of the font */
  @font-face {
  font-family: 'bootstrap-icons';
  src: url('/fonts/bootstrap-icons.woff2') format('woff2');
  /* ... other font-face properties ... */
  }

  </style>
    <title><?php wp_title(); ?></title>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

    <div id="root">
        <!-- Your React app will be rendered here -->
    </div>

    <?php wp_footer(); ?>
</body>
</html>
