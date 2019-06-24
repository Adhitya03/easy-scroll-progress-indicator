# easy-scroll-progress-indicator
Create a reading page scroll progress indicator bar to show how much the user has scrolled through of current page. Easy Scroll Progress Indicator has unlimited background color and has 4 indicator bar position. You can put the indicator bar on the top, bottom, left or right.

== Installation ==

1. In your WordPress admin panel, go to Plugins > New Plugin, search for "Easy Scroll Progress Indicator" and click "Install now". Alternatively, download the plugin and upload the contents of user-agent-blocker.zip to your plugins directory, which may be in /wp-content/plugins/.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Go to Appearance > Customize and you can start configure the indicator bar from there.

== Frequently Asked Questions ==

= I have activated the plugin, but the indicator does not show up =

You have to configure the indicator background color, indicator size and indicator position. Open "Appearance > Customize", in customizing area, click "Scroll Progress Indicator" and you can start configure the indicator bar from there.

= I have configured the plugin, but the indicator still does not show up =

This plugin use `wp_body_open()`, make sure that you use Wordpress minium 5.2, if you have used Wordpress 5.2 or above, please open "Appearance > Theme Editor", and then open Theme Header or header.php, and put this code `<?php wp_body_open(); ?>` right after opening body tag `<body>` or `<body <?php body_class();?> >`. and then Update File.
