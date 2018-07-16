/* Wc add to cart version 1.2.9 */
jQuery( function( $ ) {

	// wc_add_to_cart_params is required to continue, ensure the object exists
	if ( typeof wc_add_to_cart_params === 'undefined' )
		return false;
	
	// Ajax add to cart
	$( document ).on( 'click', '.variations_form .single_add_to_cart_button', function(e) {
		e.preventDefault();
		$variation_form = $( this ).closest( '.variations_form' );
		var var_id = $variation_form.find( 'input[name=variation_id]' ).val();
		var product_id = $variation_form.find( 'input[name=product_id]' ).val();
		var quantity = $variation_form.find( 'input[name=quantity]' ).val();
		var item = {},
			check = true;
			
			variations = $variation_form.find( 'select[name^=attribute]' );
			
			/* Updated code to work with radio button - mantish - WC Variations Radio Buttons - 8manos */ 
			if ( !variations.length) {
				variations = $variation_form.find( '[name^=attribute]:checked' );
			}
			
			/* Backup Code for getting input variable */
			if ( !variations.length) {
    			variations = $variation_form.find( 'input[name^=attribute]' );
			}
		
		variations.each( function() {
		
			var $this = $( this ),
				attributeName = $this.attr( 'name' ),
				attributevalue = $this.val(),
				index,
				attributeTaxName;
		
		
			if ( attributevalue.length === 0 ) {
				index = attributeName.lastIndexOf( '_' );
				attributeTaxName = attributeName.substring( index + 1 );
		
				check = false;
			} else {
				item[attributeName] = attributevalue;
			}
		
		
		} );
		
		console.log(item);
		if ( !check ) {
			return false;
		}
		
		
		var $thisbutton = $( this );

		if ( $thisbutton.is( '.variations_form .single_add_to_cart_button' ) ) {
			var data = {
				action: 'add_cart_ajax',
				product_id: product_id,
				quantity: quantity,
				variation_id: var_id,
				variation: item
			};
			// Ajax action
			jQuery.ajax ({ 
				url: ntt_shop_ajax_object.ajax_url,
				type:'POST',
				data: data,
				beforeSend: function() {
					//jQuery('.cart-dropdown-inner').empty();
			        jQuery('.cart-dropdown').addClass('show-dropdown');
			        jQuery('.cart-dropdown-inner').html('<div class="loading"><div class="loading-bar"></div><div class="loading-bar"></div><div class="loading-bar"></div><div class="loading-bar"></div></div>');
				},
				success:function( results ) {
					//jQuery('.cart-dropdown-inner').empty();
					jQuery('.cart-dropdown-inner').html(results);
					var cartcount = jQuery('.item-count').html();
					jQuery('.cart-totals span.count__number').html(cartcount);
					//jQuery('.single_add_to_cart_button').removeClass('adding-cart');
	                setTimeout(function () { 
	                    jQuery('.cart-dropdown').removeClass('show-dropdown');
	                }, 3000);
				
				}
			});

			return false;

		} else {
			return true;
		}

	});

});
jQuery('.simple_add_to_cart_button').click(function(e) {
	e.preventDefault();
	jQuery(this).addClass('adding-cart');
	var product_id = jQuery(this).val();
	var variation_id = jQuery('input[name="variation_id"]').val();
	var quantity = jQuery('input[name="quantity"]').val();
	console.log(quantity);
    var imgtodrag = jQuery(this);
	jQuery.ajax ({
		url: ntt_shop_ajax_object.ajax_url,  
		type:'POST',
		data:'action=add_cart_ajax&product_id=' + product_id + '&quantity=' + quantity,
		beforeSend: function() {
			jQuery('.cart-dropdown').addClass('show-dropdown');
			jQuery('.cart-dropdown-inner').html('<div class="loading"><div class="loading-bar"></div><div class="loading-bar"></div><div class="loading-bar"></div><div class="loading-bar"></div></div>');
	    },
		success:function(results) {
            jQuery('.cart-dropdown-inner').html(results);
			var cartcount = jQuery('.item-count').html();
			jQuery('.cart-totals span.count__number').html(cartcount);
            setTimeout(function () { 
                jQuery('.cart-dropdown').removeClass('show-dropdown');
            }, 3000);
		}
	});
});