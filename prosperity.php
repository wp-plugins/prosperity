<?php
/**
 * @package Prosperity_Plugin
 * @version 1.5
 */
/*
Plugin Name: Prosperity
Description: When activated you will randomly see prosperity scriptures in posts with shortcode and in the upper right of your admin screen on every page. See admin panel for shortcode to display scriptures in posts.
Author: Tyson Hahn
Version: 1.5
Author URI: http://labs.hahncreativegroup.com/wordpress-plugins/prosperity/
*/

function prosperity_get_verses() {
	$verse = array(
		"The Lord is my Shepard [to feed, guide, and shield me], I shall not lack. - <em>Psalm 23:1</em>",
		"If you are willing and obedient, you shall eat the good of the land; - <em>Isaiah 1:19</em>",
		"Delight yourself also in the Lord, and He will give you the desires <em>and</em> secret petitions of your heart. - <em>Psalm 37:4</em>",		
		"He who gives to the poor will not lack, But he who hides his eyes will have many curses. - <em>Proverbs 28:27</em>",
		"And my God will liberally supply (fill to the full) your every need according to His riches in glory in Christ Jesus. - <em>Philippians 4:19</em>",		
		"The generous soul will be made rich, And he who waters will also be watered himself. - <em>Proverbs 11:25</em>",
		"He who did not withhold <em>or</em> spare [even] His own Son but gave Him up for us all, will He not also with Him freely <em>and</em> graciously give us all [other] things? - <em>Romans 8:32</em>",
		"He who has pity on the poor lends to the LORD, And He will pay back what he has given. - <em>Proverbs 19:17</em>",
		"And as for you, be fruitful and multiply; bring forth abundantly in the earth and multiply in it. - <em>Genesis 9:7</em>",
		"But this I say: He who sows sparingly will also reap sparingly, and he who sows bountifully will also reap bountifully. - <em>2 Corinthians 9:6</em>",		
		"And his master saw that the Lord was with him and that the Lord made all he did to prosper in his hand. - <em>Genesis 39:3</em>",
		"And you shall remember the Lord your God, for it is He who gives you power to get wealth, that He may establish His covenant which He swore to your fathers, as it is this day. - <em>Deuteronomy 8:18</em>",
		"Blessed shall you be in the city, and blessed shall you be in the country. - <em>Deuteronomy 28:3</em>",
		"Blessed shall you be when you come in, and blessed shall you be when you go out. - <em>Deuteronomy 28:6</em>",
		"The Lord will open to you His good treasure, the heavens, to give the rain to your land in its season, and to bless all the work of your hand. You shall lend to many nations, but you shall not borrow. - <em>Deuteronomy 28:12</em>",
		"Therefore keep the words of this covenant, and do them, that you may prosper in all that you do. - <em>Deuteronomy 29:9</em>",
		"The young lions lack and suffer hunger; But those who seek the Lord shall not lack any good thing. - <em>Psalm 34:10</em>",
		"He who has a bountiful eye will be blessed, for he gives of his bread to the poor. <em>Proverbs 22:9</em>",
		"And God is able to make all grace abound toward you, that you, always having all sufficiency in all things, have an abundance for every good work. - <em>2 Corinthians 9:8</em>",
		"Give, and it will be given to you: good measure, pressed down, shaken together, and running over will be put into your bosom. For with the same measure that you use, it will be measured back to you. - <em>Luke 6:38</em>"
				   );	

	// get random index number	
	$index = mt_rand( 0, count( $verse ) - 1 );
	
	// And then randomly choose a line
	return wptexturize( $verse[ $index ] );
}

// This just echoes the chosen line, we'll position it later
function prosperity() {
	$chosen = prosperity_get_verses();
	$extra = "<br><a href=\"http://lifetoday.org/outreaches/\" target=\"_blank\">Give to an outreach</a>";
	echo "<p id='prosper'>".$chosen.$extra."</p>";
}

// Now we set that function up to execute when the admin_notices action is called
add_action( 'admin_notices', 'prosperity' );

// We need some CSS to position the paragraph
function prosperity_css() {
	// This makes sure that the positioning is also good for right-to-left languages
	$x = is_rtl() ? 'left' : 'right';

	echo "
	<style type='text/css'>
	#prosper {
		float: $x;
		padding-$x: 15px;
		padding-top: 5px;		
		margin: 0;
		font-size: 11px;
		text-align: $x;
	}
	</style>
	";
}
add_action( 'admin_head', 'prosperity_css' );

// Taken from Google XML Sitemaps from Arne Brachhold
function add_prosperity_plugin_links($links, $file) {
	
	if ( $file == plugin_basename(__FILE__) ) {			
		$links[] = '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=YEM6BT83GHFD4">' . __('Donate', 'prosperity') . '</a>';
		$links[] = '<a href="http://lifetoday.org/outreaches/">' . __('Outreaches', 'prosperity') . '</a>';
		
	}
	return $links;
}
	
//Add some links on the plugin page
add_filter('plugin_row_meta', 'add_prosperity_plugin_links', 10, 2);

function displayProsperity() {
	$chosen = prosperity_get_verses();
	return "<p>$chosen</p>";
}

//Add shortcode to display scripture in content
function Prosperity_Handler() {
	return displayProsperity();
}
add_shortcode('Prosperity', 'Prosperity_Handler');

// Create Admin Panel
function add_Prosperity_menu()
{
	add_menu_page(__('Prosperity','menu-Prosperity'), __('Prosperity','menu-Prosperity'), 'manage_options', 'Prosperity-admin', 'showProsperityMenu' );
}

add_action( 'admin_menu', 'add_Prosperity_menu' );

function showProsperityMenu()
{
	//include("admin/overview.php");
	?>
    	<div id='wrap'>
        	<h2>Prosperity</h2>
            <p><strong>Shortcodes</strong></p>
            <p><code>[Prosperity]</code> - Adding this shortcode to any of your posts will also display random prosperity scriptures to your visitors.</p>
            <br />
            <p><em>Please consider donating to the continued development of this plugin. Thanks.</em></p>
            <p><a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=YEM6BT83GHFD4" target="_blank"><img src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" alt="PayPal - The safer, easier way to pay online!"><img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1"></a></p>
            <br />
            <p><em>Also consider giving to one of these amazing outreaches</em></p>
            <p><a href="http://lifetoday.org/outreaches/" target="_blank">LIFE today Outreaches</a></p>            
            <p><a href="http://www.jentezenfranklin.org/outreach/" target="_blank">Jentzen Franklin Ministries Outreaches</a></p>
        </div>    
    <?php
}

?>
