<?php
function migrate_location(){

	// Get the post type and field name via query string
	$postType = $_GET['migrateType'];
	$field_key = $_GET['migrateField'];
	
	// The function only runs with the query strong.
	if($postType && $field_key){
	
		$args = array(
			'post_type' => $postType,
			'posts_per_page' => 9999,
		);
		
		// If it's on an options area, don't do any loops.
		if($postType == 'options'){			
			migrateLogic(get_field($field_key), $field_key, "Options");
		} else{
			// Let's loop through your posts.
			$my_query = new WP_Query( $args );
			if ( $my_query->have_posts() ) {
				while ( $my_query->have_posts() ) {
					$my_query->the_post();				
					$post_id = get_the_ID();
									
					// Get the old location field.
					$old_location = get_field($field_key);
					
					migrateLogic($old_location, $field_key, $post_id);
					
				}
			}
		}
	}
}

// This does all the DB magic. 
function migrateLogic($old_location, $field_key, $post_id){
	
	// Sometimes the field outputs a weird string instead of an array.
	if(is_string($old_location)){
		
		$old_location = explode('|', $old_location);
		$old_location = array(
			'address' => $old_location[0],
			'coordinates' => $old_location[1]
		);

	}
	// Only run if there's a field value, and that field value is in the old syntax.
	if(count($old_location) == 2){					
		// Explode the coordinates into an array for the new Location syntax.
		$old_coordinates = explode(',', $old_location['coordinates']);
		// Grabs the address
		$old_address = $old_location['address'];
		
		// Sets up the new "Google Map" syntax.
		$newLocation = array(
			"address" => $old_address,
			"lat" => $old_coordinates[0],
			"lng" => $old_coordinates[1]
		);
		
		// Updates the field with the new syntax.
		// update_field( $field_key, $newLocation );
		echo "Post #" .$post_id. ' has been updated!<br>';
		update_field( $field_key, $newLocation );
	} 
	// Let you know of successes.
	elseif(count($old_location) == 3){
		echo "Post #" .$post_id. ' is already updated!<br>';
	}
}

add_action('wp_head', 'migrate_location');