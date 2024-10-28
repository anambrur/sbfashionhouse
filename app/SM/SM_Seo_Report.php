<?php
/**
 * Created by PhpStorm.
 * User: mrksohag
 * Date: 10/23/17
 * Time: 12:39 PM
 */

namespace App\SM;


class SM_Seo_Report {
	protected $url = "";
	protected $start = null;
	protected $end = null;

	function __construct( $url = "" ) {
		$this->url = $url;
	}

	/**
	 * This method need to call from your source class file to generate SEO Report
	 */
	public function getSeoReport( $isHtml = false ) {
		$htmlInfo = array();

		$htmlInfo["dnsReachable"] = $this->isDNSReachable( $this->url );

// 		if($htmlInfo["dnsReachable"] !== false){

		$isAlive = $this->isAlive();
		/* $this->pre($isAlive);
		 die; */

		if ( $isAlive["STATUS"] == true ) {
			$this->start = microtime( true );
			$grabbedHTML = $this->grabHTML( $this->url );
			$this->end   = microtime( true );

			$htmlInfo            = array_merge( $htmlInfo, $this->getSiteMeta( $grabbedHTML ) );
			$htmlInfo["isAlive"] = true;
			/* $this->pre($htmlInfo);
			die; */
		} else {
			$htmlInfo["isAlive"] = false;
		}
// 		}
		$htmlInfo["url"] = $this->url;
		if ( $isHtml ) {
			$reqHTML = $this->getReadyHTML( $htmlInfo );

			return $reqHTML;
		} else {
			return $this->getSeoReportArrayWtihHTML( $htmlInfo );
		}

		// $this->exportSEOReportPDF($htmlInfo, $this->url);
	}

	/**
	 * This function used to print any data
	 *
	 * @param mixed $data
	 */
	function pre( $data ) {
		echo "<pre>";
		print_r( $data );
		echo "</pre>";
	}

	/**
	 * This function used to print any data
	 *
	 * @param mixed $data
	 */
	function dump( $data ) {
		echo "<pre>";
		var_dump( $data );
		echo "</pre>";
	}

	/**
	 * check if a url is online/alive
	 *
	 * @param string $url : URL of the website
	 *
	 * @return array $result : This containt HTTP_CODE and STATUS
	 */
	function isAlive() {
		set_time_limit( 0 );
		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $this->url );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch, CURLOPT_TIMEOUT, 7200 );
		curl_setopt( $ch, CURLOPT_DNS_USE_GLOBAL_CACHE, false );
		curl_setopt( $ch, CURLOPT_DNS_CACHE_TIMEOUT, 2 );
		curl_exec( $ch );
		$int_return_code = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
		curl_close( $ch );

		$validCodes = array( 200, 301, 302, 304 );

		if ( in_array( $int_return_code, $validCodes ) ) {
			return array( "HTTP_CODE" => $int_return_code, "STATUS" => true );
		} else {
			return array( "HTTP_CODE" => $int_return_code, "STATUS" => false );
		}
	}

	/**
	 * This function is used to check the reachable DNS
	 *
	 * @param {String} $url : URL of website
	 *
	 * @return {Boolean} $status : TRUE/FALSE
	 */
	function isDNSReachable( $url ) {
		$dnsReachable = checkdnsrr( $this->addScheme( $url ) );

		return $dnsReachable == false ? false : true;
	}

	/**
	 * This function is used to check for file existance on server
	 *
	 * @param {String} $filename : filename to be check for existance on server
	 *
	 * @return {Boolean} $status : TRUE/FALSE
	 */
	function checkForFiles( $filename ) {
		$handle = curl_init( $this->url . "/" . $filename );
		curl_setopt( $handle, CURLOPT_RETURNTRANSFER, true );
		$response = curl_exec( $handle );
		$httpCode = curl_getinfo( $handle, CURLINFO_HTTP_CODE );
		curl_close( $handle );
		if ( $httpCode == 200 ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * This function is used to check for file existance on server
	 *
	 * @param {String} $filename : filename to be check for existance on server
	 *
	 * @return {Boolean} $status : TRUE/FALSE
	 */
	function checkForSitemap( $filename ) {
		$handle = curl_init( $this->url . "/" . $filename );
		curl_setopt( $handle, CURLOPT_RETURNTRANSFER, true );
		$response = curl_exec( $handle );
		$httpCode = curl_getinfo( $handle, CURLINFO_HTTP_CODE );
		curl_close( $handle );
		if ( $httpCode == 200 || $httpCode == 301 ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * This function is used to check broken link checking
	 *
	 * @param {String} $link : Link to be test as broken or not
	 *
	 * @return {Boolean} $status : TRUE/FALSE
	 */
	function brokenLinkTester( $link ) {
		set_time_limit( 0 );
		$handle = curl_init( $link );
		curl_setopt( $handle, CURLOPT_RETURNTRANSFER, true );
		$response = curl_exec( $handle );
		$httpCode = curl_getinfo( $handle, CURLINFO_HTTP_CODE );
		curl_close( $handle );
		if ( $httpCode == 200 ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * This function is used to check broken link checking for all anchors from page
	 *
	 * @param {Array} $anchors : Anchor tags from page
	 *
	 * @return {Number} $count : Count of broken link
	 */
	function getBrokenLinkCount( $anchors ) {
		$count  = 0;
		$blinks = array();
		foreach ( $anchors as $a ) {
			array_push( $blinks, $a->getAttribute( "href" ) );
		}
		if ( ! empty( $blinks ) ) {
			foreach ( $blinks as $ln ) {
				$res = $this->brokenLinkTester( $ln );
				if ( $res ) {
					$count ++;
				}
			}
		}

		return $count;
	}

	/**
	 * This function is used to check the alt tags for available images from page
	 *
	 * @param {Array} $imgs : Images from pages
	 *
	 * @return {Array} $result : Array of results
	 */
	function imageAltText( $imgs ) {
		$totImgs = 0;
		$totAlts = 0;
		$diff    = 0;
		$imgsrc  = [];
		foreach ( $imgs as $im ) {
//			$imgsrc[]=$im->getAttribute( "src" );
			$totImgs ++;
			if ( ! empty( $im->getAttribute( "alt" ) ) ) {
				$totAlts ++;
			}
		}

		return array(
			"totImgs"   => $totImgs,
			"totAlts"   => $totAlts,
			"diff"      => ( $totImgs - $totAlts ),
			"imagesSrc" => $imgsrc
		);
	}

	/**
	 * HTTP GET request with curl.
	 *
	 * @param string $url : String, containing the URL to curl.
	 *
	 * @return string : Returns string, containing the curl result.
	 */
	function grabHTML( $url ) {
		set_time_limit( 0 );
		$ch = curl_init( $url );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 5 );
		curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1 );
		curl_setopt( $ch, CURLOPT_MAXREDIRS, 2 );
		if ( strtolower( parse_url( $this->url, PHP_URL_SCHEME ) ) == 'https' ) {
			curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 1 );
			curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 2 );
		}
		$str = curl_exec( $ch );
		curl_close( $ch );

		return ( $str ) ? $str : false;
	}

	/**
	 * This function used to check that google analytics is included in page or not
	 *
	 * @param {Object} $grabbedHtml : Page HTML object
	 *
	 * @return {Boolean} $result : TRUE/FALSE
	 */
	function findGoogleAnalytics( $grabbedHtml ) {
		$pos = strrpos( $grabbedHtml, "GoogleAnalyticsObject" );
		if ( ! $pos ) {
			$pos = strrpos( $grabbedHtml, "https://www.googletagmanager.com/gtm.js" );
		}

		return ( $pos > 0 ) ? true : false;
	}

	/**
	 * This function used to add http protocol to the url if not available
	 *
	 * @param {Strin} $url : This is website url
	 * @param {String} $scheme : Protocol Scheme, default http
	 */
	function addScheme( $url, $scheme = 'http://' ) {
		return parse_url( $url, PHP_URL_SCHEME ) === null ? $scheme . $url : $url;
	}

	/**
	 * This function used to get meta and language information from HTML
	 *
	 * @param string $grabbedHTML : This is HTML string
	 *
	 * @return array $htmlInfo : This is information grabbed from HTML
	 */
	function getSiteMeta( $grabbedHTML ) {

		$html = new \DOMDocument();
		libxml_use_internal_errors( true );
		$html->loadHTML( $grabbedHTML );
		libxml_use_internal_errors( false );
		$xpath    = new \DOMXPath( $html );
		$htmlInfo = array();
		$langs    = $xpath->query( '//html' );
		foreach ( $langs as $lang ) {
			$htmlInfo['language'] = $lang->getAttribute( 'lang' );
		}
		$metas = $xpath->query( '//meta' );
		foreach ( $metas as $meta ) {
			if ( $meta->getAttribute( 'name' ) ) {
				$htmlInfo[ $meta->getAttribute( 'name' ) ] = $meta->getAttribute( 'content' );
			}
		}

		$favicon = $xpath->query( "//link[@rel='shortcut icon']" );
		if ( ! empty( $favicon ) ) {
			foreach ( $favicon as $fav ) {
				$htmlInfo[ $fav->getAttribute( "rel" ) ] = $fav->getAttribute( "href" );
			}

			if ( ! ( isset( $htmlInfo["shortcut icon"] ) || isset( $htmlInfo["icon"] ) ) ) {
				$favicon = $xpath->query( "//link[@rel='icon']" );
				if ( ! empty( $favicon ) ) {
					foreach ( $favicon as $fav ) {
						$htmlInfo[ $fav->getAttribute( "rel" ) ] = $fav->getAttribute( "href" );
					}
				}
			}
		}

		$title = $xpath->query( "//title" );
		foreach ( $title as $tit ) {
			$htmlInfo["titleText"] = $tit->textContent;
		}

		$htmlInfo = array_change_key_case( $htmlInfo, CASE_LOWER );

		$onlyText = $this->stripHtmlTags( $grabbedHTML );

		if ( ! empty( $onlyText ) ) {
			$onlyText = array( trim( $onlyText ) );

			$count = $this->getWordCounts( $onlyText );

			$grammar = array(
				"a"       => "",
				"an"      => "",
				"the"     => "",
				"shall"   => "",
				"should"  => "",
				"can"     => "",
				"could"   => "",
				"will"    => "",
				"would"   => "",
				"am"      => "",
				"is"      => "",
				"are"     => "",
				"we"      => "",
				"us"      => "",
				"has"     => "",
				"have"    => "",
				"had"     => "",
				"not"     => "",
				"yes"     => "",
				"no"      => "",
				"true"    => "",
				"false"   => "",
				"with"    => "",
				"to"      => "",
				"your"    => "",
				"more"    => "",
				"and"     => "",
				"in"      => "",
				"out"     => "",
				"login"   => "",
				"logout"  => "",
				"sign"    => "",
				"up"      => "",
				"coming"  => "",
				"going"   => "",
				"now"     => "",
				"then"    => "",
				"about"   => "",
				"contact" => "",
				"my"      => "",
				"you"     => "",
				"go"      => "",
				"close"   => "",
				""        => "",
				"of"      => "",
				"our"     => ""
			);

			$count = array_diff_key( $count, $grammar );

			arsort( $count, SORT_DESC | SORT_NUMERIC );

			$htmlInfo["wordCount"]    = $count;
			$htmlInfo["wordCountMax"] = array_slice( $count, 0, 5, true );
		}

		if ( ! empty( $htmlInfo["wordCount"] ) && ! empty( $htmlInfo["keywords"] ) ) {
			$htmlInfo["compareMetaKeywords"] = $this->compareMetaWithContent( array_keys( $htmlInfo["wordCount"] ), $htmlInfo["keywords"] );
		}

		$h1headings = $xpath->query( "//h1" );
		$index      = 0;
		foreach ( $h1headings as $h1h ) {
			$htmlInfo["h1"][ $index ] = trim( strip_tags( $h1h->textContent ) );
			$index ++;
		}

		$h2headings = $xpath->query( "//h2" );
		$index      = 0;
		foreach ( $h2headings as $h2h ) {
			$htmlInfo["h2"][ $index ] = trim( strip_tags( $h2h->textContent ) );
			$index ++;
		}

		$h3headings = $xpath->query( "//h3" );
		$index      = 0;
		foreach ( $h3headings as $h3h ) {
			$htmlInfo["h3"][ $index ] = trim( strip_tags( $h3h->textContent ) );
			$index ++;
		}

		$h4headings = $xpath->query( "//h4" );
		$index      = 0;
		foreach ( $h4headings as $h4h ) {
			$htmlInfo["h4"][ $index ] = trim( strip_tags( $h4h->textContent ) );
			$index ++;
		}

		$htmlInfo["robots"]  = $this->checkForFiles( "robots.txt" );
		$htmlInfo["sitemap"] = $this->checkForSitemap( "sitemap.xml" );

		$htmlInfo["brokenLinkCount"] = 0;
		$anchors                     = $xpath->query( "//a" );
		if ( ! empty( $anchors ) ) {
// 			$htmlInfo["brokenLinkCount"] = $this->getBrokenLinkCount($anchors);
		}

		$htmlInfo["images"] = array();
		$imgs               = $xpath->query( "//img" );
		if ( ! empty( $imgs ) ) {
			$htmlInfo["images"] = $this->imageAltText( $imgs );
		}

		$htmlInfo["googleAnalytics"] = $this->findGoogleAnalytics( $grabbedHTML );

		$htmlInfo["pageLoadTime"] = $this->getPageLoadTime();

		$htmlInfo["flashTest"] = false;
		$flashExists           = $xpath->query( "//embed[@type='application/x-shockwave-flash']" );
		if ( $flashExists->length !== 0 ) {
			$htmlInfo["flashTest"] = true;
		}

		$htmlInfo["frameTest"] = false;
		$frameExists           = $xpath->query( "//frameset" );
		if ( $frameExists->length !== 0 ) {
			$htmlInfo["frameTest"] = true;
		}

		$htmlInfo["css"] = array();
		$cssExists       = $xpath->query( "//link[@rel='stylesheet']" );
		$htmlInfo["css"] = array_merge( $htmlInfo["css"], $this->cssFinder( $cssExists ) );

		$htmlInfo["js"] = array();
		$jsExists       = $xpath->query( "//script[contains(@src, '.js')]" );
		$htmlInfo["js"] = array_merge( $htmlInfo["js"], $this->jsFinder( $jsExists ) );

		return $htmlInfo;
	}

	/**
	 * This function used to find all JS files
	 *
	 * @param {Array} $jsExists : JS exist count
	 *
	 * @return {Array} $push : JS result with js counts
	 */
	function jsFinder( $jsExists ) {
		$push["jsCount"]       = 0;
		$push["jsMinCount"]    = 0;
		$push["jsNotMinFiles"] = array();

		if ( ! empty( $jsExists ) ) {
			foreach ( $jsExists as $ce ) {
				$push["jsCount"] ++;
				if ( $this->formatCheckLinks( $ce->getAttribute( "src" ) ) ) {
					$push["jsMinCount"] ++;
				} else {
					array_push( $push["jsNotMinFiles"], $ce->getAttribute( "src" ) );
				}
			}
		}

		return $push;
	}

	/**
	 * This function used to find all CSS files
	 *
	 * @param {Array} $cssExists : CSS exist count
	 *
	 * @return {Array} $push : CSS result with css counts
	 */
	function cssFinder( $cssExists ) {
		$push["cssCount"]       = 0;
		$push["cssMinCount"]    = 0;
		$push["cssNotMinFiles"] = array();

		if ( ! empty( $cssExists ) ) {
			foreach ( $cssExists as $ce ) {
				$push["cssCount"] ++;
				if ( $this->formatCheckLinks( $ce->getAttribute( "href" ) ) ) {
					$push["cssMinCount"] ++;

				} else {
					array_push( $push["cssNotMinFiles"], $ce->getAttribute( "href" ) );
				}
			}
		}

		return $push;
	}

	/**
	 * This function used to check format checking for JS and CSS
	 *
	 * @param {String} $link : JS or CSS file link
	 *
	 * @return {Boolean} $result : TRUE/FALSE
	 */
	function formatCheckLinks( $link ) {
		$cssFile = "";
		if ( strpos( $cssFile, '?' ) !== false ) {
			$cssFile = substr( $link, strrpos( $link, "/" ), strrpos( $link, "?" ) - strrpos( $link, "/" ) );
		} else {
			$cssFile = substr( $link, strrpos( $link, "/" ) );
		}
		if ( strpos( $cssFile, '.min.' ) !== false ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * This function used to strip HTML tags from grabbed string
	 *
	 * @param {String} $str : HTML string to be stripped
	 *
	 * @return {String} $str : Stripped string
	 */
	function stripHtmlTags( $str ) {
		$str = preg_replace( '/(<|>)\1{2}/is', '', $str );
		$str = preg_replace(
			array(
				'@<head[^>]*?>.*?</head>@siu',
				'@<style[^>]*?>.*?</style>@siu',
				'@<script[^>]*?.*?</script>@siu',
				'@<noscript[^>]*?.*?</noscript>@siu',
			),
			"",
			$str );

		$str = $this->replaceWhitespace( $str );
		$str = html_entity_decode( $str );
		$str = strip_tags( $str );

		return $str;
	}

	/**
	 * This function used to remove whitespace from string, recursively
	 *
	 * @param {String} $str : This is input string
	 *
	 * @return {String} $str : Output string, or recursive call
	 */
	function replaceWhitespace( $str ) {
		$result = $str;
		foreach (
			array(
				"  ",
				"   ",
				" \t",
				" \r",
				" \n",
				"\t\t",
				"\t ",
				"\t\r",
				"\t\n",
				"\r\r",
				"\r ",
				"\r\t",
				"\r\n",
				"\n\n",
				"\n ",
				"\n\t",
				"\n\r",
			) as $replacement
		) {
			$result = str_replace( $replacement, $replacement[0], $result );
		}

		return $str !== $result ? $this->replaceWhitespace( $result ) : $result;
	}

	/**
	 * This function use to get word count throughout the webpage
	 *
	 * @param array $phrases : This is array of strings
	 *
	 * @return array $count : Array of words with count - number of occurences
	 */
	function getWordCounts( $phrases ) {

		$counts = array();
		foreach ( $phrases as $phrase ) {
			$words = explode( ' ', strtolower( $phrase ) );

			$grammar = array(
				"a",
				"an",
				"the",
				"shall",
				"should",
				"can",
				"could",
				"will",
				"would",
				"am",
				"is",
				"are",
				"we",
				"us",
				"has",
				"have",
				"had",
				"not",
				"yes",
				"no",
				"true",
				"false",
				"with",
				"to",
				"your",
				"more",
				"and",
				"in",
				"out",
				"login",
				"logout",
				"sign",
				"up",
				"coming",
				"going",
				"now",
				"then",
				"about",
				"contact",
				"my",
				"you",
				"of",
				"our"
			);

			$words = array_diff( $words, $grammar );

			foreach ( $words as $word ) {
				if ( ! empty( trim( $word ) ) ) {
					$word = preg_replace( "#[^a-zA-Z\-]#", "", $word );
					if ( isset( $counts[ $word ] ) ) {
						$counts[ $word ] += 1;
					} else {
						$counts[ $word ] = 1;
					}
				}
			}
		}

		return $counts;
	}

	/**
	 * gets the inbounds links from a site
	 *
	 * @param string $url
	 * @param integer
	 */
	function googleSearchResult( $url ) {
		$url  = 'https://www.google.com/#q=' . $url;
		$str  = $this->grabHTML( $url );
		$data = json_decode( $str );

		return ( ! isset( $data->responseData->cursor->estimatedResultCount ) )
			? '0'
			: intval( $data->responseData->cursor->estimatedResultCount );
	}

	/**
	 * This function used to compare keywords with meta
	 *
	 * @param array $contentArray : This is content array
	 * @param string $kewordsString : This is meta keyword string
	 *
	 * @return array $keywordMatch : Match found
	 */
	function compareMetaWithContent( $contentArray, $kewordsString ) {
		$kewordsString = strtolower( str_replace( ',', ' ', $kewordsString ) );
		$keywordsArray = explode( " ", $kewordsString );
		$keywordMatch  = array();
		foreach ( $contentArray as $ca ) {
			if ( ! empty( trim( $ca ) ) && in_array( $ca, $keywordsArray ) ) {
				array_push( $keywordMatch, $ca );
			}
		}

		/* $this->pre($contentArray);
		$this->pre($kewordsString); */

		return $keywordMatch;
	}

	/**
	 * This function is used to export requirements as PDF
	 *
	 * @param {String} $htmlInfo : This is HTML string which is to be print in PDF
	 * @param {String} $for : This website link for which we are generating report
	 */
	function exportSEOReportPDF( $htmlInfo, $for ) {
		set_time_limit( 0 );
		ob_start();

		// $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf = new MYPDF ( PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false );

		$fileName        = $for;
		$htmlInfo["url"] = $for;

		if ( ! empty ( $htmlInfo ) ) {
			// set document information
			$pdf->SetCreator( PDF_CREATOR );
			$pdf->SetAuthor( 'CodeInsect' );
			$pdf->SetTitle( "SEO Report" );
			$pdf->SetSubject( 'SEO Report For ' );

			$logo = 'logo.png';

			// set default header data
			// $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 006', PDF_HEADER_STRING);
			$pdf->SetHeaderData( $logo, 10, $for, "by CodeInsect" );

			// set header and footer fonts
			$pdf->setHeaderFont( Array(
				PDF_FONT_NAME_MAIN,
				'',
				PDF_FONT_SIZE_MAIN
			) );
			$pdf->setFooterFont( Array(
				PDF_FONT_NAME_DATA,
				'',
				PDF_FONT_SIZE_DATA
			) );

			// set default monospaced font
			$pdf->SetDefaultMonospacedFont( PDF_FONT_MONOSPACED );

			// set margins
			$pdf->SetMargins( PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT );
			$pdf->SetHeaderMargin( PDF_MARGIN_HEADER );
			$pdf->SetFooterMargin( PDF_MARGIN_FOOTER );

			// set auto page breaks
			$pdf->SetAutoPageBreak( true, PDF_MARGIN_BOTTOM );

			// set image scale factor
			$pdf->setImageScale( PDF_IMAGE_SCALE_RATIO );

			$pdf->AddPage();

			$reqHTML = $this->getReadyHTML( $htmlInfo );

			/* $this->pre($reqHTML);
			die; */

			// set font for utf-8 type of data
			$pdf->SetFont( 'freeserif', '', 12 );

			$pdf->writeHTML( $reqHTML, true, false, false, false, '' );
			$pdf->lastPage();
		}

		$pdf->Output( $fileName . '.pdf', 'D' );
	}

	/**
	 * This function is used to calculate simple load time of HTML page
	 */
	function getPageLoadTime() {
		if ( ! is_null( $this->start ) && ! is_null( $this->end ) ) {
			return $this->end - $this->start;
		} else {
			return 0;
		}
	}

	/**
	 * This function used to clean the string with some set of rules
	 *
	 * @param {String} $string : String to be clean
	 *
	 * @return {String} $string : clean string
	 */
	function clean( $string ) {
		$string = str_replace( ' ', '-', $string ); // Replaces all spaces with hyphens.
		$string = preg_replace( '/[^A-Za-z0-9\-]/', '', $string ); // Removes special chars.

		$string = preg_replace( '/-+/', '-', $string ); // Replaces multiple hyphens with single one.

		return str_replace( '-', ' ', $string );
	}

	/**
	 * Create HTML to print on PDF (or on page if you want to print on HTML page)
	 * Make Sure that HTML is correct, otherwise it will not print on PDF
	 *
	 * @param {Array} $htmlInfo : Array having total seo analysis
	 *
	 * @return {String} $html : Real html which is to be print
	 */
	function getReadyHTML( $htmlInfo ) {

		$html = '<div>';
		$html .= '<table border="1" cellpadding="2" cellspacing="2" nobr="true">';
		$html .= '<thead>';
		$html .= '<tr>';
		$html .= '<th colspan="2" align="center">COMMON SEO ISSUES</th>';
		$html .= '</tr>';
		$html .= '</thead>';
		$html .= '<tbody>';


		/* if($htmlInfo["dnsReachable"] !== false){ */

		if ( $htmlInfo["isAlive"] == true ) {
			$html .= '<tr nobr="true">';
			$html .= '<td style="width: 30%;">';
			$html .= '<div style="width: 100%;"><span style="font-size:11px;"><strong>Site Status</strong></span></div>';
			$html .= '</td>';
			$html .= '<td style="width: 70%;">';
			$html .= '<div style="width: 100%;"><span style="font-size:11px;">Congratulations! Your site is alive.</span></div>';
			$html .= '</td>';
			$html .= '</tr>';

			$html .= '<tr nobr="true">';
			$html .= '<td style="width: 30%;">';
			$html .= '<div style="width: 100%;"><span style="font-size:11px;"><strong>Title Tag</strong></span></div>';
			$html .= '</td>';
			$html .= '<td style="width: 70%;">';
			if ( isset( $htmlInfo["titletext"] ) ) {
				$html .= '<div style="width: 100%;"><span style="font-size:11px;">The meta title of your page has a length of ' . strlen( $htmlInfo["titletext"] ) . ' characters. Most search engines will truncate meta titles to 70 characters. <br> -> <strong>' . $htmlInfo["titletext"] . '</strong> </span></div>';
			} else {
				$html .= '<div style="width: 100%;"><span style="font-size:11px;">Your page doesn\'t have title. </span></div>';
			}
			$html .= '</td>';
			$html .= '</tr>';

			$html .= '<tr style="width: 100%; padding-left:10px;" nobr="true">';
			$html .= '<td style="width: 30%;">';
			$html .= '<div style="width: 100%;"><span style="font-size:11px;"><strong>Meta Description</strong></span></div>';
			$html .= '</td>';
			$html .= '<td style="width: 70%;">';
			if ( isset( $htmlInfo["description"] ) ) {
				$html .= '<div style="width: 100%;"><span style="font-size:11px;">The meta description of your page has a length of ' . strlen( $htmlInfo["description"] ) . ' characters. Most search engines will truncate meta descriptions to 160 characters. <br> -> <strong>' . $htmlInfo["description"] . '</strong> </span></div>';
			} else {
				$html .= '<div style="width: 100%;"><span style="font-size:11px;">Your page doesn\'t have meta description </span></div>';
			}
			$html .= '</td>';
			$html .= '</tr>';

			$html .= '<tr style="width: 100%; padding-left:10px;" nobr="true">';
			$html .= '<td style="width: 30%;">';
			$html .= '<div style="width: 100%;"><span style="font-size:11px;"><strong>Google Search Results Preview</strong></span></div>';
			$html .= '</td>';
			$html .= '<td style="width: 70%;">';
			$html .= '<div style="width: 100%;">';
			if ( isset( $htmlInfo["titletext"] ) ) {
				$html .= '<span style="color:#609;font-size:13px;"><u>' . $htmlInfo["titletext"] . '</u></span><br>';
			}
			$html .= '<span style="color:#006621;font-size:11px;">' . $this->addScheme( $htmlInfo["url"], "http://" ) . '</span><br>';
			if ( isset( $htmlInfo["description"] ) ) {
				$html .= '<span style="color:#6A6A6A;font-size:11px;">' . $htmlInfo["description"] . '</span>';
			}
			$html .= '</div>';
			$html .= '</td>';
			$html .= '</tr>';

			$html .= '<tr style="width: 100%; padding-left:10px;" nobr="true">';
			$html .= '<td style="width: 30%;">';
			$html .= '<div style="width: 100%;"><span style="font-size:11px;"><strong>Most Common Keywords Test</strong></span></div>';
			$html .= '</td>';
			$html .= '<td style="width: 70%;">';
			$html .= '<div style="width: 100%;">';
			if ( ! empty( $htmlInfo["wordCountMax"] ) ) {
				$html .= '<span style="font-size:11px;">There is likely no optimal keyword density (search engine algorithms have evolved beyond
						keyword density metrics as a significant ranking factor). It can be useful, however, to note which
						keywords appear most often on your page and if they reflect the intended topic of your page. More
						importantly, the keywords on your page should appear within natural sounding and grammatically
						correct copy.</span>';
				foreach ( $htmlInfo["wordCountMax"] as $wordMaxKey => $wordMaxValue ) {
					$html .= '<br>-> <span style="font-weight:bold;font-size:11px;color:#000000;">' . $wordMaxKey . ' - ' . $wordMaxValue . '</span>';
				}
			} else {
				$html .= '<span style="font-size:11px;">Your page doens\'t have any repeated keywords.</span><br>';
			}
			$html .= '</div>';
			$html .= '</td>';
			$html .= '</tr>';


			$html .= '<tr style="width: 100%; padding-left:10px;" nobr="true">';
			$html .= '<td style="width: 30%;">';
			$html .= '<div style="width: 100%;"><span style="font-size:11px;"><strong>Keyword Usage</strong></span></div>';
			$html .= '</td>';
			$html .= '<td style="width: 70%;">';
			$html .= '<div style="width: 100%;">';
			if ( ! empty( $htmlInfo["compareMetaKeywords"] ) ) {
				$html .= '<span style="font-size:11px;">Your page have common keywords from meta tags.</span>';
				foreach ( $htmlInfo["compareMetaKeywords"] as $metaKey => $metaValue ) {
					$html .= '<br>-> <span style="font-size:11px;color:#000000;">' . $metaValue . '</span>';
				}
			} else {
				$html .= '<span style="font-size:11px;">Your most common keywords are not appearing in one or more of the meta-tags above. Your
							primary keywords should appear in your meta-tags to help identify the topic of your webpage to
							search engines.</span>';
			}
			$html .= '</div>';
			$html .= '</td>';
			$html .= '</tr>';

			$html .= '<tr style="width: 100%; padding-left:10px;" nobr="true">';
			$html .= '<td style="width: 30%;">';
			$html .= '<div style="width: 100%;"><span style="font-size:11px;"><strong>h1 Headings Status</strong></span></div>';
			$html .= '</td>';
			$html .= '<td style="width: 70%;">';
			$html .= '<div style="width: 100%;">';
			if ( isset( $htmlInfo["h1"] ) ) {
				$html .= '<span style="font-size:10px;">Your pages having these H1 headigs.</span>';
				foreach ( $htmlInfo["h1"] as $h1 ) {
					$html .= '<br>-> <span style="font-weight:bold;font-size:10px;color:#000000;">' . $h1 . '</span> ';
				}
			} else {
				$html .= '<span style="font-size:10px;">Your page doesn\'t have H1 tags.</span>';
			}
			$html .= '</div>';
			$html .= '</td>';
			$html .= '</tr>';

			$html .= '<tr style="width: 100%; padding-left:10px;" nobr="true">';
			$html .= '<td style="width: 30%;">';
			$html .= '<div style="width: 100%;"><span style="font-size:11px;"><strong>h2 Headings Status</strong></span></div>';
			$html .= '</td>';
			$html .= '<td style="width: 70%;">';
			$html .= '<div style="width: 100%;">';
			if ( isset( $htmlInfo["h2"] ) ) {
				$html .= '<span style="font-size:10px;">Your pages having these H2 headigs.</span>';
				foreach ( $htmlInfo["h2"] as $h2 ) {
					$html .= '<br>-> <span style="font-weight:bold;font-size:10px;color:#000000;">' . $h2 . '</span> ';
				}
			} else {
				$html .= '<span style="font-size:10px;">Your page doesn\'t have H2 tags.</span>';
			}
			$html .= '</div>';
			$html .= '</td>';
			$html .= '</tr>';

			$html .= '<tr style="width: 100%; padding-left:10px;" nobr="true">';
			$html .= '<td style="width: 30%;">';
			$html .= '<div style="width: 100%;"><span style="font-size:11px;"><strong>Robots.txt Test</strong></span></div>';
			$html .= '</td>';
			$html .= '<td style="width: 70%;">';
			$html .= '<div style="width: 100%;">';
			if ( $htmlInfo["robots"] == 200 ) {
				$html .= '<span style="font-size:10px;">Congratulations! Your site uses a "robots.txt" file: <span style="color:blue">http://' . $htmlInfo["url"] . '/robots.txt</span></span>';
			} else {
				$html .= '<span style="font-size:10px;">Your page doesn\'t have "robots.txt" file </span>';
			}
			$html .= '</div>';
			$html .= '</td>';
			$html .= '</tr>';

			$html .= '<tr style="width: 100%; padding-left:10px;" nobr="true">';
			$html .= '<td style="width: 30%;">';
			$html .= '<div style="width: 100%;"><span style="font-size:11px;"><strong>Sitemap Test</strong></span></div>';
			$html .= '</td>';
			$html .= '<td style="width: 70%;">';
			$html .= '<div style="width: 100%;">';
			if ( $htmlInfo["robots"] == 200 ) {
				$html .= '<span style="font-size:10px;">Congratulations! We\'ve found sitemap file for your website: <span style="color:blue">http://' . $htmlInfo["url"] . '/sitemap.xml</span></span>';
			} else {
				$html .= '<span style="font-size:10px;">Your page doesn\'t have "sitemap.xml" file. </span>';
			}
			$html .= '</div>';
			$html .= '</td>';
			$html .= '</tr>';

			$html .= '<tr style="width: 100%; padding-left:10px;" nobr="true">';
			$html .= '<td style="width: 30%;">';
			$html .= '<div style="width: 100%;"><span style="font-size:11px;"><strong>Broken Links Test</strong></span></div>';
			$html .= '</td>';
			$html .= '<td style="width: 70%;">';
			$html .= '<div style="width: 100%;">';
			if ( ! empty( $htmlInfo["brokenLinkCount"] ) && $htmlInfo["brokenLinkCount"] != 0 ) {
				$html .= '<span style="font-size:10px;">Your page has some broken links, count : ' . $htmlInfo["brokenLinkCount"] . '</span>';
			} else {
				$html .= '<span style="font-size:10px;">Congratulations! Your page doesn\'t have any broken links. </span>';
			}
			$html .= '</div>';
			$html .= '</td>';
			$html .= '</tr>';

			$html .= '<tr style="width: 100%; padding-left:10px;" nobr="true">';
			$html .= '<td style="width: 30%;">';
			$html .= '<div style="width: 100%;"><span style="font-size:11px;"><strong>Image Alt Test</strong></span></div>';
			$html .= '</td>';
			$html .= '<td style="width: 70%;">';
			$html .= '<div style="width: 100%;">';
			if ( ! empty( $htmlInfo["images"] ) ) {
				if ( isset( $htmlInfo["images"]["totImgs"] ) && $htmlInfo["images"]["totImgs"] != 0 ) {
					if ( $htmlInfo["images"]["diff"] <= 0 ) {
						$html .= '<span style="font-size:10px;">Congratulations! ' . $htmlInfo["images"]["totImgs"] . ' images found in your page, and all have "ALT" text. </span>';
					} else {
						$html .= '<span style="font-size:10px;">' . $htmlInfo["images"]["totImgs"] . ' images found in your page and ' . $htmlInfo["images"]["diff"] . ' images are without "ALT" text.</span>';
					}
				} else {
					$html .= '<span style="font-size:10px;">Your pages does not have any images</span>';
				}
			} else {
				$html .= '<span style="font-size:10px;">Your pages does not have any images</span>';
			}
			$html .= '</div>';
			$html .= '</td>';
			$html .= '</tr>';

			$html .= '<tr style="width: 100%; padding-left:10px;" nobr="true">';
			$html .= '<td style="width: 30%;">';
			$html .= '<div style="width: 100%;"><span style="font-size:11px;"><strong>Google Analytics</strong></span></div>';
			$html .= '</td>';
			$html .= '<td style="width: 70%;">';
			$html .= '<div style="width: 100%;">';
			if ( $htmlInfo["googleAnalytics"] == true ) {
				$html .= '<span style="font-size:10px;">Congratulations! Your page is already submitted to Google Analytics.</span>';
			} else {
				$html .= '<span style="font-size:10px;">Your page not submitted to Google Analytics</span>';
			}
			$html .= '</div>';
			$html .= '</td>';
			$html .= '</tr>';


			$html .= '<tr nobr="true">';
			$html .= '<td style="width: 30%;">';
			$html .= '<div style="width: 100%;"><span style="font-size:11px;"><strong>Favicon Test</strong></span></div>';
			$html .= '</td>';
			$html .= '<td style="width: 70%;">';
			if ( isset( $htmlInfo["shortcut icon"] ) || isset( $htmlInfo["icon"] ) ) {
				$html .= '<div style="width: 100%;font-size:10px;">Congratulations! Your website appears to have a favicon.</div>';
			} else {
				$html .= '<div style="width: 100%;font-size:10px;">Your site doesn\'t have favicon.</div>';
			}
			$html .= '</td>';
			$html .= '</tr>';

			$html .= '<tr nobr="true">';
			$html .= '<td style="width: 30%;">';
			$html .= '<div style="width: 100%;"><span style="font-size:11px;"><strong>Site Loading Speed Test</strong></span></div>';
			$html .= '</td>';
			$html .= '<td style="width: 70%;">';
			if ( $htmlInfo["pageLoadTime"] !== 0 ) {
				$html .= '<div style="width: 100%;font-size:10px;">Your site loading time is around <strong>' . $htmlInfo["pageLoadTime"] . ' seconds</strong> and the average loading speed of any website which is <strong>5 seconds</strong> required. </div>';
			} else {
				$html .= '<div style="width: 100%;font-size:10px;">Unable to get load time of your site.</div>';
			}
			$html .= '</td>';
			$html .= '</tr>';


			$html .= '<tr nobr="true">';
			$html .= '<td style="width: 30%;">';
			$html .= '<div style="width: 100%;"><span style="font-size:11px;"><strong>Flash Test</strong></span></div>';
			$html .= '</td>';
			$html .= '<td style="width: 70%;">';
			if ( $htmlInfo["flashTest"] == true ) {
				$html .= '<div style="width: 100%;font-size:10px;">Your website include flash objects (an outdated technology that was sometimes used to deliver rich multimedia content). Flash content does not work well on mobile devices, and is difficult for crawlers to interpret.</div>';
			} else {
				$html .= '<div style="width: 100%;font-size:10px;">Congratulations! Your website does not include flash objects (an outdated technology that was sometimes used to deliver rich multimedia content). Flash content does not work well on mobile devices, and is difficult for crawlers to interpret.</div>';
			}
			$html .= '</td>';
			$html .= '</tr>';

			$html .= '<tr nobr="true">';
			$html .= '<td style="width: 30%;">';
			$html .= '<div style="width: 100%;"><span style="font-size:11px;"><strong>Frame Test</strong></span></div>';
			$html .= '</td>';
			$html .= '<td style="width: 70%;">';
			if ( $htmlInfo["frameTest"] == true ) {
				$html .= '<div style="width: 100%;font-size:10px;">Your webpage use frames.</div>';
			} else {
				$html .= '<div style="width: 100%;font-size:10px;">Congratulations! Your webpage does not use frames.</div>';
			}
			$html .= '</td>';
			$html .= '</tr>';


			$html .= '<tr nobr="true">';
			$html .= '<td style="width: 30%;">';
			$html .= '<div style="width: 100%;"><span style="font-size:11px;"><strong>CSS Minification</strong></span></div>';
			$html .= '</td>';
			$html .= '<td style="width: 70%;">';
			$html .= '<div style="width: 100%;font-size:10px;">';
			if ( ! empty( $htmlInfo["css"] ) ) {
				if ( $htmlInfo["css"]["cssCount"] > 0 ) {
					$html .= '<span style="width: 100%;font-size:10px;">Your page having ' . $htmlInfo["css"]["cssCount"] . ' external css files </span>';
					if ( $htmlInfo["css"]["cssMinCount"] > 0 ) {
						$html .= '<span style="width: 100%;font-size:10px;">and out of them ' . $htmlInfo["css"]["cssMinCount"] . ' css files are minified.</span>';
					} else {
						$html .= '<span style="width: 100%;font-size:10px;">and no file is minified.</span>';
					}

					if ( ! empty( $htmlInfo["css"]["cssNotMinFiles"] ) ) {
						$html .= '<br><span style="width: 100%;font-size:10px;">Following files are not minified : </span>';
						foreach ( $htmlInfo["css"]["cssNotMinFiles"] as $cNMF ) {
							$html .= '<br><span style="width: 100%;font-size:10px;color:blue;">' . $cNMF . '</span>';
						}
					}
				} else {
					$html .= '<span style="width: 100%;font-size:10px;">No external css found.</span>';
				}
			} else {
				$html .= '<span style="width: 100%;font-size:10px;">No external css found.</span>';
			}
			$html .= '</div>';
			$html .= '</td>';
			$html .= '</tr>';

			$html .= '<tr nobr="true">';
			$html .= '<td style="width: 30%;">';
			$html .= '<div style="width: 100%;"><span style="font-size:11px;"><strong>JS Minification</strong></span></div>';
			$html .= '</td>';
			$html .= '<td style="width: 70%;">';
			$html .= '<div style="width: 100%;font-size:10px;">';
			if ( ! empty( $htmlInfo["js"] ) ) {
				if ( $htmlInfo["js"]["jsCount"] > 0 ) {
					$html .= '<span style="width: 100%;font-size:10px;">Your page having ' . $htmlInfo["js"]["jsCount"] . ' external js files </span>';
					if ( $htmlInfo["js"]["jsMinCount"] > 0 ) {
						$html .= '<span style="width: 100%;font-size:10px;">and out of them ' . $htmlInfo["js"]["jsMinCount"] . ' js files are minified.</span>';
					} else {
						$html .= '<span style="width: 100%;font-size:10px;">and no file is minified.</span>';
					}

					if ( ! empty( $htmlInfo["js"]["jsNotMinFiles"] ) ) {
						$html .= '<br><span style="width: 100%;font-size:10px;">Following files are not minified : </span>';
						foreach ( $htmlInfo["js"]["jsNotMinFiles"] as $jNMF ) {
							$html .= '<br><span style="width: 100%;font-size:10px;color:blue;">' . $jNMF . '</span>';
						}
					}
				} else {
					$html .= '<span style="width: 100%;font-size:10px;">No external js found.</span>';
				}
			} else {
				$html .= '<span style="width: 100%;font-size:10px;">No external js found.</span>';
			}
			$html .= '</div>';
			$html .= '</td>';
			$html .= '</tr>';

		} else {
			$html .= '<tr>';
			$html .= '<td style="width: 30%;">';
			$html .= '<div style="width: 100%;"><span style="font-size:11px;">Site Status</span></div>';
			$html .= '</td>';
			$html .= '<td style="width: 70%;">';
			$html .= '<div style="width: 100%;">You didn\'t uploaded anything on site yet.</div>';
			$html .= '</td>';
			$html .= '</tr>';
		}

		/* }
		else {

			$html .= '<tr>';
			$html .= '<td style="width: 30%;">';
			$html .= '<div style="width: 100%;"><span style="font-size:11px;">Site Status</span></div>';
			$html .= '</td>';
			$html .= '<td style="width: 70%;">';
			$html .= '<div style="width: 100%;">No DNS Found</div>';
			$html .= '</td>';
			$html .= '</tr>';
		} */


		$html .= '</tbody>';
		$html .= '</table>';
		$html .= '</div>';


		return $html;
	}

	/**
	 * Create HTML to print on PDF (or on page if you want to print on HTML page)
	 * Make Sure that HTML is correct, otherwise it will not print on PDF
	 *
	 * @param {Array} $htmlInfo : Array having total seo analysis
	 *
	 * @return {String} $html : Real html which is to be print
	 */
	function getSeoReportArrayWtihHTML( $htmlInfo ) {

		$errors  = [];
		$warning = [];
		$success = [];


		/* if($htmlInfo["dnsReachable"] !== false){ */
		$highPriority   = '';
		$mediumPriority = '';
		$lowPriority    = '';
		if ( $htmlInfo["isAlive"] == true ) {
			$data["isAlive"]    = 1;
			$success["isAlive"] = '<li><i class="fa fa-check-circle"></i>';
			$success["isAlive"] .= 'Congratulations! Your site is alive.';
			$success["isAlive"] .= '<li>';

			if ( isset( $htmlInfo["titletext"] ) ) {
				$titleLen = strlen( $htmlInfo["titletext"] );
				if ( $titleLen > 70 ) {
					$warning["titletext"] = '<li><i class="fa fa-warning"></i>';
					$warning["titletext"] .= 'The meta title of your page has a length of ' . $titleLen . ' characters. Most search engines will truncate meta titles to 70 characters. <br> <strong>' . $htmlInfo["titletext"] . '</strong>';
					$warning["titletext"] .= '<li>';
				} else {
					$success["titletext"] = '<li><i class="fa fa-check-circle"></i>';
					$success["titletext"] .= 'Your title is perfect.';
					$success["titletext"] .= '<li>';
				}
			} else {
				$errors["titletext"] = '<li><i class="fa fa-times-circle"></i>';
				$errors["titletext"] .= ' Your page doesn\'t have title.';
				$errors["titletext"] .= '<li>';

				$highPriority .= '<li>Title is required for a site</li>';
			}


			if ( isset( $htmlInfo["description"] ) ) {
				$descriptionLen = strlen( $htmlInfo["description"] );
				if ( $descriptionLen > 215 ) {
					$warning["description"] = '<li><i class="fa fa-warning"></i>';
					$warning["description"] .= 'The meta description of your page has a length of ' . $descriptionLen . ' characters. Most search engines will truncate meta descriptions to 215 characters. <br> -> <strong>' . $htmlInfo["description"] . '</strong>';
					$warning["description"] .= '<li>';
				} else {
					$success["description"] = '<li><i class="fa fa-check-circle"></i>';
					$success["description"] .= ' Your meta description is perfect.';
					$success["description"] .= '<li>';
				}
			} else {
				$highPriority          .= '<li>Meta Description is required.</li>';
				$errors["description"] = '<li><i class="fa fa-times-circle"></i>';
				$errors["description"] .= ' Your page doesn\'t have meta description';
				$errors["description"] .= '<li>';
			}


			$success["google_search_result_preview"] = '<strong>Google Search Results Preview</strong><br>';
			$success["google_search_result_preview"] .= '<div style="width: 100%;">';
			if ( isset( $htmlInfo["titletext"] ) ) {
				$success["google_search_result_preview"] .= '<span style="color:#609;font-size:13px;"><u>' . $htmlInfo["titletext"] . '</u></span><br>';
			}
			$success["google_search_result_preview"] .= '<span style="color:#006621;font-size:11px;">' . $this->addScheme( $htmlInfo["url"], "http://" ) . '</span><br>';
			if ( isset( $htmlInfo["description"] ) ) {
				$success["google_search_result_preview"] .= '<span style="color:#6A6A6A;font-size:11px;">' . $htmlInfo["description"] . '</span>';
			}
			$success["google_search_result_preview"] .= '</div>';


			$key               = "wordCountMax";
			$keyTitle          = "Most Common Keywords Test:";
			$mostCommonKeyword = '';
			if ( ! empty( $htmlInfo["wordCountMax"] ) ) {
				$loop = 1;
				foreach ( $htmlInfo["wordCountMax"] as $wordMaxKey => $wordMaxValue ) {
					$mostCommonKeyword .= '<tr>';
					$mostCommonKeyword .= '<td>';
					$mostCommonKeyword .= $loop;
					$mostCommonKeyword .= '</td>';
					$mostCommonKeyword .= '<td>';
					$mostCommonKeyword .= $wordMaxKey;
					$mostCommonKeyword .= '</td>';
					$mostCommonKeyword .= '<td>';
					$mostCommonKeyword .= $wordMaxValue;
					$mostCommonKeyword .= '</td>';
					$mostCommonKeyword .= '</tr>';
					$loop ++;
				}
			} else {
				$mostCommonKeyword .= '<tr>';
				$mostCommonKeyword .= '<td colspan="3">Your page doens\'t have any repeated keywords .';
				$mostCommonKeyword .= '</td>';
				$mostCommonKeyword .= '</tr>';

				$lowPriority .= '<li>Your site did not have repeated keywords..</li>';
			}


			$key          = "compareMetaKeywords";
			$keyTitle     = "Keyword Usage:";
			$keywordUsage = '';
			if ( ! empty( $htmlInfo["compareMetaKeywords"] ) ) {
				$loop = 1;
				foreach ( $htmlInfo["compareMetaKeywords"] as $metaKey => $metaValue ) {
					$keywordUsage      .= '<tr>';
					$keywordUsage      .= '<td>';
					$keywordUsage      .= $loop;
					$keywordUsage      .= '</td>';
					$keywordUsage      .= '<td>';
					$keywordUsage      .= $metaValue;
					$keywordUsage      .= '</td>';
					$mostCommonKeyword .= '</tr>';
					$loop ++;
				}
			} else {
				$keywordUsage .= '<tr>';
				$keywordUsage .= '<td colspan="2">Your most common keywords are not appearing in one or more of the meta-tags above. Your
							primary keywords should appear in your meta-tags to help identify the topic of your webpage to
							search engines.';
				$keywordUsage .= '</td>';
				$keywordUsage .= '</tr>';
				$highPriority .= '<li>You site is missing common keywords.</li>';
			}

			$key      = "h1";
			$keyTitle = "H1 headings: ";
			if ( ! empty( $htmlInfo["h1"] ) ) {
				$successH1 = [];
				$warningH1 = [];
				foreach ( $htmlInfo["h1"] as $h1 ) {
					$h1Len = strlen( $h1 );
					if ( $h1Len >= 15 && $h1Len <= 65 ) {
						$successH1[] = $h1;
					} else {
						$warningH1[] = $h1;
					}
				}
				if ( count( $successH1 ) > 0 ) {
					$success[ $key ] = '<li><i class="fa fa-check-circle"></i>' . $keyTitle;
					$success[ $key ] .= 'Heading tags are ok.<br>';
					$success[ $key ] .= implode( '<br>', $successH1 );
					$success[ $key ] .= '<li>';
				}
				if ( count( $warningH1 ) > 0 ) {
					$mediumPriority  .= '<li>Heading tags should be between 15 and 65 characters.</li>';
					$warning[ $key ] = '<li><i class="fa fa-warning"></i>' . $keyTitle;
					$warning[ $key ] .= 'Heading tags should be between 15 and 65 characters.<br>';
					$warning[ $key ] .= implode( '<br>', $warningH1 );
					$warning[ $key ] .= '<li>';
				}
			} else {
				$highPriority    .= '<li>Your page doesn\'t have H1 tags.</li>';
				$warning[ $key ] = '<li><i class="fa fa-warning"></i>' . $keyTitle;
				$warning[ $key ] .= ' Your page doesn\'t have H1 tags.';
				$warning[ $key ] .= '<li>';
			}

			$key      = "h2";
			$keyTitle = "H2 headings:";
			if ( ! empty( $htmlInfo["h2"] ) ) {
				$successH2 = [];
				$warningH2 = [];
				foreach ( $htmlInfo["h2"] as $h2 ) {
					$h2Len = strlen( $h2 );
					if ( $h2Len >= 15 && $h2Len <= 65 ) {
						$successH2[] = $h2;
					} else {
						$warningH2[] = $h2;
					}
				}
				if ( count( $successH2 ) > 0 ) {
					$success[ $key ] = '<li><i class="fa fa-check-circle"></i>' . $keyTitle;
					$success[ $key ] .= 'Heading tags are ok.<br>';
					$success[ $key ] .= implode( '<br>', $successH2 );
					$success[ $key ] .= '<li>';
				}
				if ( count( $warningH2 ) > 0 ) {
					$mediumPriority  .= '<li>Heading H2 tags should be between 15 and 65 characters.</li>';
					$warning[ $key ] = '<li><i class="fa fa-warning"></i>' . $keyTitle;
					$warning[ $key ] .= 'Heading tags should be between 15 and 65 characters.<br>';
					$warning[ $key ] .= implode( '<br>', $warningH2 );
					$warning[ $key ] .= '<li>';
				}
			} else {
				$highPriority    .= '<li>Your page doesn\'t have H2 tags.</li>';
				$warning[ $key ] = '<li><i class="fa fa-warning"></i>' . $keyTitle;
				$warning[ $key ] .= ' Your page doesn\'t have H2 tags.';
				$warning[ $key ] .= '<li>';
			}

			$key      = "h3";
			$keyTitle = "H3 headings:";
			if ( ! empty( $htmlInfo["h3"] ) ) {
				$successH3 = [];
				$warningH3 = [];
				foreach ( $htmlInfo["h3"] as $h3 ) {
					$h3Len = strlen( $h3 );
					if ( $h3Len >= 15 && $h3Len <= 65 ) {
						$successH3[] = $h3;
					} else {
						$warningH3[] = $h3;
					}
				}
				if ( count( $successH3 ) > 0 ) {
					$success[ $key ] = '<li><i class="fa fa-check-circle"></i>' . $keyTitle;
					$success[ $key ] .= 'Heading tags are ok.<br>';
					$success[ $key ] .= implode( '<br>', $successH3 );
					$success[ $key ] .= '<li>';
				}
				if ( count( $warningH3 ) > 0 ) {
					$mediumPriority  .= '<li>Heading H3 tags should be between 15 and 65 characters.</li>';
					$warning[ $key ] = '<li><i class="fa fa-warning"></i>' . $keyTitle;
					$warning[ $key ] .= 'Heading tags should be between 15 and 65 characters.<br>';
					$warning[ $key ] .= implode( '<br>', $warningH3 );
					$warning[ $key ] .= '<li>';
				}
			} else {
				$highPriority    .= '<li>Your page doesn\'t have H3 tags.</li>';
				$warning[ $key ] = '<li><i class="fa fa-warning"></i>' . $keyTitle;
				$warning[ $key ] .= ' Your page doesn\'t have H3 tags.';
				$warning[ $key ] .= '<li>';
			}

			$key      = "h4";
			$keyTitle = "H4 headings:";
			if ( ! empty( $htmlInfo["h4"] ) ) {
				$successH4 = [];
				$warningH4 = [];
				foreach ( $htmlInfo["h4"] as $h4 ) {
					$h4Len = strlen( $h4 );
					if ( $h4Len >= 15 && $h4Len <= 65 ) {
						$successH4[] = $h4;
					} else {
						$warningH4[] = $h4;
					}
				}
				if ( count( $successH4 ) > 0 ) {
					$success[ $key ] = '<li><i class="fa fa-check-circle"></i>' . $keyTitle;
					$success[ $key ] .= ' Heading tags are ok.<br>';
					$success[ $key ] .= implode( '<br>', $successH4 );
					$success[ $key ] .= '<li>';
				}
				if ( count( $warningH4 ) > 0 ) {
					$mediumPriority  .= '<li>Heading H4 tags should be between 15 and 65 characters.</li>';
					$warning[ $key ] = '<li><i class="fa fa-warning"></i>' . $keyTitle;
					$warning[ $key ] .= ' Heading tags should be between 15 and 65 characters.<br>';
					$warning[ $key ] .= implode( '<br>', $warningH4 );
					$warning[ $key ] .= '<li>';
				}
			}


			$key      = "robots";
			$keyTitle = "Robots.txt Test: ";
			if ( $htmlInfo[ $key ] == 200 ) {
				$success[ $key ] = '<li><i class="fa fa-check-circle"></i>' . $keyTitle;
				$success[ $key ] .= '<span>Your site uses a "robots.txt" file: <span style="color:blue">' . $htmlInfo["url"] . '/robots.txt</span></span>';
				$success[ $key ] .= '<li>';
			} else {
				$lowPriority     .= '<li>Your page doesn\'t have "robots.txt" file.</li>';
				$warning[ $key ] = '<li><i class="fa fa-warning"></i>' . $keyTitle;
				$warning[ $key ] .= ' Your page doesn\'t have "robots.txt" file';
				$warning[ $key ] .= '<li>';
			}


			$key      = "sitemap";
			$keyTitle = "Sitemap Test: ";
			if ( $htmlInfo[ $key ] ) {
				$success[ $key ] = '<li><i class="fa fa-check-circle"></i>' . $keyTitle;
				$success[ $key ] .= '<span>We\'ve found sitemap file for your website: <span style="color:blue">' . $htmlInfo["url"] . '/sitemap.xml</span></span>';
				$success[ $key ] .= '<li>';
			} else {
				$mediumPriority  .= '<li>Doesn\'t have a "sitemap.xml" file.</li>';
				$warning[ $key ] = '<li><i class="fa fa-warning"></i>' . $keyTitle;
				$warning[ $key ] .= ' Your page doesn\'t have "sitemap.xml" file.';
				$warning[ $key ] .= '<li>';
			}


			$key      = "brokenLinkCount";
			$keyTitle = "Broken Links Test";
			if ( ! empty( $htmlInfo["brokenLinkCount"] ) && $htmlInfo["brokenLinkCount"] != 0 ) {
				$warning[ $key ] = '<li><i class="fa fa-warning"></i>' . $keyTitle;
				$warning[ $key ] .= 'Your page has some broken links, count : ' . $htmlInfo["brokenLinkCount"];
				$warning[ $key ] .= '<li>';
			} else {
				$success[ $key ] = '<li><i class="fa fa-check-circle"></i>' . $keyTitle;
				$success[ $key ] .= ': <span>Congratulations! Your page doesn\'t have any broken links.</span>';
				$success[ $key ] .= '<li>';
			}


			$key      = "images";
			$keyTitle = "Image Alt Test";
			if ( ! empty( $htmlInfo["images"] ) ) {
				if ( isset( $htmlInfo["images"]["totImgs"] ) && $htmlInfo["images"]["totImgs"] != 0 ) {
					if ( $htmlInfo["images"]["diff"] <= 0 ) {
						$success[ $key ] = '<li><i class="fa fa-warning"></i>' . $keyTitle;
						$success[ $key ] .= ':<span>' . $htmlInfo["images"]["totImgs"] . ' images found in your page, and all have "ALT" text. </span>';
						$success[ $key ] .= '<li>';
					} else {
						$mediumPriority  .= '<li>Image must have alt text that are missing.</li>';
						$warning[ $key ] = '<li><i class="fa fa-warning"></i>' . $keyTitle;
						$warning[ $key ] .= ': ' . $htmlInfo["images"]["totImgs"] . ' images found in your page and ' . $htmlInfo["images"]["diff"] . ' images are without "ALT" text.';
						$warning[ $key ] .= '<li>';
					}
				}
			}

			$key      = "googleAnalytics";
			$keyTitle = "Google Analytics";
			if ( $htmlInfo["googleAnalytics"] == true ) {
				$success[ $key ] = '<li><i class="fa fa-check-circle"></i>' . $keyTitle;
				$success[ $key ] .= '<span>Your page is already submitted to Google Analytics.</span>';
				$success[ $key ] .= '<li>';
			} else {
				$warning[ $key ] = '<li><i class="fa fa-warning"></i>' . $keyTitle;
				$warning[ $key ] .= ': Your page not submitted to Google Analytics';
				$warning[ $key ] .= '<li>';
			}


			$key      = "shortcut";
			$keyTitle = "shortcut";
			if ( isset( $htmlInfo["shortcut icon"] ) || isset( $htmlInfo["icon"] ) ) {
				$iconKey = isset($htmlInfo["shortcut icon"]) ? "shortcut icon" : "icon";
				$success[ $key ] = '<li><i class="fa fa-check-circle"></i> Favicon: ';
				$success[ $key ] .= '<span><img width="24" height="24" src="' . $htmlInfo[$iconKey] . '" alt="' . $htmlInfo["url"] . ' favicon"> Your website appears to have a favicon.</span>';
				$success[ $key ] .= '<li>';
			} else {
				$warning[ $key ] = '<li><i class="fa fa-warning"></i>' . $keyTitle;
				$warning[ $key ] .= ' Your site doesn\'t have favicon.';
				$warning[ $key ] .= '<li>';
			}
		} else {
			$data["isAlive"] = false;
			$highPriority    = 'Your site must be live!';
		}

		/* }
		else {

			$html .= '<tr>';
			$html .= '<td style="width: 30%;">';
			$html .= '<div style="width: 100%;"><span style="font-size:11px;">Site Status</span></div>';
			$html .= '</td>';
			$html .= '<td style="width: 70%;">';
			$html .= '<div style="width: 100%;">No DNS Found</div>';
			$html .= '</td>';
			$html .= '</tr>';
		} */

		$data["highPriority"]      = $highPriority;
		$data["mediumPriority"]    = $mediumPriority;
		$data["lowPriority"]       = $lowPriority;
		$data["mostCommonKeyword"] = $mostCommonKeyword;
		$data["keywordUsage"]      = $keywordUsage;
		$data["errors"]            = $errors;
		$data["errors"]            = $errors;
		$data["warning"]           = $warning;
		$data["success"]           = $success;

		return $data;
	}
}