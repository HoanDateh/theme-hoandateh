<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 31/05/2010, 00:36
 */

if( ! defined( 'NV_SYSTEM' ) or ! defined( 'NV_MAINFILE' ) ) die( 'Stop!!!' );

function nv_site_theme( $contents, $full = true )
{
	global $home, $array_mod_title, $lang_global, $language_array, $global_config, $site_mods, $module_name, $module_info, $op_file, $mod_title, $my_head, $my_footer, $client_info, $module_config, $op;

	// Determine tpl file, check exists tpl file
	$layout_file = ( $full ) ? 'layout.' . $module_info['layout_funcs'][$op_file] . '.tpl' : 'simple.tpl';

	$responsive = ( $global_config['current_theme_type'] == 'r' ) ? true : false;

	if( ! file_exists( NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/layout/' . $layout_file ) )
	{
		nv_info_die( $lang_global['error_layout_title'], $lang_global['error_layout_title'], $lang_global['error_layout_content'] );
	}

	if( isset( $global_config['sitetimestamp'] ) )
	{
		$global_config['timestamp'] += $global_config['sitetimestamp'];
	}

	$css = nv_html_css();

	// Css for admin
	if( defined( 'NV_IS_ADMIN' ) and $full )
	{
		$css .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"" . NV_BASE_SITEURL . "themes/" . $global_config['module_theme'] . "/css/admin.css\" />\n";
	}

    // Style config
    if ( isset( $module_config['themes'][$global_config['module_theme']] ) )
	{
		if ( ! file_exists( NV_ROOTDIR . '/' . SYSTEM_FILES_DIR . '/css/theme_' . $global_config['module_theme'] . '_' . $global_config['idsite'] . '.css' ) )
    	{
			$config_theme = unserialize( $module_config['themes'][$global_config['module_theme']] );
		    $css_content = nv_css_setproperties( 'body', $config_theme['body'] );
		    $css_content .= nv_css_setproperties( 'a, a:link, a:active, a:visited', $config_theme['a_link'] );
		    $css_content .= nv_css_setproperties( 'a:hover', $config_theme['a_link_hover'] );
		    $css_content .= nv_css_setproperties( '#wraper', $config_theme['content'] );
		    $css_content .= nv_css_setproperties( '#header, #banner', $config_theme['header'] );
		    $css_content .= nv_css_setproperties( '#footer', $config_theme['footer'] );
			$css_content .= nv_css_setproperties( '.panel, .well, .nv-block-banners', $config_theme['block'] );
			$css_content .= nv_css_setproperties( '.panel-default>.panel-heading', $config_theme['block_heading'] );
		    $css_content .= nv_css_setproperties( 'generalcss', $config_theme['generalcss'] ); // Không nên thay đổi "generalcss"

		    file_put_contents( NV_ROOTDIR . '/' . SYSTEM_FILES_DIR . '/css/theme_' . $global_config['module_theme'] . '_' . $global_config['idsite'] . '.css', $css_content );

			unset( $config_theme, $css_content );
    	}
	    $my_footer .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"" . NV_BASE_SITEURL . SYSTEM_FILES_DIR . "/css/theme_" . $global_config['module_theme'] . "_" . $global_config['idsite'] . ".css?t=" . $global_config['timestamp'] . "\" />\n";
	}

	$xtpl = new XTemplate( $layout_file, NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/layout' );
	$xtpl->assign( 'LANG', $lang_global );
	$xtpl->assign( 'TEMPLATE', $global_config['module_theme'] );
	$xtpl->assign( 'NV_BASE_SITEURL', NV_BASE_SITEURL );

	$xtpl->assign( 'NV_SITE_COPYRIGHT', $global_config['site_name'] . ' [' . $global_config['site_email'] . '] ' );
	$xtpl->assign( 'NV_SITE_NAME', $global_config['site_name'] );
	$xtpl->assign( 'NV_SITE_TITLE', $global_config['site_name'] . ' ' . NV_TITLEBAR_DEFIS . ' ' . $lang_global['admin_page'] . ' ' . NV_TITLEBAR_DEFIS . ' ' . $module_info['custom_title'] );
	$xtpl->assign( 'SITE_DESCRIPTION', $global_config['site_description'] );
	$xtpl->assign( 'NV_CHECK_PASS_MSTIME', (intval( $global_config['user_check_pass_time'] ) - 62) * 1000 );
	$xtpl->assign( 'MODULE_NAME', $module_name );
	$xtpl->assign( 'NV_LANG_VARIABLE', NV_LANG_VARIABLE );
	$xtpl->assign( 'NV_LANG_INTERFACE', NV_LANG_INTERFACE );
	$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
	$xtpl->assign( 'NV_OP_VARIABLE', NV_OP_VARIABLE );
	$xtpl->assign( 'NV_SITE_TIMEZONE_OFFSET', round( NV_SITE_TIMEZONE_OFFSET / 3600 ) );
	$xtpl->assign( 'NV_CURRENTTIME', nv_date( 'T', NV_CURRENTTIME ) );
	$xtpl->assign( 'NV_COOKIE_PREFIX', $global_config['cookie_prefix'] );

	$xtpl->assign( 'LANG_TIMEOUTSESS_NOUSER', $lang_global['timeoutsess_nouser'] );
	$xtpl->assign( 'LANG_TIMEOUTSESS_CLICK', $lang_global['timeoutsess_click'] );
	$xtpl->assign( 'LANG_TIMEOUTSESS_SEC', $lang_global['sec'] );
	$xtpl->assign( 'LANG_TIMEOUTSESS_TIMEOUT', $lang_global['timeoutsess_timeout'] );
	$xtpl->assign( 'MSGBEFOREUNLOAD', $lang_global['msgbeforeunload'] );

	// System variables
	$xtpl->assign( 'THEME_PAGE_TITLE', nv_html_page_title() );
	$xtpl->assign( 'THEME_META_TAGS', nv_html_meta_tags() );
	$xtpl->assign( 'THEME_SITE_RSS', nv_html_site_rss() );
	$xtpl->assign( 'THEME_CSS', $css );
	$xtpl->assign( 'THEME_SITE_JS', nv_html_site_js() );
	$xtpl->assign( 'THEME_RESPONSIVE', (int) $responsive );
	if( $responsive )
	{
		$xtpl->parse( 'main.viewport' );
		$xtpl->parse( 'main.responsive' );
	}
	else
	{
		$xtpl->parse( 'main.non_responsive' );
	}

	// Module contents
	$xtpl->assign( 'MODULE_CONTENT', $contents );

	// Header variables
	$xtpl->assign( 'SITE_NAME', $global_config['site_name'] );
	$xtpl->assign( 'THEME_SITE_HREF', NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA );
	$xtpl->assign( 'LOGO_SRC', NV_BASE_SITEURL . $global_config['site_logo'] );
	$size = @getimagesize( NV_ROOTDIR . '/' . $global_config['site_logo'] );
	$xtpl->assign( 'LOGO_WIDTH', $size[0] );
	$xtpl->assign( 'LOGO_HEIGHT', $size[1] );

	if( isset( $size['mime'] ) and $size['mime'] == 'application/x-shockwave-flash' )
	{
		$xtpl->parse( 'main.swf' );
	}
	else
	{
		$xtpl->parse( 'main.image' );
	}

	if( $op == 'main' ) $xtpl->parse( 'main.main_h1' );
	else  $xtpl->parse( 'main.main_none_h1' );
	// Only full theme
	if( $full )
	{
		// Search form variables
		$xtpl->assign( 'THEME_SEARCH_QUERY_MAX_LENGTH', NV_MAX_SEARCH_LENGTH );
		$xtpl->assign( 'THEME_SEARCH_SUBMIT_ONCLICK', "nv_search_submit('topmenu_search_query', 'topmenu_search_submit', " . NV_MIN_SEARCH_LENGTH . ", " . NV_MAX_SEARCH_LENGTH . ");" );

		// Breadcrumbs
		if( $home != 1 )
		{
			if( $global_config['rewrite_op_mod'] != $module_name )
			{
				$arr_cat_title_i = array(
					'catid' => 0,
					'title' => $module_info['custom_title'],
					'link' => NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name
				);
				array_unshift( $array_mod_title, $arr_cat_title_i );
			}
			if( ! empty( $array_mod_title ) )
			{
				foreach( $array_mod_title as $arr_cat_title_i )
				{
					$xtpl->assign( 'BREADCRUMBS', $arr_cat_title_i );
					$xtpl->parse( 'main.breadcrumbs.loop' );
				}
				$xtpl->parse( 'main.breadcrumbs' );
			}
		}

		// Statistics image
		$theme_stat_img = '';
		if( $global_config['statistic'] and isset( $site_mods['statistics'] ) )
		{
			$theme_stat_img .= "<a title=\"" . $lang_global['viewstats'] . "\" href=\"" . NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=statistics\"><img alt=\"" . $lang_global['viewstats'] . "\" src=\"" . NV_BASE_SITEURL . "index.php?second=statimg&amp;p=" . nv_genpass() . "\" width=\"88\" height=\"31\" /></a>\n";
		}

		$xtpl->assign( 'THEME_STAT_IMG', $theme_stat_img );

		// Change theme types
		$mobile_theme = empty( $module_info['mobile'] ) ?  $global_config['mobile_theme'] : $module_info['mobile'];
		if( empty( $mobile_theme ) or empty( $global_config['switch_mobi_des'] ))
		{
			$array_theme_type  = array_diff( $global_config['array_theme_type'], array( 'm' ) );
		}
		else
		{
			$array_theme_type = $global_config['array_theme_type'];
		}
		$num_theme_type = sizeof( $array_theme_type ) - 1;
		foreach( $array_theme_type as $i => $theme_type )
		{
			$xtpl->assign( 'STHEME_TYPE', NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;nv' . NV_LANG_DATA . 'themever=' . $theme_type . '&amp;nv_redirect=' . nv_base64_encode( $client_info['selfurl'] ) );
			$xtpl->assign( 'STHEME_TITLE', $lang_global['theme_type_' . $theme_type] );
			$xtpl->assign( 'STHEME_INFO', sprintf( $lang_global['theme_type_chose'], $lang_global['theme_type_' . $theme_type] ) );

			if( $theme_type == $global_config['current_theme_type'] )
			{
				$xtpl->parse( 'main.theme_type.loop.current' );
			}
			else
			{
				$xtpl->parse( 'main.theme_type.loop.other' );
			}

			if( $i < $num_theme_type ) $xtpl->parse( 'main.theme_type.loop.space' );

			$xtpl->parse( 'main.theme_type.loop' );
		}
		$xtpl->parse( 'main.theme_type' );
	}

	$xtpl->parse( 'main' );
	$sitecontent = $xtpl->text( 'main' );

	// Only full theme
	if( $full )
	{
		$sitecontent = nv_blocks_content( $sitecontent );
		$sitecontent = str_replace( '[THEME_ERROR_INFO]', nv_error_info(), $sitecontent );

		if( defined( 'NV_IS_ADMIN' ) )
		{
			$my_footer = nv_admin_menu() . $my_footer;
		}
	}

	if( ! empty( $my_head ) ) $sitecontent = preg_replace( '/(<\/head>)/i', $my_head . '\\1', $sitecontent, 1 );
	if( ! empty( $my_footer ) ) $sitecontent = preg_replace( '/(<\/body>)/i', $my_footer . '\\1', $sitecontent, 1 );

	return $sitecontent;
}