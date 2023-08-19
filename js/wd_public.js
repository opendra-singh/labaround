(function ($) {

	$(document).ready(function () {

		if ($(document).find("#woodevz-user-login").val() == "no") {
			$(document).find(".yith-wcwl-add-button").remove();
			$('<span class="woodevz-add-to-whishlist">Add to Wishlist</span>').insertAfter($(document).find(".woocommerce-product-details__short-description"))
		}

		$(document).on("click", ".woodevz-add-to-whishlist", function () {
			alert("If you want to add it to the wishlist, you should become a member.");
		})

	});

})(jQuery);