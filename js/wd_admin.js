(function ($) {

	$(document).ready(function () {

		if (window.location.href.includes("page=product-reviews")) {
			var role = currentUserData.userRole;
			if (role == "author" || role == "editor") {
				const nonce = $('#_wpnonce').val();
				$('table.product-reviews').find('tbody tr').each(function (_index, element) {
					const id = $(element).attr("id").split("-")[1];
					$(element).children('td.comment').append('<div class="row-actions"><span class="approve"><a href="' + window.location.origin + '/wp-admin/comment.php?c=' + id + '&amp;action=approvecomment&amp;_wpnonce=' + nonce + '">Approve</a href=></span><span class="unapprove"><a href="' + window.location.origin + '/wp-admin/comment.php?c=' + id + '&amp;action=unapprovecomment&amp;_wpnonce=' + nonce + '">Unapprove</a></span><span class="edit"> | <a href="' + window.location.origin + '/wp-admin/comment.php?action=editcomment&amp;c=' + id + '">Edit</a></span><span class="spam"> | <a href="' + window.location.origin + '/wp-admin/comment.php?c=' + id + '&amp;action=spamcomment&amp;_wpnonce=' + nonce + '">Spam</a></span><span class="trash"> | <a href="' + window.location.origin + '/wp-admin/comment.php?c=' + id + '&amp;action=trashcomment&amp;_wpnonce=' + nonce + '">Trash</a></span></div>')
				});
			}
		}

	});

})(jQuery);