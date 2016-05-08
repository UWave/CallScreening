<?php
/*
	GNU Public License
	Version: GPL 3
*/
require_once "root.php";
require_once "resources/require.php";
require_once "resources/check_auth.php";
require_once "resources/header.php";
require_once "resources/paging.php";

?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td>
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td>
						<b>Call Screening</b>
					</td>
					<td width="30%" align="right" valign="top">
						<input type="text" class="originate_number" /><button onclick="javascript: void(0)">Call</button>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td class="current_status"></td>
	</tr>
	<tr>
		<td>
			<table class="tr_hover" width="100%" border="0" cellpadding="0" cellspacing="0" class="parkedlist">
				<thead>
					<tr>
						<th>Caller Number</th>
						<th>Caller Name</th>
						<th>Call Description</th>
						<th>Actions</th>
					</tr>
				</thead>
			</table>
		</td>
	</tr>
</table>
<script type="text/javascript" src="status.js">
</script>
<?php
require_once "footer.php";
