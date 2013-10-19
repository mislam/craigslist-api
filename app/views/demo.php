<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Craigslist REST API</title>
	<link rel="stylesheet" href="/css/reset.css" />
	<link rel="stylesheet" href="/css/main.css" />
</head>

<body>
	<div class="wrapper">
		<h1>Craigslist REST API</h1>
		<p>The purpose of this API is to query data from <a href="http://www.craigslist.org/" target="_blank">Craigslist</a> so that developers can use them in their app. The API itself is written with <a href="http://laravel.com/" target="_blank">Laravel</a> PHP framework.</p>

		<h2>Usage</h2>
		<p>Send a <em>GET</em> request to the resource as specified in the following format:</p>
		<table>
			<thead>
				<tr>
					<th>Resource</th>
					<th>Description</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<code class="method">GET</code>
						<code class="uri">/api/{city}/{category}/{page}</code>
					</td>
					<td>Get listing within a city by a specific category</td>
				</tr>
			</tbody>
		</table>

		<!-- End of Usage -->

		<h2>Example</h2>
		<p>Let's get the first <em>100</em> job listing in <em>New York City</em> under <em>Web Design</em> category:</p>
		<table>
			<thead>
				<tr>
					<th>Request</th>
					<th>JSON Output (partial)</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<code class="method">GET</code>
						<code class="uri">/api/newyork/web/1</code>
					</td>
					<td>
						<pre>
<em>[</em>
  <em>{</em>
    <em>&quot;</em><b>date</b><em>&quot;</em>: <em>&quot;</em>Friday, October 18, 2013<em>&quot;</em>,
    <em>&quot;</em><b>results</b><em>&quot;</em>: <em>[</em>
      <em>{</em>
        <em>&quot;</em><b>url</b><em>&quot;</em>: <em>&quot;</em>http:\/\/newyork.craigslist.org\/mnh\/web\/4137716940.html<em>&quot;</em>,
        <em>&quot;</em><b>title</b><em>&quot;</em>: <em>&quot;</em>Interactive Web Content Specialist<em>&quot;</em>,
        <em>&quot;</em><b>location</b><em>&quot;</em>: <em>&quot;</em>Midtown West<em>&quot;</em>
      <em>}</em>,
      <em>{</em>
        <em>&quot;</em><b>url</b><em>&quot;</em>: <em>&quot;</em>http:\/\/newyork.craigslist.org\/mnh\/web\/4137682225.html<em>&quot;</em>,
        <em>&quot;</em><b>title</b><em>&quot;</em>: <em>&quot;</em>Freelance Web Project!<em>&quot;</em>,
        <em>&quot;</em><b>location</b><em>&quot;</em>: <em>&quot;</em>SoHo<em>&quot;</em>
      <em>}</em>,
      ...
      ...
  <em>}</em>
<em>]</em></pre>
					</td>
				</tr>
			</tbody>
		</table>

		<!-- End of Example -->

		<h2>Application Example</h2>
		<p>Now let's create a simple app widget with this API. Let's call it <em>Job Ticker</em>. It will send the same HTTP GET request to <em><code>/api/newyork/web/1</code></em> and use the response JSON to display the job listing of today&#39;s date.</p>

		<iframe class="widget" src="/widget"></iframe>

		<!-- End of Application Example -->
	</div>

	<footer class="clearfix">
		<section class="copyright">Copyright &copy; Mohammad Islam.</section>
		<section class="links">
			<ul class="clearfix">
				<li><a target="_blank" href="https://github.com/reefat">GitHub</a></li>
				<li><a target="_blank" href="http://www.linkedin.com/in/reefat/">LinkedIn</a></li>
				<li><a target="_blank" href="http://codecake.com/">Portfolio</a></li>
				<li><a target="_blank" href="http://codecake.com/blog">Blog</a></li>
			</ul>
		</section>
	</footer>

	<a href="https://github.com/reefat/craigslist-api"><img style="position: absolute; top: 0; right: 0; border: 0;" src="https://s3.amazonaws.com/github/ribbons/forkme_right_red_aa0000.png" alt="Fork me on GitHub"></a>
</body>
</html>
