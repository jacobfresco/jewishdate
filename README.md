# Info

* Name: JewishDate
* Current version: 0.6
* Status: Stable / On hold

## History
The idea for this plugin came from the wonderfull Hebrew Date-plugin by [KosherJava](https://kosherjava.com/2006/11/05/hebrew-date-plugin-has-a-new-home/). Unfortunately, that plugin didn't have the possibility to display the current date in Hebrew i.e. in the sidebar.

## Versions

* 0.6 - Deprecated split() replaced by explode() in source
* 0.5 - Support for native hebrew (RTL); extra widget
* 0.4 - Added widgets
* 0.3 - Small fix for the sixth month (Adar)
* 0.2 - First commit
* 0.1 - Never released

## Installation

Upload the file jewishdate.php to the plugin directory of your Wordpress installation and activate the plugin. Go to the Widget-screen, ag the widget you want to use (Jewishdate – phonetic writing or HebrewDate – official writing) to the desired widget area and press 'Save'.

Use the codes below to use the plugin anywhere on the website, outside of the widget areas:
```
<?php if (function_exists('JewishDateNS')) { JewishDateNS(); } ?>
<?php if (function_exists('JewishDateHebrew')) { JewishDateHebrew(); } ?>
```

