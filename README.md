# UWave Call Screening App
This README is lacking. For now.
This is an app for [FusionPBX](http://www.fusionpbx.com/) that we use at UWave Radio to do call
screening.

# Install
To install it, clone into fusionpbx's `app/` folder and run the menu upgrades (Advanced->Upgrade,
  check off Menu Defaults and hit Execute). Note that FusionPBX seems to prefer lower case naming
  with underscores, so when cloning be sure to clone to or rename the folder `call_screening`. Next,
  run `composer install` within the directory. You'll need to have [Composer](https://getcomposer.org/).
  Next log into FusionPBX, go int Advanced->Upgrade, check "menu" and click "Execute". You may need
  to log out and log back in for it to show up in the menu.

# Slack
We use Slack as a crappy interface for now. If you wish to configure Slack webhooks for call
origination, setup a webhook pointing at `slack.php`. Copy `settings.example.json` and update as
needed. You will likely need to change most, if not all, of the example values.
