<?php
/**
 * @package jm_css3effects
 * @subpackage plg_content_jm_css3effects
 * @version 1.1 May 2012
 * @author JM-Experts! www.jm-experts.com
 * @copyright Copyright (C) 2006 - 2011 JM-Experts!. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 **/
 
// no direct access
defined( '_JEXEC' ) or die();

jimport( 'joomla.plugin.plugin' );

/**
 * @package jm_css3effects
 * @subpackage plg_content_jm_css3effects
 */
class plgContentjm_css3effects extends JPlugin
{
    function plgContentjm_css3effects ( &$subject ) {
    parent::__construct( $subject );
	}
	
	
	
	
	public function onContentPrepare($context, &$article, &$params, $page = 0)
	{
		// Don't run this plugin when the content is being indexed
		if ($context == 'com_finder.indexer') {
			return true;
		}
		$plugin = JPluginHelper::getPlugin('content', 'jm_css3effects');
		$pluginParams = new JRegistry();
		$pluginParams->loadString($plugin->params);
		$csstype = $pluginParams->get('csstype', 'fullcss'); 
		
		if($csstype=='fullcss'){$stylefile='style.css'; $stylefile_ie='style-ie.css';}
		else{$stylefile='style.compressed.css'; $stylefile_ie='style-ie.compressed.css';}
		
    	// define the regular expression for the bot
    	$regex = "#{jm(.*?)}(.*?){/jm}#s";

    	$matches 	= array();
    	// find all instances of plugin and put in $matches
    	preg_match_all( $regex, $article->text, $matches );

    	// Number of plugins
     	$count = count( $matches[0] );

     	// plugin only processes if there are any instances of the plugin in the text
     	if ( $count ) {
    		
     		$this->plgContentProcessjmimages( $context, &$article, $matches, $count, $regex, $stylefile, $stylefile_ie );
    	}


	}
	
	function plgContentProcessjmimages( $context, &$article, &$matches, $count, $regex, $stylefile, $stylefile_ie) {
    	

        for ( $i=0; $i < $count; $i++ )
    	{	
			$text = '';
	    	$theurl = '';
	    	$thetitle = '';
			$theeffect = 'noeffect';
			$theheight = '';
			$thewidth = '';
			$thefilter = '';
			$theborder = '';
			$theopacity = '';
			$theopacityie = '';
			$theshadow = '';
			$theshape = '';
			$thetint = '';
			$themask = '';
			$thealign = '';

			
			if (@$matches[1][$i]) {
        		$inline_params = $matches[1][$i];

        		// get url
        		$url_matches = array();
        		preg_match( "# url=\"(.*?)\"#s", $inline_params, $url_matches );
        		if (isset($url_matches[1])) $theurl =  $url_matches[1];
				else $theurl = "JavaScript:void(0);";
				
				// get title
        		$title_matches = array();
        		preg_match( "# title=\"(.*?)\"#s", $inline_params, $title_matches );
        		if (isset($title_matches[1])) $thetitle =  $title_matches[1];
				else $thetitle = "";
				
        		// get effect
				$effect_matches = array();
        		preg_match( "# effect=\"(.*?)\"#s", $inline_params, $effect_matches );
        		if (isset($effect_matches[1])) $theeffect =  $effect_matches[1];
				else $theeffect = "noeffect";
		
				// get height
				$height_matches = array();
        		preg_match( "# height=\"(.*?)\"#s", $inline_params, $height_matches );
        		if (isset($height_matches[1])) $theheight =  $height_matches[1];
				else $theheight = "";
		
				// get width
				$width_matches = array();
        		preg_match( "# width=\"(.*?)\"#s", $inline_params, $width_matches );
        		if (isset($width_matches[1])) $thewidth =  $width_matches[1];
				else $thewidth = "";
		
				// get filter
				$filter_matches = array();
        		preg_match( "# filter=\"(.*?)\"#s", $inline_params, $filter_matches );
        		if (isset($filter_matches[1])) $thefilter =  $filter_matches[1];
				else $thefilter = "";

				// get border
				$border_matches = array();
        		preg_match( "# border=\"(.*?)\"#s", $inline_params, $border_matches );
        		if (isset($border_matches[1])) $theborder =  $border_matches[1];
				else $theborder = "";
				
				// get opacity
				$opacity_matches = array();
        		preg_match( "# opacity=\"(.*?)\"#s", $inline_params, $opacity_matches );
        		if (isset($opacity_matches[1])) $theopacity =  $opacity_matches[1];
				else $theopacity = "";
				
				// get shadow
				$shadow_matches = array();
        		preg_match( "# shadow=\"(.*?)\"#s", $inline_params, $shadow_matches );
        		if (isset($shadow_matches[1])) $theshadow =  $shadow_matches[1];
				else $theshadow = "";
				
				// get shape
				$shape_matches = array();
        		preg_match( "# shape=\"(.*?)\"#s", $inline_params, $shape_matches );
        		if (isset($shape_matches[1])) $theshape =  $shape_matches[1];
				else $theshape = "";
				
				// get tint
				$tint_matches = array();
        		preg_match( "# tint=\"(.*?)\"#s", $inline_params, $tint_matches );
        		if (isset($tint_matches[1])) $thetint =  $tint_matches[1];
				else $thetint = "";
				
				// get mask
				$mask_matches = array();
        		preg_match( "# mask=\"(.*?)\"#s", $inline_params, $mask_matches );
        		if (isset($mask_matches[1])) $themask =  $mask_matches[1];
				else $themask = "";
				
				// get align
				$align_matches = array();
        		preg_match( "# align=\"(.*?)\"#s", $inline_params, $align_matches );
        		if (isset($align_matches[1])) $thealign =  $align_matches[1];
				else $thealign = "center";
				
				}
				
				if($thealign=="center")
				{
					$divwidth = 'style="width:'.$thewidth.'px"';
				}
				else
				{
					$divwidth = '';
				}
				
				// get border
				if($theborder!="") { $theborder = 'jm-'.$theborder; }
				
				// get filters
				if($thefilter!="") { $thefilter = 'jm-'.$thefilter; }

				// get shape
				if($theshape!="") { $theshape = 'jm-'.$theshape; }

				//get opacity for all browsers
				if($theopacity!="") {$theopacityie = $theopacity * 100;}
				if($theopacity=="") { $opacity=""; $opacityclass=""; } else {$opacity = 'style="opacity:'.$theopacity.'; filter: alpha(opacity='.$theopacityie.');"'; $opacityclass="jm-opacity";}
				
				// get shadow
				if(($theshadow!="")&&($theshadow=="1")) {$theshadowclass = 'jm-shadow';} else { $theshadowclass = ""; }				
				
				// get image path
				$thepath= trim($matches[2][$i]);
				
				//default values or when missing attributes
				$theeffect=str_replace( ' ',' jm-', $theeffect );
				
				//create html div content
				
				//if mask found
				if(($themask=='style1')||($themask=='style2')||($themask=='style3')||($themask=='style4')||($themask=='style5')||($themask=='style6'))
				{
				// find height and width , if not found then make default
				if($thewidth=="") { $thewidth='300';}
				if($theheight=="") { $theheight='200';}
				$borderwidth = $thewidth / 2;
				$top = $theheight / 4;
				$top2 = $theheight * 2;
				$left = $thewidth / 3;
				$height = $theheight + ($theheight / 2);
				$width = $thewidth + ($thewidth / 2);
				$padding = $width / 4;
				$text .= '<div ';
				$text .= 'class="jm-mask-styled jm-'.$thealign.'align jm-mask-'.$themask.'" style="height:'.$theheight.'px; width:'.$thewidth.'px" '.$divwidth.'>';
				$text .= '<a href="'.$theurl.'" ';
				$text .= 'title="'.$thetitle.'" >';
				$text .= '<img src="'.$thepath.'" ';
				$text .= 'width="'.$thewidth.'" ';
				$text .= 'height="'.$theheight.'" ';
				$text .= 'alt="'.$thetitle.'" />';
				if($themask == 'style1') {$thewidth = 0;}
				if($themask == 'style3')
				{
				$text .= '</a><div class="mask" style="height:'.$theheight / 2 .'px; width:'.$thewidth / 2 .'px;';
				}
				else
				{
				$text .= '</a><div class="mask" style="height:'.$theheight.'px; width:'.$thewidth.'px;';
				}
				if($themask=='style1') { $text .= 'border-width:'.$borderwidth.'px;'; }
				if($themask=='style3') { $text .= 'top:'.$top.'px;'; }
				if($themask=='style3') { $text .= 'left:'.$left.'px;'; }
				if($themask=='style4') { $text .= 'height:'.$height.'px;'; }
				if($themask=='style4') { $text .= 'width:'.$width.'px;'; }
				if($themask=='style4') { $text .= 'padding:'.$padding.'px;'; }
				if($top2=='style6') { $text .= 'top:'.$top2.'px;'; }
				$text .= '"></div></div>';
				}
				
				
				//if tint found
				else if($thetint!="")
				{
				$text .= '<div ';
				
				// check tint is color code or styled
				if(($thetint=='style1')||($thetint=='style2')||($thetint=='style3')||($thetint=='style4')||($thetint=='style5')||($thetint=='style6')||($thetint=='style7')||($thetint=='style8')||($thetint=='style9')||($thetint=='style10')||($thetint=='style11')||($thetint=='style12')||($thetint=='video')||($thetint=='magnify')||($thetint=='photo')||($thetint=='download')||($thetint=='link'))
				{
				$text .= 'class="jm-tint-styled jm-'.$thealign.'align jm-tint-'.$thetint.' '.$theborder.' '.$theshadowclass.'" '.$divwidth.'>';
				$text .= '<a href="'.$theurl.'" ';
				$text .= 'title="'.$thetitle.'" >';
				$text .= '<img src="'.$thepath.'" ';
				$text .= 'width="'.$thewidth.'" ';
				$text .= 'height="'.$theheight.'" ';
				$text .= 'alt="'.$thetitle.'" />';
				$text .= '</a></div>';
				}
				else
				{
				$thetint = str_replace( '#','', $thetint);
				// check tint is color code or color name
				// convert basic color name to thier corresponding hex code
				include_once('colorname2code.php');
				$thetint = str_replace( $thetint,'#'.$thetint, $thetint);
				$text .= 'class="jm-tint jm-'.$thealign.'align '.$theborder.' '.$theshadowclass.'" style="background:'.$thetint.';" '.$divwidth.'>';
				$text .= '<a href="'.$theurl.'" ';
				$text .= 'title="'.$thetitle.'" >';
				$text .= '<img src="'.$thepath.'" ';
				$text .= 'width="'.$thewidth.'" ';
				$text .= 'height="'.$theheight.'" ';
				$text .= 'alt="'.$thetitle.'" />';
				$text .= '</a></div>';				
				}
				}
				else
				{
				$text .= '<div ';
				$text .= 'class="jm-'.$theeffect.' jm-'.$thealign.'align '.$thefilter.' '.$theborder.' '.$opacityclass.' '.$theshadowclass.' '.$theshape.'" '.$divwidth.'>';
				$text .= '<a href="'.$theurl.'" ';
				$text .= 'title="'.$thetitle.'" >';
				$text .= '<img src="'.$thepath.'" ';
				$text .= 'width="'.$thewidth.'" ';
				$text .= 'height="'.$theheight.'" ';
				$text .= 'alt="'.$thetitle.'" '.$opacity.' />';
				$text .= '</a></div>';
				}
			
		$article->text = str_replace( $matches[0][$i], $text, $article->text );
	}
	$pathToJSFolders = JURI::base().'plugins/content/jm_css3effects/jm_css3effects/';
	$stylelink = '<link rel="stylesheet" type="text/css" href="' . $pathToJSFolders . $stylefile .'" />
	<!--[if IE]>
	<link rel="stylesheet" type="text/css" href="' . $pathToJSFolders . $stylefile_ie .'" />
	<![endif]-->';
	$document =& JFactory::getDocument();
	$document->addCustomTag($stylelink);
    }
	
	
}
