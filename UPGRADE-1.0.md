# UPGRADE FROM `v0.X.X` TO `v1.0.0`

## Migrations

**Becarful : table names have been changed.** Every table is now prefixed by default with "aropixel_". You can override this settings by copying mapping files in your project. 

Automatic generation migrations will generate **DROP** and **CREATE TABLE** lines. 

In order to avoid data loss, you should modify your generated migration files whith following lines:
    * `RENAME TABLE post TO aropixel_post`
    * `RENAME TABLE post_image TO aropixel_post_image`
    * `RENAME TABLE post_image_crop TO aropixel_post_image_crop`
    * `RENAME TABLE post_category TO aropixel_post_category`
