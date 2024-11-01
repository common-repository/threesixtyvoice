<?php
/*
Plugin Name: ThreeSixtyVoice
Version: 2.0
Plugin URI: http://www.stevey.eu/threesixtyvoice
Description: Get Various information from your (<a href="http://www.360voice.com/">360voice.com</a>) blog <br /> Based on the original "360voice API" concept by <a href="http://www.squidpunch.com/">David 'Squidpunch' Larrabee</a>, modified and rewritten in places to allow for correct validation, and general cleanliness of code.
Author: S Rose (stevey[dot]eu)
Author URI: http://www.stevey.eu
*/
/*
++++++++++++++++++++++++++++++++++++++++
	Version History
++++++++++++++++++++++++++++++++++++++++
2.0 - Released 09/25/08 
- Removed uneccesary print elements for stylesheets and associated functions, the elements will now take on the style of your site.
- Options page cleaned up, rearranged, reworded.
- Options for header color and block spacing removed for the time being. (See above)
- Removed oversized "get this plugin" advert, replaced with much smaller, unintrusive text link.
- Renamed the actual widget to not contain numbers, avoiding conflicts with list elements.
- General cleanup with validation/load times in mind.

++++++++++++++++++++++++++++++++++++++++
	Prior to adaptation
++++++++++++++++++++++++++++++++++++++++
1.2 - Released 03/25/08
1.1 - Released 04/10/07  
1.0 - Released 01/31/07
0.1 - Released 11/29/06
*/

$StyleWritten = false;
function GetThisPromo() {
    print "<div class=\"voiceheader\"></div>";
        print "<div class=\"voicedetails\" style=\"text-align: right;\"><a href=\"http://www.stevey.eu/threesixtyvoice/\"><small>Get This Plugin »</small></a></div>";
	}
function ShowVoiceData(){
  GetBadges();
  GetMostRecentBlogEntries(1);
  GetFavoriteGames();
  GetLeaderBoards();
  GetCompletes();
  GetThisPromo();
}
function GetPointsBreakDown() {
  Global $StyleWritten;
    $itemCount = 0;
    $gamertag = get_option('VoiceAPIgamertag');
    //$buffer = GetRemoteXML("www.360voice.com","/api/score-getlist.asp?tag=".urlencode($gamertag));
    $buffer = GetRemoteXML("www.360voice.com","/api/gamertag-leaderboard.asp?tag=".urlencode($gamertag));
	print $buffer;
    while (strpos($buffer, "<score>") > 0) {
      $start = strpos($buffer, "<value>");
      $len = strpos($buffer, "</value>", $start) - $start;
      $scoreamount = substr($buffer, $start, $len);
      $start = strpos($buffer, "<date>");
      $len = strpos($buffer, "</date>", $start) - $start;
      $scoredate = substr($buffer, $start, $len);
      //truncate the full XML (so this badge isnt there any longer)
      $buffer = substr($buffer, $start+$len);
      $arItems[$itemCount][0] = $scoreamount; 
      $arItems[$itemCount][1] = $scoredate; 
      $itemCount++;
    }
    print "<div class=\"voiceheader\"><strong>My 360Voice Scores</strong></div>";
    print "<div class=\"voicedetails\" style=\"text-align: center;\">";
    for ( $row = 0; $row < count($arItems); $row++ )
    {
      print $arItems[$row][0] . " : " . $arItems[$row][1] . "<BR \>";
    }
    print "</div>";
}
function GetLeaderBoards() { 
  Global $StyleWritten;

  if (get_option('VoiceAPIDisplayLeaderBoards') == 'True') {

    $itemCount = 0;
    $gamertag = get_option('VoiceAPIgamertag');
    $buffer = GetRemoteXML("www.360voice.com","/api/gamertag-leaderboard.asp?tag=".urlencode($gamertag));
    $start = strpos($buffer, "<leaderboard name=\"gs\">");
    $len = strpos($buffer, "</leaderboard>", $start) - $start;
    $entry= substr($buffer, $start, $len);
    $buffer = substr($buffer, $start+$len);

    $start = strpos($entry, "<name>");
    $len = strpos($entry, "</name>", $start) - $start;
    $arItems[$itemCount][0] = substr($entry, $start + strlen("<name>"), $len - strlen("</name>") + 1); 

    $start = strpos($entry, "<rank>");
    $len = strpos($entry, "</rank>", $start) - $start;
    $arItems[$itemCount][1] = substr($entry, $start + strlen("<rank>"), $len - strlen("</rank>") + 1); 

    $start = strpos($entry, "<url>");
    $len = strpos($entry, "</url>", $start) - $start;
    $arItems[$itemCount][2] = substr($entry, $start + strlen("<url>"), $len - strlen("</url>") + 1); 

  $itemCount++;

    $start = strpos($buffer, "<leaderboard name=\"gsc\">");
    $len = strpos($buffer, "</leaderboard>", $start) - $start;
    $entry= substr($buffer, $start, $len);
    $buffer = substr($buffer, $start+$len);
 
    $start = strpos($entry, "<name>");
    $len = strpos($entry, "</name>", $start) - $start;
    $arItems[$itemCount][0] = substr($entry, $start + strlen("<name>"), $len - strlen("</name>") + 1); 

    $start = strpos($entry, "<rank>");
    $len = strpos($entry, "</rank>", $start) - $start;
    $arItems[$itemCount][1] = substr($entry, $start + strlen("<rank>"), $len - strlen("</rank>") + 1); 

    $start = strpos($entry, "<url>");
    $len = strpos($entry, "</url>", $start) - $start;
    $arItems[$itemCount][2] = substr($entry, $start + strlen("<url>"), $len - strlen("</url>") + 1); 


  $itemCount++;

    $start = strpos($buffer, "<leaderboard name=\"mpg\">");
    $len = strpos($buffer, "</leaderboard>", $start) - $start;
    $entry= substr($buffer, $start, $len);
    $buffer = substr($buffer, $start+$len);

    $start = strpos($entry, "<name>");
    $len = strpos($entry, "</name>", $start) - $start;
    $arItems[$itemCount][0] = substr($entry, $start + strlen("<name>"), $len - strlen("</name>") + 1); 

    $start = strpos($entry, "<rank>");
    $len = strpos($entry, "</rank>", $start) - $start;
    $arItems[$itemCount][1] = substr($entry, $start + strlen("<rank>"), $len - strlen("</rank>") + 1); 

    $start = strpos($entry, "<url>");
    $len = strpos($entry, "</url>", $start) - $start;
    $arItems[$itemCount][2] = substr($entry, $start + strlen("<url>"), $len - strlen("</url>") + 1); 
 
    print "<div class=\"voiceheader\"><strong>360Voice Leaderboards</strong></div>";
    print "<div class=\"voicedetails\">";
    for ( $row = 0; $row < count($arItems); $row++ )
    {
      print $arItems[$row][0] . ": <a href=\"" . $arItems[$row][2] . "\">" . $arItems[$row][1] . "</a><BR>";
    }
    print "<br /><br /></div>";

  }
}
function GetMostRecentBlogEntries() {
  Global $StyleWritten;

  if (get_option('VoiceAPIDisplayBlogs') == 'True') {
    $itemCount = 0;

    $gamertag = get_option('VoiceAPIgamertag');
    $limit = get_option('VoiceAPInumblogs');
    $buffer = GetRemoteXML("www.360voice.com","/api/blog-getentries.asp?tag=".urlencode($gamertag) . "&num=" . $limit);

    while (strpos($buffer, "<entry") > 0) {
      $start = strpos($buffer, "<entry");
      $len = strpos($buffer, "</entry>", $start) - $start;
      $entry= substr($buffer, $start, $len);
      $buffer = substr($buffer, $start+$len);

      $start = strpos($entry, "<date>");
      $len = strpos($entry, "</date>", $start) - $start;
      $arItems[$itemCount][0] = substr($entry, $start + strlen("<date>"), $len - strlen("</date>") + 1); 

      $start = strpos($entry, "<link>");
      $len = strpos($entry, "</link>", $start) - $start;
      $arItems[$itemCount][1] = substr($entry, $start + strlen("<link>"), $len - strlen("</link>") + 1); 

      $start = strpos($entry, "<title>");
      $len = strpos($entry, "</title>", $start) - $start;
      $arItems[$itemCount][2] = substr($entry, $start + strlen("<title>"), $len - strlen("</title>") + 1); 

      $start = strpos($entry, "<body>");
      $len = strpos($entry, "</body>", $start) - $start;
      $arItems[$itemCount][3] = substr($entry, $start + strlen("<body>"), $len - strlen("</body>") + 1); 
      $itemCount++;
    }
    if ($limit == 1) {
      print "<div class=\"voiceheader\"><strong><a href=\"http://www.360Voice.com/\" title=\"360Voice\">360Voice</a> Blog</strong></div><br />";
    } else {
      print "<div class=\"voiceheader\"><strong><a href=\"http://www.360Voice.com/\" title=\"360Voice\">360Voice</a> Blog</strong></div>";
    }
    print "<div class=\"voicedetails\">";
    for ( $row = 0; $row < count($arItems); $row++ )
    {
      $titletag = $arItems[$row][2];
      $titletag = str_replace("&apos;", "'", $titletag );

      print "<div><a href=\"" . $arItems[$row][1] . "\">" . $titletag . "</a><br /><br /></div>";
      $bodytag = $arItems[$row][3];
      $bodytag = str_replace("&lt;", "<", $bodytag );
      $bodytag = str_replace("&quot;", "\"", $bodytag );
      $bodytag = str_replace("&gt;", ">", $bodytag );
      $bodytag = str_replace("&apos;", "'", $bodytag );
      $bodytag = str_replace("&#60;", "<", $bodytag );
      $bodytag = str_replace("&#62;", ">", $bodytag );
      $bodytag = str_replace("&quot;", "\"", $bodytag );
      $bodytag = str_replace("&apos;", "'", $bodytag );
      print "<div>" . $bodytag . "</div>";
      if ($row < count($arItems) -1) { print "<div>--</div>"; }
    }
    print "<br /><br /></div>";
  }
}
function GetBadges() {
  Global $StyleWritten;

  if (get_option('VoiceAPIDisplayBadges') == 'True') {
    $gamertag = get_option('VoiceAPIgamertag');
    $itemCount = 0;
    $buffer = GetRemoteXML("www.360voice.com","/api/gamertag-badges.asp?tag=".urlencode($gamertag));

    while (strpos($buffer, "<badge>") > 0) {
      //Grab the badge from the XML
      $start = strpos($buffer, "<badge>");
      $len = strpos($buffer, "</badge>", $start) - $start;
      $badgetext = substr($buffer, $start, $len);
      //Truncate the full XML (so this badge isnt there any longer)
      $buffer = substr($buffer, $start+$len);
      //Parse the required parts
      $start = strpos($badgetext, "<title>");
      $len = strpos($badgetext, "</title>", $start) - $start;
      $arItems[$itemCount][0] = substr($badgetext, $start + strlen("<title>"), $len - strlen("</title>") + 1); 
  
      $start = strpos($badgetext, "<description>");
      $len = strpos($badgetext, "</description>", $start) - $start;
      $arItems[$itemCount][1] = substr($badgetext, $start + strlen("<description>"), $len - strlen("</description>") + 1); 
  
      $start = strpos($badgetext, "<image>");
      $len = strpos($badgetext, "</image>", $start) - $start;
      $arItems[$itemCount][2] = substr($badgetext, $start + strlen("<image>"), $len - strlen("</image>") + 1); 
  
      $start = strpos($badgetext, "<url>");
      $len = strpos($badgetext, "</url>", $start) - $start;
      $arItems[$itemCount][3] = substr($badgetext, $start + strlen("<url>"), $len - strlen("</url>") + 1); 
  
      $itemCount++;
    }
    print "<div class=\"voiceheader\"><strong>360Voice Badges</strong></div>";
    print "<div class=\"voicedetails\" style=\"text-align: center;\">";
    for ( $row = 0; $row < count($arItems); $row++ )
    {
      print "<a href=\"" . $arItems[$row][3] . "\"><img title=\"" . $arItems[$row][1] . "\" src=\"" . $arItems[$row][2] . "\" style=\"border:0;padding:0px 3px;\"></a>";
    }
    print "<br /><br /></div>";
  }
}

function GetFavoriteGames() {
  Global $StyleWritten;
 
  if (get_option('VoiceAPIDisplayFavorites') == 'True') {

    $gamertag = get_option('VoiceAPIgamertag');
    $numfavs = get_option('VoiceAPINumFavs');

    $itemCount = 0;
    $buffer = GetRemoteXML("www.360voice.com","/api/games-listfav.asp?tag=".urlencode($gamertag) . "&num=" . $numfavs);

    while (strpos($buffer, "<game>") > 0) {
      $start = strpos($buffer, "<game>");
      $len = strpos($buffer, "</game>", $start) - $start;
      $contents = substr($buffer, $start, $len);
  
      $buffer = substr($buffer, $start+$len);  
  
      $start = strpos($contents , "<name>");
      $len = strpos($contents , "</name>", $start) - $start;
      $arItems[$itemCount][0] = substr($contents , $start + strlen("<name>"), $len - strlen("</name>") + 1); 

      $start = strpos($contents , "<tile>");
      $len = strpos($contents , "</tile>", $start) - $start;
      $arItems[$itemCount][1] = substr($contents , $start + strlen("<tile>"), $len - strlen("</tile>") + 1); 

      $start = strpos($contents , "<days>");
      $len = strpos($contents , "</days>", $start) - $start;
      $arItems[$itemCount][2] = substr($contents , $start + strlen("<days>"), $len - strlen("</days>") + 1); 
  

      $itemCount++;
    }
    print "<div class=\"voiceheader\"><strong>Most Played</strong></div>";
    print "<div class=\"voicedetails\">";
    for ( $row = 0; $row < count($arItems); $row++ )
    {
      print "<a href=\"http://www.360voice.com/game.asp?game=" . urlencode($arItems[$row][0]) . "\"><img border=0 title=\"" . $arItems[$row][0] . " - played ". $arItems[$row][2] . " days \" src=\"" . $arItems[$row][1] . "\" style=\"padding:0px 3px;border=0\"></a>";
    }
    print "<br /><br /></div>";
  }
}

function CurlRemoteXML($url) {
  // Create a new curl resource
  $ch = curl_init();
  // Set URL and other appropriate options
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  // Grab URL, return output
  $output = curl_exec($ch);
  // Close curl resource, free up system resources
  curl_close($ch);
  $xml = new DomDocument('1.0');  
  $xml->loadXML($output); 
  return $xml;
}

function GetCompletes() {
  if (get_option('VoiceAPIdisplaycompletes') == 'True') {
	$gamertag = get_option('VoiceAPIgamertag');
	$xml = CurlRemoteXML("http://www.360voice.com/api/games-listfav.asp?tag=" . urlencode($gamertag)  . "&sort=2");
	$completeimgs = "";
	$count = 0;
	foreach($xml->getElementsBytagName('game') as $item) {
		$gameid = $item->getElementsByTagName('id')->item(0)->firstChild->nodeValue; 
		$name = $item->getElementsByTagName('name')->item(0)->firstChild->nodeValue; 
		$genre = $item->getElementsByTagName('genre')->item(0)->firstChild->nodeValue; 
		$url = $item->getElementsByTagName('url')->item(0)->firstChild->nodeValue; 
		$currentgs = $item->getElementsByTagName('currentgs')->item(0)->firstChild->nodeValue; 
		$totalgs = $item->getElementsByTagName('totalgs')->item(0)->firstChild->nodeValue; 
		$currentach = $item->getElementsByTagName('currentach')->item(0)->firstChild->nodeValue; 
		$totalach = $item->getElementsByTagName('totalach')->item(0)->firstChild->nodeValue; 
		$percentcomplete = $item->getElementsByTagName('percentcomplete')->item(0)->firstChild->nodeValue; 
		$tile = $item->getElementsByTagName('tile')->item(0)->firstChild->nodeValue; 
		$tile64 = $item->getElementsByTagName('tile64')->item(0)->firstChild->nodeValue; 
		$days = $item->getElementsByTagName('days')->item(0)->firstChild->nodeValue; 
		$lastplayed = $item->getElementsByTagName('lastplayed')->item(0)->firstChild->nodeValue; 
		$own = $item->getElementsByTagName('own')->item(0)->firstChild->nodeValue; 
		$play = $item->getElementsByTagName('play')->item(0)->firstChild->nodeValue; 
		
		if ($totalach == $currentach && $totalach > 0) {
			$completeimgs  .= "<img src=\"" . $tile . "\" alt=\"" . $name . "\" title=\"" . $name . "\">\n";
			$count += 1;
		} else {
//			print $currentach . " of " . $totalach . "<BR>";
		}
		
	}
    print "<div class=\"voiceheader\"><strong>100% Complete</strong></div>";
    print "<div class=\"voicedetails\">";
	print $completeimgs;
	print "<br /><br /></div>";
	}
}

function GetRemoteXML($siteURI, $pageURI) {
  $fp = fsockopen("$siteURI", 80, $errno, $errstr, 10);
  if ($fp) { 
    $buffer = ""; 
    $out = "GET $pageURI HTTP/1.1\r\n"; 
    $out .= "Host: $siteURI\r\n"; 
    $out .= "Connection: Close\r\n"; 
    $out .= "Referer: WP Badge Plugin\r\n\r\n"; 

    fwrite($fp, $out); 
    while (!feof($fp)) { 
      $buffer .= fgets($fp); 
    } 
    fclose($fp); 
    return $buffer;
  }
}

/*++++++++++++++++++++++++++++++++++++++++
	OPTIONS PAGE BELOW
++++++++++++++++++++++++++++++++++++++++*/
   function voiceAPIshowOptions()
   {
      if (isset($_POST['info_update']))
      {
         $gamertag = trim($_POST['gamertag']);
         $displaybadges = trim($_POST['displaybadges']);
         $displayblogs = trim($_POST['displayblogs']);
         $displayleaderboards = trim($_POST['displayleaderboards']);
         $voiceheadercolor = trim($_POST['voiceheadercolor']);
         $displayfavorites = trim($_POST['displayfavorites']);
         $displaycompletes = trim($_POST['displaycompletes']);
         $numblogs = trim($_POST['numblogs']);
         $numfavs = trim($_POST['numfavs']);
         $voicepadding = trim($_POST['voicepadding']);
         update_option('VoiceAPIgamertag', $gamertag);
         update_option('VoiceAPIblockpadding', $voicepadding);
         update_option('VoiceAPIDisplayBadges', $displaybadges);
         update_option('VoiceAPIDisplayblogs', $displayblogs);
         update_option('VoiceHeaderColor', $voiceheadercolor);

         update_option('VoiceAPIDisplayLeaderboards', $displayleaderboards);
         update_option('VoiceAPIDisplayFavorites', $displayfavorites );
         update_option('VoiceAPINumBlogs', $numblogs);
         update_option('VoiceAPINumFavs', $numfavs);
         update_option('VoiceAPIdisplaycompletes', $displaycompletes);

         ?><div class="updated"><p><strong><?php 
         _e('Options Updated', 'Localization name')
         ?>
	 </strong></p></div>
         <?php
      }
      else
      {
         $gamertag = get_option('VoiceAPIgamertag');
         $displaybadges = get_option('VoiceAPIDisplayBadges');
         $displayblogs = get_option('VoiceAPIDisplayBlogs');
         $displayleaderboards = get_option('VoiceAPIDisplayLeaderboards');
         $displayfavorites = get_option('VoiceAPIDisplayFavorites');
         $numblogs = get_option('VoiceAPINumBlogs');
         $numfavs = get_option('VoiceAPINumFavs');
         $voiceheadercolor = get_option('VoiceHeaderColor');
         $voicepadding = get_option('VoiceAPIblockpadding');
		 $displaycompletes = get_option('VoiceAPIdisplaycompletes');

           // Sets plugin values to defaults on first viewing the options:
	   // Everything on, display one blog, five favorites
		   
//         if ($voiceheadercolor == '') {
//           $voiceheadercolor ='#99FF66';
//        }
//       if ($voicepadding == '') {
//        $voicepadding ='10';
//         }
         if ($displayblogs == '') {
           $displayblogs = 'True';
         }
		 if ($displaycompletes == '') {
           $displaycompletes = 'True';
         }
         if ($displaybadges == '') {
           $displaybadges = 'True';
         }
         if ($displayleaderboards == '') {
           $displayleaderboards = 'True';
         }

         if ($displayfavorites == '') {
           $displayfavorites = 'True';
         }


         if ($numblogs== '') {
           $numblogs = '1';
         }

         if ($numfavs == '') {
           $numfavs = '5';
         }

      }
      ?>

      <div class="wrap">
      <form method="post">
         <h2>ThreeSixtyVoice Options</h2>
	 <p>ThreeSixtyVoice allows you to pull information from your <a href="http://www.360voice.com">360voice</a> account. This page will allow you to modify your settings so it knows where to get the data, what to display, and how to display it!<br /><br />For FAQs and support please go <a href="#">here</a>.
	 </p>
         <fieldset class="options" name="set1">
		 <h3>General</h3>
            <b>Gamertag:</b> <input type="text" size="14" name="gamertag" value="<?php echo $gamertag ?>"/><br />
            <!--- <b>Header Color: </b><input type ="text" name="voiceheadercolor" value ="<? echo $voiceheadercolor ?>" /><BR/ > --->
            <!---<strong>Block spacing: </strong><input type="text" size="1" name="voicepadding" value="<?php echo $voicepadding ?>"/>&nbsp;pixels--->
                     
		<h3>Blocks</h3>

<strong>Display badges? </strong>
            <input type="radio" name="displaybadges" value="True" <? if ($displaybadges=="True") print "CHECKED"; ?>> Yes 
            <input type="radio" name="displaybadges" value="False" <? if ($displaybadges!="True") print "CHECKED"; ?>> No<br /><br />
            <strong>Display blog? </strong>
            <input type="radio" name="displayblogs" value="True" <? if ($displayblogs=="True") print "CHECKED"; ?>> Yes 
            <input type="radio" name="displayblogs" value="False" <? if ($displayblogs!="True") print "CHECKED"; ?>> No<BR /><BR />
			<i>Display:</i>&nbsp;&nbsp;<input type="text" size="1" name="numblogs" value ="<? print $numblogs; ?>"> Blog(s)<br /><br />
            
            <strong>Display favorites? </strong>
            <input type="radio" name="displayfavorites" value="True" <? if ($displayfavorites=="True") print "CHECKED"; ?>> Yes 
            <input type="radio" name="displayfavorites" value="False" <? if ($displayfavorites!="True") print "CHECKED"; ?>> No<BR /><BR />
			<i>Display:</i>&nbsp;&nbsp;<input type="text" size="1" name="numfavs" value ="<? print $numfavs; ?>"> Favorite(s)<br /><br />
            
           
            <strong>Display leaderboards? </strong>
            <input type="radio" name="displayleaderboards" value="True" <? if ($displayleaderboards=="True") print "CHECKED"; ?>> Yes 
            <input type="radio" name="displayleaderboards" value="False" <? if ($displayleaderboards!="True") print "CHECKED"; ?>> No<BR /><BR />
            <strong>Display 100% clubs? </strong>
            <input type="radio" name="displaycompletes" value="True" <? if ($displaycompletes=="True") print "CHECKED"; ?>> Yes 
            <input type="radio" name="displaycompletes" value="False" <? if ($displaycompletes!="True") print "CHECKED"; ?>> No<BR /><BR />
            
			
         </fieldset>
         <div class="submit">
            <input type="submit" name="info_update" value="<?php _e('Update options', 'Localization name') ?> »" />
         </div>
      </form>
      </div>

<?php
   }

function voiceAPIaddOptionMenu()
{
  if(function_exists('add_options_page'))
  {
    add_options_page('ThreeSixtyVoice', 'ThreeSixtyVoice', 'manage_options', basename(__FILE__), 'voiceAPIshowOptions');
  }
}

add_action('admin_menu', 'voiceAPIaddOptionMenu');

// Put functions into one big function we'll call at the plugins_loaded
// action. This ensures that all required plugin functions are defined.
function widget_voicewidget_init() {

	// Check for the required plugin functions. This will prevent fatal
	// errors occurring if you deactivate the dynamic-sidebar.
	if ( !function_exists('register_sidebar_widget') )
		return;

	// This is the function that outputs our little Google search form.
	function widget_voicewidget($args) {
		
		// $args is an array of strings that help widgets to conform to
		// the active theme: before_widget, before_title, after_widget,
		// and after_title are the array keys. Default tags: li and h2.
		extract($args);

		// Each widget can store its own options. We keep strings here.
		$options = get_option('widget_voicewidget');
		$title = $options['title'];
		$buttontext = $options['buttontext'];

		// These lines generate our output.
		echo $before_widget . $before_title . $title . $after_title;
		$url_parts = parse_url(get_bloginfo('home'));
		echo ShowVoiceData();
		echo $after_widget;
	}

	// This is the function that outputs the form to let the users edit
	// the widget's title. It's an optional feature that users cry for.
	function widget_voicewidget_control() {

		// Get our options and see if we're handling a form submission.
		$options = get_option('widget_voicewidget');
		if ( !is_array($options) )
			$options = array('title'=>'', 'buttontext'=>__('ThreeSixtyVoice', 'widgets'));
		if ( $_POST['voicewidget-submit'] ) {

			// Remember to sanitize and format use input appropriately.
			$options['title'] = strip_tags(stripslashes($_POST['voicewidget-title']));
			$options['buttontext'] = strip_tags(stripslashes($_POST['voicewidget-buttontext']));
			update_option('widget_voicewidget', $options);
		}

		// Be sure you format your options to be valid HTML attributes.
		$title = htmlspecialchars($options['title'], ENT_QUOTES);
		$buttontext = htmlspecialchars($options['buttontext'], ENT_QUOTES);
		
		// Here is our little form segment. Notice that we don't need a
		// complete form. This will be embedded into the existing form.
		echo '<p style="text-align:right;"><label for="voicewidget-title">' . __('Title:') . ' <input style="width: 200px;" id="voicewidget-title" name="voicewidget-title" type="text" value="'.$title.'" /></label></p>';
		echo '<input type="hidden" id="voicewidget-submit" name="voicewidget-submit" value="1" />';
	}
	
	// This registers our widget so it appears with the other available
	// widgets and can be dragged and dropped into any active sidebars.
	register_sidebar_widget(array('ThreeSixtyVoice', 'widgets'), 'widget_voicewidget');

	// This registers our optional widget control form. Because of this
	// our widget will have a button that reveals a 300x100 pixel form.
	register_widget_control(array('ThreeSixtyVoice', 'widgets'), 'widget_voicewidget_control', 300, 100);
}

// Run our code later in case this loads prior to any required plugins.
add_action('widgets_init', 'widget_voicewidget_init');
?>
