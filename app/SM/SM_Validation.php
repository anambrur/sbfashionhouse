<?php
/**
 * Created by PhpStorm.
 * User: mrksohag
 * Date: 2/8/18
 * Time: 11:11 AM
 */

namespace App\SM;


trait SM_Validation {
	private static $domainExtension = array(
		".aero",
		".biz",
		".cat",
		".com",
		".coop",
		".edu",
		".gov",
		".info",
		".int",
		".jobs",
		".mil",
		".mobi",
		".museum",
		".name",
		".net",
		".org",
		".travel",
		".co",
		".club",
		".design",
		".shop",
		".site",
		".online",
		".me",
		".adult",
		'.art',
		'.asia',
		'.computer',
		'.technology',
		'.tech',
		".ac",
		".ad",
		".ae",
		".af",
		".ag",
		".ai",
		".al",
		".am",
		".an",
		".ao",
		".aq",
		".ar",
		".as",
		".at",
		".au",
		".aw",
		".az",
		".ba",
		".bb",
		".bd",
		".be",
		".bf",
		".bg",
		".bh",
		".bi",
		".bj",
		".bm",
		".bn",
		".bo",
		".br",
		".bs",
		".bt",
		".bv",
		".bw",
		".by",
		".bz",
		".ca",
		".cc",
		".cd",
		".cf",
		".cg",
		".ch",
		".ci",
		".ck",
		".cl",
		".cm",
		".cn",
		".co",
		".cr",
		".cs",
		".cu",
		".cv",
		".cx",
		".cy",
		".cz",
		".de",
		".dj",
		".dk",
		".dm",
		".do",
		".dz",
		".ec",
		".ee",
		".eg",
		".eh",
		".er",
		".es",
		".et",
		".eu",
		".fi",
		".fj",
		".fk",
		".fm",
		".fo",
		".fr",
		".ga",
		".gb",
		".gd",
		".ge",
		".gf",
		".gg",
		".gh",
		".gi",
		".gl",
		".gm",
		".gn",
		".gp",
		".gq",
		".gr",
		".gs",
		".gt",
		".gu",
		".gw",
		".gy",
		".hk",
		".hm",
		".hn",
		".hr",
		".ht",
		".hu",
		".id",
		".ie",
		".il",
		".im",
		".in",
		".io",
		".iq",
		".ir",
		".is",
		".it",
		".je",
		".jm",
		".jo",
		".jp",
		".ke",
		".kg",
		".kh",
		".ki",
		".km",
		".kn",
		".kp",
		".kr",
		".kw",
		".ky",
		".kz",
		".la",
		".lb",
		".lc",
		".li",
		".lk",
		".lr",
		".ls",
		".lt",
		".lu",
		".lv",
		".ly",
		".ma",
		".mc",
		".md",
		".mg",
		".mh",
		".mk",
		".ml",
		".mm",
		".mn",
		".mo",
		".mp",
		".mq",
		".mr",
		".ms",
		".mt",
		".mu",
		".mv",
		".mw",
		".mx",
		".my",
		".mz",
		".na",
		".nc",
		".ne",
		".nf",
		".ng",
		".ni",
		".nl",
		".no",
		".np",
		".nr",
		".nu",
		".nz",
		".om",
		".pa",
		".pe",
		".pf",
		".pg",
		".ph",
		".pk",
		".pl",
		".pm",
		".pn",
		".pr",
		".ps",
		".pt",
		".pw",
		".py",
		".qa",
		".re",
		".ro",
		".ru",
		".rw",
		".sa",
		".sb",
		".sc",
		".sd",
		".se",
		".sg",
		".sh",
		".si",
		".sj",
		".sk",
		".sl",
		".sm",
		".sn",
		".so",
		".sr",
		".st",
		".su",
		".sv",
		".sy",
		".sz",
		".tc",
		".td",
		".tf",
		".tg",
		".th",
		".tj",
		".tk",
		".tm",
		".tn",
		".to",
		".tp",
		".tr",
		".tt",
		".tv",
		".tw",
		".tz",
		".ua",
		".ug",
		".uk",
		".um",
		".us",
		".uy",
		".uz",
		".va",
		".vc",
		".ve",
		".vg",
		".vi",
		".vn",
		".vu",
		".wf",
		".ws",
		".ye",
		".yt",
		".yu",
		".za",
		".zm",
		".zr",
		".zw"
	);

	public static function emailValidate( $email ) {
		$smError = '';
		if ( filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
			$emailArray = explode( '@', $email );
			if ( strlen( $emailArray[0] ) < 21 ) {
				$domain       = explode( '.', $emailArray[1] );
				$domainLength = count( $domain );
				if ( $domainLength > 3 ) {
					$smError .= 'Email Domain not Valid!<br>';
				} else {
					if ( strlen( $domain[0] ) < 21 ) {
						if ( $domainLength > 2 ) {
							if ( strlen( $domain[1] ) < 11 && strlen( $domain[2] ) < 3 ) {
								if ( ! (
									strtolower( in_array( '.' . $domain[1], self::$domainExtension ) ) &&
									strtolower( in_array( '.' . $domain[2], self::$domainExtension ) )
								) ) {
									$smError .= 'We don\'t take this email domain extension!<br>';
								}
							} else {
								$smError .= 'We don\'t take this email domain extension!<br>';
							}
						} else {
							if ( ! in_array( strtolower( '.' . $domain[1] ), self::$domainExtension ) ) {
								$smError .= 'We don\'t take this domain extension!<br>';
							}
						}
					} else {
						$smError .= 'Email domain name length must be less then 20 characters!<br>';
					}
				}
			} else {
				$smError .= 'Username length must be less then 20 characters!<br>';
			}
		} else {
			$smError .= 'Invalid Email!<br>';
		}

		return $smError;
	}

	public static function urlValidate( $url ) {
		$urlP    = explode( '/', $url );
		$smError = '';
		if ( count( $urlP ) > 2 && ( $urlP[0] == 'http:' || $urlP[0] == 'https:' ) ) {
			$domain = explode( '.', $urlP[2] );

			if ( $domain && ( ( $domain[0] == 'www' && strlen( $domain[0] ) < 4 ) || ( $domain[0] != 'www' && strlen( $domain[0] ) < 21 ) ) ) {
				if ( $domain[0] == 'www' ) {
					$domain = array_slice( $domain, 1 );
				}
				$domainLength = count( $domain );
				if ( $domainLength > 3 ) {
					$smError .= 'URL Domain not Valid!<br>';
				} else {
					if ( strlen( $domain[1] ) < 21 ) {
						if ( $domainLength > 2 ) {
							if ( strlen( $domain[1] ) < 11 && strlen( $domain[2] ) < 3 ) {
								if ( ! (
									strtolower( in_array( '.' . $domain[1], self::$domainExtension ) ) &&
									strtolower( in_array( '.' . $domain[2], self::$domainExtension ) )
								) ) {
									$smError .= 'We don\'t take this website domain extension!<br>';
								}
							} else {
								$smError .= 'We don\'t take this website domain extension!<br>';
							}
						} else {
							if ( ! in_array( strtolower( '.' . $domain[1] ), self::$domainExtension ) ) {
								$smError .= 'We don\'t take this website domain extension!<br>';
							}
						}
					} else {
						$smError .= 'Website Domain name length must be less then 20 characters!<br>';
					}
				}
			} else {
				$smError .= 'Website Domain name length must be less then 20 characters!<br>';
			}
		} else {
			$smError .= 'Website Domain Protocol not valid!<br>';
		}

		return $smError;
	}
}