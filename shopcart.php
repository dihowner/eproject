<style>

<!--Fix cart to side bar -->
	.awfm-warp-content {
		color: #fff;
		width: 220px;
		margin-left: 5px;
		z-index: 9999;
		font-size: 12px;
	}
	
	#woo-floating-minicart {
		position: fixed;
		right: -220px;
		top: 15%;
	}
	#woo-floating-minicart {
		z-index: 9999;
		transition: all 1s;
		width: 216px;
		margin-top: 0;
	}
	#woo-floating-minicart-wrapper {
		position: relative;
	}
	#woo-floating-minicart-icon {
		float: left;
		position: absolute;
		left: -56px;
		top: 0px;
	}
	#woo-floating-minicart-icon {
		display: inline-block;
		width: 62px;
	}
	#woo-floating-minicart-icon .cart_contents_count {
		position: absolute;
		top: 0px;
		right: 40px;
	}
	#woo-floating-minicart-icon .cart_contents_count {
		font-size: 12px;
		padding: 1px 7px;
		background-color: #F36557;
		border: 1px solid #F36557;
		border-radius: 20px;
		text-align: center;
		z-index: 1;
		line-height: 1.5;
	}
	#woo-floating-minicart-icon span.cart-icon {
		background-color: #3F9B77;
	}
	#woo-floating-minicart-icon span.cart-icon {
		border-top-left-radius: 50%;
	}
	#woo-floating-minicart-icon span.cart-icon {
		padding: 9px 12px;
		opacity: 0.9;
		cursor: pointer;
		position: absolute;
		top: 0;
	}
	#woo-floating-minicart p.cart-items {
		background: #fff;
	}
	#woo-floating-minicart p.cart-items {
		clear: both;
		color: #fff;
		margin: 0;
		padding: 16px 20px;
		text-align: center;
		font-weight: bold;
		line-height: 1.5;
	}
	#woo-floating-minicart-base {
		background-color: #42a2ce;
	}
	#woo-floating-minicart-base p.buttons {
		text-align: center;
		padding: 10px 0;
		margin: 0;
	}
	#woo-floating-minicart-base p.buttons a.button {
		margin: 0 0 1em 0;
		line-height: 1;
		color: #fff !important;
		background: #71b02f;
		cursor: pointer;
		border: 0;
		text-shadow: none;
		font-size: .9em;
		font-weight: 600;
		text-align: center;
		text-decoration: none !important;
		text-transform: uppercase;
		outline: 0 !important;
		padding: 8px 15px;
		border-radius: 100px;
	}
	#woo-floating-minicart-base p.buttons a.button {
		background: #71b02f;
	}
</style>

<div class="awfm-warp-content">

    <div id="woo-floating-minicart" class="woo-floating-minicart">

        <div id="woo-floating-minicart-wrapper">

            <div id="woo-floating-minicart-icon">
                <span class="cart_contents_count">0</span>
                <span class="cart-icon">
					<a href="cart">
                        <img src="assets/images/basketg.png" title="Shopping Basket" alt="My Cart" height="32" width="32">
                    </a>
				</span>
            </div><!-- END .woo-floating-minicart-inactive -->

        </div>
    </div> <!-- END .woo-floating-minicart-active -->
</div>

<script>
	$(document).ready(function() {
	
		//reloading walletbalance after 1 second
		load_data = {'fetch':1};
		
		//count cart into topnav bag
		window.setInterval(function(){
			$.post('addcart.php?countCart', load_data,  function(data) {
				$('.cart_contents_count').html(data);
			});
		}, 1000);
		
	});
</script>