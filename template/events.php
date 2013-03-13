<?php
	$today = date("l");
?>
			<ul class='last events'>
				<li>EVENTS</li>
				<li<?php if ($today == 'Friday') {echo ' id="today"';} ?>><a href='events.php#Friday' class='modal'>FRIDAY</a></li>
				<li<?php if ($today == 'Saturday') {echo ' id="today"';} ?>><a href='events.php#Saturday' class='modal'>SATURDAY</a></li>
				<li <?php if ($today == 'Sunday') {echo ' id="today"';} ?>><a href='events.php#Sunday' class='modal'>SUNDAY</a></li>
				<li <?php if ($today == 'Monday') {echo ' id="today"';} ?>><a href='events.php#Monday' class='modal'>MONDAY</a></li>
				<li <?php if ($today == 'Tuesday') {echo ' id="today"';} ?>><a href='events.php#Tuesday' class='modal'>TUESDAY</a></li>
				<li <?php if ($today == 'Wednesday') {echo ' id="today"';} ?>><a href='events.php#Wednesday' class='modal'>WEDNESDAY</a></li>
				<li <?php if ($today == 'Thursday') {echo ' id="today"';} ?>><a href='events.php#Thursday' class='modal'>THURSDAY</a></li>
			</ul>