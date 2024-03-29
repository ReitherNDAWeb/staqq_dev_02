<?php
/**
 * Class that handles the output for the DuoScorecard template.
 *
 * Class ExactMetrics_SiteInsights_Template_DuoScorecard
 */
abstract class ExactMetrics_SiteInsights_Template_DuoScorecard extends ExactMetrics_SiteInsights_Metric_Template {

	/**
	 * Returns the HTML of a card based of the given args.
	 *
	 * @param string $side Could be `left` or `right`.
	 * @param $value int The value to display.
	 * @param $label string The label to display.
	 * @param $compare_value int A comparable value.
	 * @param $compare_label string What are we comparing to.
	 *
	 * @return string
	 */
	protected function get_card_template( $side, $label, $value, $compare_value, $compare_label, $withComparison ) {
		$compare_class_name = '';

		if ( $compare_value > 0 ) {
			$compare_class_name = 'is-positive-percentage';
		}

		$comparison = '';

		if ( $withComparison ) {
			$comparison = sprintf(
				'<div class="exactmetrics-duo-scorecard-compare">
					<div class="exactmetrics-duo-scorecard-compare-percentage %1$s">%2$s&#37;</div>
					<div class="exactmetrics-duo-scorecard-compare-label">%3$s</div>
				</div>',
				$compare_class_name,
				$compare_value,
				$compare_label
			);
		}

		$format = '<div class="exactmetrics-duo-scorecard-half exactmetrics-duo-scorecard-%1$s">
			<div class="exactmetrics-duo-scorecard-content">
				<div class="exactmetrics-duo-scorecard-title">%2$s</div>
				<div class="exactmetrics-duo-scorecard-value">%3$s</div>
			</div>
			%4$s
		</div>';

		return sprintf(
			$format,
			$side,
			$label,
			$value,
			$comparison
		);
	}
}