<?php
class CraigslistController extends BaseController {

	const SOCKET_TIMEOUT = 10;
	const USER_AGENT = "Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10 GTB5 (.NET CLR 3.5.30729)";
	
	/**
	 * Get search results from Craigslist
	 * @param  [string]   $city       Which city to search in (e.g. 'newyork')
	 * @param  [string]   $category   Which category to search in (e.g. 'web')
	 * @param  int        $totalPages How many pages to crawl
	 * @return [response]             JSON result
	 */
	public function getSearchResults($city, $category, $totalPages) {
		$contents = null;

		$url = $url_main = "http://{$city}.craigslist.org/{$category}/";
		$searchResults = array();

		$pageIteration = 0;
		$thisYear = date("Y");
		$thisMonth = date("n");
		
		$months = array('Jan'=>1, 'Feb'=>2, 'Mar'=>3, 'Apr'=>4, 'May'=>5, 'Jun'=>6, 'Jul'=>7, 'Aug'=>8, 'Sep'=>9, 'Oct'=>10, 'Nov'=>11, 'Dec'=>12);
		
		while ($pageIteration < $totalPages) {

			$pageIteration++;
			$prevSearchResults = $searchResults;
			$searchResults = array();
			$results = array();

			$contents = $this->ReadPage($url);
			$pattern = "/<\/h4>([\s\S]*)<h4/U";
			preg_match_all($pattern, $contents, $matches, PREG_SET_ORDER);

			foreach ($matches as $key => $val) {
				$tmp = $val[1];
				$results[$key] = $tmp;
			}

			$pattern = "/<h4(.*)<\/h4>/U";
			preg_match_all($pattern, $contents, $matches, PREG_SET_ORDER);

			foreach ($matches as $key => $val) {
				$tmp = $val[1];
				
				$tmp2 = explode(" ", $tmp);					
				if ($months[$tmp2[2]] > $thisMonth) {
					$thisYear--;
				}
				$thisMonth = $months[$tmp2[2]];
				
				$date_day = (int) $tmp2[3];
				$date_month = (int) $thisMonth;
				$date_year = (int) $thisYear;

				$searchResults[$key]['date'] = date("l, F d, Y", mktime(0,0,0,$date_month,$date_day,$date_year));
			}

			$pattern = "/".str_replace("/", "\\/", $matches[count($matches)-1][0])."([\s\S]*)<p class=\"nextpage\">/U";
			preg_match_all($pattern, $contents, $matches, PREG_SET_ORDER);
			$results[] = $matches[0][1];

			foreach ($results as $key => $val) {
				$pattern = '|</span>  <a href="(.+)">(.+)</a> </span> <span class="l2">   <span class="pnr"> <small> \((.*)\)</small>|U';
				preg_match_all($pattern, $val, $matches2, PREG_SET_ORDER);
				$result2 = array();
				foreach ($matches2 as $key2 => $val2) {
					unset($matches2[$key2][0]);
					if (count($val2) > 4) {
						unset($matches2[$key2][3]);
					}
					$result2[$key2] = array_values($matches2[$key2]);

					// Replace numeric keys with descriptive keys
					$result2[$key2]['url'] = "http://{$city}.craigslist.org" . $result2[$key2][0];
					$result2[$key2]['title'] = $result2[$key2][1];
					$result2[$key2]['location'] = $result2[$key2][2];
					unset($result2[$key2][0]);
					unset($result2[$key2][1]);
					unset($result2[$key2][2]);
				}
				$searchResults[$key]['results'] = $result2;
			}

			if (!empty($prevSearchResults)) {
				if ($prevSearchResults[count($prevSearchResults)-1]['date'] == $searchResults[0]['date']) {
					$prevSearchResults[count($prevSearchResults)-1]['results'] = array_merge($prevSearchResults[count($prevSearchResults)-1]['results'], $searchResults[0]['results']);
					unset($searchResults[0]);
					$searchResults = array_values($searchResults);
				}
				$searchResults = array_merge($prevSearchResults, $searchResults);
			}
				
			// for next pages
			$pattern = '|<a href="(index(\d)+.html)">(next 100 postings)</a>|U';
			preg_match_all($pattern, $contents, $matches, PREG_SET_ORDER);
			if ($matches[0][3] == "next 100 postings") {
				$url = $url_main . $matches[0][1];
			} else {
				break;
			}
		}

		//clean up the array
		$tmp = $searchResults;
		foreach ($tmp as $key => $val) {
			if (empty($val['results'])) {
				unset($searchResults[$key]);
			}
		}

		return Response::json($searchResults);
	}

	// read webpage specified in $url and returns contents of that page as pointer to $contents
	private function ReadPage($url) {
		$pattern = "|http://(.*)/|U";
		preg_match_all($pattern, $url, $matches1, PREG_SET_ORDER);
		$host = $matches1[0][1];

		$pattern = "|http://.*/(.*)$|U";
		preg_match_all($pattern, $url, $matches2, PREG_SET_ORDER);
		$uri = "/" . $matches2[0][1];		
		
		$contents = '';
		
		$header  = "GET " . $uri . " HTTP/1.1\r\n";
		$header .= "Host: " . $host . "\r\n";
		$header .= "User-Agent: " . self::USER_AGENT . "\r\n";
		$header .= "Connection: Close\r\n\r\n";

		$fp = @fsockopen($host, 80, $errNo, $errorMsg, self::SOCKET_TIMEOUT);
		
		// if failed to open socket, return false;
		if (!$fp) {
			throw new Exception($errorMsg, 1);
		} else {
			fputs($fp, $header);
			while (($buffer = fgets($fp, 4096)) != null) {
				$contents .= $buffer;
			}
			fclose($fp);
			return $contents;
		}
	}

}
?>