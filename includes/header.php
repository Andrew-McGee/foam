<!-- Header for McGee Technology - Copyright 2018-2020 McGee Technology
     Mostly the meta data for SEO and CSS stylesheets -->

<!-- Standard Meta -->
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
<meta name="google-site-verification" content="OHjKANI42quW0tLq927uOg3UAPciUbgJsWmirTpVXPs" />

<link href="/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" />

  <!-- Site Properties using Semantic -->
  <link rel="stylesheet" type="text/css" href="semantic/components/reset.css">
  <link rel="stylesheet" type="text/css" href="semantic/components/site.css">

  <link rel="stylesheet" type="text/css" href="semantic/components/container.css">
  <link rel="stylesheet" type="text/css" href="semantic/components/grid.css">
  <link rel="stylesheet" type="text/css" href="semantic/components/header.css">
  <link rel="stylesheet" type="text/css" href="semantic/components/image.css">
  <link rel="stylesheet" type="text/css" href="semantic/components/menu.css">

  <link rel="stylesheet" type="text/css" href="semantic/components/divider.css">
  <link rel="stylesheet" type="text/css" href="semantic/components/dropdown.css">
  <link rel="stylesheet" type="text/css" href="semantic/components/segment.css">
  <link rel="stylesheet" type="text/css" href="semantic/components/button.css">
  <link rel="stylesheet" type="text/css" href="semantic/components/list.css">
  <link rel="stylesheet" type="text/css" href="semantic/components/icon.css">
  <link rel="stylesheet" type="text/css" href="semantic/components/sidebar.css">
  <link rel="stylesheet" type="text/css" href="semantic/components/transition.css">
  <link rel="stylesheet" type="text/css" href="semantic/components/label.css">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="css/main.css" type="text/css" />

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script src="semantic/components/visibility.js"></script>
  <script src="semantic/components/sidebar.js"></script>
  <script src="semantic/components/transition.js"></script>

  <script>
  $(document)
    .ready(function() {

      // fix menu when passed
      $('.masthead')
        .visibility({
          once: false,
          onBottomPassed: function() {
            $('.fixed.menu').transition('fade in');
          },
          onBottomPassedReverse: function() {
            $('.fixed.menu').transition('fade out');
          }
        })
      ;

      // create sidebar and attach to menu open
      $('.ui.sidebar')
        .sidebar('attach events', '.toc.item')
      ;

    })
  ;
  </script>
