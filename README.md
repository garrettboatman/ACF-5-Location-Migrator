# ACF 5 Location Migrator
This is a niche, dirty-ass script that helps migrate the [ACF 4 "Location" field add-on](https://wordpress.org/plugins/advanced-custom-fields-location-field-add-on) data to the [ACF 5's core "Google Maps"](http://www.advancedcustomfields.com/resources/google-map/) field. If you use this wrong, it will fuck up your database, but it works! Make sure to back up your DB.
### Why it exists.
You're pissed because the [Location field add-on](https://wordpress.org/plugins/advanced-custom-fields-location-field-add-on) doesn't support ACF 5. The [ACF 5 Google Map field](http://www.advancedcustomfields.com/resources/google-map/) basically replaces the need for the location field, but the data is saved differently in the database. Booooo! You switched the fields in ACF, but when you edit a post, the data is blank. 

The data is there, it just doesn't know how to interact with the Google maps field. We want our current data to work with the new format.
### What it does.
This script is run via query string, and loops through any post type of your choice. You provide the script with the field name you want to update(such as `location` or `map`, or any other name you chose). The script checks to see if the saved data is in the old ACF 4 add-on format. If it is, it'll grab that data, interpret it into the new ACF 5 Google map format, and save that field.
### What should my query string look like?
Lets say you have example.com running on WP, with post type called `events`. In the `events` post type, you have a custom field called `location`. 

Your query string will be `example.com?migrateType=events&migrateField=location`

Just go to that URL and the script will output some gross plain text to tell you what it did.
### What should my upgrade process be?
(I'm gonna write more about this later. Email garrett.boatman@mac.com if you need this NOW) 

1. Backup your DB.
2. Place the whole contents of the php file into your functions.php. 
3. Activate ACF 5(or Pro). Deactivate regular ACF and the redundant add-on(s).
3. Run this script.
4. Update your templates to the new [ACF 5 Google Maps](http://www.advancedcustomfields.com/resources/google-map/) format.
5. Delete redundant ACF versions and add-ons.