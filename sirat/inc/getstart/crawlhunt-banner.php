<?php
/**
 * Crawl Hunt banner shown below the demo import box.
 */
?>
<style>
.crawlhunt-promo{display:flex;flex-wrap:wrap;align-items:center;gap:24px;margin:24px 0 0;text-align:left;clear:both}
.crawlhunt-promo *{box-sizing:border-box}
.crawlhunt-promo__media{flex:1 1 260px;text-align:center}
.crawlhunt-promo__media img{max-width:100%;height:auto}
.crawlhunt-promo__card{flex:1.4 1 420px;display:flex;flex-wrap:wrap;align-items:center;gap:16px;background:#fff;padding:20px;box-shadow:0 2px 6px rgba(0,0,0,.25)}
.crawlhunt-promo__content{flex:1 1 230px}
.crawlhunt-promo__logo{width:150px;max-width:100%;height:auto;display:block;margin-bottom:10px}
.crawlhunt-promo h2{font-size:26px;line-height:1.25;font-weight:700;color:#111;margin:0 0 12px;padding:0}
.crawlhunt-promo h2 span{color:#2563eb}
.crawlhunt-promo ul{list-style:none;margin:0 0 16px;padding:0}
.crawlhunt-promo li{position:relative;padding-left:22px;margin:0 0 6px;font-size:15px;color:#222}
.crawlhunt-promo li:before{content:"";position:absolute;left:0;top:2px;width:16px;height:16px;background:url(<?php echo esc_url( get_theme_file_uri( 'inc/getstart/images/crawl-bullets.png' ) ); ?>) no-repeat center/contain}
.crawlhunt-promo__btns{display:flex;flex-wrap:wrap;gap:8px}
.crawlhunt-promo a.crawlhunt-btn{display:inline-block;background:#2563eb;color:#fff;padding:9px 16px;font-size:14px;font-weight:600;text-decoration:none;border-radius:2px;width:170px;text-align:center}
.crawlhunt-promo a.crawlhunt-btn:hover,.crawlhunt-promo a.crawlhunt-btn:focus{background:#1d4ed8;color:#fff}
.crawlhunt-promo__shot{flex:1 1 200px;max-width:260px;margin:0 auto;text-align:center}
.crawlhunt-promo__shot img{max-width:100%;height:auto;display:block}
.crawlhunt-promo a.crawlhunt-btn--scan{background:#2563eb}
.crawlhunt-promo a.crawlhunt-btn--scan:hover,.crawlhunt-promo a.crawlhunt-btn--scan:focus{background:#1d4ed8}
.crawlhunt-promo a.crawlhunt-btn--learn{background:#f97316}
.crawlhunt-promo a.crawlhunt-btn--learn:hover,.crawlhunt-promo a.crawlhunt-btn--learn:focus{background:#ea580c}
</style>
<div class="crawlhunt-promo">
	<div class="crawlhunt-promo__media">
		<img src="<?php echo esc_url( get_theme_file_uri( 'inc/getstart/images/responsive.png' ) ); ?>" alt="<?php esc_attr_e( 'Responsive Image', 'sirat' ); ?>" />
	</div>
	<div class="crawlhunt-promo__card">
		<div class="crawlhunt-promo__content">
			<img class="crawlhunt-promo__logo" src="<?php echo esc_url( get_theme_file_uri( 'inc/getstart/images/logo-full-sm.png' ) ); ?>" alt="<?php esc_attr_e( 'Crawl Hunt', 'sirat' ); ?>" />
			<h2><?php esc_html_e( 'Fix Your Website SEO with The', 'sirat' ); ?> <span><?php esc_html_e( 'Power of AI', 'sirat' ); ?></span></h2>
			<ul>
				<li><?php esc_html_e( 'Auto-fix SEO issues', 'sirat' ); ?></li>
				<li><?php esc_html_e( 'Optimize for Google & AI Search', 'sirat' ); ?></li>
				<li><?php esc_html_e( 'Improve rankings & traffic', 'sirat' ); ?></li>
			</ul>
			<div class="crawlhunt-promo__btns">
				<?php if ( function_exists( 'is_plugin_active' ) && is_plugin_active( 'crawl-hunt-seo-audit-tool/crawl-hunt.php' ) ) : ?>
					<a href="<?php echo esc_url( admin_url( 'admin.php?page=crawl-hunt' ) ); ?>" class="crawlhunt-btn crawlhunt-btn--scan"><?php esc_html_e( 'Start Free SEO Scan', 'sirat' ); ?></a>
				<?php endif; ?>
				<a href="<?php echo esc_url( 'https://www.crawlhunt.com/' ); ?>" class="crawlhunt-btn crawlhunt-btn--learn" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Learn More', 'sirat' ); ?></a>
			</div>
		</div>
		<div class="crawlhunt-promo__shot">
			<img src="<?php echo esc_url( get_theme_file_uri( 'inc/getstart/images/crawlhunt-img.png' ) ); ?>" alt="" />
		</div>
	</div>
</div>
