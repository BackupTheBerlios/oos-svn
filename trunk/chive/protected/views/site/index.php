<h2>Welcome, <?php echo Yii::app()->user->name; ?>!</h2>


<table class="list" style="float: left; width: 49%;">
	<colgroup>
		<col style="width: 200px;"></col>
		<col></col>
	</colgroup>
	<thead>
		<tr>
			<th colspan="2">Server information</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>Host</td>
			<td><?php echo Yii::app()->user->host; ?></td>
		</tr>
		<tr>
			<td>MySQL server version</td>
			<td><?php echo Yii::app()->db->getServerVersion(); ?></td>
		</tr>
		<tr>
			<td>MySQL client version</td>
			<td><?php echo Yii::app()->db->getClientVersion(); ?></td>
		</tr>
		<tr>
			<td>User</td>
			<td><?php echo Yii::app()->user->name; ?>@<?php echo Yii::app()->user->host; ?></td>
		</tr>
		<tr>
			<td>Webserver</td>
			<td><?php echo $_SERVER['SERVER_SOFTWARE']; ?></td>
		</tr>
	</tbody>
</table>

<?php if(ConfigUtil::getUrlFopen() && count($entries) > 0) { ?>
	<table class="list" style="float: left; width: 50%; margin-left: 10px;">
		<colgroup>
			<col style="width: 200px;"></col>
			<col></col>
			<col style="width: 20px;"></col>
		</colgroup>
		<thead>
			<tr>
				<th colspan="3">
					<span class="icon">
						<?php echo CHtml::link(Html::icon('rss'), 'http://feeds.launchpad.net/chive/announcements.atom'); ?>
						<span>Project news</span>
					</span>
				</th>
			</tr>
		</thead>
		<tbody>
			<?php $i = 1; ?>
			<?php foreach($entries AS $entry) { // Limit entries ?>
				<?php if ($i > 5) break;?>
				<tr class="noSwitch">
					<td><?php echo (string)$formatter->formatDateTime(strtotime($entry->published)); ?></td>
					<td><?php echo (string)$entry->title; ?></td>
					<td>
						<a href="javascript:void(0);" onclick="$(this).parent().parent().next().toggle();">
							<?php echo Html::icon('search', 16, false, 'core.showDetails'); ?>
						</a>
					</td>
				</tr>
				<tr style="display: none;">
					<td colspan="3">
						<?php echo $entry->content; ?>
					</td>
				</tr>
				<?php $i++; ?>
			<?php } ?>
		</tbody>
	</table>
<?php } ?>