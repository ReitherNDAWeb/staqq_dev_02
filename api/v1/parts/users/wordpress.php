<?php

	$app->get('/user/{wpid}/rechnungen', function($request, $response, $args) use($app) {
			
		define('DEFINED_JO_VERRECHNUNG_PRODUCT_ID', 231);	
		include("../../wp-load.php");

		$filter = array(
			'meta_key'    => '_customer_user',
			'meta_value'  => $args['wpid'], 
			'post_type' => 'shop_order',
			'orderby'       =>  'post_date',
			'order'         =>  'ASC',
			'posts_per_page' => -1 // no limit
		);

		$posts = get_posts($filter);
		$elements = array();

		foreach($posts as $p){

			$order = new WC_Order($p->ID);
			$items = $order->get_items();

			$elem = new stdClass();
			
			$elem->payment_url = $order->get_checkout_payment_url();
			$elem->summe = "€ " . number_format($order->get_total(), 2, ',', '.');
			$elem->type = "Paket Ordering";
			$elem->content = array();
			$elem->contentNames = array();

			foreach($items as $id => $item){
				
				
				if ($item['item_meta']['_product_id'][0] == DEFINED_JO_VERRECHNUNG_PRODUCT_ID){
					$elem->type = "Job Verrechnung";
				
					$x = new stdClass();

					$x->joborder_id = wc_get_order_item_meta($id, 'ID');
					$x->jobtitel = wc_get_order_item_meta($id, 'Job Name');
					$x->zeitraum = wc_get_order_item_meta($id, 'Zeitraum');

					$x->name = "{$x->jobtitel} ({$x->zeitraum})";
				}else{
				
					$x = new stdClass();
					$x->product_id = $item['item_meta']['_product_id'][0];
					$x->name = "{$item["item_meta"]["_qty"][0]}x {$item["name"]}";
				}

				array_push($elem->content, $x);
				array_push($elem->contentNames, $x->name);
			}

			if ($order->post->post_status == 'wc-completed'){
				$woo_pdf_invoice_id = get_post_meta($p->ID, '_woo_pdf_invoice_id', true);
				$woo_pdf_invoice_code = get_post_meta($p->ID, '_woo_pdf_invoice_code', true);
				$woo_pdf_invoice_prefix = get_post_meta($p->ID, '_woo_pdf_invoice_prefix', true);
				$woo_pdf_invoice_suffix = get_post_meta($p->ID, '_woo_pdf_invoice_suffix', true);

				$data = $woo_pdf_invoice_id.'|'.$woo_pdf_invoice_prefix.'|'.$woo_pdf_invoice_code.'|'.$woo_pdf_invoice_suffix;
				$elem->rechnung = '/?wpd_invoice=' . base64_encode($data);
			}else{
				$elem->rechnung = false;
			}

			array_push($elements, $elem);
		}
        
		$body = json_encode($elements);
        $response->write($body);
        return $response;
        
	});
?>