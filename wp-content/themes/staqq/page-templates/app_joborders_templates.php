<?php

    /**
     *   Template Name: STAQQ / App / Joborders / Templates
     */

    require_once get_template_directory().'/vendor/restclient.php';

    get_header();

	if(isset($_GET['id'])){
		$id = $_GET['id'];
		$template = $api->get("templates/$id", [])->decode_response();
	}else{	

		$templates = $api->get("templates", [
			'creator_type' => $wpUserRole,
			'creator_id' => $wpUserSTAQQId
		])->decode_response();
	}

?>
   
    <seciton class="section joborder-ressources">
        <div class="section__overlay">
            <div class="section__wrapper">
                <article class="gd gd--12">
					<a href="/app/joborders/" class="button">Zurück zu den Joborders</a>
                </article>
                <article class="gd gd--12">
                    
                    <?php 
						
						if (isset($_GET['id'])){
							var_dump($template);
					
					?>
                    
                    Item
                    
                    <?php 
												  
						} else {
						
                    		if (count($templates) > 0){
					?>
                    	
                    
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>verwenden</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($templates as $item){ ?>
								
								<tr>
									<td><?php echo $item->name; ?></td>
									<td><a href="/app/joborders/neu/?template=true&id=<?php echo $item->id; ?>" class="button">Neue Joborder erstellen und verwenden</a></td>
								</tr>
								
							<?php } ?>
                        </tbody>
                    </table>
                    
                    <?php 
						
							}else{
					?>
					
					<p>keine Vorlagen verfügbar!</p>
					
					<?php
							}
						}
					?>
                    
                </article>
            </div>
        </div>
    </seciton>
    
    <script>
        
        jQuery(document).ready(function(){
            jQuery('.remodal-ressource-details').remodal();
        });
        
        function openRemodal (id){
            jQuery('#ressources-id--'+id).remodal().open();
        }
        
    </script>
    
    
    
<?php

    get_footer();

?>
               
                    