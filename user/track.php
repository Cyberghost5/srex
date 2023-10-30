<?php include 'includes/head-user.php'; ?>
<link rel="stylesheet" href="<?php echo $settings['site_url']; ?>styles/track.css" />
	<body class="main-dashboard">
		<div class="mobile-overlay" onclick="handleMobileOverLay()"></div>
		<side-bar><?php include 'includes/side-bar.php'; ?></side-bar>
		<section class="main-body">
			<header-bar><?php include 'includes/top-bar.php'; ?></header-bar>

			<div class="main">
            <article class="trackArticle1">
                <h2>Track your shipment</h2>
                <p>Enter the tracking number for your shipment</p>
                <form>
                    <div>
                        <img src="<?php echo $settings['site_url']; ?>assets/images/search-icon.svg" alt="" />
                        <input
                            type="search"
                            name="trackingNo"
                            id="trackingNo"
                            placeholder="Tracking number"
                        />
                    </div>
                    <button type="submit" class="button">Track</button>
                </form>
            </article>
            </div>
		</section>
	</body>
</html>
