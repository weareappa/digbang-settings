# Settings
(This package uses laravel-doctrine)

## Installation
`composer require digbang/settings`

Then
1. Add the service provider to your app.php config file
2. Publish or copy the config file

## Usage
Change the config file (settings.php) to create, update or edit your settings.

If you want to use an EnumSetting, you need to have a class that extends `Digbang\Utils\Enumerables\Enum`
Also, the default value for this setting should be an array as follows `[YourEnum::class, YourEnum::YourValue]`

If you want to use the TimeSetting, note that the expected value is a string with format `H:i`

All other settings should have a default value of the type the setting requires.

After configuring your settings, use the command `settings:sync` to synchronize the config with the database.

You can use the `SettingsRepository` to get the values by id, key, etc.
