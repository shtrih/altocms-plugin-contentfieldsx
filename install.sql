ALTER TABLE  `prefix_content_field` ADD  `field_unique_name` VARCHAR( 255 ) NULL DEFAULT NULL AFTER  `content_id` ;
ALTER TABLE  `prefix_content_field` ADD UNIQUE (
  `content_id` ,
  `field_unique_name`
);