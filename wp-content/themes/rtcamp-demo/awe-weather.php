<?php $longday=[
				'Mon'=>'Monday',
				'Tue'=>'Tuesday',
				'Wed'=>'Wednesday',
				'Thu'=>'Thursday',
				'Fri'=>'Friday',
				'Sat'=>'Saturday',
				'Sun'=>'Sunday',
			];?>
<div id="<?php awe_widget_id( $weather ); ?>" class="wan-weather-1 <?php echo $background_classes ?>" <?php echo $inline_style; ?>>
<?php if($weather->background_image) { ?>
	<div class="awesome-weather-cover" style="background-image: url(<?php echo $weather->background_image; ?>);">
	<div class="awesome-weather-darken">
<?php } ?>

	<?php awe_change_weather_form( $weather ); ?>

	<?php if($weather->forecast_days != "hide") { ?>
	
		<div class="awesome-weather-forecast awe_days_<?php echo count($weather_forecast); ?> awecf">
			<?php foreach( $weather_forecast as $forecast ) { ?>
				<div class="awesome-weather-forecast-day">
					<div class="awesome-weather-forecast-day-abbr"><?php echo $longday[$forecast->day_of_week]; ?></div>
					<?php if($weather->show_icons) { ?><i class="<?php echo $forecast->icon; ?>"></i><?php } ?>
					<div class="awesome-weather-forecast-day-desc"><?php echo $forecast->description; ?></div>
					<div class="awesome-weather-forecast-day-temp"><?php echo $forecast->high; ?><sup>&deg;</sup> / <?php echo $forecast->low; ?><sup>&deg;</sup></div>
				</div>
			<?php } ?>
	
		</div><!-- /.awesome-weather-forecast -->
	
	<?php } ?>
	
	<?php awe_extended_link( $weather ); ?>
	
	<?php awe_attribution( $weather ); ?>

<?php if($weather->background_image) { ?>
	</div><!-- /.awesome-weather-cover -->
	</div><!-- /.awesome-weather-darken -->
<?php } ?>

</div><!-- /.awesome-weather-wrap: tall -->
