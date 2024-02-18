
jQuery(document).ready(function() {
	
	jQuery('.mpay24cw-transaction-table .mpay24cw-more-details-button').each(function() {
		jQuery(this).click(function() {
			
			// hide all open 
			jQuery('.mpay24cw-transaction-table').find('.active').removeClass('active');
			
			// Get transaction ID
			var mainRow = jQuery(this).parents('.mpay24cw-main-row');
			var transactionId = mainRow.attr('id').replace('mpay24cw-main_row_', '');
			
			var selector = '.mpay24cw-transaction-table #mpay24cw_details_row_' + transactionId;
			jQuery(selector).addClass('active');
			jQuery(mainRow).addClass('active');
		})
	});
	
	jQuery('.mpay24cw-transaction-table .mpay24cw-less-details-button').each(function() {
		jQuery(this).click(function() {
			// hide all open 
			jQuery('.mpay24cw-transaction-table').find('.active').removeClass('active');
		})
	});
	
});

(function($) {
	
	var Mpay24CwLineItemGrid = {
		decimalPlaces: 2,
		currencyCode: 'EUR',
		
		init: function() {
			this.decimalPlaces = parseFloat($("#mpay24cw-decimal-places").val());
			this.currencyCode = $("#mpay24cw-currency-code").val();
			this.attachListeners();
		},
		
		attachListeners: function() {
			$(".mpay24cw-line-item-grid input.line-item-quantity").each(function() {
				Mpay24CwLineItemGrid.attachListener(this);
			});
			$(".mpay24cw-line-item-grid input.line-item-price-excluding").each(function() {
				Mpay24CwLineItemGrid.attachListener(this);
			});
			$(".mpay24cw-line-item-grid input.line-item-price-including").each(function() {
				Mpay24CwLineItemGrid.attachListener(this);
			});
		},
		
		attachListener: function(element) {
			$(element).change(function() {
				Mpay24CwLineItemGrid.recalculate(this);
			});
			
			$(element).attr('data-before-change', $(element).val());
			$(element).attr('data-original', $(element).val());
		},
		
		recalculate: function(eventElement) {
			var lineItemIndex = $(eventElement).parents('tr').attr('data-line-item-index');
			var row = $('.mpay24cw-line-item-grid tr[data-line-item-index="' + lineItemIndex + '"]');
			var taxRate = parseFloat(row.find('input.tax-rate').val());
				
			var quantity = parseFloat(row.find('input.line-item-quantity').val());
			var quantityBefore = parseFloat(row.find('input.line-item-quantity').attr('data-before-change'));
			if(isNaN(quantity)) {
				quantity = quantityBefore;
			}
			
			var priceExcluding = parseFloat(row.find('input.line-item-price-excluding').val());
			var priceExcludingBefore = parseFloat(row.find('input.line-item-price-excluding').attr('data-before-change'));
			if(isNaN(priceExcluding)) {
				priceExcluding = priceExcludingBefore;
			}
			
			var priceIncluding = parseFloat(row.find('input.line-item-price-including').val());
			var priceIncludingBefore = parseFloat(row.find('input.line-item-price-including').attr('data-before-change'));
			if(isNaN(priceIncluding)) {
				priceIncluding = priceIncludingBefore;
			}
			
			if ($(eventElement).hasClass('line-item-quantity')) {
				if (quantityBefore == 0) {
					quantityBefore = quantity;
					priceExcludingBefore = parseFloat(row.find('input.line-item-price-excluding').attr('data-original'));
				}
				var pricePerItemExcluding = parseFloat(priceExcludingBefore / quantityBefore);
				priceExcluding = quantity * pricePerItemExcluding;
				priceIncluding = (taxRate / 100 + 1) * priceExcluding;
			}
			else if ($(eventElement).hasClass('line-item-price-excluding')) {
				priceIncluding = (taxRate / 100 + 1) * priceExcluding;
			}
			else if ($(eventElement).hasClass('line-item-price-including')) {
				priceExcluding = priceIncluding / (taxRate / 100 + 1);
			}
			
			quantity = quantity.toFixed(2);
			priceExcluding = priceExcluding.toFixed(this.decimalPlaces);
			priceIncluding = priceIncluding.toFixed(this.decimalPlaces);
			
				
			row.find('input.line-item-quantity').val(quantity);
			row.find('input.line-item-price-excluding').val(priceExcluding);
			row.find('input.line-item-price-including').val(priceIncluding);
			
			row.find('input.line-item-quantity').attr('data-before-change', quantity);
			row.find('input.line-item-price-excluding').attr('data-before-change', priceExcluding);
			row.find('input.line-item-price-including').attr('data-before-change', priceIncluding);
			
			// Update total
			var totalAmount = 0;
			$(".mpay24cw-line-item-grid input.line-item-price-including").each(function() {
				totalAmount += parseFloat($(this).val());
			});
			
			$('#line-item-total').html(totalAmount.toFixed(this.decimalPlaces));
			$('#line-item-total').append(" " + this.currencyCode)
		},
		
	};
	
	$(document).ready(function() {
		Mpay24CwLineItemGrid.init();
	});

})(jQuery);