// Generated by CoffeeScript 1.6.3
(function() {
	$(function() {
		var brick;
		var flag = false;// 用于防止，商品主图右上角的删除按钮，会同时触发两个事件。会把图片管理也弹出来
		brick = "<div class='brick small'><div class='delete'>&times;</div></div>";
		$(document).on("click", ".gridly .brick", function(event) {
			var $this, size;
			event.preventDefault();
			event.stopPropagation();
			$this = $(this);
			setGoodsFigure($this);
//			 alert(flag);
//			if (!flag) {
				// 写在：NewProductFun.js
				UploadImage(event, ADMINMAIN, $this.attr("js-img"));
				// $this.toggleClass('small');
				// $this.toggleClass('large');
//				if ($this.hasClass('small')) {
//					size = 90;// 原：140	90
//				}
//				if ($this.hasClass('large')) {
//					size = 300;
//				}
//			} else {
//				flag = false;
//			}
			$this.data('width', size);
			$this.data('height', size);
			// $("#file_upload_img_1").css('width', size);
			// $("#file_upload_img_1").css('height', size);
			// $this.children("a").show();
			return $('.gridly').gridly('layout');
		});
		$(document).on(
				"click",
				".gridly .close-modal",
				function(event) {
					var $this;
					event.preventDefault();
					event.stopPropagation();
					$this = $(this);
					if (null != $this.prev().attr("data-id")
							&& "" != $this.prev().attr("data-id")) {
						$this.prev().attr("data-id", "");
						$this.prev().attr("src", ADMINIMG + "/Default.png");
						// $this.hide();
					}
					// flag = true;
					// $this.closest('.brick').remove();
					return $('.gridly').gridly('layout');
				});
//		$(document).on("click", ".add", function(event) {
//			event.preventDefault();
//			event.stopPropagation();
//			$('.gridly').append(brick);
//			return $('.gridly').gridly();
//		});
		return $('.gridly').gridly();
	});

}).call(this);
